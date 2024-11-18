<template>
  <div>
    <!-- Card Component -->
    <div
      class="max-w-lg p-6 cursor-pointer rounded-2xl bg-[#FAF8F6]"
      @click="handle(landing.id)"
    >
      <div class="flex justify-between">
        <div class="flex">
          <img
            :src="landing.logo"
            :alt="FullName"
            loading="lazy"
            class="w-11 h-11"
          />
          <div class="ml-3">
            <h2 class="text-base font-bold">{{ FullName  }}</h2>
            <p class="text-xs break-all overflow-hidden">
              {{ fullURL }}
            </p>
          </div>
        </div>
        <!-- Trash Icon iconsss -->
        <i class="fas fa-trash w-4 h-4" @click.stop="showModal = true"></i>
      </div>
      <div class="flex justify-between mt-4">
        <!-- Expand Icon -->
        
        <i class="fa-solid fa-circle-check text-[#f16822]" v-if="landing.published" title="Landing publicada"></i>
        <div class="flex items-center space-x-2">
          <!-- Truck Icon -->
          <img
            src="../static/asset/cart.svg"
            alt="cart nelly app"
            class="w-4 h-4"
          />
          <span class="font-xs">{{ landing.vehicles.length }}</span>
          <!-- Book Icon -->
          <i class="fas fa-book w-4 h-4"></i>
          <span class="font-xs">{{ landing.reservations.length }}</span>
        </div>
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
                ¿Estás seguro de que deseas eliminar este landing?
              </h3>
              <button
                @click="deleteLanding(landing.id)"
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
  </div>
</template>

<script>
import Axios from "../axios";

export default {
  name: "CardLanding",
  props: {
    landing: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      URL: `/${this.landing.name}`,
      showModal: false, // Estado del modal
    };
  },
  computed: {
    FullName(){
      const NameLanding = this.landing.name;
      return  NameLanding.replace("-", " ");
    },
    fullURL() {
    const baseURL = import.meta.env.VITE_API_BASE_URL;
    
    console.log(`${baseURL}`);

    return `${baseURL}${this.landing.name}`;
  }
  },
  methods: {
    handle(id) {
      this.$router.push(`/view-landing/${id}`);
    },
    viewlanding() {
      window.open(this.URL, "_blank");
    },

    deleteLanding(id) {
      Axios.delete(`/landing/${id}`)
        .then((response) => {
          this.$emit("deleted", id); // Emite un evento cuando se elimina el landing
          this.showModal = false;
        })
        .catch((error) => {
          console.error(
            "Error al eliminar el landing:",
            error.response ? error.response.data : error.message
          );
        });
    },
  },
};
</script>

<style scoped>
/* Animación emergente */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.4s ease, transform 0.4s ease;
}
.modal-fade-enter, .modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
