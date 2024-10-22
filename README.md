# Inventario
Sistema de control de inventarios en php con bootstrap y datatables, para el manejo de las tablas.
Este sistema permite tener un control de entrada de productos, salidas, registro de clientes, consulta de movimientos por fecha, por cliente.
En datatables se añadió el buscador y filtrado de datos para facilitar la navegación del cliente y la experiencia de ususario.

## Modulos
- Productos
- Categorias
- Caja
- Clientes
- Proveedores
- Inventario
- Usuarios

## Update 
- Se actualizo la Plantilla Principal por Core UI v4


## Instalacion
Para instalar el Sistema Requieres Apache+PHP+MySQL o tener instalado el XAMPP/LAMPP

1. Primero debes descargar este repositorio y colocarlo en tu carpeta htdocs o /var/www/ segun sea el caso.
2. Deberas crear la base de datos llamada inventiolite en tu servidor mysql, las tablas requeridas estan en el archivo schema.sql
3. Deberas modificar el archivo inventio-lite/core/controller/Database.php y agregar los datos de conexion a tu base de datos.
4. Ejecutar el sistema desde http://localhost/inventio-system/ depende del nombre que le pusiste a la carpeta del proyecto.
5. Los datos de usuario por default son:
    Usuario: admin
    Password: admin
6. Disfrutar el sistema


