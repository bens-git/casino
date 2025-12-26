<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "@/axios"; // adjust if needed

const router = useRouter();

const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref(null);

const submit = async () => {
  error.value = null;
  loading.value = true;

  try {
    const { data } = await axios.post("/api/login", {
      email: email.value,
      password: password.value,
    });

    // example token handling
    localStorage.setItem("auth_token", data.token);

    router.push("/play");
  } catch (err) {
    error.value = "Invalid credentials. Please try again.";
  } finally {
    loading.value = false;
  }
};

const enterAsGuest = () => {
  router.push("/play");
};
</script>

<template>
  <div class="enter-root">
    <v-card class="enter-card" elevation="12">
      <v-card-text class="text-center">
        <v-icon size="64" color="gold">mdi-cards</v-icon>

        <h1 class="title mt-4">Enter the Casino</h1>
        <p class="subtitle">Sign in to join the current jackpot</p>

        <v-alert v-if="error" type="error" variant="tonal" class="mb-4">
          {{ error }}
        </v-alert>

        <v-form @submit.prevent="submit">
          <v-text-field
            v-model="email"
            label="Email"
            type="email"
            prepend-inner-icon="mdi-email"
            required
          />

          <v-text-field
            v-model="password"
            label="Password"
            type="password"
            prepend-inner-icon="mdi-lock"
            required
          />

          <v-btn
            block
            size="large"
            color="primary"
            class="mt-4"
            :loading="loading"
            type="submit"
          >
            Enter Casino
          </v-btn>
        </v-form>

        <v-divider class="my-6" />

        <v-btn block variant="outlined" color="primary" @click="enterAsGuest">
          Enter as Guest
        </v-btn>
      </v-card-text>
    </v-card>
  </div>
</template>

<style scoped>
.enter-root {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(
    circle at top,
    #1b1b1b 0%,
    #0f0f0f 60%,
    #000 100%
  );
}

.enter-card {
  width: 100%;
  max-width: 420px;
  background: rgba(20, 20, 20, 0.95);
  color: #fff;
  border-radius: 16px;
}

.title {
  font-size: 2rem;
  font-weight: 700;
  letter-spacing: 0.05em;
}

.subtitle {
  opacity: 0.8;
  margin-bottom: 1.5rem;
}
</style>
