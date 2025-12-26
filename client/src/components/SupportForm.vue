<script setup></script>

<template>
  <div class="support-root">
    <v-container class="support-container">
      <v-row justify="center">
        <v-col cols="12" md="10" lg="8">
          <h1 class="title text-center mb-8">Support</h1>

          <!-- INTRO -->
          <v-card class="support-card mb-8" elevation="8">
            <v-card-text>
              <p class="intro">We’re here to help.</p>
              <p>
                Whether you have a question about gameplay, your account,
                payments, or a specific round, our support team is ready to
                assist.
              </p>
            </v-card-text>
          </v-card>

          <!-- COMMON ISSUES -->
          <v-card class="support-card mb-6" elevation="8">
            <v-card-text>
              <div class="section-header">
                <v-icon color="gold" size="36">mdi-help-circle</v-icon>
                <h2>Common Questions</h2>
              </div>

              <ul>
                <li>Issues entering a round</li>
                <li>Questions about odds or jackpot size</li>
                <li>Balance or transaction concerns</li>
                <li>Round closing or draw timing</li>
                <li>Account access or verification</li>
              </ul>
            </v-card-text>
          </v-card>

          <!-- CONTACT -->
          <v-card class="support-card mb-6" elevation="8">
            <v-card-text>
              <div class="section-header">
                <v-icon color="gold" size="36">mdi-email-outline</v-icon>
                <h2>Contact Support</h2>
              </div>

              <p>For the fastest response, please contact us by email:</p>

              <p class="contact">
                <strong>support@yourcasino.com</strong>
              </p>

              <p class="note">
                Include your username and round ID (if applicable) so we can
                help you faster.
              </p>
            </v-card-text>
          </v-card>

          <!-- RESPONSE TIME -->
          <v-card class="support-card mb-6" elevation="8">
            <v-card-text>
              <div class="section-header">
                <v-icon color="gold" size="36">mdi-clock-outline</v-icon>
                <h2>Response Time</h2>
              </div>

              <p>
                We aim to respond to all inquiries within
                <strong>24 hours</strong>.
              </p>

              <p>
                During high-traffic periods or maintenance windows, response
                times may be slightly longer.
              </p>
            </v-card-text>
          </v-card>

          <!-- FAIR PLAY -->
          <v-card class="support-card mb-10" elevation="8">
            <v-card-text>
              <div class="section-header">
                <v-icon color="gold" size="36">mdi-shield-check</v-icon>
                <h2>Fair Play & Responsible Gaming</h2>
              </div>

              <p>
                If you have concerns about fairness, transparency, or
                responsible play, please contact support directly.
              </p>

              <p class="note">We encourage all players to play responsibly.</p>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<style scoped>
.support-root {
  min-height: 100vh;
  background: radial-gradient(
    circle at top,
    #1b1b1b 0%,
    #0f0f0f 60%,
    #000 100%
  );
  color: #fff;
}

.support-container {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.title {
  font-size: clamp(2.2rem, 4vw, 3rem);
  font-weight: 700;
  letter-spacing: 0.05em;
}

.support-card {
  background: rgba(20, 20, 20, 0.95);
  border-radius: 16px;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1rem;
}

.section-header h2 {
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

.contact {
  font-size: 1.1rem;
  letter-spacing: 0.03em;
}

.note {
  font-size: 0.85rem;
  opacity: 0.65;
}
</style>
