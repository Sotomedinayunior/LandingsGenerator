<template>
  <div>
    <div v-if="loading">Cargando...</div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th style="opacity: 0;">imagen</th>
            <th>Nombre</th>
            <th>Precio por día</th>
            <th>Tipo de Carro</th>
            <th>Equipaje</th>
            <th>Personas</th>
            <th>Transmisión</th>
            <th>Acomodaciones</th>
            <th>Comisiones</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="vehiculo in vehicles" :key="vehiculo.id">
            <td class="vehiculo-nombre">
              <img :src="`/storage/${vehiculo.images[0].path_images}`" :alt="vehiculo.name" class="vehicle-image" />
            </td>
            <td>{{ vehiculo.name }}</td>
            <td>{{ vehiculo.price }}</td>
            <td>{{ vehiculo.type_of_car }}</td>
            <td>{{ vehiculo.luggage }}</td>
            <td>{{ vehiculo.people }}</td>
            <td>{{ vehiculo.transmision }}</td>
            <td>{{ vehiculo.bluetooth }}</td>
            <td>{{ vehiculo.commissions }}</td>
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


export default {
  props: {
    vehicles: {
      type: Array, // Cambiar a Array para que acepte un array de vehículos
      required: true,
    },
  },
  data() {
    return {
      loading: true,
      error: false,
    };
  },

 

};
</script>

<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  border-radius: 8px 8px 0 0; /* Añadir borde redondeado superior */
  overflow: hidden; /* Asegurar que el borde redondeado se aplique correctamente */
}

.table thead {
  background-color: #fdf0e9;
  color: #222;
  font-size: 10px !important;
  border: 2px solid #fc8b46;
  border-radius: 8px 8px 0 0; /* Añadir borde redondeado superior */
}

.table th,
.table td {
  padding: 7px;
  text-align: left;
  border-bottom: 1.2px solid #ddd;
  vertical-align: middle;
}

.table td {
  font-size: 12px;
}

.table th {
  text-transform: capitalize;
  letter-spacing: 0.04em;
  font-weight: 300;
  font-size: 12px; /* text-xs */
}

.table td img {
  width: 40px;
  height: 40px;
  margin-right: 10px;
  border-radius: 5px;
}

.actions-cell {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

/* Ocultar íconos por defecto */
.actions-cell {
  opacity: 0;
  transition: opacity 0.3s ease;
}

/* Mostrar íconos al hacer hover en la fila */
tr:hover .actions-cell {
  opacity: 1;
}

.error {
  color: red;
  font-size: 14px;
}

.vehicle-image {
  border-radius: 5px;
  width: 40px;
  height: 40px;
}

.vehiculo-nombre {
  display: flex;
  align-items: center;
}
</style>
