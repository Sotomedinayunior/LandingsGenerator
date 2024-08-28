<template>
  <section class="w-full">
    <div class="flex justify-around">
      <div class="flex flex-col">
        <h2 class="font-bold text-gray-500 text-2xl">Review</h2>
        <p class="text-sm text-gray-400">
          Aquí puede echar un vistazo a su nuevo sitio:
          <span class="font-bold">{{ landing.name }}</span>
        </p>
      </div>

      <button
        @click="Publicar"
        class="px-7 py-2 text-sm text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
      >
        Publicar
      </button>
    </div>

    <section class="w-full h-full bg-gray-200 mt-5 flex justify-center">
      <div class="max-w-4xl bg-white p-2">
        <!-- Aquí puede mostrar contenido adicional del sitio -->
      </div>
    </section>
  </section>
</template>

<script>
import Axios from "../axios";

export default {
  data() {
    return {
      landing: {}, // Se cambió a objeto porque es un único landing
    };
  },
  created() {
    this.obtener();
  },
  methods: {
    Publicar() {
      let userId = localStorage.getItem("NellyUserId");
      let landingId = localStorage.getItem("NellyLandinCreate");

      if (userId && landingId) {
        Axios.patch(
          "/landing/status",
          {
            landing_id: landingId,
            user_id: userId,
          },
          {
            headers: {
              "Content-Type": "application/json",
            },
          }
        )
          .then(() => {
            // Redirigir a otra página o mostrar un mensaje de éxito
            this.$router.push("/published"); // Ejemplo de redirección
          })
          .catch((error) => {
            console.error("Error updating status:", error);
          });
      } else {
        console.error("Falta el ID de usuario o de landing");
      }
    },
    obtener() {
      let userId = localStorage.getItem("NellyUserId");
      let landingId = localStorage.getItem("NellyLandinCreate");

      if (userId && landingId) {
        Axios.get(`/api/landing/${landingId}`)
          .then((response) => {
            this.landing = response.data;
          })
          .catch((err) => {
            console.error(`El error es: ${err}`);
          });
      } else {
        console.error("Falta el ID de usuario o de landing");
      }
    },
  },
};
</script>

<style scoped>
/* Agrega estilos si es necesario */
</style>
