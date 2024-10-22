<template>
  <div class="w-full">
    <!-- Contador de vehículos se renderiza si hay vehículos -->
    <CountVehiclesTab
      :vehicles="vehicle"
      v-if="vehicle.length > 0 && currentForm === 'table' && !loading"
      @redirect-to-create="goToCreateVehicle"
      @search-query="updateSearchQuery"
    />

    <!-- Si no hay vehículos -->
    <div
      v-if="vehicle.length === 0 && !loading && currentForm === 'table'"
      class="flex justify-between items-center w-full"
    >
      <p>No existen vehículos en esta landing.</p>
      <button
        @click="goToCreateVehicle"
        class="mt-4 bg-orange-500 text-white px-4 py-2 rounded"
      >
        Aceptar
      </button>
    </div>

    <!-- Indicador de carga -->
    <div v-if="loading">Cargando vehículos...</div>

    <!-- Formulario de creación -->
    <FormVehiclesCreateTab
      v-if="currentForm === 'create'"
      @add-vehicle="addVehicle"
    />

    <!-- Formulario de edición -->
    <FormUpdateVehiclesTab
      v-if="currentForm === 'edit'"
      :vehicle="vehicleToEdit"
      @update-vehicle="updateVehicle"
    />

    <!-- Tabla de vehículos -->
    <TableVehiclesTab
      :vehicles="vehicle"
      v-if="vehicle.length > 0 && currentForm === 'table' && !loading"
      @edit-vehicle="goToEditVehicle"
      @redirect-to-create="goToCreateVehicle"
      @refresh-vehicles="getVehicles"
    />
  </div>
</template>

<script>
import CountVehiclesTab from "../components/CountVehiclesTab.vue";
import TableVehiclesTab from "../components/TableVehicleTab.vue";
import FormVehiclesCreateTab from "./FormVehiclesCreateTab.vue";
import FormUpdateVehiclesTab from "./FormUpdateVehiclesTab.vue";
import Axios from "../axios";

export default {
  components: {
    CountVehiclesTab,
    TableVehiclesTab,
    FormVehiclesCreateTab,
    FormUpdateVehiclesTab,
  },
  data() {
    return {
      error: false,
      currentForm: "table", // Maneja el estado del formulario: 'create', 'edit', 'table'
      vehicle: [],
      vehicleToEdit: null, // Almacena el vehículo seleccionado para editar
      loading: false, // Indicador de carga
 
    };
  },
  computed: {
    // Propiedad computada para filtrar los vehículos
    filteredVehicles() {
      if (!this.searchQuery) {
        return this.vehicle;
      }
      const query = this.searchQuery.toLowerCase();
      return this.vehicle.filter((vehicle) => {
        return (
          vehicle.name.toLowerCase().includes(query) ||
          vehicle.type_of_car.toLowerCase().includes(query) ||
          vehicle.transmision.toLowerCase().includes(query)
        );
      });
    },
  },
  mounted() {
    this.getVehicles(); // Llama a getVehicles cuando el componente se monta
  },
  methods: {
  
    async getVehicles() {
      const landingId = this.$route.params.id;
      this.loading = true; // Indicar que está cargando
      try {
        const response = await Axios.get(`/api/vehicles/${landingId}`);
        this.vehicle = response.data.vehicles; // Asigna los datos recibidos
      } catch (err) {
        console.error(`Error al obtener los datos: ${err}`);
      } finally {
        this.loading = false; // Finaliza el estado de carga
      }
    },

    goToCreateVehicle() {
      // Cambia al formulario de creación
      this.currentForm = "create";
    },

    goToEditVehicle(vehicle) {
      // Cambia al formulario de edición y pasa el vehículo seleccionado
      this.vehicleToEdit = vehicle;
      this.currentForm = "edit";
    },

    async addVehicle(newVehicle) {
      try {
        await Axios.post("/api/vehicles", newVehicle);
        alert("Vehículo agregado con éxito");
        this.getVehicles(); // Actualiza la lista de vehículos
        this.currentForm = "table"; // Regresa a la tabla
      } catch (error) {
        console.error("Error al agregar el vehículo:", error);
        alert("Hubo un error al agregar el vehículo.");
      }
    },

    async updateVehicle(updatedVehicle) {
      try {
        await Axios.put(`/api/vehicle/${updatedVehicle.id}`, updatedVehicle);
        alert("Vehículo actualizado con éxito");
        this.getVehicles(); // Actualiza la lista de vehículos
        this.currentForm = "table"; // Regresa a la tabla
      } catch (error) {
        console.error("Error al actualizar el vehículo:", error);
        alert("Hubo un error al actualizar los datos del vehículo.");
      }
    },

    confirmModal() {
      // Lógica para manejar el botón "Aceptar"
      alert("Modal confirmado"); // Cambiar esto según lo que quieras hacer
    },
  },
};
</script>
