<template>
  <v-dialog v-model="dialog" @open="onOpen">
    <template #activator="{ props: activatorProps }">
      <v-btn
        prepend-icon="mdi-history"
        text="My Bets"
        variant="plain"
        block
        v-bind="activatorProps"
      ></v-btn>
    </template>
    <v-card prepend-icon="mdi-history" title="My Bets">
      <v-card-text>
        <MyBetsForm />
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

import MyBetsForm from "./MyBetsForm.vue";

const dialog = shallowRef(false);

const onOpen = async () => {};
</script>
