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
    About_vehicle:'Our vehicles',
    no_vehicle:'No vehicles available',
    footer_text:' .All rights reserved'
  },
  es: {
    welcome: 'Bienvenido',
    overview:'visión general',
    vehicle:'vehículo',
    about_us:'Acerca de nosotros',
    Rent:'Renta tu vehiculó',
    Find:'Busca tu vehiculo ideal',
    selected_location:'Selecciona una ubicación',
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
