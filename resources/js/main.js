import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';
import store from './global/store'; // Asegúrate de que la ruta sea correcta
import { createMetaManager } from 'vue-meta'; // Importa vue-meta

const app = createApp(App);

// Agrega vue-meta para manejar etiquetas meta
const metaManager = createMetaManager();
app.use(metaManager); // Usa el meta manager

app.use(router);
app.use(store);

// Iniciar la verificación de sesión al cargar la aplicación
store.dispatch('startSessionCheck');

app.mount('#app');
