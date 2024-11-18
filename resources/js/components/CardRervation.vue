<template>
  <div class="card">
    <button class="close-button" @click.stop="showModal = true">✖</button>

    <div class="card-header">
      <img
        :src="reservation.avatar_url || defaultAvatar"
        alt="Avatar"
        class="avatar"
      />
      <div class="card-info">
        <h3 class="name">{{ reservation.name_landing }}</h3>
        <p class="role">{{ reservation.name }}</p>
        <p class="location">
          <span class="icon-location"></span> {{ reservation.location }}
        </p>
      </div>
    </div>
    <div class="card-body">
      <p class="rating">
        <span class="icon-star"></span> {{ reservation.email }}
      </p>
      <!-- <p class="availability">
          <span class="icon-clock"></span> {{ reservation.phone }}
        </p> -->
      <button class="invite-button" @click="viewReservation">Ver</button>
    </div>
  </div>
  <!-- Modal -->
  <transition
    name="modal-fade"
    enter-active-class="transition ease-out duration-400 transform"
    leave-active-class="transition ease-in duration-300 transform"
    enter-from-class="opacity-0 scale-95"
    enter-to-class="opacity-100 scale-100"
    leave-from-class="opacity-100 scale-100"
    leave-to-class="opacity-0 scale-95"
  >
    <div
      v-if="showModal"
      tabindex="-1"
      class="fixed inset-0 z-50 flex justify-center items-center w-full h-[calc(100%-1rem)] max-h-full overflow-y-auto overflow-x-hidden"
    >
      <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <button
            @click="showModal = false"
            type="button"
            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-xs w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
          >
            <svg
              class="w-3 h-3"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
              />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
          <div class="p-4 md:p-5 text-center">
            <svg
              class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 20"
            >
              <path
                stroke="#f16822"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              />
            </svg>
            <h3
              class="mb-5 text-base font-normal text-gray-500 dark:text-gray-400"
            >
              ¿Estás seguro de que deseas eliminar este Reservacion?
            </h3>
            <button
              @click="deleteLanding(reservation.id)"
              type="button"
              class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-xs inline-flex items-center px-5 py-2.5"
            >
              Sí, estoy seguro
            </button>
            <button
              @click="showModal = false"
              type="button"
              class="py-2.5 px-5 ms-3 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
            >
              No, cancelar
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import Axios from "axios";
export default {
  name: "CardReservation",
  props: {
    reservation: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      defaultAvatar: "https://via.placeholder.com/150", // Imagen por defecto si no hay avatar
      showModal: false, // Estado del modal

    };
  },
  methods: {
    viewReservation() {
      this.$emit("viewReservation", this.reservation);
    },
    deleteLanding(id) {
      Axios.delete(`/reservations/${id}`)
    .then((response) => {
      this.$emit("deleted", id); // Emite el evento cuando se elimina la reserva
      this.showModal = false;
    })
    .catch((error) => {
      console.error(
        "Error al eliminar la reserva:",
        error.response ? error.response.data : error.message
      );
    });
}

  },
};
</script>

<style scoped>
.card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  padding: 16px;
  margin: 16px;
  background-color: #fff;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  width: 300px;
}

.card-header {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  margin-right: 16px;
  border: 2px solid #ddd;
  object-fit: cover;
}

.card-info {
  flex-grow: 1;
}

.name {
  font-size: 18px;
  font-weight: bold;
  text-transform: capitalize;
  color: #333;
  margin: 0;
}

.role {
  font-size: 14px;
  color: #888;
  margin: 4px 0;
}

.location {
  font-size: 14px;
  color: #666;
  display: flex;
  align-items: center;
}

.icon-location {
  content: "📍";
  margin-right: 4px;
}

.card-body {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

.rating {
  font-size: 14px;
  color: #333;
  display: flex;
  align-items: center;
}

.icon-star {
  content: "⭐";
  margin-right: 4px;
}

.availability {
  font-size: 14px;
  color: #28a745;
  display: flex;
  align-items: center;
}

.icon-clock {
  content: "⏰";
  margin-right: 4px;
}

.invite-button {
  background-color: #f16822;
  color: #fff;
  border: none;
  border-radius: 20px;
  padding: 8px 16px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.invite-button:hover {
  background-color: #c4551d;
}

.close-button {
  margin: 0 0 0 240px;
  background-color: transparent;
  border: none;
  font-size: 16px;
  color: #888;
  cursor: pointer;
  transition: color 0.3s ease;
}
</style>
