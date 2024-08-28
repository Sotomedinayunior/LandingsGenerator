<template>
  <section class="lg:ml-64 p-4">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 px-4">
      <h1 class="font-bold text-3xl">
        Localizaciones
      </h1>
    </div>
    
    <div class="flex flex-col items-center">
      <select v-model="selectedLanding" class="mb-4 p-2 border border-gray-300 rounded">
        <option disabled value="">Selecciona una landing para tus localizaciones</option>
        <option v-for="landing in landings" :key="landing.id" :value="landing">
          {{ landing.name }}
        </option>
      </select>

      <div v-if="selectedLanding" class="flex flex-col items-center">
        <img :src="selectedLanding.logo" alt="Landing Image" class="w-70 h-70 object-cover" />
        <form>
          
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import Axios from '../axios';

export default {
  data() {
    return {
      landings: [],
      selectedLanding: '' // Inicializa con cadena vacía para que el placeholder sea visible
    };
  },
  created() {
    this.getLandingsData();
  },
  methods: {
    getLandingsData() {
      let userId = localStorage.getItem('NellyUserId');
      Axios.get(`/api/landing/${userId}`)
        .then(response => {
          this.landings = response.data;
        })
        .catch(error => {
          console.error("Error al obtener landings:", error);
        });
    }
  }
}
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
