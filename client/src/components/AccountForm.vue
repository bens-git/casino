<template>
  <v-container>
    <v-card rounded="xl">
      <v-card-title class="text-h6"> Account </v-card-title>

      <v-divider />

      <v-card-text>
        <!-- Profile -->
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="form.displayName"
              label="Display Name"
              prepend-inner-icon="mdi-account"
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="form.email"
              label="Email"
              disabled
              prepend-inner-icon="mdi-email"
            />
          </v-col>
        </v-row>

        <v-btn color="primary" class="mb-6"> Save Changes </v-btn>

        <v-divider class="my-6" />

        <!-- Wallet -->
        <WalletForm />

        <v-divider class="my-6" />

        <!-- My Bets -->
        <MyBetsForm />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { reactive } from "vue";
import WalletForm from "./WalletForm.vue";
import MyBetsForm from "./MyBetsForm.vue";

const form = reactive({
  displayName: "LuckyAce42",
  email: "player@email.com",
});
</script>
