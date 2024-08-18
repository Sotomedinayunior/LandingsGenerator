<template>
    <div
      class="max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-4">
          <img
            class="w-10 h-10 rounded"
            :src="landing.logo"
            :alt="landing.name"
            loading="lazy"
          />
          <h2 class="text-lg font-semibold dark:text-white">{{ landing.name }}</h2>
        </div>
      </div>
      <div class="flex justify-between">
        <button
          class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
          @click="restoreLanding"
        >
          Restaurar
        </button>
        <button
          class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-600"
          @click="deleteLanding"
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
    methods: {
      restoreLanding() {
        this.$emit("restore", this.landing.id);
      },
      deleteLanding() {
        this.$emit("delete", this.landing.id);
      },
    },
  };
  </script>
   