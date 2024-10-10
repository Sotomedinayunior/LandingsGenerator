<template>
  <section class="lg:ml-64 p-4">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-bold text-3xl">Reservas</h1>

      <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0">
        <!-- Campo de búsqueda -->
        <div class="relative">
          <input
            type="text"
            placeholder="Buscar una reserva"
            v-model="searchTerm"
            class="p-2 pr-10 border border-gray-300 rounded-md focus:outline-none placeholder:text-sm w-full sm:w-auto"
          />
          <!-- SVG de lupa -->
          <svg
            class="absolute inset-y-2 right-2 w-5 h-5 text-gray-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM21 21l-4.35-4.35"
            />
          </svg>
        </div>
      </div>
    </div>

    <!-- Tabla aquí -->
    <div class="overflow-x-auto">
      <table class="table">
      <thead>
        <tr>
     
          <th>Logo landing</th>
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
            <img :src="item.logo" alt="Carro" class="foto" />
          </td>
          <td>{{ item.reservations[0].vehicle.name }}</td>
          <td>{{ item.total_price || "N/A" }}</td>
          <td>{{ item.reservations[0].name }}</td>
          <td>{{ item.reservations[0].last_name }}</td>
          <td>{{ item.reservations[0].email }}</td>
          <td>{{ item.reservations[0].phone }}</td>
          <td>{{ item.reservations[0].description }}</td>
          <td class="flex justify-between" id="actions">
            <i class="fa-solid fa-eye" @click="viewReservation(item)"></i>
            <i class="fa-solid fa-pencil" @click="editReservation(item)"></i>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </section>
</template>


<script>
import Axios from '../axios';

export default {
  data() {
    return {
      
      reservations: [], // Asegúrate de inicializar esto como un array
      searchTerm: '', // Para la búsqueda de reservas
      
    };
  },
  computed: {
    filteredReservations() {
     
      return this.reservations.filter(reservation => {
        const fullName = `${reservation.name} ${reservation.last_name}`.toLowerCase();
        return (
          fullName.includes(this.searchTerm.toLowerCase()) ||
          reservation.email.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
          reservation.arrival_place.toLowerCase().includes(this.searchTerm.toLowerCase())
        );
      });
    },
  },
  methods: {
    async fetchReservations() {
      try {
        const UserId = localStorage.getItem("NellyUserId");
        const response = await Axios.get(`/api/reservations/user/${UserId}`);
        this.reservations = response.data; 
        console.log("Reservas cargadas:", this.reservations);
      } catch (error) {
        this.error = "Error al cargar las reservas";
        console.error("Error al cargar las reservas:", error);
      } finally {
        this.loading = false; // Detiene el estado de carga
      }
    },
  },
  mounted() {
    this.fetchReservations();
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

.vehiculo-nombre {
  display: flex;
  align-items: center;
}

</style>
