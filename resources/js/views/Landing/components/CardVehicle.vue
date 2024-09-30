<template>
  <div
    class="flex justify-between items-center bg-white py-4 rounded-lg  w-[220px]"
  >
    <!-- Columna izquierda: Información del vehículo -->
    <div class="flex flex-col gap-2">
      <!-- Título del vehículo -->
      <h2 class="text-[#333333] text-xl font-bold mb-3">
        {{ vehicle.name }}
      </h2>

      <!-- Características del vehículo (iconos) -->
      <div class="flex gap-4 text-gray-500">
        <!-- Capacidad de pasajeros -->
        <div class="flex items-center gap-1 p-1  bg-gray-300 rounded-lg">
          <i class="fas fa-user text-black text-xs"></i>
          <span class="text-xs">{{ vehicle.people }}</span>
        </div>
        <!-- Equipaje -->
        <div class="flex items-center gap-1 p-1  bg-gray-300 rounded-lg">
          <i class="fas fa-suitcase text-black text-xs"></i>
          <span>{{ vehicle.luggage }}</span>
        </div>
      </div>
    </div>

    <!-- Columna derecha: Precio -->
    <div class="text-right">
      <p class="text-[#333333] text-base font-bold mt-4">
        US${{ vehicle.price }}<span class="text-[#828282] text-base">/day</span>
      </p>
    </div>
  </div>

  <!-- Imagen del vehículo -->
  <img
    class="rounded-lg w-[220px] h-[160px] object-cover"
    :src="imageSrc"
    :alt="vehicle.name"
    width="330"
    height="172"
    
    
  />
</template>

<script>
export default {
  name: "CardVehicle",
  props: {
    vehicle: {
      type: Object,
      required: true,
    },
  },
  computed: {
    imageSrc() {
      return this.vehicle.images.length > 0
        ? `http://localhost:8000/storage/${this.vehicle.images[0].path_images}`
        : "path/to/default/image.jpg"; // Imagen por defecto si no hay imágenes
    },
  },
};
</script>

<style scoped>
/* Estilos para mejorar el aspecto visual */

</style>
