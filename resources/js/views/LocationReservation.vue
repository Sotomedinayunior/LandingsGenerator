<template>
  <section class="lg:ml-64 p-4">
    <!-- Encabezado de la sección -->
    <div
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
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
      <div v-if="selectedLanding" class="flex flex-col ">
        <!-- pickUp de datos -->
        <section class="w-full bg-blue-800 p-4 rounded-lg mb-4 	">
          <div
            class="flex flex-row bg-white p-3 shadow-lg items-center justify-between"
          >
            <div class="flex flex-col mb-4">
              <label for="place_of_departure" class="text-blue-300"
                >lugar de salida</label
              >

              <select
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
            <div class="flex flex-col mb-4">
              <label for="place_of_departure" class="text-blue-300"
                >lugar de retorno</label
              >
              <select
                name="place_of_departure"
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
          </div>
        </section>

        <!-- formulario de localizaciones -->
        <form>
          <div class="space-y-2">
            <div class="">
              <h2 class="text-base font-semibold leading-7 text-gray-900">
                Agrega las localizaciones
              </h2>
              

              <div
                class="mt-1 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
              >
                <div class="sm:col-span-3">
                  <label
                    for="first-name"
                    class="block text-sm font-medium leading-6 text-gray-900"
                    >Lugar de salida</label
                  >
                  <div class="mt-2">
                    <input
                      type="text"
                      name="first-name"
                      id="first-name"
                      autocomplete="given-name"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
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
                      type="text"
                      name="last-name"
                      id="last-name"
                      autocomplete="family-name"
                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    />
                  </div>
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
  </section>
</template>

<script>
import Axios from "../axios";

export default {
  data() {
    return {
      landings: [],
      selectedLanding: null, // Inicializa con null para manejar la lógica condicional
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
          this.landings = response.data;
        })
        .catch((error) => {
          console.error("Error al obtener landings:", error);
        });
    },
  },
};
</script>

<style scoped>
/* Agrega estilos personalizados aquí */
</style>
