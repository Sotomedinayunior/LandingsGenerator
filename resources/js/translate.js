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
    footer_text:'.All rights reserved'
  },
  es: {
    welcome: 'Bienvenido',
    overview:'visión general',
    vehicle:'vehículo',
    about_us:'Acerca de nosotros',
    
    Rent:'Renta tu vehiculó',
    Find:'Busca tu vehiculo ideal',
    pick_up_and_return:"Recogida y devolución",
    selected_location:'Selecciona una ubicación',
    pick_up_and_retur: "Recogida y Devolución",
    add_different_return_location:"Agregar una ubicación de retorno diferente",
    seats: "Asientos",
    departure_date: "Fecha de salida",
    return_date: "Fecha de Retorno",
    About_vehicle:'Nuestros vehiculos',
    no_vehicle:'No hay vehiculos disponibles',
    footer_text:' .Todos los derechos reservados'
    
  }
}

const i18n = createI18n({
  locale: 'en', // idioma por defecto
  fallbackLocale: 'en', // idioma alternativo
  messages,
})

export default i18n
