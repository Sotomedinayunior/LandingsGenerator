<template>
  <div>
    <!-- Card Component -->
    <div 
      class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg cursor-pointer shadow dark:bg-gray-800 dark:border-gray-700" 
      @click="handle(landing.id)"
    >
      <div class="flex justify-between">
        <div class="flex">
          <img :src="landing.logo" :alt="landing.name" loading="lazy" class="w-10 h-10" />
          <div class="ml-3">
            <h2 class="text-lg font-semibold">{{ landing.name }}</h2>
            <p class="text-sm">{{ `https://${landing.name}.com` }}</p>
          </div>
        </div>
        <!-- Trash Icon -->
        <i class="fas fa-trash w-6 h-6 text-gray-500 dark:text-gray-400" @click.stop="showModal = true"></i>
      </div>
      <div class="flex justify-between mt-4">
        <!-- Expand Icon -->
        <i class="fas fa-expand w-6 h-6 text-gray-500 dark:text-gray-400"></i>
        <div class="flex space-x-4">
          <!-- Truck Icon -->
          <i class="fas fa-truck w-5 h-5 mr-1 text-gray-500 dark:text-gray-400"></i>  {{ landing.vehicles.length }}
          <!-- Book Icon -->
          <i class="fas fa-book w-5 h-5 mr-1 text-gray-500 dark:text-gray-400"></i>
          {{ landing.reservations.length }}
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
      <div class="bg-white p-6 border border-gray-300 rounded-lg shadow-lg z-60">
        <h2 class="text-lg font-semibold mb-4">Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este landing?</p>
        <div class="mt-4 flex justify-end space-x-4">
          <button 
            @click="deleteLanding(landing.id)"
            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
          >
            Eliminar
          </button>
          <button 
            @click="showModal = false"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400"
          >
            Cancelar
          </button>
        </div>
      </div>
    
    </div>
  </div>
</template>

<script>
import Axios from '../axios';

export default {
  name: "CardLanding",
  props: {
    landing: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      showModal: false // Estado del modal
    };
  },
  methods: {
    handle(id) {
      this.$router.push(`/view-landing/${id}`);
    },
    deleteLanding(id) {
      Axios.delete(`/landing/${id}`)
        .then((response) => {
          // Maneja la respuesta después de eliminar, por ejemplo, emite un evento para actualizar la lista
          this.$emit('deleted', id);
          this.showModal = false; // Cierra el modal después de eliminar
        })
        .catch((error) => {
          console.error("Error al eliminar el landing:", error);
        });
    }
  }
}
</script>

<style scoped>
/* Agrega aquí estilos específicos si es necesario */
</style>
