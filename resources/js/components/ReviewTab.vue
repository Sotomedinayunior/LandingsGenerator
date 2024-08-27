<template>
  <section class="w-[400px]">
    <div class="flex justify-between">
      <h2>Review</h2>
      <button
        @click="Publicar"
        class="px-4 py-2 text-sm text-[#F57200] border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
      >
        Publicar
      </button>
    </div>
  </section>
</template>

<script>
import Axios from "../axios";

export default {
  methods: {
    Publicar() {
      let userId = localStorage.getItem('NellyUserId');
      let landingId = localStorage.getItem('NellyLandinCreate');

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
      .then((response) => {
        console.log("Status updated successfully");
      })
      .catch((error) => {
        console.error("Error updating status:", error);
      });
    },
  },
};
</script>

<style scoped>
/* Agrega estilos si es necesario */
</style>
