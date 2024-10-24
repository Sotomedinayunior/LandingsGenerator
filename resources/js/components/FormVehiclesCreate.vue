<template>
  <div>
    <div></div>
    <button
      @click="prev"
      class="flex items-center mb-4 px-4 py-2 ml-10 text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
    >
      <i class="fa fa-arrow-left mr-2"></i>Atrás
    </button>
    <div class="p-2">
      <!-- Carousel de imágenes del vehículo -->
      <form
        @submit.prevent="addVehicle"
        class="flex justify-evelyn items-start"
        enctype="multipart/form-data"
      >
        <div class="w-full px-10">
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
              type="text"
              name="name"
              placeholder="Nombre del vehículo"
              id=""
              v-model="newVehicle.name"
              class="mt-1 block w-[300px] border border-gray-300 outline-none rounded-md p-2 text-xs"
            />
          </div>
          <div class="mb-4">
            <textarea
              v-model="newVehicle.description"
              id="description"
              maxlength="255"
              placeholder="Describe brevemente el vehículo"
              class="mt-1 block w-[300px] border border-gray-300 outline-none rounded-md p-2 text-xs"
              required
            ></textarea>
          </div>
          <div class="mb-4">
            <div class="flex items-center justify-start">
              <input
                type="number"
                name="price"
                id=""
                v-model="newVehicle.price"
                class="mt-1 block w-[300px] border border-gray-300 outline-none rounded-md p-2 text-xs"
              />
              <span class="text-xs text-gray-400 mx-2">Precio por dia</span>
            </div>
          </div>
          <div class="mb-4">
            <h2 class="text-lg font-bold mb-4">
              Seleccionar características del vehiculo
            </h2>
            <div class="flex flex-col space-x-4">
              <div class="flex space-x-2">
                <div>
                  <label for="equipaje" class="text-xs font-bold"
                    >Seleccione un equipaje</label
                  >
                  <select
                    id="equipaje"
                    v-model="newVehicle.luggage"
                    class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    required
                  >
                    <option value="" disabled selected>Equipaje</option>
                    <option
                      v-for="item in Equipaje"
                      :key="item.name"
                      :value="item.name"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
                <div>
                  <label for="equipaje" class="text-xs font-bold"
                    >Seleccione la capacidad</label
                  >
                  <select
                    id="Capacidad"
                    v-model="newVehicle.people"
                    name="people"
                    class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-xs"
                    required
                  >
                    <option value="" disabled>Capacidad</option>
                    <option
                      v-for="item in Capacidad"
                      :key="item.name"
                      :value="item.name"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
                <!-- Select Capacidad -->
              </div>
              <div class="flex space-x-2">
                <div>
                  <label for="type of car" class="text-xs font-bold"
                    >Selecciona el tipo de vehiculo</label
                  >
                  <select
                    id="type_of_car"
                    v-model="newVehicle.type_of_car"
                    name="type_of_car"
                    class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-xs"
                    required
                  >
                    <option value="" disabled>Tipo de vehiculo</option>
                    <option
                      v-for="item in Tipo"
                      :key="item.name"
                      :value="item.name"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>

                <!-- Select Tipo de transmision -->
                <div>
                  <label for="transmision" class="text-xs font-bold"
                    >Tipo de transmisión</label
                  >
                  <select
                    id="transmision"
                    v-model="newVehicle.transmision"
                    name="transmision"
                    class="mt-1 block w-[200px] border border-gray-300 rounded-md p-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 text-xs"
                    required
                  >
                    <option value="" disabled>Transmision</option>
                    <option
                      v-for="item in Transmision"
                      :key="item.name"
                      :value="item.name"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-4">
            <h3 class="text-lg font-bold mb-4">
              características adicionales
            </h3>
            <div class="flex space-x-3">
              <template v-if="features && features.length > 0">
                <div class="flex flex-wrap space-x-2">
                  <span
                    v-for="(feature, index) in features"
                    :key="index"
                    class="inline-block bg-blue-500 text-white text-xs font-medium px-2 py-1 rounded-md"
                  >
                    {{ feature.name }}
                  </span>
                </div>
              </template>

              <template v-else>
                <p class="text-xs text-gray-500">
                  No se han creado características para este vehículo.
                </p>
              </template>
            </div>
          </div>
          <div>
            <button
              type="submit"
              class="px-4 py-2 ml-30 mt-5 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
            >
              Agregar Vehículo
            </button>
          </div>
        </div>
      </form>
      <!-- Diálogo de confirmación -->
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
            Vehículo agregado con éxito.
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

      <Dialog header="Confirmación" v-model:visible="showError" modal>
        <div class="flex justify-around">
          <p>Error al crear</p>
        </div>
        <button @click="closeDialog">Cerrar</button>
      </Dialog>
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
      showErrorModal: false, // Controla la visibilidad del modal
      errorMessage: "", // Mensaje de error
      showError: false,
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
      },
      features: [],

      selectedItem: null, // Almacena el vehículo seleccionado
      items: [], // Lista completa de vehículos
      filteredItems: [], // Lista filtrada para sugerencias

      Equipaje: null,
      Capacidad: null,
      Tipo: null,
      Transmision: null,
    };
  },
  mounted() {
    this.fetchFeatures(); // Llama al método fetchFeatures al montar el componente
    this.Transmision = [
      { name: "Automática" },
      { name: "Manual" },
      { name: "CVT" },
      { name: "DCT" },
      { name: "AMT" },
      { name: "Semi-Automática" },
      { name: "Tiptronic" },
      { name: "i-MMD" },
    ];
    this.Capacidad = [
      { name: "1" },
      { name: "2" },
      { name: "3" },
      { name: "4" },
      { name: "5" },
      { name: "6" },
      { name: "7" },
      { name: "8" },
      { name: "9" },
      { name: "10" },
    ];
    this.Tipo = [
      { name: "Sedan" },
      { name: "SUV" },
      { name: "Pickup" },
      { name: "Van" },
      { name: "Coupe" },
      { name: "Convertible" },
      { name: "Hatchback" },
      { name: "Wagon" },
      { name: "Crossover" },
      { name: "Deportivo" },
      { name: "Camioneta" },
      { name: "Familiar" },
      { name: "Compacto" },
      { name: "Eléctrico" },
      { name: "Híbrido" },
      { name: "De Lujo" },
      { name: "Otros" },
    ];
    this.Equipaje = [
      { name: "1" },
      { name: "2" },
      { name: "3" },
      { name: "4" },
      { name: "5" },
      { name: "6" },
      { name: "7" },
      { name: "8" },
      { name: "9" },
      { name: "10" },
    ];
    this.items = [
      { name: "Toyota Corolla" },
      { name: "Honda Civic" },
      { name: "Ford Mustang" },
      { name: "Chevrolet Camaro" },
      { name: "Jeep Wrangler" },
      { name: "Toyota RAV4" },
      { name: "Nissan Sentra" },
      { name: "Hyundai Elantra" },
      { name: "Kia Forte" },
      { name: "Mazda 3" },
      { name: "Volkswagen Jetta" },
      { name: "Subaru Impreza" },
      { name: "Audi A4" },
      { name: "BMW Serie 3" },
      { name: "Mercedes-Benz Clase C" },
      { name: "Lexus IS" },
      { name: "Infiniti Q50" },
      { name: "Acura ILX" },
      { name: "Genesis G70" },
      { name: "Tesla Model 3" },
      { name: "Porsche Taycan" },
      { name: "Jaguar I-PACE" },
      { name: "Audi e-tron" },
      { name: "BMW i3" },
      { name: "Chevrolet Bolt" },
      { name: "Nissan Leaf" },
      { name: "Kia Niro" },
      { name: "Hyundai Kona" },
      { name: "Ford Mustang Mach-E" },
      { name: "Volkswagen ID.4" },
      { name: "Toyota Prius" },
      { name: "Honda Insight" },
      { name: "Hyundai Ioniq" },
      { name: "Kia Soul" },
      { name: "Nissan Versa" },
      { name: "Chevrolet Spark" },
      { name: "Mitsubishi Mirage" },
      { name: "Smart EQ fortwo" },
      { name: "Mini Cooper SE" },
      { name: "Fiat 500e" },
      { name: "Honda Clarity" },
      { name: "Toyota Mirai" },
      { name: "Hyundai Nexo" },
      { name: "Chevrolet Equinox" },
      { name: "Ford Escape" },
      { name: "Jeep Cherokee" },
      { name: "Nissan Rogue" },
      { name: "Toyota RAV4" },
      { name: "Honda CR" },
      { name: "Jeep Grand Cherokee" },
      { name: "Ford Explorer" },
      { name: "Chevrolet Traverse" },
      { name: "Toyota Highlander" },
      { name: "Nissan Pathfinder" },
      { name: "Hyundai Palisade" },
      { name: "Kia Telluride" },
      { name: "Mazda CX-9" },
      { name: "Volkswagen Atlas" },
      { name: "Subaru Ascent" },
      { name: "Audi Q7" },

      { name: "Toyota Sienna" },
      // Otros vehículos
    ];
  },
  created() {
    const storedId = localStorage.getItem("NellyLandingCreate");
    if (storedId) {
      this.newVehicle.id_landing = parseInt(storedId, 10);
    }
  },
  methods: {
    async fetchFeatures() {
      this.loading = true; // Muestra el indicador de carga
      try {
        const response = await Axios.get("/api/features");
        this.features = response.data; // Almacena las características
      } catch (error) {
        console.error("Error al obtener características:", error);
      } finally {
        this.loading = false; // Cambia el estado de carga a falso
      }
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
    removeImage(index) {
      this.vehicleImages.splice(index, 1);
    },
    async addVehicle() {
      const formData = new FormData();

      // Iterar sobre los campos del vehículo
      for (const key in this.newVehicle) {
        let value = this.newVehicle[key];

        // Si es un objeto, extrae el campo relevante (por ejemplo, 'name')
        if (typeof value === "object" && value !== null) {
          value = value.name; // 'name' debe coincidir con lo que esperas enviar
        }

        formData.append(
          key,
          typeof value === "boolean" ? (value ? 1 : 0) : value
        );
      }

      // Agregar imágenes
      const imageInput = document.getElementById("vehicle-images").files;
      Array.from(imageInput).forEach((file, index) => {
        formData.append(`images[${index}]`, file);
      });
      // Mostrar el contenido del formData antes de enviarlo
      console.log("FormData enviado al backend:");
      for (let pair of formData.entries()) {
        console.log(pair[0] + ": " + pair[1]); // Muestra el nombre del campo y el valor
      }
      console.log("Descripción del vehículo:", this.newVehicle.description);

      // Envío de datos al backend
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

        this.newVehicle = {
          name: "",
          description: "",
          id_landing: 0,
          price: 0,
          luggage: null,
          people: null,
          type_of_car: null,
          transmision: null,
        };

        // Limpiar las imágenes
        this.vehicleImages = [];
        document.getElementById("vehicle-images").value = ""; // Limpiar input file
      } catch (error) {
        if (error.response && error.response.status === 422) {
          console.log("Errores de validación:", error.response.data.errors);
          console.error("Error al agregar el vehículo:", error);
          this.errorMessage = "Hubo un error al enviar los datos del vehículo."; // Asigna el mensaje de error
          this.showErrorModal = true; // Muestra el modal de error
          // Aquí puedes manejar los errores y mostrarlos en tu UI
        } else {
          console.error("Error inesperado:", error);
        }
      }
    },
    closeDialog() {
      this.showErrorModal = false;
    },

    prev() {
      this.$router.push("/layout-designer/add-vehicles");
    },
  },
};
</script>

<style scoped lang="scss">
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
