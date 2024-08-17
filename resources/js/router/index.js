import { createRouter, createWebHistory } from 'vue-router';
import store from '../global/store'; // Asegúrate de que esta ruta sea correcta
import Login from '../views/Login.vue';
import ListLanding from '../views/ListLanding.vue';
import Help from '../views/Help.vue';
import Reservation from '../views/Reservation.vue';
import MainLayout from '../views/MainLayout.vue'; 
import LayoutDesigner from '../views/LayoutDesigner.vue';
import NotFoundDashboard from '../views/NotFoundDashorad.vue'; // 404 para usuarios autenticados
import NotFoundPublic from '../views/NotFoundPublic.vue'; // 404 para usuarios no autenticados
import HistoryLanding from '../views/HistoryLanding.vue';
import LocationReservation from '../views/LocationReservation.vue';
const routes = [
  { 
    path: '/', 
    component: Login, 
    name: 'login',
    meta: { title: 'Login - Nelly App' } 
  },
  { 
    path: '/dashboard', 
    name: 'dashboard',
    component: MainLayout,
    meta: { title: 'Dashboard - Nelly App', requiresAuth: true },
    children: [
      { 
        path: '/landings', 
        component: ListLanding, 
        meta: { title: 'List of Landings - Nelly App' } 
      },
      { 
        path: '/reservation', 
        component: Reservation, 
        meta: { title: 'Reservations - Nelly App' } 
      },
      { 
        path: '/help', 
        component: Help, 
        meta: { title: 'Help - Nelly App' } 
      },
      {
        path:'/history',
        component:HistoryLanding,
        meta:{title:'History - Nelly App'}
      },
      {
        path:'/location-reservaction ',
        component:LocationReservation,
        meta:{title:'location - Nelly App'}
      }
    ],
  },
  {
    path: '/layout-designer',
    name: 'LayoutDesigner',
    component: LayoutDesigner,
    meta: { title: 'Layout Designer - Nelly App', requiresAuth: true } 
  },
  // Ruta catch-all para usuarios autenticados
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFoundAuth',
    component: NotFoundDashboard,
    meta: { title: 'Not Found - Nelly App', requiresAuth: true }
  },


];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Protección de rutas y actualización del título
router.beforeEach(async (to, from, next) => {
  // Llama a checkSession para manejar la expiración de la sesión
  await store.dispatch('checkSession');

  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = store.getters.isAuthenticated; // Llamar al getter correctamente

  if (requiresAuth && !isAuthenticated) {
    next({ name: 'login' });
  } else if (to.name === 'login' && isAuthenticated) {
    next({ name: 'dashboard' }); 
  } else {
    // Establecer el título de la página
    const title = to.meta.title || 'Nelly App'; // Título predeterminado si no se especifica
    document.title = title;

    next();
  }
});

export default router;
