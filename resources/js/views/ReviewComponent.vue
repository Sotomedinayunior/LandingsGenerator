<template>
  <div  class="lg:ml-64 p-4" >
    <header class="flex justify-between">
      
        <div class="flex flex-col ">
            <h1 class="font-bold text-gray-600">Review</h1>
            <p class="text-gray-300">Here you can take a look of your new website: <span class="font-bold">{{ LayoutLanding.name  }}</span> </p>
        </div>
        <button class="px-4 py-2 m-6 border-orange-500 border text-orange-500 rounded transition-colors">Guardar</button>

    </header>
    <section class="w-full h-full bg-gray-200 mt-2 flex justify-center">
      <div class="max-w-4xl bg-white p-4">
         <div class="flex justify-between">
           <img :src="LayoutLanding.logo" :alt="LayoutLanding.name" :title="LayoutLanding.name">
         </div>
         <nav>
          <ul class="flex flex-col items-center md:flex-row md:space-x-4 font-bold text-xs">
            <li><a href="#">visión general</a></li>
            <li><a href="#">vehículos</a> </li>
            <li><a href="#">Acerca de nosotros</a></li>
        
          </ul>
         </nav>
      </div>
    </section>
    <section class="slider fade-in">
        <div class="d-flex justify-center items-center flex-col">
          <h1 class="text-center text-6xl bold text-white text-wrap mb-8">
            {{ $t("Rent") }}
          </h1>
          <p
            class="text-center text-3xl font-normal text-white text-wrap mb-10"
          >
            {{ $t("Find") }}
          </p>
          <div class="pickup">
            <div>
              <img src="./Landing/asset/pickup.png" alt="pickup ejemplo" width="400" height="500">
            </div>
          </div>
        </div>
      </section>
  </div>
</template>
<script>
import Axios from "../axios";
export default {
  name: "ReviewLanding",
  data() {
    return {
      LayoutLanding: {},
    };
  },
  mounted() {
    this.getLayoutLanding();
  },
  methods: {
    getLayoutLanding() {
      let IdLanding = this.$route.params.name;
      Axios.get(`/api/reviews/${IdLanding}`).then((response) => {
        this.LayoutLanding = response.data;
      });
    },
  },
};

</script>
<style scoped>
::selection {
  background-color: var(--primary-color);
  color: #fff;
}





.slider {
  display: flex;
  justify-content: center;
  font-family: "Cera Round Pro", sans-serif;
  align-items: center;
  background-image: url("./Landing/asset/Slider.jpg");
  background-repeat: no-repeat;
  background-size:contain;
  background-position: center;
  margin-top: 40px;
  min-height: 350px;
}
.vehicle {
  background-image: url("./Landing/asset/vehicle.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  min-height: 380px;
  border-radius: 8px;
}
.fade-in {
  opacity: 0; /* Inicialmente invisible */
  animation: fadeIn 0.5s forwards; /* Llama a la animación */
}
@media only screen and(max-width: 578px) {
  body {
    overflow-x: hidden;
  }
  .pickup {
    display: none;
  }
}

@keyframes fadeIn {
  0% {
    opacity: 0; /* Al inicio, completamente invisible */
    transform: translateY(20px); /* Desplazado hacia abajo */
  }
  100% {
    opacity: 1; /* Al final, completamente visible */
    transform: translateY(0); /* Regresa a la posición original */
  }
}
</style>
