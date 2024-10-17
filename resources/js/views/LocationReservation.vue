<template>
  <section class="lg:ml-64 p-4">
    <!-- Encabezado de la sección -->
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
    <div
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4" v-else
    >
      <h1 class="font-bold text-3xl">Localizaciones</h1>
    </div>

    <!-- Selección de landing -->
    <div class="flex flex-col">
      <select
        v-model="selectedLanding"
        class="mb-4 p-2 border border-gray-300 rounded"
      >
        <option disabled selected
          >Selecciona una landing para tus localizaciones</option
        >
        <option v-for="landing in landings" :key="landing.id" :value="landing">
          {{ landing.name }}
        </option>
      </select>

      <!-- Informacion de la landing seleccionada -->
      <div v-if="selectedLanding" class="flex flex-col">
        <!-- pickUp de datos -->
        <section class="w-full bg-blue-800 p-4 rounded-lg mb-4">
          <div
            class="flex flex-row bg-white p-3 shadow-lg items-center justify-between"
          >
            <!-- Select Lugar de salida -->
            <div class="flex flex-col mb-4">
              <label for="place_of_departure" class="text-blue-800"
                >Lugar de salida</label
              >
              <select
                v-model="placeOfDeparture"
                name="place_of_departure"
                class="appearance-none p-2 rounded-lg border text-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
              >
                <option disabled selected>Selecciona lugar de salida</option>
                <option
                  v-for="option in selectedLanding.place_of_departure"
                  :key="option"
                  :value="option"
                >
                  {{ option }}
                </option>
              </select>
            </div>

            <!-- Select Lugar de retorno -->
            <div class="flex flex-col mb-4">
              <label for="arrival_place" class="text-blue-800"
                >Lugar de retorno</label
              >
              <select
                v-model="arrivalPlace"
                name="arrival_place"
                class="appearance-none p-2 rounded-lg border text-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
              >
                <option disabled selected
                  >Selecciona un lugar diferente de salida</option
                >
                <option
                  v-for="option in selectedLanding.arrival_place"
                  :key="option"
                  :value="option"
                >
                  {{ option }}
                </option>
              </select>
            </div>

            <!-- Select Asientos -->
            <div class="flex flex-col mb-4">
              <label for="seats" class="text-blue-800"
                >Número de Asientos</label
              >
              <select
                v-model="number_of_persons"
                name="number_of_persons"
                class="appearance-none p-2 rounded-lg border text-sm text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
              >
              <option disabled selected
                  >4</option
                >
              <option
                  v-for="option in selectedLanding.number_of_persons"
                  :key="option"
                  :value="option"
                >
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
              <h2 class="text-base font-semibold leading-7 text-gray-900">
                Agrega las localizaciones
              </h2>
              <div class="mt-1 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                  <label
                    for="first-name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Lugar de salida</label
                  >
                  <div class="mt-2">
                    <input
                      v-model="placeOfDeparture"
                      type="text"
                      name="punto de partida"
                      id="first-name"
                      autocomplete="given-name"
                      class="focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label
                    for="first-name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Asientos</label
                  >
                  <div class="mt-2">
                    <input
                      v-model="seats"
                      type="text"
                      name="number_of_persons"
                      id="first-name"
                      autocomplete="given-name"
                      class="focus:outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                  </div>
                </div>

                <div class="sm:col-span-3">
                  <label
                    for="last-name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Lugar de retorno</label
                  >
                  <div class="mt-2">
                    <input
                      v-model="arrivalPlace"
                      type="text"
                      name="lugar de llegada"
                      id="last-name"
                      autocomplete="family-name"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 focus:outline-none"
                    />
                  </div>
                </div>
                <div class="flex">
                  <button
                    type="submit"
                    class="bg-[#f16822] text-white px-4 py-2 rounded-md hover:bg-[#d5551d]"
                  >
                    Agregar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- Mensaje cuando no hay landing seleccionada -->
      <p v-else class="text-gray-500 mt-4">
        Selecciona una landing para ver los detalles y opciones de lugar de
        salida.
      </p>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div
        class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
      >
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span
          class="hidden sm:inline-block sm:align-middle sm:h-screen"
          aria-hidden="true"
          >&#8203;</span
        >
        <div
          class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
        >
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div
                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10"
              >
                <svg
                  class="h-6 w-6 text-green-600"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                  ></path>
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3
                  class="text-lg leading-6 font-medium text-gray-900"
                  id="modal-title"
                >
                  {{ modalMessage }}
                </h3>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button
              @click="showModal = false"
              type="button"
              class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
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
      placeOfDeparture: "",
      number_of_persons: 0,
      arrivalPlace: "",
      showModal: false,
      modalMessage: "",
      loading: true,
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
          this.landings = response.data.map((landing) => {
            return {
              ...landing,
              place_of_departure: Array.isArray(landing.place_of_departure)
                ? landing.place_of_departure
                : [landing.place_of_departure],
              arrival_place: Array.isArray(landing.arrival_place)
                ? landing.arrival_place
                : [landing.arrival_place],
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
    updatePlaces() {
      if (!this.selectedLanding) return;

      const data = {
        place_of_departure: this.placeOfDeparture,
        arrival_place: this.arrivalPlace,
        number_of_persons: this.number_of_persons || 4,
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
      this.placeOfDeparture = "";
      this.arrivalPlace = "";
      this.number_of_persons = 0;
    },
  },
};
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
.fade-in {
  animation: fadeIn 0.5s;
}
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
