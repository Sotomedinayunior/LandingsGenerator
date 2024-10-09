<template>
  <div>
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
          <tr v-if="reservations.length == 0">
            <td colspan="9" class="text-center">No hay reservas disponibles.</td>
          </tr>
          <tr v-for="(item, index) in reservations" :key="item.id || index">
            <td>
              <img :src="item.landing.logo || '/ruta/a/imagen/predeterminada.png'" alt="Carro" class="foto" />
            </td>
            <td>{{ item.vehicle.name }}</td>
            <td>{{ item.total_price || 'N/A' }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.last_name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.telephone }}</td>
            <td>{{ item.description }}</td>
            <td class="flex justify-between" id="actions">
              <i class="fa-solid fa-eye" @click="viewReservation(item)"></i>
              <i class="fa-solid fa-pencil" @click="editReservation(item)"></i>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="error" class="text-red-500 text-center">
        Error al cargar las reservas. Por favor intenta de nuevo.
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    reservations: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      error: false,
    };
  },
  methods: {
    viewReservation(item) {
      console.log('Ver reserva:', item);
      // Lógica para ver los detalles de la reserva
    },
    editReservation(item) {
      console.log('Editar reserva:', item);
      // Lógica para editar la reserva
    }
  }
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
  opacity: 0.5;
  cursor: pointer;
  transition: opacity 0.3s ease;
}

#actions i:hover {
  opacity: 1;
}

.text-center {
  font-size: 16px;
  color: #333;
}

.text-red-500 {
  color: red;
}
</style>
