<template>
  <section class="lg:ml-64 p-4">
    <!-- Cargando -->
    <div v-if="loading" class="flex justify-center items-center h-screen">
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

    <!-- Selección de landing -->
    <div
      v-else
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
    >
      <h1 class="font-bold text-xl">Localizaciones</h1>
    </div>

    <div class="flex flex-col">
      <select
        v-model="selectedLanding"
        class="mb-4 p-2 border border-gray-300 rounded"
      >
        <option disabled value=""
          >Selecciona una landing para tus localizaciones</option
        >
        <option v-for="landing in landings" :key="landing.id" :value="landing">
          {{ landing.name }}
        </option>
      </select>

      <!-- Información de la landing seleccionada -->
      <div v-if="selectedLanding" class="flex flex-col">
        <section class="flex justify-start mb-4">
          <button
            type="button"
            class="bg-orange-500 text-white px-4 py-2 rounded"
            @click="visible = true"
          >
            Agregar Localizaciones
          </button>
        </section>
        <section class="grid grid-cols-8 justify-between">
          <!-- Lugar de Salida y Llegada -->
          <div class="flex justify-between">
            <!-- Verificar si hay localizaciones -->
            <template v-if="selectedLanding.locations.length > 0">
              <span
                v-for="(location, index) in selectedLanding.locations"
                :key="location.id"
                class="max-w-60 mx-3 bg-gray-200 text-gray-700 px-2 py-1 text-xs rounded inline-flex items-center justify-between"
              >
                {{ location.place_of_departure }}
              </span>
            </template>
            <!-- Mostrar mensaje si no hay localizaciones -->
            <template v-else>
              <h2 class="text-red-500 text-xs"
                >No hay localizaciones disponibles para esta landing.</h2
              >
            </template>
          </div>
        </section>
      </div>
    </div>

    <!-- Modal para agregar nuevas localizaciones -->
    <div
      v-if="visible"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded shadow-lg" style="width: 25rem;">
        <h2 class="font-bold mb-4">Agregar Localizaciones</h2>
        <span class="text-gray-600 block mb-4">Agrega una localización</span>

        <!-- Formulario para agregar localizaciones -->
        <div class="flex items-center gap-4 mb-4">
          <label for="location" class="font-semibold w-24">Localización</label>
          <input
            id="location"
            v-model="location"
            class="flex-auto border border-gray-300 rounded-md p-2"
            autocomplete="on"
          />
        </div>

        <!-- Botones del Modal -->
        <div class="flex justify-center gap-2">
          <button
            type="button"
            class="bg-gray-300 text-black px-4 py-2 rounded"
            @click="visible = false"
          >
            Cancelar
          </button>
          <button
            type="button"
            class="bg-[#F57200] text-white px-4 py-2 rounded"
            @click="updatePlaces"
          >
            Guardar
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "../axios";

export default {
  data() {
    return {
      landings: [],
      selectedLanding: null,
      location: "", // Solo un campo para la localización
      visible: false,
      loading: true,
    };
  },
  created() {
    this.getLandingsData();
  },
  methods: {
    // Obtén las landings de la API
    getLandingsData() {
      let userId = localStorage.getItem("NellyUserId");
      Axios.get(`/landing/${userId}`)
        .then((response) => {
          this.landings = response.data.map((landing) => {
            return {
              ...landing,
              locations: Array.isArray(landing.locations)
                ? landing.locations
                : [],
            };
          });
        })
        .catch((error) => {
          console.error("Error al obtener landings:", error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    // Actualiza las localizaciones con la API
    updatePlaces() {
      if (!this.selectedLanding) return;

      const data = {
        place_of_departure: this.location,
        arrival_place: this.location, // Usar el mismo valor para ambos
      };

      Axios.post(`/landings/${this.selectedLanding.id}/addLocation`, data)
        .then((response) => {
          this.selectedLanding.locations.push({
            place_of_departure: this.location,
            arrival_place: this.location,
          });
          this.location = ""; // Limpiar el campo
          this.visible = false;
        })
        .catch((error) => {
          console.error("Error al agregar localización:", error);
        });
    },

    // Elimina una localización
    removeLocation(index) {
      if (!this.selectedLanding) return;

      Axios.delete(`/landing/${this.selectedLanding.id}/locations`)
        .then(() => {
          this.selectedLanding.locations.splice(index, 1);
        })
        .catch((error) => {
          console.error("Error al eliminar localización:", error);
        });
    },
  },
};
</script>

<style scoped>
/* Agrega los estilos que necesites */
</style>
