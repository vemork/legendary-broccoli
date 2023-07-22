SELECT idproduct, SUM(quantity) as total_quantity
        FROM sold
        GROUP BY idproduct
        ORDER BY total_quantity DESC
        LIMIT 1;