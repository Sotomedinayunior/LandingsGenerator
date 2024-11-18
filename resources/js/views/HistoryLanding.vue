<template>
  <section class="lg:ml-64 p-4">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-bold text-xl">
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

    <!-- Mostrar un spinner mientras los landings se están cargando -->
    <div v-if="isLoading" class="mt-6 text-center">
      <p>Cargando landings eliminadas...</p>
    </div>

    <!-- Mostrar el componente CardDeleteLanding o un mensaje si no hay resultados y la carga terminó -->
    <div v-else>
      <div v-if="filteredLandings.length > 0" class="mt-6 grid grid-cols-1 gap-4">
        <CardDeleteLanding
          v-for="landing in filteredLandings"
          :key="landing.id"
          :landing="landing"
          @restore="openRestoreModal"
          @delete="openDeleteModal"
        />
      </div>
      <p v-else class="mt-6 text-red-500 text-center">
        No se encontraron landings eliminadas.
      </p>
    </div>

    <!-- Modal de restauración -->
    <div
      v-if="showRestoreModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-md shadow-md">
        <p class="text-lg mb-4">Landing restaurada con éxito</p>
        <button
          @click="closeRestoreModal"
          class="px-4 py-2 bg-blue-500 text-white rounded-md"
        >
          Cerrar
        </button>
      </div>
    </div>

    <!-- Modal de confirmación para eliminación -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded-md shadow-md">
        <p class="text-lg mb-4">
          ¿Estás seguro de eliminar esta landing? Este proceso es irreversible.
        </p>
        <div class="flex justify-end space-x-4">
          <button
            @click="confirmDelete"
            class="px-4 py-2 bg-red-500 text-white rounded-md"
          >
            Eliminar
          </button>
          <button
            @click="closeDeleteModal"
            class="px-4 py-2 bg-gray-500 text-white rounded-md"
          >
            Cancelar
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import CardDeleteLanding from "../components/CardDeleteLanding.vue";
import Axios from "../axios";

export default {
  components: { CardDeleteLanding },
  data() {
    return {
      landings: [], // Array para almacenar las landings eliminadas
      searchTerm: "", // Término de búsqueda
      isLoading: true, // Indicador de carga
      showRestoreModal: false, // Modal de restauración
      showDeleteModal: false, // Modal de confirmación de eliminación
      selectedLandingId: null, // ID de la landing seleccionada
    };
  },
  computed: {
    filteredLandings() {
      return this.landings.filter(
        (landing) =>
          landing.name &&
          landing.name.toLowerCase().includes(this.searchTerm.toLowerCase())
      );
    },
  },
  methods: {
    fetchDeletedLandings() {
      let userId = localStorage.getItem("NellyUserId");
      if (userId) {
        Axios.get(`/landing/deleted/${userId}`)
          .then((response) => {
            this.landings = response.data;
            this.isLoading = false; 
          })
          .catch((error) => {
            console.error("Error fetching deleted landings:", error);
            this.isLoading = false; 
          });
      } else {
        console.error("User ID is missing from localStorage.");
        this.isLoading = false;
      }
    },

    openRestoreModal(id) {
      this.selectedLandingId = id;
      this.restoreLanding(id);
    },

    restoreLanding(id) {
      Axios.post(`/landing/restore/${id}`)
        .then(() => {
          // Eliminar manualmente la landing restaurada del array local
          this.landings = this.landings.filter(landing => landing.id !== id);
          this.showRestoreModal = true;
        })
        .catch((error) => {
          console.error("Error restoring landing:", error);
        });
    },

    closeRestoreModal() {
      this.showRestoreModal = false;
    },

    openDeleteModal(id) {
      this.selectedLandingId = id;
      this.showDeleteModal = true;
    },

    confirmDelete() {
      this.deleteLanding(this.selectedLandingId);
    },

    deleteLanding(id) {
      Axios.delete(`/landing/deletedFinal/${id}`)
        .then(() => {
          this.showDeleteModal = false;
          this.landings = this.landings.filter(landing => landing.id !== id);
          this.fetchDeletedLandings(); // Actualizar la lista después de eliminar
        })
        .catch((error) => {
          console.error("Error deleting landing:", error);
        });
    },

    closeDeleteModal() {
      this.showDeleteModal = false;
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
