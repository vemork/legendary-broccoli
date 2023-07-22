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

    public function conectar()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->base_datos);
        if ($this->conexion->connect_errno) {
            die('Error al conectarse a la base de datos: ' . $this->conexion->connect_error);
        }
    }

    public function consultar($consulta)
    {
        $resultado = $this->conexion->query($consulta);
        if (!$resultado) {
            die('Error en la consulta: ' . $this->conexion->error);
        }
        return $resultado;
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}

// Ejemplo de uso:

// Crear una instancia de la clase ConexionDB
$conexionDB = new ConexionDB('nombre_del_servidor', 'nombre_de_usuario', 'contraseña', 'nombre_de_la_base_de_datos');

// Conectar a la base de datos
$conexionDB->conectar();

// Consulta de ejemplo
$consulta = "SELECT * FROM tabla_ejemplo";
$resultado = $conexionDB->consultar($consulta);

// Recorrer los resultados
while ($fila = $resultado->fetch_assoc()) {
    echo 'ID: ' . $fila['id'] . ', Nombre: ' . $fila['nombre'] . ', Otro campo: ' . $fila['otro_campo'] . '<br>';
}

// Cerrar la conexión
$conexionDB->cerrarConexion();
