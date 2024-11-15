<template>
  <div v-if="landing">
    <NavComponents
      :logo="logoLanding"
      :logoTitle="LogoTitle"
      :colorPrimary="color1"
      :colorSecondary="color2"
      :defaultLanguage="currentLanguage"
      @language-change="changeLanguage"
    />
    <main class="grid grid-cols-2 gap-5 py-[45px]">
      <section class="py-11 px-5">
        <h2 class="text-2xl font-bold mb-4">{{ $t('overview') }}</h2>

        <div class="border rounded-lg p-4 bg-gray-100">
          <h2 class="text-lg font-semibold">{{ $t('order_details') }}</h2>
          <div class="flex flex-col">
            <h2 class="text-sm text-gray-700 my-5">{{ $t('date_location') }}</h2>
            <div class="flex items-center whitespace-nowrap">
              <h2 class="text-xs font-bold">{{ $t('pickup') }}</h2>
              <span class="text-xs ml-2">{{ Tabs1.place_of_departure }}</span>
              <img
                src="./asset/line.png"
                alt="line"
                width="40"
                height="30"
                class="mx-3"
              />
              <h2 class="text-xs font-bold ml-2">Return -</h2>
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
            <h2 class="text-sm text-gray-700 my-2">Vehicle</h2>
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
          <div class="flex flex-col">
            <h2 class="text-sm text-gray-700 my-3">Extras</h2>
            <h2 class="text-xs font-extrabold">{{ Tabs3.name }}</h2>
          </div>
        </div>
      </section>
      <section class="">
        <div class="max-w-md mx-auto p-5 bg-white">
          <h2 class="text-xl font-bold mb-4">Charges</h2>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Charges Summary</span>
              <span class="text-gray-600">US$180.00</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Additional Liability Service</span>
              <span class="text-gray-600">US$9.95</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Vehicle License Fee</span>
              <span class="text-gray-600">US$3.50</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Silla Extra Bebé</span>
              <span class="text-gray-600">US$20.00</span>
            </div>
            <div class="flex justify-between font-semibold">
              <span class="text-gray-700">Subtotal</span>
              <span class="text-gray-700">US$213.45</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">ITBIS (18%)</span>
              <span class="text-gray-600">US$38.42</span>
            </div>
            <div class="flex justify-between text-lg font-bold mt-4">
              <span>Total</span>
              <span>US$251.87</span>
            </div>
          </div>
        </div>
        <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg">
          <h2 class="text-xl font-semibold mb-4">Contact Information</h2>

          <form class="space-y-4" @submit.prevent="submitForm">
            <!-- Name Field -->
            <input
              type="text"
              v-model="name"
              required
              placeholder="Name"
              class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <input
              type="text"
              v-model="lastName"
              required
              placeholder="Last Name"
              class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <!-- Email Field -->
            <input
              type="email"
              placeholder="Email"
              required
              v-model="email"
              class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <!-- Phone Field -->
            <input
              type="phone"
              required
              placeholder="Phone/ Cellphone"
              class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <!-- Comment Field -->
            <textarea
              rows="4"
              placeholder="Algun comentario adicional"
              v-model="comment"
              class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>

            <!-- Information Text -->
            <p class="text-xs text-gray-500">
              <strong>IMPORTANT INFORMATION</strong> about your PREPAID
              reservation: prepaid rates are subject to the following
              cancellation and no-show fees. Please note that the cancellation
              fees listed below will never exceed the total prepaid amount:
            </p>

            <ul class="list-disc list-inside text-xs text-gray-500">
              <li>
                When booking is cancelled within 24 hours before the pickup
                time, a fee of $200.00 will be charged.
              </li>
              <li>
                When the booking is cancelled more than 24 hours before the
                pickup time, a fee of $100.00 will be charged.
              </li>
              <li>
                No refund for No-Show: No refund will be issued in case of
                failure to pick up your vehicle (no-show) or cancellation after
                scheduled pick up time.
              </li>
              <li>
                No refund for unused rental days: No refunds or credits will be
                issued for unused rental days (late pick up or early return)
                once the vehicle is rented.
              </li>
            </ul>

            <!-- Checkbox -->
            <div class="flex items-start mt-4">
              <input
                type="checkbox"
                id="accept"
                required
                class="mt-1 mr-2 focus:ring-blue-500 focus:border-blue-500"
              />
              <label for="accept" class="text-xs text-gray-600">
                I have read and accept the
                <a href="#" class="underline">rental information</a>, the
                <a href="#" class="underline">terms and conditions</a>, and the
                <a href="#" class="underline">privacy policy</a>, and I
                acknowledge that I am booking a prepaid rate, where the total
                rental price is immediately charged to the credit or debit card
                I provided. I am aware that certain
                <a href="#" class="underline">driver requirements</a> (e.g.,
                age),
                <a href="#" class="underline">payment requirements</a> (e.g.,
                debit cards, security hold/deposit), and
                <a href="#" class="underline">territorial restrictions</a>
                apply.
              </label>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              class="w-full bg-black text-white font-semibold py-3 rounded-lg hover:bg-gray-800"
            >
              Reservar
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
const url =  import.meta.env.VITE_API_URL  ;
import NavComponents from "./components/NavComponents.vue";
export default {
  components: {
    NavComponents,
  },
  data() {
    return {
      message: "Calculando información...",
      currentLanguage: "en",
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
    const timeOfDeparture24 = formData.time_of_departure ? this.convertTo24Hour(formData.time_of_departure) : null;
    const timeOfArrival24 = formData.time_of_arrival ? this.convertTo24Hour(formData.time_of_arrival) : null;

    // Asegúrate de que 'name_landing' esté en formData
    const nameLanding = formData.name_landing || "Unknown Landing"; // Valor por defecto si no existe

    // Aquí se agrega la URL del logo de la landing
    const urlLanding = this.logoLanding || "";  // Si no hay logo, se envía una cadena vacía

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
      url_landing: urlLanding,  // Se agrega la URL del logo de la landing
    };

    // Hacer la solicitud para crear la reserva
    axios.post(`${url}/reservations`, reservationData)
      .then(response => {
        console.log("Reservación creada:", response.data);

        // Limpiar los datos del localStorage
        localStorage.removeItem("formValidate");
        localStorage.removeItem("formVehicles");
        localStorage.removeItem("selectedProduct");
        localStorage.setItem("NameUser", this.name);

        // Redirigir a la página de agradecimiento
        this.$router.push({ name: "thanks-you" });
      })
      .catch(error => {
        console.error("Error al crear la reservación:", error);
      });
  } else {
    console.error("No se encontraron datos en localStorage.");
  }
},



    getVehicles() {
      const NameLandingId = this.$route.params.name;

      axios
        .get(`${url}/publicLanding/${NameLandingId}`)
        .then((response) => {
          this.landing = response.data.landing;
          this.logoLanding = this.landing.logo;
          this.LogoTitle = this.landing.name;
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

<style scoped></style>
