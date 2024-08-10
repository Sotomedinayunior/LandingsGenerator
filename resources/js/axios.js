import axios from 'axios';
import store from './global/store';

axios.defaults.baseURL = 'http://localhost:8000/api';
axios.interceptors.request.use(config => {
  const token = store.state.token;
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

axios.interceptors.response.use(response => {
  if (response.config.url === '/api/login' && response.status === 200) {
    store.dispatch('checkSession'); // Verificar la sesión después de iniciar sesión
  }
  return response;
}, error => {
  if (error.response && error.response.status === 401) {
    store.dispatch('logout'); // Cerrar sesión si hay error de autenticación
  }
  return Promise.reject(error);
});
