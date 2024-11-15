<template>
  <section class="lg:ml-64 p-4">
    <div
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
    >
      <h1 class="font-bold text-3xl">Reservas</h1>
      <div
        class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0"
      >
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
      <progress></progress>
    </div>

    <!-- Mostrar mensaje si no hay reservas -->
    <div v-else-if="filteredReservations.length === 0" class="text-center">
      <p class="text-lg">No hay datos disponibles.</p>
    </div>

    <!-- Mostrar reservas si las hay -->
    <div v-else>
      <div
        v-for="(landing, index) in filteredReservations"
        :key="index"
        class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 gap-3 px-3"
      >
        <!-- Iteramos sobre las reservas dentro de cada landing -->
        <CardRervation
          v-for="(reservation, resIndex) in landing.reservations"
          :key="`res-${index}-${resIndex}`"
          :reservation="reservation"
          @viewReservation="openModal(reservation)"
        />
      </div>
    </div>

    <!-- Modal con la información de la reserva -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="head-modal">
        <h2 class="text-white font-bold">Detalles de la reserva</h2>
        <img
          :src="selectedReservation.avatar_url"
          alt="Avatar"
          class="avatar"
        />
      </div>
    </div>
  </section>
</template>

<script>
import Axios from "../axios";
import CardRervation from "../components/CardRervation.vue";

export default {
  components: {
    CardRervation,
  },

  data() {
    return {
      reservations: [], // Reservas que vienen desde el backend
      loading: true, // Indicador de carga
      searchTerm: "", // Término de búsqueda
      isModalOpen: false, // Estado del modal
      selectedReservation: null, // Datos de la reserva seleccionada
    };
  },

  computed: {
    // Filtro de las reservas basado en el término de búsqueda
    filteredReservations() {
      const searchLower = this.searchTerm.toLowerCase();
      return this.reservations.filter((landing) => {
        return landing.reservations.some((reservation) => {
          const fullName = `${reservation.name} ${reservation.last_name}`.toLowerCase();
          return (
            fullName.includes(searchLower) ||
            reservation.email.toLowerCase().includes(searchLower) ||
            reservation.arrival_place.toLowerCase().includes(searchLower)
          );
        });
      });
    },
  },

  methods: {
    // Función para obtener las reservas
    async fetchReservations() {
      try {
        const UserId = localStorage.getItem("NellyUserId");
        const response = await Axios.get(`/reservations/user/${UserId}`);
        this.reservations = response.data; // Guardar las reservas en el estado
      } catch (error) {
        console.error("Error al cargar las reservas:", error);
      } finally {
        this.loading = false; // Terminar la carga
      }
    },
    openModal(reservation) {
      // Abrir el modal y cargar la información de la reserva seleccionada
      this.selectedReservation = reservation;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedReservation = null; // Limpiar los datos cuando se cierra el modal
    },
  },

  mounted() {
    this.fetchReservations(); // Cargar las reservas al montar el componente
  },
};
</script>

<style scoped>
.head-modal {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #f168220d;
  padding: 10px;
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
  padding: 30px;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 600px;
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
}
</style>
