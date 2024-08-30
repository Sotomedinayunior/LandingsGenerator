<template>
  <section class="lg:ml-64 p-4">
    <!-- Encabezado de la sección -->
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-bold text-3xl">Localizaciones</h1>
    </div>

    <!-- Selección de landing -->
    <div class="flex flex-col">
      <select v-model="selectedLanding" class="mb-4 p-2 border border-gray-300 rounded">
        <option disabled selected>Selecciona una landing para tus localizaciones</option>
        <option v-for="landing in landings" :key="landing.id" :value="landing">
          {{ landing.name }}
        </option>
      </select>

      <!-- Informacion de la landing seleccionada -->
      <div v-if="selectedLanding" class="flex flex-col">
        <!-- pickUp de datos -->
        <section class="w-full bg-blue-800 p-4 rounded-lg mb-4">
          <div class="flex flex-row bg-white p-3 shadow-lg items-center justify-between">
            <div class="flex flex-col mb-4">
              <label for="place_of_departure" class="text-blue-800">lugar de salida</label>
              <select v-model="placeOfDeparture" name="place_of_departure" class="appearance-none p-2 rounded-lg border text-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none">
                <option disabled selected>Selecciona lugar de salida</option>
                <option v-for="option in selectedLanding.place_of_departure" :key="option" :value="option">
                  {{ option }}
                </option>
              </select>
            </div>
            <div class="flex flex-col mb-4">
              <label for="arrival_place" class="text-blue-800">lugar de retorno</label>
              <select v-model="arrivalPlace" name="arrival_place" class="appearance-none p-2 rounded-lg border text-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none">
                <option disabled selected>Selecciona un lugar diferente de salida</option>
                <option v-for="option in selectedLanding.arrival_place" :key="option" :value="option">
                  {{ option }}
                </option>
              </select>
            </div>
          </div>
        </section>

        <!-- formulario de localizaciones -->
        <form @submit.prevent="updatePlaces">
          <div class="space-y-2">
            <div class="">
              <h2 class="text-base font-semibold leading-7 text-gray-900">Agrega las localizaciones</h2>
              <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                  <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Lugar de salida</label>
                  <div class="mt-2">
                    <input v-model="placeOfDeparture" type="text" name="punto de partida" id="first-name" autocomplete="given-name" class="focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Lugar de retorno</label>
                  <div class="mt-2">
                    <input v-model="arrivalPlace" type="text" name="lugar de llegada" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 focus:outline-none"  />
                  </div>
                </div>
                <div class="flex">
                  <button type="submit" class="bg-[#f16822] text-white px-4 py-2 rounded-md hover:bg-[#d5551d]">Agregar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- Mensaje cuando no hay landing seleccionada -->
      <p v-else class="text-gray-500 mt-4">Selecciona una landing para ver los detalles y opciones de lugar de salida.</p>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                  {{ modalMessage }}
                </h3>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="showModal = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
              Cerrar
            </button>
          </div>
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
      placeOfDeparture: '',
      arrivalPlace: '',
      showModal: false,
      modalMessage: ''
    };
  },
  created() {
    this.getLandingsData();
  },
  methods: {
    getLandingsData() {
      let userId = localStorage.getItem("NellyUserId");
      Axios.get(`/api/landing/${userId}`)
        .then((response) => {
          // Verifica y corrige el formato de los datos
          this.landings = response.data.map(landing => {
            return {
              ...landing,
              place_of_departure: Array.isArray(landing.place_of_departure) ? landing.place_of_departure : [landing.place_of_departure],
              arrival_place: Array.isArray(landing.arrival_place) ? landing.arrival_place : [landing.arrival_place]
            };
          });
        })
        .catch((error) => {
          console.error("Error al obtener landings:", error);
        });
    },
    updatePlaces() {
      if (!this.selectedLanding) return;

      const data = {
        place_of_departure: this.placeOfDeparture,
        arrival_place: this.arrivalPlace
      };

      // Agregar logs para depuración
      console.log("Datos enviados:", data);
      console.log("ID de la landing seleccionada:", this.selectedLanding.id);

      Axios.post(`/api/landings/${this.selectedLanding.id}/addLocation`, data)
        .then((response) => {
          console.log("Respuesta de la API:", response);
          this.modalMessage = "Places added successfully";
          this.showModal = true;
          this.clearInputs();
        })
        .catch((error) => {
          console.error("Error al agregar lugares:", error);
          this.modalMessage = "Error adding places";
          this.showModal = true;
        });
    },
    clearInputs() {
      this.placeOfDeparture = '';
      this.arrivalPlace = '';
    }
  }
};
</script>

<style scoped>
/* Agrega estilos personalizados aquí */
</style>