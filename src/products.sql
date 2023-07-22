CREATE TABLE `products` (
  `idproducts` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  `reference` varchar(45) COLLATE utf8mb3_bin NOT NULL,
  `price` int NOT NULL,
  `weight` int NOT NULL,
  `category` varchar(45) COLLATE utf8mb3_bin NOT NULL,
  `stock` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idproducts`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin