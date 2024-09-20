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
              <img
                :src="
                  vehiculo.images.length
                    ? 'storage/' + vehiculo.images[0].path_images
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
      console.log("Landing ID:", landingId);

      if (!landingId) {
        console.error("No se encontró el ID de la landing page en localStorage.");
        this.error = true;
        this.loading = false;
        return;
      }

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
          console.error("Error al obtener los datos:", err);
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
    async eliminarVehiculo() {
      if (this.vehicleToDelete) {
        const landingId = localStorage.getItem("NellyLandingCreate"); // Obtener el landingId
        if (!landingId) {
          alert("No se encontró el ID de la landing en la localStorage.");
          return;
        }

        try {
          const response = await Axios.delete(`/api/vehicle/${this.vehicleToDelete}`, {
            data: { landingId } // Enviar el landingId junto con la solicitud
          });

          console.log("Vehículo eliminado:", response.data);

          if (response.status === 200) {
            // Eliminar el vehículo de la lista local
            this.vehicles = this.vehicles.filter(
              (vehiculo) => vehiculo.id !== this.vehicleToDelete
            );
          } else {
            console.error("No se pudo eliminar el vehículo en el servidor.");
            alert("Error al eliminar el vehículo. Intente nuevamente.");
          }

          this.vehicleToDelete = null; // Limpia el ID del vehículo
          this.cerrarModal(); // Cierra el modal
        } catch (error) {
          console.error("Error al eliminar el vehículo:", error);
          alert("Error al eliminar el vehículo.");
        }
      }
    },
  },
};
</script>

<style scoped>
.table {
  width: 75%;
  border-collapse: collapse;
  margin: 0 auto;
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
  border-bottom: 1.2px solid #ddd;
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

.actions-cell {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* Ocultar íconos por defecto */
.actions-cell {
  opacity: 0;
  transition: opacity 0.3s ease;
}

/* Mostrar íconos al hacer hover en la fila */
tr:hover .actions-cell {
  opacity: 1;
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

.vehiculo-nombre {
  display: flex;
  align-items: center;
}
</style>
