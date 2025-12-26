<script setup></script>

<template>
  <div class="how-root">
    <v-container class="how-container">
      <v-row justify="center">
        <v-col cols="12" md="10" lg="8">
          <h1 class="title text-center mb-8">How It Works</h1>

          <!-- OVERVIEW -->
          <v-card class="step-card mb-8" elevation="8">
            <v-card-text>
              <p class="intro">
                This is a jackpot-based 50–50 style game. The jackpot grows as
                players join, and one player wins.
              </p>

              <p>
                The name refers to how the jackpot is split — not to fixed odds.
                Your odds depend entirely on how many players are in the round.
              </p>
            </v-card-text>
          </v-card>

          <!-- STEP 1 -->
          <v-card class="step-card mb-6" elevation="8">
            <v-card-text>
              <div class="step-header">
                <v-icon color="gold" size="36">mdi-account-multiple</v-icon>
                <h2>1. Players Enter the Round</h2>
              </div>

              <p>
                Each round opens with an empty jackpot. Players enter by
                contributing a fixed entry amount.
              </p>

              <p>
                Every player receives one equal entry into the draw. As more
                players join, the jackpot increases.
              </p>
            </v-card-text>
          </v-card>

          <!-- STEP 2 -->
          <v-card class="step-card mb-6" elevation="8">
            <v-card-text>
              <div class="step-header">
                <v-icon color="gold" size="36">mdi-scale-balance</v-icon>
                <h2>2. Odds Are Based on Participation</h2>
              </div>

              <p>This game does <strong>not</strong> use fixed 50/50 odds.</p>

              <p>
                Your chance of winning is determined by the total number of
                players in the round:
              </p>

              <ul>
                <li>10 players → 1 in 10 chance</li>
                <li>25 players → 1 in 25 chance</li>
                <li>100 players → 1 in 100 chance</li>
              </ul>

              <p class="note">
                Odds update in real time while the round is open.
              </p>
            </v-card-text>
          </v-card>

          <!-- STEP 3 -->
          <v-card class="step-card mb-6" elevation="8">
            <v-card-text>
              <div class="step-header">
                <v-icon color="gold" size="36">mdi-lock-clock</v-icon>
                <h2>3. When the Round Closes</h2>
              </div>

              <p>
                Each round remains open until one of the following conditions is
                met:
              </p>

              <ul>
                <li>
                  <strong>Time Limit:</strong> The round closes after a set
                  amount of time.
                </li>
                <li>
                  <strong>Player Limit:</strong> A maximum number of players is
                  reached.
                </li>
                <li>
                  <strong>Jackpot Target:</strong> The jackpot reaches a
                  predefined size.
                </li>
                <li>
                  <strong>Manual Close:</strong> Rarely, for maintenance or rule
                  enforcement.
                </li>
              </ul>

              <p class="note">
                Closing conditions are shown before you enter. Once closed, no
                new entries are accepted.
              </p>
            </v-card-text>
          </v-card>

          <!-- STEP 4 -->
          <v-card class="step-card mb-6" elevation="8">
            <v-card-text>
              <div class="step-header">
                <v-icon color="gold" size="36">mdi-dice-multiple</v-icon>
                <h2>4. The Draw</h2>
              </div>

              <p>After the round closes, one entry is selected at random.</p>

              <p>
                Every player has an equal chance based solely on the number of
                total entries.
              </p>
            </v-card-text>
          </v-card>

          <!-- STEP 5 -->
          <v-card class="step-card mb-6" elevation="8">
            <v-card-text>
              <div class="step-header">
                <v-icon color="gold" size="36">mdi-cash-multiple</v-icon>
                <h2>5. Jackpot Split</h2>
              </div>

              <p>When a winner is selected, the jackpot is split evenly:</p>

              <ul>
                <li><strong>50%</strong> is awarded to the winning player</li>
                <li>
                  <strong>50%</strong> is allocated to:
                  <ul>
                    <li>Community programs</li>
                    <li>Charitable causes</li>
                    <li>Casino operations and management</li>
                  </ul>
                </li>
              </ul>

              <p>
                This structure supports sustainability, community impact, and
                continued operation of the platform.
              </p>
            </v-card-text>
          </v-card>

          <!-- STEP 6 -->
          <v-card class="step-card mb-10" elevation="8">
            <v-card-text>
              <div class="step-header">
                <v-icon color="gold" size="36">mdi-shield-check</v-icon>
                <h2>6. Fair & Transparent Play</h2>
              </div>

              <ul>
                <li>One entry per player</li>
                <li>No hidden multipliers</li>
                <li>No odds changes after closing</li>
                <li>Random selection at draw time</li>
              </ul>

              <p class="note">Please play responsibly.</p>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<style scoped>
.how-root {
  min-height: 100vh;
  background: radial-gradient(
    circle at top,
    #1b1b1b 0%,
    #0f0f0f 60%,
    #000 100%
  );
  color: #fff;
}

.how-container {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.title {
  font-size: clamp(2.2rem, 4vw, 3rem);
  font-weight: 700;
  letter-spacing: 0.05em;
}

.step-card {
  background: rgba(20, 20, 20, 0.95);
  border-radius: 16px;
}

.step-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.step-header h2 {
  font-size: 1.4rem;
  font-weight: 600;
}

p {
  opacity: 0.9;
  margin-bottom: 0.75rem;
}

ul {
  margin-left: 1.5rem;
  opacity: 0.9;
}

.intro {
  font-size: 1.05rem;
  font-weight: 500;
}

.note {
  font-size: 0.85rem;
  opacity: 0.65;
}
</style>
