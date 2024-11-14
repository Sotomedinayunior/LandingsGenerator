<template>
  <section class="w-full" v-if="LayoutLanding && LayoutLanding.name">
    <div class="flex justify-around">
      <div class="flex flex-col">
        <h2 class="font-bold text-gray-500 text-2xl">Review</h2>
        <p class="text-sm text-gray-400">
          Aquí puede echar un vistazo a su nuevo sitio:
          <span class="font-bold">{{ LayoutLanding.name }}</span>
        </p>
      </div>

      <button
        @click="publicar"
        class="px-7 py-2 text-sm text-[#F57200] font-bold border border-[#F57200] rounded hover:bg-[#F57200] hover:text-white transition-colors"
      >
        Publicar
      </button>
    </div>

    <section class="w-full h-full bg-gray-200 mt-5 flex">
      <div
        class="lg:ml-64 p-4"
        :style="{ '--primary-color': LayoutLanding.color_primary }"
      >
       
        <section class="h-full py-4 px-8 bg-gray-200 mt-2 flex justify-center">
          <div class="box bg-white w-[700px]">
            <div
              class="bg-white p-2 flex justify-between items-center flex-nowrap"
            >
              <div class="">
                <img
                  :src="LayoutLanding.logo"
                  :alt="LayoutLanding.name"
                  :title="LayoutLanding.name"
                  width="40"
                  height="40"
                  loading="lazy"
                  class="w-10 h-10"
                />
              </div>
              <nav>
                <ul class="flex items-center space-x-4 font-semibold text-xs">
                  <li><a href="#" class="text-xs">visión general</a></li>
                  <li><a href="#" class="text-xs">vehículos</a></li>
                  <li><a href="#" class="text-xs">Acerca de nosotros</a></li>
                </ul>
              </nav>
            </div>
            <div class="slider flex-col">
              <h2 class="text-3xl text-white font-bold mb-4">
                Renta tu Vehiculo
              </h2>
              <p class="text-sm text-white mb-4">Busca tu vehiculo ideal</p>
              <img
                src="./Landing/asset/pickup.png"
                alt="pickup"
                width="400"
                height="400"
                class=""
              />
            </div>
            <div class="px-2 py-4">
              <h2 class="text-xl font-semibold">Nuestros vehiculos</h2>
              <div class="grillas">
                <div v-for="item in vehicles" key="item.id">
                  <Card style="width: 17rem; overflow: hidden;">
                    <template #header>
                      <img
                        :alt="item.name"
                        :src="url + '/' + item.images[0].path_images"
                      />
                    </template>
                    <template #title>
                      <h2 class="text-sm">{{ item.name }}</h2>
                    </template>
                    <template #subtitle
                      ><p class="text-xs">{{ item.price }} por dia</p></template
                    >
                    <template #content>
                      <p class="text-xs">
                        {{ item.description }}
                      </p>
                    </template>
                    <template #footer>
                      <div class="flex gap-4 mt-1">
                        <!-- <Button
                        label="Cancel"
                        severity="secondary"
                        outlined
                        class="w-full"
                      />
                      <Button label="Save" class="w-full" /> -->
                      </div>
                    </template>
                  </Card>
                </div>
              </div>
            </div>
            <div
              class="container max-w-screen-lg mx-auto p-5 grid grid-cols-2 gap-6"
            >
              <div class="vehicle"></div>
              <div class="flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-slate-950 text-left mb-7">
                  How it works
                </h2>
                <ul class="space-y-4">
                  <li class="flex items-start mb-7">
                    <span
                      class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-white font-bold mr-4"
                      >1</span
                    >
                    <div>
                      <h3 class="font-semibold text-slate-950">
                        Select Your Car
                      </h3>
                      <p class="text-slate-600">
                        Browse our fleet and choose the one that fits your
                        needs.
                      </p>
                    </div>
                  </li>
                  <li class="flex items-start mb-7">
                    <span
                      class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-white font-bold mr-4"
                      >2</span
                    >
                    <div>
                      <h3 class="font-semibold text-slate-950">
                        Book Your Ride
                      </h3>
                      <p class="text-slate-600">
                        Fill out the booking form with your details and trip
                        dates.
                      </p>
                    </div>
                  </li>
                  <li class="flex items-start mb-7">
                    <span
                      class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 text-white font-bold mr-4"
                      >3</span
                    >
                    <div>
                      <h3 class="font-semibold text-slate-950">
                        Enjoy Your Trip
                      </h3>
                      <p class="text-slate-600">
                        Drive safely and enjoy your trip! Return the car at your
                        convenience.
                      </p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <footer
              class="bg-slate-100 p-5 flex flex-col justify-center item fade-in"
            >
              <p class="text-slate-600 text-center">
                ©{{ LayoutLanding.name }}{{ $t("footer_text") }}
              </p>
            </footer>
          </div>
        </section>
      </div>
    </section>
  </section>
</template>

<script>
import Axios from "../axios";

export default {
 
  data() {
    return {
      LayoutLanding: {},
      vehicles: [],
      url: "http://localhost:8000/storage",
    };
  },
  mounted() {
  
    this.getLayoutLanding();
  },
  methods: {
    async publicar() {
      let userId = localStorage.getItem("NellyUserId");
      let landingId = localStorage.getItem("NellyLandingCreate");

      if (userId && landingId) {
        try {
          await Axios.patch(
            "/landing/status",
            {
              landing_id: landingId,
              user_id: userId,
            },
            {
              headers: {
                "Content-Type": "application/json",
              },
            }
          );
          this.$router.push("/published");
        } catch (error) {
          console.error("Error al actualizar el estado:", error);
        }
      } else {
        alert("Falta el ID de usuario o de landing");
      }
    },
    getLayoutLanding() {
      let IdLanding = localStorage.getItem("NellyLandingName");
      Axios.get(`/reviews/${IdLanding}`).then((response) => {
        this.LayoutLanding = response.data.landing;
        this.vehicles = response.data.vehicles;
        console.log("Vehicles", this.vehicles);
        console.log("LayoutLanding", this.LayoutLanding);
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
  background-size: cover;
  background-position: center;
  margin-top: 40px;
  min-height: 200px;
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
.grillas {
  display: grid;
  grid-template-columns: auto auto;
  grid-auto-flow: row;
  gap: 20px;
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
