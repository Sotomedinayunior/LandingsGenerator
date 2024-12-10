<template>
  <div class="box-container">
    <div class="container my-3">
      <div v-if="!error">
        <CountVehicles :vehicles="vehicle" />

        <div
          v-if="vehicle.length"
          class="flex items-center justify-center flex-col mt-6"
        >
          <TableVehicle :vehicles="vehicle" @delete="deleteVehicle" />
          <button
            @click="review"
            class="px-4 py-2 text-sm text-[#F57200] border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
          >
            Continuar
          </button>

          <!-- Toast Notification for Success -->
          <div
            v-if="showToast"
            class="fixed bottom-4 right-4 p-4 bg-orange-500 text-white rounded-md shadow-md transition-opacity duration-300"
            @click="showToast = false"
          >
            Vehículo eliminado con éxito
          </div>

          <!-- Toast Notification for Error -->
          <div
            v-if="showErrorToast"
            class="fixed bottom-16 right-4 p-4 bg-red-500 text-white rounded-md shadow-md transition-opacity duration-300"
            @click="showErrorToast = false"
          >
            Hubo un error al eliminar el vehículo.
          </div>
        </div>
      </div>

      <div v-else class="text-center text-red-600 font-bold">
        Error: Debes crear una landing primero para luego agregarles los
        vehículos. Serás redirigido en {{ countdown }} segundos...
      </div>
    </div>
  </div>
</template>

<script>
import CountVehicles from "../components/CountVehicles.vue";
import TableVehicle from "../components/TableVehicle.vue";
import Axios from "../axios";

export default {
  components: {
    CountVehicles,
    TableVehicle,
  },
  data() {
    return {
      error: false,
      vehicle: [],
      countdown: 7,
      showToast: false, // Para mostrar el toast de éxito
      showErrorToast: false, // Para mostrar el toast de error
    };
  },
  mounted() {
    const nellyUserId = localStorage.getItem("NellyLandingCreate");

    if (!nellyUserId) {
      this.error = true;
      const interval = setInterval(() => {
        if (this.countdown > 0) {
          this.countdown--;
        } else {
          clearInterval(interval);
          this.$router.push("/layout-designer/");
        }
      }, 1000);
    } else {
      this.getVehicles();
    }
  },
  methods: {
    async getVehicles() {
      const storedId = localStorage.getItem("NellyLandingCreate");
      this.loading = true;
      try {
        const response = await Axios.get(`/vehicles/${storedId}`);
        this.vehicle = response.data.vehicles;
      } catch (err) {
        console.error(`Error al obtener los datos: ${err}`);
      } finally {
        this.loading = false;
      }
    },
    review() {
      this.$router.push("/layout-designer/review");
    },
    async deleteVehicle(vehicleId, index) {
      try {
        await Axios.delete(`/vehicle/${vehicleId}`);

        // Eliminar del array local usando splice para asegurar la reactividad
        this.vehicle.splice(index, 1);

        this.showToast = true; // Mostrar el toast de éxito
        setTimeout(() => {
          this.showToast = false; // Ocultar el toast de éxito después de 3 segundos
        }, 3000);
      } catch (error) {
        console.error("Error al eliminar el vehículo:", error);
        this.showErrorToast = true; // Mostrar el toast de error
        setTimeout(() => {
          this.showErrorToast = false; // Ocultar el toast de error después de 3 segundos
        }, 3000);
      }
    },
  },
};
</script>

<style scoped lang="scss">
.btn-new {
  background-color: $color-background-secondary;
  font-size: clamp(12px, 1vw, 1.5rem);
  border-radius: 8px;
  padding: 14px 25px;
  color: $color-font-tertiary;
}

/* Caja principal */
.box-container {
  max-width: 1024px; /* Ancho máximo */
  margin: 0 auto; /* Centrar horizontalmente */
}
</style>
