import { createApp } from 'vue'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'
import GoldDark from './presets/gold-dark'
import ConfirmationService from 'primevue/confirmationservice'

import './assets/main.css'
import 'primeicons/primeicons.css'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(PrimeVue, {
  theme: {
    preset: GoldDark,
    options: {
      darkModeSelector: '.dark',
    },
  },
})
app.use(ConfirmationService)

app.mount('#app')
