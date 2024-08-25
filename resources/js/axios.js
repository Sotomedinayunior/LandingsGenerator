import axios from 'axios';
import store from './global/store';

axios.defaults.baseURL = import.meta.env.VITE_API_URL;

axios.interceptors.request.use(config => {
  const token = store.state.token;
  // console.log(` token`);
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

axios.interceptors.response.use(response => {
  if (response.config.url === '/api/login-nelly' && response.status === 200) {
    store.dispatch('checkSession'); // Verificar la sesión después de iniciar sesión
  }
  return response;
}, error => {
  if (error.response && error.response.status === 401) {
    store.dispatch('nelly-logout'); // Cerrar sesión si hay error de autenticación
  }
  return Promise.reject(error);
});
export default axios;
