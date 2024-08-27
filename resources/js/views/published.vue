<template>
  <div class="w-full h-screen flex flex-col items-center justify-center bg-white">
    <header class="w-full flex justify-center bg-white py-4">
      <img src="../static/asset/Logo.webp" alt="Logo Nelly" loading="lazy" title="nelly app" class="w-50 h-20">
    </header>

    <section class="flex justify-center items-center flex-col mt-10">
      <img :src="landing.logo" :alt="landing.name" class="h-18 w-auto" loading="lazy" />
      <h1 class="font-bold text-2xl mt-4">¡Publicado exitosamente!</h1>
      <p class="text-gray-500 mt-2">Se ha creado un endpoint para {{ landing.name }}</p>

      <div class="mt-4 flex items-center">
        <input
          type="text"
          :value="landing.endpoint"
          readonly
          class=" p-2 border border-gray-300 rounded w-64"
        />
        <button
          @click="copiarAlPortapapeles(landing.endpoint)"
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
      landing: {},
    };
  },
  created() {
    this.CargaData();
  },
  methods: {
    CargaData() {
      let userId = this.$route.params.userid;
      let landingId = this.$route.params.landingid;
      if (userId && landingId) {
        Axios.get(`/api/landing/${userId}/${landingId}`)
          .then((response) => {
            this.landing = response.data.landing;
          })
          .catch((error) => {
            console.error("Error fetching landing data:", error);
          });
      }
    },
    copiarAlPortapapeles(text) {
      navigator.clipboard.writeText(text).then(() => {
        alert("Texto copiado al portapapeles");
      }).catch((err) => {
        console.error("Error copiando al portapapeles: ", err);
      });
    },
    volverAlDashboard() {
      this.$router.push("/dashboard"); // Asegúrate de que esta ruta exista en tu aplicación
    },
  },
};
</script>

  
  <style scoped>
  /* Agrega aquí estilos específicos si es necesario */
  </style>
  