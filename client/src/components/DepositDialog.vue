<template>
  <v-dialog v-model="dialog" @open="onOpen">
    <template #activator="{ props: activatorProps }">
      <v-btn
        prepend-icon="mdi-plus"
        text="Deposit"
        variant="tonal"
        color="success"
        v-bind="activatorProps"
      ></v-btn>
    </template>
    <v-card prepend-icon="mdi-plus" title="Deposit Funds">
      <v-card-text>
        <v-card variant="outlined" rounded="xl">
          <v-card-text> <DepositForm /></v-card-text>
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

import DepositForm from "./DepositForm.vue";

const dialog = shallowRef(false);

const onOpen = async () => {};
</script>
