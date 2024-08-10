import { createRouter, createWebHistory } from 'vue-router';
import store from '../global/store'; // Asegúrate de que esta ruta sea correcta
import Login from '../views/Login.vue';
import ListLanding from '../views/ListLanding.vue';
import Help from '../views/Help.vue';
import Reservation from '../views/Reservation.vue';
import MainLayout from '../views/MainLayout.vue'; 

const routes = [
  { path: '/', component: Login, name: 'login' },
  { 
    path: '/dashboard', 
    name: 'dashboard',
    component: MainLayout,
    children:[
      {path:'/landings' , component:ListLanding},
      {path:'/reservation' , component:Reservation},
      {path:'/help' , component:Help},
      // {path:'/Landings' , component:ListLanding},

      

    ]
    // meta: { requiresAuth: true } 
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Protección de rutas
router.beforeEach(async (to, from, next) => {
  // Llama a checkSession para manejar la expiración de la sesión
  await store.dispatch('checkSession');

  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = store.getters.isAuthenticated; // Llamar al getter correctamente

  if (requiresAuth && !isAuthenticated) {
    next({ name: 'login' });
  }
  else if (to.name === 'login' && isAuthenticated) {
    next({ name: 'dashboard' }); 
  } 
  else {
    next();
  }
});

export default router;
