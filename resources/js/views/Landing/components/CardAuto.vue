<template>
  <div class="card-auto" :style="{ borderColor: colorPrimary }">
    <img
      :src="url + '/' + vehicle.images[0].path_images"
      :alt="vehicle.name"
      loading="lazy"
      :title="vehicle.name"
      class="vehicle-image"
    />
    <div class="card-header" :style="{ backgroundColor: colorPrimary }">
      <h3 class="vehicle-name">{{ vehicle.name }}</h3>
      <p class="vehicle-type">{{ vehicle.type }}</p>
    </div>
    <div class="flex justify-between w-full items-center">
      
      <div class="py-3 px-2">
        <i
          v-for="(star, index) in 5"
          :key="index"
          :class="getStarClass(index)"
          class="fa"
          :style="{ color: colorPrimary }"
          title="Rating"
        ></i>
      </div>
      <div class="text-xs py-3 px-2">
        <span class="font-bold mx-1" :style="{ color: colorPrimary }">
          {{ $t("price_per_day") }}
        </span>

        $ {{ vehicle.price }}
      </div>
    </div>
    <div class="py-3 px-2">
      <p class="text-xs text-justify">{{ vehicle.description }}</p>
    </div>
    <div class="py-3 px-2">
      <h2 class="text-left font-bold text-sm" :style="{ color: colorPrimary }">
        {{ $t("special_features") }}
      </h2>

      <div class="flex space-x-5 my-3">
        <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs">{{
          vehicle.transmision
        }}</span>
        <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs">{{
          vehicle.type_of_car
        }}</span>
        <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs"
          >{{ $t('people')}} {{ vehicle.people }}</span
        >
        <span class="px-3 py-1 bg-gray-200 rounded-lg text-xs"
          >{{ $t('suitcase') }} {{ vehicle.people }}</span
        >
      </div>
      <div class="flex space-x-2 my-3">
        <span
          v-for="(item, index) in feature"
          :key="index"
          class="px-3 py-1 bg-gray-200 rounded-lg text-xs"
        >
          {{ item.name }}
        </span>
      </div>
    </div>

    <!-- Indicación visual de que el filtro está activo -->
    <div v-if="isFiltered" class="filter-active">
      Este vehículo cumple con el filtro
    </div>

    <a
  :href="`vehicles/${vehicle.id}`"
  class="btn-select"
  :style="{ backgroundColor: colorPrimary }"
  :class="{ 'hover-effect': true }"
>
  {{ $t('select') }}
</a>

  </div>
</template>

<script>
import axios from "axios";
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
  },
  data() {
    return {
      feature: [],
      randomRating: 0,
      url: import.meta.env.VITE_API_DATA,

      api: import.meta.env.VITE_API_URL,
    };
  },
  created() {
    // Generar un valor aleatorio de calificación al crear el componente
    this.randomRating = this.getRandomRating();
    this.getFeatures();
  },
  mounted() {
    // console.log(this.vehicle);
    document.documentElement.style.setProperty(
      "--secondary-color",
      this.colorSecondary
    );
  },

  methods: {
    getFeatures() {
      // Obtiene las características del vehículo
      axios
        .get(`${this.api}/special-features-public`)
        .then((response) => {
          this.feature = response.data;
          console.log(this.feature);
        })
        .catch((error) => {
          console.error(error);
        });
    },
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
  display: flex;
  flex-direction: column;
  border-radius: 8px;
  overflow: hidden;
  width: 400px;
  margin: 0 10px 0 10px;
  height: 600px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
  padding: 5px;
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
  height: 300px;
  aspect-ratio: 16/9;
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
  cursor: pointer;
  font-weight: 700;
  transition: background-color 0.3s;
}

.btn-select:hover {
  background-color: darken(var(--primary-color), 10%);
}
</style>
