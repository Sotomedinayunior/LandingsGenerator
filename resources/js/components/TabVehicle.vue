<template>
  <div>
    <CountVehiclesTab :vehicles="vehicle" v-if="!showCreateForm && !showEditForm" @redirect-to-create="goToCreateVehicle"/>

    <!-- Formulario de creación -->
    <FormVehiclesCreateTab v-if="showCreateForm" @add-vehicle="addVehicle" />

    <!-- Formulario de edición -->
    <FormUpdateVehiclesTab v-if="showEditForm" :vehicle="vehicleToEdit" @update-vehicle="updateVehicle" />

    <!-- Tabla de vehículos -->
    <TableVehiclesTab
      :vehicles="vehicle"
      v-if="!showCreateForm && !showEditForm"
      @edit-vehicle="goToEditVehicle"
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
    FormUpdateVehiclesTab
  },
  data() {
    return {
      error: false,
      showCreateForm: false, // Bandera para mostrar el formulario de creación
      showEditForm: false, // Bandera para mostrar el formulario de edición
      vehicle: [], // Asegúrate de que vehicle es un array
      vehicleToEdit: null, // Almacena el vehículo seleccionado para editar
    };
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
      // Mostrar el formulario de creación
      this.showCreateForm = true;
    },

    goToEditVehicle(vehicle) {
      // Mostrar el formulario de edición y pasar el vehículo seleccionado
      this.vehicleToEdit = vehicle;
      this.showEditForm = true;
    },

    async updateVehicle(updatedVehicle) {
      try {
        await Axios.put(`/api/vehicle/${updatedVehicle.id}`, updatedVehicle);
        alert("Vehículo actualizado con éxito");
        this.getVehicles(); // Actualizar la lista de vehículos
        this.showEditForm = false; // Ocultar el formulario de edición
      } catch (error) {
        console.error("Error al actualizar el vehículo:", error);
        alert("Hubo un error al actualizar los datos del vehículo.");
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
