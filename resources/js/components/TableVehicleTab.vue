<template>
  <div>
    <div v-if="loading">Cargando...</div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th style="opacity: 0;">imagen</th>
            <th>Nombre</th>
            <th>Precio por día</th>
            <th>Tipo de Carro</th>
            <th>Equipaje</th>
            <th>Personas</th>
            <th>Transmisión</th>
            <th>Acomodaciones</th>
            <th>Comisiones</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="vehiculo in vehicles" :key="vehiculo.id">
            <td class="vehiculo-nombre">
              <img
                :src="`/storage/${vehiculo.images[0].path_images}`"
                :alt="vehiculo.name"
                class="vehicle-image"
              /> 
            </td>
            <td>{{ vehiculo.name }}</td>
            <td>{{ vehiculo.price }}</td>
            <td>{{ vehiculo.type_of_car }}</td>
            <td>{{ vehiculo.luggage }}</td>
            <td>{{ vehiculo.people }}</td>
            <td>{{ vehiculo.transmision }}</td>
            <td>{{ vehiculo.bluetooth }}</td>
            <td>{{ vehiculo.commissions }}</td>
            <td class="actions-cell">
              <i
                class="fa-solid fa-pencil"
                
                @click="updateVehicle
                (vehiculo.id)"
              ></i>
              <i
                class="fa-solid fa-trash"
                @click="confirmDeleteVehicle(vehiculo.id)"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="error" class="error">Error al cargar los datos</div>
    </div>

    <div
      v-if="showModal"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-lg font-semibold">Confirmar eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este vehículo?</p>
        <div class="flex justify-end mt-4">
          <button
            @click="deleteVehicle(selectedVehicle)"
            class="bg-red-600 text-white px-4 py-2 rounded"
          >
            Eliminar
          </button>
          <button
            @click="showModal = false"
            class="ml-2 bg-gray-300 text-black px-4 py-2 rounded"
          >
            Cancelar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "../axios";
export default {
  props: {
    vehicles: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      loading: false,
      showModal: false,
      selectedVehicle: null, // Almacena el vehículo seleccionado para eliminación
      error: false,
    };
  },
  methods: {
    updateVehicle(vehicleId) {
      const vehicleToEdit = localStorage.setItem("vehicleToEdit", vehicleId);
      this.$emit("edit-vehicle", this.vehicleToEdit);
    },
    confirmDeleteVehicle(vehicleId) {
      this.selectedVehicle = vehicleId; // Almacena el ID del vehículo seleccionado
      this.showModal = true; // Muestra el modal de confirmación
    },
    deleteVehicle(vehicleId) {
      const landingId = this.$route.params.id;

      Axios.delete(`/vehicle/${landingId}/${vehicleId}`)
        .then(() => {
          this.showModal = false; // Ocultar el modal
          this.$emit("refresh-vehicles");  // Emitimos un evento para actualizar los vehículos
        })
        .catch(() => {
          this.error = true; // Mostrar error si ocurre
          this.showModal = false;
        });
    },
  
  },
};
</script>

<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  border-radius: 8px 8px 0 0;
  overflow: hidden;
}

.table thead {
  background-color: #fdf0e9;
  color: #222;
  font-size: 10px !important;
  border: 2px solid #fc8b46;
  border-radius: 8px 8px 0 0;
}

.table th,
.table td {
  padding: 7px;
  text-align: left;
  border-bottom: 2px solid #ddd;
  vertical-align: middle;
}

.table td {
  font-size: 12px;
}

.table th {
  text-transform: capitalize;
  letter-spacing: 0.04em;
  font-weight: 300;
  font-size: 12px;
}

.table td img {
  width: 40px;
  height: 40px;
  margin-right: 10px;
  border-radius: 5px;
}

i{
  margin: 0px 10px 0px 10px;
}

/* Ocultar íconos por defecto */
.actions-cell {

  cursor: pointer;
  transition: opacity 0.3s ease;
}


.error {
  color: red;
  font-size: 14px;
}

.vehicle-image {
  border-radius: 5px;
  width: 40px;
  height: 40px;
}


</style>
