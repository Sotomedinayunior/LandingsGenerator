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
    <main class="grid grid-cols-2 gap-5 py-[70px]">
      <section class="py-11 px-5">
        <h2 class="text-2xl font-semibold mb-4">Overview</h2>

        <div class="border rounded-lg p-4 bg-gray-100">
          <h2 class="text-lg font-semibold">Order Details</h2>
          <div class="flex flex-col">
            <h2 class="text-sm text-gray-700 my-5">Date & Location</h2>
            <div class="flex items-center whitespace-nowrap">
              <h2 class="text-xs font-bold">Pickup -</h2>
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
              placeholder="Name and Last Name"
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
const url = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
import NavComponents from "./components/NavComponents.vue";
export default {
  components: {
    NavComponents,
  },
  data() {
    return {
      message: "Hola Mundo",
      currentLanguage: "en",
      name: '',
      lastName: '', // Asegúrate de definir lastName
      email: '',
      comment: '',
      phone: '',
      
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
    submitForm() {
      // Recuperar los datos del viaje desde localStorage
      const storedVehicle = localStorage.getItem("formVehicles");
      const storedFormData = localStorage.getItem("formValidate");

      // Asegurarse de que los datos existen
      if (storedVehicle && storedFormData) {
        const vehicleData = JSON.parse(storedVehicle);
        const formData = JSON.parse(storedFormData);

        // Preparar el objeto que se enviará al servidor
        const reservationData = {
          id_vehicle: vehicleData.id_vehicle,  // ID del vehículo
          id_landing: formData.id_landing,     // ID de la landing
          name: this.name,                      // Nombre del usuario
          last_name: this.lastName,             // Apellido del usuario
          email: this.email,                    // Email del usuario
          description: this.comment,            // Comentario adicional
          place_of_departure: formData.place_of_departure, // Lugar de salida
          arrival_place: formData.arrival_place, // Lugar de llegada
          number_of_persons: formData.number_of_persons, // Número de personas
          date_of_departure: formData.date_of_departure, // Fecha de salida
          time_of_departure: formData.time_of_departure, // Hora de salida
          date_of_arrival: formData.date_of_arrival, // Fecha de llegada
          time_of_arrival: formData.time_of_arrival, // Hora de llegada
        };

        // Realizar la solicitud a la API para crear la reserva
        axios.post(`${url}/reservations`, reservationData)
          .then(response => {
            console.log("Reservación creada:", response.data);
            // Aquí puedes manejar la respuesta, como redirigir o mostrar un mensaje
          })
          .catch(error => {
            console.error("Error al crear la reservación:", error);
            // Aquí puedes manejar el error, mostrar un mensaje al usuario, etc.
          });
      } else {
        console.error("No se encontraron datos en localStorage.");
        // Manejar el caso donde no hay datos disponibles
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

          console.log(`Info de los vehicles`, this.vehicles, this.logoLanding, this.color1, this.color2);
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
      // Verificar si la cadena de fecha está definida y tiene el formato correcto
      if (!dateString || !/^\d{2}-\d{2}-\d{4}$/.test(dateString)) {
        console.error("Formato de fecha inválido o cadena indefinida:", dateString);
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
