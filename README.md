# legendary-broccoli
Another PHP API

Para visualizar este proyecto previamente debe tener instalada y configurado PHP y MySQL.

Estando en el ambiente de MySQL cree una base de datos (se recomienda usar los siguientes valores por defecto para la conexión,  host: "localhost", user: "root", password: "", database_name: "konecta") o si lo prefiere use otros pero recuerde actualizar los datos dentro del fichero index.php 
la línea 26 $connection = new ConexionDB("localhost", "root", "", "konecta");

Luego ejecute los ficheros, para crear las datas y la data de prueba:

1. products.sql
2. sold.sql
3. productsData.sql
4. soldData.sql

Con esto ya tendrá el ambiente para la persistencia. A continuación ejecute sobre la tabla sold los triggers

1. tr_subtract_stock.sql (Para actualizar el stock sobre la tabla products cada que se genere una venta)
2. tr before_insert_sold.sql (Para que antes de autorizar una venta se valide si el productro cuenta con stock)

Ahora ingrese desde la terminal de comandos, situe su path sobre la ruta en la que ha descargado este proyecto
ejecute la siguiente instrucción para levantar un servidor PHP de forma local

php -S localhost:9090

Hecho esto ahora podrá usar cualquier cliente para realizar las peticiones HTTP (Recomendado usar Postman).
El API cuenta con los siguientes endpoints:

1. http://localhost:9091/productos,  Para obtener todos los productos almacenados existentes)
   `Consuma el endpoint usando GET`
   
2. http://localhost:9091/add,        Para crear un producto nuevo
   `Use como payload un JSON BODY igual a este y consuma el endpoint usando POST:

    {
        "name": "Producto 444",
        "reference": "REF002",
        "price": 200,
        "weight": 0.5,
        "category": "Electrónica",
        "stock": 10,
        "date": "2023-07-19"
    }
    `
   
4. http://localhost:9091/delete,     Para eliminar un producto existente
   `Use como payload un JSON BODY igual a este y consuma el endpoint usando DELETE:

    {
        "id": 1 //id del producto
    }
    `
   
6. http://localhost:9091/update,     Para actualizar un producto
  `Use como payload un JSON BODY igual a este y consuma el endpoint usando PUT:

    {
        "id": 15,
        "name": "Producto bebe",
        "reference": "REF bebe",
        "price": 4,
        "weight": 4.0,
        "category": "hogar",
        "stock": 4,
        "date": "2023-07-04"
    }
    `
   
8. http://localhost:9091/sold,       Para vender un producto
  `Use como payload un JSON BODY igual a este y consuma el endpoint usando POST:
  
  {
      "idproduct": 3,
      "quantity": 1
  }
  `

10. http://localhost:9091/max,        Para conocer el producto con mayor stock
   `Consuma el endpoint usando GET`
   
11. http://localhost:9090/maxsold,    Para conocer el producto con mayor venta
    `Consuma el endpoint usando GET`

Gracias por haber llegado hasta este punto! 
