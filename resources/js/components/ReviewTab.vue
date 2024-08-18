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
  data() {},
  methods: {
    Publicar() {
        let  UserId = localStorage.getItem('NellyUserId');
        let  landingId = localStorage.getItem('NellyLandinCreate');

      Axios
        .patch(
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
          
        })
        .catch((error) => {
          console.error("Error updating status:", error);
        });
    },
  },
};
</script>
<style></style>
