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
        <h1 class="font-bold text-3xl">Características Adicionales</h1>
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
    <section class="flex justify-center">
      <Button
        type="button"
        label="Agregar Característica"
        icon="pi pi-plus"
        @click="visible = true"
      />
      <Dialog
        v-model:visible="visible"
        modal
        header="Agregar Característica"
        :style="{ width: '25rem' }"
      >
        <span class="text-surface-500 dark:text-surface-400 block mb-8">
          Agrega una característica especial
        </span>
        <div class="flex items-center gap-4 mb-4">
          <label for="nombre" class="font-semibold w-24">Nombre</label>
          <InputText
            id="nombre"
            v-model="newFeature.name"
            class="flex-auto"
            autocomplete="off"
          />
        </div>
        <div class="flex items-center gap-4 mb-8">
          <label for="descripcion" class="font-semibold w-24"
            >Descripción</label
          >
          <InputText
            id="descripcion"
            v-model="newFeature.description"
            class="flex-auto"
            autocomplete="off"
          />
        </div>
        <div class="flex justify-end gap-2">
          <Button
            type="button"
            label="Cancel"
            severity="secondary"
            @click="visible = false"
          />
          <Button type="button" label="Guardar" @click="saveFeature" />
        </div>
      </Dialog>
    </section>
    <section>
      <div class="grid grid-cols-8 sm:grid-cols-2 lg:grid-cols-8 gap-4">
        <Chip
          v-for="(feature, index) in filteredFeatures"
          :key="feature.id"
          :label="feature.name"
          class="p-1"
          removable
          @remove="removeFeature(index, feature.id)"
        />
      </div>
    </section>
    <Toast ref="toast" position="bottom-right" group="br" />

  </div>
</template>

<script>
import Axios from "../axios";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Card from "primevue/card";

import Chip from "primevue/chip";
import Toast from "primevue/toast";

import InputText from "primevue/InputText";

export default {
  components: {
    Button,
    Dialog,
    
    Card,
    InputText,
    Chip,
    Toast
  },
  data() {
    return {
      loading: true, // Estado de carga
      visible: false, // Controla la visibilidad del diálogo
      searchTerm: "", // Término de búsqueda
      newFeature: {
        name: "",
        description: "",
      }, // Datos de la nueva característica
      features: [], // Almacena las características existentes
      filteredFeatures: [], // Almacena las características filtradas
    };
  },
  mounted() {
    this.fetchFeatures(); // Llama a fetchFeatures al montar el componente
  },
  methods: {
    // Método para obtener las características existentes
    async fetchFeatures() {
      this.loading = true; // Muestra el indicador de carga
      try {
        const response = await Axios.get("/api/features");
        this.features = response.data; // Almacena las características
        this.filteredFeatures = response.data; // Inicializa las características filtradas
      } catch (error) {
        console.error("Error al obtener características:", error);
      } finally {
        this.loading = false; // Cambia el estado de carga a falso
      }
    },

    // Método para guardar una nueva característica
    async saveFeature() {
      try {
        const response = await Axios.post("/api/features", this.newFeature);
        console.log("Característica guardada:", response.data);
        this.visible = false; // Cierra el diálogo
        // Resetear los campos
        this.newFeature.name = "";
        this.newFeature.description = "";
        await this.fetchFeatures(); // Actualiza la lista de características
        this.$refs.toast.add({
          severity: "success",
          summary: "Éxito",
          detail: "Característica guardada",
        });
      } catch (error) {
        console.error("Error al guardar la característica:", error);
      }
    },

    // Método para filtrar las características basadas en el término de búsqueda
    filterFeatures() {
      this.filteredFeatures = this.features.filter((feature) => {
        return feature.name
          .toLowerCase()
          .includes(this.searchTerm.toLowerCase());
      });
    },
    // Método para eliminar una característica
    async removeFeature(index, featureId) {
      try {
        // Eliminar del servidor
        await Axios.delete(`/api/features/${featureId}`);
        // Remover la característica del array local
        this.features.splice(index, 1);
        this.filteredFeatures = this.features; // Actualiza la lista filtrada
        this.$refs.toast.add({
          severity: "success",
          summary: "Éxito",
          detail: "Característica eliminada",
        });
      } catch (error) {
        console.error("Error al eliminar la característica:", error);
      }
    },
  },

  watch: {
    // Observador para el término de búsqueda
    searchTerm(newTerm) {
      this.filterFeatures(); // Filtra las características cada vez que cambia el término
    },
  },
};
</script>
