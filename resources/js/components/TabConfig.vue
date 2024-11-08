<template>
  <div class="grid grid-cols-2 gap-8">
    <div class="p-5 w-full flex flex-col">
      <form
        ref="form"
        @submit.prevent="handleSubmit"
        enctype="multipart/form-data"
      >
        <div class="mb-7">
          <h2 class="text-xl text-slate-950 font-medium mb-2">
            1- Name your website
          </h2>
          <input
            type="text"
            class="w-full px-4 py-2 border border-slate-300 rounded outline-none focus:ring-0"
            v-model="LandingInfo.name"
            name="name"
            placeholder="Enter your website name"
            required
          />
        </div>
        <div class="mb-4">
          <h2 class="text-xl text-slate-950 font-medium mb-2">
            2- Upload the logo
          </h2>
          <div
            class="border-2 border-dashed border-[#F2994A] bg-[#F2994A0D] p-4 w-full h-40 flex items-center justify-center relative"
          >
            <input
              type="file"
              id="logo"
              ref="logoInput"
              name="logo"
              @change="previewImage"
              class="absolute inset-0 opacity-0 cursor-pointer"
            />
            <label
              for="logo"
              class="flex flex-col items-center justify-center text-center text-gray-500 cursor-pointer w-full h-full"
            >
              <template v-if="LandingInfo.logoUrl">
                <img
                  :src="LandingInfo.logoUrl"
                  alt="Logo Preview"
                  class="h-full max-h-full object-contain"
                />
              </template>
              <template v-else>
                <i class="fa-solid fa-camera text-[#F2994A] text-4xl"></i>
                <p class="text-[#F2994A] mt-2">
                  Tamaño recomendado 1920 x 1080px
                </p>
              </template>
            </label>
          </div>
        </div>
        <div class="mb-8">
          <h2 class="text-xl text-slate-950 font-medium mb-2">
            3- Choose Primary & Secondary Color
          </h2>
          <div class="flex space-x-4">
            <div class="flex flex-col items-center">
              <label for="primaryColor" class="text-slate-950 mb-2">
                Primary Color
              </label>
              <input
                type="color"
                id="primaryColor"
                v-model="LandingInfo.color_primary"
                name="primaryColor"
                class="w-12 h-12 cursor-pointer border border-slate-300 rounded"
              />
            </div>
            <div class="flex flex-col items-center">
              <label for="secondaryColor" class="text-slate-950 mb-2">
                Secondary Color
              </label>
              <input
                type="color"
                id="secondaryColor"
                v-model="LandingInfo.color_secondary"
                name="secondaryColor"
                class="w-12 h-12 cursor-pointer border border-slate-300 rounded"
              />
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="p-8 w-full flex  flex-col">
      <div class="p-8 w-full flex flex-col">
        <div class="flex justify-between">
          <h2 class="text-2xl font-bold text-gray-500">Preview</h2>
        </div>
        <div class="flex justify-around">
          <div class="flex justify-between gap-10">
            <button
              class="px-4 py-2 m-6 border-orange-500 border text-orange-500 rounded transition-colors"
              @click="handlePreview"
            >
              Previsualizar
            </button>
            <button
              @click="handleSubmit"
              :disabled="!isFormComplete"
              :class="{
                'bg-orange-500': isFormComplete,
                'bg-gray-500': !isFormComplete,
              }"
              class="px-4 py-2 m-6 text-white rounded transition-colors"
            >
              Guardar
            </button>
          </div>
        </div>
        <p class="my-1 mb-2 text-sm text-gray-500">
          Echa un vistazo a cómo se verá y se sentirá
        </p>

        <!-- Vista previa de la landing -->
        <div class="p-8 bg-gray-100 rounded-lg">
          <!-- Header con logo y botón -->
          <div class="flex justify-between items-center mb-8">
            <!-- Logo -->
            <img
              v-if="logoUrl"
              :src="logoUrl"
              alt="Logo"
              class="h-auto w-14"
              width="200"
              height="200"
            />
            <img
              v-else
              src="../static/asset/Logo.webp"
              alt="Logo Predeterminado"
              class="h-auto w-14"
              width="200"
              height="200"
            />

            <!-- Botón superior derecho -->
            <div
              class="w-16 h-8 rounded"
              :style="{ backgroundColor: primaryColor }"
            ></div>
          </div>

          <!-- Sección principal con cuadro de búsqueda y caja grande -->
          <div class="gap-4 mb-8">
            <!-- Caja grande -->
            <div
              class="bg-gray-200 h-24 rounded flex items-center justify-between"
            >
              <div class="flex-grow"></div>
              <!-- Espacio flexible para empujar el input hacia la derecha -->
              <div>
                <input
                  type="text"
                  placeholder="Search"
                  class="h-5 p-1 border rounded"
                  :style="{ backgroundColor: primaryColor }"
                />
              </div>
            </div>
          </div>

          <!-- Caja de precios -->
          <div class="grid grid-cols-5 gap-4 mb-8">
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-sm" :style="{ color: primaryColor }">$0.00</p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-sm" :style="{ color: primaryColor }">$0.00</p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-sm" :style="{ color: primaryColor }">$0.00</p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-sm" :style="{ color: primaryColor }">$0.00</p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-sm" :style="{ color: primaryColor }">$0.00</p>
            </div>
          </div>

          <!-- Caja grande y puntos -->
          <div class="grid grid-cols-12 gap-4">
            <!-- Caja grande inferior izquierda -->
            <div class="col-span-9 bg-gray-200 h-24 rounded"></div>

            <!-- Puntos a la derecha -->
            <div
              class="col-span-3 flex flex-col space-y-4 items-center justify-center"
            >
              <span
                class="w-3 h-3 rounded-full"
                :style="{ backgroundColor: primaryColor }"
              ></span>
              <span
                class="w-3 h-3 rounded-full"
                :style="{ backgroundColor: primaryColor }"
              ></span>
              <span
                class="w-3 h-3 rounded-full"
                :style="{ backgroundColor: primaryColor }"
              ></span>
            </div>
          </div>
        </div>
        <div class="w-full bg-gray-200 h-24 rounded"></div>
      </div>
    </div>

    <div
      v-if="isModalVisible"
      class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75"
    >
      <div class="bg-white p-6 rounded shadow-lg text-center">
        <h2 class="text-2xl font-bold mb-4">{{ modalTitle }}</h2>
        <p>{{ modalMessage }}</p>
        <button
          @click="confirmModal"
          class="mt-4 bg-orange-500 text-white px-4 py-2 rounded"
        >
          Aceptar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "../axios";

export default {
  data() {
    return {
      LandingInfo: {
        name: "",
        logo: null,
        color_primary: "#000000",
        logoUrl: null,
        color_secondary: "#FFFFFF",
      },
      isModalVisible: false, // Controla la visibilidad del modal
      modalTitle: "Landing Actualizada",
      modalMessage: "Tu landing ha sido Actualizada exitosamente.",
    };
  },
  computed: {
    isFormComplete() {
      return (
        this.LandingInfo.name &&
        this.LandingInfo.color_primary &&
        this.LandingInfo.color_secondary
      );
    },
  },
  methods: {
    createSlug(name) {
    return name
      .toLowerCase()                    // Convierte a minúsculas
      .trim()                           // Elimina espacios al inicio y al final
      .replace(/[^\w\s-]/g, '')         // Elimina caracteres especiales
      .replace(/\s+/g, '-')             // Reemplaza espacios por guiones
      .replace(/-+/g, '-');             // Elimina guiones duplicados
  },
    fetchLandingData() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      if (!userId || !landingId) {
        console.error("User ID and Landing ID are required");
        return;
      }

      Axios.get(`/api/landings/${userId}/${landingId}`)
        .then((response) => {
          this.LandingInfo = response.data;
          this.LandingInfo.logoUrl = response.data.logo; // Asegura que logoUrl esté configurado
        })
        .catch((error) => {
          console.error("Error fetching landing data:", error);
        });
    },
    handlePreview() {
      const IdLanding = this.LandingInfo.name;
      console.log(`IdLanding: ${IdLanding}`);
      this.$router.push(`/review-component/${IdLanding}`);
    },
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.LandingInfo.logo = file;
        this.LandingInfo.logoUrl = URL.createObjectURL(file);
      }
    },
    
    confirmModal() {
      this.isModalVisible = false;
    },
    handleSubmit() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      const formData = new FormData();
      formData.append("name",  this.createSlug(this.LandingInfo.name));

      const logoFile = this.$refs.logoInput.files[0];
      if (logoFile) {
        formData.append("logo", this.LandingInfo.logo);
        console.log("url construida del logo:", this.LandingInfo.logo);
      }

      formData.append("color_primary", this.LandingInfo.color_primary);
      formData.append("color_secondary", this.LandingInfo.color_secondary);

      Axios.post(`/api/landing-update/${userId}/${landingId}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          this.isModalVisible = true;
          console.log("Landing actualizada:", response.data);
        })
        .catch((error) => {
          console.error("Error al actualizar la landing:", error);
          this.modalMessage = "Hubo un error al actualizar la landing.";
          this.isModalVisible = true;
        });
    },
  },
  mounted() {
    this.fetchLandingData();
  },
};
</script>

<style scoped></style>
