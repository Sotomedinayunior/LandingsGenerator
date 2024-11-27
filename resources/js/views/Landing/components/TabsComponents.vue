<template>
  <section class="px-3 py-3 border-b border-gray-200 w-full">
    <div class="container max-w-[1150px]			 mx-auto flex justify-between items-center">
      <div class="flex flex-col cursor-pointer">
        <h2 class="text-xs font-bold mb-3"> {{ $t("date_location") }}</h2>
        <div class="flex items-center whitespace-nowrap">
          <h2 class="text-xs font-bold">{{ $t("pickup") }}-</h2>
          <span class="text-xs ml-3">{{ Tabs1.place_of_departure }}</span>
          <img
            src="../asset/line.png"
            alt="line"
            width="40"
            height="30"
            class="mx-3"
          />
          <h2 class="text-xs font-bold ml-5">{{ $t("return") }} -</h2>
          <span class="text-xs ml-3">{{ Tabs1.arrival_place }}</span>
        </div>
        <div class="flex items-center whitespace-nowrap">
          <h2 class="text-xs font-bold whitespace-nowrap">
            {{ formatDate(Tabs1.date_of_arrival) }}
          </h2>
          <img src="../asset/circle.png" alt="" class="mx-3" />
          <h2 class="text-xs font-bold">{{ Tabs1.time_of_arrival }}</h2>
          <h2 class="text-xs font-bold ml-4">
            {{ formatDate(Tabs1.date_of_departure) }}
          </h2>
          <img src="../asset/circle.png" alt="" class="mx-3" />
          <h2 class="text-xs font-bold">{{ Tabs1.time_of_departure }}</h2>
        </div>
      </div>
      <div>
        <div class="flex flex-col">
          <h2 class="text-xs font-bold">{{ $t("vehicle") }}
          </h2>

          <!-- Si Tabs2 está disponible, muestra la imagen y el nombre -->
          <div class="flex items-center" v-if="Tabs2">
            <img
              :src="Tabs2.image_path"
              :alt="Tabs2.title"
              class="w-20 h-auto"
            />
            <h2 class="text-xs font-bold mb-3">
              {{ Tabs2.title }}
            </h2>
          </div>

          <!-- Si Tabs2 no está disponible, muestra el mensaje "Not yet" -->
          <div v-else>
            <h2 class="text-base text-gray-400">{{ $t('not_yet') }}</h2>
            <span class="text-xs text-gray-400">{{ $t('select_vehicle') }} </span>
          </div>
        </div>
      </div>
      <!-- <div class="flex flex-col">
      <h2 class="text-xs text-gray-300">Extras</h2>
      <h2 class="text-xs font-extrabold">{{ Tabs3.name }}</h2>
      <p> <p class="text-[#333333] text-xs font-bold">
        US${{  Tabs3.price  }}<span class="text-[#828282] text-xs">/day</span>
      </p></p>
    </div> -->
      <div>
        <h2 class="text-xs font-bold text-center">{{ $t("review") }}
        </h2>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "TabsComponent",
  data() {
    return {
      currentLanguage: null,

      Tabs1: [],
      Tabs2: [],
      Tabs3: [],
    };
  },
  mounted() {
    this.getTabs();
  },
  methods: {
    getTabs() {
      const storedTabs = localStorage.getItem("formValidate");
      const storedTabs1 = localStorage.getItem("formVehicles");
      const storedTabs2 = localStorage.getItem("selectedProduct"); // Asegúrate de que esta línea esté presente

      if (storedTabs) {
        this.Tabs1 = JSON.parse(storedTabs);
        console.log(`Tabs list`, this.Tabs1.place_of_departure);
      } else {
        console.log("No data found in localStorage for formValidate");
      }

      if (storedTabs1) {
        this.Tabs2 = JSON.parse(storedTabs1);
        console.log(`Tabs list ggggg`, this.Tabs2);
      } else {
        console.log("No data found in localStorage for formVehicles");
      }

      if (storedTabs2) {
        this.Tabs3 = JSON.parse(storedTabs2);
        console.log(`Tabs list products ext`, this.Tabs3);
      } else {
        console.log("No data found in localStorage for formProducts");
      }
    },

    formatDate(dateString) {
      // Verificar si la cadena de fecha está definida y tiene el formato correcto
      if (!dateString || !/^\d{2}-\d{2}-\d{4}$/.test(dateString)) {
        console.error(
          "Formato de fecha inválido o cadena indefinida:",
          dateString
        );
        return dateString || "Fecha no disponible"; // Retornar un valor por defecto si es undefined o null
      }

      // Dividir la cadena en día, mes, año
      const [day, month, year] = dateString.split("-");

      // Crear un nuevo objeto de fecha
      const date = new Date(`${year}-${month}-${day}`);

      // Verificar si la fecha es válida
      if (isNaN(date.getTime())) {
        console.error("Fecha inválida:", dateString);
        return dateString;
      }

      // Configurar las opciones de formato
      const options = { day: "numeric", month: "short", year: "numeric" };

      // Retornar la fecha formateada
      return date.toLocaleDateString("es-ES", options);
    },
  },
};
</script>

<style scoped></style>
