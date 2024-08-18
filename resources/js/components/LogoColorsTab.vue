<template>
  <div class="grid grid-cols-2 gap-8">
    <div class="p-5 w-full flex flex-col justify-center">
      <!-- Contenido para la primera columna -->
      <form ref="form" @submit.prevent="handleSubmit" enctype="multipart/form-data">
        <div class="mb-7">
          <h2 class="text-2xl font-semibold text-slate-950 mb-2">
            1- Name your website
          </h2>
          <input
            type="text"
            class="w-full px-4 py-2 border border-slate-300 rounded outline-none focus:ring-0"
            v-model="name"
            name="name"
            placeholder="Enter your website name"
            required
          />
        </div>
        <div class="mb-4">
          <h2 class="text-2xl font-semibold text-slate-950 mb-2">
            2- Upload the logo
          </h2>
          <div
            class="border-2 border-dashed border-[#F2994A] bg-[#F2994A0D] p-4 w-full h-40 flex items-center justify-center relative"
          >
            <input
              type="file"
              id="logo"
              ref="logoInput"
              name="logo"
              @change="previewImage"
              class="absolute inset-0 opacity-0 cursor-pointer"
            />
            <label
              for="logo"
              class="flex flex-col items-center justify-center text-center text-gray-500 cursor-pointer w-full h-full"
            >
              <template v-if="logoUrl">
                <img
                  :src="logoUrl"
                  alt="Logo Preview"
                  class="h-full max-h-full object-contain"
                />
              </template>
              <template v-else>
                <!-- Icono de cámara de Font Awesome -->
                <i class="fa-solid fa-camera text-[#F2994A] text-4xl"></i>
                <p class="text-[#F2994A] mt-2">
                  Tamaño recomendado 1920 x 1080px
                </p>
              </template>
            </label>
          </div>
        </div>
        <div class="mb-8">
          <h2 class="text-2xl font-semibold text-slate-950 mb-2">
            3- Choose Primary & Secondary Color
          </h2>
          <div class="flex space-x-4">
            <!-- Selector de color primario -->
            <div class="flex flex-col items-center">
              <label for="primaryColor" class="text-slate-950 mb-2">
                Primary Color
              </label>
              <input
                type="color"
                id="primaryColor"
                v-model="primaryColor"
                name="primaryColor"
                class="w-12 h-12 cursor-pointer border border-slate-300 rounded"
              />
            </div>

            <!-- Selector de color secundario -->
            <div class="flex flex-col items-center">
              <label for="secondaryColor" class="text-slate-950 mb-2">
                Secondary Color
              </label>
              <input
                type="color"
                id="secondaryColor"
                v-model="secondaryColor"
                name="secondaryColor"
                class="w-12 h-12 cursor-pointer border border-slate-300 rounded"
              />
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Segunda columna -->
    <div class="p-8 w-full flex justify-center flex-col">
      <div class="flex justify-around">
        <h2 class="text-2xl font-bold text-gray-500">Preview</h2>
        <div class="flex justify-end">
          <button
            @click="submitForm"
            :disabled="!isFormComplete"
            :class="{
              'bg-orange-500': isFormComplete,
              'bg-gray-500': !isFormComplete
            }"
            class="px-4 py-2 text-white rounded transition-colors"
          >
            Continuar
          </button>
        </div>
      </div>
      <p class="ml-[80px] my-1 text-sm text-gray-500">Echa un vistazo a cómo se verá y se sentirá</p>

      <img
        src="../static/asset/under-construcion.webp"
        class="h-61 max-w-lg rounded-lg"
        alt="underconstrucion"
        lazy="loading"
        title="Muy pronto a la luz para el publico"
      />
    </div>
    <ModalComponent
      :title="modalTitle"
      :message="modalMessage"
      :isVisible="isModalVisible"
      @close="closeModal"
    />
  </div>
</template>

<script>
import Axios from '../axios';
import ModalComponent from './ModalComponent.vue';

export default {
  components: {
    ModalComponent
  },
  data() {
    return {
      name: '',
      logoUrl: null, // Para almacenar la URL de la imagen
      primaryColor: '#000000', // Valor por defecto para el color primario
      secondaryColor: '#FFFFFF', // Valor por defecto para el color secundario
    };
  },
  computed: {
    isFormComplete() {
      // Verifica si todos los campos necesarios están llenos
      return this.name && this.logoUrl && this.primaryColor && this.secondaryColor;
    }
  },
  methods: {
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.logoUrl = URL.createObjectURL(file); // Generar la URL de la imagen
      }
    },
    handleSubmit() {
      // Tomar el ID del usuario desde el almacenamiento local
      let userId = localStorage.getItem('NellyUserId');
      
      if (!userId) {
        console.error('User ID is required');
        return;
      }

      // Crear un objeto FormData para enviar los datos del formulario
      const formData = new FormData();
      formData.append('id_users_landing', userId);
      formData.append('name', this.name);
      formData.append('logo', this.$refs.logoInput.files[0]); // Usando una referencia al input de archivo
      formData.append('color_primary', this.primaryColor);
      formData.append('color_secondary', this.secondaryColor);

      // Enviar los datos usando Axios
      Axios.post('/api/landing', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
      .then(response => {
        console.log('Formulario enviado con éxito:', response.data);
        let IdLanding = localStorage.setItem("NellyLandinCreate" , response.data.id)
        // Manejar la respuesta exitosa aquí, por ejemplo, redirigir o mostrar un mensaje
      })
      .catch(error => {
        console.error('Error al enviar el formulario:', error);
        // Manejar el error aquí, por ejemplo, mostrar un mensaje de error
      });
    },
    submitForm() {
      // Llamar al método de envío del formulario
      this.$refs.form.requestSubmit(); // Usar requestSubmit() para enviar el formulario
    }
  }
};
</script>

<style scoped>
/* Agrega aquí tus estilos personalizados si es necesario */
</style>
