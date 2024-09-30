<template>
  <div>
    <form
      @submit.prevent="handleSubmit"
      method="post"
      class="flex justify-between p-4 shadow-lg rounded mt-5"
    >
      <div class="flex flex-col">
        <div class="mb-4">
          <label
            for="meta_title"
            class="text-xs text-slate-950 font-medium mb-2"
            >Meta Title</label
          >
          <input
            type="text"
            v-model="metaData.meta_title"
            name="meta_title"
            id="meta_title"
            placeholder="Ingrese el título de la página (máx. 60 caracteres)"
            class="w-full border text-xs border-slate-300 rounded outline-none focus:ring-0"
            required
          />
        </div>

        <div class="mb-4">
          <label
            for="meta_description"
            class="text-xs text-slate-950 font-medium mb-2"
            >Meta Descripción</label
          >
          <textarea
            v-model="metaData.meta_description"
            name="meta_description"
            placeholder="Escriba una descripción breve de la página (máx. 160 caracteres)"
            id="meta_description"
            class="w-full border  text-xs border-slate-300 rounded outline-none focus:ring-0"
            rows="4"
            required
          ></textarea>
        </div>

        <div class="mb-4">
          <label
            for="meta_keywords"
            class="text-xs text-slate-950 font-medium mb-2"
            >Meta Keywords</label
          >
          <input
            type="text"
            v-model="metaData.meta_keywords"
            name="meta_keywords"
            placeholder="Ingrese palabras clave separadas por comas (ej. 'SEO, marketing, alquiler')"
            id="meta_keywords"
            class="w-full border  text-xs border-slate-300 rounded outline-none focus:ring-0"
          />
        </div>

        <div class="mb-4">
          <label for="og_title" class="text-xs text-slate-950 font-medium mb-2"
            >OG Title</label
          >
          <input
            type="text"
            v-model="metaData.og_title"
            name="og_title"
            id="og_title"
            placeholder="Título para compartir en redes sociales (máx. 60 caracteres)"
            class="w-full  text-xs border border-slate-300 rounded outline-none focus:ring-0"
          />
        </div>
      </div>

      <div class="flex mx-20 p-5">
        <div class="mb-4">
          <label for="og_image" class="text-xs text-slate-950 font-medium mb-2"
            >OG Image</label
          >
          <div
            class="border-2 border-[#F2994A] bg-[#F2994A0D] p-5 w-full h-50 flex items-center justify-center relative"
          >
            <input
              type="file"
              id="og_image"
              ref="ogImageInput"
              name="og_image"
              @change="previewImage"
              class="absolute inset-0 opacity-0 cursor-pointer"
              accept="image/*"
            />
            <label
              for="og_image"
              class="flex flex-col items-center justify-center text-center text-gray-500 cursor-pointer w-full h-full"
            >
              <template v-if="previewUrl">
                <img
                  :src="previewUrl"
                  alt="OG Image Preview"
                  class="h-full max-h-full object-contain"
                />
              </template>
              <template v-else>
                <p class="text-[#F2994A] text-xs">
                    Suba una imagen para compartir en redes sociales
                </p>
                <p class="text-[#F2994A] text-xs">(preferiblemente 1200x630px)</p>
                <p class="text-gray-500 text-xs">
                  Haz clic aquí o arrastra tu imagen
                </p>
              </template>
            </label>
          </div>
        </div>
      </div>
      <div class="flex flex-col">
        <div class="mb-4">
          <label
            for="og_description"
            class="text-xs text-slate-950 font-medium mb-2"
            >og_description</label
          >
          <textarea
            v-model="metaData.og_description"
            name="og_description"
            id="og_description"
            placeholder="Escriba una descripción breve para compartir en redes sociales (máx. 160 caracteres)"
            class="w-full border  text-xs border-slate-300 rounded outline-none focus:ring-0"
            rows="4"
            required
          ></textarea>
        </div>
        <div class="mb-4">
          <label
            for="canonical_url"
            class="text-xs text-slate-950 font-medium mb-2"
            >Canonical URL</label
          >
          <input
            type="url"
            v-model="metaData.canonical_url"
            name="canonical_url"
            id="canonical_url"
            placeholder="Ingrese la URL canónica de la página (ej. 'https://www.ejemplo.com/pagina')"
            class="w-full border  text-xs border-slate-300 rounded outline-none focus:ring-0"
          />
        </div>

        <div class="mb-4">
          <label for="robots" class="text-xs text-slate-950 font-medium mb-2"
            >Robots</label
          >
          <input
            type="text"
            v-model="metaData.robots"
            name="robots"
            id="robots"
            placeholder="Instrucciones para motores de búsqueda (ej. 'index, follow' o 'noindex, nofollow')"
            class="w-full border text-xs border-slate-300 rounded outline-none focus:ring-0"
          />
        </div>
        <button
          type="submit"
          class="px-4 py-2 bg-orange-500 text-white rounded transition-colors"
        >
          Guardar Metadatos
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import Axios from "../axios";

export default {
  name: "TabSeo",
  data() {
    return {
      metaData: {
        meta_title: "",
        meta_description: "",
        meta_keywords: "",
        og_title: "",
        og_description: "",
        og_image: null,
        canonical_url: "",
        robots: "",
      },
      previewUrl: null,
    };
  },
  methods: {
    getMetaData() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      Axios.get(`/api/landings/${userId}/${landingId}`)
        .then((response) => {
          this.metaData = response.data;
          console.log("Metadatos obtenidos:", this.metaData);
        })
        .catch((error) => {
          console.error("Error al obtener los metadatos:", error);
        });
    },
    handleSubmit() {
      const userId = localStorage.getItem("NellyUserId");
      const landingId = this.$route.params.id;

      const formData = new FormData();
      Object.entries(this.metaData).forEach(([key, value]) => {
        formData.append(key, value);
      });

      // Imprimir los datos que se enviarán
      for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }

      Axios.post(`/api/landings/${userId}/${landingId}/meta`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          console.log("Metadatos actualizados:", response.data);
        })
        .catch((error) => {
          console.error(
            "Error al actualizar los metadatos:",
            error.response ? error.response.data : error
          );
        });
    },

    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.metaData.og_image = file; // Guardar el archivo en metaData
        this.previewUrl = URL.createObjectURL(file); // Generar la URL para vista previa
      }
    },
  },
  mounted() {
    this.getMetaData();
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
