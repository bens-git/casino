<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const goToPlay = () => {
  router.push("/play");
};

const goToRules = () => {
  router.push("/rules");
};
</script>

<template>
  <v-container fluid class="landing-root d-flex flex-column">
    <!-- HERO -->
    <v-row align="center" justify="center" class="hero flex-grow-1">
      <v-col cols="12" md="8" class="text-center">
        <v-icon size="96" color="gold">mdi-cards</v-icon>

        <h1 class="hero-title mt-4">50 / 50 Casino</h1>
        <p class="hero-subtitle">One coin. Two sides. Fair odds.</p>

        <v-row justify="center" class="mt-6" dense>
          <v-col cols="12" sm="5">
            <v-btn block size="x-large" color="primary" @click="goToPlay">
              Play Now
            </v-btn>
          </v-col>

          <v-col cols="12" sm="5">
            <v-btn
              block
              size="x-large"
              variant="outlined"
              color="primary"
              @click="goToRules"
            >
              How It Works
            </v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <!-- FEATURES (auto-shrink to fit) -->
    <v-row justify="center" class="features flex-shrink-0">
      <v-col cols="12" md="4" class="text-center">
        <v-icon size="48" color="gold">mdi-scale-balance</v-icon>
        <h3 class="feature-title">Jackpot-Based Odds</h3>
        <p class="feature-text">
          The chance of winning depends on the jackpot size and number of
          players.
        </p>
      </v-col>

      <v-col cols="12" md="4" class="text-center">
        <v-icon size="48" color="gold">mdi-lightning-bolt</v-icon>
        <h3 class="feature-title">Fast Gameplay</h3>
        <p class="feature-text">
          Flip, reveal, and see results instantly—no long waits.
        </p>
      </v-col>

      <v-col cols="12" md="4" class="text-center">
        <v-icon size="48" color="gold">mdi-shield-check</v-icon>
        <h3 class="feature-title">Transparent & Fair</h3>
        <p class="feature-text">
          Simple rules, clear outcomes, and no hidden mechanics.
        </p>
      </v-col>
    </v-row>

    <!-- CTA -->
    <v-row justify="center" class="cta flex-shrink-0 mb-8">
      <v-col cols="12" md="8" class="text-center">
        <h2 class="cta-title">Ready to test your luck?</h2>
        <v-btn size="x-large" color="primary" class="mt-4" @click="goToPlay">
          Enter the Casino
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
html,
body,
#app {
  height: 100%;
  margin: 0;
}

.landing-root {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background: radial-gradient(
    circle at top,
    #1b1b1b 0%,
    #0f0f0f 60%,
    #000 100%
  );
  color: #fff;
}

.hero {
  flex-grow: 1;
}

.hero-title {
  font-size: clamp(2rem, 5vw, 3rem);
  font-weight: 700;
  letter-spacing: 0.05em;
}

.hero-subtitle {
  font-size: 1.1rem;
  opacity: 0.85;
}

.features {
  width: 100%; /* ensure row takes full width */
  max-width: 1200px; /* optional max width */
  margin: 0 auto; /* center row in viewport */
  display: flex;
  flex-wrap: wrap;
  justify-content: center; /* center columns */
}

.feature-title {
  margin-top: 1rem;
  font-weight: 600;
}

.feature-text {
  opacity: 0.8;
}

.cta-title {
  font-size: clamp(1.8rem, 4vw, 2.5rem);
  font-weight: 600;
}

.landing-root {
  min-height: 100vh; /* optional, ensures big screens fill viewport */
  display: flex;
  flex-direction: column;
  justify-content: flex-start; /* let content flow naturally */
  background: radial-gradient(
    circle at top,
    #1b1b1b 0%,
    #0f0f0f 60%,
    #000 100%
  );
  color: #fff;
  padding-top: 2rem;
  padding-bottom: 2rem;
}
</style>
