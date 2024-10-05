<template>
  <div class="container">
    <NavComponents
      :logo="logoLanding"
      :logoTitle="LogoTitle"
      :colorPrimary="color1"
      :colorSecondary="color2"
      :defaultLanguage="currentLang"
      @language-change="onLanguageChange"
    />
    <TabsComponents />
    <button
      class="border border-blue-500 text-blue-500 rounded-lg px-4 py-2 hover:bg-blue-100"
      @click="retorn"
    >
      Atrás
    </button>
    <section class="flex mx-auto items-center">
      <div class="w-1/2">
        <img
          v-if="vehicle.images && vehicle.images.length > 0"
          class="rounded-[8px] w-auto h-auto"
          :src="url + '/' + vehicle.images[0].path_images"
          :alt="vehicle.name"
        />
        <p v-else>No image available</p>
      </div>
      <div class="flex flex-col w-1/2">
        <h2 class="text-2xl text-slate-950 font-bold text-left mb-3">
          {{ vehicle.name }}
        </h2>
        <div class="flex items-center space-x-2 mb-3">
          <span class="font-bold">+US${{ vehicle.price }}</span>
          <span class="text-gray-500 mb-3">/per day</span>
        </div>
        <p class="mb-3">{{ vehicle.description }}</p>
        <h2 class="text-2xl text-gray-500 text-left mb-3">Features</h2>
        <div class="grid grid-cols-4 gap-2">
          <span class="px-1 py-1 text-center text-xs bg-gray-400 rounded-lg"
            >{{ vehicle.luggage }} Maletas</span
          >
          <span class="px-1 py-1 text-center text-xs bg-gray-400 rounded-lg"
            >{{ vehicle.people }} personas</span
          >
          <span class="px-1 py-1 text-center text-xs bg-gray-400 rounded-lg"
            >{{ vehicle.type_of_car }}
          </span>
          <span class="px-1 py-1 text-center text-xs bg-gray-400 rounded-lg">{{
            vehicle.transmision
          }}</span>
        </div>
        <h2 class="text-2xl text-gray-500 text-left mb-3">Special Features</h2>
        <div>
          <span class="px-1 py-1 text-center text-xs bg-gray-400 rounded-lg"
            >Bluetooth</span
          >
        </div>
        <div class="flex justify-end">
          <button
            @click="Guardar()"
            class="bg-slate-700 text-white font-bold text-xs p-2 rounded-lg"
          >
            Continuar
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import TabsComponents from "./components/TabsComponents.vue";
import NavComponents from "./components/NavComponents.vue";
const url = import.meta.env.VUE_APP_API_URL || "http://localhost:8000/api"; // Usar variable de entorno
import axios from "axios";
export default {
  components: {
    TabsComponents,
    NavComponents,
  },
  data() {
    return {
      currentLanguage: "en",
      logoLanding: "",
      LogoTitle: "",
      color1: "",
      color2: "",
      vehicle: [],
      landing:[],
      formVehicles: {
        id_vehicle: "",
        id_user: "",
        id_landing: "",
      },
      url: "http://localhost:8000/storage",
    };
  },
  mounted() {
    this.getVehicle();
    this.getLanding();
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
        .get(`${url}/publicLanding/${NameLandingId}`)
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
        .get(`${url}/publicLanding/${name}/vehicle/${idvehicle}`)
        .then((response) => {
          this.vehicle = response.data.vehicle;
          console.log("Info del vehicle", this.vehicle);
        })
        .catch((error) => {
          console.log("Error", error);
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
h1 {
  color: #42b983;
}
</style>
