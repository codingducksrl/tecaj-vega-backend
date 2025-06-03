<?php

namespace Vscode\TecajVegaBackend\Models;

use mysqli;

class Uporabnik_ima_kategorije {

    public static function set($fk_uporabnik, $fk_kategorije, $stevilo_ur) {
        
        $conn = Database::connect();

        $stmt = $conn->prepare("REPLACE INTO uporabnik_ima_kategorije (fk_uporabnik, fk_kategorije, stevilo_ur) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $fk_uporabnik, $fk_kategorije, $stevilo_ur);
        $stmt->execute();
    }

    public static function get($fk_uporabnik) {
        $conn = Database::connect();

        $stmt = $conn->prepare("SELECT ime, stevilo_ur FROM uporabnik_ima_kategorije 
        JOIN Kategorije ON uporabnik_ima_kategorije.fk_kategorije = Kategorije.ime 
        JOIN Uporabnik ON uporabnik_ima_kategorije.fk_uporabnik = Uporabnik.SteamID 
        WHERE fk_uporabnik = ?");
        $stmt->bind_param("i", $fk_uporabnik);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
