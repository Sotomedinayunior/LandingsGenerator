<template>
  <div class="max-w-sm rounded overflow-hidden shadow-lg">
    <img
      class="rounded-t-lg transform hover:scale-105 transition duration-300 cursor-pointer"
      :src="url + '/' + vehicle.images[0].path_images"
      :alt="vehicle.name"
      :title="vehicle.title"
      width="300"
      height="200"
      loading="lazy"
      @click="goToVehicle(vehicle.id)"
    />
    <div class="p-3">
      <h2
        class="text-2xl my-2 text-gray-500 font-semibold text-left truncate max-w-xs"
      >
        {{ vehicle.name }}
      </h2>
      <div class="flex justify-between items-center my-3">
        <div class="py-5">
          <i
            v-for="(star, index) in 5"
            :key="index"
            :class="getStarClass(index)"
            class="fa"
            :style="{ color: colorPrimary }"
            title="Rating"
          ></i>
        </div>
        <h2
          class="text-base font-semibold text-left"
          :style="{ color: colorPrimary }"
        >
          {{ vehicle.price }} <span class="text-sm text-gray-300"> / day</span>
        </h2>
      </div>

      <!-- Mostrar la descripción truncada -->
      <p :style="{ color: colorPrimary }">
        {{ truncateDescription(vehicle.description) }}
      </p>

      <div>
        <h2 class="text-base text-gray-400 my-5">Especial Feature</h2>
      </div>
      <div class="flex justify-between mt-2">
        <div class="flex flex-col">
          <div class="flex" :style="{ color: colorPrimary }">
            <i class="fas fa-map-marker-alt" v-if="vehicle.gps == 1"></i>
            <i class="fas fa-cogs mr-2" v-if="vehicle.transmision"></i>
            <i class="fab fa-bluetooth mr-2" v-if="vehicle.bluetooth == 1"></i>
          </div>
        </div>
        <div class="flex justify-end">
          <span
            :style="{ color: colorPrimary, backgroundColor: colorSecondary }"
            class="flex bg-slate-400 w-10 h-10 justify-center rounded-full items-center mx-2"
            ><i class="fas fa-suitcase-rolling mx-1"></i>
            {{ vehicle.luggage }}</span
          >
          <span
            :style="{ color: colorPrimary, backgroundColor: colorSecondary }"
            class="flex bg-slate-400 w-10 h-10 justify-center rounded-full items-center mx-2"
          >
            <i class="fas fa-user mx-1"></i> {{ vehicle.people }}</span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardAuto",
  props: {
    vehicle: {
      type: Object,
      required: true,
    },
    colorPrimary: {
      type: String,
      default: "#000",
    },
    colorSecondary: {
      type: String,
      default: "#000",
    },
  },
  data() {
    return {
      showModal: false, // Estado del modal
      url: "http://localhost:8000/storage",
      randomRating: 0, // Para almacenar el rating aleatorio
    };
  },
  created() {
    // Generar un valor aleatorio de calificación al crear el componente
    this.randomRating = this.getRandomRating();
  },
  methods: {
    getRandomRating() {
      // Genera un valor aleatorio entre 4, 4.5 y 5
      const ratings = [4, 4.5, 5];
      return ratings[Math.floor(Math.random() * ratings.length)];
    },
    getStarClass(index) {
      // Retorna las clases de las estrellas según la calificación
      if (index < Math.floor(this.randomRating)) {
        return "fa-star"; // Estrella llena
      } else if (index < this.randomRating) {
        return "fa-star-half-alt"; // Media estrella
      } else {
        return "fa-star text-gray-300"; // Estrella vacía o gris
      }
    },
    goToVehicle(idvehicle) {
      this.$router.push({
        name: "vehicle-pages",
        params: { idvehicle: idvehicle },
      });
    },
    truncateDescription(text) {
      // Convertir el texto en un arreglo de palabras
      const words = text.split(" ");

      // Si el texto tiene más de 15 palabras, lo trunca y agrega "..."
      if (words.length > 15) {
        return words.slice(0, 15).join(" ") + "...";
      } else {
        return text;
      }
    },
  },
};
</script>

<style scoped>
/* Agrega aquí estilos específicos si es necesario */
</style>
