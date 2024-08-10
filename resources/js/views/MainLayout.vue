<template>
    <div class="flex h-screen">
      <Sidebar />
      <div class="flex-1 overflow-y-auto">
        <router-view />
      </div>
    </div>
  </template>
  
  <script>
  import Sidebar from '../components/SideBar.vue';
  
  export default {
    components: {
      Sidebar
    }
  };
  </script>
  