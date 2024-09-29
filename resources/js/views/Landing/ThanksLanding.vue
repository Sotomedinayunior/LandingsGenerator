<template>
    <div class="container mt-11">
      <div v-if="vehicles">
        <NavComponents
          :logo="logoLanding"
          :logoTitle="LogoTitle"
          :colorPrimary="color1"
          :colorSecondary="color2"
          :defaultLanguage="currentLang"
          @language-change="onLanguageChange"
        />
        <section class="flex justify-center items-center ">
            <img src="./asset/check.png" alt="Existo" class="w-44 h-auto">
            <p>En breve uno de nuestros representates estarán comunicandote.</p>
            <button class="bg-gray-600 p-5">Aceptar</button>
        </section>

        
       
      </div>
      <div v-else>
        <h1>{{ message }}</h1>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import TabsComponents from "./components/TabsComponents.vue";
  import CardAuto from "./components/CardAuto.vue";
  import NavComponents from "./components/NavComponents.vue";
  const url = import.meta.env.VUE_APP_API_URL || "http://localhost:8000/api"; // Usar variable de entorno
  
  export default {
    components: { TabsComponents, CardAuto, NavComponents },
    data() {
      return {
        vehicles: [],
        currentLanguage: "en",
        logoLanding: "",
        LogoTitle: "",
        color1: "",
        color2: "",
        message: "",
      };
    },
    mounted() {
      this.getVehicles();
    },
    methods: {
      getVehicles() {
        const NameLandingId = this.$route.params.name;
  
        axios
          .get(`${url}/publicLanding/${NameLandingId}`)
          .then((response) => {
            this.logoLanding = response.data.landing.logo;
            this.LogoTitle = response.data.landing.name;
            this.color1 = response.data.landing.color_primary;
            this.color2 = response.data.landing.color_secondary;
            this.vehicles = response.data.landing.vehicles;
            console.log(
              `aqui estan la info de los vehicles`,
              this.vehicles,
              this.logoLanding,
              this.color1,
              this.color2
            );
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
    },
  };
  </script>
  
  <style scoped>
  h1 {
    color: blue;
  }
  </style>
  