<template>
  <section class="lg:ml-64 p-4">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-semibold text-xl sm:text-sm md:text-2xl lg:text-4xl xl:text-5xl">
        Tus Landings
      </h1>
      <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-4 sm:mt-0">
        <!-- Campo de búsqueda -->
        <div class="relative">
          <input
            type="text"
            placeholder="Buscar un landing"
            v-model="searchTerm"
            @input="filterLandings"
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
        <ButtonDefault @click="addLanding" />
      </div>
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <CardLanding
        v-for="landing in filteredLandings"
        :key="landing.id"
        :landing="landing"
        @delete="deleteLanding"
      />
    </div>
  </section>
</template>

<script>
import Axios from "../axios";
import ButtonDefault from "../components/ButtonDefault.vue";
import CardLanding from "../components/CardLanding.vue";

export default {
  components: { ButtonDefault, CardLanding },
  data() {
    return {
      landings: [],
      searchTerm: '',
      filteredLandings: []
    };
  },
  mounted() {
    this.fetchLandings();
  },
 
  methods: {
    async fetchLandings() {
      try {
        const userId = localStorage.getItem('NellyUserId');
        const response = await Axios.get(`/api/landings/${userId}`, {
          headers: {
            'Accept': 'application/json'
          }
        });
        this.landings = response.data || [];
        console.log(this.landings); // Verifica si los datos se reciben correctamente
      } catch (error) {
        console.error("Error fetching landings:", error.response ? error.response.data : error.message);
      }
   
  }
}
};
</script>

<style scoped>
/* Estilos adicionales específicos si son necesarios */
</style>
