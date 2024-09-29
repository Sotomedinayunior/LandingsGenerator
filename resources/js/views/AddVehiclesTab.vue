<template>
  <div class="container my-3">
    <div v-if="!error">
      <!-- Asegúrate de pasar el prop 'vehicles' correctamente -->
      <CountVehicles :vehicles="vehicle"/>

      <div v-if="vehicle.length" class="flex items-center justify-center flex-col mt-6">
        <TableVehicle
          :vehicles="vehicle"
          
        />
        <button
          @click="review"
          class="px-4 py-2 text-sm text-[#F57200] border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
        >
          Continuar
        </button>

      </div>
    </div>


    <div v-else class="text-center text-red-600 font-bold">
      Error: Debes crear una landing primero para luego agregarles los vehículos. Serás redirigido
      en {{ countdown }} segundos...
    </div>
  </div>
</template>

<script>
// Importación correcta del componente CountVehicles
import CountVehicles from "../components/CountVehicles.vue";
import TableVehicle from "../components/TableVehicle.vue";
import  Axios  from "../axios";
export default {
  components: {
    CountVehicles, TableVehicle
  },
  data() {
    return {
      error: false,
      vehicle:[], // Asegúrate de que vehicle es un array
      countdown: 7, // Inicializa la cuenta regresiva a 7 segundos
    };
  },
  mounted() {
 
    const nellyUserId = localStorage.getItem("NellyUserId");

    if (!nellyUserId) {
      this.error = true;

      // Iniciar el temporizador para actualizar la cuenta regresiva
      const interval = setInterval(() => {
        if (this.countdown > 0) {
          this.countdown--; // Reduce el valor del contador
        } else {
          clearInterval(interval); // Detener el temporizador cuando llegue a 0
          this.$router.push("/layout-designer/"); // Redirigir cuando la cuenta regresiva termine
        }
      }, 1000); // Cada segundo (1000 ms)
    } else {
      this.getVehicles(); // Llama a getVehicles si el usuario está autenticado
    }
  },

  methods: {
    async getVehicles() {
      const storedId = localStorage.getItem("NellyLandingCreate");
      console.log(storedId);
      this.loading = true; // Indicar que está cargando
      try {
        const response = await Axios.get(`/api/vehicles/${storedId}`);

        this.vehicle = response.data.vehicles; // Asigna los datos recibidos
        console.log(response.data);
      } catch (err) {
        console.error(`Error al obtener los datos: ${err}`);
      } finally {
        this.loading = false; // Finaliza el estado de carga
      }
    },
    review() {
      this.$router.push("/layout-designer/review");
    },

    async addVehicle() {
      const formData = new FormData();

      for (const key in this.newVehicle) {
        const value = this.newVehicle[key];
        formData.append(
          key,
          typeof value === "boolean" ? (value ? 1 : 0) : value
        );
      }

      const imageInput = document.getElementById("vehicle-images").files;
      Array.from(imageInput).forEach((file, index) => {
        formData.append(`images[${index}]`, file);
      });

      try {
        await Axios.post("/api/vehicle", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        alert("Vehículo agregado con éxito");
        this.getLanding(); // Actualizar la lista de vehículos
        this.previousStep(); // Volver al contador de vehículos
      } catch (error) {
        console.error("Error al agregar el vehículo:", error);
        alert("Hubo un error al enviar los datos del vehículo.");
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
</style>
