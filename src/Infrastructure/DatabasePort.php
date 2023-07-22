<?php

namespace App\Infrastructure;

interface DatabasePort {
    public function setNewProduct(array $data);
    public function setUpdateProduct(array $data);
    public function delete($id);
    public function getAll();
    public function getMaxProductStock();
    // Otros métodos necesarios...
}
