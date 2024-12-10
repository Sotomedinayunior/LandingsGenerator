<template>
  <div class="box-container">
    <div class="grid grid-cols-2 justify-between">
      <div class="flex flex-col items-center">
        <form
          ref="form"
          @submit.prevent="handleSubmit"
          enctype="multipart/form-data"
          class="w-30 mr-40 "
        >
          <div class="mb-7">
            <h2 class="text-base text-slate-950 font-semibold mb-2">
              1- Nombre de tu landing
            </h2>
            <input
              v-model="name"
              type="text"
              placeholder="Nombre de tu landing"
              maxlength="35"
              class="w-full border border-gray-300 rounded px-3 py-2 text-xs"
            />

            <p class="text-gray-600 text-[9px] mt-1 font-bold">
              * Este nombre debe ser único.
            </p>
          </div>
          <div class="mb-4">
            <h2 class="text-base text-slate-950 font-semibold mb-2">
              2- Sube el logo de tu landing
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
                    Tamaño recomendado 250px / 80px
                  </p>
                </template>
              </label>
            </div>
          </div>
          <div class="mb-8">
            <h2 class="text-base text-slate-950 font-semibold mb-2">
              3- Color principal y secundario
            </h2>
            <div class="flex space-x-5 justify-center">
              <!-- Selector de color primario -->
              <div class="flex flex-col items-center mx-5 ">
                <label for="primaryColor" class="text-slate-950 text-xs mb-2">
                  Color Principal
                </label>
                <input
                  type="color"
                  name="primaryColor"
                  v-model="primaryColor"
                  id=""
                />
              </div>

              <!-- Selector de color secundario -->
              <div class="flex flex-col items-center mx-5">
                <label for="secondaryColor" class="text-slate-950 text-xs mb-2">
                  Color secundario
                </label>
                <input
                  type="color"
                  name="secondaryColor"
                  v-model="secondaryColor"
                />
              </div>
            </div>
          </div>
          <div class="mb-8">
            <h2 class="text-base text-slate-950 font-semibold mb-2">
              4- Idioma Predeterminado de tu landing
            </h2>
            <div class="flex justify-around">
              <div
                class="bg-white w-20 h-auto shadow-xl flex justify-around items-center cursor-pointer"
                @click="selectLanguage('es')"
                :class="{
                  'border-4 border-orange-500': defaultLanguage === 'es',
                }"
              >
                <div class="w-full h-full">
                  <img
                    src="../static/asset/do.svg"
                    alt="Idioma español"
                    width="40"
                    height="40"
                    class="w-full h-full"
                  />
                </div>
              </div>
              <div
                class="bg-white w-20 h-auto shadow-xl flex justify-around items-center cursor-pointer"
                @click="selectLanguage('en')"
                :class="{
                  'border-4 border-orange-500': defaultLanguage === 'en',
                }"
              >
                <div class="w-full h-full">
                  <img
                    src="../static/asset/us.svg"
                    alt="Idioma español"
                    width="40"
                    height="40"
                    class="w-full h-full"
                  />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- Segunda columna -->
      <div class="p-8 w-full flex justify-end  flex-col">
        <div class="flex justify-between">
          <h2 class="text-base font-bold text-gray-500">Preview</h2>
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
              <p class="text-xs" :style="{ color: secondaryColor }">
                $0.00
              </p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-xs" :style="{ color:secondaryColor }">
                $0.00
              </p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-xs" :style="{ color:secondaryColor }">
                $0.00
              </p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-xs" :style="{ color:secondaryColor }">
                $0.00
              </p>
            </div>
            <div
              class="bg-gray-200 h-16 flex items-center justify-center rounded"
            >
              <p class="text-xs" :style="{ color:secondaryColor }">
                $0.00
              </p>
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
      defaultLanguage: "",
      isErrorDialogVisible: false,
      errorHeader: "Error al crear la landing",
      errorMessage: "",

      modalMessage: "Tu landing ha sido creada exitosamente.",
    };
  },
  computed: {
    isFormComplete() {
      // Verifica si todos los campos necesarios están llenos
      return (
        this.name &&
        this.logoUrl &&
        this.primaryColor &&
        this.secondaryColor &&
        this.defaultLanguage
      );
    },
  },
  methods: {
    createSlug(name) {
      return name
        .toLowerCase() // Convierte a minúsculas
        .trim() // Elimina espacios al inicio y al final
        .replace(/[^\w\s-]/g, "") // Elimina caracteres especiales
        .replace(/\s+/g, "-") // Reemplaza espacios por guiones
        .replace(/-+/g, "-"); // Elimina guiones duplicados
    },
    selectLanguage(lang) {
      this.defaultLanguage = lang; // Asigna el idioma seleccionado a defaultLanguage
    },
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

      const formData = new FormData();
      formData.append("id_users_landing", userId);
      formData.append("name", this.createSlug(this.name));
      formData.append("logo", this.$refs.logoInput.files[0]);
      formData.append("color_primary", this.primaryColor);
      formData.append("default_language", this.defaultLanguage);
      formData.append("color_secondary", this.secondaryColor);

      Axios.post("/landing", formData, {
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

          this.errorMessage = error.response.data.message;
          this.isErrorDialogVisible = true;
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
.flag-icon {
  width: 1.5rem; /* Ajusta el tamaño de las banderas */
  height: auto;
}
/* Caja principal */
.box-container {
  max-width: 1024px; /* Ancho máximo */
  margin: 0 auto; /* Centrar horizontalmente */
}
</style>
