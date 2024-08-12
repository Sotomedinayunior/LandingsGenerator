<template>
  <section class="lg:ml-64 p-">
    <div
      class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4"
    >
      <h1
        class="font-semibold text-xl sm:text-sm md:text-2xl lg:text-4xl xl:text-5xl"
      >
        Tus Landing
      </h1>
      <div
        class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0"
      >
        <!-- Campo de búsqueda -->
        <div class="relative">
          <input
            type="text"
            placeholder="Buscar un landing"
            class="p-2 pr-5 border border-gray-500 rounded-md focus:outline-none placeholder: text-sm w-full sm:w-auto"
          />
          <!-- SVG de lupa -->
          <svg
            class="absolute inset-y-2 right-1 w-6 h-6 text-gray"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 4a7 7 0 1 0 0 14 7 7 0 0 0 0-14zM21 21l-4.35-4.35"
            />
          </svg>
        </div>
        <ButtonDefault />
      </div>
    </div>
  </section>
</template>

<script>
import ButtonDefault from "../components/ButtonDefault.vue";

export default {
  components: { ButtonDefault },
  // No es necesario agregar scripts si no tienes lógica adicional aquí
};
</script>

<style scoped>
/* Estilos adicionales específicos si son necesarios */
</style>
