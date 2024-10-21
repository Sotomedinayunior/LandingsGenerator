<template>
  <div>
    <div v-if="reservations.length > 0">
      <DataTable :value="reservations" tableStyle="min-width: 50rem">
        <Column field="vehicle.name" header="Nombre de Carro" sortable></Column>
        <Column field="total_price" header="$ Monto Total" sortable></Column>
        <Column field="name" header="Nombre" sortable></Column>
        <Column field="last_name" header="Apellido" sortable></Column>
        <Column field="email" header="Correo Electrónico" sortable></Column>
        <Column field="telephone" header="Teléfono" sortable></Column>
        <Column field="description" header="Descripción" sortable></Column>
        <Column header="Acciones" :body="renderActions"></Column>
      </DataTable>
    </div>
    
    <div v-else class="text-center">
      <p>No hay reservas disponibles.</p>
    </div>
    
    <div v-if="error" class="text-red-500 text-center">
      Error al cargar las reservas. Por favor intenta de nuevo.
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
    renderActions(reservation) {
      return `
        <i class="fa-solid fa-eye" @click="viewReservation(reservation)"></i>
        <i class="fa-solid fa-pencil" @click="editReservation(reservation)"></i>
      `;
    },
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
