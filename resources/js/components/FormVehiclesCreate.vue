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
            <AutoComplete
              v-model="newVehicle.name"
              :suggestions="filteredItems"
              @complete="searchItems"
              :virtualScrollerOptions="{ itemSize: 38 }"
              optionLabel="name"
              dropdown
              id="name"
              placeholder="Nombre del Vehículo"
              class="mt-1 block text-xs w-[450px] outline-none rounded-md"
              required
            />
          </div>
          <div class="mb-4" style="max-width: 510px;">
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
            <div class="flex items-center justify-start">
              <InputNumber
                v-model="newVehicle.price"
                inputId="currency-us"
                mode="currency"
                currency="USD"
                locale="en-US"
              />
              <span class="text-xs text-gray-400 mx-2">Precio por dia</span>
            </div>
          </div>
          <div class="mb-4">
            <h2 class="text-lg font-bold mb-4">Seleccionar característica</h2>
            <div class="flex space-x-4">
              <!-- Select Equipaje -->
              <Select
                v-model="newVehicle.luggage"
                :options="Equipaje"
                name="luggage"
                optionLabel="name"
                placeholder="Equipajes"
                class="text-xs w-25"
              />

              <!-- Select Capacidad -->
              <Select
                v-model="newVehicle.people"
                :options="Capacidad"
                name="people"
                optionLabel="name"
                placeholder="capacidad"
                class="text-xs w-25"
              />

              <!-- Select Tipo de vehicle -->
              <Select
                v-model="newVehicle.type_of_car"
                :options="Tipo"
                optionLabel="name"
                placeholder="Tipo"
                class="text-xs w-25"
              />

              <!-- Select Tipo de transmision -->
              <Select
                v-model="newVehicle.transmision"
                :options="Transmision"
                optionLabel="name"
                placeholder="Transmision"
                class="text-xs w-25"
              />
            </div>
          </div>
          <div class="mb-4">
            <h3 class="text-lg font-bold mb-4">
              características adicionales
            </h3>
            <div class="flex space-x-3">
              <template v-if="features && features.length > 0">
                <Tag
                  v-for="(feature, index) in features"
                  :key="index"
                  class="text-xs"
                >
                  {{ feature.name }}
                </Tag>
              </template>
              <template v-else>
                <p class="text-xs text-gray-500">
                  No se han creado características para este vehículo.
                </p>
              </template>
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
      <Toast ref="toast" position="bottom-right" group="br" />

      <Dialog header="Confirmación" v-model:visible="showError" modal >
        <div class="flex justify-around">
          <p>Error al crear </p>
        </div>
        <button @click="closeDialog">Cerrar</button>
      </Dialog>
    </div>
  </div>
</template>

<script>
const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

import AutoComplete from "primevue/autocomplete";


import InputNumber from 'primevue/inputnumber';

import Select from "primevue/select";
import Tooltip from "primevue/tooltip";

import Tag from "primevue/tag";

import Dialog from "primevue/dialog";

import Axios from "../axios";
import Toast from "primevue/toast";
export default {
  components: {
    AutoComplete,
    Dialog,
    Select,
    InputNumber,
    Toast,
    Tooltip,
    Tag,
  },
  name: "FormVehicles",
  data() {
    return {
      showError: false,
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
      editorOptions: {
        theme: "bubble",
        modules: {
          toolbar: [
            // Aquí puedes incluir la configuración de la barra de herramientas si es necesario
            ["bold", "italic", "underline"],
            [{ list: "ordered" }, { list: "bullet" }],
            ["clean"], // Botón para limpiar el formato
          ],
        },
        placeholder: "Descripción del vehículo", // Establece el placeholder aquí
      },
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
        console.log("features", this.features);

      } catch (error) {
        console.error("Error al obtener características:", error);
      } finally {
        this.loading = false; // Cambia el estado de carga a falso
      }
    },
    // Método para filtrar vehículos según el texto ingresado
    searchItems(event) {
      const query = event.query.toLowerCase();
      this.filteredItems = this.items.filter((item) => {
        return item.name.toLowerCase().includes(query);
      });
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
        this.showDialog = true;
        this.$refs.toast.add({
            severity: "success",
            summary: "Éxito",
            detail: "Vehiculo creado con exito",
            life: 3000,
          });

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
          this.$refs.toast.add({
            severity: "success",
            summary: "Éxito",
            detail: "Vehiculo creado con exito",
            life: 3000,
          });
          // Aquí puedes manejar los errores y mostrarlos en tu UI
        } else {
          console.error("Error inesperado:", error);
        }
      }
    },
    closeDialog() {
      this.showDialog = false;
    },

    prev() {
      this.$router.push("/layout-designer/add-vehicles");
    },
  },
};
</script>

<style scoped lang="scss"></style>
