CREATE TABLE `sold` (
  `idsold` int NOT NULL AUTO_INCREMENT,
  `idproduct` int NOT NULL,
  `date` date NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`idsold`)
) ENGINE=InnoDB AUTO_INCREMENT=93798 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin