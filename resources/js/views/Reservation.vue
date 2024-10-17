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

    <!-- Mostrar indicador de carga mientras se obtienen las reservas -->
    <div v-if="loading" class="flex justify-center items-center">
      <div role="status">
        <svg
          aria-hidden="true"
          class="inline w-16 h-16 text-gray-200 animate-spin dark:text-gray-600"
          style="fill: #f16822;"
          viewBox="0 0 100 101"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
            fill="currentColor"
          />
          <path
            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
            fill="currentFill"
          />
        </svg>
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <div v-else class="overflow-x-auto">
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
          <template v-for="landing in filteredReservations" :key="landing.id">
            <template v-for="reservation in landing.reservations" :key="reservation.id">
              <tr>
                <!-- Muestra el logo y el nombre del carro solo en la primera reserva -->
                <td v-if="reservation === landing.reservations[0]">
                  <img :src="landing.logo" alt="Carro" class="foto" />
                </td>
                <td v-if="reservation === landing.reservations[0]">
                  {{ reservation.vehicle.name }}
                </td>
                <td v-if="reservation === landing.reservations[0]">
                  {{ landing.total_price || "N/A" }}
                </td>
                <td>{{ reservation.name }}</td>
                <td>{{ reservation.last_name }}</td>
                <td>{{ reservation.email }}</td>
                <td>{{ reservation.phone }}</td>
                <td>{{ reservation.description }}</td>
                <td class="flex justify-between" id="actions">
                  <i class="fa-solid fa-eye" @click="viewReservation(reservation)"></i>
                  <i class="fa-solid fa-pencil" @click="editReservation(reservation)"></i>
                </td>
              </tr>
            </template>
          </template>
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
      loading: true, // Estado de carga
      searchTerm: '', // Para la búsqueda de reservas
    };
  },
  computed: {
    filteredReservations() {
      return this.reservations.filter(landing => {
        return landing.reservations.some(reservation => {
          const fullName = `${reservation.name} ${reservation.last_name}`.toLowerCase();
          return (
            fullName.includes(this.searchTerm.toLowerCase()) ||
            reservation.email.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
            reservation.arrival_place.toLowerCase().includes(this.searchTerm.toLowerCase())
          );
        });
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
        this.loading = false; // Desactivar el estado de carga al final
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

.error {
  color: red;
  font-size: 14px;
}
</style>
