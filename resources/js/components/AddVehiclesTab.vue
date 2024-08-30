<template>
  <div class="container my-3">
    <!-- Estado Inicial: Contador de Vehículos -->
    <div v-if="step === 1">
      <div class="flex justify-around items-center">
        <div class="flex items-center">
          <i class="fa fa-car mr-2"></i>
          <h2 class="text-2xl font-bold">Vehículos</h2>
          <span
            class="bg-[#F57200] text-white ml-2 px-2 py-1 rounded text-sm"
            >{{ vehicle.vehicles.length }}</span
          >
        </div>
        <button
          @click="nextStep"
          class="px-4 py-2 text-sm text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
        >
          + Agregar Vehículo
        </button>
      </div>
      <p class="text-gray-500 mt-2 ml-60">
        Agregar los vehículos para esta landing
      </p>

      <div v-if="vehicle.vehicles.length > 0" class="flex flex-col">
        <!-- Aqui va el vehicle TabVehicle -->

        <TableVehicleTab />
        <div><button class="btn-new" @click="handleNext">Continuar</button></div>
      </div>
    </div>

    <!-- Formulario para Agregar Vehículo -->
    <div v-else-if="step === 2">
      <button
        @click="previousStep"
        class="flex items-center mb-4 px-4 py-2 text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
      >
        <i class="fa fa-arrow-left mr-2"></i>Atrás
      </button>
      <div>
        <!-- Carousel de imágenes del vehículo -->
        <form
          @submit.prevent="addVehicle"
          class="grid grid-cols-1 md:grid-cols-2 gap-5"
          enctype="multipart/form-data"
        >
          <div class="pl-10">
            <!-- Contenedor de carga de imágenes -->
            <div
              class="border-2 border-dashed border-gray-300 bg-[#DDDDDD33] p-4 w-full h-40 flex items-center justify-center relative"
            >
              <input
                type="file"
                id="vehicle-images"
                multiple
                accept="image/*"
                @change="handleImageUpload"
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
              <div class="flex space-x-4">
                <!-- Select Equipaje -->
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="newVehicle.luggage"
                    name="luggage"
                    required
                  >
                    <option disabled>Equipaje</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="8">8</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-suitcase text-gray-500"></i>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>

                <!-- Select Capacidad -->
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="newVehicle.people"
                    name="people"
                    required
                  >
                    <option disabled>Capacidad</option>
                    <option value="2">2 Personas</option>
                    <option value="4">4 Personas</option>
                    <option value="6">6 Personas</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-users text-gray-500"></i>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>

                <!-- Select Tipo -->
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="newVehicle.type_of_car"
                    name="type_of_car"
                    required
                  >
                    <option disabled>Tipo</option>
                    <option value="sedan">Sedan</option>
                    <option value="suv">SUV</option>
                    <option value="camioneta">Camioneta</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fas fa-car text-gray-500"></i>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>

                <!-- Select Tipo -->
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                    v-model="newVehicle.transmision"
                    name="transmision"
                  >
                    <option disabled>Transmision</option>
                    <option value="automatica">automática</option>
                    <option value="cvt">CVT</option>
                    <option value="secuencial">secuencial</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-gears text-gray-500"></i>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-4">
              <h3 class="text-lg font-bold mb-4">
                Seleccione características adicionales
              </h3>
              <div class="flex space-x-4">
                <div class="flex items-center">
                  <input
                    id="checked-bluetooth"
                    type="checkbox"
                    v-model="newVehicle.bluetooth"
                    name="bluetooth"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="checked-checkbox"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >Bluetooth</label
                  >
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-siriuxmx"
                    type="checkbox"
                    name="siriusxm"
                    v-model="newVehicle.siriusxm"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="checked-checkbox"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >SiriusXM</label
                  >
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-gps"
                    type="checkbox"
                    name="gps"
                    v-model="newVehicle.gps"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="checked-checkbox"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >GPS</label
                  >
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-checkbox"
                    type="checkbox"
                    v-model="newVehicle.apple_car"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="checked-checkbox"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >Apple Car</label
                  >
                </div>
              </div>
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
    </div>
  </div>
</template>

<script>
import Axios from "../axios";
import TableVehicleTab from "./TableVehicle.vue";

export default {
  components: { TableVehicleTab },
  data() {
    return {
      step: 1,
      vehicle: [],
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
      loading: false,
    };
  },
  created() {
    const storedId = localStorage.getItem("NellyLandingCreate");
    if (storedId) {
      this.newVehicle.id_landing = parseInt(storedId, 10);
    }
    this.getLanding();
  },
  methods: {
    nextStep() {
      this.step = 2;
    },
    previousStep() {
      this.step = 1;
    },
    handleNext() {
      this.$emit('next', 'review');
    },
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
    async getLanding() {
      const storedId = localStorage.getItem("NellyLandingCreate");
      this.loading = true; // Indicar que está cargando
      try {
        const response = await Axios.get(`/api/vehicles/${storedId}`);
        this.vehicle = response.data;
        console.log(response.data);
      } catch (err) {
        console.error(`Error al obtener los datos: ${err}`);
      } finally {
        this.loading = false; // Finalizar el estado de carga
      }
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

        alert("Vehículo agregado con éxito");
        this.getLanding(); // Actualizar la lista de vehículos
        this.previousStep(); // Volver al contador de vehículos
      } catch (error) {
        console.error("Error al agregar el vehículo:", error);
        alert("Hubo un error al enviar los datos del vehículo.");
      }
    },
  },
};
</script>

<style scoped lang="scss">
.btn-new {
  background-color: $color-background-secondary;
  font-size: clamp(12px, 1vw, 1.5rem);
  border-radius: 8px;
  padding: 14px 25px;
  color: $color-font-tertiary;
}
</style>
