<template>
  <section class="lg:ml-64 p-4">
    <div
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
    >
      <h1 class="font-bold text-xl">
        Tus Landings
      </h1>
      <div
        class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0"
      >
        <!-- Campo de búsqueda -->
        <div class="relative">
          <input
            type="text"
            placeholder="Buscar un landing"
            v-model="searchTerm"
            class="px-3 py-2 border border-gray-500 rounded-md focus:outline-none placeholder:text-sm w-full sm:w-auto"
          />
          <!-- SVG de lupa -->
          <svg
            class="absolute inset-y-2 right-3 w-6 h-6 text-gray-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM21 21l-4.35-4.35"
            />
          </svg>
        </div>
        <ButtonDefault @click="addLanding" />
      </div>
    </div>

    <!-- Mostrar indicador de carga mientras se obtienen los datos -->
    <div v-if="loading" class="flex justify-center items-center">
      <div role="status">
        <svg
          aria-hidden="true"
          class="inline w-16 h-16 text-gray-200 animate-spin dark:text-gray-600"
          style="fill: #f16822;"
          viewBox="0 0 100 101"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
            fill="currentColor"
          />
          <path
            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
            fill="currentFill"
          />
        </svg>
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <!-- Mostrar mensaje si no hay landings -->
    <div
      v-else-if="filteredLandings.length === 0"
      class="flex justify-center items-center"
    >
      <p class="text-base text-gray-400">No hay landings creadas.</p>
    </div>

    <!-- Iterar sobre los landings y mostrar CardLanding para cada uno -->
    <div v-else class="wrapper">
      <CardLanding
        v-for="landing in filteredLandings"
        :key="landing.id"
        :landing="landing"
        @deleted="handleDeleted"
      />
    </div>
  </section>
</template>

<script>
import Axios from "../axios";
import { defineAsyncComponent } from 'vue';

export default {
  components: {
    ButtonDefault: defineAsyncComponent(() => import("../components/ButtonDefault.vue")),
    CardLanding: defineAsyncComponent(() => import("../components/CardLanding.vue")),
  },
  data() {
    return {
      searchTerm: "", // Término de búsqueda
      landings: [], // Array vacío para almacenar los landings
      loading: true, // Estado de carga
    };
  },
  created() {
    this.getLandingsData();
  },
  computed: {
    filteredLandings() {
      // Asegurarse de que landings sea un array antes de filtrar
      return Array.isArray(this.landings)
        ? this.landings.filter((landing) =>
            landing.name.toLowerCase().includes(this.searchTerm.toLowerCase())
          )
        : [];
    },
  },
  methods: {
    getLandingsData() {
      let userId = localStorage.getItem("NellyUserId");
      Axios.get(`/landing/${userId}`)
        .then((response) => {
          // Asegurarse de que la respuesta es un array
          this.landings = Array.isArray(response.data) ? response.data : [];
        })
        .catch((error) => {
          // Manejo de errores si es necesario
          console.error("Error al obtener landings:", error);
          this.landings = []; // Asegurarse de que landings sea un array en caso de error
        })
        .finally(() => {
          this.loading = false; // Siempre desactivar el estado de carga al final
        });
    },
    handleDeleted(id) {
      // Actualiza la lista después de eliminar un landing
      this.landings = this.landings.filter((landing) => landing.id !== id);
    },
  },
};
</script>

<style scoped>
.wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1rem;
}
</style>
