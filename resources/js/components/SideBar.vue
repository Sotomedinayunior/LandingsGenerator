<template>
  <div>
    <!-- button  Hamburguesa -->
    <button @click="toggleSidebar" class="lg:hidden p-4 text-[#F57200]">
      <svg
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"
        ></path>
      </svg>
    </button>

    <!-- Sidebar -->
    <aside :class="sidebarClass"  class=" w-64 h-screen flex flex-col  px-6">
      <!-- Logo e Icono -->
      <div class="flex justify-between items-center py-6 px-2">
        <img
          src="../static/asset/Icon.webp"
          alt="Logo"
          class="h-8"
          loading="lazy"
        />
        <!-- El icono de la flecha doble -->
        <img
          src="../static/asset/arrow.svg"
          alt="arrow double"
          class="w-5 h-5 cursor-pointer"
          @click="toggleSidebarOnMobile"
        />
      </div>

      <!-- Links -->
      <nav class="flex-1 mt-6">
        <ul class="space-y-4">
          <li
            v-for="link in links"
            :key="link.name"
            :class="getLinkClass(link.route)"
            @click="navigate(link.route)"
            class="flex items-center px-4 py-2 cursor-pointer"
          >
            <component :is="link.icon" class="h-6 w-6 mr-2" />
            <span>{{ link.name }}</span>
          </li>
        </ul>
      </nav>

      <!-- Sección Inferior -->
      <div class="flex flex-col items-center mb-6 mt-auto">
        <div class="flex items-center space-x-2 mb-4">
          <img src="../static/asset/config.svg" alt="configuracion de usuario" loading="lazy">
          <img
            src=""
            alt="User Avatar"
            class="h-12 w-12 rounded-full border-2 border-[#F57200]"
          />
        </div>
        <button
          @click="logout"
          class="px-4 py-2 tex-sm text-[#F57200] border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
        >
          Cerrar Sesión
        </button>
      </div>
    </aside>
  </div>
</template>

<script>
import {
  NewspaperIcon,
   BookOpenIcon,
  QuestionMarkCircleIcon,
  Cog6ToothIcon,
} from "@heroicons/vue/24/outline";



export default {
 
  data() {
    return {
      isOpen: false,
      links: [
        { name: "Landings", route: "/landings", icon: NewspaperIcon },
        { name: "Reservacion", route: "/reservation", icon: BookOpenIcon },
        { name: "Ayuda", route: "/help", icon: QuestionMarkCircleIcon },
      ],
    };
  },
  computed: {
    sidebarClass() {
      return [
        "fixed top-0 left-0 w-64 h-screen bg-[#FAF8F6] lg:translate-x-0 transition-transform",
        this.isOpen ? "translate-x-0" : "-translate-x-full",
      ].join(" ");
    },
  },
  methods: {
    toggleSidebar() {
      this.isOpen = !this.isOpen;
    },
    toggleSidebarOnMobile() {
      if (window.innerWidth < 1024) {
        // Solo en pantallas móviles
        this.toggleSidebar();
      }
    },
    navigate(route) {
      this.$router.push(route);
      this.isOpen = false; // Cierra el sidebar al hacer clic en un enlace
    },
    getLinkClass(route) {
      return this.$route.path === route
        ? "text-[#F57200] font-bold border-b-2 border-[#F57200]"
        : "text-gray-600";
    },
    async logout() {
      try {
        await this.$store.dispatch('logout');

      } catch (err) {
        console.error(`Ocurrió un error al cerrar la sesión: ${err}`);
      }
    },
  },
};
</script>

<style scoped>
/* Agrega estilos específicos para el componente aquí */
</style>



