<template>
  <div v-if="landing">
    <NavComponents
      :logo="logoLanding"
      :logoTitle="LogoTitle"
      :colorPrimary="color1"
      :colorSecondary="color2"
      :defaultLanguage="currentLanguage"
      @language-change="changeLanguage"
    />
    <main class="grid grid-cols-2 gap-5">
      <section class="py-10 px-5">
        <h2 class="text-2xl font-semibold mb-4">Overview</h2>

        <div class="border rounded-lg p-4 bg-gray-100">
          <h2 class="text-lg font-semibold">Order Details</h2>
          <div class="flex flex-col">
            <h2 class="text-sm text-gray-700 my-5">Date & Location</h2>
            <div class="flex items-center whitespace-nowrap">
              <h2 class="text-xs font-bold">Pickup -</h2>
              <span class="text-xs ml-2">{{ Tabs1.place_of_departure }}</span>
              <img
                src="./asset/line.png"
                alt="line"
                width="40"
                height="30"
                class="mx-3"
              />
              <h2 class="text-xs font-bold ml-2">Return -</h2>
              <span class="text-xs ml-2">{{ Tabs1.arrival_place }}</span>
            </div>
          </div>
          <div class="flex items-center whitespace-nowrap my-2">
            <h2 class="text-xs font-bold whitespace-nowrap">
              {{ formatDate(Tabs1.date_of_arrival) }}
            </h2>
            <img src="./asset/circle.png" alt="" class="mx-3" />
            <h2 class="text-xs font-bold">{{ Tabs1.time_of_arrival }}</h2>
            <h2 class="text-xs font-bold ml-4">
              {{ formatDate(Tabs1.date_of_departure) }}
            </h2>
            <img src="./asset/circle.png" alt="" class="mx-3" />
            <h2 class="text-xs font-bold">{{ Tabs1.time_of_departure }}</h2>
          </div>
          <div class="flex flex-col">
            <h2 class="text-sm text-gray-700 my-2">Vehicle</h2>
            <div class="flex items-center">
              <img
                :src="Tabs2.image_path"
                :alt="Tabs2.title"
                class="w-20 h-auto"
              />
              <h2 class="text-xs font-bold mb-3 mx-3">
                {{ Tabs2.title }}
              </h2>
            </div>
          </div>
        </div>
      </section>
      <section></section>
    </main>
  </div>
  <div v-else>
    <h1>{{ message }}</h1>
  </div>
</template>

<script>
import axios from "axios";
import NavComponents from "./components/NavComponents.vue";
const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

export default {
  components: { NavComponents },
  data() {
    return {
      message: "Hola Mundo",
      currentLanguage: "en",
      logoLanding: "",
      LogoTitle: "",
      color1: "",
      color2: "",
      landing: null, // Declarar landing
      vehicles: [], // Declarar vehicles
      Tabs1: [],
      Tabs2: [],
      Tabs3: [],
    };
  },

  created() {
    this.getVehicles();
    this.getTabs();
  },
  methods: {
    getVehicles() {
      const NameLandingId = this.$route.params.name;

      axios
        .get(`${url}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.logoLanding = this.landing.logo;
          this.LogoTitle = this.landing.name;
          this.color1 = this.landing.color_primary;
          this.color2 = this.landing.color_secondary;

          console.log(
            `Info de los vehicles`,
            this.vehicles,
            this.logoLanding,
            this.color1,
            this.color2
          );
        })
        .catch((err) => {
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
    getTabs() {
      const storedTabs = localStorage.getItem("formValidate");
      const storedTabs1 = localStorage.getItem("formVehicles");
      const storedTabs2 = localStorage.getItem("selectedProduct"); // Asegúrate de que esta línea esté presente

      if (storedTabs) {
        this.Tabs1 = JSON.parse(storedTabs);
        console.log(`Tabs list`, this.Tabs1.place_of_departure);
      } else {
        console.log("No data found in localStorage for formValidate");
      }

      if (storedTabs1) {
        this.Tabs2 = JSON.parse(storedTabs1);
        console.log(`Tabs list ggggg`, this.Tabs2);
      } else {
        console.log("No data found in localStorage for formVehicles");
      }

      if (storedTabs2) {
        this.Tabs3 = JSON.parse(storedTabs2);
        console.log(`Tabs list products ext`, this.Tabs3);
      } else {
        console.log("No data found in localStorage for formProducts");
      }
    },
    formatDate(dateString) {
      // Verificar si la cadena de fecha está definida y tiene el formato correcto
      if (!dateString || !/^\d{2}-\d{2}-\d{4}$/.test(dateString)) {
        console.error(
          "Formato de fecha inválido o cadena indefinida:",
          dateString
        );
        return dateString || "Fecha no disponible"; // Retornar un valor por defecto si es undefined o null
      }

      // Dividir la cadena en día, mes, año
      const [day, month, year] = dateString.split("-");

      // Crear un nuevo objeto de fecha
      const date = new Date(`${year}-${month}-${day}`);

      // Verificar si la fecha es válida
      if (isNaN(date.getTime())) {
        console.error("Fecha inválida:", dateString);
        return dateString;
      }

      // Configurar las opciones de formato
      const options = { day: "numeric", month: "short", year: "numeric" };

      // Retornar la fecha formateada
      return date.toLocaleDateString("es-ES", options);
    },
  },
};
</script>

<style scoped></style>
