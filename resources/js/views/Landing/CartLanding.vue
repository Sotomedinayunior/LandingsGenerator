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
        <aside class="flex flex-col space-y-6 p-12 bg-gray-50 shadow-lg">
          <!-- busqueda rapida  -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-base	 font-semibold text-gray-700">
              {{ $t("quick_search") }}
            </h2>
            <input
              type="text"
              :placeholder="$t('search_placeholder')"
              v-model="quickSearch"
              class="p-2 w-full border text-xs text-gray-700 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors ease-in-out"
            />
          </div>
          <!-- Capacidad -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-base	 font-semibold text-gray-700">
              {{ $t("capacity") }}
            </h2>
            <select
              class="p-2 border border-gray-300 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.capacity = $event.target.value"
            >
              <option value="">{{ $t("all") }}</option>
              <option value="2">{{ $t("people_2") }}</option>
              <option value="4">{{ $t("people_4") }}</option>
              <option value="5">{{ $t("people_5") }}</option>
              <option value="7">{{ $t("people_7") }}</option>
              <option value="9">{{ $t("people_9") }}</option>
            </select>
          </div>

          <!-- Tipo de Vehículo -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">
              {{ $t("vehicle_type") }}
            </h2>
            <select
              class="p-2 border border-gray-300 text-xs rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.type_of_car = $event.target.value"
            >
              <option value="">{{ $t("all") }}</option>
              <option value="SUV">SUV</option>
              <option value="Sedán">Sedán</option>
              <option value="Camioneta">Camioneta</option>
            </select>
          </div>

          <!-- Equipaje -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-sm font-semibold text-gray-700">
              {{ $t("luggage") }}
            </h2>
            <select
              class="p-2 border text-xs border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.luggage = $event.target.value"
            >
              <option value="">{{ $t("any_capacity") }}</option>
              <option value="2">{{ $t("luggage_2") }}</option>
              <option value="4">{{ $t("luggage_4") }}</option>
              <option value="6">{{ $t("luggage_6") }}</option>
            </select>
          </div>

          <!-- Marca -->
          <!-- <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">{{ $t('brand') }}</h2>

            <select
              class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.brand = $event.target.value"
            >
              <option value="">{{ $t("all") }}</option>
              <option value="Toyota">Toyota</option>
              <option value="Honda">Honda</option>
              <option value="Ford">Ford</option>
            </select>
          </div> -->

          <!-- Transmisión -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-sm font-semibold text-gray-700">Transmisión</h2>
            <select
              class="p-2 border border-gray-300 text-xs rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.transmision = $event.target.value"
            >
              <option value="">{{ $t("transmission_any") }}</option>
              <option value="Manual">{{ $t("transmission_manual") }}</option>
              <option value="Semi-Automática">{{
                $t("transmission_semi_automatic")
              }}</option>
              <option value="Automática">{{
                $t("transmission_automatic")
              }}</option>
            </select>
          </div>

          <!-- Características -->
          <!-- <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">
              {{ $t("features") }}
            </h2>
            <div class="flex flex-col space-y-1">
              <label class="flex items-center space-x-2">
                <input
                  type="checkbox"
                  value="bluetooth"
                  class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                  @change="toggleFeature('bluetooth')"
                />
                <span class="text-gray-600">Bluetooth</span>
              </label>
              <label class="flex items-center space-x-2">
                <input
                  type="checkbox"
                  value="gps"
                  class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                  @change="toggleFeature('gps')"
                />
                <span class="text-gray-600">GPS</span>
              </label>
              <label class="flex items-center space-x-2">
                <input
                  type="checkbox"
                  value="asientos-calefaccionados"
                  class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                  @change="toggleFeature('asientos-calefaccionados')"
                />
                <span class="text-gray-600">{{ $t('heated_seats') }}</span>
              </label>
            </div>
          </div> -->

          <!-- Botón de Restablecer Filtros -->
          <button
            class="mt-4 w-full py-2 text-sm text-white rounded-md transition-colors font-semibold"
            @click="resetFilters"
            :style="{ backgroundColor: color1 }"
          >
            {{ $t("reset_filters") }}
          </button>
        </aside>

        <main class="wrapper-cards">
          <CardAuto
            v-for="vehicle in filteredVehicles"
            :key="vehicle.id"
            :vehicle="vehicle"
            :colorPrimary="color1"
            :colorSecondary="color2"
          />
          <div
            v-if="filteredVehicles.length === 0"
            class="text-center text-gray-600 p-4 text-2xl"
          >
          <h2>{{ $t('no_vehicles_found') }}</h2>
        </div>
        </main>
      </section>
    </div>
    <div v-else>
      <h1>{{ message }}</h1>
    </div>
  </div>
</template>

<script>
import { defineAsyncComponent } from "vue";

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
      logoLanding: "",
      landing: null,
      LogoTitle: "",
      color1: "",
      color2: "",
      message: "",
      quickSearch: "", // Búsqueda rápida
      filters: {
        capacity: null,
        type_of_car: null,

        luggage: null,
        brand: null,
        transmision: null,
        features: [], // Array para características especiales
      },
    };
  },
  computed: {
    noFiltersApplied() {
      return Object.values(this.filters).every(
        (value) => !value || (Array.isArray(value) && value.length === 0)
      );
    },
    filteredVehicles() {
      return this.vehicles.filter((vehicle) => {
        const {
          capacity,
          type_of_car,
          luggage,
          brand,
          transmision,
          features,
        } = this.filters;

        if (
          this.quickSearch &&
          !vehicle.name.toLowerCase().includes(this.quickSearch.toLowerCase())
        ) {
          return false;
        }

        if (capacity && parseInt(vehicle.people) !== parseInt(capacity))
          return false;
        if (type_of_car && vehicle.type_of_car !== type_of_car) return false;
        if (luggage && parseInt(vehicle.luggage) !== parseInt(luggage))
          return false;
        if (brand && vehicle.brand !== brand) return false;
        if (transmision && vehicle.transmision !== transmision) return false;

        if (
          features.length &&
          !features.every((feature) =>
            vehicle.features.includes(feature.toLowerCase())
          )
        )
          return false;

        return true;
      });
    },
  },

  mounted() {
    this.getVehicles();
    this.updateMetaTags();
  },
  methods: {
    resetFilters() {
      // Reinicia todos los filtros
      this.filters = {
        capacity: null,
        type_of_car: null,
        luggage: null,
        brand: null,
        transmision: null,
        features: [],
      };
      this.quickSearch = "";
    },
    metaInfo() {
      return {
        title: this.landing?.meta_title || "Vehicles",
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
          const landingLanguage = this.landing.default_language; // Aquí puedes cambiar 'es' por el idioma que quieras como predeterminado

          console.log("aqui esta la landing", this.landing);
          this.changeLanguage(landingLanguage);


          // Asignar el color a la variable CSS
          document.documentElement.style.setProperty(
            "--primary-color",
            this.color1
          );

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
  created() {
    // Verifica si hay un idioma guardado en localStorage
    const savedLanguage = localStorage.getItem("Idioma");

    // Si existe, úsalo; de lo contrario, utiliza el idioma actual
    this.currentLanguage = savedLanguage || this.$i18n.locale;

    // Establece el idioma en Vue i18n
    this.$i18n.locale = this.currentLanguage;
  },
};
</script>

<style scoped>
.wrapper-content {
  display: grid;
  grid-template-columns:25% 75%;
  row-gap: 1rem;
  
}
.wrapper-cards {
  display: grid;
  grid-template-columns: auto auto auto;
  padding: 1rem;
 
  gap: 1rem;
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
