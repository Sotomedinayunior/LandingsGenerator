<template>
  <header
    class="flex justify-between p-3 items-center border-b border-gray-200 bg-white shadow-md"
  >
    <!-- Logo -->
    <div class="container max-w-[1150px] mx-auto">
      <img
        :src="logo"
        :alt="logoTitle"
        :title="logoTitle"
        width="230"
        height="200"
        class="w-auto h-20 cursor-pointer mr-7 object-cover aspect-auto"
        @click="goToHome"
      />
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
      default: "#ffffff",
    },
    colorSecondary: {
      type: String,
      default: "#000000",
    },
    defaultLanguage: {
      type: String,
      default: "en",
    },
  },
  data() {
    return {
      currentLanguage: this.defaultLanguage, // idioma predeterminado
    };
  },
  methods: {
    changeLanguage(language) {
      this.$emit("language-change", language); // Emite un evento cuando cambia el idioma
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
