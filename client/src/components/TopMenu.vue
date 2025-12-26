<template>
  <v-app-bar flat class="casino-app-bar">
    <v-app-bar-nav-icon @click="drawer = !drawer" />

    <!-- Logo / Brand -->
    <v-btn
      v-if="!mobile"
      :class="{ 'v-btn--active': isActive('/landing-page') }"
      to="/"
      text
    >
      <v-icon size="32" color="amber">mdi-cards</v-icon>
      <span class="logo-text">{{ appTitle }}</span>
    </v-btn>

    <v-spacer />

    <!-- Desktop menu links -->
    <v-btn
      text
      :class="{ 'v-btn--active': isActive('/play') }"
      @click="go('/play')"
    >
      Play
    </v-btn>

    <v-btn
      text
      :class="{ 'v-btn--active': isActive('/how-it-works') }"
      @click="go('/how-it-works')"
    >
      How It Works
    </v-btn>

    <v-btn
      text
      :class="{ 'v-btn--active': isActive('/support') }"
      @click="go('/support')"
    >
      Support
    </v-btn>

    <LoginDialog
      v-if="!userStore.user && !isActiveRoute('/login-form')"
      :block="false"
    />
    <RegistrationDialog v-if="!userStore.user" :block="false" />
    <v-spacer />

    <v-menu v-if="userStore.user">
      <template #activator="{ props }">
        <v-btn v-bind="props" variant="flat" class="px-3" height="48">
          <v-icon class="mr-2">mdi-account-circle</v-icon>

          <div class="text-left mr-2">
            <div class="text-body-2 font-weight-medium text-truncate">
              {{ userStore.user.email }}
            </div>
            <div class="text-caption text-success">
              {{ userStore.formattedBalance }}
            </div>
          </div>

          <v-icon size="18">mdi-chevron-down</v-icon>
        </v-btn>
      </template>

      <v-list>
        <v-list-item>
          <WalletDialog />
        </v-list-item>
        <v-list-item>
          <MyBetsDialog />
        </v-list-item>
        <v-list-item>
          <EditProfileDialog />
        </v-list-item>
        <v-list-item>
          <LogoutDialog />
        </v-list-item>
      </v-list>
    </v-menu>

    <v-spacer />

    <!-- Account -->
  </v-app-bar>

  <!-- Navigation Drawer for Mobile -->
  <v-navigation-drawer
    v-model="drawer"
    temporary
    elevation="2"
    width="260"
    class="app-drawer"
  >
    <!-- App Title -->
    <div class="drawer-header">
      <v-btn
        :class="{ 'v-btn--active': isActive('/landing-page') }"
        to="/"
        text
        block
        class="casino-logo-btn"
      >
        <v-icon size="32" color="amber">mdi-cards</v-icon>
        <span class="logo-text">{{ appTitle }}</span>
      </v-btn>
    </div>

    <v-divider />

    <!-- Navigation Buttons -->
    <div class="drawer-btns">
      <LoginDialog v-if="!userStore.user && !isActiveRoute('/login-form')" />

      <RegistrationDialog v-if="!userStore.user" />
    </div>

    <v-list nav>
      <v-btn
        block
        text
        :class="{ 'v-btn--active': isActive('/play') }"
        @click="go('/play')"
        >Play</v-btn
      >
      <v-btn
        block
        text
        :class="{ 'v-btn--active': isActive('/how-it-works') }"
        @click="go('/how-it-works')"
        >How It Works</v-btn
      >
      <v-btn
        block
        text
        :class="{ 'v-btn--active': isActive('/support') }"
        @click="go('/support')"
        >Support</v-btn
      >

      <v-divider class="my-2" />

      <WalletDialog />
      <MyBetsDialog />
      <EditProfileDialog />
      <LogoutDialog />
    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useDisplay } from "vuetify";
import { useUserStore } from "@/stores/user";
import { useRouter, useRoute } from "vue-router";
import LogoutDialog from "./LogoutDialog.vue";
import RegistrationDialog from "./RegistrationDialog.vue";
import LoginDialog from "./LoginDialog.vue";
import EditProfileDialog from "./EditProfileDialog.vue";
import WalletDialog from "./WalletDialog.vue";
import MyBetsDialog from "./MyBetsDialog.vue";

const route = useRoute();
const { mobile } = useDisplay();
const drawer = ref(false);
const userStore = useUserStore();
const appTitle = process.env.VUE_APP_TITLE;
const router = useRouter();

const links = ref([]);
const drawerLinks = ref([]);

const isActive = (path) => route.path === path;
const go = (path) => router.push(path);

onMounted(async () => {
  setupLinks();
});

const setupLinks = () => {
  if (userStore.user) {
    links.value = [
      { text: "Items", route: "item-list" },
      { text: "Projects", route: "project-list" },
    ];

    drawerLinks.value = [
      { text: "Items", route: "item-list" },
      { text: "Projects", route: "project-list" },
      { text: "Jobs", route: "job-list" },
      { text: "Archetypes", route: "archetype-list" },
      { text: "Categories", route: "category-list" },
      { text: "Usages", route: "usage-list" },
      { text: "Brands", route: "brand-list" },
    ];
  } else {
    links.value = [];
    drawerLinks.value = [];
  }
};

// Watch for changes in the responseStore to display the appropriate snackbar
watch(
  () => userStore.user,
  () => {
    setupLinks();
  },
  { deep: true }
);

// Safeguard to handle undefined or null paths
const normalizePath = (path) => {
  return path ? path.replace(/\/+$/, "").trim() : "";
};

const isActiveRoute = (linkRoute) => {
  return normalizePath(route.path) === normalizePath(linkRoute);
};
</script>

<style>
.active {
  color: #1976d2;
  font-weight: bold;
  background-color: rgba(25, 118, 210, 0.1);
}

.app-drawer {
  background: #121212;
  color: #fff;
}

.drawer-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 20px;
  font-size: 1.2rem;
  font-weight: 600;
}

.drawer-title {
  letter-spacing: 0.5px;
}

/* Ensure buttons take full width and stack vertically */
.drawer-btns {
  display: flex;
  flex-direction: column; /* vertical stacking */
  width: 100%;
  padding: 8px;
  gap: 8px;
}

.drawer-btn {
  text-align: left; /* optional: align text to left */
  border-radius: 12px;
}

.drawer-btn.active {
  background: rgba(255, 215, 0, 0.15);
  color: #ffd700;
}
</style>
