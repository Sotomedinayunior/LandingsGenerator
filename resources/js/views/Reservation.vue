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

    <!-- Mostrar indicador de carga nativo mientras se obtienen las reservas -->
    <div v-if="loading" class="flex justify-center items-center">
      <progress class="w-full" value="0" max="100"></progress>
    </div>

    <!-- Mostrar mensaje si no hay reservas -->
    <div v-else-if="filteredReservations.length === 0" class="text-center">
      <p class="text-lg">No hay datos disponibles.</p>
    </div>

    <div v-else class="overflow-x-auto">
      <DataTable :value="filteredReservations" responsiveLayout="scroll" :paginator="true" :rows="10">
        <ColumnGroup>
          <Row>
            <Column header="Logo landing" />
            <Column header="Nombre de Carro" />
            <Column header="$ Monto Total" />
            <Column header="Nombre" />
            <Column header="Apellido" />
            <Column header="Correo Electrónico" />
            <Column header="Teléfono" />
            <Column header="Descripción" />
            <Column header="Acciones" />
          </Row>
        </ColumnGroup>
        <template v-for="landing in filteredReservations" :key="landing.id">
          <template v-for="reservation in landing.reservations" :key="reservation.id">
            <Column :body="renderLogo(landing, reservation)" />
            <Column :body="renderVehicle(landing, reservation)" />
            <Column :body="renderTotalPrice(landing)" />
            <Column :body="reservation.name" />
            <Column :body="reservation.last_name" />
            <Column :body="reservation.email" />
            <Column :body="reservation.phone" />
            <Column :body="reservation.description" />
            <Column :body="renderActions(reservation)" />
          </template>
        </template>
      </DataTable>
    </div>
  </section>
</template>

<script>
// import DataTable from 'primevue/datatable';
// import Column from 'primevue/column';
// import ColumnGroup from 'primevue/columngroup'; // optional
// import Row from 'primevue/row';  
import Axios from '../axios';

export default {

  data() {
    return {
      reservations: [],
      loading: true,
      searchTerm: '',
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
      } catch (error) {
        console.error("Error al cargar las reservas:", error);
      } finally {
        this.loading = false;
      }
    },
    renderLogo(landing, reservation) {
      return reservation === landing.reservations[0] ? `<img src="${landing.logo}" alt="Carro" class="foto" />` : '';
    },
    renderVehicle(landing, reservation) {
      return reservation === landing.reservations[0] ? reservation.vehicle.name : '';
    },
    renderTotalPrice(landing) {
      return landing.total_price || "N/A";
    },
    renderActions(reservation) {
      return `
        <i class="fa-solid fa-eye" @click="viewReservation(reservation)"></i>
        <i class="fa-solid fa-pencil" @click="editReservation(reservation)"></i>
      `;
    },
  },
  mounted() {
    this.fetchReservations();
  },
};
</script>

<style scoped>
/* Estilos para el indicador de carga nativo */
progress {
  appearance: none;
  width: 100%; /* Ancho completo */
  height: 10px; /* Ajusta la altura según lo necesites */
  border-radius: 5px; /* Bordes redondeados */
}

progress::-webkit-progress-bar {
  background-color: #f3f4f6; /* Color de fondo */
}

progress::-webkit-progress-value {
  background-color: #3b82f6; /* Color del progreso */
}

progress::-moz-progress-bar {
  background-color: #3b82f6; /* Color del progreso para Firefox */
}
</style>
