<template>
  <header
    class="fixed top-0 left-0 w-full z-50 flex justify-around items-center p-3 bg-white shadow-md"
  >
  
    <!-- Logo -->
    <div class="flex">
      <img
        :src="logo"
        :alt="name"
        :title="name"
        loading="lazy"
        width="230"
        height="200"
        class="w-auto h-20  cursor-pointer mr-7 object-cover aspect-auto"
        @click="goToHome"

      />
    </div>

    <!-- Menú de navegación (oculto en pantallas pequeñas) -->
    <nav
      :class="isMenuOpen ? 'block' : 'hidden'"
      class="absolute top-full left-0 w-full ml-16 bg-white md:relative md:block md:w-auto md:bg-transparent"
    >
      <ul
        class="flex flex-col items-center md:flex-row md:space-x-4 font-bold text-xs"
      >
        <li>
          <a
            href="#"
            class="p-2 hover:underline transition duration-600 ease-in-out"
            >{{ $t("overview") }}</a
          >
        </li>
        <li>
          <a
            href="#vehicle"
            class="p-2 hover:underline transition duration-600 ease-in-out"
            >{{ $t("vehicle") }}</a
          >
        </li>
        <li>
          <a
            href="#about"
            class="p-2 hover:underline transition duration-600 ease-in-out"
            >{{ $t("about_us") }}</a
          >
        </li>
        
      </ul>
    </nav>
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
