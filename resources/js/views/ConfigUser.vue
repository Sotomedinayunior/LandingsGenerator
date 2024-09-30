<template>
  <div class="max-w-3xl lg:ml-64  p-6 bg-white shadow-md rounded-md">
    <h2 class="text-2xl font-semibold mb-6 text-[#f16822]">Configuración del Usuario</h2>

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
          <div class="flex items-center justify-center w-20 h-20 border-2 border-[#f16822] border-dashed rounded-full bg-gray-100">
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
        <label for="name" class="block text-base font-bold text-[#f16822]">Nombre</label>
        <input
          type="text"
          v-model="user.name"
          id="name"
          name="name"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.name" class="text-red-500">{{ errors.name }}</span>
      </div>

      <div class="mb-4">
        <label for="email" class="block text-base font-bold text-[#f16822]">Correo Electrónico</label>
        <input
          type="email"
          v-model="user.email"
          id="email"
          name="email"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.email" class="text-red-500">{{ errors.email }}</span>
      </div>

      <div class="mb-4">
        <label for="phone" class="block text-base font-bold text-[#f16822]">Teléfono</label>
        <input
          type="text"
          v-model="user.phone"
          id="phone"
          name="phone"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.phone" class="text-red-500">{{ errors.phone }}</span>
      </div>

      <div class="mb-4">
        <label for="theme" class="block text-base font-bold text-[#f16822]">Tema</label>
        <input
          type="text"
          v-model="user.theme"
          id="theme"
          name="theme"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.theme" class="text-red-500">{{ errors.theme }}</span>
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          class="px-4 py-2 mt-5 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
          :disabled="loading"
        >
          {{ loading ? 'Actualizando...' : 'Actualizar' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Axios from '../axios';
import { mapState } from 'vuex';

export default {
  name: "UserConfig",
  data() {
    return {
      errors: {},
      loading: false
    };
  },
  computed: {
    ...mapState(['user']),
  },
  methods: {
    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.user.avatar = URL.createObjectURL(file);
        this.user.avatarFile = file;
      }
    },
    validateForm() {
      this.errors = {};

      if (!this.user.name) this.errors.name = 'El nombre es obligatorio.';
      if (!this.user.email) {
        this.errors.email = 'El correo electrónico es obligatorio.';
      } else if (!/\S+@\S+\.\S+/.test(this.user.email)) {
        this.errors.email = 'El correo electrónico no es válido.';
      }

      if (!this.user.phone) this.errors.phone = 'El teléfono es obligatorio.';
      if (!this.user.theme) this.errors.theme = 'El tema es obligatorio.';

      return Object.keys(this.errors).length === 0;
    },
    updateUser() {
      if (!this.validateForm()) return;

      this.loading = true;
      const formData = new FormData();
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("phone", this.user.phone);
      formData.append("theme", this.user.theme);
      if (this.user.avatarFile) {
        formData.append("avatar", this.user.avatarFile);
      }

      Axios.post('/api/users-update', formData)
        .then(() => {
          this.$store.dispatch('fetchUser');
          alert("Información actualizada con éxito");
        })
        .catch((error) => {
          console.error("Error al actualizar la información:", error);
          if (error.response && error.response.data) {
            this.errors = error.response.data.errors || {};
          } else {
            alert("Hubo un problema al actualizar la información.");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    }
  }
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí */
</style>