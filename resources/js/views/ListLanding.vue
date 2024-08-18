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
            class="p-2 pr-5 border border-gray-500 rounded-md focus:outline-none placeholder:text-sm w-full sm:w-auto"
          />
          <!-- SVG de lupa -->
          <svg
            class="absolute inset-y-2 right-1 w-6 h-6 text-gray-500"
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

    <!-- Iterar sobre los landings y mostrar CardLanding para cada uno -->
     <div class="grid grid-cols-3 gap-2"> <CardLanding 
      v-for="landing in filteredLandings" 
      :key="landing.id" 
      :landing="landing" 
    /></div>
   
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
      searchTerm: "", // Término de búsqueda
      landings: [], // Array vacío para almacenar los landings
    };
  },
  created() {
    this.getLandingsData();
  },
  computed: {
    filteredLandings() {
      // Asegúrate de que 'landings' es un array antes de filtrar
      if (!Array.isArray(this.landings)) {
        console.error("landings no es un array:", this.landings);
        return [];
      }
      return this.landings.filter(landing =>
        landing.name.toLowerCase().includes(this.searchTerm.toLowerCase())
      );
    },
  },
  methods: {
    getLandingsData() {
      let userId = localStorage.getItem('NellyUserId');
      Axios.get(`/api/landing/${userId}`)
        .then(response => {
          // Asegúrate de que response.data sea un array
           console.log(response.data)
            this.landings = response.data;
         
        })
        .catch(error => {
          
        });
    },
   
  },
};
</script>

<style scoped>
/* Estilos adicionales específicos si son necesarios */
</style>
