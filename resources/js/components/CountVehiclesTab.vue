<template>
  <div>
    <div class="flex justify-between items-center p-4">
      <div class="flex space-x-2">
        <!-- Botón "Mas costoso" con dropdown -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            class="inline-flex justify-center w-full rounded-full border border-gray-300 px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300"
            id="cost-button"
            aria-expanded="true"
            aria-haspopup="true"
          >
            Más costoso
            <svg
              class="ml-2 -mr-1 h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>

        <!-- Botón "Tipo de Carro" con dropdown -->
        <div class="relative inline-block text-left">
          <button
            type="button"
            class="inline-flex justify-center w-full rounded-full border border-gray-300 px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300"
            id="car-button"
            aria-expanded="true"
            aria-haspopup="true"
          >
            Tipo de Carro
            <svg
              class="ml-2 -mr-1 h-5 w-5"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>
      </div>

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
