import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';
import store from './global/store';
import { createMetaManager } from 'vue-meta'; // Importa vue-meta
import i18n from './translate'
const app = createApp(App);

// Agrega vue-meta para manejar etiquetas meta
const metaManager = createMetaManager();
app.use(metaManager); // Usa el meta manager
app.use(i18n)
app.use(router);
app.use(store);


// Iniciar la verificación de sesión al cargar la aplicación
store.dispatch('startSessionCheck');

app.mount('#app');
