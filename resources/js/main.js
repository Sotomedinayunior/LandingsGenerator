import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';
import store from './global/store';
import '../sass/app.scss';
import { createMetaManager } from 'vue-meta'; 
import i18n from './translate'
// Importar PrimeVue y sus estilos
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

import 'primeicons/primeicons.css'
import ToastService from 'primevue/toastservice';




const app = createApp(App);

// Agrega vue-meta para manejar etiquetas meta
const metaManager = createMetaManager();

app.use(i18n); // Usa i18n para la internacionalización
app.use(store); // Usa el store (Vuex)
app.use(router); // Usa el router
app.use(metaManager); // Usa el meta manager
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: 'system',
            cssLayer: false
        }
    }
 });
 app.use(ToastService);
// Verificación de sesión antes de montar la aplicación
store.dispatch('startSessionCheck').then(() => {
    // Monta la aplicación solo después de la verificación de sesión
    app.mount('#app');
});
