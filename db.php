<?php

class ConexionDB
{
    private $host;
    private $usuario;
    private $contrasena;
    private $base_datos;
    private $conexion;

    public function __construct($host, $usuario, $contrasena, $base_datos)
    {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
        $this->base_datos = $base_datos;
    }

    public function connect()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->base_datos);
        if ($this->conexion->connect_errno) {
            die('Error al connectse a la base de datos: ' . $this->conexion->connect_error);
        }
    }

    public function consultar($consulta)
    {
        $response = $this->conexion->query($consulta);
        if (!$response) {
            die('Error en la consulta: ' . $this->conexion->error);
        }
        return $response;
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}

// Ejemplo de uso:

// Crear una instancia de la clase ConexionDB
$conexionDB = new ConexionDB('nombre_del_servidor', 'nombre_de_usuario', 'contraseña', 'nombre_de_la_base_de_datos');

// connect a la base de datos
$conexionDB->connect();

// Consulta de ejemplo
$consulta = "SELECT * FROM tabla_ejemplo";
$response = $conexionDB->consultar($consulta);

// Recorrer los resultados
while ($row = $response->fetch_assoc()) {
    echo 'ID: ' . $row['id'] . ', Nombre: ' . $row['nombre'] . ', Otro campo: ' . $row['otro_campo'] . '<br>';
}

// Cerrar la conexión
$conexionDB->cerrarConexion();
