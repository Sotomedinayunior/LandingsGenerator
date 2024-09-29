<template>
  <section class="lg:ml-64 p-4">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-bold text-3xl">
        Tus Landings
      </h1>
      <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0">
        <!-- Campo de búsqueda -->
        <div class="relative">
          <input
            type="text"
            placeholder="Buscar un landing"
            v-model="searchTerm"
            class="p-2 pr-5 border border-gray-500 rounded-md focus:outline-none placeholder:text-sm w-full sm:w-auto"
          />
          <!-- SVG de lupa -->
          <svg
            class="absolute inset-y-2 right-1 w-6 h-6 text-gray-500"
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
      Cargando...
    </div>

    <!-- Mostrar mensaje si no hay landings -->
    <div v-else-if="filteredLandings.length === 0" class="flex justify-center items-center">
      <p>No hay landings creadas.</p>
    </div>

    <!-- Iterar sobre los landings y mostrar CardLanding para cada uno -->
    <div v-else class="grid grid-cols-3 gap-2">
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
import ButtonDefault from "../components/ButtonDefault.vue";
import CardLanding from "../components/CardLanding.vue";

export default {
  components: { ButtonDefault, CardLanding },
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
      return Array.isArray(this.landings) ? this.landings.filter(landing =>
        landing.name.toLowerCase().includes(this.searchTerm.toLowerCase())
      ) : [];
    },
  },
  methods: {
    getLandingsData() {
      let userId = localStorage.getItem('NellyUserId');
      Axios.get(`/api/landing/${userId}`)
        .then(response => {
          // Asegurarse de que la respuesta es un array
          this.landings = Array.isArray(response.data) ? response.data : [];
        })
        .catch(error => {
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
      this.landings = this.landings.filter(landing => landing.id !== id);
    },
  },
};
</script>

<style scoped>
/* Estilos adicionales específicos si son necesarios */
</style>
