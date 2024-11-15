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
        <aside class="p-10 flex flex-col space-y-6 bg-gray-50 shadow-lg">
          <!-- busqueda rapida  -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">Busqueda Rapida</h2>
            <input
              type="text"
              placeholder="Buscar por nombre"
              v-model="quickSearch"
              class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors ease-in-out"
            />
          </div>
          <!-- Capacidad -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">Capacidad</h2>
            <select
              class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.capacity = $event.target.value"
            >
              <option value="">Todas</option>
              <option value="2">2 Personas</option>
              <option value="4">4 Personas</option>
              <option value="5">5 Personas</option>
              <option value="7">7 Personas</option>
              <option value="9">9 Personas</option>
            </select>
          </div>

          <!-- Tipo de Vehículo -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">
              Tipo de Vehículo
            </h2>
            <select
              class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.type_of_car = $event.target.value"
            >
              <option value="">Todos</option>
              <option value="SUV">SUV</option>
              <option value="Sedán">Sedán</option>
              <option value="Camioneta">Camioneta</option>
            </select>
          </div>

          <!-- Equipaje -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">Equipaje</h2>
            <select
              class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.luggage = $event.target.value"
            >
              <option value="">Cualquier capacidad</option>
              <option value="2">2 Maletas</option>
              <option value="4">4 Maletas</option>
              <option value="6">6 Maletas</option>
            </select>
          </div>

          <!-- Marca -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">Marca</h2>
            <select
              class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.brand = $event.target.value"
            >
              <option value="">Todas</option>
              <option value="Toyota">Toyota</option>
              <option value="Honda">Honda</option>
              <option value="Ford">Ford</option>
            </select>
          </div>

          <!-- Transmisión -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">Transmisión</h2>
            <select
              class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              @change="filters.transmision = $event.target.value"
            >
              <option value="">Cualquier transmisión</option>
              <option value="Manual">Manual</option>
              <option value="Semi-Automática">Semi-Automática</option>
              <option value="Automática">Automática</option>
            </select>
          </div>

          <!-- Características -->
          <div class="flex flex-col space-y-2">
            <h2 class="text-lg font-semibold text-gray-700">Características</h2>
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
                <span class="text-gray-600">Asientos calefaccionados</span>
              </label>
            </div>
          </div>

          <!-- Botón de Restablecer Filtros -->
          <button
            class="mt-4 w-full py-2 text-white rounded-md transition-colors font-semibold"
            @click="resetFilters"
            :style="{ backgroundColor: color1 }"
          >
            Restablecer Filtros
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
const url = import.meta.env.VITE_API_URL; // Usar variable de entorno

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
  filteredVehicles() {
    return this.vehicles.filter((vehicle) => {
      const { capacity, type_of_car, luggage, brand, transmision, features } =
        this.filters;

      // Verificar búsqueda rápida
      if (
        this.quickSearch &&
        !vehicle.name.toLowerCase().includes(this.quickSearch.toLowerCase())
      ) {
        return false;
      }

      // Verificar capacidad
      if (capacity && parseInt(vehicle.people) !== parseInt(capacity))
        return false;

      // Verificar tipo de carro
      if (type_of_car && vehicle.type_of_car !== type_of_car) return false;

      // Verificar capacidad de equipaje
      if (luggage && parseInt(vehicle.luggage) !== parseInt(luggage))
        return false;

      // Verificar marca
      if (brand && vehicle.brand !== brand) return false;

      // Verificar transmisión
      if (transmision && vehicle.transmision !== transmision) return false;

      // Verificar características
      if (
        features.length &&
        !features.every((feature) =>
          vehicle.features.includes(feature.toLowerCase())
        )
      )
        return false;

      return true; // Cumple todos los filtros
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
  grid-template-columns: 1fr 3fr;
  margin: 0px 0px 0px 0px;
}
.wrapper-cards {
  display: grid;
  grid-template-columns: auto auto;
  margin: 20px 0px 0px 0px;
  padding-bottom: 20px;
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
