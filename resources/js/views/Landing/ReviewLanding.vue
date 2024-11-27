<template>
  <div v-if="landing" :style="{ '--primary-color': landing.color_primary }">
    <NavComponents
      :logo="logoLanding"
      :logoTitle="LogoTitle"
      :colorPrimary="color1"
      :colorSecondary="color2"
    />
    <TabsComponents />
    <main
      class="container max-w-[1150px] mx-auto grid grid-cols-2 justify-between gap-9"
    >
      <section class="py-11">
        <h2 class="text-2xl font-bold mb-4">{{ $t("overview") }}</h2>

        <div class="border rounded-lg p-4 bg-gray-100">
          <h2 class="text-lg font-semibold">{{ $t("order_details") }}</h2>
          <div class="flex flex-col">
            <h2
              class="text-xs text-gray-700 my-5 font-semibold"
              :style="{ color: landing.color_primary }"
            >
              {{ $t("date_location") }}
            </h2>
            <div class="flex items-center whitespace-nowrap">
              <h2 class="text-xs font-bold">{{ $t("pickup") }}</h2>
              <span class="text-xs ml-2">{{ Tabs1.place_of_departure }}</span>
              <img
                src="./asset/line.png"
                alt="line"
                width="40"
                height="30"
                class="mx-3"
              />
              <h2 class="text-xs font-bold ml-2">{{ $t("return") }} -</h2>
              <span class="text-xs ml-2">{{ Tabs1.arrival_place }}</span>
            </div>
          </div>
          <div class="flex items-center whitespace-nowrap my-2">
            <h2 class="text-xs font-bold whitespace-nowrap">
              {{ formatDate(Tabs1.date_of_arrival) }}
            </h2>
            <img src="./asset/circle.png" alt="" class="mx-3" />
            <h2 class="text-xs font-bold">{{ Tabs1.time_of_arrival }}</h2>
            <h2 class="text-xs font-bold ml-4">
              {{ formatDate(Tabs1.date_of_departure) }}
            </h2>
            <img src="./asset/circle.png" alt="" class="mx-3" />
            <h2 class="text-xs font-bold">{{ Tabs1.time_of_departure }}</h2>
          </div>
          <div class="flex flex-col">
            <h2
              class="text-xs font-semibold my-2"
              :style="{ color: landing.color_primary }"
            >
              {{ $t("vehicle") }}
            </h2>
            <div class="flex items-center">
              <img
                :src="Tabs2.image_path"
                :alt="Tabs2.title"
                class="w-20 h-auto"
              />
              <h2 class="text-xs font-bold mb-3 mx-3">
                {{ Tabs2.title }}
              </h2>
            </div>
          </div>
          <!-- <div class="flex flex-col">
            <h2 class="text-sm text-gray-700 my-3">Extras</h2>
            <h2 class="text-xs font-extrabold">{{ Tabs3.name }}</h2>
          </div> -->
        </div>
      </section>
      <section class="w-full">
        <div class="mx-auto py-5 bg-white">
          <h2 class="text-sm font-bold mb-4">{{ $t("charges") }}</h2>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600 text-xs">{{
                $t("charges_summary")
              }}</span>
              <span class="text-gray-600 text-xs">US$180.00</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 text-xs">{{
                $t("additional_liability_service")
              }}</span>
              <span class="text-gray-600 text-xs">US$9.95</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 text-xs">{{
                $t("vehicle_license_fee")
              }}</span>
              <span class="text-gray-600 text-xs">US$3.50</span>
            </div>
            <div class="flex justify-between font-semibold">
              <span class="text-gray-700 text-xs">{{ $t("subtotal") }}</span>
              <span class="text-gray-700 text-xs">US$213.45</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600 text-xs">{{ $t("tax_itbis") }}</span>
              <span class="text-gray-600 text-xs">US$38.42</span>
            </div>
            <div class="flex justify-between text-xs font-bold mt-4">
              <span>{{ $t("total") }}</span>
              <span>US$251.87</span>
            </div>
          </div>
        </div>

        <div class="w-full mx-auto py-6">
          <h2 class="text-sm font-semibold mb-4">
            {{ $t("contact_information") }}
          </h2>

          <form class="space-y-4" @submit.prevent="submitForm">
            <!-- Name Field -->
            <input
              type="text"
              v-model="name"
              required
              :placeholder="$t('name')"
              class="w-full border rounded-lg p-3 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <input
              type="text"
              v-model="lastName"
              required
              :placeholder="$t('last_name')"
              class="w-full border text-xs rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <!-- Email Field -->
            <input
              type="email"
              required
              v-model="email"
              :placeholder="$t('email')"
              class="w-full border text-xs rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <!-- Phone Field -->
            <input
              type="phone"
              required
              :placeholder="$t('phone')"
              class="w-full border text-xs rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <!-- Comment Field -->
            <textarea
              rows="4"
              v-model="comment"
              :placeholder="$t('additional_comment')"
              class="w-full border text-xs rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>

            <!-- Information Text -->
            <p class="text-xs text-gray-500">
              <strong>{{ $t("important_information") }}</strong>
              {{ $t("prepaid_reservation_info") }}
            </p>

            <ul class="list-disc list-inside text-xs text-gray-500">
              <li>{{ $t("cancellation_within_24_hours") }}</li>
              <li>{{ $t("cancellation_more_than_24_hours") }}</li>
              <li>{{ $t("no_show_no_refund") }}</li>
              <li>{{ $t("unused_rental_days_no_refund") }}</li>
            </ul>

            <!-- Checkbox -->
            <div class="flex items-start mt-4">
              <input
                type="checkbox"
                id="accept"
                required
                class="mt-1 mr-2 text-xs focus:ring-blue-500 focus:border-blue-500"
              />
              <label for="accept" class="text-xs text-gray-600">
                {{ $t("accept_terms") }}
                <a href="#" class="underline">{{ $t("rental_information") }}</a
                >, <a href="#" class="underline">{{ $t("terms_conditions") }}</a
                >, <a href="#" class="underline">{{ $t("privacy_policy") }}</a
                >,
                {{ $t("prepaid_rate_acknowledgment") }}
                <a href="#" class="underline">{{ $t("driver_requirements") }}</a
                >,
                <a href="#" class="underline">{{
                  $t("payment_requirements")
                }}</a
                >,
                {{ $t("territorial_restrictions") }}
              </label>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              class="w-full bg-black text-white text-xs font-semibold py-3 rounded-lg hover:bg-gray-800"
            >
              {{ $t("reserve") }}
            </button>
          </form>
        </div>
      </section>
    </main>
  </div>
  <div v-else>
    <h1>{{ message }}</h1>
  </div>
</template>

<script>
import axios from "axios";
import TabsComponents from "./components/TabsComponents.vue";

const url = import.meta.env.VITE_API_URL;
import NavComponents from "./components/NavComponents.vue";
export default {
  components: {
    NavComponents,
    TabsComponents,
  },
  data() {
    return {
      message: this.$t('calculating_information'),
      currentLanguage: null,
      name: "",
      lastName: "", // Asegúrate de definir lastName
      email: "",
      comment: "",
      phone: "",

      logoLanding: "",
      LogoTitle: "",
      color1: "",
      color2: "",
      landing: null, // Declarar landing
      vehicles: [], // Declarar vehicles
      Tabs1: [],
      Tabs2: [],
      Tabs3: [],
    };
  },

  mounted() {
    this.getVehicles();
    this.getTabs();
  },

  methods: {
    // Aquí defines la función convertTo24Hour
    convertTo24Hour(time) {
      const [timePart, modifier] = time.split(" ");
      let [hours, minutes] = timePart.split(":");

      if (hours === "12") {
        hours = "00";
      }

      if (modifier === "PM") {
        hours = parseInt(hours, 10) + 12;
      }

      return `${hours}:${minutes}`;
    },

    submitForm() {
      const storedVehicle = localStorage.getItem("formVehicles");
      const storedFormData = localStorage.getItem("formValidate");

      if (storedVehicle && storedFormData) {
        // Convertir los datos del localStorage a objetos
        const vehicleData = JSON.parse(storedVehicle);
        const formData = JSON.parse(storedFormData);

        // Verificar que los datos necesarios estén presentes
        if (!vehicleData || !formData) {
          console.error("Faltan datos necesarios en localStorage.");
          return;
        }

        // Verificar que 'time_of_departure' y 'time_of_arrival' existan en formData
        const timeOfDeparture24 = formData.time_of_departure
          ? this.convertTo24Hour(formData.time_of_departure)
          : null;
        const timeOfArrival24 = formData.time_of_arrival
          ? this.convertTo24Hour(formData.time_of_arrival)
          : null;

        // Asegúrate de que 'name_landing' esté en formData
        const nameLanding = formData.name_landing || "Unknown Landing"; // Valor por defecto si no existe

        // Aquí se agrega la URL del logo de la landing
        const urlLanding = this.logoLanding || ""; // Si no hay logo, se envía una cadena vacía

        // Crear los datos para la reserva
        const reservationData = {
          id_vehicle: vehicleData.id_vehicle,
          id_landing: formData.id_landing,
          name_landing: nameLanding, // Asigna name_landing desde el formData
          name: this.name,
          last_name: this.lastName,
          email: this.email,
          description: this.comment,
          place_of_departure: formData.place_of_departure,
          arrival_place: formData.arrival_place,
          number_of_persons: formData.number_of_persons,
          date_of_departure: this.formatDate(formData.date_of_departure), // Convertir aquí
          time_of_departure: timeOfDeparture24,
          date_of_arrival: this.formatDate(formData.date_of_arrival), // Convertir aquí también
          time_of_arrival: timeOfArrival24,
          url_landing: urlLanding, // Se agrega la URL del logo de la landing
        };

        // Hacer la solicitud para crear la reserva
        axios
          .post(`${url}/reservations`, reservationData)
          .then((response) => {
            console.log("Reservación creada:", response.data);

            // Limpiar los datos del localStorage
            localStorage.removeItem("formValidate");
            localStorage.removeItem("formVehicles");
            localStorage.removeItem("selectedProduct");
            localStorage.setItem("NameUser", this.name);

            // Redirigir a la página de agradecimiento
            this.$router.push({ name: "thanks-you" });
          })
          .catch((error) => {
            console.error("Error al crear la reservación:", error);
          });
      } else {
        console.error("No se encontraron datos en localStorage.");
      }
    },
    metaInfo() {
      return {
        title: this.landing?.meta_title || "Default Title",
        meta: [
          {
            name: "description",
            content: this.landing?.meta_description || "Default description",
          },
          {
            name: "viewport",
            content: "width=device-width, initial-scale=1.0",
          },
          { name: "keywords", content: this.landing?.meta_keywords || "" },
          {
            property: "og:title",
            content: this.landing?.og_title || "Default OG Title",
          },
          {
            property: "og:description",
            content: this.landing?.og_description || "Default OG Description",
          },
          {
            property: "og:image",
            content: this.landing?.og_image || "default-image-url.jpg",
          },
          { name: "robots", content: this.landing?.robots || "index, follow" },
          {
            rel: "canonical",
            href: this.landing?.canonical_url || window.location.href,
          },
        ],
      };
    },
    updateMetaTags() {
      const metaData = this.metaInfo();

      // Actualiza el título de la página
      document.title = metaData.title;

      // Eliminar meta tags existentes (si es necesario)
      const existingMetaTags = document
        .querySelectorAll("meta")
        .forEach((meta) => meta.remove());
      existingMetaTags.forEach((tag) => tag.parentNode.removeChild(tag));

      // Añadir nuevos meta tags
      metaData.meta.forEach((metaTag) => {
        const meta = document.createElement("meta");
        Object.keys(metaTag).forEach((key) => {
          meta.setAttribute(key, metaTag[key]);
        });
        document.head.appendChild(meta);
      });
    },

    getVehicles() {
      const NameLandingId = this.$route.params.name;

      axios
        .get(`${url}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.logoLanding = this.landing.logo;
          this.LogoTitle = this.landing.name;
          const landingLanguage = this.landing.default_language; // Aquí puedes cambiar 'es' por el idioma que quieras como predeterminado

          this.changeLanguage(landingLanguage);
          this.color1 = this.landing.color_primary;
          this.color2 = this.landing.color_secondary;

          console.log(
            `Info de los vehicles`,
            this.vehicles,
            this.logoLanding,
            this.color1,
            this.color2
          );
        })
        .catch((err) => {
          if (err.response && err.response.status === 404) {
            this.message = "Landing no encontrada o ha sido eliminada.";
          } else {
            this.message = "Ocurrió un error al buscar la landing.";
          }
        });
    },

    changeLanguage(language) {
      this.$i18n.locale = language;
      this.currentLanguage = language;
    },

    getTabs() {
      const storedTabs = localStorage.getItem("formValidate");
      const storedTabs1 = localStorage.getItem("formVehicles");
      const storedTabs2 = localStorage.getItem("selectedProduct");

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
      if (!dateString || !/^\d{2}-\d{2}-\d{4}$/.test(dateString)) {
        console.error(
          "Formato de fecha inválido o cadena indefinida:",
          dateString
        );
        return dateString || "Fecha no disponible";
      }

      // Dividir la cadena en día, mes, año
      const [day, month, year] = dateString.split("-");

      // Retornar la fecha en formato YYYY-MM-DD
      return `${year}-${month}-${day}`;
    },
  },
};
</script>

<style scoped>
::selection {
  background-color: var(--primary-color);
  color: #fff;
}
</style>
