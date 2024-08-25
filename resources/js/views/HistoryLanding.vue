<template>
  <section class="lg:ml-64 p-4">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-semibold text-xl sm:text-sm md:text-2xl lg:text-4xl xl:text-5xl">
        Landings borradas
      </h1>
      <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0">
        <!-- Campo de búsqueda -->
        <div class="relative">
          <input
            type="text"
            placeholder="Buscar una landing eliminada"
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
      </div>
    </div>
      
    <!-- Mostrar el componente CardDeleteLanding o un mensaje si no hay resultados -->
    <div v-if="filteredLandings.length > 0" class="mt-6 grid grid-cols-1 gap-4">
      <CardDeleteLanding 
        v-for="landing in filteredLandings" 
        :key="landing.id" 
        :landing="landing"
        @restore="handleRestore"
        @delete="handleDelete"
      />
    </div>
    <p v-else class="mt-6 text-red-500">No se encontraron landings eliminadas.</p>
  </section>
</template>

<script>
import CardDeleteLanding from '../components/CardDeleteLanding.vue';
import Axios from '../axios';

export default {
  components: { CardDeleteLanding },
  data() {
    return {
      landings: [], // Array para almacenar las landings eliminadas
      searchTerm: '', // Término de búsqueda
    };
  },
  computed: {
    filteredLandings() {
      return this.landings.filter(landing => 
        landing.name.toLowerCase().includes(this.searchTerm.toLowerCase())
      );
    },
  },
  methods: {
    fetchDeletedLandings() {
      let userId = localStorage.getItem('NellyUserId');
      Axios.get(`api/landing/deleted/${userId}`)
        .then(response => {
          this.landings = response.data;
        })
        .catch(error => {
          console.error('Error fetching deleted landings:', error);
        });
    },
    handleRestore(id) {
      Axios.post(`/landing/restore/${id}`)
        .then(() => {
          // Actualizar la lista después de restaurar
          this.landings = this.landings.filter(landing => landing.id !== id);
        })
        .catch(error => {
          console.error('Error restoring landing:', error);
        });
    },
    handleDelete(id) {
      Axios.delete(`/landing/${id}`)
        .then(() => {
          // Actualizar la lista después de eliminar
          this.landings = this.landings.filter(landing => landing.id !== id);
        })
        .catch(error => {
          console.error('Error deleting landing:', error);
        });
    },
  },
  mounted() {
    this.fetchDeletedLandings();
  },
};
</script>

<style scoped>
/* Aquí puedes agregar tus estilos personalizados */
</style>
