# LandingsGenerator
[![LandingsGenerator Logo](https://chezaad.com/wp-content/uploads/2021/05/chezaad-new-logo-regular-v2.png)](https://chezaad.com/)

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

## Instalación

### Instalación del frontend (Vue.js 3)

1. **Instalar dependencias de npm**:
    ```bash
    npm install
    ```

2. **Comandos npm**:
    - Para entorno de desarrollo:
      ```bash
      npm run dev
      ```
    - Para construir el proyecto:
      ```bash
      npm run build
      ```

### Dependencias principales de npm:
- **axios**: `npm install axios`
- **laravel-vite-plugin**: `npm install laravel-vite-plugin`
- **sass**: `npm install sass`
- **sass-loader**: `npm install sass-loader`
- **vite**: `npm install vite`
- **@headlessui/vue**: `npm install @headlessui/vue`
- **@heroicons/vue**: `npm install @heroicons/vue`
- **@vitejs/plugin-vue**: `npm install @vitejs/plugin-vue`
- **tailwindcss**: `npm install tailwindcss`
- **vue**: `npm install vue`
- **vue-i18n**: `npm install vue-i18n`
- **vue-loader**: `npm install vue-loader`
- **vue-meta**: `npm install vue-meta`
- **vue-router**: `npm install vue-router`
- **vuex**: `npm install vuex`

### Instalación del backend (Laravel 11)

1. **Instalar dependencias de Composer**:
    ```bash
    composer install
    ```

2. **Dependencias principales de Composer**:
    - **laravel/sanctum**: `composer require laravel/sanctum`
    - **spatie/laravel-permission**: `composer require spatie/laravel-permission`
