# Comercio Electronico

Este documento proporciona una guía de instalación para el proyecto de comercio electrónico desarrollado en Laravel, así como una introducción general al funcionamiento y uso del sistema. Sirve como manual de usuario para comprender la estructura del proyecto, los requisitos previos, las instrucciones paso a paso para la configuración inicial y la administración básica de la plataforma. Aquí encontrarás la información necesaria para instalar el proyecto correctamente, realizar ajustes de configuración y aprovechar las funcionalidades principales de la tienda en línea.

# Índice

1. [Instalacion y ejecucion del proyecto](#instalacion-y-ejecucion-del-proyecto)
   - [Requisitos previos](#requisitos-previos)
   - [Paso a paso para ejecutar el Proyecto](#paso-a-paso-para-ejecutar-el-proyecto)
2. [Manual de usuario](#manual-de-usuario)
   - [Administrador](#administrador)
   - [Cliente](#cliente)
3. [Rutas api](#rutas-api)
   - [Coleccion de postman Json](#coleccion-de-postman-json)
   - [Rutas](#rutas)
4. [Observaciones Finales](#observaciones-finales)

## Instalacion y ejecucion del proyecto

A continuación se describe el proceso paso a paso para ejecutar un proyecto Laravel con Docker.

### Requisitos previos
1. **Docker**: Asegúrate de tener Docker instalado y en funcionamiento. Puedes descargarlo desde [Docker](https://www.docker.com/products/docker-desktop).
2. **Git**: Necesitarás Git para clonar el repositorio. Descárgalo desde [Git](https://git-scm.com/downloads).

### Paso a Paso para ejecutar el Proyecto

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
      docker-compose exec app php artisan migrate:fresh --seed

7. **Compilar los Recursos Frontend**

   Ejecuta paquetes de frontend:
      ```bash
      docker-compose exec app npm install
      docker-compose exec app npm run build

8. **Acceder a la Aplicación**

   Con todo listo, puedes acceder a tu aplicación en [http://localhost:8000/](http://localhost:8000/).


## Manual de usuario

[Modelo Relacional](https://drive.google.com/file/d/1Ne-2AAI6gTYXvJTc4ByteCui4mStQD-4/view?usp=sharing)

Comercio-Electronico es un proyecto compuesto por dos roles principales: administrador y cliente.

A rasgos generales es un pequeño comercio donde el administrador podra gestionar productos, clientes y ordenes realizadas. El cliente podra agregar productos al carrito,hacer compras y gestionar sus ordenes realizadas. (solo disponibles los productos activos por el administrador, inicialmente todos los productos estan activos).

En el [home](http://localhost:8000/) vemos diferentes carouseles de categorias con productos aleatorios de la misma. (categorias gestionables por el admin). Ademas en la parte superior tenemos un buscador de productos por nombre de producto.

Adentro de cada producto vemos la informacion detallada y la opcion de agregar al carrito.

### Administrador

El administrador posee la gestion de los modulos: Ordenes, Clientes, Categorias y Productos.

[Inicia sesion](http://localhost:8000/login) con el correo `admin@example.com` y la contraseña: `password`.

1. **[Ordenes](http://localhost:8000/orders)**
   1.1 **index**
      Vemos una tabla paginada con los datos de ordenes realizadas, en la parte superior tenemos unos filtros como un buscador por nombre y correo de cliente y un filtro de estados, podemos dar en buscar con los filtros seleccionados, tambien podemos limpiar filtros y generar un reporte de excel que mantendra los filtros seleccionados.

      En la tabla al final de cada registro vemos una opcion de ver detalles de la orden en el boton `Detalles` donde podemos ver los detalles de esa orden especifica.

2. **[Clientes](http://localhost:8000/customers)**
   2.1 **index**
      Vemos una tabla paginada con los datos de los clientes registrados, en la parte superior tenemos unos filtros como un buscador por nombre y correo de cliente, podemos dar en buscar con la busqueda escrita, tambien podemos limpiar filtros y generar un reporte de excel que mantendra los filtros seleccionados.

      En la tabla al final de cada registro vemos una opcion de ver detalles del cliente en el boton `Detalles` donde podemos ver los detalles de ese cliente como las ordenes realizadas con sus respectivos productos.

      nota: guarda un correo para ingresar despues como cliente.

3. **[Categorias](http://localhost:8000/categories)**
   3.1 **index**
      Vemos una tabla paginada con los datos de las categorias disponibles, en la parte superior tenemos unos filtros como un buscador por nombre de categoria, podemos dar en buscar con la busqueda escrita, tambien podemos limpiar filtros.

      En la tabla al final de cada registro vemos una opcion de ver detalles de la categoria en el boton `Detalles` donde podemos ver los detalles de esa categoria como los productos relacionados y al final una opcion para modificar el nombre de la categoria.

   3.2 **crear**
      En la parte superior derecha de la tabla principal, vemos un boton llamado `Crear Categoria` que nos mostrara una ventana modal solicitando un nombre para nuestra nueva categoria.

4. **[Productos](http://localhost:8000/products)**
   4.1 **index**
      Vemos una tabla paginada con los datos de los productos registrados, en la parte superior tenemos unos filtros como un buscador por nombre y categoria de producto, podemos dar en buscar con la busqueda y filtro, tambien podemos limpiar filtros y generar un reporte de excel que mantendra los filtros seleccionados.

      En la tabla al final de cada registro vemos una opcion de ver detalles del producto en el boton `Detalles` donde podemos ver los detalles de ese producto, como las ordenes en las que ha estado vendido, cantidad y precio al momento de la compra.

   4.2 **crear**
      En la parte superior derecha de la tabla principal, vemos un boton llamado `Crear Producto` que nos llevara a un formulario para crear nuestro producto, si el estado es inactivo no se mostrara en el catalogo, todos los campos son requeridos.

   4.3 **editar**
      En la tabla index al final de cada registro vemos el boton `Editar` donde podemos editar la informacion del producto, si el estado es inactivo no se mostrara en el catalogo, todos los campos son requeridos.

Puedes cerrar sesion para continuar con el sistema.

### Cliente

El cliente posee la gestion de: carrito, compras.

Inicia sesion con el correo que guardaste mientras revisabas el apartado de cliente. [Inicia sesion](http://localhost:8000/login) con el correo guardado y la contraseña: `password`.

En el [home](http://localhost:8000/) vemos diferentes carouseles de categorias con productos aleatorios de la misma. (categorias gestionables por el admin). Ademas en la parte superior tenemos un buscador de productos por nombre de producto.

Adentro de cada producto ([detalle producto](http://localhost:8000/detail/206)) vemos la informacion detallada y la opcion de agregar al carrito.

1. **[Compras](http://localhost:8000/orders)**
   1.1 **index**
      Vemos una tabla con registros de compras realizadas, en la parte podemos generar un reporte de excel.

      En la tabla al final de cada registro vemos una opcion de ver detalles de la compra en el boton `Detalles` donde podemos ver los detalles de esa compra especifica.

2. **[Carrito](http://localhost:8000/cart)**
   2.1 **carrito**
      Vemos una parrilla con los productos que hacen parte de nuestro carrito, podemos eliminar el carrito, comprarlo y eliminar items del carrito

## Rutas api

Para demostrar destreza en el desarrollo de Api's he desarrollado una serie de funcionalidades para consumir utilizando `postman`, estas Api's fueron desarrolladas con Laravel Sanctum.

### Coleccion de postman Json.

[Descarga la coleccion de postan aca](https://drive.google.com/file/d/14e2h0n6CDQztjLeNGhzEVRY3zpyJ57IZ/view?usp=sharing)

Importala en tu postman, dispondras de 3 peticiones.

### Rutas

La unica ruta que funciona sin autenticar es la de autenticacion donde obtendremos un bearer token que nos servira para realizar las otras peticiones.

1. **Autenticacion**

   Esta api nos servira para obtener el bearer token y autenticarnos con sanctum.

   Peticion:

      ```json
      {
         "METHOD": "POST",
         "URL": "http://localhost:8000/api/generate-token",
         "AUTHORIZATION": "NONE"
      }

   Body:

      ```json
      {
         "email": "admin@example.com",
         "password": "password"
      }

   Respuesta Exitosa:

      ```json
      {
         "code": "200",
         "message": "Informacion Correcta, No olvides usar este bearer token para autenticarte en las demas rutas Api,DESARROLLADO CON LARAVEL SANCTUM",
         "accessToken": "BEARERTOKEN",
         "token_type": "Bearer"
      }

   DEBES GUARDAR EL BEARER TOKEN (accessToken) PARA PODER AUTENTICARTE EN LAS DEMAS PETICIONES

2. **Listar Productos**

   Esta api nos servira para listar todos los productos disponibles en nuestro catalogo, api con paginacion.

   Peticion (No olvides el bearer token de la peticion de la primera peticion):

      ```json
      {
         "METHOD": "GET",
         "URL": "http://localhost:8000/api/products",
         "AUTHORIZATION": "BEARER TOKEN"
      }

   PARAMS:

      ```json
      {
         "page": 1,
         "per_page": 10
      }

   Respuesta Exitosa:

      ```json
      {
         "code": 200,
         "message": "Productos obtenidos correctamente",
         "data": {
            "current_page": 1,
            "data": [...],
            "first_page_url": "http://localhost:8000/api/products?page=1",
            "from": 1,
            "last_page": 60,
            "last_page_url": "http://localhost:8000/api/products?page=60",
            "links": [...],
            "next_page_url": "http://localhost:8000/api/products?page=2",
            "path": "http://localhost:8000/api/products",
            "per_page": 5,
            "prev_page_url": null,
            "to": 5,
            "total": 300
         }
      }

3. **ACTUALZIAR PRODUCTO**

   Esta api nos servira para actualizar cualquier producto de nuestro catalogo.

   Peticion (No olvides el bearer token de la peticion de la primera peticion):

      ```json
      {
         "METHOD": "POST",
         "URL": "http://localhost:8000/api/update-products",
         "AUTHORIZATION": "BEARER TOKEN"
      }

   Body:

      ```json
      {
         "product_id": 5, # PRODUCTO A ACTUALIZAR
         "name": "Nuevo nombre del producto", #NUEVO NOMBRE
         "price": 95000, #NUEVO PRECIO
         "stock": 10, #NUEVA CANTIDAD
      }

   Respuesta Exitosa:

      ```json
      {
         "code": 200,
         "message": "Producto actualizado correctamente",
         "data": {
            "id": 5,
            "category_id": 5,
            "name": "Nuevo nombre del producto",
            "description": "Iste facere neque voluptatum ipsa. In eveniet quod possimus dolorem. In quia minima rerum. Et nostrum ut hic. Ducimus voluptas aperiam aperiam voluptatum nostrum.",
            "price": "95000",
            "stock": "10",
            "image": "https://placehold.co/800@3x.png?text=libero",
            "status": "1",
            "created_at": "2024-10-27T17:29:08.000000Z",
            "updated_at": "2024-10-27T18:53:26.000000Z"
         }
      }

## Observaciones finales

Se entrega un proyecto web funcional con una gestion basica para un comercio electronico, como escalabilidad se pued eimplementar un manejo de roles mas completo utilizando spatie-laravel, ademas de un mejor manejo de ordenes, productos, compras y usuarios.

Quiero agradecer la oportunidad de presentar este proyecto. He disfrutado mucho de la prueba técnica, ya que me ha permitido aplicar mis habilidades y conocimientos en un entorno práctico. La experiencia fue desafiante y enriquecedora, y me brindó la posibilidad de explorar nuevas soluciones y mejorar mis capacidades.

Estoy emocionado de entregar este proyecto y espero que cumpla con las expectativas. Estoy abierto a cualquier comentario o sugerencia que puedan tener.

Muchas gracias