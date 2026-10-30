import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import '@fontsource-variable/inter'
import '../assets/css/main.css'

import App from './App.vue'
import router from './router'
import AnnuaPreset from './theme/annua-preset'

const app = createApp(App)

app.use(router)
app.use(PrimeVue, {
  license: import.meta.env.VITE_PRIMEUI_LICENSE,
  theme: {
    preset: AnnuaPreset,
    options: {
      darkModeSelector: '.annua-dark',
      cssLayer: {
        name: 'primevue',
        order: 'theme, base, primevue',
      },
    },
  },
})

app.mount('#app')