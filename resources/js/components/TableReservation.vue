<template>
  <div>
    <div v-if="filteredItems.length === 0" class="text-center text-gray-600 py-8">
      <p>No hay reservas para esta landing.</p>
    </div>
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Foto</th>
            <th>Nombre de Carro</th>
            <th>$ Monto Total</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo Electrónico</th>
            <th>Teléfono</th>
            <th>Comentario Adicional</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in filteredItems" :key="index">
            <td>{{ index + 1 }}</td>
            <td>
              <img :src="item.foto" alt="Carro" class="foto" />
            </td>
            <td>{{ item.nombreCarro }}</td>
            <td>{{ item.montoTotal }}</td>
            <td>{{ item.nombre }}</td>
            <td>{{ item.apellido }}</td>
            <td>{{ item.correoElectronico }}</td>
            <td>{{ item.telefono }}</td>
            <td>{{ item.comentarioAdicional }}</td>
            <td class="flex justify-between" id="actions">
              <i class="fa-solid fa-eye"></i>
              <i class="fa-solid fa-pencil"></i>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import Axios from '../axios';  // Asegúrate de que Axios esté correctamente importado

export default {
  props: ['searchTerm'],
  data() {
    return {
      items: [], // Inicializa vacío para recibir los datos desde el API
    };
  },
  mounted() {
    this.fetchReservations(); // Llamar a la función para obtener las reservaciones
  },
  methods: {
    async fetchReservations() {
      try {
        const landingId = 2;  // Obtiene el landing_id de la URL
        if (landingId) {
          const response = await Axios.get(`reservations/${landingId}`);
          this.items = response.data; // Asigna los datos de la API a 'items'
        } else {
          console.error('No landingId found in the URL');
        }
      } catch (error) {
        console.error('Error fetching reservations:', error);
      }
    },
  },
  computed: {
    filteredItems() {
      // Convierte el término de búsqueda a minúsculas
      const lowerCaseSearchTerm = this.searchTerm.toLowerCase();

      // Filtra los elementos en base al nombre del carro, nombre, apellido, correo electrónico, etc.
      return this.items.filter(item => {
        return (
          item.nombreCarro.toLowerCase().includes(lowerCaseSearchTerm) ||
          item.nombre.toLowerCase().includes(lowerCaseSearchTerm) ||
          item.apellido.toLowerCase().includes(lowerCaseSearchTerm) ||
          item.correoElectronico.toLowerCase().includes(lowerCaseSearchTerm) ||
          item.telefono.toLowerCase().includes(lowerCaseSearchTerm)
        );
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
  background-color: #FDF0E9;
  color: #222;
  font-size: 15px;
  border-bottom: 2px solid #FC8B46;
}

.table th, .table td {
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
  opacity: 0;
  cursor: pointer;
}

#actions:hover i {
  opacity: 1;
}

#actions i:hover {
  opacity: 2;
}

.text-center {
  font-size: 16px;
  color: #333;
}

.text-gray-600 {
  color: #718096;
}
</style>
