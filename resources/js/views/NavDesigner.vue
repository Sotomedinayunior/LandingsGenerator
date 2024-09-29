<template>
    <header class="grid grid-cols-2 p-4">
      <div class="flex pl-9">
        <button
          @click="cancelProcess"
          class="border border-gray-400 rounded px-4 py-3 text-gray-600 hover:bg-gray-100"
        >
          Cancelar Proceso
        </button>
      </div>
      <div>
        <img src="../static/asset/Logo.webp" class="w-[120px] h-full" alt="Logo nelly" width="600" height="200">
      </div>
    </header>
  
    <section class="flex justify-around items-center border-b border-gray-200 my-10 font-semibold">
      <router-link to="/layout-designer/"  class="nav-link">Logo & Colors</router-link>
      <router-link to="/layout-designer/add-vehicles"  class="nav-link">Add Vehicles</router-link>
      <router-link to="/layout-designer/review"  class="nav-link">Review</router-link>
    </section>
  </template>
  
  <script>
  export default {
    name: "NavDesigner",
    methods: {
      cancelProcess() {
        let userId = localStorage.getItem("NellyLandingCreate");
        if (userId) {
          localStorage.removeItem("NellyLandingCreate");
        }
        return this.$router.push("/landings");
        // Lógica para cancelar el proceso
      },
    },
  };
  </script>
  
  <style scoped>
  header {
    background-color: white;
  }
  
  a {
    font-size: 16px;
  }
  
  img {
    width: 60px; /* Ajustar según el tamaño del logo */
  }
  
  /* Estilo por defecto para los links */
  .nav-link {
    color: #6b7280; /* color gris */
    padding: 0.5rem;
    text-decoration: none;
  }
  
  /* Estilo activo para el link seleccionado */
  .active {
    color: #f97316; /* color naranja */
    border-bottom: 2px solid #f97316; /* Línea debajo del link activo */
  }
  </style>
  