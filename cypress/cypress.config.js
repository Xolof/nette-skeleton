import { defineConfig } from 'cypress';

export default defineConfig({
  e2e: {
    baseUrl: 'http://localhost:8080',
    specPattern: 'e2e/**/*.spec.{js,jsx,ts,tsx}',
    supportFile: 'support/e2e.js',
    setupNodeEvents(on, config) {
      return config;
    },
  },
});
