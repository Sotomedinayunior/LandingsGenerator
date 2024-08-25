<template>
  <div>
    <div v-if="loading">Cargando...</div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Precio por día</th>
            <th>Tipo de Carro</th>
            <th>Equipaje</th>
            <th>Personas</th>
            <th>Transmisión</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="vehiculo in vehicles" :key="vehiculo.id">
            <td>{{ vehiculo.name }}</td>
            <td>{{ vehiculo.price }}</td>
            <td>{{ vehiculo.type_of_car }}</td>
            <td>{{ vehiculo.luggage }}</td>
            <td>{{ vehiculo.people }}</td>
            <td>{{ vehiculo.manual }}</td>
            <td class="actions-cell">
              <i class="fa-solid fa-pencil"></i>
              <i class="fa-solid fa-trash"></i>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="error" class="error">Error al cargar los datos</div>
    </div>
  </div>
</template>

<script>
import Axios from "../axios"; // Asegúrate de que la importación sea correcta

export default {
  data() {
    return {
      vehicles: [],
      loading: true,
      error: false,
    };
  },
  mounted() {
    this.Obtener(); // Llama al método para obtener los datos cuando se monta el componente
  },
  methods: {
    Obtener() {
      const landingId = this.$route.params.id; // Obtiene el landingId de los parámetros de la URL
      console.log(landingId);
      Axios.get(`/api/vehicles/${landingId}`)
        .then((response) => {
          console.log(response.data);
          this.vehicles = response.data.vehicles;
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
          this.error = true;
          this.loading = false;
        });
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
  background-color: #fdf0e9;
  color: #222;
  font-size: 14px;
  border-bottom: 2px solid #fc8b46;
}

.table th,
.table td {
  padding: 10px;
  text-align: left;
  font-size: 13px;
  border-bottom: 1px solid #ddd;
}

.table th {
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Alineación del contenido de las celdas */
.table td {
  vertical-align: middle;
}

.actions-cell {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* Estilo de los íconos en acciones */
.actions-cell i {
  cursor: pointer;
  transition: opacity 0.2s ease;
}

.actions-cell i:hover {
  opacity: 0.7;
}

.error {
  color: red;
  font-size: 14px;
}
</style>
