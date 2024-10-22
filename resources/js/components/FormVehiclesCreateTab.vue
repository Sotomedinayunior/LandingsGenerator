<template>
  <div class="w-full">
    <button
      @click="prev"
      class="flex items-center mb-4 px-4 py-2 text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
    >
      <i class="fa fa-arrow-left mr-2"></i>Atrás
    </button>
    <div>
      <!-- Carousel de imágenes del vehículo -->
      <form
        @submit.prevent="addVehicle"
        class="form w-full p-5"
        enctype="multipart/form-data"
      >
        <div class="mr-20">
          <!-- Contenedor de carga de imágenes -->
          <div
            class="border-2 border-dashed border-gray-300 bg-[#DDDDDD33] p-8 w-full h-80 flex items-center justify-center relative"
          >
            <input
              type="file"
              id="vehicle-images"
              multiple
              accept="image/*"
              @change="handleImageUpload"
              maxlength="17"
              class="absolute inset-0 opacity-0 cursor-pointer"
              required
            />
            <label
              for="vehicle-images"
              class="flex flex-col items-center justify-center text-center text-gray-500 cursor-pointer w-full h-full"
            >
              <template v-if="currentImage">
                <img
                  :src="currentImage"
                  alt="Vehicle Preview"
                  class="h-full max-h-full object-contain"
                />
              </template>
              <template v-else>
                <!-- Icono de cámara de Font Awesome -->
                <i class="fa-solid fa-camera text-[#333] text-4xl"></i>
                <p class="text-[#333] mt-2">
                  Sube hasta 12 imágenes del vehículo
                </p>
              </template>
            </label>
          </div>

          <!-- Vista previa de imágenes subidas con opción para eliminar -->
          <div class="mt-4 flex flex-wrap space-x-2">
            <div
              v-for="(image, index) in vehicleImages"
              :key="index"
              class="relative"
            >
              <img
                :src="image"
                alt="Preview"
                class="w-24 h-24 object-cover border border-gray-300 rounded"
              />
              <button
                @click="removeImage(index)"
                class="absolute top-0 right-0 p-1 bg-red-500 text-white rounded-full hover:bg-red-700"
              >
                ×
              </button>
            </div>
          </div>
        </div>

        <!-- Formulario -->
        <div>
          <h2 class="text-2xl font-bold mb-4">
            Detalla los datos del vehículo
          </h2>

          <div class="mb-4">
            <input
              v-model="newVehicle.name"
              id="name"
              placeholder="Nombre del Vehículo"
              class="mt-1 block text-sm w-[450px] border outline-none border-gray-300 rounded-md p-3"
              required
            />
          </div>
          <div class="mb-4">
            <textarea
              v-model="newVehicle.description"
              id="description"
              maxlength="255"
              placeholder="Describe brevemente el vehículo"
              class="mt-1 block w-[450px] border border-gray-300 outline-none rounded-md p-2"
              required
            ></textarea>
          </div>
          <div class="mb-4">
            <input
              v-model="newVehicle.price"
              id="price"
              type="number"
              placeholder="Precio por día"
              class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2"
              required
            />
          </div>
          <div class="mb-4">
            <h2 class="text-lg font-bold mb-4">Seleccionar característica</h2>
            <div class="flex">
              <!-- Select Equipaje -->
              <div>
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="newVehicle.luggage"
                  name="luggage"
                  required
                >
                  <option value="" disabled>Equipaje</option>
                  <!-- Actúa como un placeholder -->
                  <option value="2">2</option>
                  <option value="4">4</option>
                  <option value="8">8</option>
                </select>
              </div>

              <!-- Select Capacidad -->
              <div class="relative inline-block">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="newVehicle.people"
                  name="people"
                  required
                >
                  <option value="">Capacidad</option>
                  <option value="2">2 Personas</option>
                  <option value="4">4 Personas</option>
                  <option value="6">6 Personas</option>
                </select>
              </div>
            </div>

            <div class="flex">
              <!-- Select Tipo -->
              <div class="relative inline-block m-2">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="newVehicle.type_of_car"
                  name="type_of_car"
                  required
                >
                  <option value="">Tipo</option>
                  <option value="sedan">Sedan</option>
                  <option value="suv">SUV</option>
                  <option value="camioneta">Camioneta</option>
                </select>
              </div>
              <!-- Select Tipo -->
              <div class="relative inline-block">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  required
                  v-model="newVehicle.transmision"
                  name="transmision"
                >
                  <option>Transmision</option>
                  <option value="automatica">automática</option>
                  <option value="cvt">CVT</option>
                  <option value="secuencial">secuencial</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-4">
            <h3 class="text-lg font-bold mb-4">
              Seleccione características adicionales
            </h3>
            <div class="flex space-x-3"></div>
          </div>

          <button
            type="submit"
            class="px-4 py-2 ml-80 mt-5 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
          >
            Agregar Vehículo
          </button>
        </div>
      </form>
    </div>
    <div
      v-if="showToast"
      id="toast-container"
      class="fixed top-0 right-0 p-4 z-50"
    >
      <div
        id="toast-success"
        class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
        role="alert"
      >
        <div
          class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
        >
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"
            />
          </svg>
          <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">Vehículo agregado con éxito.</div>
        <button
          type="button"
          class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
          @click="closeToast"
          aria-label="Close"
        >
          <span class="sr-only">Close</span>
          <svg
            class="w-3 h-3"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
          </svg>
        </button>
      </div>
    </div>
    <div
      v-if="showErrorModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="bg-white rounded-lg shadow-lg p-4 max-w-sm w-full">
        <h2 class="text-lg font-semibold text-red-600">Error</h2>
        <p class="mt-2 text-gray-700">{{ errorMessage }}</p>
        <div class="mt-4 flex justify-end">
          <button
            @click="closeErrorModal"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
          >
            Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
import Axios from "../axios";
export default {
  name: "FormVehicles",
  data() {
    return {
      showToast: false, // Controla la visibilidad del toast

      vehicleImages: [], // Array para almacenar las imágenes cargadas
      currentImage: null, // Imagen seleccionada para previsualización
      newVehicle: {
        name: "",
        description: "",
        id_landing: 0,
        price: 0,
        luggage: null,
        people: null,
        type_of_car: null,
        transmision: null,
        apple_car: false,
        bluetooth: false,
        siriusxm: false,
        gps: false,
      },
      showErrorModal: false, // Controla la visibilidad del modal
      errorMessage: '', // Mensaje de error
      // Nueva característica
      newFeature: {
        name: "",
        value: "",
      },
    };
  },
  created() {
    const storedId = this.$route.params.id;
    if (storedId) {
      this.newVehicle.id_landing = parseInt(storedId, 10);
    }
  },
  methods: {
    handleImageUpload(event) {
      const files = event.target.files;
      if (files.length + this.vehicleImages.length > 12) {
        alert("Puedes subir un máximo de 12 imágenes.");
        return;
      }
      Array.from(files).forEach((file) => {
        if (file.type.startsWith("image/")) {
          this.vehicleImages.push(URL.createObjectURL(file)); // Previsualización
        }
      });
    },
    removeImage(index) {
      this.vehicleImages.splice(index, 1);
    },
    async addVehicle() {
      const formData = new FormData();

      for (const key in this.newVehicle) {
        const value = this.newVehicle[key];
        formData.append(
          key,
          typeof value === "boolean" ? (value ? 1 : 0) : value
        );
      }

      const imageInput = document.getElementById("vehicle-images").files;
      Array.from(imageInput).forEach((file, index) => {
        formData.append(`images[${index}]`, file);
      });

      try {
        await Axios.post("/api/vehicle", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        // Mostrar el toast
        this.showToast = true;

        // Ocultar el toast después de unos segundos
        setTimeout(() => {
          this.showToast = false; // Esto oculta el toast
        }, 3000); // 3000 ms = 3 segundos
      } catch (error) {
        console.error("Error al agregar el vehículo:", error);
        this.errorMessage = "Hubo un error al enviar los datos del vehículo."; // Asigna el mensaje de error
        this.showErrorModal = true; // Muestra el modal de error
      }
    },
    prev() {
      this.$router.go(-1);
    },
    closeErrorModal() {
      this.showErrorModal = false; // Cierra el modal
    },
  },
};
</script>

<style scoped lang="scss">
.form {
  display: grid;
  grid-template-columns: auto auto;
}
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 50;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
}

.btn-new {
  background-color: $color-background-secondary;
  font-size: clamp(12px, 1vw, 1.5rem);
  border-radius: 8px;
  padding: 14px 25px;
  color: $color-font-tertiary;
}
#toast-container {
  position: fixed;
  top: 1rem; /* Distancia desde la parte superior */
  right: 1rem; /* Distancia desde la derecha */
  z-index: 9999; /* Asegúrate de que esté por encima de otros elementos */
}
#toast-container {
  position: fixed;
  top: 1rem; /* Distancia desde la parte superior */
  right: 1rem; /* Distancia desde la derecha */
  z-index: 9999; /* Asegúrate de que esté por encima de otros elementos */
}
</style>
