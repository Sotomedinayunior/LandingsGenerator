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
            <h2 class="text-2xl font-bold mb-4">Detalla los datos del vehículo</h2>
  
            <div class="mb-4">
              <input
                v-model="currentVehicle.name"
                id="name"
                type="text"
                placeholder="Nombre del Vehículo"
                class="mt-1 block text-sm w-[450px] border outline-none border-gray-300 rounded-md p-3"
                required
              />
            </div>
            <div class="mb-4">
              <textarea
                v-model="currentVehicle.description"
                id="description"
                placeholder="Describe brevemente el vehículo"
                class="mt-1 block w-[450px] border border-gray-300 outline-none rounded-md p-2"
                required
              ></textarea>
            </div>
            <div class="mb-4">
              <input
                v-model="currentVehicle.price"
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
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.luggage"
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
                  <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>
  
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.people"
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
                  <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>
  
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    v-model="currentVehicle.type_of_car"
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
                  <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-500"></i>
                  </div>
                </div>
  
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
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
                  <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
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
                    v-model="currentVehicle.bluetooth"
                    name="bluetooth"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                  />
                  <label
                    for="checked-bluetooth"
                    class="ms-2 text-sm font-medium text-gray-900"
                  >Bluetooth</label>
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-siriusxm"
                    type="checkbox"
                    name="siriusxm"
                    v-model="currentVehicle.siriusxm"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                  />
                  <label
                    for="checked-siriusxm"
                    class="ms-2 text-sm font-medium text-gray-900"
                  >SiriusXM</label>
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-gps"
                    type="checkbox"
                    name="gps"
                    v-model="currentVehicle.gps"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                  />
                  <label
                    for="checked-gps"
                    class="ms-2 text-sm font-medium text-gray-900"
                  >GPS</label>
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-automatic"
                    type="checkbox"
                    name="automatic"
                    v-model="currentVehicle.automatic"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                  />
                  <label
                    for="checked-automatic"
                    class="ms-2 text-sm font-medium text-gray-900"
                  >Transmisión</label>
                </div>
                <div class="flex items-center">
                  <input
                    id="checked-air-conditioning"
                    type="checkbox"
                    name="air_conditioning"
                    v-model="currentVehicle.apple_car"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                  />
                  <label
                    for="checked-air-conditioning"
                    class="ms-2 text-sm font-medium text-gray-900"
                  >apple car</label>
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
    </div>
  </template>
  
  <script>
  import Axios from '../axios';
  
  export default {
    data() {
      return {
        currentVehicle: {
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
        vehicleImages: [],
        vehicle: [],
        loading: false,
        currentImage: null,
      };
    },
    methods: {
      handleImageUpload(event) {
        const files = event.target.files;
        if (files.length > 0) {
          const fileReader = new FileReader();
          fileReader.onload = (e) => {
            this.currentImage = e.target.result;
          };
          fileReader.readAsDataURL(files[0]);
          this.vehicleImages = Array.from(files).map(file => URL.createObjectURL(file));
        }
      },
      removeImage(index) {
        this.vehicleImages.splice(index, 1);
      },
      prev() {
        // Implement logic to go back
      },
      async updateVehicle() {
        // Implement the logic to update the vehicle
        console.log('Updated Vehicle:', this.currentVehicle);
        try {
          const vehicleId = this.$route.params.id;
          const response = await Axios.put(`/api/vehicles/${vehicleId}`, this.currentVehicle);
          console.log('Vehicle updated successfully:', response.data);
        } catch (error) {
          console.error('Error updating vehicle:', error);
        }
      },
      async loadVehicleData(vehicleId) {
        this.loading = true; // Indicar que está cargando
        try {
          const response = await Axios.get(`/api/vehicles/${vehicleId}`);
          this.currentVehicle = response.data.vehicles; // Asigna los datos recibidos
          console.log('datos de la landing:', this.currentVehicle);
        } catch (err) {
          console.error(`Error al obtener los datos: ${err}`);
        } finally {
          this.loading = false; // Finaliza el estado de carga
        }
      },
    },
    mounted() {
      const vehicleId = this.$route.params.id; // Assuming you're using Vue Router
      this.loadVehicleData(vehicleId);
    },
  };
  </script>
  
  <style scoped>
  /* Your custom styles here */
  </style>
  