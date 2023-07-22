<?php

namespace App\Infrastructure;

class ProductRepositoryInMemory
{
    private $products;

    public function __construct()
    {
        // Simulación de una base de datos
        $this->products = [
            [
                'id' => 1,
                'nombre' => 'Producto 1',
                'referencia' => 'REF001',
                'precio' => 100.50,
                'peso' => 0.5,
                'categoria' => 'Electrónica',
                'stock' => 10,
                'fecha_creacion' => '2023-07-19'
            ],
            // Agrega más productos aquí...
        ];
    }

    public function getAll()
    {
        return $this->products;
    }

    public function setNewProduct()
    {
        $nuevoObjeto = [
            'id' => 2,
            'nombre' => 'Producto 2',
            'referencia' => 'REF002',
            'precio' => 100.50,
            'peso' => 0.5,
            'categoria' => 'Electrónica',
            'stock' => 10,
            'fecha_creacion' => '2023-07-19'
        ];
        array_push($this->products, $nuevoObjeto);
        return (array(
            'message' => 'Producto creado correctamente.',
            'err' => false,
            'code' => 201,
            'data' => $this->products,
        ));
    }

    public function deleteProduct($id)
    {
        unset($this->products[$id]);
        return (array(
            'message' => 'Producto eliminado correctamente.',
            'err' => false,
            'code' => 200,
            'data' => $this->products,
        ));
    }
}
