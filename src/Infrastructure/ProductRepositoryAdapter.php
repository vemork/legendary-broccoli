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
        $this->connection->connect();
        $sql = "INSERT INTO products (name, reference, price, weight, category, stock, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepareStatement($sql);
        $stmt->bind_param("ssdssis", $name, $reference, $price, $weight, $category, $stock, $date);

        // execute quer
        try {
            if ($stmt->execute()) {
                if ($this->connection->getAffectedRows() > 0) {
                    return (array(
                        'message' => 'Producto agregado correctamente.',
                        'err' => false,
                        'code' => 200,
                        'data' => $nuevoProductoJSON,
                    ));
                }
                $stmt->close();
            } else {
                return (array(
                    'message' => 'Error al agregar el producto:',
                    'err' => true,
                    'code' => 500,
                    'data' => $this->connection->error,
                ));
            }
        } catch (\Exception $e) {
            // Handl error when product does not have stock
            return (array(
                'message' => 'Error al actualizar el producto:',
                'err' => true,
                'code' => 500,
                'data' => $e->getMessage(),
            ));
        }
        $this->connection->close();
    }

    public function setNewProductSold(array $data)
    {
        $idproduct = $data['idproduct'];
        $quantity = $data['quantity'];

        $currentDate = new \DateTime('now', new \DateTimeZone('America/Mexico_City'));
        $currentDateStr = $currentDate->format('Y-m-d');

        $nuevoProductoSoldJSON = [
            'idproduct' => $data['idproduct'],
            'quantity' => $data['quantity'],
            'date' => $currentDateStr,
        ];
        $this->connection->connect();
        $sql = "INSERT INTO sold (idproduct, quantity, date) VALUES (?, ?, CURDATE())";
        $stmt = $this->connection->prepareStatement($sql);
        $stmt->bind_param("ii", $idproduct, $quantity);

        // execute query
        try {
            if ($stmt->execute()) {
                if ($this->connection->getAffectedRows() > 0) {
                    return (array(
                        'message' => 'Producto vendido correctamente.',
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
            // Handl error when product does not have stock
            return (array(
                'message' => 'Error al vender el producto:',
                'err' => true,
                'code' => 500,
                'data' => $e->getMessage(),
            ));
        }
        $this->connection->close();
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


        // Execute la query
        try {
            $this->connection->connect();

            $checkIdExistsStmt = $this->connection->prepareStatement("SELECT COUNT(*) as total FROM products WHERE idproducts = ?");
            $checkIdExistsStmt->bind_param("i", $id);
            $checkIdExistsStmt->execute();
            $result = $checkIdExistsStmt->get_result();
            $existIdIntoDatabase = $result->fetch_assoc();

            if (!$existIdIntoDatabase['total'] > 0) {
                return (array(
                    'message' => 'Valida nuevamente el Id, parece que el producto no existe!',
                    'err' => true,
                    'code' => 400,
                    'data' => $nuevoProductoJSON,
                ));
            }

            $sql = "UPDATE products SET name = ?, reference = ?, price = ?, weight = ?, category = ?, stock = ?, date = ? WHERE idproducts = ?";
            $stmt = $this->connection->prepareStatement($sql);
            $stmt->bind_param("ssdssisi", $name, $reference, $price, $weight, $category, $stock, $date, $id);

            if ($stmt->execute()) {
                if ($this->connection->getAffectedRows() > 0 || $this->connection->getAffectedRows() === 0) {

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
                    'message' => 'Error al actualizar el producto:',
                    'err' => true,
                    'code' => 500,
                    'data' => $this->connection->error,
                ));
            }
        } catch (\Exception $e) {
            // Handl error when product does not have stock
            return (array(
                'message' => 'Error al actualizar el producto:',
                'err' => true,
                'code' => 500,
                'data' => $e->getMessage(),
            ));
        }
        $this->connection->close();
    }

    public function delete($id)
    {
        // Query for deleting the product
        $query = "DELETE FROM products WHERE idproducts = $id";

        $this->connection->connect();
        // execute query
        if ($this->connection->execute($query) === TRUE) {
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
        $this->connection->close();
    }

    public function getAll()
    {
        $query = "SELECT * FROM products";
        $this->connection->connect();
        $response = $this->connection->execute($query);
        $this->connection->close();

        $productos_encontrados = array();
        while ($row = $response->fetch_assoc()) {
            $productos_encontrados[] = $row;
        }

        return $productos_encontrados;
    }

    public function getMaxProductStock()
    {
        $query = "SELECT *
        FROM products
        WHERE stock = (SELECT MAX(stock) FROM products)
        LIMIT 1";
        $this->connection->connect();
        $response = $this->connection->execute($query);
        $this->connection->close();

        $productosMaxStock = array();
        while ($row = $response->fetch_assoc()) {
            $productosMaxStock[] = $row;
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
        $this->connection->connect();
        $response = $this->connection->execute($query);

        while ($row = $response->fetch_assoc()) {

            $productosMaxSold[] = $row;

            //aditional query into products table
            $query = "SELECT *
            FROM products
            WHERE idproducts = " . $row['idproduct'];

            $this->connection->connect();
            $response = $this->connection->execute($query);

            while ($row = $response->fetch_assoc()) {
                $productosMaxSoldInfo[] = $row;
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
        $this->connection->close();
        return $completeMaxSoldProductInfo;
    }
}
