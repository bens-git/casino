<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetEmail;
use App\Mail\ValidateUserEmail;
use App\Models\Item;
use App\Models\Location;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class Coordinates
{
    public $latitude;
    public $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}

class AuthController extends Controller
{

    public function depositIntent(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:5000'],
        ]);

        $user = $request->user();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Amount in cents
        $amountCents = intval($request->amount * 100);

        $paymentIntent = PaymentIntent::create([
            'amount' => $amountCents,
            'currency' => 'cad',
            'metadata' => [
                'user_id' => $user->id,
                'type' => 'deposit',
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function depositConfirm(Request $request)
    {
        $request->validate([
            'payment_intent_id' => ['required', 'string'],
        ]);

        $user = $request->user();

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

        if ($paymentIntent->status !== 'succeeded') {
            return response()->json([
                'message' => 'Payment not completed'
            ], 400);
        }

        // Use a transaction to ensure atomicity
        DB::transaction(function () use ($user, $paymentIntent) {
            // Convert cents to dollars
            $amount = $paymentIntent->amount / 100;

            // Credit user balance
            $user->balance += $amount;
            $user->save();

            // Log transaction
            $user->transactions()->create([
                'type' => 'deposit',
                'amount' => $amount,
                'status' => 'completed',
                'method' => 'stripe',
                'payment_intent_id' => $paymentIntent->id,
            ]);
        });

        return response()->json([
            'balance' => $user->balance,
        ]);
    }


    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'repeatPassword' => 'required|string|same:password',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',

        ]);


        // Check if the email already exists with an email_verification_token
        $existingUser = User::where('email', $validatedData['email'])
            ->whereNotNull('email_verification_token')
            ->first();

        if ($existingUser) {
            // Update existing user's email_verification_token
            $existingUser->email_verification_token = Str::random(60);
            $existingUser->save();

            // Send new validation email
            Mail::to($existingUser->email)->send(new ValidateUserEmail($existingUser));

            return response()->json(['message' => 'A user with this email is already registered but has not verified their email. A new verification email has been sent.']);
        }

        // Validate that the email is unique for new registrations
        $request->validate([
            'email' => 'unique:users',
        ]);

        // Create a new user
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'email_verification_token' => Str::random(60),
        ]);


        // Send validation email
        Mail::to($user->email)->send(new ValidateUserEmail($user));

        return response()->json(['success' => true, 'message' => 'User registered successfully. Please check your email to validate your account.']);
    }

    public function show()
    {
        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            $user->load('location');
        }
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function requestPasswordReset(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
            ]);

            // Check if the email already exists with a verified email
            $existingUser = User::where('email', $validatedData['email'])
                ->whereNotNull('email_verified_at')
                ->first();

            if (!$existingUser) {
                return response()->json(['message' => 'User not found.', 'error' => 'User not found.'], 500);
            } else {

                //set password reset token
                $existingUser->password_reset_token = Str::random(60);
                $existingUser->save();


                // Send new validation email
                Mail::to($existingUser->email)->send(new PasswordResetEmail($existingUser));

                return response()->json(['message' => 'A password reset email has been sent to ' . $existingUser->email . '.']);
            }
        } catch (\Exception $e) {
            // Handle errors
            return response()->json(['message' => 'Failed to register', 'error' => $e->getMessage()], 500);
        }
    }

    public function validateEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();


        if (!$user) {
            return redirect()->away(config('app.front_end_url') . '/email-verified?error=true');
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();
        Auth::login($user);

        return redirect()->away(config('app.front_end_url') . '/email-verified?success=true');
    }

    public function resetPasswordWithToken(Request $request)
    {
        $user = User::where('password_reset_token', $request->token)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 403);
        }


        // Validate the incoming request
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'], // Ensure the new password is at least 8 characters and matches confirmation
        ]);


        // Update the password
        $user->password = Hash::make($request->input('new_password'));
        $user->password_reset_token = null;
        /** @var \App\Models\User $user */
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false,  'errors' => ['password' => ['Invalid credentials']]], 400);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['success' => true, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        // Revoke the current token that was used for authentication
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the user fields
        $user->name = $validatedData['name'];

        // Save the updated user and location
        /** @var \App\Models\User $user */
        $user->save();
        $user->load('location');

        // Return the updated user data
        return response()->json(['success' => true, 'data' => $user]);
    }

    public function deleteUser()
    {
        $user = Auth::user();

        $response = DB::transaction(function () use ($user) {

            /** @var \App\Models\User $user */
            $user->delete();
        });

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
    /**
     * Update the authenticated user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'], // Ensure the new password is at least 8 characters and matches confirmation
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match our records.'],
            ]);
        }

        // Update the password
        $user->password = Hash::make($request->input('new_password'));
        /** @var \App\Models\User $user */
        $user->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }
}
