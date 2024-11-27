<template>
 <header
  class="fixed top-0 left-0 w-full z-50 bg-white shadow-md p-3"
>
  <div class="container max-w-screen-lg mx-auto">
    <div class="flex justify-center items-center">
      <!-- Logo -->
      <div class="flex">
        <img
          :src="logo"
          :alt="name"
          :title="name"
          loading="lazy"
          width="230"
          height="200"
          class="w-auto h-20 cursor-pointer mr-7 object-cover aspect-auto"
          @click="goToHome"
        />
      </div>

      <!-- Menú de navegación (oculto en pantallas pequeñas) -->
    
    </div>
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
    name: {
      type: String,
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
      currentLanguage: "en", // default language
      isMenuOpen: false, // state to control menu visibility
    };
  },
  methods: {
    goToHome() {
      this.$router.push({ name: "home-landing" });
    },
    changeLanguage(language) {
      this.$emit("language-change", language);
    },
  },
};
</script>

<style scoped>
/* Aquí puedes agregar estilos específicos si lo necesitas */
</style>
