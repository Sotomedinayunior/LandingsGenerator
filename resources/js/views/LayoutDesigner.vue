<template>
  <section>
    <!-- button and logo -->
    <div class="flex justify-between w-[570px] p-6 mb-8 ml-[198px]">
      <button
        @click="HandleClick()"
        class="bg-transparent border border-gray-500 text-gray-500 text-sm px-6 py-3 rounded"
      >
        Cancelar proceso
      </button>
      <img
        src="../static/asset/Logo.webp"
        alt="Logo nelly"
        lazy="loading"
        class="w-[120px]"
        height="auto"
        title="nelly app"
      />
    </div>

    <!-- Header with Tabs -->
    <div class="w-full flex justify-evenly border-b-2">
      <button
        @click="setActiveTab(1)"
        :class="[
          'py-2 px-12',
          activeTab === 1
            ? 'text-orange-500 border-b-2 border-orange-500'
            : 'text-gray-500',
        ]"
      >
        Logo & Colors
      </button>
      <button
        @click="setActiveTab(2)"
        :class="[
          'py-2 px-4',
          activeTab === 2
            ? 'text-orange-500 border-b-2 border-orange-500'
            : 'text-gray-500',
        ]"
        :disabled="!canActivateAddVehicles"
      >
        Add Vehicles
      </button>
      <button
        @click="setActiveTab(3)"
        :class="[
          'py-2 px-4',
          activeTab === 3
            ? 'text-orange-500 border-b-2 border-orange-500'
            : 'text-gray-500',
        ]"
        :disabled="!canActivateReview"
      >
        Review
      </button>
    </div>

    <!-- Contenido de cada Tab -->
    <div class="container mx-auto mt-4 flex justify-center items-center">
      <LogoColorsTab v-if="activeTab === 1" @next="handleNext('addVehicles')" />
      <AddVehiclesTab v-if="activeTab === 2" @next="handleNext('review')" />
      <ReviewTab v-if="activeTab === 3" />
    </div>
  </section>
</template>

<script>
import LogoColorsTab from "../components/LogoColorsTab.vue";
import AddVehiclesTab from "../components/AddVehiclesTab.vue";
import ReviewTab from "../components/ReviewTab.vue";

export default {
  components: {
    LogoColorsTab,
    AddVehiclesTab,
    ReviewTab,
  },
  data() {
    return {
      activeTab: 1,
      canActivateAddVehicles: false,
      canActivateReview: false,
    };
  },
  methods: {
    setActiveTab(tab) {
      if (tab === 2 && this.canActivateAddVehicles) {
        this.activeTab = tab;
      } else if (tab === 3 && this.canActivateReview) {
        this.activeTab = tab;
      } else if (tab === 1) {
        this.activeTab = tab;
      }
    },
    handleNext(nextTab) {
      if (nextTab === "addVehicles") {
        this.canActivateAddVehicles = true;
        this.activeTab = 2;
      } else if (nextTab === "review") {
        this.canActivateReview = true;
        this.activeTab = 3;
      }
    },
    HandleClick(){
       // Verificar si existe "NellyLandinCreate" en localStorage
    if (localStorage.getItem("NellyLandinCreate")) {
      // Si existe, eliminarlo
      localStorage.removeItem("NellyLandinCreate");

    }

    // Redirigir al dashboard
    this.$router.push('/dashboard');
  }
    
  },
};
</script>

<style scoped>
button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
</style>
