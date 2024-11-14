<template>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th>Foto</th>
          <th>Nombre de Carro</th>
          <th>$ Monto Total</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in reservations" :key="item.id || index">
          <td>
            <img :src="item.landing.logo" alt="Carro" class="foto" />
          </td>
          <td>{{ item.vehicle.name }}</td>
          <td>{{ item.total_price || "N/A" }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.last_name }}</td>
          <td>{{ item.email }}</td>
          <td>{{ item.phone }}</td>
          <td>{{ item.description }}</td>
          <td class="flex justify-center items-center" id="actions">
            <i
              class="fa-solid fa-trash"
              @click="confirmDeleteVehicle(item.id)"
            ></i>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal de confirmación de eliminación -->
    <div v-if="isDeleteModalOpen" class="modal-overlay" @click.self="closeDeleteModal">
      <div class="modal-content">
        <h3>¿Estás seguro de que deseas eliminar esta reserva?</h3>
        <div class="flex justify-around mt-4">
          <button @click="deleteVehicle" class="bg-red-500 text-white px-4 py-2 rounded">
            Sí, Eliminar
          </button>
          <button @click="closeDeleteModal" class="bg-gray-500 text-white px-4 py-2 rounded">
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
  components: {
    TableReservation: () => import("./TableReservation.vue"), // Lazy loading del componente
  },
  data() {
    return {
      reservations: null,
      loading: true, // Inicia en estado de carga
      error: null,
      isDeleteModalOpen: false, // Estado para controlar el modal de confirmación
      vehicleToDelete: null, // El vehículo que se va a eliminar
    };
  },
  mounted() {
    this.fetchReservations();
  },
  methods: {
    async fetchReservations() {
      try {
        const landingId = this.$route.params.id;
        const response = await Axios.get(`/reservations/${landingId}`);
        this.reservations = response.data;
        console.log("Reservas cargadas:", this.reservations);
      } catch (error) {
        this.error = "Error al cargar las reservas";
        console.error("Error al cargar las reservas:", error);
      } finally {
        this.loading = false; // Detiene el estado de carga
      }
    },
    // Abre el modal de confirmación de eliminación
    confirmDeleteVehicle(vehicleId) {
      this.vehicleToDelete = vehicleId; // Guarda el id del vehículo que se eliminará
      this.isDeleteModalOpen = true; // Abre el modal
    },
    // Elimina el vehículo
    async deleteVehicle() {
      try {
        const response = await Axios.delete(`/reservations/${this.vehicleToDelete}`);
        // Actualizar la lista de reservas después de eliminar
        this.reservations = this.reservations.filter(item => item.id !== this.vehicleToDelete);
        this.closeDeleteModal(); // Cierra el modal después de eliminar
      } catch (error) {
        console.error("Error al eliminar la reserva:", error);
        alert("Hubo un problema al eliminar la reserva.");
      }
    },
    // Cierra el modal de confirmación de eliminación
    closeDeleteModal() {
      this.isDeleteModalOpen = false;
      this.vehicleToDelete = null; // Limpiar el vehículo seleccionado
    },
  },
};
</script>

<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.table thead {
  background-color: #FDF0E9;
  color: #222;
  font-size: 15px;
  border-bottom: 2px solid #FC8B46;
}

.table th,
.table td {
  padding: 12px;
  text-align: left;
  font-size: 13px;
  border-bottom: 1px solid #ddd;
}

.foto {
  width: 40px;
  height: auto;
  border-radius: 4px;
}

#actions i {
  cursor: pointer;
  color: #e60000;
  font-size: 18px;
}

#actions i:hover {
  color: #ff3b3b;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 600px;
}

button {
  font-weight: bold;
  padding: 10px 20px;
  cursor: pointer;
}

button.bg-red-500 {
  background-color: #f16822;
}

button.bg-gray-500 {
  background-color: #888;
}

button:hover {
  opacity: 0.8;
}
</style>
