<template>
  <!-- Current Balance -->
  <div class="mb-4">
    <div class="text-caption text-medium-emphasis">Current Balance</div>
    <div class="text-h5 text-success">
      {{ userStore.user.formattedBalance }}
    </div>
  </div>

  <!-- Preset Amounts -->
  <div class="mb-4">
    <div class="text-caption mb-2">Quick Amount</div>

    <v-btn-toggle v-model="preset" divided mandatory>
      <v-btn
        v-for="presetAmount in presetAmounts"
        :key="presetAmount"
        :value="presetAmount"
        @click="setAmount(presetAmount)"
      >
        ${{ presetAmount }}
      </v-btn>
    </v-btn-toggle>
  </div>

  <!-- Custom Amount -->
  <v-text-field
    v-model.number="amount"
    label="Deposit Amount"
    prefix="$"
    type="number"
    :rules="amountRules"
    min="10"
    max="5000"
    clearable
  />

  <!-- Payment Method (stub) -->
  <v-select
    v-model="paymentMethod"
    label="Payment Method"
    :items="paymentMethods"
    prepend-inner-icon="mdi-credit-card"
  />

  <!-- Submit -->
  <v-btn
    block
    color="success"
    size="large"
    class="mt-4"
    :disabled="!isValid"
    @click="deposit"
  >
    Deposit ${{ amount || 0 }}
  </v-btn>

  <!-- Disclaimer -->
  <div class="text-caption text-medium-emphasis mt-3">
    Deposits are instant. Please play responsibly.
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useUserStore } from "@/stores/user";
const userStore = useUserStore();

const amount = ref(null);
const preset = ref(null);

const presetAmounts = [25, 50, 100, 250, 500];

const paymentMethods = ["Credit Card", "Debit Card", "Interac"];

const paymentMethod = ref(paymentMethods[0]);

const amountRules = [
  (v) => !!v || "Amount is required",
  (v) => v >= 10 || "Minimum deposit is $10",
  (v) => v <= 5000 || "Maximum deposit is $5,000",
];

const isValid = computed(
  () =>
    amount.value &&
    amount.value >= 10 &&
    amount.value <= 5000 &&
    paymentMethod.value
);

const setAmount = (value) => {
  amount.value = value;
};

const deposit = async () => {
  const response = await userStore.deposit({
    amount: amount.value,
  });

  if (response?.success) {
    amount.value = null;
    preset.value = null;
  }
};
</script>
