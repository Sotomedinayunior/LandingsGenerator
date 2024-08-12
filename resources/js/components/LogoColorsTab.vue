<template>
  <div class="grid grid-cols-2 gap-8">
    <div class="p-5 w-full flex flex-col justify-center">
      <!-- Contenido para la primera columna -->
      <form action="" method="post" enctype="multipart/form-data">
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
                class="w-12 h-12 cursor-pointer border border-slate-300 rounded"
              />
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Segunda columna -->
    <div class="p-8 w-full flex items-center justify-center">
      <!-- Contenido para la segunda columna -->
      <button
        @click="$emit('next')"
        class="px-4 py-2 bg-orange-500 text-white rounded"
      >
        Continuar
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      logoUrl: null, // Para almacenar la URL de la imagen
    };
  },
  methods: {
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.logoUrl = URL.createObjectURL(file); // Generar la URL de la imagen
      }
    },
  },
};
</script>
