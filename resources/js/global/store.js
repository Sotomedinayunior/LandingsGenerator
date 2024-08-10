import { createStore } from 'vuex';
import axios from 'axios';
import router from '../router/index';

const store = createStore({
  state() {
    return {
      token: localStorage.getItem('NellyToken') || null,
      user: null,
      sessionExpiry: localStorage.getItem('sessionExpiry') || null,
    };
  },
  mutations: {
    setToken(state, { token }) {
      const expiry = new Date().getTime() + 30 * 60 * 1000; // 30 minutos en milisegundos
      state.token = token;
      state.sessionExpiry = expiry;
      localStorage.setItem('NellyToken', token);
      localStorage.setItem('sessionExpiry', expiry);
    },
    clearToken(state) {
      state.token = null;
      state.user = null;
      state.sessionExpiry = null;
      localStorage.removeItem('NellyToken');
      localStorage.removeItem('sessionExpiry');
    },
    setUser(state, user) {
      state.user = user;
    }
  },
  actions: {
    async login({ commit }, credentials) {
      try {
        // Solicitar CSRF
        await axios.get('/sanctum/csrf-cookie');
        
        // Solicitar autenticación
        const response = await axios.post('/api/login', credentials);
        const { token, user } = response.data;

        // Establecer token y tiempo de expiración en el estado global
        commit('setToken', { token });
        commit('setUser', user);

        // Redirigir al dashboard
        router.push('/dashboard');
      } catch (error) {
        console.error('Error en login:', error);
      }
    },
    logout({ commit }) {
      axios.post('/api/logout', {}, {
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
    }
  }
});

export default store;
