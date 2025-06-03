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
}
?>
