<template>
  <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <h2 class="text-lg font-semibold">{{ landing.name }}</h2>
    <p class="text-sm">{{ `https://${landing.name}.com` }}</p>
    <!-- Botones para restaurar o eliminar -->
    <div class="flex justify-end space-x-4 mt-4">
      <button 
        @click="$emit('restore', landing.id)"
        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
      >
        Restaurar
      </button>
      <button 
        @click="$emit('delete', landing.id)"
        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
      >
        Eliminar
      </button>
    </div>
  </div>
</template>

<script>
import Axios from '../axios';

export default {
  name: "CardDeleteLanding",
  props: {
    landing: {
      type: Object,
      required: true
    }
  },
};
</script>

<style scoped>
/* Agrega estilos específicos si es necesario */
</style>
