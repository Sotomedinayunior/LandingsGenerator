<template>
  <header class="flex p-4 justify-between items-center">
    <div class="flex pl-9 py-2">
      <button
        @click="cancelProcess"
        class="border border-gray-400 rounded px-4 py-3 text-gray-600 hover:bg-gray-100"
      >
        Cancelar Proceso
      </button>
    </div>
    <div class="flex justify-start items-center mr-32">
      <img
        src="../static/asset/Logo.webp"
        width="510"
        height="104"
        class="w-[200px] h-auto text-center"
        alt="Logo nelly"
      />
    </div>
    <div class="hi"></div>
  </header>

  <section
    class="flex justify-around items-center border-b border-gray-200 my-10 font-semibold"
  >
    <router-link to="/layout-designer/" exact class="nav-link"
      >Logo & Colors</router-link
    >
    <router-link to="/layout-designer/add-vehicles" exact class="nav-link"
      >Add Vehicles</router-link
    >
    <router-link to="/layout-designer/review" exact class="nav-link"
      >Review</router-link
    >
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
