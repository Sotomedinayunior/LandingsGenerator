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
            >{{ vehicles.length }}</span
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
          class="grid grid-cols-1 md:grid-cols-2"
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
              <div v-for="(image, index) in vehicleImages" :key="index" class="relative">
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
                    class="appearance-none pl-10 pr-4 py-2 border rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  >
                    <option>Equipaje</option>
                    <option>Maletero</option>
                    <option>Carga</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 text-gray-500"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 12h18M3 12l6-6m-6 6l6 6"
                      />
                    </svg>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 text-gray-500"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </div>
                </div>

                <!-- Select Capacidad -->
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-4 py-2 border rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  >
                    <option>Capacidad</option>
                    <option>2 Personas</option>
                    <option>4 Personas</option>
                    <option>6 Personas</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 text-gray-500"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 8h12M6 16h12M6 12h12"
                      />
                    </svg>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 text-gray-500"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </div>
                </div>

                <!-- Select Tipo -->
                <div class="relative inline-block">
                  <select
                    class="appearance-none pl-10 pr-4 py-2 border rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                  >
                    <option>Tipo</option>
                    <option>Sedan</option>
                    <option>SUV</option>
                    <option>Camioneta</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 text-gray-500"
                      fill="none"
                      viewBox="0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 8h12M6 16h12M6 12h12"
                      />
                    </svg>
                  </div>
                  <div
                    class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-5 w-5 text-gray-500"
                      fill="none"
                      viewBox="0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      />
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <button
              type="submit"
              class="px-4 py-2 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
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
export default {
  data() {
    return {
      step: 1,
      vehicles: [], // Array de vehículos
      newVehicle: {
        name: '',
        description: '',
        price: '',
      },
      vehicleImages: [], // Array para almacenar las imágenes cargadas
      currentImage: null, // Imagen seleccionada para previsualización
    };
  },
  methods: {
    nextStep() {
      this.step = 2;
    },
    previousStep() {
      this.step = 1;
    },
    handleImageUpload(event) {
      const files = event.target.files;
      if (files.length + this.vehicleImages.length > 12) {
        alert('Puedes subir un máximo de 12 imágenes.');
        return;
      }
      Array.from(files).forEach((file) => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.vehicleImages.push(e.target.result);
          };
          reader.readAsDataURL(file);
        } else {
          alert('Por favor, selecciona solo imágenes.');
        }
      });
    },
    removeImage(index) {
      this.vehicleImages.splice(index, 1);
    },
    addVehicle() {
      // Aquí agregarías el código para agregar el vehículo
      this.vehicles.push({
        ...this.newVehicle,
        images: this.vehicleImages,
      });
      // Resetear campos
      this.newVehicle = { name: '', description: '', price: '' };
      this.vehicleImages = [];
      this.step = 1; // Regresar al paso inicial
    },
  },
};
</script>

<style scoped>
/* Estilos adicionales si es necesario */
</style>
