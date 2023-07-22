DROP TRIGGER IF EXISTS tr_subtract_stock;

DELIMITER //
CREATE TRIGGER tr_subtract_stock
AFTER INSERT ON sold
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock = stock - NEW.quantity
    WHERE idproducts = NEW.idproduct;
END;
//
DELIMITER ;