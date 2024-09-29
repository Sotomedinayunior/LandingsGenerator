<template>
  <div>
    <div class="flex justify-around items-center">
      <div class="flex items-center">
        <i class="fa fa-car mr-2"></i>
        <h2 class="text-2xl font-bold">Vehículos</h2>
        <span
          class="bg-[#F57200] text-white ml-2 px-2 py-1 rounded-full text-sm"
          >{{vehicles.length }}</span
        >
      </div>
      <button
        @click="addVehicle"
        class="px-4 py-2 text-sm text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
      >
        + Agregar Vehículo
      </button>
    </div>
    <p class="text-gray-500 mt-2 ml-60">
      Agregar los vehículos para esta landing
    </p>
  </div>
</template>

<script>
export default {
  name: "CountVehicles",
  props:{
    vehicles: {
      type:Array,
      required: true,
    },


  },
  methods:{
    addVehicle(){
      console.log(this.vehicles)
      return this.$router.push("/layout-designer/add-vehicles/add-form");
    }
  }
};
</script>

<style scoped>
/* Add your styles here */
</style>
