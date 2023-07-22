<?php

namespace App\Application;

require 'validaciones.php';

use App\Infrastructure\ProductRepositoryAdapter;

class GetProductsUseCase
{
    private $productRepository;

    public function __construct(ProductRepositoryAdapter $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllUseCase()
    {
        return $this->productRepository->getAll();
    }
    public function getProductMaxStockUseCase()
    {
        return $this->productRepository->getMaxProductStock();
    }
    public function getProductMaxSoldUseCase()
    {
        return $this->productRepository->getMaxProductSold();
    }
    public function setNewProductUseCase($data)
    {
        [$msg, $err] = integridad($data);

        // Validar los datos recibidos
        if ($err) {
            return (array(
                'message' => 'Error: invalid json payload.' . $msg,
                'err' => true,
                'code' => 400
            ));
        }

        return $this->productRepository->setNewProduct($data);
    }
    public function setNewProductSoldUseCase($data)
    {
        [$msg, $err] = integridadSold($data);

        // Validar los datos recibidos
        if ($err) {
            return (array(
                'message' => 'Error: invalid json payload.' . $msg,
                'err' => true,
                'code' => 400
            ));
        }

        return $this->productRepository->setNewProductSold($data);
    }
    public function deleteProductUseCase($data)
    {
        if (!isset($data["id"])) {
            return (array(
                'message' => 'Error: id is required.',
                'err' => true,
                'code' => 400
            ));
        }

        return $this->productRepository->delete($data["id"]);
    }
    public function updateProductUseCase($data)
    {
        [$msg, $err] = integridad($data);

        // Validar los datos recibidos (puedes agregar más validaciones según tus requerimientos)
        if ($err) {
            return (array(
                'message' => 'Error: invalid json payload.' . $msg,
                'err' => true,
                'code' => 400
            ));
        }

        return $this->productRepository->setUpdateProduct($data);
    }
}
