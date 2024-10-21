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
      <div class="column1">
        <!-- Mostrar Galleria si hay más de 3 imágenes -->
        <Galleria
          v-if="vehicle.images && vehicle.images.length > 3"
          :value="galleryImages"
          :responsiveOptions="responsiveOptions"
          :numVisible="5"
          :circular="true"
          containerStyle="max-width: 640px"
        >
          <template #item="slotProps">
            <img
              :src="slotProps.item.itemImageSrc"
              :alt="slotProps.item.alt"
              style="width: 100%; display: block;"
            />
          </template>
          <template #thumbnail="slotProps">
            <img
              :src="slotProps.item.thumbnailImageSrc"
              :alt="slotProps.item.alt"
              style="width: 50%; display: block;"
            />
          </template>
        </Galleria>

        <!-- Mostrar Image si hay 3 o menos imágenes -->
        <Image
          v-else
          v-for="(image, index) in vehicle.images"
          :key="index"
          :src="url + '/' + image.path_images"
          :alt="vehicle.name"
          width="600"
          preview
        />
      </div>
      <div class="column2">
        <div class="my-2">
          <h1 class="text-2xl text-slate-700 font-bold">{{ vehicle.name }}</h1>
        </div>
        <div class="my-2 flex">
          <h2 class="text-base text-slate-700 font-bold">
            US${{ vehicle.price }}
            <span class="text-sm text-gray-300"> / per day</span>
          </h2>
        </div>
        <div class="my-2">
          <p class="text-xs text-gray-400">{{ vehicle.description }}</p>
        </div>
        <div class="my-2">
          <h2 class="text-base text-slate-700 my-5 font-bold">
            Special Feature
          </h2>
        </div>
        <div class="my-2 flex flex-wrap">
          <div class="flex justify-between">
            <div class="flex flex-col">
              <div
                class="flex justify-center items-center bg-gray-400 rounded-lg px-3 py-2"
                v-if="vehicle.luggage"
              >
                <img
                  src="./asset/bag.png"
                  class="w-5 h-5"
                  :alt="vehicle.name"
                />
                <span class="text-xs">{{ vehicle.luggage }} Maletas</span>
              </div>
            </div>
          </div>
          <div class="flex justify-between mx-1">
            <div class="flex flex-col">
              <div
                class="flex justify-center items-center bg-gray-400 rounded-lg px-3 py-2"
                v-if="vehicle.people"
              >
                <img
                  src="./asset/User.png"
                  class="w-5 h-5"
                  :alt="vehicle.name"
                />
                <span class="text-xs">{{ vehicle.people }} personas</span>
              </div>
            </div>
          </div>
          <div class="flex justify-between mx-1">
            <div class="flex flex-col">
              <div
                class="flex justify-center items-center bg-gray-400 rounded-lg px-3 py-2"
                v-if="vehicle.type_of_car"
              >
                <img
                  src="./asset/cart.png"
                  class="w-5 h-5"
                  :alt="vehicle.name"
                />
                <span class="text-xs ml-1">{{ vehicle.type_of_car }}</span>
              </div>
            </div>
          </div>
          <div class="flex justify-between mx-1">
            <div class="flex flex-col">
              <div
                class="flex justify-center items-center bg-gray-400 rounded-lg px-3 py-2"
                v-if="vehicle.transmision"
              >
                <img
                  src="./asset/transmision.png"
                  class="w-5 h-5"
                  :alt="vehicle.name"
                />
                <span class="text-xs ml-1">{{ vehicle.transmision }}</span>
              </div>
            </div>
          </div>
        </div>

        <h2 class="font-bold text-gray-400" v-if="specialFeatures.length">
          Especial feature
        </h2>
        <ul v-if="specialFeatures.length" class="flex">
          <li v-for="(featureSet, index) in specialFeatures" :key="index">
            <ul v-if="featureSet.features.length" class="flex">
              <li
                v-for="(feature, featureIndex) in featureSet.features"
                :key="featureIndex"
                class="flex m-2"
              >
                <input
                  type="checkbox"
                  :checked="!!feature.value"
                  disabled
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                />
                <label class="ms-2 text-sm font-medium text-gray-900"
                  ><strong>{{ feature.name }}</strong></label
                >
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </section>
  </div>
</template>

<script>
import TabsComponents from "./components/TabsComponents.vue";

import Galleria from "primevue/galleria";

import Carousel from "primevue/carousel";

import NavComponents from "./components/NavComponents.vue";
const url = import.meta.env.VUE_APP_API_URL || "http://localhost:8000/api"; // Usar variable de entorno
import axios from "axios";

import Image from "primevue/image";

export default {
  components: {
    TabsComponents,
    NavComponents,
    Image,
    Carousel,
    Galleria,
  },
  data() {
    return {
      currentLanguage: "en",
      galleryImages: [],
      specialFeatures: [],
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
      url: "http://localhost:8000/storage",
    };
  },
  mounted() {
    this.getVehicle();
    this.getLanding();
    this.loadSpecialFeatures();
    this.updateMetaTags();
  },

  methods: {
    async loadSpecialFeatures() {
      try {
        const vehicleId = this.$route.params.idvehicle;
        const response = await axios.get(
          `/api/vehicle/${vehicleId}/special-features-public`
        );

        if (response.data?.specialFeatures) {
          this.specialFeatures = response.data.specialFeatures;
        } else {
          console.error("No se encontraron specialFeatures");
          this.specialFeatures = [];
        }
      } catch (err) {
        this.error = "Error al cargar características especiales.";
        console.error(err);
      } finally {
        this.loading = false;
      }
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
          // Mapear las imágenes del vehículo a galleryImages
          this.galleryImages = this.vehicle.images.map((image) => ({
            itemImageSrc: this.url + "/" + image.path_images,
            thumbnailImageSrc: this.url + "/" + image.path_images,
            alt: this.vehicle.name,
          }));

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
.wrapper {
  display: grid;

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
