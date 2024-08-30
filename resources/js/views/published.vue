<template>
  <div class="w-full h-screen flex flex-col items-center justify-start bg-white">
    <header class="w-full flex justify-center mb-35  bg-white py-4">
      <img src="../static/asset/Logo.webp" alt="Logo Nelly" loading="lazy" title="nelly app" class="w-44 h-auto">
    </header>

    <section class="h-screen flex justify-center items-center flex-col mx-0 ">
      <img :src="landing.logo" :alt="landing.name" class="h-9 w-9" loading="lazy" />
      <h1 class="font-bold text-2xl mt-4">¡Publicado exitosamente!</h1>
      <p class="text-gray-500 mt-2">Se ha creado un endpoint para {{ landing.name }}</p>

      <div class="mt-4 flex items-center">
        <input
          type="text"
          :value="landing.name"
          readonly
          class=" p-2 border border-gray-300 rounded w-64"
        />
        <button
          @click="copiarAlPortapapeles(landing.name)"
          class=" px-3 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
          📋
        </button>
      </div>

      <button
        @click="volverAlDashboard"
        class="mt-8 px-5 py-2 text-white bg-[#F57200] rounded hover:bg-[#e56300] transition-colors"
      >
        Volver al dashboard
      </button>
    </section>
  </div>
</template>

  
<script>
import Axios from "../axios";

export default {
  data() {
    return {
      landing: [],
    };
  },
  mounted() {
    this.CargaData();
  },
  methods: {
    CargaData() {
      let userId = localStorage.getItem('NellyUserId');
      let landingId = localStorage.getItem('NellyLandingCreate');
      console.log(`${userId}and${landingId}`);
      
        Axios.get(`/api/landings/${userId}/${landingId}`)
          .then((response) => {
            this.landing = response.data;
          })
          .catch((error) => {
            console.error("Error fetching landing data:", error);
          });
    
    },
    copiarAlPortapapeles(text) {
      navigator.clipboard.writeText(text).then(() => {
        alert("Texto copiado al portapapeles");
      }).catch((err) => {
        console.error("Error copiando al portapapeles: ", err);
      });
    },
    volverAlDashboard() {
      this.$router.push("/landings");
    },
  },
};
</script>

  
  <style scoped>
  /* Estilpos  */
  </style>
  