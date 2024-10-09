<template>
  <div class="grid grid-cols-2">
    <div class="flex flex-col items-center">
      <form
        ref="form"
        @submit.prevent="handleSubmit"
        enctype="multipart/form-data"
        class="ml-27"
      >
        <div class="mb-7">
          <h2 class="text-xl text-slate-950 font-semibold mb-2">
            1- Name your website
          </h2>

          <input
            type="text"
            class="text-sm px-9 py-2 w-full border border-slate-300 rounded outline-none focus:ring-0"
            v-model="name"
            name="name"
            placeholder="Enter your website name"
            required
            pattern="^[A-Za-z0-9]+$"
            title="El nombre debe contener solo letras  sin espacios."
            maxlength="25"
          />

          <p class="text-gray-600 text-xs mt-1">Este nombre debe ser único.</p>
        </div>
        <div class="mb-4">
          <h2 class="text-xl text-slate-950 font-semibold mb-2">
            2- Upload the logo
          </h2>
          <div
            class="border-4 border-orange-400 border-dashed bg-[#F2994A0D] p-4 h-60 flex items-center justify-center relative w-full"
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
          <h2 class="text-xl text-slate-950 font-semibold mb-2">
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
    <div class="p-8 w-full flex flex-col">
      <div class="flex justify-between">
        <h2 class="text-2xl font-bold text-gray-500">Preview</h2>
        <div class="flex justify-end">
          <button
            @click="submitForm"
            :disabled="!isFormComplete"
            :class="{
              'bg-orange-500': isFormComplete,
              'bg-gray-500': !isFormComplete,
            }"
            class="px-4 py-2 text-white rounded transition-colors"
          >
            Continuar
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
      step: null,
      name: "",
      logoUrl: null, // Para almacenar la URL de la imagen
      primaryColor: "#000000", // Valor por defecto para el color primario
      secondaryColor: "#FFFFFF", // Valor por defecto para el color secundario
      isModalVisible: false, // Controla la visibilidad del modal
      modalTitle: "Landing Creada",
      modalMessage: "Tu landing ha sido creada exitosamente.",
    };
  },
  computed: {
    isFormComplete() {
      // Verifica si todos los campos necesarios están llenos
      return (
        this.name && this.logoUrl && this.primaryColor && this.secondaryColor
      );
    },
  },
  methods: {
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.logoUrl = URL.createObjectURL(file); // Generar la URL de la imagen
      }
    },
    handleSubmit() {
      let userId = localStorage.getItem("NellyUserId");

      if (!userId) {
        console.error("User ID is required");
        return;
      }
      const formattedName = this.name.trim(); // Eliminar espacios en blanco al principio y final

      // Validar que el nombre solo contenga letras y números
      if (!/^[A-Za-z0-9]+$/.test(formattedName)) {
        alert(
          "El nombre solo puede contener letras y números sin espacios ni caracteres especiales."
        );
        return;
      }

      const formData = new FormData();
      formData.append("id_users_landing", userId);
      formData.append("name", formattedName);
      formData.append("name", this.name);
      formData.append("logo", this.$refs.logoInput.files[0]);
      formData.append("color_primary", this.primaryColor);
      formData.append("color_secondary", this.secondaryColor);

      Axios.post("/api/landing", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          if (response.data && response.data.id) {
            localStorage.setItem("NellyLandingCreate", response.data.id);
            localStorage.setItem("NellyLandingName", response.data.name);
            console.log("ID de la landing creada:", response.data.id);
            console.log("name de la landing creada:", response.data.name);
          } else {
            console.error(
              "El ID de la landing no está en la respuesta:",
              response.data
            );
          }

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
    submitForm() {
      this.$refs.form.requestSubmit();
    },
    confirmModal() {
      this.isModalVisible = false;
      // Redirigir a la siguiente ventana (por ejemplo, /next-page)
      return this.$router.push("/layout-designer/add-vehicles");
    },
  },
};
</script>

<style scoped>
</style>
