<template>
  <div class="p-4 max-w-sm bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <!-- Imagen del vehículo -->
    <img
      :src="imageSrc"
      :alt="vehicle.name"
      :title="vehicle.name"
      class="w-full h-48 object-cover object-center rounded-t-lg"
    />

    <!-- Información del vehículo -->
    <div class="p-4">
      <!-- Nombre del vehículo -->
      <h3 class="text-lg font-semibold text-gray-900">{{ vehicle.name }}</h3>

      <!-- Descripción corta -->
      <p class="text-gray-600 mt-2">
        {{
          vehicle.description.length > 100
            ? vehicle.description.slice(0, 100) + "..."
            : vehicle.description
        }}
      </p>

      <!-- Precio del vehículo -->
      <div class="mt-4 flex justify-between items-center">
        <span :style="{ color: primaryColor }" class="text-xl font-bold">${{ vehicle.price }}</span>
        <button
          :style="{ backgroundColor: hover ? secondaryColor : primaryColor }"
          class="px-3 py-2 text-white text-xs font-bold uppercase rounded transition-colors duration-200"
          @mouseover="hover = true"
          @mouseleave="hover = false"
          @click="showFullImage = true" 
        >
          Ver Imagen
        </button>
         <!-- Tooltip -->
         <div 
            v-if="showTooltip" 
            class="absolute bg-gray-800 text-white text-xs rounded py-2 px-4 mt-1 left-1/2 transform -translate-x-1/2"
            @click="showTooltip = false"
          >
            {{ vehicle.description }} <!-- Muestra la descripción completa -->
          </div>
      </div>
    </div>
  </div>
   <!-- Modal para imagen completa -->
   <div v-if="showFullImage" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
      <div class="relative">
        <button 
          class="absolute top-4 right-4 text-white text-lg font-bold"
          @click="showFullImage = false" 
        >
          &times; 
        </button>
        <img :src="imageSrc" alt="Imagen del vehículo" class="max-w-full max-h-full object-contain" />
      </div>
    </div>

</template>

<script>
export default {
  name: "CardVehicle",
  props: {
    vehicle: {
      type: Object,
      required: true,
    },
    primaryColor: {
      type: String,
      required: true,
    },
    secondaryColor: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      hover: false, // Estado para controlar el hover
      showFullImage: false, // Estado para mostrar la imagen completa
      showTooltip: false, // Estado para mostrar el tooltip
      
    };
  },
  computed: {
    imageSrc() {
      const baseUrl = import.meta.env.VUE_APP_API_URL 
        ? "https://generator.nellyrac.do/storage";

      const imagePath =
        this.vehicle.images.length > 0
          ? this.vehicle.images[0].path_images
          : "path/to/default/image.jpg";

      const fullUrl = `${baseUrl}/${imagePath}`;

      console.log("Imagen URL: ", fullUrl); // Imprimir la URL de la imagen

      return fullUrl;
    },
  },
};
</script>

<style scoped>

</style>
