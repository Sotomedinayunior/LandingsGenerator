<template>
  <div>
    <button
      @click="prev"
      class="flex items-center mb-4 px-4 py-2 ml-10 text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
    >
      <i class="fa fa-arrow-left mr-2"></i>Atrás
    </button>

    <div v-if="loading" class="text-center">Cargando...</div>

    <div v-else>
      <form
        @submit.prevent="updateVehicle"
        class="grid grid-cols-1 md:grid-cols-2 gap-5"
        enctype="multipart/form-data"
      >
        <div class="pl-10">
          <div
            class="border-2 border-dashed border-gray-300 bg-[#DDDDDD33] p-4 w-full h-40 flex items-center justify-center relative"
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
                  class="h-full max-h-full object-contain"
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
            <input
              v-model="currentVehicle.name"
              id="name"
              type="text"
              placeholder="Nombre del Vehículo"
              class="mt-1 block text-sm w-[450px] border outline-none border-gray-300 rounded-md p-3"
            />
          </div>
          <div class="mb-4">
            <textarea
              v-model="currentVehicle.description"
              id="description"
              placeholder="Describe brevemente el vehículo"
              class="mt-1 block w-[450px] border border-gray-300 outline-none rounded-md p-2"
            ></textarea>
          </div>
          <div class="mb-4">
            <input
              v-model="currentVehicle.price"
              id="price"
              type="number"
              placeholder="Precio por día"
              class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2"
            />
          </div>
          <div class="mb-4">
            <h2 class="text-lg font-bold mb-4">Seleccionar característica</h2>
            <div class="flex space-x-4">
              <div class="relative inline-block">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="currentVehicle.luggage"
                  name="luggage"
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

              <div class="relative inline-block">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="currentVehicle.people"
                  name="people"
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

              <div class="relative inline-block">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="currentVehicle.type_of_car"
                  name="type_of_car"
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

              <div class="relative inline-block">
                <select
                  class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  v-model="currentVehicle.transmision"
                  name="transmision"
                >
                  <option disabled>Transmisión</option>
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
      class="fixed inset-0 flex items-center justify-center z-50"
      v-if="showModal"
      @click.self="closeModal"
    >
      <div class="bg-white p-4 rounded shadow-lg max-w-sm">
        <p class="text-lg font-bold mb-2">Imágenes agregadas exitosamente</p>
        <button
          @click="closeModal"
          class="px-4 py-2 bg-[#F57200] text-white font-bold rounded hover:bg-[#d06b2e] transition-colors"
        >
          Ok
        </button>
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
      }, // Inicializa  // Asegúrate de inicializar el objeto del vehículo
      error: false,
      loading: true,
      currentImage: null,

      vehicleImages: [], // Inicializa el array de imágenes
    };
  },
  methods: {
    closeModal() {
      this.showModal = false;
    },
    fetchData() {
      const landingId = localStorage.getItem("NellyLandingCreate");
      const vehicleId = this.$route.params.id;

      Axios.get(`/vehicles/${landingId}/${vehicleId}`)
        .then((response) => {
          console.log(response.data);
          this.vehicleImages = response.data.vehicle.images.map(
            (image) => `/storage/${image.path_images}`
          );
          this.currentVehicle = response.data.vehicle; // Usa currentVehicle
        })
        .catch((error) => {
          this.error = true;
          console.error("Error fetching data:", error); // Para depuración
        })
        .finally(() => {
          this.loading = false;
        });
    },
    updateVehicle() {
      const landingId = localStorage.getItem("NellyLandingCreate");
      const vehicleId = this.$route.params.id;
      Axios.put(`/vehicles/${landingId}/${vehicleId}`, this.currentVehicle)
        .then((response) => {
          console.log("Vehículo actualizado:", response.data);
        
          this.showModal = true;
          this.closeModal=false;  

        })
        .catch((error) => {
          console.error("Error actualizando el vehículo:", error);
        });
    },
    handleImageUpload(event) {
      const files = event.target.files;
      this.vehicleImages = []; // Reinicializa el array de imágenes en el componente

      for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.vehicleImages.push(e.target.result); // Agrega la imagen al array
        };
        reader.readAsDataURL(files[i]);
      }
    },

    removeImage(index) {
      this.vehicleImages.splice(index, 1); // Elimina la imagen del array
    },
    prev() {
      this.$router.push("/layout-designer/add-vehicles");
    },
  },

  mounted() {
    this.fetchData();
  },
};
</script>

<style scoped>
/* Your custom styles here */
</style>
