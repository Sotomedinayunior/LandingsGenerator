import { createStore } from 'vuex';
import axios from 'axios';
import router from '../router/index';

const store = createStore({
  state() {
    return {
      token: localStorage.getItem('NellyToken') || null,
      iduser: localStorage.getItem('NellyUserId') || null,
      user: JSON.parse(localStorage.getItem('NellyUser')) || null, // Cargar el usuario desde localStorage
      sessionExpiry: localStorage.getItem('sessionExpiry') || null,
    };
  },
  mutations: {
    setToken(state, { token, iduser }) {
      const expiry = new Date().getTime() + 60 * 60 * 1000; // 60 minutos en milisegundos
      state.token = token;
      state.sessionExpiry = expiry;
      state.iduser = iduser; // Almacenar el iduser en el estado
      localStorage.setItem('NellyToken', token);
      localStorage.setItem('sessionExpiry', expiry);
      localStorage.setItem('NellyUserId', iduser); // Guardar iduser en localStorage
    },
    clearToken(state) {
      state.token = null;
      state.user = null;
      state.sessionExpiry = null;
      state.iduser = null; // Limpiar iduser en el estado
      localStorage.removeItem('NellyToken');
      localStorage.removeItem('NellyUserId'); // Remover iduser de localStorage
      localStorage.removeItem('sessionExpiry');
      localStorage.removeItem('NellyUser'); // Remover usuario de localStorage
    },
    setUser(state, user) {
      state.user = user;
      localStorage.setItem('NellyUser', JSON.stringify(user)); // Guardar usuario en localStorage
    }
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        // Solicitar CSRF
        await axios.get('/sanctum/csrf-cookie');
        
        // Solicitar autenticación
        const response = await axios.post('/login-nelly', credentials);
        const { token, user } = response.data;

        // Establecer token, iduser y tiempo de expiración en el estado global
        commit('setToken', { token, iduser: user.id }); // Guardar solo el id del usuario
        commit('setUser', user);

        // Redirigir a la landing
        router.push('/landings');
      } catch (error) {
        if (error.response && error.response.status === 422) {
          // Si hay errores de validación (422), los devolvemos para manejarlos en el componente
          return Promise.reject(error.response.data.errors);
        } else {
          console.error('Error en login:', error);
          return Promise.reject({ general: 'An unexpected error occurred. Please try again.' });
        }
      }
    },
    logout({ commit }) {
      axios.post('/nelly-logout', {}, {
        headers: {
          Authorization: `Bearer ${store.state.token}`
        }
      })
      .then(() => {
        commit('clearToken');
        router.push('/'); // Redirigir al login
      })
      .catch(error => {
        console.error('Error en logout:', error);
      });
    },
    checkSession({ commit, state }) {
      const now = new Date().getTime();
      if (state.sessionExpiry && now > parseInt(state.sessionExpiry, 10)) {
        commit('clearToken');
        router.push('/');
      }
    },
    startSessionCheck({ dispatch }) {
      // Verificar la sesión cada minuto (60000 ms)
      setInterval(() => {
        dispatch('checkSession');
      }, 60000);
    }
  },
  getters: {
    isAuthenticated(state) {
      const now = new Date().getTime();
      return !!state.token && state.sessionExpiry && now < state.sessionExpiry;
    },
    getUser(state) {
      return state.user;
    },
    getUserId(state) {
      return state.iduser; // Getter para obtener el id del usuario
    }
  }
});

export default store;