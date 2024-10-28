<template>
  <div>
    <!-- Mostrar los detalles de la landing si fue encontrada -->
    <div v-if="landing" :style="{ '--primary-color': landing.color_primary }">
      <HeaderComponents
        :logo="landing.logo"
        :name="landing.name"
        :primaryColor="landing.color_primary"
        :secondaryColor="landing.color_secondary"
        @language-change="changeLanguage"
      />

      <section class="slider fade-in">
        <div class="d-flex justify-center items-center flex-col">
          <h1 class="text-center text-6xl bold text-white text-wrap mb-8">
            {{ $t("Rent") }}
          </h1>
          <p
            class="text-center text-3xl font-normal text-white text-wrap mb-10"
          >
            {{ $t("Find") }}
          </p>
          <div class="pickup">
            <form @submit="SubmitForm">
              <div class="flex flex-row justify-between">
                <div class="flex-col">
                  <label
                    for="Lugar de salida"
                    class="text-xs font-semibold text-gray-900 mb-5"
                    >{{ $t("pick_up_and_return") }}</label
                  >
                  <div class="flex">
                    <select
                      class="px-5 rounded-lg text-xs text-gray-500 focus:outline-none bg-gray-200 cursor-pointer"
                      v-model="formValidate.place_of_departure"
                    >
                      <option disabled value="">{{
                        $t("selected_location")
                      }}</option>
                      <!-- Iteramos sobre el array de locations -->
                      <option
                        v-for="location in locations"
                        :key="location.id"
                        :value="location.place_of_departure"
                      >
                        {{ location.place_of_departure }}
                      </option>
                    </select>

                    <select
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none cursor-pointer"
                      v-model="formValidate.arrival_place"
                    >
                      <option disabled value="">{{
                        $t("add_different_return_location")
                      }}</option>
                      <!-- Iteramos sobre el array de locations -->
                      <option
                        v-for="location in locations"
                        :key="location.id"
                        :value="location.arrival_place"
                      >
                        {{ location.arrival_place }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="flex flex-col mx-2">
                  <label
                    for="Asientos"
                    class="text-xs font-semibold text-gray-900 mb-1"
                    >{{ $t("seats") }}</label
                  >
                  <select
                    class="p-3 rounded-lg text-sm text-gray-500 focus:outline-none bg-gray-200 cursor-pointer"
                    v-model="formValidate.number_of_persons"
                  >
                    <option disabled value="">4</option>
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
                    class="text-xs font-semibold text-gray-900 mb-1"
                  >
                    {{ $t("departure_date") }}</label
                  >
                  <div>
                    <input
                      type="date"
                      class="px-3 rounded-lg text-xs text-gray-300 focus:outline-none"
                      value="2024-02-12"
                      v-model="formValidate.date_of_departure"
                    />
                    <input
                      type="time"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="10:00"
                      v-model="formValidate.time_of_departure"
                    />
                  </div>
                </div>
                <div class="flex flex-col">
                  <label
                    for="Fecha de Retorno"
                    class="text-xs font-semibold text-gray-900 mb-1"
                  >
                    {{ $t("return_date") }}</label
                  >
                  <div>
                    <input
                      type="date"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="2024-02-12"
                      v-model="formValidate.date_of_arrival"
                    />
                    <input
                      type="time"
                      class="p-3 rounded-lg text-sm text-gray-300 focus:outline-none"
                      value="10:00"
                      v-model="formValidate.time_of_arrival"
                    />
                  </div>
                </div>
                <div class="flex justify-center items-center mt-6">
                  <button class="bg-gray-600 text-white px-5 py-1 rounded">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
      <section
        class="container max-w-screen-lg mx-auto py-5 my-7 fade-in"
        id="vehicle"
      >
        <h2 class="text-4xl font-bold text-slate-950 text-left">
          {{ $t("About_vehicle") }}
        </h2>

        <!-- Validar si hay vehículos disponibles -->
        <div v-if="vehicles.length > 0" class="grid grid-cols-2 gap-4 mt-5">
          <CardVehicle
            v-for="vehicle in vehicles.slice(0, 4)"
            :key="vehicle.id"
            :vehicle="vehicle"
            :primaryColor="landing.color_primary"
            :secondaryColor="landing.color_secondary"
          />
        </div>

        <!-- Mensaje si no hay vehículos disponibles -->
        <div v-else class="text-center text-gray-500 mt-5">
          <p>{{ $t("no_vehicles_available") }}</p>
        </div>
      </section>

      <section
        class="container max-w-screen-lg mx-auto p-5 grid grid-cols-2 gap-6 fade-in"
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
      <footer
        class="bg-slate-100 p-5 flex flex-col justify-center item fade-in"
      >
        <p class="text-slate-600 text-center">
          ©{{ landing.name }}{{ $t("footer_text") }}
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
import { defineAsyncComponent } from "vue";
const url =
  import.meta.env.VUE_APP_API_URL ||
  (import.meta.env.PROD
    ? "https://generator.nellyrac.do/api"
    : "http://localhost:8000/api");

import axios from "axios";
const HeaderComponents = defineAsyncComponent(() =>
  import("./components/HeaderComponents.vue")
);
const CardVehicle = defineAsyncComponent(() =>
  import("./components/CardVehicle.vue")
);

export default {
  components: {
    HeaderComponents,
    CardVehicle,
  },

  data() {
    return {
      landing: null, // Para almacenar los datos de la landing si se encuentran
      message: "", // Para almacenar el mensaje de error
      locations: null,
      isVisible: false,
      formValidate: {
        place_of_departure: "",
        arrival_place: "",
        number_of_persons: "",
        date_of_departure: "",
        departure_date: "",
        time_of_departure: "",
        date_of_arrival: "",
        time_of_arrival: "",
        id_landing: "",
      },

      vehicles: [],
      currentLanguage: null,
    };
  },

  mounted() {
    this.getLanding();
  },

  methods: {
    metaInfo() {
      return {
        title: this.landing?.meta_title || "Default Title",
        meta: [
          {
            name: "description",
            content: this.landing?.meta_description || "Default description",
          },
          {
            name: "viewport",
            content: "width=device-width, initial-scale=1.0",
          },
          { name: "keywords", content: this.landing?.meta_keywords || "" },
          {
            property: "og:title",
            content: this.landing?.og_title || "Default OG Title",
          },
          {
            property: "og:description",
            content: this.landing?.og_description || "Default OG Description",
          },
          {
            property: "og:image",
            content: this.landing?.og_image || "default-image-url.jpg",
          },
          { name: "robots", content: this.landing?.robots || "index, follow" },
          {
            rel: "canonical",
            href: this.landing?.canonical_url || window.location.href,
          },
        ],
      };
    },
    getLanding() {
      const NameLandingId = this.$route.params.name;

      axios
        .get(`${url}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.locations = response.data.landing.locations;
          this.vehicles = response.data.landing.vehicles;
          console.log(response.data.landing.vehicles);
          const landingLanguage = this.landing.default_language; // Aquí puedes cambiar 'es' por el idioma que quieras como predeterminado

          this.changeLanguage(landingLanguage);

          console.log(
            `aqui esta los locations`,
            this.locations[0].place_of_departure
          );
          console.log(`aqui estan la info de los vehicles`, this.vehicles);
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
    updateMetaTags() {
      const metaData = this.metaInfo();

      // Actualiza el título de la página
      document.title = metaData.title;

      // Eliminar meta tags existentes (si es necesario)
      const existingMetaTags = document
        .querySelectorAll("meta")
        .forEach((meta) => meta.remove());
      existingMetaTags.forEach((tag) => tag.parentNode.removeChild(tag));

      // Añadir nuevos meta tags
      metaData.meta.forEach((metaTag) => {
        const meta = document.createElement("meta");
        Object.keys(metaTag).forEach((key) => {
          meta.setAttribute(key, metaTag[key]);
        });
        document.head.appendChild(meta);
      });
    },
    SubmitForm(e) {
      e.preventDefault();
      this.formValidate.place_of_departure =
        this.formValidate.place_of_departure || "santiago";
      this.formValidate.arrival_place =
        this.formValidate.arrival_place || "La Romana"; // Por ejemplo, La Romana
      this.formValidate.number_of_persons =
        this.formValidate.number_of_persons || "2"; // Por ejemplo, 1 persona
      this.formValidate.date_of_departure =
        this.formValidate.date_of_departure || "01-01-2024"; // Por ejemplo, una fecha por defecto
      this.formValidate.time_of_departure =
        this.formValidate.time_of_departure || "12:00 AM"; // Por ejemplo, 12:00 PM
      this.formValidate.date_of_arrival =
        this.formValidate.date_of_arrival || "02-01-2024"; // Otra fecha por defecto
      this.formValidate.time_of_arrival =
        this.formValidate.time_of_arrival || "12:00 PM"; // Por ejemplo, 12:00 PM

      //metodo para almacenar los datos del formulario en la localstorage y redirigir CartLanding
      this.formValidate.id_landing = this.landing.id;
      localStorage.setItem("formValidate", JSON.stringify(this.formValidate));
      return this.$router.push({ name: "vehicle" });
    },

    changeLanguage(language) {
      this.$i18n.locale = language;
      this.currentLanguage = language;
    },
  },

  created() {
    this.currentLanguage = this.$i18n.locale;
  },
};
</script>

<style scoped>
::selection {
  background-color: var(--primary-color);
  color: #fff;
}

.pickup {
  display: flex;
  font-family: "Cera Round Pro", sans-serif;
  background-color: white;
  padding: 12px;
  min-width: 100%;
  border-radius: 8px;
}
.slider {
  display: flex;
  justify-content: center;
  font-family: "Cera Round Pro", sans-serif;
  align-items: center;
  background-image: url("./asset/Slider.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  margin-top: 40px;
  min-height: 390px;
}
.vehicle {
  background-image: url("./asset/vehicle.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  min-height: 380px;
  border-radius: 8px;
}
.fade-in {
  opacity: 0; /* Inicialmente invisible */
  animation: fadeIn 0.5s forwards; /* Llama a la animación */
}
@media only screen and(max-width: 578px) {
  body {
    overflow-x: hidden;
  }
  .pickup {
    display: none;
  }
}

@keyframes fadeIn {
  0% {
    opacity: 0; /* Al inicio, completamente invisible */
    transform: translateY(20px); /* Desplazado hacia abajo */
  }
  100% {
    opacity: 1; /* Al final, completamente visible */
    transform: translateY(0); /* Regresa a la posición original */
  }
}
</style>
