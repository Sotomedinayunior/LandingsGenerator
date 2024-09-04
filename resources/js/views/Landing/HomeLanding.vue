<template>
  <div>
    <!-- Mostrar los detalles de la landing si fue encontrada -->
    <div v-if="landing">
      <header class="flex justify-around items-center p-6 bg-white">
        <div class="flex">
          <img
            :src="landing.logo"
            :alt="landing.name"
            :title="landing.name"
            class="h-20 w-20"
          />
        </div>
        <div>
          <nav>
            <ul class="flex justify-evenly font-bold text-sm">
              <li>
                <a href="#" class="p-2 hover:underline">item 1</a>
              </li>
              <li>
                <a href="#" class="p-2 hover:underline">item 2</a>
              </li>
              <li>
                <a href="#" class="p-2 hover:underline">item 3</a>
              </li>
              <li>
                <a href="#" class="p-2 hover:underline">item 4</a>
              </li>
              <li>
                <a href="#" class="p-2 hover:underline">item 5</a>
              </li>
              <li>
                <a href="#" class="p-2 hover:underline">item 6</a>
              </li>
              <li>
                <a href="#" class="p-2 hover:underline">item 7</a>
              </li>
            </ul>
          </nav>
        </div>
      </header>
    </div>

    <!-- Mostrar un mensaje si no se encuentra la landing -->
    <div v-else-if="message">
      <h2 class="text-center text-gray-950 font-semibold text-2xl">
        {{ message }}
      </h2>
    </div>
  </div>
</template>

<script>
import axios from "axios";

const url = import.meta.env.VUE_APP_API_URL || "http://localhost:8000/api"; // Usar variable de entorno
console.log(`${url}`);

export default {
  data() {
    return {
      landing: null, // Para almacenar los datos de la landing si se encuentran
      message: "", // Para almacenar el mensaje de error
    };
  },

  mounted() {
    this.getLanding();
  },

  methods: {
    getLanding() {
      const landingId = this.$route.params.landingid;
      const userId = this.$route.params.userid; 
      console.log("Landing ID:", landingId);
      console.log("User ID:", userId);

      
      axios
        .get(`${url}/publicLanding/${userId}/${landingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          console.log(response.data);
        })
        .catch((err) => {
          // si ocurre un error (como un 404), mostrar el mensaje de error
          if (err.response && err.response.status === 404) {
            this.message = "Landing no encontrada o ha sido eliminada.";
          } else {
            this.message = "Ocurrió un error al buscar la landing.";
          }
          console.error(err);
        });
    },
  },
};
</script>

<style scoped></style>
