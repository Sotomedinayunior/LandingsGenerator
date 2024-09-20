<template>
  <div class="container">
    <!-- Mostrar los detalles de la landing si fue encontrada -->
    <div v-if="landing">
      <header
        class="container max-w-screen-lg mx-auto flex justify-between items-center p-4 bg-white"
      >
        <!-- Logo -->
        <div class="flex">
          <img
            :src="landing.logo"
            :alt="landing.name"
            :title="landing.name"
            class="w-[112px] h-auto"
          />
        </div>

        <!-- Menú de navegación (oculto en pantallas pequeñas) -->
        <nav
          :class="isMenuOpen ? 'block' : 'hidden'"
          class="absolute top-full left-0 w-full bg-white md:relative md:block md:w-auto md:bg-transparent"
        >
          <ul class="flex flex-col items-center md:flex-row md:space-x-4 font-bold text-xs">
            <li>
              <a href="#" class="p-2 hover:underline">{{ $t("overview") }}</a>
            </li>
            <li>
              <a href="#vehicle" class="p-2 hover:underline">{{
                $t("vehicle")
              }}</a>
            </li>
            <li>
              <a href="#about" class="p-2 hover:underline">{{ $t("about_us") }}</a>
            </li>
            <div class="relative inline-block text-left">
              <select
                v-model="currentLanguage"
                @change="changeLanguage($event.target.value)"
                :style="{'background-color': landing.color_primary , 'color':landing.color_secondary}"

                class="block w-full px-4 py-2 text-sm font-medium  border rounded-md shadow-sm focus:outline-none focus:ring-2  transition duration-300 ease-in-out"
              >
                <option value="en">EN</option>
                <option value="es">ES</option>
              </select>
            </div>
          </ul>
        </nav>
      </header>

      <section class="slider">
        <div class="d-flex justify-center items-center flex-col">
          <h1 class="text-center text-5xl font-bold text-white">
            {{ $t("Rent") }}
          </h1>
          <p class="text-center text-3xl font-normal text-white">
            {{ $t("Find") }}
          </p>
          <div class="pickup">
            <form @submit="enviar">
              <div class="flex flex-row justify-between">
                <select
                  class="p-1 rounded-lg text-xs text-gray-300 focus:outline-none"
                  v-model="formValidate.departure"
                >
                  <option disabled selected>{{ $t("selected_location") }}</option>
                  <option
                    v-for="location in locations.place_of_departure"
                    :key="location.id"
                    :value="location.place_of_departure"
                    name="place_of_departure"
                    
                    
                  ></option>
                </select>
                <select
                  class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                >
                  <option disabled selected
                    >Add Different Return Location</option
                  >
                  <option
                    v-for="location in locations.arrival_place"
                    :key="location.id"
                    :value="location.arrival_place"
                  ></option>
                </select>
                <div class="flex flex-col">
                  <label for="Asientos" class="text-sm font-bold text-gray-400"
                    >Asientos</label
                  >
                  <select
                    class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                  >
                    <option disabled selected>4</option>
                    <option
                      v-for="location in locations.number_of_persons"
                      :key="location.id"
                      :value="location.number_of_persons"
                    ></option>
                  </select>
                </div>

                <div class="flex flex-col">
                  <label
                    for="Fecha de salida"
                    class="text-sm font-bold text-gray-400"
                    >Fecha de salida</label
                  >
                  <div>
                    <input
                      type="date"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="2024-02-12"
                    />
                    <input
                      type="time"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="10:00"
                    />
                  </div>
                </div>
                <div class="flex flex-col">
                  <label
                    for="Fecha de Retorno"
                    class="text-sm font-bold text-gray-400"
                    >Fecha de Retorno</label
                  >
                  <div>
                    <input
                      type="date"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="2024-02-12"
                      v-model=""
                    />
                    <input
                      type="time"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="10:00"
                    />
                  </div>
                </div>
                <button class="bg-gray-600 text-white px-5 py-1 rounded">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>
      <section class="container max-w-screen-lg mx-auto p-5 mb-5" id="vehicle">
        <h2 class="text-2xl font-bold text-slate-950 text-left">
         {{ $t('About_vehicle') }}
         
        </h2>
        <div v-if="vehicles">
          <div v-for="item in vehicles">
            <CardVehicle :name />
          </div>
        </div>
        <h2 v-else>{{ $t('no_vehicle') }}</h2>
      </section>
      <section
        class="container max-w-screen-lg mx-auto p-5 grid grid-cols-2 gap-6 sm:grid-cols-2"
        id="about"
      >
        <div class="vehicle"></div>
        <div class="flex flex-col justify-center">
          <h2 class="text-2xl font-bold text-slate-950 text-left mb-7">
            How it works
          </h2>
          <ul class="space-y-4">
            <li class="flex items-start mb-7">
              <span
                class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-white font-bold mr-4"
                >1</span
              >
              <div>
                <h3 class="font-semibold text-slate-950">Select Your Car</h3>
                <p class="text-slate-600">
                  Browse our fleet and choose the one that fits your needs.
                </p>
              </div>
            </li>
            <li class="flex items-start mb-7">
              <span
                class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-white font-bold mr-4"
                >2</span
              >
              <div>
                <h3 class="font-semibold text-slate-950">Book Your Ride</h3>
                <p class="text-slate-600">
                  Fill out the booking form with your details and trip dates.
                </p>
              </div>
            </li>
            <li class="flex items-start mb-7">
              <span
                class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-white font-bold mr-4"
                >3</span
              >
              <div>
                <h3 class="font-semibold text-slate-950">Enjoy Your Trip</h3>
                <p class="text-slate-600">
                  Drive safely and enjoy your trip! Return the car at your
                  convenience.
                </p>
              </div>
            </li>
          </ul>
        </div>
      </section>
      <footer class="bg-slate-100 p-5 flex flex-col">
        <p class="text-slate-600 text-center">
          ©{{ landing.name }}{{ $t('footer_text') }}
        </p>
      </footer>
    </div>

    <!-- Mostrar un mensaje si no se encuentra la landing -->
    <div v-else-if="message">
      <h2 class="text-center text-gray-950 font-semibold text-sm">
        {{ message }}
      </h2>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import CardVehicle from "./components/CardVehicle.vue";
const url = import.meta.env.VUE_APP_API_URL || "http://localhost:8000/api"; // Usar variable de entorno

export default {
  components: { CardVehicle },
  data() {
    return {
      landing: null, // Para almacenar los datos de la landing si se encuentran
      message: "", // Para almacenar el mensaje de error
      locations: null,
      formValidate:{
        departure:'',
        arrival_place:'',
        number_of_persons:'',
      },

      vehicles: {},
      currentLanguage: "en",
    };
  },

  mounted() {
    this.getLanding();
  },

  methods: {
    getLanding() {
      const NameLandingId = this.$route.params.name;
      const userId = this.$route.params.id;

      axios
        .get(`${url}/publicLanding/${userId}/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.locations = response.data.landing.locations;
          this.vehicle = response.data.landing.vehicles;
          console.log(response.data.landing.vehicles);
        })
        .catch((err) => {
          // si ocurre un error (como un 404), mostrar el mensaje de error
          if (err.response && err.response.status === 404) {
            this.message = "Landing no encontrada o ha sido eliminada.";
          } else {
            this.message = "Ocurrió un error al buscar la landing.";
          }
        });
    },
    changeLanguage(language) {
      this.$i18n.locale = language;
      this.currentLanguage = language;
    },
    enviar(e){
      e.preventDefault();
      console.log("enviar...")
    }
  },
  created() {
    this.currentLanguage = this.$i18n.locale;
  },
};
</script>

<style scoped>
.pickup {
  display: flex;
  background-color: white;
  padding: 15px;
  border-radius: 8px;
}
.slider {
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: url("./asset/Slider.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center center;
  min-height: 400px;
}
.vehicle {
  background-image: url("./asset/vehicle.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  min-height: 350px;
  border-radius: 8px;
}
</style>
