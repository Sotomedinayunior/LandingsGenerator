<template>
  <div>
    <button
      @click="prev"
      class="flex items-center mb-4 px-4 py-2 text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
    >
      <i class="fa fa-arrow-left mr-2"></i>Atrás
    </button>

    <div v-if="loading" class="text-center">Cargando...</div>

    <div v-else class="mx-w-md">
      <form
        @submit.prevent="updateVehicle"
        class="flex justify-between space-x-4"
        enctype="multipart/form-data"
      >
        <div class="">
          <div
            class="border-2 border-dashed border-gray-300 bg-[#DDDDDD33] p-4 w-full flex items-center justify-center relative"
          >
            <input
              type="file"
              id="vehicle-images"
              multiple
              accept="image/*"
              ref="imageInput"
              @change="handleImageUpload"
              class="absolute inset-0 opacity-0 cursor-pointer"
            />

            <label
              for="vehicle-images"
              class="flex flex-col items-center justify-center text-center text-gray-500 cursor-pointer w-full h-full"
            >
              <template v-if="currentImage">
                <img
                  :src="currentImage"
                  alt="Vehicle Preview"
                  class="h-full max-h-full w-full object-cover"
                />
              </template>
              <template v-else>
                <i class="fa-solid fa-camera text-[#333] text-4xl"></i>
                <p class="text-[#333] mt-2">
                  Sube hasta 12 imágenes del vehículo
                </p>
              </template>
            </label>
          </div>

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

        <div>
          <h2 class="text-2xl font-bold mb-4">
            Detalla los datos del vehículo
          </h2>

          <div class="mb-4">
            <label for="name" class="text-xs font-semibold text-gray-400"
              >Nombre del vehículo</label
            >
            <input
              v-model="currentVehicle.name"
              id="name"
              type="text"
              placeholder="Nombre del Vehículo"
              class="mt-1 block text-xs w-[450px] border outline-none border-gray-300 rounded-md p-3"
            />
          </div>
          <div class="mb-4">
            <label for="description" class="text-xs font-semibold text-gray-400"
              >Descripción del vehículo</label
            >
            <textarea
              v-model="currentVehicle.description"
              id="description"
              placeholder="Describe brevemente el vehículo"
              class="mt-1 block w-[450px] border text-xs border-gray-300 outline-none rounded-md p-2"
            ></textarea>
          </div>
          <div class="mb-4">
            <label for="precio" class="text-xs font-semibold text-gray-400"
              >Precio del vehículo</label
            >
            <div class="flex items-center">
              <input
                v-model="currentVehicle.price"
                id="price"
                type="number"
                placeholder="Precio por día"
                class="mt-1 block w-[200px] border text-xs  border-gray-300 rounded-md p-2"
              />
              <span class="text-xs  ml-2 text-orange-400 italic text-[10px]">Precio por día</span>
            </div>
          </div>
          <div class="mb-4">
            <h2 class="text-lg font-bold mb-4">Seleccionar característica</h2>
            <div class="flex flex-col">
              <!-- Grupo 1 -->
              <div class="flex space-x-3">
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-xs rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.luggage"
                    
                    name="luggage"
                  >
                  <option selected>{{currentVehicle.luggage}}</option>

                    <option value="2">2 Maletas</option>
                    <option value="4">4 Maletas</option>
                    <option value="8">8 Maletas</option>
                  </select>
                </div>

                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-xs rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.people"
                    name="people"
                  >
                    <option selected>{{ currentVehicle.people }}</option>
                    <option value="2">2 Personas</option>
                    <option value="4">4 Personas</option>
                    <option value="6">6 Personas</option>
                  </select>
                </div>
              </div>

              <!-- Grupo 2 -->
              <div class="flex space-x-3">
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-xs rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.type_of_car"
                    name="type_of_car"
                  >
                    <option selected>{{ currentVehicle.type_of_car }}</option>
                    <option value="sedan">Sedan</option>
                    <option value="suv">SUV</option>
                    <option value="camioneta">Camioneta</option>
                  </select>
                </div>

                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-6 pr-6 py-2 border text-xs rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.transmision"
                    name="transmision"
                  >
                    <option selected>{{ currentVehicle.transmision }}</option>
                    <option value="automatica">automática</option>
                    <option value="cvt">CVT</option>
                    <option value="secuencial">secuencial</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-4">
            <h2 class="text-lg font-bold mb-4">Caracteristicas Especiales</h2>
            <div
              v-if="specialFeatures && specialFeatures.length"
              class="flex flex-col"
            >
              <div
                v-for="feature in specialFeatures"
                :key="feature.id"
                class="flex items-center"
              >
                <input
                  type="checkbox"
                  :value="feature.id"
                  v-model="selectedFeatures"
                  class="mr-2"
                />
                <label>{{ feature.name }}</label>
              </div>
            </div>
          </div>

          <button
            type="submit"
            class="w-[450px] px-4 py-2 bg-[#F57200] text-white font-bold rounded hover:bg-[#d06b2e] transition-colors"
          >
            Actualizar Vehículo
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
        <div class="ms-3 text-sm font-normal">
          Vehículo Actualizado con exito.
        </div>
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
              class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-red-600"
            >
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";

export default {
  data() {
    return {
      showModal: false,

      specialFeatures: [],
      selectedFeatures: [], // Características seleccionadas
      showToast: false, // Controla la visibilidad del toast

      currentVehicle: {
        name: "",
        description: "",
        price: null,
        luggage: null,
        people: null,
        type_of_car: "",
        transmision: "",
        bluetooth: false,
        siriusxm: false,
        gps: false,
        automatic: false,
        apple_car: false,
        images: [],
      },
      error: false,
      loading: true,
      currentImage: null,
      showModalFeature: false,
      newFeature: {
        name: "",
        value: "",
      },

      showErrorModal: false, // Controla la visibilidad del modal
      errorMessage: "", // Mensaje de error
      vehicleImages: [],
    };
  },
  methods: {
    async loadSpecialFeatures() {
      try {
        const response = await Axios.get(`/special-features`);
        if (response.data) {
          this.specialFeatures = response.data;
          console.log(
            "Características especiales cargadas:",
            this.specialFeatures
          );
        } else {
          console.error("No se encontraron características especiales");
          this.specialFeatures = [];
        }
      } catch (err) {
        this.error = "Error al cargar características especiales.";
        console.error(err);
      } finally {
        this.loading = false;
      }
    },

    closeModal() {
      this.showModal = false;
      this.showModalFeature = false;
    },

    async fetchData() {
      const landingId = this.$route.params.id;
      const vehicleId = localStorage.getItem("vehicleToEdit");

      try {
        const response = await Axios.get(`/vehicles/${landingId}/${vehicleId}`);
        console.log(response.data);
        this.vehicleImages = response.data.vehicle.images.map(
          (image) => `/storage/${image.path_images}`
        );
        this.currentVehicle = response.data.vehicle;
      } catch (error) {
        this.error = true;
        console.error("Error fetching data:", error);
      } finally {
        this.loading = false;
      }
    },
    async updateVehicle() {
      const landingId = this.$route.params.id;
      const vehicleId = localStorage.getItem("vehicleToEdit");

      try {
        console.log(
          "Datos del vehículo antes de la actualización:",
          this.currentVehicle
        );

        // Actualizar datos generales del vehículo
        const response = await Axios.put(
          `/vehicles/${landingId}/${vehicleId}`,
          this.currentVehicle
        );
        console.log(
          "Respuesta del servidor al actualizar el vehículo:",
          response.data
        );

        // Actualizar características especiales
        if (this.selectedFeatures && this.selectedFeatures.length > 0) {
          // Iterar sobre cada característica seleccionada
          for (const featureId of this.selectedFeatures) {
            // Buscar el nombre de la característica
            const feature = this.specialFeatures.find(
              (f) => f.id === featureId
            );

            if (feature) {
              try {
                const featureResponse = await Axios.post(
                  `/vehicles/${vehicleId}/special-features`,
                  {
                    special_feature_id: feature.id,
                    name: feature.name, // Backend lo requiere
                  }
                );
                console.log(
                  `Característica especial asignada: ${feature.name}`,
                  featureResponse.data
                );
              } catch (featureError) {
                console.error(
                  `Error al asignar la característica especial (${feature.name}):`,
                  featureError.response || featureError
                );
              }
            }
          }
        } else {
          console.log("No se seleccionaron características para actualizar.");
        }

        // Mostrar mensaje de éxito
        this.showToast = true;
        setTimeout(() => {
          this.showToast = false;
        }, 3000);
      } catch (error) {
        // Manejo de errores
        console.error(
          "Error actualizando el vehículo:",
          error.response || error
        );
        this.errorMessage = "Hubo un error al enviar los datos del vehículo.";
        this.showErrorModal = true;
      }
    },

    handleImageUpload(event) {
      const files = event.target.files;

      this.currentImage = null;

      Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.vehicleImages.push(e.target.result);
          this.currentImage = e.target.result;
          console.log(this.currentImage);
        };
        reader.readAsDataURL(file);
      });
    },

    removeImage(index) {
      this.vehicleImages.splice(index, 1);
    },

    prev() {
      this.$router.go(-1);
    },

    openFeatureModal() {
      this.showModalFeature = true;
    },

    async addFeature() {
      if (!this.newFeature.name || !this.newFeature.value) {
        alert("Por favor, completa todos los campos de la característica.");
        return;
      }

      const featureData = {
        features: [
          {
            name: this.newFeature.name,
          },
        ],
      };

      try {
        const vehicleId = localStorage.getItem("vehicleToEdit");
        await Axios.post(`/special-feature/${vehicleId}`, featureData);
        alert("Característica agregada con éxito");
        this.closeModal();
      } catch (error) {
        console.error("Error al agregar la característica:", error);
        alert("Hubo un error al agregar la característica.");
      }
    },
  },

  mounted() {
    this.fetchData();
    this.loadSpecialFeatures();
  },
};
</script>

<style scoped></style>
