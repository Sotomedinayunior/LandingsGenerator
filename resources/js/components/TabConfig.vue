<template>
  <div class="grid grid-cols-2 gap-8">
    <div class="p-5 w-full flex flex-col justify-center">
      <form ref="form" @submit.prevent="handleSubmit">
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
              <template v-if="LandingInfo.logo">
                <img
                  :src="LandingInfo.logo"
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
            <!-- Selector de color primario -->
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

            <!-- Selector de color secundario -->
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

    <!-- Segunda columna -->
    <div class="p-8 w-full flex justify-center flex-col">
      <div class="flex justify-around">
        <div class="flex justify-end">
          <button
            class="px-4 py-2 border-orange-500 border text-orange-500 rounded transition-colors"
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
            class="px-4 py-2 text-white rounded transition-colors"
          >
            Guardar
          </button>
        </div>
      </div>
    </div>

    <!-- Modal -->
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
        // Se puede usar un objeto para almacenar los datos del formulario
        name: '',
        logo: null,
        color_primary: "#000000",
        logoUrl: null,
        color_secondary: "#FFFFFF",
      },
      isSubmitting: false,
      isModalVisible: false, // Controla la visibilidad del modal
      modalTitle: "Landing Actualizada",
      modalMessage: "Tu landing ha sido Actualizada exitosamente.",
    };
  },
  computed: {
    isFormComplete() {
      // Verifica si todos los campos necesarios están llenos
      return (
        this.LandingInfo.name &&
        this.LandingInfo.color_primary &&
        this.LandingInfo.color_secondary
      );
    },
  },

  methods: {
    fetchLandingData() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      if (!userId || !landingId) {
        console.error("User ID and Landing ID are required");
        return;
      }

      Axios.get(`/api/landings/${userId}/${landingId}`)
        .then((response) => {
          console.log("Landing data:", response.data);
          this.LandingInfo = response.data;
          console.log("Landing data:", this.LandingInfo);
        })
        .catch((error) => {
          console.error("Error fetching landing data:", error);
        });
    },
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.LandingInfo.logo = file; // Guardar el archivo en LandingInfo
        this.LandingInfo.logoUrl = URL.createObjectURL(file); // Generar la URL para vista previa
      }
    },

    confirmModal() {
      this.isModalVisible = false;
    },
    handleSubmit() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      console.log("LandingInfo:", this.LandingInfo); // Verificar datos

      

      const formData = new FormData();
      formData.append("name", this.LandingInfo.name);
      formData.append("logo", this.LandingInfo.logo);
      formData.append("color_primary", this.LandingInfo.color_primary);
      formData.append("color_secondary", this.LandingInfo.color_secondary);

      // Imprimir cada entrada de FormData
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      }

      Axios.post(`/api/landing-update/${userId}/${landingId}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          console.log("Landing actualizada:", response.data);
          this.isModalVisible = true;
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

<style scoped>
/* Estilos personalizados */
</style>
