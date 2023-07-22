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

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8");
        //echo "Conexión exitosa a la base de datos.";
    }

    public function desconectar()
    {
        $this->conexion->close();
    }

    public function ejecutar($consulta)
    {
        return $this->conexion->query($consulta);
    }

    public function getAffectedRows()
    {
        return $this->conexion->affected_rows;
    }

    public function prepareStatement($sql)
    {
        return $this->conexion->prepare($sql);
    }
    // Otros métodos para ejecutar consultas, transacciones, etc.
}
