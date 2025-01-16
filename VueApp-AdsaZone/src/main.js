import './assets/main.css'

import App from './App.vue'
import { createApp } from 'vue'

// Importo lo necesario para utilizar firebase
import { VueFire, VueFireAuth } from 'vuefire'
import { firebaseApp } from './firebase'

// Importo lo necesario para utilizar componentes de PrimeVue
import 'primeicons/primeicons.css'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

const app = createApp(App)

app.use(VueFire, {
    // imported above but could also just be created here
    firebaseApp,
    modules: [
        // we will see other modules later on
        VueFireAuth(),
    ],
})

app.use(PrimeVue, {
    theme: {
        preset: Aura
    },
});

app.mount('#app')