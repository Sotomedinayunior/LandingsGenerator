<template>
  <div :style="{ '--primary-color': landing.color_primary }">
    <NavComponents
      :logo="logoLanding"
      :logoTitle="LogoTitle"
      :colorPrimary="color1"
      :colorSecondary="color2"
      :defaultLanguage="currentLang"
      @language-change="onLanguageChange"
    />
    <TabsComponents />
    <section class="wrapper">
      <img
        v-if="vehicle.images && vehicle.images.length > 0"
        :src="url + '/' + vehicle.images[0].path_images"
        :alt="vehicle.name"
        class="w-85 h-auto"
        :title="vehicle.name"
        width="800"
        height="800"
      />
      <div>
        <h2 class="text-gray-700 text-3xl font-bold py-1">
          {{ vehicle.name }}
        </h2>
        <h2 class="text-gray-700 text-sm py-1">
          <span class="text-xs mx-2">Precio por dia</span> {{ vehicle.price }}
        </h2>
        <p class="text-gray-500 text-lg py-1">{{ vehicle.description }}</p>
        <div class="py-8">
          <h2 class="text-left font-bold" :style="{ color: colorPrimary }">
            Características especiales
          </h2>
          <div class="flex space-x-2 my-3">
            <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs">{{
              vehicle.transmision
            }}</span>
            <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs">{{
              vehicle.type_of_car
            }}</span>
            <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs"
              >Personas {{ vehicle.luggage }}</span
            >
          </div>
          <div class="flex space-x-2 my-3">
            <span
              v-for="(item, index) in feature"
              :key="index"
              class="px-3 py-1 bg-gray-200 rounded-lg text-xs"
            >
              {{ item.name }}
            </span>
          </div>
          <a href="#" 
            @click.prevent="Guardar" 
         
            class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300"
          >
            Reservar
          </a>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import TabsComponents from "./components/TabsComponents.vue";

import NavComponents from "./components/NavComponents.vue";
const url = import.meta.env.VUE_APP_API_URL || "https://generator.nellyrac.do/storage"; // Usar variable de entorno
const api = import.meta.env.VUE_APP_API_URL || "https://generator.nellyrac.do/api"; // Usar variable de entorno
import axios from "axios";

export default {
  components: {
    NavComponents,
    TabsComponents,
  },

  data() {
    return {
      currentLanguage: "en",
      galleryImages: [],
      feature: [],
      activeIndex: 0,
      logoLanding: "",
      LogoTitle: "",
      color1: "",
      color2: "",
      vehicle: [],
      landing: [],
      formVehicles: {
        id_vehicle: "",
        id_user: "",
        id_landing: "",
      },
      url:
        import.meta.env.VUE_APP_API_URL || "https://generator.nellyrac.do/storage",
       
      api:
        import.meta.env.VUE_APP_API_URL || "https://generator.nellyrac.do/api",
      site:
      import.meta.env.VUE_APP_API_URL || "https://generator.nellyrac.do/",
    };
  },
  mounted() {
    this.getVehicle();
    this.getLanding();
    this.getFeatures();
    this.updateMetaTags();
  },

  methods: {
    RedirectLink() {
       this.$router.push({ name: "vehicle-additions" });
    },
    getFeatures() {
      // Obtiene las características del vehículo
      axios
        .get(`${this.api}/special-features-public`)
        .then((response) => {
          this.feature = response.data;
          console.log(this.feature);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    prevImage() {
      this.activeIndex =
        this.activeIndex === 0
          ? this.vehicle.images.length - 1
          : this.activeIndex - 1;
    },
    nextImage() {
      this.activeIndex =
        this.activeIndex === this.vehicle.images.length - 1
          ? 0
          : this.activeIndex + 1;
    },

    metaInfo() {
      return {
        title: this.landing?.meta_title || "vehiculo",
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
    changeLanguage(language) {
      this.currentLanguage = language;
    },
    retorn() {
      this.$router.push({ name: "vehicle" });
    },
    Guardar() {
      // Asignar los valores al objeto formVehicles

      this.formVehicles.id_vehicle = this.$route.params.idvehicle; // ID del vehículo
      this.formVehicles.title = this.vehicle.name; // Título del vehículo

      // Comprobar si hay imágenes disponibles y almacenar la ruta de la primera imagen
      if (this.vehicle.images && this.vehicle.images.length > 0) {
        this.formVehicles.image_path =
          this.url + "/" + this.vehicle.images[0].path_images;
      } else {
        this.formVehicles.image_path = null; // En caso de que no haya imagen disponible
      }

      console.log("Datos a guardar en localStorage:", this.formVehicles);

      // Guardar los datos en localStorage
      localStorage.setItem("formVehicles", JSON.stringify(this.formVehicles));

      // Redirigir a otra ruta
      this.$router.push({ name: "vehicle-additions" });
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

    getLanding() {
      const NameLandingId = this.$route.params.name;

      axios
        .get(`${this.api}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.logoLanding = response.data.landing.logo;
          this.landing = response.data.landing;
          this.LogoTitle = response.data.landing.name;
          this.color1 = response.data.landing.color_primary;
          this.color2 = response.data.landing.color_secondary;
          this.vehicles = response.data.landing.vehicles;

          console.log("Info de la landing", this.landing);
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

    getVehicle() {
      const idUser = this.$route.params.userid;
      const idvehicle = this.$route.params.idvehicle;
      const name = this.$route.params.name;

      axios
        .get(`${this.api}/publicLanding/${name}/vehicle/${idvehicle}`)
        .then((response) => {
          if (response.data.vehicle) {
            this.vehicle = response.data.vehicle;
          } else {
            console.warn("No se encontró información del vehículo.");
            this.vehicle = { images: [] }; // Asignación segura si no hay datos
          }
          console.log("Info del vehicle", this.vehicle);
        })
        .catch((error) => {
          console.error("Error al obtener el vehículo:", error);
          this.vehicle = { images: [] }; // Inicializa vehicle con un array vacío en caso de error
        });
    },
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
};
</script>

<style scoped>
.wrapper {
  display: grid;
  margin-top: 30px;
  gap: 50px;
  grid-auto-flow: column;

  grid-template-columns: auto auto;
}
/* media query */
@media (max-width: 578px) {
  .wrapper {
    grid-template-columns: 1fr;
    grid-auto-flow: row;
  }
}
</style>
