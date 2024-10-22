<template>
  <div>
    <div class="flex justify-end items-center p-4">
      
      

      <!-- Botón "Agregar Vehículo" -->
      <button
        type="button"
        @click="goToCreateVehicle"
        class="ml-auto px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-full hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
      >
        + Agregar Vehículo
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "CountVehicles",
  props: {
    vehicles: {
      type: Array,
      required: true,
    },
  },
  methods: {
    emitSearchQuery() {
      // Emitir el término de búsqueda hacia el componente padre
      this.$emit('search-query', this.searchQuery);
    },
    goToCreateVehicle() {
      this.$emit("redirect-to-create"); // Emitimos un evento personalizado
    },
    addVehicle() {
      console.log(this.vehicles);
      return this.$router.push("/layout-designer/add-vehicles/add-form");
    },
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
