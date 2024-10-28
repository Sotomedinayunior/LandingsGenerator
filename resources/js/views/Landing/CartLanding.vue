<template>
  <div>
    <div v-if="vehicles" :style="{ '--primary-color': color2 }">
      <NavComponents
        :logo="logoLanding"
        :logoTitle="LogoTitle"
        :colorPrimary="color1"
        :colorSecondary="color2"
        :defaultLanguage="currentLang"
        @language-change="onLanguageChange"
      />
      <section class="w-full">
        <TabsComponents />
      </section>
      <section class="wrapper-content">
        <aside class="p-10 flex flex-col space-y-11">
          <div
            class="flex py-3 justify-between items-center border-b border-gray-300"
          >
            <div class="flex">
              <img src="./asset/User.png" alt="" />
              <h2>Capacidad</h2>
            </div>
            <img src="./asset/vector.png" alt="" />
          </div>
          <div
            class="flex py-3 justify-between items-center border-b border-gray-300"
          >
            <div class="flex">
              <img src="./asset/cart.png" alt="" />
              <h2>Tipo de Vehículo</h2>
            </div>
            <img src="./asset/vector.png" alt="" />
          </div>
          <div
            class="flex py-3 justify-between items-center border-b border-gray-300"
          >
            <div class="flex">
              <img src="./asset/bag.png" alt="" />
              <h2>Equipaje</h2>
            </div>
            <img src="./asset/vector.png" alt="" />
          </div>
          <div
            class="flex py-3 justify-between items-center border-b border-gray-300"
          >
            <div class="flex">
              <img src="./asset/cart.png" alt="" />
              <h2>Marca</h2>
            </div>
            <img src="./asset/vector.png" alt="" />
          </div>
          <div
            class="flex py-3 justify-between items-center border-b border-gray-300"
          >
            <div class="flex">
              <img src="./asset/transmision.png" alt="" />
              <h2>Transmisión</h2>
            </div>
            <img src="./asset/vector.png" alt="" />
          </div>
          <div
            class="flex py-3 justify-between items-center border-b border-gray-300"
          >
            <div class="flex">
              <img src="./asset/bluetooh.png" alt="" />
              <h2>Características</h2>
            </div>
            <img src="./asset/vector.png" alt="" />
          </div>
        </aside>
        <main class="wrapper-cards">
          <CardAuto
            v-for="vehicle in vehicles"
            :key="vehicle.id"
            :vehicle="vehicle"
            :colorPrimary="color1"
            :colorSecondary="color2"
          />
        </main>
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
      landing: [],
      LogoTitle: "",
      color1: "",
      color2: "",
      message: "",
    };
  },
  mounted() {
    this.getVehicles();
    this.updateMetaTags();
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
    getVehicles() {
      const NameLandingId = this.$route.params.name;

      axios
        .get(`${url}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.logoLanding = response.data.landing.logo;
          this.LogoTitle = response.data.landing.name;
          this.color1 = response.data.landing.color_primary;
          this.color2 = response.data.landing.color_secondary;
          this.vehicles = response.data.landing.vehicles;

          // Asignar el color a la variable CSS
          document.documentElement.style.setProperty('--primary-color', this.color1);

          this.updateMetaTags();
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
      const existingMetaTags = document.querySelectorAll(
        "meta[name], meta[property]"
      );
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
    changeLanguage(language) {
      this.$i18n.locale = language;
      this.currentLanguage = language;
    },
  },
};
</script>

<style scoped>
.wrapper-content {
  display: grid;
  grid-template-columns: 1fr 3fr;
  margin: 20px 0px 0px 0px;
}
.wrapper-cards {
  display: grid;
  grid-template-columns: auto auto;
  gap: 10px;
  margin: 20px 20px 0px 0px;
}
@media screen and (max-width: 576px) {
  .wrapper-cards {
    grid-template-columns: auto;
  }
  .wrapper-content {
    grid-template-columns: 1fr;
  }
}

::selection {
  background-color: var(--primary-color) !important;
  color: #fff !important;
}
</style>
