<template>
  <section class="lg:ml-64 p-4">
    <div
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
    >
      <h1 class="font-bold text-xl">Reservas</h1>
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

    <!-- Mostrar mensaje si no hay reservas -->
    <div v-else-if="filteredReservations.length === 0" class="text-center">
      <p class="text-lg">No hay datos disponibles.</p>
    </div>

    <!-- Mostrar reservas si las hay -->
    <div v-else>
      <div
        v-for="(landing, index) in filteredReservations"
        :key="index"
        class="grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-3 gap-3 px-3"
      >
        <!-- Iteramos sobre las reservas dentro de cada landing -->
        <CardRervation
          v-for="(reservation, resIndex) in landing.reservations"
          :key="`res-${index}-${resIndex}`"
          :reservation="reservation"
          @deleted="handleDeleted"
          @viewReservation="openModal(reservation)"
        />
      </div>
    </div>

    <!-- Modal con la información de la reserva -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content bg-[#F168220D]">
        <h2 class="text-xl font-bold mb-4 text-gray-800">
          Detalles de la reservacion
        </h2>

        <!-- Fecha y ubicación -->
        <div class="mb-4">
          <h3 class="font-semibold text-orange-600 text-sm">
            Fecha y localizacion
          </h3>
          <div class="flex items-center mt-2">
            <div class="flex flex-col">
              <div class="flex items-center whitespace-nowrap">
                <h2 class="text-xs font-bold">Salida -</h2>
                <span class="text-xs ml-3">{{
                  selectedReservation.place_of_departure
                }}</span>
                <img
                  src="./Landing/asset/line.png"
                  alt="line"
                  width="40"
                  height="30"
                  class="mx-3"
                />
                <h2 class="text-xs font-bold ml-5">Regreso -</h2>
                <span class="text-xs ml-3">{{
                  selectedReservation.arrival_place
                }}</span>
              </div>
              <div class="flex items-center whitespace-nowrap">
                <h2 class="text-xs font-bold whitespace-nowrap">
                  {{ selectedReservation.date_of_arrival }}
                </h2>
                <img src="./Landing/asset/circle.png" alt="" class="mx-3" />
                <h2 class="text-xs font-bold">
                  {{ selectedReservation.time_of_arrival }}
                </h2>
                <h2 class="text-xs font-bold ml-4">
                  {{ selectedReservation.date_of_departure }}
                </h2>
                <img src="./Landing/asset/circle.png" alt="" class="mx-3" />
                <h2 class="text-xs font-bold">
                  {{ selectedReservation.time_of_departure }}
                </h2>
              </div>
            </div>
            <div>
              <p class="text-gray-800 text-sm">
                {{ selectedReservation.return_date }} ·
                {{ selectedReservation.return_time }}
              </p>
            </div>
          </div>
        </div>

        <!-- Información del vehículo -->
        <div class="mb-4">
          <h3 class="font-semibold text-orange-600 text-sm">Vehiculo</h3>
          <div class="flex items-center mt-2">
            <img
              :src="selectedReservation.url_landing"
              alt="Vehicle"
              class="w-24 h-16 object-cover rounded-md mr-4"
            />
          </div>
        </div>

        <!-- Información del cliente -->
        <div class="flex justify-around pt-4">
          <div class="flex items-center justify-center flex-col space-x-3">
            <img
              :src="selectedReservation.avatar_url"
              alt="Customer"
              class="w-12 h-12 rounded-full"
            />
            <div>
              <p class="font-semibold text-gray-800 text-xs text-center">
                {{ selectedReservation.name }}
              </p>
              <p class="text-gray-600 text-xs">
                {{ selectedReservation.phone }}
              </p>
              <p class="text-xs text-gray-600">
                {{ selectedReservation.email }}
              </p>
            </div>
          </div>
          <div class="mt-4 bg-gray-50 p-3">
            <p class="font-bold text-sm text-orange-600 my-2">
              Comentario adicional:
            </p>
            <p class="text-xs text-gray-600">
              {{ selectedReservation.description }}
            </p>
          </div>
        </div>

        <!-- Botón de cierre -->
        <div class="mt-6 flex justify-end">
          <button
            class="px-4 py-2 bg-orange-600 text-white rounded-md"
            @click="closeModal"
          >
            Cerrar
          </button>
        </div>
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
      vehicle:[]
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
    async fetchVehicleDetails(vehicleId , landingId) {
      vehicleId = this.selectedReservation.id_vehicle;
      landingId = this.selectedReservation.id_landing;
    try {
      const response = await Axios.get(`/vehicles/${landingId}/${vehicleId}`);
      this.vehicle = response.data; // Guardar la información del vehículo en el estado
      console.log('aqui esta los vehicles' + this.vehicle);
    } catch (error) {
      console.error("Error al cargar los detalles del vehículo:", error);
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
    handleDeleted(id) {
      // Aquí es donde se maneja la eliminación en el componente padre
      // Filtra las reservas para eliminar la que se ha solicitado eliminar
      this.reservations = this.reservations.filter((reservation) => reservation.id !== id);

    },
  },

  mounted() {
    this.fetchReservations(); // Cargar las reservas al montar el componente
    this.fetchVehicleDetails(); // Cargar los detalles del vehículo al montar el componente
  },
};
</script>

<style scoped>
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
  z-index: 50;
}

.modal-content {
  background: #fff;
  border-radius: 8px;
  padding: 20px;
  width: 90%;
  max-width: 600px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* .head-modal {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: #f168220d;
  padding: 20px;
  max-width: 300px;
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

  padding: 20px;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 80%;
  max-width: 600px;
}

.pickup {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
} */
</style>
