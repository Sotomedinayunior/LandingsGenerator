<template>
  <div
    class="max-w-sm mt-10 p-6 bg-white shadow-md rounded-md flex justify-center items-center flex-col"
    style="margin-left: 25rem;"
  >
    <h2 class="text-xl font-semibold mb-6 text-[#f16822]">
      Configuración del Usuario
    </h2>

    <form @submit.prevent="updateUser">
      <div class="mb-8 flex justify-center">
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
              v-if="user.avatarPreview || user.avatar"
              :src="user.avatarPreview ? user.avatarPreview : user.avatar"
              alt="Avatar"
              class="w-full h-full rounded-full object-cover"
            />
            <span v-else class="text-gray-500 text-center">Subir Imagen</span>
          </div>
        </div>
      </div>

      <div class="mb-8">
        <label for="name" class="block text-base font-bold text-[#f16822]">
          Nombre
        </label>
        <input
          v-model="user.name"
          type="text"
          placeholder="Nombre"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <span v-if="errors.name" class="text-red-500">{{ errors.name }}</span>
      </div>

      <div class="mb-8">
        <label for="password" class="block text-base font-bold text-[#f16822]">
          Contraseña
        </label>
        <input
          v-model="user.password"
          type="password"
          placeholder="Contraseña"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <span v-if="errors.password" class="text-red-500">{{ errors.password }}</span>
      </div>

      <div class="mb-8">
        <label
          for="password-confirm"
          class="block text-base font-bold text-[#f16822]"
        >
          Confirma la contraseña
        </label>
        <input
          v-model="user.password_confirmation"
          type="password"
          placeholder="Confirma la contraseña"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <span v-if="errors.password_confirmation" class="text-red-500">
          {{ errors.password_confirmation }}
        </span>
      </div>

      <div class="mb-8">
        <label for="email" class="block text-base font-bold text-[#f16822]">
          Correo Electrónico
        </label>
        <input
          v-model="user.email"
          type="email"
          placeholder="Correo Electrónico"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <span v-if="errors.email" class="text-red-500">{{ errors.email }}</span>
      </div>

      <div class="mb-8">
        <label for="phone" class="block text-base font-bold text-[#f16822]">
          Teléfono
        </label>
        <input
          v-model="user.phone"
          type="text"
          placeholder="Teléfono"
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
        <span v-if="errors.phone" class="text-red-500">{{ errors.phone }}</span>
      </div>

      <div class="flex justify-center">
        <button
          type="submit"
          class="px-4 py-2 mt-5 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
          :disabled="loading"
        >
          {{ loading ? "Actualizando..." : "Actualizar" }}
        </button>
      </div>
    </form>

    <div v-if="isErrorDialogVisible" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-md shadow-md">
        <h3 class="text-lg font-semibold mb-4">Error</h3>
        <p>{{ errorMessage }}</p>
        <div class="flex justify-end">
          <button @click="isErrorDialogVisible = false" class="px-4 py-2 text-white bg-red-500 rounded-md">
            Cerrar
          </button>
        </div>
      </div>
    </div>

    <!-- Toast de éxito -->
    <div
      v-if="showToast"
      id="toast-default"
      class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
      role="alert"
    >
      <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
        <svg
          class="w-6 h-6"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 18 20"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15.147 15.085a7.159 7.159 0 0 1-6.189 3.307A6.713 6.713 0 0 1 3.1 15.444c-2.679-4.513.287-8.737.888-9.548A4.373 4.373 0 0 0 5 1.608c1.287.953 6.445 3.218 5.537 10.5 1.5-1.122 2.706-3.01 2.853-6.14 1.433 1.049 3.993 5.395 1.757 9.117Z"
          />
        </svg>
        <span class="sr-only">Fire icon</span>
      </div>
      <div class="ms-3 text-sm font-normal">Usuario actualizado correctamente.</div>
      <button
        type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        @click="showToast = false"
      >
        <span class="sr-only">Close</span>
        <svg
          class="w-4 h-4"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 14 14"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
          />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import Axios from "../axios";
import { ref } from "vue";

export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone: "",
        avatar: "",
      },
      errors: {},
      loading: false,
      showToast: false, // Propiedad para controlar la visibilidad del Toast
      isErrorDialogVisible: false,
      errorMessage: '',
    };
  },

  mounted() {
    this.GetUser();
  },

  methods: {
    GetUser() {
      const UserId = localStorage.getItem("NellyUserId");
      Axios.get(`/api/users/${UserId}`)
        .then((response) => {
          this.user = {
            name: response.data.user.name || "",
            email: response.data.user.email || "",
            phone: response.data.user.phone || "",
            password: "",
            avatar: response.data.user.avatar || "",
          };
        })
        .catch((error) => {
          console.error("Error al obtener la información del usuario:", error);
        });
    },

    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.user.avatar = file;
        const reader = new FileReader();
        reader.onload = (event) => {
          this.user.avatarPreview = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    },

    updateUser() {
      const UserId = localStorage.getItem("NellyUserId");

      this.loading = true;
      this.errors = {};

      const formData = new FormData();
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("password", this.user.password);
      formData.append("password_confirmation", this.user.password_confirmation);
      formData.append("phone", this.user.phone);

      if (this.user.avatar) {
        const fileInput = document.getElementById("avatar");
        const file = fileInput.files[0];
        if (file) {
          formData.append("avatar", file);
        }
      }

      Axios.post(`/api/users-update/${UserId}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          this.loading = false;
          this.showToast = true; // Mostrar el Toast al actualizar correctamente
          this.GetUser();
          setTimeout(() => {
            this.showToast = false; // Ocultar el Toast después de 3 segundos
          }, 3000);
        })
        .catch((error) => {
          this.loading = false;
          if (error.response && error.response.data.errors) {
            this.errors = error.response.data.errors;
            this.errorMessage = this.errors[0] || 'Error desconocido';
          } else {
            this.errorMessage = 'Error al actualizar el usuario.';
          }
          this.isErrorDialogVisible = true;
        });
    },
  },
};
</script>

<style scoped>
/* Agregar estilos personalizados aquí */
</style>
