import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';
import store from './global/store';
import '../sass/app.scss';
import { createMetaManager } from 'vue-meta'; 
import i18n from './translate'

const app = createApp(App);

// Agrega vue-meta para manejar etiquetas meta
const metaManager = createMetaManager();

app.use(i18n); // Usa i18n para la internacionalización
app.use(store); // Usa el store (Vuex)
app.use(router); // Usa el router
app.use(metaManager); // Usa el meta manager

// Verificación de sesión antes de montar la aplicación
store.dispatch('startSessionCheck').then(() => {
    // Monta la aplicación solo después de la verificación de sesión
    app.mount('#app');
});
