<template>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-md">
      <h2 class="text-2xl font-semibold mb-6">Configuración del Usuario</h2>
      <form @submit.prevent="updateUser">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
          <input type="text" v-model="user.name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
        </div>
  
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
          <input type="email" v-model="user.email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
        </div>
  
        <div class="mb-4">
          <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
          <input type="text" v-model="user.phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
        </div>
  
        <div class="mb-4">
          <label for="theme" class="block text-sm font-medium text-gray-700">Tema</label>
          <input type="text" v-model="user.theme" id="theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
        </div>
  
        <div class="mb-4">
          <label for="avatar" class="block text-sm font-medium text-gray-700">Avatar</label>
          <input type="file" @change="onFileChange" id="avatar" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
          <img v-if="user.avatar" :src="user.avatar" alt="Avatar" class="mt-4 h-20 w-20 rounded-full object-cover">
        </div>
  
        <div class="flex justify-end">
          <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Actualizar
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import { mapActions, mapGetters } from 'vuex';
  
  export default {
    name: 'UserConfig',
    data() {
      return {
        user: {
          name: '',
          email: '',
          phone: '',
          theme: '',
          avatar: '',
        },
      };
    },
    computed: {
      ...mapGetters(['getUser']),
    },
    methods: {
      ...mapActions(['updateUserData']),
      onFileChange(e) {
        const file = e.target.files[0];
        if (file) {
          this.user.avatar = URL.createObjectURL(file);
          this.user.avatarFile = file; // Guarda el archivo real para el envío
        }
      },
      updateUser() {
        const formData = new FormData();
        formData.append('name', this.user.name);
        formData.append('email', this.user.email);
        formData.append('phone', this.user.phone);
        formData.append('theme', this.user.theme);
        if (this.user.avatarFile) {
          formData.append('avatar', this.user.avatarFile);
        }
  
        this.updateUserData(formData)
          .then(() => {
            alert('Información actualizada con éxito');
          })
          .catch((error) => {
            console.error('Error al actualizar la información:', error);
          });
      },
    },
    created() {
      if (this.getUser) {
        this.user = { ...this.getUser };
      }
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos personalizados aquí */
  </style>
  