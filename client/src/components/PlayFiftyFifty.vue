<script setup>
import { ref, computed } from "vue";

/**
 * Mock state (replace with API data later)
 */
const jackpot = ref(1250);
const players = ref(37);
const userJoined = ref(false);
const loading = ref(false);

const odds = computed(() => {
  if (!players.value) return "—";
  return `1 in ${players.value}`;
});

const joinGame = async () => {
  loading.value = true;

  // simulate API delay
  setTimeout(() => {
    userJoined.value = true;
    players.value += 1;
    jackpot.value += 50;
    loading.value = false;
  }, 800);
};
</script>

<template>
  <div class="play-root">
    <v-card class="play-card" elevation="14">
      <v-card-text class="text-center">
        <v-icon size="64" color="gold">mdi-cards-playing</v-icon>

        <h1 class="title mt-4">Current Jackpot</h1>

        <div class="jackpot">${{ jackpot.toLocaleString() }}</div>

        <v-row class="stats mt-6" dense>
          <v-col cols="6">
            <div class="stat-label">Players</div>
            <div class="stat-value">{{ players }}</div>
          </v-col>

          <v-col cols="6">
            <div class="stat-label">Your Odds</div>
            <div class="stat-value">{{ odds }}</div>
          </v-col>
        </v-row>

        <v-alert v-if="userJoined" type="success" variant="tonal" class="mt-6">
          You’re in! Waiting for the draw.
        </v-alert>

        <v-btn
          v-else
          block
          size="x-large"
          color="primary"
          class="mt-6"
          :loading="loading"
          @click="joinGame"
        >
          Join the Pot
        </v-btn>

        <p class="disclaimer mt-6">
          Odds change as more players enter the jackpot.
        </p>
      </v-card-text>
    </v-card>
  </div>
</template>

<style scoped>
.play-root {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(
    circle at top,
    #1b1b1b 0%,
    #0f0f0f 60%,
    #000 100%
  );
}

.play-card {
  width: 100%;
  max-width: 460px;
  background: rgba(20, 20, 20, 0.95);
  color: #fff;
  border-radius: 18px;
}

.title {
  font-size: 1.8rem;
  font-weight: 700;
  letter-spacing: 0.05em;
}

.jackpot {
  font-size: 3rem;
  font-weight: 800;
  color: #ffd700;
  margin-top: 0.5rem;
}

.stats {
  text-align: center;
}

.stat-label {
  font-size: 0.85rem;
  opacity: 0.7;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: 600;
}

.disclaimer {
  font-size: 0.8rem;
  opacity: 0.6;
}
</style>
