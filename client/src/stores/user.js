import { defineStore } from "pinia";
import useApi from "@/stores/api";
import axios from "../axios";
import { ref, computed } from "vue";
import { loadStripe } from "@stripe/stripe-js";
import { useLoadingStore } from "@/stores/loading";
import { useResponseStore } from "@/stores/response";

const stripePromise = loadStripe(process.env.VUE_APP_STRIPE_PUBLIC_KEY);

export const useUserStore = defineStore(
  "user",
  () => {
    /**
     * Deposit funds using Stripe
     */
    const deposit = async ({ amount }) => {
      const { sendRequest } = useApi();
      const loadingStore = useLoadingStore();
      const responseStore = useResponseStore();

      loadingStore.startLoading("deposit");

      try {
        // 1️⃣ Ask backend to create PaymentIntent
        const intentRes = await sendRequest("/user/deposit-intent", "POST", {
          amount, // dollars
        });

        const { clientSecret } = intentRes.data;

        // 2️⃣ Confirm payment on frontend
        const stripe = await stripePromise;

        const { paymentIntent, error: stripeError } =
          await stripe.confirmCardPayment(clientSecret);

        if (stripeError) {
          throw new Error(stripeError.message);
        }

        // 3️⃣ Tell backend payment succeeded
        const confirmRes = await sendRequest("/user/deposit-confirm", "POST", {
          payment_intent_id: paymentIntent.id,
        });

        // 4️⃣ Update balance from backend
        user.value.balance = confirmRes.data.balance;
        responseStore.setResponse(true, confirmRes.data || "Success");

        return confirmRes.data;
      } catch (e) {
        const error =
          e.response?.data?.message || e.message || "Deposit failed";
        responseStore.setResponse(false, error);

        throw e;
      } finally {
        loadingStore.stopLoading("deposit");
      }
    };

    const user = ref(null);

    const formattedBalance = computed(() => {
      if (user.value.balance) {
        return `$${user.value.balance?.toFixed(2)}`;
      } else {
        return `$0.00`;
      }
    });

    const register = async (userData) => {
      const { sendRequest } = useApi();
      const data = await sendRequest("register", "POST", userData);

      return data;
    };

    const login = async (params) => {
      const { sendRequest } = useApi();
      const response = await sendRequest("login", "post", params);

      if (response?.success) {
        console.log(response);
        const token = response.token;
        localStorage.setItem("authToken", token);
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        await show();
      }
      return response;
    };

    const logout = async () => {
      const { sendRequest } = useApi();

      const response = await sendRequest("logout", "POST");
      user.value = null;

      localStorage.removeItem("authToken");
      localStorage.removeItem("user");
      delete axios.defaults.headers.common["Authorization"];
      return response;
    };

    const show = async () => {
      const { fetchRequest } = useApi();

      const response = await fetchRequest("user");
      console.log(response);
      user.value = response.data;
    };

    const update = async (user) => {
      const { sendRequest } = useApi();

      const data = await sendRequest(`me`, "PUT", user);

      if (data?.success) {
        this.user = data.data;
      }
    };

    const destroy = async () => {
      const { sendRequest } = useApi();

      const data = await sendRequest("user", "DELETE");

      if (data?.success) {
        this.user = null;
        localStorage.removeItem("authToken");
        localStorage.removeItem("user");
        delete axios.defaults.headers.common["Authorization"];
      }

      return data;
    };

    const patchPassword = async (
      currentPassword,
      newPassword,
      confirmPassword
    ) => {
      const { sendRequest } = useApi();

      // Prepare the data to be sent in the request
      const user = {
        current_password: currentPassword,
        new_password: newPassword,
        new_password_confirmation: confirmPassword,
      };

      await sendRequest("/user/password", "PUT", user);
    };

    const patchPasswordWithToken = async (
      newPassword,
      confirmPassword,
      token
    ) => {
      const user = {
        new_password: newPassword,
        new_password_confirmation: confirmPassword,
        token: token,
      };
      const { sendRequest } = useApi();

      await sendRequest("/user/password-with-token", "PUT", user);
    };

    const requestPasswordReset = async (email) => {
      const { sendRequest } = useApi();

      await sendRequest("request-password-reset", "POST", email);
    };

    return {
      deposit,
      destroy,
      login,
      logout,
      patchPassword,
      patchPasswordWithToken,
      register,
      requestPasswordReset,
      show,
      update,
      user,
      formattedBalance,
    };
  },

  {
    persist: {
      enabled: true,
      strategies: [
        {
          key: "userStore",
          storage: localStorage,
        },
      ],
    },
  }
);
