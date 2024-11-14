<template>
  <div class="w-full h-screen flex flex-col items-center justify-start bg-white">
    <header class="w-full flex justify-center mb-35 bg-white py-4">
      <img src="../static/asset/Logo.webp" alt="Logo Nelly" loading="lazy" title="nelly app" class="w-44 h-auto">
    </header>

    <section class="h-screen flex justify-center items-center flex-col mx-0">
      <img :src="landing.logo" :alt="landing.name" class="h-9 w-9" loading="lazy" />
      <h1 class="font-bold text-2xl mt-4">¡Publicado exitosamente!</h1>
      <p class="text-gray-500 mt-2">Se ha creado un endpoint para   <a :href="`https://generator.nellyrac.do/${landing.name}`">
      {{ landing.name }}
    </a></p>

      <div class="mt-4 flex items-center">
        <input
          type="text"
          :value="`http://localhost:8000/${landing.name}`"
          readonly
          class="p-2 border border-gray-300 rounded w-64"
        />
        <Button
          @click="copiarAlPortapapeles(`http://localhost:8000/${landing.name}`)"
          class="px-3 py-2 bg-gray-200 border rounded hover:bg-gray-300"
        >
          📋
        </Button>
      </div>

      <button
        @click="volverAlDashboard"
        class="mt-8 px-5 py-2 text-white bg-[#F57200] rounded hover:bg-[#e56300] transition-colors"
      >
        Volver al dashboard
      </button>
    </section>

    <!-- Componente Toast para mostrar la notificación -->
    <Toast ref="toast" />
  </div>
</template>

<script>
// import Button from 'primevue/button';
// import Toast from 'primevue/toast'; // Importar el componente Toast
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
      let landingId = localStorage.getItem('NellyLandingP');
      Axios.get(`/landings/${userId}/${landingId}`)
        .then((response) => {
          this.landing = response.data;
        })
        .catch((error) => {
          console.error("Error fetching landing data:", error);
        });
    },
    copiarAlPortapapeles(text) {
      navigator.clipboard.writeText(text).then(() => {
        this.$refs.toast.add({
          severity: 'success',
          summary: 'Copiado',
          detail: 'El texto ha sido copiado al portapapeles',
          life: 3000, // Duración de la notificación (3 segundos)
        });
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

</style>
