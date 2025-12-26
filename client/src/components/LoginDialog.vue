<template>
  <v-dialog v-model="dialog" @open="onOpen">
    <template #activator="{ props: activatorProps }">
      <v-btn
        :block="props.block"
        color="secondary"
        prepend-icon="mdi-login"
        text="Login"
        variant="tonal"
        v-bind="activatorProps"
      ></v-btn>
    </template>
    <LoginForm @logged_in="dialog = false" />
  </v-dialog>
</template>
<script setup>
import { shallowRef, watch } from "vue";
import { useResponseStore } from "@/stores/response";
import LoginForm from "./LoginForm.vue";
const dialog = shallowRef(false);

const responseStore = useResponseStore();

// Watch the dialog's state
watch(dialog, (newVal) => {
  if (newVal) {
    onOpen();
  } else {
    onClose();
  }
});

const props = defineProps({
  block: { type: Boolean, default: true },
});

// const emit = defineEmits(["update:modelValue", "close"]);

const onOpen = async () => {
  responseStore.$reset();
};

const onClose = () => {};
</script>
