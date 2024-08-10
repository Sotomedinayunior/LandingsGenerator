// main.js
import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index';
import store from './global/store'; // Asegúrate de que la ruta sea correcta

const app = createApp(App);

app.use(router);
app.use(store);

// Iniciar la verificación de sesión al cargar la aplicación
store.dispatch('startSessionCheck');

app.mount('#app');
