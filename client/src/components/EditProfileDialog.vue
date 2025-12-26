<template>
  <v-dialog v-model="dialog" @open="onOpen">
    <template #activator="{ props: activatorProps }">
      <v-btn
        prepend-icon="mdi-account-circle"
        text="Account"
        variant="plain"
        block
        v-bind="activatorProps"
      ></v-btn>
    </template>
    <v-card prepend-icon="mdi-account-circle" title="Account">
      <v-card-text>
        <AccountForm />
      </v-card-text>
      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>

        <v-btn text="Cancel" variant="plain" @click="dialog = false"></v-btn>

        <v-btn
          color="success"
          text="Save"
          variant="tonal"
          @click="save"
        ></v-btn>

        <DeleteAccountDialog />

        <PasswordDialog />
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { shallowRef, watch } from "vue";
import { useUserStore } from "@/stores/user";
import { useResponseStore } from "@/stores/response";
import PasswordDialog from "./PasswordDialog.vue";
import DeleteAccountDialog from "./DeleteAccountDialog.vue";
import AccountForm from "./AccountForm.vue";

const dialog = shallowRef(false);

const userStore = useUserStore();
const responseStore = useResponseStore();

// Watch the dialog's state
watch(dialog, (newVal) => {
  if (newVal) {
    onOpen();
  } else {
    onClose();
  }
});

// const emit = defineEmits(["update:modelValue", "close"]);

const onOpen = async () => {
  responseStore.$reset();
};

const onClose = () => {};

// Save user and location data
const save = async () => {
  // Save location first to get the ID

  // Update user with new location ID
  await userStore.updateUser();
};
</script>
