<template>
  <div>
    <!-- Card Component -->
    <div 
      class="max-w-sm p-6    cursor-pointer  rounded-2xl bg-[#FAF8F6]" 
      @click="handle(landing.id)"
    >
      <div class="flex justify-between">
        <div class="flex">
          <img :src="landing.logo" :alt="landing.name" loading="lazy" class="w-11 h-11" />
          <div class="ml-3">
            <h2 class="text-lg font-bold">{{ landing.name }}</h2>
            <p class="text-xs text-wrap">{{ `https://${landing.name}.com` }}</p>
          </div>
        </div>
        <!-- Trash Icon -->
        <i class="fas fa-trash w-4 h-4" @click.stop="showModal = true"></i>
      </div>
      <div class="flex justify-between mt-4">
        <!-- Expand Icon -->
        <img src="../static/asset/click.svg" alt="click expan nelly app" class="w-4 h-4 mt-2">
        <div class="flex  items-center space-x-2">
          <!-- Truck Icon -->
          <img src="../static/asset/cart.svg" alt="cart nelly app" class="w-4 h-4"> <span class="font-xs">{{ landing.vehicles.length }}</span>
          <!-- Book Icon -->
          <i class="fas fa-book w-4 h-4"></i>
          <span class="font-xs">{{ landing.reservations.length }}</span> 
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
      Axios.delete(`api/landing/${id}`)
        .then((response) => {
          this.$emit('deleted', id); // Emite un evento cuando se elimina el landing
          this.showModal = false;
        })
        .catch((error) => {
          console.error("Error al eliminar el landing:", error.response ? error.response.data : error.message);
        });
    }
  }
}
</script>

<style scoped>
/* Agrega aquí estilos específicos si es necesario */
</style>
