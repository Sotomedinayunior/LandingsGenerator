<template>
  <div class="box-container">
    <header class="container">
      <div class="w-full mx-auto grid grid-cols-3   justify-between py-4  items-center">
        <div class="col-span-1">
          <button
            @click="cancelProcess"
            class="border border-gray-400 rounded px-4 py-3 text-gray-600 hover:bg-gray-100"
          >
            Cancelar Proceso
          </button>
        </div>
        <div class="col-span-1 mx-auto">
          <img
            src="../static/asset/Logo.webp"
            width="510"
            height="104"
            class="w-[200px] h-auto text-center"
            alt="Logo nelly"
            title="Logo  nelly"
          />
        </div>
        
      </div>
    </header>

    <section class="container">
      <div
        class="max-w-screen-lg mx-auto flex justify-between items-center border-b border-gray-200 my-10 font-semibold"
      >
        <router-link to="/layout-designer/" exact class="nav-link"
          >Logo & Colores</router-link
        >
        <router-link to="/layout-designer/add-vehicles" exact class="nav-link"
          >Agregar Vehículos</router-link
        >
        <router-link to="/layout-designer/review" exact class="nav-link"
          >Previsualizar</router-link
        >
      </div>
    </section>
  </div>
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
/* Caja principal */
.box-container {
  max-width: 1024px; /* Ancho máximo */
  margin: 0 auto; /* Centrar horizontalmente */
}

header {
  background-color: white;
}

a {
  font-size: 16px;
}

/* Estilo por defecto para los links */
.nav-link {
  color: #6b7280; /* color gris */
  padding: 0.5rem;
  text-decoration: none;
}

/* Estilo activo para el link seleccionado */
.router-link-active {
  color: #f97316; /* color naranja */
  border-bottom: 2px solid #f97316; /* Línea debajo del link activo */
}

</style>
