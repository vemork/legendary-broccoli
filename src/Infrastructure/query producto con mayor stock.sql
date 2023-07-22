SELECT *
        FROM products
        WHERE stock = (SELECT MAX(stock) FROM products)
        LIMIT 1