<template>
  <div class="max-w-3xl lg:ml-64 p-6 bg-white shadow-md rounded-md">
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
              v-if="user.avatarPreview || user.avatar"
              :src="user.avatarPreview ? user.avatarPreview : user.avatar"
              alt="Avatar"
              class="w-full h-full rounded-full object-cover"
            />

            <span v-else class="text-gray-500 text-center">Subir Imagen</span>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label for="name" class="block text-base font-bold text-[#f16822]"
          >Nombre</label
        >
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
        <label for="contraseña" class="block text-base font-bold text-[#f16822]"
          >Contraseña</label
        >
        <input
          type="password"
          v-model="user.password"
          id="contraseña"
          name="password"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.password" class="text-red-500">{{
          errors.password
        }}</span>
      </div>
      <div class="mb-4">
        <label
          for="password-confirm"
          class="block text-base font-bold text-[#f16822]"
          >Confirma la contraseña</label
        >
        <input
          type="password"
          v-model="user.password_confirmation"
          id="name"
          name="confirm_password"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.password_confirmation" class="text-red-500">{{
          errors.password_confirmation
        }}</span>
      </div>

      <div class="mb-4">
        <label for="email" class="block text-base font-bold text-[#f16822]"
          >Correo Electrónico</label
        >
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
        <label for="phone" class="block text-base font-bold text-[#f16822]"
          >Teléfono</label
        >
        <input
          type="text"
          v-model="user.phone"
          id="phone"
          name="phone"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:outline-none sm:text-sm"
        />
        <span v-if="errors.phone" class="text-red-500">{{ errors.phone }}</span>
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          class="px-4 py-2 mt-5 text-white bg-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
          :disabled="loading"
        >
          {{ loading ? "Actualizando..." : "Actualizar" }}
        </button>
      </div>
    </form>

    <!-- Modal de confirmación -->
    <transition name="fade">
      <div
        v-if="showSuccessModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
      >
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <div
            class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-green-100 rounded-full"
          >
            <i
              class="fas fa-check-circle text-green-600 text-4xl animate-check"
            ></i>
          </div>
          <p class="text-lg font-semibold mb-2">¡Actualización Exitosa!</p>
          <p class="text-gray-600 mb-4">
            El usuario ha sido actualizado correctamente.
          </p>
          <button
            @click="closeSuccessModal"
            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors"
          >
            Cerrar
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import Axios from "../axios";

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
      showSuccessModal: false,
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
          console.log("Información del usuario:", this.user);
        })
        .catch((error) => {
          console.error("Error al obtener la información del usuario:", error);
        });
    },

    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.user.avatar = file; // Guardar el archivo en user
        const reader = new FileReader();
        reader.onload = (event) => {
          this.user.avatarPreview = event.target.result; // Crear una vista previa si deseas
        };
        reader.readAsDataURL(file);
      }
    },

    closeSuccessModal() {
      this.showSuccessModal = false;
    },

    updateUser() {
      const UserId = localStorage.getItem("NellyUserId");

      this.loading = true; // Iniciar el estado de carga
      this.errors = {}; // Reiniciar errores

      // Crear un objeto FormData
      const formData = new FormData();
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("password", this.user.password);
      formData.append("password_confirmation", this.user.password_confirmation);
      formData.append("phone", this.user.phone);

      // Solo agregar el avatar si existe
      if (this.user.avatar) {
        const fileInput = document.getElementById("avatar");
        const file = fileInput.files[0]; // Obtener el archivo directamente del input
        if (file) {
          formData.append("avatar", file); // Agregar el archivo de imagen
        }
      }

      Axios.post(`/api/users-update/${UserId}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          this.loading = false; // Finalizar el estado de carga
          this.showSuccessModal = true; // Mostrar el modal de éxito
          this.GetUser(); // Actualizar la información del usuario
          console.log("Usuario actualizado:", response.data);
        })
        .catch((error) => {
          this.loading = false; // Finalizar el estado de carga
          if (error.response && error.response.data.errors) {
            // Manejo de errores desde el servidor
            this.errors = error.response.data.errors;
          } else {
            console.error("Error al actualizar el usuario:", error);
          }
        });
    },
  },
};
</script>

<style scoped>
@keyframes check-animation {
  0% {
    opacity: 0;
    transform: scale(0.5);
  }
  50% {
    opacity: 1;
    transform: scale(1.1);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.animate-check {
  animation: check-animation 0.5s ease-in-out;
  background-color: #2e4c6ec3;
}
</style>
