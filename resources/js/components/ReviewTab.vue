<template>
  <section class="w-full" v-if="landing && landing.name">
    <div class="flex justify-around">
      <div class="flex flex-col">
        <h2 class="font-bold text-gray-500 text-2xl">Review</h2>
        <p class="text-sm text-gray-400">
          Aquí puede echar un vistazo a su nuevo sitio:
          <span class="font-bold">{{ landing.name }}</span>
        </p>
      </div>

      <button
        @click="publicar"
        class="px-7 py-2 text-sm text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
      >
        Publicar
      </button>
    </div>

    <section class="w-full h-full bg-gray-200 mt-5 flex justify-center">
      <div class="max-w-4xl bg-white p-2">
        <!-- Aquí puede mostrar contenido adicional del sitio -->
        <img src="../static/asset/under-construcion.webp" alt="undercontruction" loading="lazy">
      </div>
    </section>
  </section>
</template>

<script>
import Axios from "../axios";

export default {
  data() {
    return {
      landing: [], // Se inicializa en null para evitar posibles conflictos
    };
  },
  mounted() {
    this.obtener();
  },
  methods: {
    async publicar() {
      let userId = localStorage.getItem("NellyUserId");
      let landingId = localStorage.getItem("NellyLandingCreate");

      if (userId && landingId) {
        try {
          await Axios.patch(
            "/api/landing/status",
            {
              landing_id: landingId,
              user_id: userId,
            },
            {
              headers: {
                "Content-Type": "application/json",
              },
            }
          );
          this.$router.push("/published");
        } catch (error) {
          console.error("Error al actualizar el estado:", error);
        }
      } else {
        alert("Falta el ID de usuario o de landing");
      }
    },
    async obtener() {
      let userId = localStorage.getItem("NellyUserId");
      let landingId = localStorage.getItem("NellyLandingCreate");

      if (userId && landingId) {
        try {
          const response = await Axios.get(`/api/landings/${userId}/${landingId}`);
          console.log("Datos obtenidos:", response.data);
          this.landing = response.data;
        } catch (err) {
          console.error(`Error al obtener los datos: ${err}`);
        }
      } else {
        alert("Falta el ID de usuario o de landing");
        console.log(`${userId}`);
        console.log(`${landingId}`);
      }
    },
  },
};
</script>
