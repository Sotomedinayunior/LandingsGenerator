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
      <!-- Carrusel de imágenes -->
      <div v-if="vehicle.images && vehicle.images.length > 1" class="carousel-container">
        <button @click="prevImage" class="carousel-btn prev-btn"><</button>
        <img
          :src="url + '/' + vehicle.images[activeIndex].path_images"
          :alt="vehicle.name"
          class="carousel-image"
          :title="vehicle.name"
          width="400"
          height="400"
        />
        <button @click="nextImage" class="carousel-btn next-btn">></button>
      </div>
      <!-- Si solo hay una imagen, mostrarla normalmente -->
      <img v-else
        v-if="vehicle.images && vehicle.images.length > 0"
        :src="url + '/' + vehicle.images[0].path_images"
        :alt="vehicle.name"
        class="w-full h-85"
        :title="vehicle.name"
        width="400"
        height="400"
      />

      <div>
        <h2 class="text-gray-700 text-3xl font-bold py-1">
          {{ vehicle.name }}
        </h2>
        <h2 class="text-gray-700 text-sm py-1">
          <span class="text-xs mx-2">{{ $t('price_per_day') }}</span> ${{ vehicle.price }} 
        </h2>
        <p class="text-gray-500 text-lg py-1">{{ vehicle.description }}</p>
        <div class="py-8">
          <h2 class="text-left font-bold" :style="{ color: colorPrimary }">
            {{ $t('special_features') }}
          </h2>
          <div class="flex space-x-2 my-3">
            <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs">{{
              vehicle.transmision
            }}</span>
            <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs">{{
              vehicle.type_of_car
            }}</span>
            <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs"
              >{{$t('people')}} {{ vehicle.luggage }}</span
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
            {{ $t('select') }}
          </a>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import TabsComponents from "./components/TabsComponents.vue";
import NavComponents from "./components/NavComponents.vue";
const url = import.meta.env.VITE_API_DATA; // Usar variable de entorno
const api = import.meta.env.VITE_API_URL; // Usar variable de entorno
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
      activeIndex: 0, // Índice para el carrusel
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
      url: import.meta.env.VITE_API_DATA,
      api: import.meta.env.VITE_API_URL,
      site: import.meta.env.VITE_API_URL,
    };
  },
  mounted() {
    this.getVehicle();
    this.getLanding();
    this.getFeatures();
    this.updateMetaTags();
  },

  methods: {
    prevImage() {
      // Lógica para mostrar la imagen anterior
      this.activeIndex = this.activeIndex === 0 ? this.vehicle.images.length - 1 : this.activeIndex - 1;
    },
    nextImage() {
      // Lógica para mostrar la siguiente imagen
      this.activeIndex = this.activeIndex === this.vehicle.images.length - 1 ? 0 : this.activeIndex + 1;
    },
    getFeatures() {
      // Obtiene las características del vehículo
      axios
        .get(`${this.api}/special-features-public`)
        .then((response) => {
          this.feature = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    metaInfo() {
      return {
        title: this.landing?.meta_title || "Detail Vehicle",
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
    Guardar() {
      // Asignar los valores al objeto formVehicles
      this.formVehicles.id_vehicle = this.$route.params.idvehicle; // ID del vehículo
      this.formVehicles.title = this.vehicle.name; // Título del vehículo
      if (this.vehicle.images && this.vehicle.images.length > 0) {
        this.formVehicles.image_path = this.url + "/" + this.vehicle.images[0].path_images;
      } else {
        this.formVehicles.image_path = null; // En caso de que no haya imagen disponible
      }
      localStorage.setItem("formVehicles", JSON.stringify(this.formVehicles));
      this.$router.push({ name:"vehicle-additions" });
    },

    updateMetaTags() {
      const metaData = this.metaInfo();
      document.title = metaData.title;
      const existingMetaTags = document.querySelectorAll("meta[name], meta[property]");
      existingMetaTags.forEach((tag) => tag.parentNode.removeChild(tag));
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
        })
        .catch((err) => {
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
            this.vehicle = { images: [] }; // Asignación segura si no hay datos
          }
        })
        .catch((error) => {
          this.vehicle = { images: [] }; // Inicializa vehicle con un array vacío en caso de error
        });
    },
  },
};
</script>

<style scoped>
.wrapper {
  padding: 10px;
  display: grid;
  gap: 50px;
  justify-content: space-around;
  grid-auto-flow: column;
  grid-template-columns: auto auto;
}

/* Carrusel */
.carousel-container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.carousel-image {
  aspect-ratio: 16/9;
  width: 100%;
  height: auto;
  object-fit: cover;
}

.carousel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.prev-btn {
  left: 10px;
}

.next-btn {
  right: 10px;
}

/* media query */
@media (max-width: 578px) {
  .wrapper {
    grid-template-columns: 1fr;
    grid-auto-flow: row;
  }
}
</style>
