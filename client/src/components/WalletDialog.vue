<template>
  <v-dialog v-model="dialog" @open="onOpen">
    <template #activator="{ props: activatorProps }">
      <v-btn
        prepend-icon="mdi-wallet"
        text="Wallet"
        variant="plain"
        block
        v-bind="activatorProps"
      ></v-btn>
    </template>
    <v-card prepend-icon="mdi-wallet" title="Wallet">
      <v-card-text>
        <v-card variant="outlined" rounded="lg">
          <v-card-text> <WalletForm /></v-card-text>
        </v-card>
      </v-card-text>
      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn text="Cancel" variant="plain" @click="dialog = false"></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { shallowRef } from "vue";

import WalletForm from "./WalletForm.vue";

const dialog = shallowRef(false);

const onOpen = async () => {};
</script>
