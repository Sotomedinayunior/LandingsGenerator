<template>
  <section class="lg:ml-64 p-4">
    <div class="flex justify-between">
      <div class="flex items-center">
        <div>
          <i
            class="fas fa-arrow-left text-gray-800 cursor-pointer"
            @click="goBack"
            aria-label="Volver"
          ></i>
        </div>
        <div class="flex items-center ml-4">
          <img
            v-if="landing.logo"
            :src="landing.logo"
            :alt="landing.name"
            class="w-10 h-10"
            loading="lazy"
          />
          <h1 v-if="landing.name" class="font-semibold text-2xl ml-2">
            {{ landing.name }}
          </h1>
        </div>
      </div>
      <div class="flex space-x-6 items-center">
        <div class="flex flex-col items-center">
          <div class="flex items-center">
            <i class="fas fa-car text-gray-800" aria-label="Vehículos"></i>
            <span class="ml-1">{{ landing.vehicles.length }}</span>
          </div>
          <span class="text-sm text-gray-600">Vehículos</span>
        </div>
        <div class="border-l h-12 mx-4"></div>
        <div class="flex flex-col items-center">
          <div class="flex items-center">
            <i class="fas fa-book text-gray-800" aria-label="Reservas"></i>
            <span class="ml-1">{{ landing.reservations.length }}</span>
          </div>
          <span class="text-sm text-gray-600">Reservas</span>
        </div>
      </div>
    </div>

    <!-- Header with Tabs -->
    <div class="w-full flex mt-8">
      <button
        @click="activeTab = 'reservations'"
        :class="{
          'py-2 px-4': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold': activeTab === 'reservations',
          'text-gray-500': activeTab !== 'reservations'
        }"
      >
        Reservas ({{ landing.reservations.length }})
      </button>

      <button
        @click="activeTab = 'vehicles'"
        :class="{
          'py-2 px-4': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold': activeTab === 'vehicles',
          'text-gray-500': activeTab !== 'vehicles'
        }"
      >
        Vehículos ({{ landing.vehicles.length }})
      </button>

      <button
        @click="activeTab = 'config'"
        :class="{
          'py-2 px-4': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold': activeTab === 'config',
          'text-gray-500': activeTab !== 'config'
        }"
      >
        Configuración
      </button>
    </div>

    <!-- Tab Content -->
    <div class="container mx-auto mt-4 flex justify-center items-center">
      <!-- Loading State -->
      <div v-if="isLoading">Cargando datos...</div>

      <!-- Reservations Tab -->
      <TabReservation
        v-if="!isLoading && activeTab === 'reservations' && landing.reservations.length > 0"
        :reservations="landing.reservations"
      />
      <div v-if="!isLoading && activeTab === 'reservations' && landing.reservations.length === 0">
        No hay reservas disponibles.
      </div>

      <!-- Vehicles Tab -->
      <TabVehicle
        v-if="!isLoading && activeTab === 'vehicles' && landing.vehicles.length > 0"
        :vehicles="landing.vehicles"
      />
      <div v-if="!isLoading && activeTab === 'vehicles' && landing.vehicles.length === 0">
        No hay vehículos disponibles.
      </div>

      <!-- Config Tab -->
      <TabConfig v-if="!isLoading && activeTab === 'config'" />
    </div>
  </section>
</template>

<script>
import Axios from "../axios";
import TabReservation from "../components/TabReservation.vue";
import TabConfig from "../components/TabConfig.vue";
import TabVehicle from "../components/TabVehicle.vue";

export default {
  components: { TabVehicle, TabReservation, TabConfig },
  data() {
    return {
      landing: {
        vehicles: [],
        reservations: [],
        logo: "",
        name: "",
      },
      activeTab: "vehicles",
      isLoading: true, // Estado para manejar la carga
    };
  },
  created() {
    this.fetchLanding();
  },
  methods: {
    async fetchLanding() {
      try {
        const userId = localStorage.getItem("NellyUserId");
        const landingId = this.$route.params.id;

        if (!userId || !landingId) {
          throw new Error("Usuario o ID de landing no encontrado");
        }

        const response = await Axios.get(`/api/landings/${userId}/${landingId}`);
        this.landing = response.data;
      } catch (error) {
        console.error("Error fetching landing:", error);
      } finally {
        this.isLoading = false; // Finaliza el estado de carga
      }
    },
    goBack() {
      this.$router.go(-1);
    },
  },
};
</script>

<style scoped>
button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
