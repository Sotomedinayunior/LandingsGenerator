<template>
  <div class="lg:ml-64 p-4">
    <!-- Mostrar indicador de carga mientras se está procesando -->
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

    <!-- Contenido principal del componente -->
    <div v-else>
      <div
        class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
      >
        <h1 class="font-bold text-xl">Características Adicionales</h1>
        <div
          class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0"
        >
          <!-- Campo de búsqueda -->
          <div class="relative">
            <input
              type="text"
              placeholder="Característica"
              v-model="searchTerm"
              class="p-2 pr-10 border border-gray-300 rounded-md focus:outline-none placeholder:text-sm w-full sm:w-auto"
            />
            <svg
              class="absolute inset-y-2 right-2 w-5 h-5 text-gray-500"
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
    </div>

    <!-- Botón para agregar característica -->
    <section class="flex justify-center mb-4">
      <button
        type="button"
        class="bg-orange-500 text-white px-4 py-2 rounded"
        @click="visible = true"
      >
        Agregar Característica
      </button>
    </section>

    <!-- Diálogo para agregar característica -->
    <div
      v-if="visible"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded shadow-lg" style="width: 25rem;">
        <h2 class="font-bold mb-4">Agregar Característica</h2>
        <span class="text-gray-600 block mb-4"
          >Agrega una característica especial</span
        >
        <div class="flex items-center gap-4 mb-4">
          <label for="nombre" class="font-semibold w-24">Nombre</label>
          <input
            id="nombre"
            v-model="newFeature.name"
            class="flex-auto border border-gray-300 rounded-md p-2"
            autocomplete="off"
          />
        </div>
        <div class="flex items-center gap-4 mb-8">
          <label for="descripcion" class="font-semibold w-24"
            >Descripción</label
          >
          <input
            id="descripcion"
            v-model="newFeature.description"
            class="flex-auto border border-gray-300 rounded-md p-2"
            autocomplete="off"
          />
        </div>
        <div class="flex justify-end gap-2">
          <button
            type="button"
            class="bg-gray-300 text-black px-4 py-2 rounded"
            @click="visible = false"
          >
            Cancelar
          </button>
          <button
            type="button"
            class="bg-blue-500 text-white px-4 py-2 rounded"
            @click="saveFeature"
          >
            Guardar
          </button>
        </div>
      </div>
    </div>

    <!-- Sección de características -->
    <section>
      <div class="grid grid-cols-8 sm:grid-cols-2 lg:grid-cols-8 gap-4">
        <span
          v-for="(feature, index) in filteredFeatures"
          :key="feature.id"
          class="bg-gray-200 text-gray-700 px-2 py-1 text-xs rounded inline-flex items-center justify-between"
          style="max-width: 100%;"
        >
          {{ feature.name }}
          <button
            type="button"
            class="ml-2 text-red-500"
            @click="removeFeature(index, feature.id)"
          >
            &times;
          </button>
        </span>
      </div>
      <div
        v-if="showToast"
        id="toast-container"
        class="fixed top-0 right-0 p-4 z-50"
      >
        <div
          id="toast-success"
          class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
          role="alert"
        >
          <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
          >
            <svg
              class="w-5 h-5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"
              />
            </svg>
            <span class="sr-only">Check icon</span>
          </div>
          <div class="ms-3 text-sm font-normal">
            Vehículo agregado con éxito.
          </div>
          <button
            type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            @click="closeToast"
            aria-label="Close"
          >
            <span class="sr-only">Close</span>
            <svg
              class="w-3 h-3"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
          </button>
        </div>
      </div>
      <div
        v-if="DeleteToast"
        id="toast-container"
        class="fixed top-0 right-0 p-4 z-50"
      >
        <div
          id="toast-success"
          class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
          role="alert"
        >
          <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-white bg-green-100 rounded-lg dark:bg-red-800 dark:text-green-200"
          >
            <svg
              class="w-5 h-5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"
              />
            </svg>
            <span class="sr-only">Check icon</span>
          </div>
          <div class="ms-3 text-sm font-normal">
            Borrado exitoso.
          </div>
          <button
            type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            @click="closeToast"
            aria-label="Close"
          >
            <span class="sr-only">Close</span>
            <svg
              class="w-4 h-4"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Axios from "../axios";

export default {
  data() {
    return {
      showToast: false,
      DeleteToast: false,
      loading: true,
      visible: false,
      errorModalVisible: false,
      errorMessage: "",
      deleteErrorModalVisible: false,
      deleteErrorMessage: "",
      searchTerm: "",
      newFeature: {
        name: "",
        description: "",
      },
      features: [],
      filteredFeatures: [],
    };
  },
  mounted() {
    this.fetchFeatures();
  },
  methods: {
    async fetchFeatures() {
      this.loading = true;
      try {
        const response = await Axios.get("/special-features");
        this.features = response.data;
        console.log("Características recibidas:", response.data); // Agregar este log

        this.filteredFeatures = response.data;

      } catch (error) {
        console.error("Error al obtener características:", error);
      } finally {
        this.loading = false;
      }
    },

    async saveFeature() {
      try {
        const response = await Axios.post("/special-features", this.newFeature);
        console.log("Característica guardada:", response.data);
        this.visible = false;
        this.newFeature.name = "";
        this.newFeature.description = "";
        await this.fetchFeatures();
        // Mostrar el toast
        this.showToast = true;

        // Ocultar el toast después de unos segundos
        setTimeout(() => {
          this.showToast = false; // Esto oculta el toast
        }, 3000); // 3000 ms = 3 segundos
      } catch (error) {
        console.error("Error al guardar la característica:", error);
        this.errorMessage =
          "Error al crear la característica. Inténtalo de nuevo.";
        this.errorModalVisible = true; // Mostrar modal de error
      }
    },

    filterFeatures() {
      this.filteredFeatures = this.features.filter((feature) => {
        return feature.name
          .toLowerCase()
          .includes(this.searchTerm.toLowerCase());
      });
    },

    async removeFeature(index, featureId) {
      try {
        await Axios.delete(`/special-features/${featureId}`);
        this.features.splice(index, 1);
        this.filteredFeatures = this.features;
        // Mostrar el toast
        this.DeleteToast = true;

        // Ocultar el toast después de unos segundos
        setTimeout(() => {
          this.DeleteToast = false; // Esto oculta el toast
        }, 3000); // 3000 ms = 3 segundos
      } catch (error) {
        console.error("Error al eliminar la característica:", error);
        this.deleteErrorMessage =
          "Error al eliminar la característica. Inténtalo de nuevo.";
        this.deleteErrorModalVisible = true; // Mostrar modal de error
      }
    },
  },

  watch: {
    searchTerm(newTerm) {
      this.filterFeatures();
    },
  },
};
</script>

<style>

</style>
