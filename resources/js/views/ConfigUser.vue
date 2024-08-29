<template>
  <div class="max-w-3xl lg:ml-64 p-4 p-6 bg-white shadow-md rounded-md">
    <h2 class="text-2xl font-semibold mb-6 text-[#f16822]">
      Configuración del Usuario
    </h2>

    <form @submit.prevent="updateUser">
      <div class="mb-4 flex justify-center">
        <div class="relative flex items-center justify-center">
          <input
            type="file"
            @change="onFileChange"
            id="avatar"
            name="avatar"
            class="absolute inset-0 opacity-0 cursor-pointer"
          />
          <div
            class="flex items-center justify-center w-20 h-20 border-2 border-[#f16822] border-dashed rounded-full bg-gray-100"
          >
            <img
              v-if="user.avatar"
              :src="user.avatar"
              alt="Avatar"
              class="w-full h-full rounded-full object-cover"
            />
            <span v-else class="text-gray-500 text-center">Subir Imagen</span>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label
          for="name"
          class="block text-base font-bold text-orange-600 text-[#f16822]"
          >Nombre</label
        >
        <input
          type="text"
          name="name"
          v-model="user.name"
          id="name"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
      </div>

      <div class="mb-4">
        <label
          for="email"
          class="block text-base font-bold text-orange-600 text-[#f16822]"
          >Correo Electrónico</label
        >
        <input
          type="email"
          name="email"
          v-model="user.email"
          id="email"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
      </div>

      <div class="mb-4">
        <label
          for="phone"
          class="block text-base font-bold text-orange-600 text-[#f16822]"
          >Teléfono</label
        >
        <input
          type="text"
          name="phone"
          v-model="user.phone"
          id="phone"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
      </div>

      <div class="mb-4">
        <label
          for="theme"
          class="block text-base font-bold text-orange-600 text-[#f16822]"
          >Tema</label
        >
        <input
          type="text"
          name="theme"
          v-model="user.theme"
          id="theme"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          class="px-4 py-2 mt-5 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
        >
          Actualizar
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Axios from '../axios'; // Importa la instancia de Axios configurada
import { mapState } from 'vuex';

export default {
  name: "UserConfig",
  computed: {
    ...mapState(['user']) // Usa Vuex store para acceder a la información del usuario
  },
  methods: {
    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.user.avatar = URL.createObjectURL(file);
        this.user.avatarFile = file; // Guarda el archivo real para el envío
      }
    },
    updateUser() {
      const formData = new FormData();
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("phone", this.user.phone);
      formData.append("theme", this.user.theme);
      if (this.user.avatarFile) {
        formData.append("avatar", this.user.avatarFile);
      }

      Axios.patch('/api/users-update', formData)
        .then(() => {
          this.$store.dispatch('fetchUser'); // Actualiza el usuario en el store después de la actualización
          alert("Información actualizada con éxito");
        })
        .catch((error) => {
          console.error("Error al actualizar la información:", error);
          alert("Hubo un problema al actualizar la información. Por favor, intenta de nuevo.");
        });
    },
  },
 
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>
