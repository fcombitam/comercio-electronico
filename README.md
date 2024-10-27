# Comercio Electronico

Este documento proporciona una guía de instalación para el proyecto de comercio electrónico desarrollado en Laravel, así como una introducción general al funcionamiento y uso del sistema. Sirve como manual de usuario para comprender la estructura del proyecto, los requisitos previos, las instrucciones paso a paso para la configuración inicial y la administración básica de la plataforma. Aquí encontrarás la información necesaria para instalar el proyecto correctamente, realizar ajustes de configuración y aprovechar las funcionalidades principales de la tienda en línea.

## Instalacion y ejecucion del proyecto

A continuación se describe el proceso paso a paso para ejecutar un proyecto Laravel con Docker.

### Requisitos Previos
1. **Docker**: Asegúrate de tener Docker instalado y en funcionamiento. Puedes descargarlo desde [Docker](https://www.docker.com/products/docker-desktop).
2. **Git**: Necesitarás Git para clonar el repositorio. Descárgalo desde [Git](https://git-scm.com/downloads).
3. **Composer (Opcional)**: Aunque Docker instalará las dependencias, tener Composer configurado localmente puede ser útil en algunos casos. Descárgalo desde [Composer](https://getcomposer.org/download/).

### Paso a Paso para Ejecutar el Proyecto

1. **Clonar el Repositorio**
   
   Clona el repositorio en tu máquina local con el siguiente comando:
   ```bash
   git clone https://github.com/tu-usuario/tu-repositorio.git
   cd tu-repositorio

2. **Copiar el Archivo `.env`**

   Laravel usa un archivo `.env` para almacenar configuraciones de entorno. Copia el archivo de ejemplo:
   ```bash
   cp .env.example .env

3. **Construir los Contenedores con Docker Compose**

   Ejecuta el siguiente comando para construir los contenedores:
   ```bash
   docker-compose up -d --build

4. **Generar la Clave de la Aplicación**

   Ejecuta el siguiente comando para generar una clave de aplicación:
   ```bash
   docker-compose exec app php artisan key:generate

5. **Ejecutar las Migraciones y Semillas de Base de Datos**

   Con las configuraciones de base de datos listas, ejecuta las migraciones y las semillas para crear y poblar las tablas:
   ```bash
   docker-compose exec app php artisan migrate --seed