import { createI18n } from 'vue-i18n'

// Cargar los mensajes traducidos
const messages = {
  en: {
    welcome: 'Welcome',
    capacity: 'Capacity',

    search_placeholder: 'Search by name',
    pickup: 'Pickup -',
    date_location: "Date & Location",
    return: "Return",
    vehicle: "Vehicle",
    review: 'Review',
    charges: "Charges",
    charges_summary: "Charges Summary",
    additional_liability_service: "Additional Liability Service",
    vehicle_license_fee: "Vehicle License Fee",
    subtotal: "Subtotal",
    tax_itbis: "ITBIS (18%)",
    total: "Total",
    contact_information: "Contact Information",
    important_information: "IMPORTANT INFORMATION",
    prepaid_reservation_info:
      "about your PREPAID reservation: prepaid rates are subject to the following cancellation and no-show fees. Please note that the cancellation fees listed below will never exceed the total prepaid amount:",
    cancellation_within_24_hours:
      "When booking is cancelled within 24 hours before the pickup time, a fee of $200.00 will be charged.",
    cancellation_more_than_24_hours:
      "When the booking is cancelled more than 24 hours before the pickup time, a fee of $100.00 will be charged.",
    no_show_no_refund:
      "No refund for No-Show: No refund will be issued in case of failure to pick up your vehicle (no-show) or cancellation after scheduled pick up time.",
    unused_rental_days_no_refund:
      "No refund for unused rental days: No refunds or credits will be issued for unused rental days (late pick up or early return) once the vehicle is rented.",


      accept_terms: "I have read and accept the",
      rental_information: "rental information",
      terms_conditions: "terms and conditions",
      privacy_policy: "privacy policy",
      prepaid_rate_acknowledgment:
        ", and I acknowledge that I am booking a prepaid rate, where the total rental price is immediately charged to the credit or debit card I provided. I am aware that certain",
      driver_requirements: "driver requirements",
      payment_requirements: "payment requirements",
      territorial_restrictions: "(e.g., debit cards, security hold/deposit), and territorial restrictions apply.",
      representative_contact: "One of our representatives will be in touch with you shortly.",
      accept: "Accept",






    all: 'All',
    vehicle_type: 'Vehicle Type',
    luggage: 'Luggage',
    people: 'People',
    suitcase: 'Suitcase',
    people_2: '2 People',
    people_4: '4 People',
    people_5: '5 People',
    people_7: '7 People',
    people_9: '9 People',
    luggage_2: '2 Suitcases',
    luggage_4: '4 Suitcases',
    luggage_6: '6 Suitcases',
    transmission_any: 'Any transmission',
    transmission_manual: 'Manual',
    transmission_semi_automatic: 'Semi-Automatic',
    transmission_automatic: 'Automatic',
    features: 'Features',
    reset_filters: 'Reset Filters',
    no_vehicles_found: 'No vehicles found with the applied filters.',
    brand: 'Brand',
    price_per_day: 'Price per day',
    special_features: 'Special features',
    features: 'Features',
    select: 'Select',
    heated_seats: 'Heated seats',
    protection_products: 'Protection Products',
    overview: 'Overview',
    order_details: 'Order Details',
    date_location: 'Date & Location',
    vehicle:'vehicle',
    about_us:'About Us',
    Rent:'Rent your vehicle',
    Find:'Find your ideal vehicle',
    selected_location:'Select a location',
    any_capacity: 'Any capacity',
    back: 'Back',
    continue: 'Continue',
    add_product: '+ Add',
    personal_effects_coverage: 'Personal effects coverage',
    per_day: '/per day',
    equipment: 'Equipment',
    secure_extra_equipment: 'Secure some extra equipment',
    quick_search: "Quick Search",
    add_extras: 'Add extras',
    safer_trip: 'Safer and more protected trip',
    damage_disclaimer: 'Damage disclaimer',
    more_info: 'More info',
    add_different_return_location:"Add a different return location",
    seats: "Seats",
    return_date: "Return Date",
    reserve: "Reserve",
    pickup: "Pickup",
    select_vehicle: 'Select a Vehicle',
    name: "Name",
    last_name: "Last Name",
    email: "Email",
    phone: "Phone/ Cellphone",
    additional_comment: "Any additional comment",
    calculating_information: "Calculating information...",




    
    noFeatures: "No features for this vehicle",
    
    departure_date: "Departure date",
    pick_up_and_return:"PickUp & Return",
    About_vehicle:'Our vehicles',
    no_vehicle:'No vehicles available',   
    how_it_works:'How it works',
    select_vehicle:'Select your car',
    browser:'Browse our fleet and choose the one that best suits your needs.',
    book_you:'Fill out the booking form with your details and trip dates.',
    book_you_ride:'Book Your Ride',
    back: "Back",
    not_yet: 'Not yet',


    enjoy:'Enjoy your trip!',
    enjoy_text:'Drive safely and enjoy your trip! Return the car at your convenience.',
    footer_text:'.All rights reserved',
 
  },
  es: {
    welcome: 'Bienvenido',
    search_placeholder: 'Buscar por nombre',
    capacity: 'Capacidad',
    all: 'Todas',
    reserve: 'Reservar',
    date_location: 'Fecha y Ubicación',
    pickup: 'Recogida',
    return: "Devolución",
    vehicle: "Vehículo",
    not_yet: 'Aún no',
    select_vehicle: 'Selecciona un Vehículo',
    review: 'Revisión',
    charges: "Cargos",
    charges_summary: "Resumen de Cargos",
    additional_liability_service: "Servicio de Responsabilidad Adicional",
    vehicle_license_fee: "Tarifa de Licencia del Vehículo",
    subtotal: "Subtotal",
    tax_itbis: "ITBIS (18%)",
    total: "Total",
    contact_information: "Información de Contacto",
    name: "Nombre",
    last_name: "Apellido",
    email: "Correo Electrónico",
    phone: "Teléfono / Celular",
    additional_comment: "Algún comentario adicional",
    important_information: "INFORMACIÓN IMPORTANTE",
    prepaid_reservation_info:
      "sobre su reserva PREPAGADA: las tarifas prepagadas están sujetas a las siguientes tarifas de cancelación y no presentación. Tenga en cuenta que las tarifas de cancelación que se enumeran a continuación nunca excederán el monto total prepagado:",
    cancellation_within_24_hours:
      "Cuando la reserva se cancela dentro de las 24 horas antes de la hora de recogida, se cobrará una tarifa de $200.00.",
    cancellation_more_than_24_hours:
      "Cuando la reserva se cancela con más de 24 horas de anticipación a la hora de recogida, se cobrará una tarifa de $100.00.",
    no_show_no_refund:
      "Sin reembolso por no presentarse: no se emitirá ningún reembolso en caso de no recoger el vehículo (no presentarse) o cancelación después de la hora programada de recogida.",
    unused_rental_days_no_refund:
      "Sin reembolso por días de alquiler no utilizados: no se emitirán reembolsos ni créditos por días de alquiler no utilizados (recogida tardía o devolución anticipada) una vez que se alquile el vehículo.",

      accept_terms: "He leído y acepto la",
      rental_information: "información de alquiler",
      terms_conditions: "términos y condiciones",
      privacy_policy: "política de privacidad",
      prepaid_rate_acknowledgment:
        ", y reconozco que estoy reservando una tarifa prepaga, donde el precio total del alquiler se carga de inmediato a la tarjeta de crédito o débito que proporcioné. Soy consciente de que se aplican ciertos",
      driver_requirements: "requisitos del conductor",
      payment_requirements: "requisitos de pago",
      territorial_restrictions:
        "(por ejemplo, tarjetas de débito, retención de seguridad/depósito) y restricciones territoriales.",
      calculating_information: "Calculando información...",
      accept: 'Aceptar',
      representative_contact: "En breve uno de nuestros representantes estarán comunicándote.",









    vehicle_type: 'Tipo de Vehículo',
    luggage: 'Equipaje',
    any_capacity: 'Cualquier capacidad',
    people_2: '2 Personas',
    people_4: '4 Personas',
    people_5: '5 Personas',
    people_7: '7 Personas',
    people_9: '9 Personas',
    luggage_2: '2 Maletas',
    luggage_4: '4 Maletas',
    luggage_6: '6 Maletas',
    transmission_any: 'Cualquier transmisión',
    transmission_manual: 'Manual',
    transmission_semi_automatic: 'Semi-Automática',
    transmission_automatic: 'Automática',
    features: 'Características',
    reset_filters: 'Restablecer Filtros',
    no_vehicles_found: 'No se encontraron vehículos con los filtros aplicados.',
    brand: 'Marca',
    price_per_day: 'Precio por día',
    
    noFeatures: "No hay características para este vehículo",
    
    special_features: 'Características especiales',
    select: 'Seleccionar',
    heated_seats: 'Asientos calefaccionados',
    back: "Atrás",

    add_extras: 'Agregar extras',
    protection_products: 'Productos de Protección',
    safer_trip: 'Viaje más seguro y protegido',
    damage_disclaimer:'Exención de responsabilidad por daños',
    more_info: 'Más info',
    overview:'visión general',
    vehicle:'vehículo',
    date_location: 'Fecha y ubicación',


    about_us:'Acerca de nosotros',
    quick_search: "Búsqueda Rápida",
    back: 'Atrás',
    continue: 'Continuar',
    add_product: '+ Agregar',
    personal_effects_coverage: 'Cobertura de efectos personales',
    per_day: '/por día',
    equipment: 'Equipamiento',
    secure_extra_equipment: 'Asegure algún equipamiento extra',
    overview: 'Resumen',
    order_details: 'Detalles del pedido',








    
    Rent:'Renta tu vehiculó',
    Find:'Busca tu vehiculo ideal',
    pick_up_and_return:"Recogida y devolución",
    selected_location:'ubicación',
    pick_up_and_retur: "Recogida y Devolución",
    add_different_return_location:"ubicación diferente",
    seats: "Asientos",
    departure_date: "Fecha de salida",
    return_date: "Fecha de Retorno",
    About_vehicle:'Nuestros vehiculos',
    no_vehicle:'No hay vehiculos disponibles',
    how_it_works:'Como funciona',
    select_vehicle:'Selecciona tu vehiculo',
    browser:'Navegue por nuestra flota y elija la que mejor se adapte a sus necesidades.',
    book_you_ride:'Reserva tu viaje',
    book_you:'Complete el formulario de reserva con sus datos y fechas de viaje.',
    enjoy:'¡Disfruta de tu viaje!',
    enjoy_text:'¡Conduce con seguridad y disfruta de tu viaje! Devuelve el coche a tu conveniencia.',

    footer_text:' .Todos los derechos reservados'
    
  }
}

const i18n = createI18n({
  locale: 'en', // idioma por defecto
  fallbackLocale: 'en', // idioma alternativo
  messages,
})

export default i18n
