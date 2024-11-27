<template>
  <div class="" >
    <div v-if="vehicles" :style="{ '--primary-color': landing.color_primary }">
      <NavComponents
        :logo="logoLanding"
        :logoTitle="LogoTitle"
        :colorPrimary="color1"
        :colorSecondary="color2"
 
      />
      <section
        class="flex flex-col justify-center items-center min-h-screen mx-auto text-center bg-gray-50"
      >
        <!-- Check Animado -->
        <div class="checkmark-container mb-6">
          <div class="checkmark"></div>
        </div>
        <!-- Título -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ name }}</h1>
        <!-- Mensaje -->
        <p class="text-xs text-gray-600 mb-6">
          {{ $t("representative_contact") }}
        </p>

        <!-- Botón -->
        <button
  class="bg-gray-600 hover:bg-gray-700 p-3 px-6 text-white rounded-lg"
>
  {{ $t('accept') }}
</button>

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
const url = import.meta.env.VITE_API_URL; // Usar variable de entorno

export default {
  components: { TabsComponents, CardAuto, NavComponents },
  data() {
    return {
      vehicles: [],
      currentLanguage: null,
      landing:[],


      logoLanding: "",
      LogoTitle: "",
      color1: "",
      color2: "",
      name: "",
      message: "",
    };
  },
  mounted() {
    this.getVehicles();
    this.name = localStorage.getItem("NameUser");
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
          this.landing = response.data.landing;
          const landingLanguage = response.data.landing.default_language;
          console.log(`aqui estan la info de los vehicles`, landingLanguage);
          this.changeLanguage(landingLanguage);
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
::selection {
  background-color: var(--primary-color);
  color: #fff;
}


/* Contenedor del check */
.checkmark-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background-color: #4caf50; /* Color verde */
  position: relative;
  animation: popIn 0.5s ease-out forwards;
}

/* Check dibujado */
.checkmark {
  width: 25px;
  height: 50px;
  border: solid white;
  border-width: 0 6px 6px 0;
  transform: rotate(45deg);
  position: absolute;
  top: 10px;
  left: 28px;
  opacity: 0;
  animation: drawCheck 0.5s ease-out 0.5s forwards;
}

/* Animación del check */
@keyframes drawCheck {
  0% {
    opacity: 0;
    transform: rotate(45deg) scale(0);
  }
  100% {
    opacity: 1;
    transform: rotate(45deg) scale(1);
  }
}

/* Animación del fondo */
@keyframes popIn {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
</style>
