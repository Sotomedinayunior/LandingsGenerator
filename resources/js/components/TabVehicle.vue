<template>
    <div class="container my-3">
      <!-- Estado Inicial: Contador de Vehículos -->
      <div v-if="step === 1">
        <div class="flex justify-between items-center mb-3">
          <div class="flex items-center space-x-3">
            <select
              class="appearance-none pl-10 pr-6 py-2 border text-xs rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
              name="priceFilter"
              required
            >
              <option disabled selected>Filtrar por precio</option>
              <option value="barato">Más barato</option>
              <option value="caro">Más caro</option>
            </select>
            <select
              class="appearance-none pl-10 pr-6 py-2 border text-xs rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
              name="carTypeFilter"
              required
            >
              <option disabled selected>Tipo de carros</option>
              <option value="barato">Más barato</option>
              <option value="caro">Más caro</option>
            </select>
          </div>
          <button
            @click="nextStep()"
            class="bg-[#f16822] text-white px-4 py-2 rounded-md hover:bg-[#d5551d] text-xs"
          >
            + Agregar Vehículo
          </button>
        </div>
        <div class="flex flex-col">
          <!-- Componente de lista de vehículos -->
          <div v-if="loading">Cargando...</div>
          <div v-else>
            <table class="table">
              <thead>
                <tr>
                  <th style="opacity: 0;">Imagen</th>
                  <th>Nombre</th>
                  <th>Precio por día</th>
                  <th>Tipo de Carro</th>
                  <th>Equipaje</th>
                  <th>Personas</th>
                  <th>Transmisión</th>
                  <th>Acomodaciones</th>
                  <th>Comisiones</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="vehiculo in vehicles" :key="vehiculo.id">
                  <td class="vehiculo-nombre">
                    <img
                      :src="`/storage/${vehiculo.images[0].path_images}`"
                      :alt="vehiculo.name"
                      class="vehicle-image"
                    />
                  </td>
                  <td>{{ vehiculo.name }}</td>
                  <td>{{ vehiculo.price }}</td>
                  <td>{{ vehiculo.type_of_car }}</td>
                  <td>{{ vehiculo.luggage }}</td>
                  <td>{{ vehiculo.people }}</td>
                  <td>{{ vehiculo.transmision }}</td>
                  <td>{{ vehiculo.bluetooth }}</td>
                  <td>{{ vehiculo.commissions }}</td>
                  <td class="actions-cell">
                    <i
                      class="fa-solid fa-pencil"
                      @click="editVehicle(vehiculo)"
                    ></i>
                    <i class="fa-solid fa-trash"></i>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="error" class="error">Error al cargar los datos</div>
          </div>
        </div>
      </div>
  
      <!-- Formulario para actualizar un Vehículo -->
      <div v-else-if="step === 2">
        <h3 class="text-2xl text-gray-600 m-3 font-bold">Editando un vehiculo</h3>
        <form
          @submit.prevent="addVehicle"
          class="grid grid-cols-1 md:grid-cols-2 gap-5"
          enctype="multipart/form-data"
        >
          <div class="pl-7">
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
  
          <!-- Detalles del Vehículo -->
          <div>
            <h2 class="text-2xl font-bold mb-4">
              Detalla los datos del vehículo
            </h2>
            <div class="mb-4">
              <input
                v-model="newVehicle.name"
                placeholder="Nombre del Vehículo"
                class="mt-1 block text-sm w-[450px] border outline-none border-gray-300 rounded-md p-3"
                required
              />
            </div>
            <div class="mb-4">
              <textarea
                v-model="newVehicle.description"
                placeholder="Describe brevemente el vehículo"
                class="mt-1 block w-[450px] border border-gray-300 outline-none rounded-md p-2"
                required
              ></textarea>
            </div>
            <div class="mb-4">
              <input
                v-model="newVehicle.price"
                type="number"
                placeholder="Precio por día"
                class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2"
                required
              />
            </div>
  
            <!-- Características -->
            <div class="mb-4">
              <h2 class="text-lg font-bold mb-4">Seleccionar característica</h2>
              <div class="flex space-x-4">
                <!-- Select Equipaje -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.luggage"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
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
                </div>
                <!-- Select Capacidad -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.people"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                  >
                    <option disabled>Capacidad</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-users text-gray-500"></i>
                  </div>
                </div>
                <!-- Select Tipo de Carro -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.type_of_car"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                  >
                    <option disabled>Tipo de Carro</option>
                    <option value="sedan">Sedán</option>
                    <option value="suv">SUV</option>
                    <option value="hatchback">Hatchback</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-car text-gray-500"></i>
                  </div>
                </div>
                <!-- Select Transmisión -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.transmision"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                  >
                    <option disabled>Transmisión</option>
                    <option value="manual">Manual</option>
                    <option value="automatic">Automática</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-cogs text-gray-500"></i>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Acomodaciones -->
            <div class="mb-4">
              <h2 class="text-lg font-bold mb-4">Acomodaciones</h2>
              <div class="flex space-x-4">
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    v-model="newVehicle.bluetooth"
                    class="mr-2"
                  />
                  <label>Bluetooth</label>
                </div>
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    v-model="newVehicle.siriusxm"
                    class="mr-2"
                  />
                  <label>SiriusXM</label>
                </div>
                <div class="flex items-center">
                  <input type="checkbox" v-model="newVehicle.gps" class="mr-2" />
                  <label>GPS</label>
                </div>
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    v-model="newVehicle.apple_car"
                    class="mr-2"
                  />
                  <label>Apple CarPlay</label>
                </div>
              </div>
            </div>
  
            <!-- Comisiones -->
            <div class="mb-4">
              <input
                v-model="newVehicle.commissions"
                type="number"
                placeholder="Comisiones"
                class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2"
                required
              />
            </div>
  
            <!-- Botón de envío -->
            <div class="flex items-center justify-around space-x-4">
              <button
                @click="previousStep"
                class="flex items-center  px-4 py-2 text-gray-500 font-bold border border-gray-200 rounded hover:bg-gray-800 hover:text-white transition-colors"
              >
                Cancelar
              </button>
              <button
                type="submit"
                class="px-4 py-2 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] transition-colors"
              >
                Actualizar
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Esta parte es para agregar un vehicle -->
      <div v-else-if="step === 3">
        <h3 class="text-2xl text-gray-600 m-3 font-bold">Editando un vehiculo</h3>
        <form
          @submit.prevent="addVehicle"
          class="grid grid-cols-1 md:grid-cols-2 gap-5"
          enctype="multipart/form-data"
        >
          <div class="pl-7">
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
  
          <!-- Detalles del Vehículo -->
          <div>
            <h2 class="text-2xl font-bold mb-4">
              Detalla los datos del vehículo
            </h2>
            <div class="mb-4">
              <input
                v-model="newVehicle.name"
                placeholder="Nombre del Vehículo"
                class="mt-1 block text-sm w-[450px] border outline-none border-gray-300 rounded-md p-3"
                required
              />
            </div>
            <div class="mb-4">
              <textarea
                v-model="newVehicle.description"
                placeholder="Describe brevemente el vehículo"
                class="mt-1 block w-[450px] border border-gray-300 outline-none rounded-md p-2"
                required
              ></textarea>
            </div>
            <div class="mb-4">
              <input
                v-model="newVehicle.price"
                type="number"
                placeholder="Precio por día"
                class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2"
                required
              />
            </div>
  
            <!-- Características -->
            <div class="mb-4">
              <h2 class="text-lg font-bold mb-4">Seleccionar característica</h2>
              <div class="flex space-x-4">
                <!-- Select Equipaje -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.luggage"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
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
                </div>
                <!-- Select Capacidad -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.people"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                  >
                    <option disabled>Capacidad</option>
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-users text-gray-500"></i>
                  </div>
                </div>
                <!-- Select Tipo de Carro -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.type_of_car"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                  >
                    <option disabled>Tipo de Carro</option>
                    <option value="sedan">Sedán</option>
                    <option value="suv">SUV</option>
                    <option value="hatchback">Hatchback</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-car text-gray-500"></i>
                  </div>
                </div>
                <!-- Select Transmisión -->
                <div class="relative inline-block">
                  <select
                    v-model="newVehicle.transmision"
                    class="appearance-none pl-10 pr-6 py-2 border text-sm rounded-full text-gray-700 bg-white hover:bg-gray-100 focus:outline-none"
                    required
                  >
                    <option disabled>Transmisión</option>
                    <option value="manual">Manual</option>
                    <option value="automatic">Automática</option>
                  </select>
                  <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <i class="fa-solid fa-cogs text-gray-500"></i>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Acomodaciones -->
            <div class="mb-4">
              <h2 class="text-lg font-bold mb-4">Acomodaciones</h2>
              <div class="flex space-x-4">
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    v-model="newVehicle.bluetooth"
                    class="mr-2"
                  />
                  <label>Bluetooth</label>
                </div>
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    v-model="newVehicle.siriusxm"
                    class="mr-2"
                  />
                  <label>SiriusXM</label>
                </div>
                <div class="flex items-center">
                  <input type="checkbox" v-model="newVehicle.gps" class="mr-2" />
                  <label>GPS</label>
                </div>
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    v-model="newVehicle.apple_car"
                    class="mr-2"
                  />
                  <label>Apple CarPlay</label>
                </div>
              </div>
            </div>
  
            <!-- Comisiones -->
            <div class="mb-4">
              <input
                v-model="newVehicle.commissions"
                type="number"
                placeholder="Comisiones"
                class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2"
                required
              />
            </div>
  
            <!-- Botón de envío -->
            <div class="flex items-center justify-around space-x-4">
              <button
                @click="previousStep"
                class="flex items-center  px-4 py-2 text-gray-500 font-bold border border-gray-200 rounded hover:bg-gray-800 hover:text-white transition-colors"
              >
                Cancelar
              </button>
              <button
                type="submit"
                class="px-4 py-2 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] transition-colors"
              >
                Actualizar
              </button>
            </div>
          </div>
        </form>
      </div>


      </div>
   
  </template>
  
  <script>
  import Axios from "axios";
  import TableVehicleTab from "./TableVehicle.vue";
  
  export default {
    components: { TableVehicleTab },
    data() {
      return {
        step: 1,
        loading: true,
        error: false,
        vehicles: [], // Suponiendo que aquí almacenas los vehículos
        vehicleImages: [], // Array para almacenar las imágenes cargadas
        currentImage: null, // Imagen seleccionada para previsualización
        newVehicle: {
          name: "",
          description: "",
          price: 0,
          luggage: "",
          people: "",
          type_of_car: "",
          transmision: "",
          bluetooth: false,
          siriusxm: false,
          gps: false,
          apple_car: false,
          commissions: 0,
        },
      };
    },
    mounted() {
      this.Obtener();
    },
    methods: {
      nextStep(vehicle = null) {
        if (vehicle) {
          this.newVehicle = { ...vehicle };
          this.vehicleImages = vehicle.images.map(
            (img) => `/storage/${img.path_images}`
          );
          this.currentImage = this.vehicleImages[0] || null;
        }
        this.step++;
      },
      previousStep() {
        this.step--;
      },
      Obtener() {
        const landingId = this.$route.params.id;
        Axios.get(`/api/vehicles/${landingId}`)
          .then((response) => {
            if (response.data.vehicles) {
              this.vehicles = response.data.vehicles;
            } else {
              this.vehicles = [];
            }
            this.loading = false;
          })
          .catch((err) => {
            this.error = true;
            this.loading = false;
          });
      },
      handleImageUpload(event) {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.vehicleImages.push(e.target.result);
            if (!this.currentImage) {
              this.currentImage = e.target.result;
            }
          };
          reader.readAsDataURL(files[i]);
        }
      },
      removeImage(index) {
        this.vehicleImages.splice(index, 1);
      },
      addVehicle() {
        this.vehicles.push({
          ...this.newVehicle,
          images: this.vehicleImages,
        });
        this.resetForm();
        this.previousStep();
      },
      editVehicle(vehicle) {
        this.nextStep(vehicle);
      },
      resetForm() {
        this.newVehicle = {
          name: "",
          description: "",
          price: 0,
          luggage: "",
          people: "",
          type_of_car: "",
          transmision: "",
          bluetooth: false,
          siriusxm: false,
          gps: false,
          apple_car: false,
          commissions: 0,
        };
        this.vehicleImages = [];
        this.currentImage = null;
      },
    },
  };
  </script>

<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  border-radius: 8px 8px 0 0; /* Añadir borde redondeado superior */
  overflow: hidden; /* Asegurar que el borde redondeado se aplique correctamente */
}

.table thead {
  background-color: #fdf0e9;
  color: #222;
  font-size: 10px !important;
  border: 2px solid #fc8b46;
  border-radius: 8px 8px 0 0; /* Añadir borde redondeado superior */
}

.table th,
.table td {
  padding: 7px;
  text-align: left;
  border-bottom: 1.2px solid #ddd;
  vertical-align: middle;
}
.table td {
  font-size: 12px;
}

.table th {
  text-transform: capitalize;
  letter-spacing: 0.04em;
  font-weight: 300;
  font-size: 12px; /* text-xs */
}

.table td img {
  width: 40px;
  height: 40px;
  margin-right: 10px;
  border-radius: 5px;
}

.actions-cell {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* Ocultar íconos por defecto */
.actions-cell {
  opacity: 0;
  transition: opacity 0.3s ease;
}
.actions-cell i {
  cursor: pointer;
}

/* Mostrar íconos al hacer hover en la fila */
tr:hover .actions-cell {
  opacity: 1;
}

.error {
  color: red;
  font-size: 14px;
}

.vehicle-image {
  border-radius: 5px;
  width: 40px;
  height: 40px;
}

.vehiculo-nombre {
  display: flex;
  align-items: center;
}
</style>
