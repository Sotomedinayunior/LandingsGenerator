<template>
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between p-3 items-center border-b border-gray-200 mb-10 bg-white shadow-md">
      <!-- Logo -->
      <img
        :src="logo"
        :alt="logoTitle"
        :title="logoTitle"
        width="230"
        height="200"
        class="w-[75px] h-auto cursor-pointer"
        @click="goToHome"

      />
      
      <!-- Selector de idioma -->
      <div class="relative inline-block text-left">
        <select
          v-model="currentLanguage"
          @change="$emit('language-change', $event.target.value)"
          :style="{
            'background-color': colorPrimary,
            color: colorSecondary,
          }"
          class="block w-full px-4 py-2 text-sm font-medium border rounded-md shadow-sm focus:outline-none focus:ring-2 transition duration-300 ease-in-out"
        >
          <option value="en">EN</option>
          <option value="es">ES</option>
        </select>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    props: {
      logo: {
        type: String,
        required: true,
      },
      logoTitle: {
        type: String,
        required: true,
      },
      colorPrimary: {
        type: String,
        default: '#ffffff',
      },
      colorSecondary: {
        type: String,
        default: '#000000',
      },
      defaultLanguage: {
        type: String,
        default: 'en',
      },
    },
    data() {
      return {
        currentLanguage: this.defaultLanguage, // idioma predeterminado
      };
    },
    methods: {
      changeLanguage(language) {
        this.$emit('language-change', language); // Emite un evento cuando cambia el idioma
      },
      goToHome() {
      this.$router.push({ name: "home-landing" });
    },
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos personalizados aquí */
  </style>
  