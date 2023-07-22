DROP TRIGGER IF EXISTS before_insert_sold;

DELIMITER //
CREATE TRIGGER before_insert_sold
BEFORE INSERT ON sold
FOR EACH ROW
BEGIN
    DECLARE stock_count INT;

    SELECT stock INTO stock_count
    FROM products
    WHERE idproducts = NEW.idproduct;

    IF stock_count <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El stock del producto es igual o menor a cero.';
    END IF;
END //
DELIMITER ;