<?php

namespace App\Infrastructure;

require 'src/Infrastructure/DatabasePort.php';

class ProductRepositoryAdapter implements DatabasePort
{
    private $connection;
    private $products;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function setNewProduct(array $data)
    {
        $name = $data['name'];
        $reference = $data['reference'];
        $price = $data['price'];
        $weight = $data['weight'];
        $category = $data['category'];
        $stock = $data['stock'];
        $date = $data['date'];


        $nuevoProductoJSON = [
            'name' => $data['name'],
            'reference' => $data['reference'],
            'price' => $data['price'],
            'weight' => $data['weight'],
            'category' => $data['category'],
            'stock' => $data['stock'],
            'date' => $data['date'],
        ];
        $this->connection->conectar();
        $sql = "INSERT INTO products (name, reference, price, weight, category, stock, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepareStatement($sql);
        $stmt->bind_param("ssdssis", $name, $reference, $price, $weight, $category, $stock, $date);

        // Ejecutar la query
        if ($stmt->execute()) {
            if ($this->connection->getAffectedRows() > 0) {
                return (array(
                    'message' => 'Producto actualizado correctamente.',
                    'err' => false,
                    'code' => 200,
                    'data' => $nuevoProductoJSON,
                ));
            }
            $stmt->close();
        } else {
            return (array(
                'message' => 'Error al actualiazr el producto:',
                'err' => true,
                'code' => 500,
                'data' => $this->connection->error,
            ));
        }
        $this->connection->desconectar();
    }

    public function setNewProductSold(array $data)
    {
        $idproduct = $data['idproduct'];
        $quantity = $data['quantity'];

        $nuevoProductoSoldJSON = [
            'idproduct' => $data['idproduct'],
            'quantity' => $data['quantity'],
        ];
        $this->connection->conectar();
        $sql = "INSERT INTO sold (idproduct, quantity) VALUES (?, ?)";
        $stmt = $this->connection->prepareStatement($sql);
        $stmt->bind_param("ii", $idproduct, $quantity);

        // Ejecutar la query
        try {
            if ($stmt->execute()) {
                if ($this->connection->getAffectedRows() > 0) {
                    return (array(
                        'message' => 'Producto actualizado correctamente.',
                        'err' => false,
                        'code' => 200,
                        'data' => $nuevoProductoSoldJSON,
                    ));
                }
                $stmt->close();
            } else {
                return (array(
                    'message' => 'Error al vender el producto:',
                    'err' => true,
                    'code' => 500,
                    'data' => $this->connection->error,
                ));
            }
        } catch (\Exception $e) {
            // el prodcuto que se intenta vender ya no cuenta con stock
            return (array(
                'message' => 'Error al vender el producto:',
                'err' => true,
                'code' => 500,
                'data' => $e->getMessage(),
            ));
        }
        $this->connection->desconectar();
    }

    public function setUpdateProduct(array $data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $reference = $data['reference'];
        $price = $data['price'];
        $weight = $data['weight'];
        $category = $data['category'];
        $stock = $data['stock'];
        $date = $data['date'];


        $nuevoProductoJSON = [
            'id' => $data['id'],
            'name' => $data['name'],
            'reference' => $data['reference'],
            'price' => $data['price'],
            'weight' => $data['weight'],
            'category' => $data['category'],
            'stock' => $data['stock'],
            'date' => $data['date'],
        ];
        $this->connection->conectar();
        $sql = "UPDATE products SET name = ?, reference = ?, price = ?, weight = ?, category = ?, stock = ?, date = ? WHERE idproducts = ?";
        $stmt = $this->connection->prepareStatement($sql);
        $stmt->bind_param("ssdssisi", $name, $reference, $price, $weight, $category, $stock, $date, $id);

        // Ejecutar la query
        if ($stmt->execute()) {
            if ($this->connection->getAffectedRows() > 0) {
                return (array(
                    'message' => 'Producto actualizado correctamente.',
                    'err' => false,
                    'code' => 200,
                    'data' => $nuevoProductoJSON,
                ));
            }
            $stmt->close();
        } else {
            return (array(
                'message' => 'Error al actualiazr el producto:',
                'err' => true,
                'code' => 500,
                'data' => $this->connection->error,
            ));
        }
        $this->connection->desconectar();
    }

    public function delete($id)
    {
        // Query para eliminar el producto
        $query = "DELETE FROM products WHERE idproducts = $id";

        $this->connection->conectar();
        // Ejecutar la query
        if ($this->connection->ejecutar($query) === TRUE) {
            if ($this->connection->getAffectedRows() > 0) {
                return (array(
                    'message' => 'Producto eliminado correctamente.',
                    'err' => false,
                    'code' => 200,
                    'data' => [],
                ));
            } else {
                return (array(
                    'message' => 'El ID proporcionado no existe',
                    'err' => true,
                    'code' => 400,
                    'data' => $id,
                ));
            }
        } else {
            return (array(
                'message' => 'Error al eliminar el producto:',
                'err' => true,
                'code' => 500,
                'data' => $this->connection->error,
            ));
        }
        $this->connection->desconectar();
    }

    public function getAll()
    {
        $query = "SELECT * FROM products";
        $this->connection->conectar();
        $resultado = $this->connection->ejecutar($query);
        $this->connection->desconectar();

        $productos_encontrados = array();
        while ($fila = $resultado->fetch_assoc()) {
            $productos_encontrados[] = $fila;
        }

        return $productos_encontrados;
    }

    public function getMaxProductStock()
    {
        $query = "SELECT *
        FROM products
        WHERE stock = (SELECT MAX(stock) FROM products)
        LIMIT 1";
        $this->connection->conectar();
        $resultado = $this->connection->ejecutar($query);
        $this->connection->desconectar();

        $productosMaxStock = array();
        while ($fila = $resultado->fetch_assoc()) {
            $productosMaxStock[] = $fila;
        }

        return $productosMaxStock;
    }

    public function getMaxProductSold()
    {
        $query = "SELECT idproduct, SUM(quantity) as total_quantity
        FROM sold
        GROUP BY idproduct
        ORDER BY total_quantity DESC
        LIMIT 1;";
        $this->connection->conectar();
        $resultado = $this->connection->ejecutar($query);

        while ($fila = $resultado->fetch_assoc()) {

            $productosMaxSold[] = $fila;

            //consultar información adicional desde la tabla productos
            $query = "SELECT *
            FROM products
            WHERE idproducts = " . $fila['idproduct'];

            $this->connection->conectar();
            $resultado = $this->connection->ejecutar($query);

            while ($fila = $resultado->fetch_assoc()) {
                $productosMaxSoldInfo[] = $fila;
            }
        }
        $completeMaxSoldProductInfo = [
            'max_quantity' => $productosMaxSold[0]['total_quantity'],
            'id' => $productosMaxSoldInfo[0]['idproducts'],
            'name' => $productosMaxSoldInfo[0]['name'],
            'reference' => $productosMaxSoldInfo[0]['reference'],
            'price' => $productosMaxSoldInfo[0]['price'],
            'weight' => $productosMaxSoldInfo[0]['weight'],
            'category' => $productosMaxSoldInfo[0]['category'],
            'stock' => $productosMaxSoldInfo[0]['stock'],
            'date' => $productosMaxSoldInfo[0]['date'],
        ];
        $this->connection->desconectar();
        return $completeMaxSoldProductInfo;
    }
}
