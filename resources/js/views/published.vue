<template>
    <div>
      <header class="w-full flex justify-center bg-white">
        <img src="../static/asset/Logo.webp" alt="Logo Nelly" loading="lazy" />
      </header>
      <section class="flex justify-center items-center flex-col">
        <img :src="landing?.logo" :alt="landing?.name" loading="lazy" />
        <h1 class="font-bold text-2xl mt-4">Publicado exitosamente</h1>
        <input type="text" :value="landing?.name" readonly class="mt-2 p-2 border border-gray-300 rounded" />
      </section>
    </div>
  </template>
  
  <script>
  import Axios from "../axios";
  
  export default {
    data() {
      return {
        landing: null,
      };
    },
    created() {
      this.CargaData();
    },
    methods: {
      CargaData() {
        let userId = localStorage.getItem("NellyUserId");
        if (userId) {
          Axios.get(`/api/landing/${userId}`)
            .then((response) => {
              this.landing = response.data.landing; // Asegúrate de que `landing` esté en la estructura correcta
            })
            .catch((error) => {
              console.error("Error fetching landing data:", error);
            });
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Agrega aquí estilos específicos si es necesario */
  </style>
  