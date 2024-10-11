# LandingsGenerator

## Descripción

Este proyecto es una **aplicación monolítica** construida utilizando **Vue.js 3** en el frontend y **Laravel 11** en el backend. Su objetivo principal es generar **landings personalizadas** enfocadas en la **renta de vehículos**. La aplicación ofrece una solución integral que permite gestionar vehículos, reservaciones y agentes, todo dentro de una plataforma escalable y eficiente, con soporte para **roles de usuarios** y funcionalidades **multi-idioma**.

## Tecnologías Utilizadas

### Frontend:
- **Vue.js 3**: Framework JavaScript moderno que permite la creación de interfaces de usuario altamente reactivas.
- **Vite**: Herramienta de compilación ultrarrápida que mejora la experiencia de desarrollo y construcción de la aplicación.
- **Tailwind CSS**: Framework de utilidades CSS para el diseño de interfaces de usuario responsivas y personalizables.
- **Vuex**: Biblioteca oficial de manejo de estado para Vue.js, utilizada para gestionar el estado compartido en la aplicación, permitiendo una arquitectura centralizada y eficiente para controlar los datos y su flujo entre componentes.
- **Vue Meta**: Plugin que facilita la gestión de las etiquetas meta del documento en una aplicación Vue, permitiendo configurar dinámicamente el contenido de SEO como títulos de página y meta descripciones basados en la ruta o la vista activa.

### Backend:
- **Laravel 11**: Framework de PHP que sigue el patrón MVC (Modelo-Vista-Controlador) para construir aplicaciones web robustas y escalables.
- **Laravel Sanctum**: Proporciona autenticación simple basada en tokens para SPAs y APIs.
- **Spatie Laravel Permission**: Sistema avanzado de gestión de roles y permisos dentro de la aplicación.

### Internacionalización (i18n):
- **i18n**: Implementación completa de un sistema multi-idioma que adapta la aplicación a diferentes regiones y usuarios globales. Esto permite que el contenido y la interfaz se ajusten automáticamente en función del idioma preferido por el usuario.

### Gestión de Roles y Permisos:
- Funcionalidad avanzada para manejar diferentes niveles de acceso mediante roles de usuario y permisos, garantizando un control detallado dentro de la plataforma.

## Funcionalidades Principales

- **Generación Dinámica de Landings**: La aplicación permite la creación automática de landings personalizadas para la renta de vehículos, mostrando información sobre la flota disponible, precios y detalles de contacto.
- **Sistema de Reservaciones**: Los usuarios pueden consultar, crear y gestionar reservas de vehículos desde cualquier landing.
- **Soporte Multi-Idioma**: Gracias a la integración de i18n, la aplicación puede cambiar dinámicamente de idioma, brindando una experiencia localizada para diferentes usuarios.
- **Gestión de Roles**: Sistema robusto que permite definir distintos tipos de usuarios como administradores, usuarios y agentes, con permisos diferenciados.
- **Interfaz Responsive**: La aplicación está optimizada para dispositivos móviles y de escritorio, garantizando una experiencia de usuario fluida en cualquier dispositivo.

## Dependencias y Herramientas

### Scripts de NPM:
```json
{
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "axios": "^1.7.3",
        "laravel-vite-plugin": "^1.0",
        "sass": "^1.79.5",
        "sass-loader": "^16.0.0",
        "vite": "^5.0"
    },
    "dependencies": {
        "@headlessui/vue": "^1.7.22",
        "@heroicons/vue": "^2.1.5",
        "@vitejs/plugin-vue": "^5.1.2",
        "tailwindcss": "^3.4.9",
        "vue": "^3.4.35",
        "vue-i18n": "^9.14.0",
        "vue-loader": "^17.3.1",
        "vue-meta": "^3.0.0-alpha.2",
        "vue-router": "^4.4.2",
        "vuex": "^4.1.0"
    }
}
