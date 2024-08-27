<template>
  <div
    class="w-full flex flex-row	 items-center justify-between	p-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
  >
    <div class="flex items-center gap-2	">
      <img :src="landing.logo" :alt="landing.name" class="w-12 h-12">
      <h2 class="text-base font-bold text-orange-600">{{landing.name}}</h2>
    </div>

    <!-- Botones para restaurar o eliminar -->
    <div class="flex justify-end space-x-3 mt-4">
      <button
        @click="$emit('restore', landing.id)"
        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-600"
      >
        Restaurar
      </button>
      <button
        @click="$emit('delete', landing.id)"
        class="px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-600"
      >
        Eliminar
      </button>
    </div>
  </div>
</template>

<script>
import Axios from "../axios";

export default {
  name: "CardDeleteLanding",
  props: {
    landing: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
/* Agrega estilos específicos si es necesario */
</style>
