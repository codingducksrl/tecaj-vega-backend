CREATE TABLE `Kategorije` (
  `ime` varchar(20) PRIMARY KEY NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `Uporabnik` (
  `SteamID` bigint(20) PRIMARY KEY NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `uporabnik_ima_kategorije` (
  `fk_uporabnik` bigint(20) NOT NULL,
  `fk_kategorije` varchar(20) NOT NULL,
  `stevilo_ur` int(11) NOT NULL,
  FOREIGN KEY (`fk_uporabnik`) REFERENCES `Uporabnik`(`SteamID`),
  FOREIGN KEY (`fk_kategorije`) REFERENCES `Kategorije`(`ime`),
  PRIMARY KEY (`fk_uporabnik`, `fk_kategorije`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;