import { createRouter, createWebHistory } from "vue-router";
import EmailVerified from "@/components/EmailVerified.vue";
import LandingPage from "@/components/LandingPage.vue";

import { useUserStore } from "@/stores/user"; // Adjust the import path as necessary

const routes = [
  {
    path: "/landing-page",
    name: "landing-page",
    component: LandingPage,
    meta: { requiresAuth: false },
  },

  {
    path: "/play",
    name: "play",
    component: () => import("@/components/PlayFiftyFifty.vue"),
  },

  {
    path: "/how-it-works",
    name: "how-it-works",
    component: () => import("@/components/HowItWorks.vue"),
  },
  {
    path: "/support",
    name: "support",
    component: () => import("@/components/SupportForm.vue"),
  },
  {
    path: "/:catchAll(.*)",
    redirect: "/landing-page",
  },
  {
    path: "/email-verified",
    name: "EmailVerified",
    component: EmailVerified,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const userStore = useUserStore();
  const isAuthenticated = !!userStore.user; // Check if user is logged in
  const requiresAuth = to.meta.requiresAuth;

  if (
    to.matched.some((record) => record.meta.requiresGuest) &&
    userStore.user
  ) {
    // Redirect to home page if user is already logged in
    return next({ name: "landing-page" });
  }

  if (requiresAuth && !isAuthenticated) {
    // Redirect to login if route requires authentication and user is not logged in
    next({ name: "landing-page" });
  } else {
    next(); // Proceed to the route
  }
});

export default router;
