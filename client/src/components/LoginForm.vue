<template>
  <v-container fluid class="fill-height d-flex justify-center align-center">
    <v-card
      v-if="!userStore.user"
      prepend-icon="mdi-login"
      title="Login"
      class="pa-4"
      max-width="1200px"
      width="100%"
      height="80vh"
    >
      <v-card-text>
        <v-icon size="64" color="gold">mdi-cards</v-icon>

        <h1 class="title mt-4">Enter the Casino</h1>
        <p class="subtitle">Sign in to join the current jackpot</p>

        <v-form ref="form">
          <v-text-field
            v-model="email"
            name="email"
            autocomplete="email"
            label="Email"
            :error-messages="responseStore?.response?.errors?.email"
            required
          />

          <v-text-field
            v-model="password"
            name="password"
            autocomplete="current-password"
            label="Password"
            type="password"
            :error-messages="responseStore?.response?.errors?.password"
            required
          />
        </v-form>
      </v-card-text>
      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn text="Cancel" variant="plain" @click="dialog = false"></v-btn>

        <v-btn text="Login" variant="tonal" @click="login"></v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>
<script setup>
import { shallowRef, ref } from "vue";
import { useUserStore } from "@/stores/user";
import { useResponseStore } from "@/stores/response";
import { useRouter } from "vue-router";
const dialog = shallowRef(false);
const router = useRouter();
const responseStore = useResponseStore();

const email = ref("");
const password = ref("");

const userStore = useUserStore();
const emit = defineEmits(["logged_in"]);

const login = async () => {
  responseStore.clearResponse(); // Clear previous responses

  const response = await userStore.login({
    email: email.value,
    password: password.value,
  });
  if (response?.success) {
    emit("logged_in");
    router.push({ name: "enter" }); // Use router to navigate to login page after logout
  }
};
</script>

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
