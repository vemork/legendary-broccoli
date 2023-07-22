<?php

namespace App\Presentation;

use App\Application\GetProductsUseCase;

class ProductController
{
    private $getProductsUseCase;

    public function __construct(GetProductsUseCase $getProductsUseCase)
    {
        $this->getProductsUseCase = $getProductsUseCase;
    }

    public function getProducts()
    {
        return $this->getProductsUseCase->getAllUseCase();
    }
    public function getProductMaxStock()
    {
        return $this->getProductsUseCase->getProductMaxStockUseCase();
    }
    public function getProductMaxSold()
    {
        return $this->getProductsUseCase->getProductMaxSoldUseCase();
    }
    public function setProduct($data)
    {
        return $this->getProductsUseCase->setNewProductUseCase($data);
    }
    public function setProductSold($data)
    {
        return $this->getProductsUseCase->setNewProductSoldUseCase($data);
    }
    public function updateProduct($data)
    {
        return $this->getProductsUseCase->updateProductUseCase($data);
    }
    public function deleteProduct($data)
    {
        return $this->getProductsUseCase->deleteProductUseCase($data);
    }
}
