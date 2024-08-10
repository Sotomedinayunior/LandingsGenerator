<template>
    <div>
        <Dashboard/>
      
     
    </div>
  </template>
  
  <script>
  import Dashboard from '../components/SideBar.vue'
  import { mapGetters } from 'vuex';
  
  export default {
    components:{
        Dashboard
    },
    computed: {
      ...mapGetters(['getUser', 'getToken']),
      user() {
        return this.getUser;
      },
      token() {
        return this.getToken;
      }
    }
  }
  </script>
  
  <style scoped>
  /* Estilos opcionales */
  </style>
  

