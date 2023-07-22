<?php
namespace App\Domain;
class Product
{
    private $id;
    private $nombre;
    private $referencia;
    private $precio;
    private $peso;
    private $categoria;
    private $stock;
    private $fecha_creacion;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getReferencia()
    {
        return $this->referencia;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }
}
