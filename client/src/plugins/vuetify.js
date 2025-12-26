// Styles
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

// Vuetify
import { createVuetify } from "vuetify";
import * as directives from "vuetify/directives";
import { VDateInput } from "vuetify/labs/VDateInput";

const myCustomLightTheme = {
  dark: true,
  colors: {
    primary: "#D4A017", // Golden chips / luxury feel
    secondary: "#C41E3A", // Roulette red
    accent: "#1E88E5", // Blue accent for UI highlights
    info: "#00E5FF", // Neon cyan (for alerts/notifications)
    success: "#00C853", // Winning green
    warning: "#FF6D00", // Big bet orange
    error: "#D50000", // Loss red
    background: "#121212", // Deep casino dark
    surface: "#1E1E1E", // Card-table greenish dark surface
  },
};

export default createVuetify(
  // https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides
  {
    theme: {
      defaultTheme: "myCustomLightTheme",
      themes: {
        myCustomLightTheme,
      },
    },
    // locale: 'en-CA',
    components: { VDateInput },
    directives,
    display: {
      mobileBreakpoint: "sm", // Check if this is set
    },
  }
);
