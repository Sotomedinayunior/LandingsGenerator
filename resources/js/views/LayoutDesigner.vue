<template>
  <section>
    <!-- Botón y Logo -->
    <div class="flex justify-between w-[570px] p-6 mb-8 ml-[198px]">
      <button
        @click="handleClick"
        class="bg-transparent border border-gray-500 text-gray-500 text-sm px-6 py-3 rounded"
      >
        Cancelar proceso
      </button>
      <img
        src="../static/asset/Logo.webp"
        alt="Logo Nelly"
        loading="lazy"
        class="w-[120px]"
        height="auto"
        title="Nelly app"
      />
    </div>

    <!-- Cabecera con Tabs -->
    <div class="w-full flex justify-evenly border-b-2">
      <button @click="setActiveTab(1)" :class="getTabClass(1)">
        Logo & Colors
      </button>
      <button
        @click="setActiveTab(2)"
        :class="getTabClass(2)"
        :disabled="!canActivateAddVehicles"
      >
        Add Vehicles
      </button>
      <button
        @click="setActiveTab(3)"
        :class="getTabClass(3)"
        :disabled="!canActivateReview"
      >
        Review
      </button>
    </div>

    <!-- Contenido de cada Tab -->
    <div class="container mx-auto mt-4 flex justify-center items-center">
      <keep-alive>
        <component :is="currentTabComponent" @next="handleNext" />
      </keep-alive>
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
      activeTab: 1, // Inicia en la primera pestaña
      canActivateAddVehicles: true, // Control para activar la pestaña 2
      canActivateReview: true, // Control para activar la pestaña 3
    };
  },
  computed: {
    currentTabComponent() {
      if (this.activeTab === 1) {
        return "LogoColorsTab";
      } else if (this.activeTab === 2) {
        return "AddVehiclesTab";
      } else if (this.activeTab === 3) {
        return "ReviewTab";
      }
    },
  },
  methods: {
    setActiveTab(tab) {
      console.log(`Intentando activar la pestaña: ${tab}`);
      // Controlar el cambio de tabs con condiciones
      if (
        tab === 1 ||
        (tab === 2 && this.canActivateAddVehicles) ||
        (tab === 3 && this.canActivateReview)
      ) {
        this.activeTab = tab;
        console.log(`Pestaña activa: ${this.activeTab}`);
      }
    },
    handleNext(nextTab) {
      console.log(`Siguiente pestaña: ${nextTab}`);
      // Controlar los pasos entre pestañas
      if (nextTab === "addVehicles") {
        this.canActivateAddVehicles = true;
        this.setActiveTab(2);
      } else if (nextTab === "review") {
        this.canActivateReview = true;
        this.setActiveTab(3);
      }
      console.log(`Pestaña activa después de next: ${this.activeTab}`);
    },
    handleClick() {
      console.log("Cancelando proceso...");

      // Verifica si el item existe en localStorage
      const landingItem = localStorage.getItem("NellyLandinCreate");
      if (landingItem) {
        console.log("Elemento encontrado en localStorage:", landingItem);
        localStorage.removeItem("NellyLandinCreate");

        // Verifica si el elemento fue eliminado
        const checkItem = localStorage.getItem("NellyLandinCreate");
        if (!checkItem) {
          console.log("Elemento eliminado de localStorage.");
        } else {
          console.log(
            "Error: El elemento no se pudo eliminar de localStorage."
          );
        }
      } else {
        console.log("Elemento no encontrado en localStorage.");
      }

      // Redirige al dashboard
      this.$router.push("/landings");
    },
    getTabClass(tab) {
      // Devuelve las clases CSS para los botones de las pestañas
      return [
        "py-4 px-10",
        this.activeTab === tab
          ? "text-orange-500 border-b-2	 text-xl font-semibold border-orange-500"
          : "text-gray-500 text-xl font-semibold",
      ];
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
