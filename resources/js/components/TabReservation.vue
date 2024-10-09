<template>
  <div>
    <table class="table">
      <thead>
        <tr>
     
          <th>Foto</th>
          <th>Nombre de Carro</th>
          <th>$ Monto Total</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo Electrónico</th>
          <th>Teléfono</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in reservations" :key="item.id || index">
         
          <td>
            <img :src="item.landing.logo" alt="Carro" class="foto" />
          </td>
          <td>{{ item.vehicle.name }}</td>
          <td>{{ item.total_price || "N/A" }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.last_name }}</td>
          <td>{{ item.email }}</td>
          <td>{{ item.phone }}</td>
          <td>{{ item.description }}</td>
          <td class="flex justify-between" id="actions">
            <i class="fa-solid fa-eye" @click="viewReservation(item)"></i>
            <i class="fa-solid fa-pencil" @click="editReservation(item)"></i>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Axios from "../axios";
export default {
  components: {
    TableReservation: () => import("./TableReservation.vue"), // Lazy loading del componente
  },
  data() {
    return {
      reservations: null,
      loading: true, // Inicia en estado de carga
      error: null,
    };
  },
  mounted() {
    this.fetchReservations();
  },
  methods: {
    async fetchReservations() {
      try {
        const landingId = this.$route.params.id;
        const response = await Axios.get(`/api/reservations/${landingId}`);
        this.reservations = response.data;
        console.log("Reservas cargadas:", this.reservations);
      } catch (error) {
        this.error = "Error al cargar las reservas";
        console.error("Error al cargar las reservas:", error);
      } finally {
        this.loading = false; // Detiene el estado de carga
      }
    },
  },
};
</script>
<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.table thead {
  background-color: #FDF0E9;
  color: #222;
  font-size: 15px;
  border-bottom: 2px solid #FC8B46;
}

.table th,
.table td {
  padding: 10px;
  text-align: left;
  font-size: 13px;
  border-bottom: 1px solid #ddd;
}

.foto {
  width: 40px;
  height: auto;
  border-radius: 4px;
}

#actions i {
 
  cursor: pointer;
}


.text-center {
  font-size: 16px;
  color: #333;
}

.text-red-500 {
  color: red;
}
</style>