import { createRouter, createWebHistory } from 'vue-router';
import AdditionsLanding from '../views/Landing/AdditionsLanding.vue';
import AddVehiclesTab from '../views/AddVehiclesTab.vue';
import CartLanding from '../views/Landing/CartLanding.vue';
import ConfigUser from '../views/ConfigUser.vue';
import FeatureView from '../views/FeatureView.vue';
import FormUpdateVehicles from '../components/FormUpdateVehicles.vue';
import FormVehiclesCreate from '../components/FormVehiclesCreate.vue';
import FAQ from '../views/Landing/Faq.vue';
import HomeLanding from '../views/Landing/HomeLanding.vue';
import Help from '../views/Help.vue';
import HistoryLanding from '../views/HistoryLanding.vue';
import LayoutDesigner from '../views/LayoutDesigner.vue';
import LayoutLanding from '../views/Landing/LayoutLanding.vue';
import ListLanding from '../views/ListLanding.vue';
import LocationReservation from '../views/LocationReservation.vue';
import Login from '../views/Login.vue';
import LogoColorsTab from '../views/LogoColorsTab.vue';
import MainLayout from '../views/MainLayout.vue';
import NotFoundDashboard from '../views/NotFoundDashorad.vue'; // 404 para usuarios autenticados
import Published from '../views/published.vue';
import PublishedTab from '../views/PublishedTab.vue';
import Reservation from '../views/Reservation.vue';
import ReviewLanding from '../views/Landing/ReviewLanding.vue';
import ReviewComponent from '../views/ReviewComponent.vue';
import ReviewTab from '../views/ReviewTab.vue';
import ThanksLanding from '../views/Landing/ThanksLanding.vue';
import VehicleDetail from '../views/Landing/VehicleDetail.vue';
import ViewConfigLanding from '../views/ViewConfigLanding.vue';
import store from '../global/store';


const routes = [
  { 
    path: '/', 
    component: Login, 
    name: 'login',
    meta: { title: 'Login - Nelly App' } 
  },
  { 
    path: '/landings', 
    name: 'dashboard',
    component: MainLayout,
    meta: { title: 'Dashboard - Nelly App', requiresAuth: true },
    children: [
      { 
        path: '/landings', 
        component: ListLanding, 
        name: 'landings',
        meta: { title: 'List of Landings - Nelly App'  } 
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
      },
      {
        path:'/feature-view',
        component:FeatureView,
        meta:{title:'feature - Nelly App'}
      },
      {
        path:'/user-config',
        component:ConfigUser,
        meta:{title:'user - Nelly App'}
      },
      {
        path: '/view-landing/:id',
        component: ViewConfigLanding,
        meta: { title: 'View-landing - Nelly App' }
      },
      {
        path:'/review-component/:name',
        component:ReviewComponent,
        meta:{title:'review - Nelly App'}
      },
      {
        path: '/review-landing/:id',
        component: ViewConfigLanding,
        meta: { title: 'View-landing - Nelly App' }
      }
    ],
  
  },

  {
    path: '/layout-designer',
    name: 'LayoutDesigner',
    component: LayoutDesigner,
    meta: { title: 'Layout Designer - Nelly App', requiresAuth: true } ,
    children: [
      {
        path:'',
        name:'Landing Loyout',
        component:LogoColorsTab,
        meta:{title:'landing - Nelly App' , requiresAuth:true},
      },
      
      {
        path:'add-vehicles',
        name:'add-vehicles',
        component:AddVehiclesTab,
        meta:{title:'add vehicles - Nelly App' , requiresAuth:true},

      },
      {
        path:'add-vehicles/add-form',
        name:'add-form',
        component:FormVehiclesCreate,
        meta:{title:'add form - Nelly App' , requiresAuth:true},

      },
      {
       path:'add-vehicles/update-form/:id',
       name:'update-form',
       component:FormUpdateVehicles,
       meta:{title:'update form - Nelly App' , requiresAuth:true},

      },
      {
        path:'review',
        name:'review',
        component:ReviewTab,
        meta:{title:'review - Nelly App' , requiresAuth:true}
      }
    ]
  },
  {
    path:'/published',
    component: Published,
    meta:{title:'Layout published - Nelly app' , requiresAuth:true},
  },
  {
    path:'/publishedTap',
    component: PublishedTab ,
    meta:{title:'published - Nelly app' , requiresAuth:true},

  },
  // Ruta catch-all para usuarios autenticados
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFoundAuth',
    component: NotFoundDashboard,
    meta: { title: 'Not Found - Nelly App', requiresAuth: true }
  },
  {
    path:'/:name',
    component:LayoutLanding,
    meta:{title:'Home pages'},
    children:[
      {
        path:'',
        name:'home-landing',
        component:HomeLanding,
        
      },
      {
        path:'vehicle',
        name:'vehicle',
        component:CartLanding,
      },
      {
        path:'vehicles/:idvehicle',
        name: 'vehicle-pages',
        component:VehicleDetail,
      },
      {
        path:'FAQ',
        name:'fqa',
        component:FAQ,
        

      },
      {
        path:'additions',
        name:'vehicle-additions',
        component:AdditionsLanding,
      },
      {
        path:'review',
        name:'vehicle-review',
        component:ReviewLanding,
      },
      {
        path:'thanks-you',
        name:'thanks-you',
        component:ThanksLanding,
      }
    ]
    
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
    next({ name: 'landings' }); 

  }else if(to.name === '/' && isAuthenticated){
    next({ name: 'landings' });
  }
  
  else {
    // Establecer el título de la página
    const title = to.meta.title || 'Nelly App'; // Título predeterminado si no se especifica
    document.title = title;

    next();
  }
});

export default router;
