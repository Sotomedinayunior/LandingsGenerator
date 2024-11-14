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
          'py-2 px-4 flex items-center text-sm': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold text-sm':
            activeTab === 'reservations',
          'text-gray-500 text-sm': activeTab !== 'reservations',
        }"
      >
        Reservas
        <span
          :class="{
            'flex justify-center items-center w-5 h-5 rounded-full ml-2 text-sm': true,
            'bg-orange-500 text-white text-sm': activeTab === 'reservations',
            'border border-gray-500 text-gray-500 text-sm':
              activeTab !== 'reservations',
          }"
        >
          {{ landing.reservations.length }}
        </span>
      </button>

      <button
        @click="activeTab = 'vehicles'"
        :class="{
          'py-2 px-4 flex items-center text-sm': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold text-sm':
            activeTab === 'vehicles',
          'text-gray-500 text-sm': activeTab !== 'vehicles',
        }"
      >
        Vehículos
        <span
          :class="{
            'flex justify-center items-center w-5 h-5 rounded-full ml-2 text-xs': true,
            'bg-orange-500 text-white': activeTab === 'vehicles',
            'border border-gray-500 text-gray-500': activeTab !== 'vehicles',
          }"
        >
          {{ landing.vehicles.length }}
        </span>
      </button>

      <button
        @click="activeTab = 'config'"
        :class="{
          'py-2 px-4 flex items-center': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold':
            activeTab === 'config',
          'text-gray-500': activeTab !== 'config',
        }"
      >
        Configuración
      </button>

      <!-- Nuevo botón para SEO -->
      <button
        @click="activeTab = 'seo'"
        :class="{
          'py-2 px-4 flex items-center': true,
          'text-orange-500 border-b-2 border-orange-500 font-bold':
            activeTab === 'seo',
          'text-gray-500': activeTab !== 'seo',
        }"
      >
        SEO
      </button>
    </div>

    <!-- Tab Content -->
    <div class="container mx-auto mt-4 flex">
      <!-- Loading State -->
      <div v-if="isLoading">Cargando datos...</div>

      <!-- Reservations Tab -->
      <TabReservation
        v-if="
          !isLoading &&
          activeTab === 'reservations' &&
          landing.reservations.length > 0
        "
        :reservations="landing.reservations"
      />
      <div
        v-if="
          !isLoading &&
          activeTab === 'reservations' &&
          landing.reservations.length === 0
        "
      >
        No hay reservas disponibles.
      </div>

      <TabVehicle
        v-show="activeTab === 'vehicles'"
        :vehicles="landing.vehicles"
      />

      <!-- Config Tab -->
      <TabConfig v-if="!isLoading && activeTab === 'config'" />

      <!-- Nuevo SEO Tab -->
      <TabSeo v-if="!isLoading && activeTab === 'seo'" />
    </div>
  </section>
</template>

<script>
import Axios from "../axios";
import TabReservation from "../components/TabReservation.vue";
import TabConfig from "../components/TabConfig.vue";
import TabSeo from "../components/TabSeo.vue"; // Nuevo componente SEO
import TabVehicle from "../components/TabVehicle.vue";

export default {
  components: { TabVehicle, TabReservation, TabConfig, TabSeo },
  data() {
    return {
      landing: {
        vehicles: [],
        reservations: [],
        logo: "",
        name: "",
      },
      activeTab: "reservations",
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

        const response = await Axios.get(
          `/landings/${userId}/${landingId}`
        );
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
