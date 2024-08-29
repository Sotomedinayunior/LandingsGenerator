<template>
  <div>
    <div v-if="loading">Cargando...</div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th>Imágenes</th>
            <th>Nombre</th>
            <th>Precio por día</th>
            <th>Tipo de Carro</th>
            <th>Equipaje</th>
            <th>Personas</th>
            <th>Transmisión</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="vehiculo in vehicles" :key="vehiculo.id">
            <td>
              <!-- Mostrar solo la primera imagen yugfyfud-->
              <img
                :src="
                 'storage/'.vehiculo.images.length
                    ? vehiculo.images[0].path_images
                    : 'default.jpg'
                "
                :alt="vehiculo.name"
                width="100"
              />
            </td>
            <td>{{ vehiculo.name }}</td>
            <td>{{ vehiculo.price }}</td>
            <td>{{ vehiculo.type_of_car }}</td>
            <td>{{ vehiculo.luggage }}</td>
            <td>{{ vehiculo.people }}</td>
            <td>{{ vehiculo.transmision }}</td>
            <td class="actions-cell">
              <i class="fa-solid fa-pencil"></i>
              <i
                class="fa-solid fa-trash"
                @click="confirmarEliminacion(vehiculo.id)"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="error" class="error">Error al cargar los datos</div>
    </div>

    <!-- Modal de Confirmación -->
    <transition name="fade">
      <div
        v-if="showModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50"
      >
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm mx-auto">
          <h3 class="text-lg font-semibold mb-4">Confirmar Eliminación</h3>
          <p>¿Estás seguro de que quieres eliminar este vehículo?</p>
          <div class="mt-4 flex justify-end">
            <button
              class="bg-gray-500 text-white px-4 py-2 rounded mr-2"
              @click="cerrarModal"
            >
              Cancelar
            </button>
            <button
              class="bg-red-500 text-white px-4 py-2 rounded"
              @click="eliminarVehiculo"
            >
              Eliminar
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import Axios from "../axios"; // Asegúrate de que la importación sea correcta

export default {
  data() {
    return {
      vehicles: [],
      loading: true,
      error: false,
      showModal: false, // Controla la visibilidad del modal
      vehicleToDelete: null, // Almacena el vehículo a eliminar
    };
  },
  mounted() {
    this.Obtener(); // Llama al método para obtener los datos cuando se monta el componente
  },
  methods: {
    Obtener() {
      const landingId = localStorage.getItem("NellyLandingCreate"); // Obtiene el landingId de la localstorage
      console.log(landingId);
      Axios.get(`/api/vehicles/${landingId}`)
        .then((response) => {
          console.table(response.data);

          // Verifica que la estructura de datos es correcta antes de asignar
          if (response.data.vehicles) {
            this.vehicles = response.data.vehicles;
          } else {
            this.vehicles = [];
          }

          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
          this.error = true;
          this.loading = false;
        });
    },
    confirmarEliminacion(vehicleId) {
      this.vehicleToDelete = vehicleId; // Guarda el ID del vehículo a eliminar
      this.showModal = true; // Muestra el modal
    },
    cerrarModal() {
      this.showModal = false; // Oculta el modal
    },
    eliminarVehiculo() {
      if (this.vehicleToDelete) {
        Axios.delete(`/api/vehicle/${this.vehicleToDelete}`)
          .then(() => {
            // Eliminar el vehículo de la lista local
            this.vehicles = this.vehicles.filter(
              (vehiculo) => vehiculo.id !== this.vehicleToDelete
            );
            this.vehicleToDelete = null; // Limpia el ID del vehículo
            this.cerrarModal(); // Cierra el modal
          })
          .catch((err) => {
            console.error("Error al eliminar el vehículo:", err);
            this.error = true;
          });
      }
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
  background-color: #fdf0e9;
  color: #222;
  font-size: 14px;
  border-bottom: 2px solid #fc8b46;
}

.table th,
.table td {
  padding: 10px;
  text-align: left;
  font-size: 13px;
  border-bottom: 1px solid #ddd;
}

.table th {
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Alineación del contenido de las celdas */
.table td {
  vertical-align: middle;
}

.actions-cell {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* Estilo de los íconos en acciones */
.actions-cell i {
  cursor: pointer;
  transition: opacity 0.2s ease;
}

.actions-cell i:hover {
  opacity: 0.7;
}

.error {
  color: red;
  font-size: 14px;
}
</style>
