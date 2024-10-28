<template>
  <div class="card-auto" :style="{ borderColor: colorPrimary }">
    <div class="card-header" :style="{ backgroundColor: colorSecondary }">
      <h3 class="vehicle-name">{{ vehicle.name }}</h3>
      <p class="vehicle-type">{{ vehicle.type }}</p>
    </div>
    <img
      :src="url + '/' + vehicle.images[0].path_images"
      :alt="vehicle.name"
      class="vehicle-image"
    />
    <div class="card-details">
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
    </div>
    <div class="py-5">
      <p class="text-xs text-justify">{{ vehicle.description}}</p>


    </div>
    <div class="py-5 flex ">
      

    </div>

    <!-- Indicación visual de que el filtro está activo -->
    <div v-if="isFiltered" class="filter-active">
      Este vehículo cumple con el filtro
    </div>

    <button class="btn-select" :style="{ backgroundColor: colorPrimary }">
      Seleccionar
    </button>
  </div>
</template>

<script>
const url =
  import.meta.env.VUE_APP_API_URL ||
  (import.meta.env.PROD
    ? "https://generator.nellyrac.do/storage"
    : "http://localhost:8000//storage");

export default {
  props: {
    vehicle: {
      type: Object,
      required: true,
    },
    colorPrimary: {
      type: String,
      default: "#333",
    },
    colorSecondary: {
      type: String,
      default: "#eee",
    },
    isFiltered: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      randomRating: 0,
      url:
        import.meta.env.VUE_APP_API_URL ||
        (import.meta.env.PROD
          ? "https://generator.nellyrac.do/storage"
          : "http://localhost:8000/storage"),
    }; // Elimina el punto y coma aquí
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
  },
};
</script>

<style scoped>
.card-auto {
  border: 2px solid;
  border-radius: 8px;
  overflow: hidden;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 15px;
}

.card-header {
  padding: 10px;
  color: #fff;
}

.vehicle-name {
  font-size: 1.2em;
  font-weight: bold;
}

.vehicle-type {
  font-size: 0.9em;
}

.vehicle-image {
  width: 100%;
  height: auto;
  margin: 10px 0;
}

.card-details {
  text-align: left;
  font-size: 0.9em;
  color: #555;
}

.card-details p {
  margin: 5px 0;
}

.filter-active {
  background-color: #d1e7dd;
  color: #0f5132;
  padding: 5px;
  margin-top: 10px;
  font-size: 0.8em;
  border-radius: 4px;
}

.btn-select {
  margin-top: 10px;
  color: #fff;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-select:hover {
  background-color: darken(var(--primary-color), 10%);
}
</style>
