<template>
  <div class="container mt-[95px]">
    <div v-if="landing">
      <NavComponents
        :logo="logoLanding"
        :logoTitle="LogoTitle"
        :colorPrimary="color1"
        :colorSecondary="color2"
        :defaultLanguage="currentLanguage"
        @language-change="changeLanguage"
      />
      <section>
        <TabsComponents />
      </section>
      <section class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Agregar extras</h1>

        <!-- Productos de Protección -->
        <div class="mb-8">
          <h2 class="text-xl font-semibold mb-2">Productos de Protección</h2>
          <p class="text-gray-500 mb-4">Viaje más seguro y protegido</p>

          <!-- Producto 1 -->
          <div
            class="flex justify-between items-center p-4 border border-gray-200 rounded-lg mb-4"
          >
            <div>
              <h3 class="font-medium">Exención de responsabilidad por daños</h3>
              <a href="#" class="text-sm text-gray-500 underline">Más info</a>
            </div>
            <div class="flex items-center space-x-4">
              <span class="font-bold">+US$12.00</span>
              <span class="text-gray-500">/per day</span>
              <button
                v-if="!selected[0]"
                @click="selectProduct(0)"
                class="px-4 py-2 border border-gray-200 rounded-lg"
              >
                + Agregar
              </button>
              <div v-else class="flex items-center space-x-2">
                <button
                  @click="decreaseQuantity(0)"
                  class="px-2 py-1 border border-gray-300 rounded"
                >
                  -
                </button>
                <span>{{ quantities[0] }}</span>
                <button
                  @click="increaseQuantity(0)"
                  class="px-2 py-1 border border-gray-300 rounded"
                >
                  +
                </button>
              </div>
            </div>
          </div>

          <!-- Producto 2 -->
          <div
            class="flex justify-between items-center p-4 border border-gray-200 rounded-lg mb-4"
            :class="{ 'border-blue-400 bg-blue-50': selected[1] }"
          >
            <div>
              <h3 class="font-medium">Cobertura de efectos personales</h3>
              <a href="#" class="text-sm text-gray-500 underline">Más info</a>
            </div>
            <div class="flex items-center space-x-4">
              <span class="font-bold">+US$12.00</span>
              <span class="text-gray-500">/per day</span>
              <button
                v-if="!selected[1]"
                @click="selectProduct(1)"
                class="px-4 py-2 border border-gray-200 rounded-lg"
              >
                + Agregar
              </button>
              <div v-else class="flex items-center space-x-2">
                <button
                  @click="decreaseQuantity(1)"
                  class="px-2 py-1 border border-gray-300 rounded"
                >
                  -
                </button>
                <span>{{ quantities[1] }}</span>
                <button
                  @click="increaseQuantity(1)"
                  class="px-2 py-1 border border-gray-300 rounded"
                >
                  +
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Equipamiento -->
        <div class="mb-8">
          <h2 class="text-xl font-semibold mb-2">Equipamiento</h2>
          <p class="text-gray-500 mb-4">Asegure algún equipamiento extra</p>

          <!-- Equipamiento 1 -->
          <div
            class="flex justify-between items-center p-4 border border-gray-200 rounded-lg mb-4"
          >
            <div>
              <h3 class="font-medium">Baby Seat</h3>
              <a href="#" class="text-sm text-gray-500 underline">Más info</a>
            </div>
            <div class="flex items-center space-x-4">
              <span class="font-bold">+US$12.00</span>
              <span class="text-gray-500">/per day</span>
              <button
                v-if="!selected[2]"
                @click="selectProduct(2)"
                class="px-4 py-2 border border-gray-200 rounded-lg"
              >
                + Agregar
              </button>
              <div v-else class="flex items-center space-x-2">
                <button
                  @click="decreaseQuantity(2)"
                  class="px-2 py-1 border border-gray-300 rounded"
                >
                  -
                </button>
                <span>{{ quantities[2] }}</span>
                <button
                  @click="increaseQuantity(2)"
                  class="px-2 py-1 border border-gray-300 rounded"
                >
                  +
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Botones de Navegación -->
        <div class="flex justify-between">
          <button
            class="px-6 py-3 border border-black text-black rounded-lg"
            @click="retorn"
          >
            Atrás
          </button>
          <button
            class="px-6 py-3 bg-black text-white rounded-lg"
            @click="Review()"
          >
            Continuar
          </button>
        </div>
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
import NavComponents from "./components/NavComponents.vue";

// Cambiado para seguir la convención de Vite
const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

export default {
  components: { TabsComponents, NavComponents },
  data() {
    return {
      currentLanguage: "en",
      logoLanding: "",
      LogoTitle: "",
      color1: "",
      color2: "",
      selected: [false, false, false],
      quantities: [1, 1, 1], // Inicializar quantities

      message: "",
      landing: null, // Declarar landing
      vehicles: [], // Declarar vehicles
    };
  },
  mounted() {
    this.getVehicles();
  },
  methods: {
    Review() {
      this.$router.push({ name: "vehicle-review" });
    },
    getVehicles() {
      const NameLandingId = this.$route.params.name;
      const userId = this.$route.params.userid;

      axios
        .get(`${url}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.logoLanding = this.landing.logo;
          this.LogoTitle = this.landing.name;
          this.color1 = this.landing.color_primary;
          this.color2 = this.landing.color_secondary;
          this.vehicles = this.landing.vehicles;

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
    retorn() {
      this.$router.push({ name: "vehicle" });
    },
    selectProduct(index) {
  // Activa el contador al hacer clic en "Agregar"
  this.selected[index] = true;

  // Datos de los productos
  const products = [
    { name: "Exención de responsabilidad por daños", price: 12.0 },
    { name: "Cobertura de efectos personales", price: 12.0 },
    { name: "Baby Seat", price: 12.0 },
  ];

  // Obtener el producto seleccionado
  const selectedProduct = products[index];

  // Obtener el producto almacenado en localStorage
  const storedProduct = localStorage.getItem("selectedProduct");

  if (storedProduct) {
    // Si ya existe, convertir a objeto
    const existingProduct = JSON.parse(storedProduct);

    if (existingProduct.name === selectedProduct.name) {
      // Si el producto ya existe, incrementar la cantidad
      existingProduct.quantity += 1; // Asegúrate de que tienes una propiedad `quantity`
    } else {
      // Si no es el mismo producto, puedes agregar lógica adicional si es necesario
      console.log("Producto diferente, no se incrementa la cantidad.");
    }

    // Guardar de nuevo en localStorage como objeto
    localStorage.setItem("selectedProduct", JSON.stringify(existingProduct));
  } else {
    // Si no existe, agregarlo como un nuevo objeto con cantidad inicial de 1
    const productToStore = {
      name: selectedProduct.name,
      price: selectedProduct.price,
      quantity: 1, // Inicializa la cantidad
    };
    localStorage.setItem("selectedProduct", JSON.stringify(productToStore));
  }

  console.log("Producto agregado al localStorage:", selectedProduct);
},


    increaseQuantity(index) {
      this.quantities[index] += 1; // Incrementa la cantidad
    },
    decreaseQuantity(index) {
      if (this.quantities[index] > 1) {
        this.quantities[index] -= 1; // Decrementa la cantidad, pero no puede bajar de 1
      }
    },
    changeLanguage(language) {
      this.$i18n.locale = language;
      this.currentLanguage = language;
    },
  },
};
</script>

<style scoped></style>
