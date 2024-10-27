# Comercio Electronico

Este documento proporciona una guía de instalación para el proyecto de comercio electrónico desarrollado en Laravel, así como una introducción general al funcionamiento y uso del sistema. Sirve como manual de usuario para comprender la estructura del proyecto, los requisitos previos, las instrucciones paso a paso para la configuración inicial y la administración básica de la plataforma. Aquí encontrarás la información necesaria para instalar el proyecto correctamente, realizar ajustes de configuración y aprovechar las funcionalidades principales de la tienda en línea.

## Instalacion y ejecucion del proyecto

A continuación se describe el proceso paso a paso para ejecutar un proyecto Laravel con Docker.

### Requisitos Previos
1. **Docker**: Asegúrate de tener Docker instalado y en funcionamiento. Puedes descargarlo desde [Docker](https://www.docker.com/products/docker-desktop).
2. **Git**: Necesitarás Git para clonar el repositorio. Descárgalo desde [Git](https://git-scm.com/downloads).

### Paso a Paso para Ejecutar el Proyecto

1. **Clonar el Repositorio**
   
   Clona el repositorio en tu máquina local con el siguiente comando:
      ```bash
      git clone https://github.com/fcombitam/comercio-electronico.git
      cd comercio-electronico

2. **Copiar el Archivo `.env`**

   Laravel usa un archivo `.env` para almacenar configuraciones de entorno. O puedes crear crear el archivo manualmente compiando todo el contenido de .env.example a .env en la raiz.
      ```bash
      cp .env.example .env

3. **Construir los Contenedores con Docker Compose**

   Ejecuta el siguiente comando para construir los contenedores:
   ```bash
   docker-compose up -d --build

4. **Instalar Dependencias de PHP con Composer**

   Una vez que el contenedor esté levantado, instala las dependencias de Laravel ejecutando el siguiente comando dentro del contenedor:
      ```bash
      docker-compose exec app composer install

5. **Generar la Clave de la Aplicación**

   Ejecuta el siguiente comando para generar una clave de aplicación:
      ```bash
      docker-compose exec app php artisan key:generate

6. **Ejecutar las Migraciones y Semillas de Base de Datos**

   Con las configuraciones de base de datos listas, ejecuta las migraciones y las semillas para crear y poblar las tablas:
      ```bash
      docker-compose exec app php artisan migrate --seed

7. **Compilar los Recursos Frontend**

   Ejecuta paquetes de frontend:
      ```bash
      docker-compose exec app npm install
      docker-compose exec app npm run build

8. **Acceder a la Aplicación**

   Con todo listo, puedes acceder a tu aplicación en `http://localhost:8000/`.