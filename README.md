# Suplementos Hub

Aplicación web monolítica desarrollada con **Laravel 12** para la gestión de catálogo de suplementos, con control de acceso por roles/permisos, administración de productos y categorías, y gestión de imágenes.

## Descripción

Suplementos Hub centraliza la operación de un catálogo de suplementos para distintos perfiles de usuario (administración y proveedores).
El sistema implementa autenticación, autorización basada en RBAC y un modelo de dominio orientado a:

- Categorías
- Productos
- Imágenes de producto

La solución está diseñada para ser escalable, mantenible y fácil de desplegar en entornos Linux.

## Características principales

- Autenticación de usuarios
- Autorización por roles y permisos (RBAC)
- CRUD de categorías
- CRUD de productos
- Asociación y gestión de imágenes de producto
- Paneles diferenciados por perfil de usuario
- Migraciones y seeders para versionado de datos
- Pipeline de assets con Vite
- Base de pruebas con Pest/PHPUnit

## Stack tecnológico

- **Backend:** PHP 8+ / Laravel 12
- **Frontend:** Blade, JavaScript, CSS, Vite
- **ORM:** Eloquent
- **Autorización:** spatie/laravel-permission
- **Testing:** Pest + PHPUnit
- **Base de datos:** MySQL/MariaDB (u otro motor soportado por Laravel)

## Arquitectura

- Patrón **MVC** con separación de responsabilidades
- Capa de servicios para lógica transversal (ej. procesamiento de imágenes)
- Persistencia relacional con migraciones versionadas
- Configuración desacoplada por entorno mediante variables de entorno
- Renderizado server-side con Blade

## Requisitos

- PHP 8+
- Composer
- Node.js + npm
- Base de datos relacional (MySQL/MariaDB)
- Extensiones PHP requeridas por Laravel

## Instalación y ejecución local

```bash
git clone <URL_DEL_REPO>
cd suplementos-hub

cp .env.example .env
composer install
npm install

php artisan key:generate
php artisan migrate --seed

npm run dev
php artisan serve
```

## Scripts útiles

```bash
# Ejecutar pruebas
php artisan test

# Compilar assets para producción
npm run build

# Limpiar/optimizar cachés
php artisan optimize:clear
php artisan optimize
```

## Despliegue (resumen)

1. Configurar `.env` de producción.
2. Instalar dependencias con optimización.
3. Ejecutar migraciones.
4. Compilar assets (`npm run build`).
5. Configurar permisos de escritura en storage/cache.
6. Publicar con Nginx/Apache + PHP-FPM.
7. Activar cachés de configuración/rutas/eventos.

## Calidad y mantenimiento

- Migraciones incrementales y reversibles
- Seeders para datos base
- Pruebas automatizadas para regresión
- Gestión centralizada de permisos para auditoría de acceso

## Licencia

Este proyecto se distribuye bajo la licencia que defina el repositorio.
