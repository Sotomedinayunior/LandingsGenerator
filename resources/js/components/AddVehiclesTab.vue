<template>
    <div>
      <!-- Estado Inicial -->
      <div v-if="!isAdding">
        <h2>Vehículos ({{ vehicles.length }})</h2>
        
        <!-- Tabla de Vehículos (se muestra solo si hay vehículos) -->
        <div v-if="vehicles.length > 0">
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio por día</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(vehicle, index) in vehicles" :key="index">
                <td>{{ vehicle.name }}</td>
                <td>{{ vehicle.description }}</td>
                <td>{{ vehicle.price }}</td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <!-- Botón para agregar un nuevo vehículo -->
        <button @click="toggleAddVehicle">+ Agregar Vehículo</button>
  
        <!-- Botón Continuar (se muestra solo si hay vehículos agregados) -->
        <button v-if="vehicles.length > 0" @click="continueToReview" class="mt-4 px-4 py-2 bg-orange-500 text-white rounded">
          Continuar
        </button>
      </div>
  
      <!-- Estado de Agregar Vehículo -->
      <div v-else>
        <h2>Agregar Nuevo Vehículo</h2>
        <form @submit.prevent="addVehicle">
          <!-- Campos del formulario -->
          <input v-model="newVehicle.name" placeholder="Nombre del vehículo" required />
          <textarea v-model="newVehicle.description" placeholder="Descripción" required></textarea>
          <input v-model="newVehicle.price" placeholder="Precio por día" type="number" required />
          
          <!-- Botones de acción -->
          <button type="submit">Agregar</button>
          <button type="button" @click="cancelAddVehicle">Cancelar</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isAdding: false,  // Controla si estamos en el estado de agregar o en el estado inicial
        vehicles: [],     // Lista de vehículos agregados
        newVehicle: {     // Datos del nuevo vehículo
          name: '',
          description: '',
          price: 0
        }
      };
    },
    methods: {
      toggleAddVehicle() {
        this.isAdding = true;
      },
      addVehicle() {
        this.vehicles.push({ ...this.newVehicle });
        this.resetForm();
        this.isAdding = false;
      },
      cancelAddVehicle() {
        this.resetForm();
        this.isAdding = false;
      },
      resetForm() {
        this.newVehicle = {
          name: '',
          description: '',
          price: 0
        };
      },
      continueToReview() {
        this.$emit('next');  // Emite el evento para avanzar al siguiente tab (Review)
      }
    }
  };
  </script>
  