<template>
  <div class="max-w-sm">
    <h2 class="capitalize font-bold">{{ vehicle.name }}</h2>

    <div class="w-full my-3 flex justify-between">
      <div class="flex gap-1">
        <div
          class="flex justify-between items-center rounded-full bg-slate-100 p-1"
        >
          <div>
            <img src="../asset/User.png" alt="usuario" width="19" height="18" />
          </div>
          <span class="text-xs px-1">{{ vehicle.people }}</span>
        </div>
        <div
          class="flex justify-between items-center rounded-full bg-slate-100 p-1"
        >
          <div>
            <img src="../asset/bag.png" alt="usuario" width="19" height="18" />
          </div>
          <span class="text-xs px-1">{{ vehicle.luggage }}</span>
        </div>
      </div>
      <div class="flex">
        <h2 class="text-xs font-bold" :style="{ color: colorPrimary }">
          US${{ vehicle.price }}
        </h2>
        <span class="text-xs text-gray-400 ml-1">/day</span>
      </div>
    </div>
    <img
      :src="url + '/' + vehicle.images[0].path_images"
      :alt="vehicle.name"
      loading="lazy"
      :title="vehicle.name"
      width="200"
      height="150"
      class="w-full h-50 object-cover cursor-pointer aspect-[20/9] rounded-lg transform transition-transform duration-300 hover:scale-105"
      @click="Redirect"
    />
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
      const vehicleId = this.vehicle.id;
      axios
        .get(`${this.api}/vehicle/${vehicleId}/special-features-public`)
        .then((response) => {
          this.feature = response.data.specialFeatures;
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
    Redirect() {
      console.log(this.vehicle.id);
      console.log("tesssst");
      this.$router.push({
        name: "vehicle-pages",
        params: { idvehicle: this.vehicle.id },
      });
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
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 5px;
  color: #fff;
}

.vehicle-name {
  font-size: 1.2em;
  text-transform: capitalize;
  font-weight: bold;
  padding: 0 0 0 4px;
}

.vehicle-type {
  font-size: 0.9em;
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
