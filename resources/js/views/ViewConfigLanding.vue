<template>
  <section class="lg:ml-64 p-4">
    <div class="flex justify-between">
      <div class="flex">
        <div>
          <!-- Icono de flecha apuntando a la izquierda -->
          <i
            class="fas fa-arrow-left text-gray-800 cursor-pointer"
            @click="goBack"
          ></i>
        </div>
        <div class="flex items-center ml-4">
          <img
            :src="landing.logo"
            :alt="landing.name"
            class="w-10 h-10"
            loading="eager"
          />
          <h1 class="font-semibold text-2xl ml-2">{{ landing.name }}</h1>
        </div>
      </div>
      <div class="flex space-x-6 items-center">
        <div class="flex flex-col items-center">
          <!-- Icono de carro -->
          <div class="flex items-center">
            <i class="fas fa-car text-gray-800"></i>
            <span class="ml-1">{{ landing.vehicles.length }}</span>
          </div>
          <span class="text-sm text-gray-600">Vehículos</span>
        </div>
        <div class="border-l h-12 mx-4"></div> <!-- Línea vertical de separación -->
        <div class="flex flex-col items-center">
          <!-- Icono de libro -->
          <div class="flex items-center">
            <i class="fas fa-book text-gray-800"></i>
            <span class="ml-1">{{ landing.reservations.length }}</span>
          </div>
          <span class="text-sm text-gray-600">Reservas</span>
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
      landing: {
        vehicles: [],  // Inicializar como array vacío
        reservations: [], // Inicializar como array vacío
        logo: "", // Inicializar como cadena vacía
        name: ""  // Inicializar como cadena vacía
      },
    };
  },
  created() {
    this.fetchLanding();
  },
  methods: {
    async fetchLanding() {
      try {
        const userId = localStorage.getItem('NellyUserId');
        const landingId = this.$route.params.id; // Obteniendo el ID de la landing desde la URL
        const response = await Axios.get(`/api/landings/${userId}/${landingId}`);
        this.landing = response.data;
      } catch (error) {
        console.error('Error fetching landing:', error);
      }
    },
    goBack() {
      this.$router.go(-1); // Navegar hacia atrás
    }
  }
};
</script>

<style scoped>
/* Añadir cualquier estilo adicional aquí */
</style>
