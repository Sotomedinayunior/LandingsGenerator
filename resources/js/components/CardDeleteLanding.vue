<template>
  <div
    class="w-full flex flex-row	 items-center justify-between	p-2 bg-white border border-gray-100 rounded-lg shadow dark:bg-gray-400 dark:border-gray-300"
  >
    <div class="flex items-center gap-2	">
      <img :src="landing.logo" :alt="landing.name" class="w-12 h-12">
      <h2 class="text-base font-bold text-orange-600">{{FullName}}</h2>
    </div>

    <!-- Botones para restaurar o eliminar -->
    <div class="flex justify-end  items-center space-x-3">
      <button
        @click="$emit('restore', landing.id)"
        class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-600"
      >
        Restaurar
      </button>
      <button
        @click="$emit('delete', landing.id)"
        class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-600"
      >
        Eliminar
      </button>
    </div>
  </div>
</template>

<script>


export default {
  name: "CardDeleteLanding",
  props: {
    landing: {
      type: Object,
      required: true,
    },
  },
  computed: {
    FullName(){
      const NameLanding = this.landing.name;
      return  NameLanding.replace("-"," ").replace("-"," ");
    },
  },
};
</script>

<style scoped>
</style>
