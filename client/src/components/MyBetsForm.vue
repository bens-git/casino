<template>
  <div>
    <h3 class="text-h6 mb-3">My Bets</h3>

    <v-card variant="outlined" rounded="lg">
      <v-table density="comfortable">
        <thead>
          <tr>
            <th>Game</th>
            <th>Wager</th>
            <th>Status</th>
            <th>Payout</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="bet in bets" :key="bet.id">
            <td>{{ bet.game }}</td>
            <td>${{ bet.wager.toFixed(2) }}</td>
            <td>
              <v-chip
                size="small"
                :color="statusColor(bet.status)"
                variant="flat"
              >
                {{ bet.status }}
              </v-chip>
            </td>
            <td>
              {{ bet.payout ? `$${bet.payout.toFixed(2)}` : "—" }}
            </td>
          </tr>
        </tbody>
      </v-table>

      <v-card-actions>
        <v-btn variant="text" prepend-icon="mdi-history">
          View Full History
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script setup>
const bets = [
  { id: 1, game: "Blackjack", wager: 50, status: "Won", payout: 100 },
  { id: 2, game: "Roulette", wager: 25, status: "Lost", payout: null },
  { id: 3, game: "Slots", wager: 10, status: "Active", payout: null },
];

const statusColor = (status) => {
  if (status === "Won") return "success";
  if (status === "Lost") return "error";
  return "warning";
};
</script>
