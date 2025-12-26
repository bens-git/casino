<template>
  <div>
    <div class="d-flex justify-space-between align-center mb-4">
      <div>
        <div class="text-caption text-medium-emphasis">Current Balance</div>
        <div class="text-h5 text-success">
          {{ userStore.formattedBalance }}
        </div>
      </div>

      <DepositDialog />
    </div>

    <v-row>
      <v-col cols="12" md="6">
        <v-btn block variant="outlined" prepend-icon="mdi-bank">
          Withdraw
        </v-btn>
      </v-col>

      <v-col cols="12" md="6">
        <v-btn block variant="outlined" prepend-icon="mdi-receipt-text">
          Transaction History
        </v-btn>
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import {} from "vue";
import { useUserStore } from "@/stores/user";
import DepositDialog from "./DepositDialog.vue";

const userStore = useUserStore();
</script>
