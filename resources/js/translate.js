import { createI18n } from 'vue-i18n'

// Cargar los mensajes traducidos
const messages = {
  en: {
    welcome: 'Welcome',
    overview:'overview',
    vehicle:'vehicle',
    about_us:'About Us',
    Rent:'Rent your vehicle',
    Find:'Find your ideal vehicle',
    selected_location:'Select a location',
    add_different_return_location:"Add a different return location",
    seats: "Seats",
    return_date: "Return Date",
    departure_date: "Departure date",
    pick_up_and_return:"PickUp & Return",
    About_vehicle:'Our vehicles',
    no_vehicle:'No vehicles available',   
    how_it_works:'How it works',
    select_vehicle:'Select your car',
    browser:'Browse our fleet and choose the one that best suits your needs.',
    book_you:'Fill out the booking form with your details and trip dates.',
    book_you_ride:'Book Your Ride',
    enjoy:'Enjoy your trip!',
    enjoy_text:'Drive safely and enjoy your trip! Return the car at your convenience.',
    footer_text:'.All rights reserved',
 
  },
  es: {
    welcome: 'Bienvenido',
    overview:'visión general',
    vehicle:'vehículo',
    about_us:'Acerca de nosotros',
    
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
