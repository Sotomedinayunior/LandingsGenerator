<template>
    <section class="lg:ml-64 p-4">
      
      <h2 class="font-bold text-3xl mb-2">Preguntas Frecuentes</h2>
      <p class="text-gray-600 mt-2 mb-7">¿Tienes preguntas sobre el funcionamiento de la aplicación?</p>
      <div class="space-y-4">
        <!-- Pregunta 1 -->
        <details class="group border border-gray-300 rounded-md p-4 transition-all">
          <summary class="flex justify-between items-center cursor-pointer text-lg font-medium text-gray-800">
            <span>¿Qué servicios ofrecemos?</span>
            <svg
              class="w-6 h-6 text-gray-500 group-open:rotate-180 transform transition-transform"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </summary>
          <p class="mt-4 text-gray-600 leading-relaxed">
            Ofrecemos una amplia gama de servicios que incluyen desarrollo web, diseño gráfico, marketing digital y más.
          </p>
        </details>
  
        <!-- Pregunta 2 -->
        <details class="group border border-gray-300 rounded-md p-4 transition-all">
          <summary class="flex justify-between items-center cursor-pointer text-lg font-medium text-gray-800">
            <span>¿Cómo puedo contactar al soporte?</span>
            <svg
              class="w-6 h-6 text-gray-500 group-open:rotate-180 transform transition-transform"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </summary>
          <p class="mt-4 text-gray-600 leading-relaxed">
            Puedes contactar al equipo de soporte mediante nuestro correo electrónico de soporte@empresa.com o a través del formulario de contacto en nuestra web.
          </p>
        </details>
  
        <!-- Pregunta 3 -->
        <details class="group border border-gray-300 rounded-md p-4 transition-all">
          <summary class="flex justify-between items-center cursor-pointer text-lg font-medium text-gray-800">
            <span>¿Qué métodos de pago aceptamos?</span>
            <svg
              class="w-6 h-6 text-gray-500 group-open:rotate-180 transform transition-transform"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </summary>
          <p class="mt-4 text-gray-600 leading-relaxed">
            Aceptamos pagos a través de tarjetas de crédito, PayPal y transferencias bancarias.
          </p>
        </details>
  
        <!-- Pregunta 4 -->
        <details class="group border border-gray-300 rounded-md p-4 transition-all">
          <summary class="flex justify-between items-center cursor-pointer text-lg font-medium text-gray-800">
            <span>¿Dónde están ubicadas nuestras oficinas?</span>
            <svg
              class="w-6 h-6 text-gray-500 group-open:rotate-180 transform transition-transform"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </summary>
          <p class="mt-4 text-gray-600 leading-relaxed">
            Nuestras oficinas están ubicadas en el centro de la ciudad, en la Avenida Principal #123, Edificio Corporativo.
          </p>
        </details>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: "FAQSection",
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos personalizados adicionales aquí si lo deseas */
  </style>
  