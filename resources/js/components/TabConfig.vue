<template>
  <div class="grid grid-cols-2 gap-8">
    <div class="p-5 w-full flex flex-col justify-center">
      <form
        ref="form"
        @submit.prevent="handleSubmit"
      >
        <div class="mb-7">
          <h2 class="text-xl text-slate-950 font-medium mb-2">
            1- Name your website
          </h2>
          <input
            type="text"
            class="w-full px-4 py-2 border border-slate-300 rounded outline-none focus:ring-0"
            v-model="name"
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
              <template v-if="logoUrl">
                <img
                  :src="logoUrl"
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
                v-model="primaryColor"
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
                v-model="secondaryColor"
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
      name: "",
      logoUrl: null, // Para almacenar la URL de la imagen
      primaryColor: "#000000", // Valor por defecto para el color primario
      secondaryColor: "#FFFFFF", // Valor por defecto para el color secundario
      isModalVisible: false, // Controla la visibilidad del modal
      modalTitle: "Landing Actualizada",
      modalMessage: "Tu landing ha sido Actualizada exitosamente.",
    };
  },
  computed: {
    isFormComplete() {
      // Verifica si todos los campos necesarios están llenos
      return (
        this.name && this.primaryColor && this.secondaryColor
      );
    },
  },
  mounted() {
    this.fetchLandingData();
  },
  methods: {
    fetchLandingData() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = localStorage.getItem("NellyLandingCreate");

      if (!userId || !landingId) {
        console.error("User ID and Landing ID are required");
        return;
      }

      Axios.get(`/api/landings/${userId}/${landingId}`)
        .then((response) => {
          const data = response.data;
          this.name = data.name;
          this.logoUrl = data.logo ? `${data.logo}` : null;
          this.primaryColor = data.color_primary;
          this.secondaryColor = data.color_secondary;
        })
        .catch((error) => {
          console.error("Error fetching landing data:", error);
        });
    },
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.logoUrl = URL.createObjectURL(file); // Generar la URL de la imagen
      }
    },
    handleSubmit() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      if (!userId || !landingId) {
        console.error("User ID and Landing ID are required");
        return;
      }

      const formData = new FormData();
      formData.append("name", this.name);
      if (this.$refs.logoInput.files[0]) {
        formData.append("logo", this.$refs.logoInput.files[0]);
      }
      formData.append("color_primary", this.primaryColor);
      formData.append("color_secondary", this.secondaryColor);

      // Log para verificar los datos que se están enviando
      for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }

      Axios.put(`/api/landing/updated/${landingId}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          console.log("Respuesta del servidor:", response.data);
          if (response.data && response.data.id) {
            console.log("ID de la landing actualizada:", response.data.id);
          } else {
            console.error(
              "El ID de la landing no está en la respuesta:",
              response.data
            );
          }

          // Actualizar la vista con los nuevos datos
          this.logoUrl = response.data.logo ? `${response.data.logo}` : null;
          this.name = response.data.name;
          this.primaryColor = response.data.color_primary;
          this.secondaryColor = response.data.color_secondary;

          // Mostrar el modal
          this.isModalVisible = true;

          // Redirigir después de 2 segundos
          setTimeout(() => {
            this.confirmModal();
          }, 2000);
        })
        .catch((error) => {
          console.error("Error al enviar el formulario:", error);
        });
    },
    confirmModal() {
      this.isModalVisible = false;
    },
  },
};
</script>

<style scoped>
/* Estilos personalizados */
</style>