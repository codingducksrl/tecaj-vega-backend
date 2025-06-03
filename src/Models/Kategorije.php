<?php

namespace Vscode\TecajVegaBackend\Models;

use mysqli;

class Kategorije {

    public static function set($kategorija) {
        
        $conn = Database::connect();

        $stmt = $conn->prepare("INSERT IGNORE INTO Kategorije (ime) VALUES (?)");
        $stmt->bind_param("s", $kategorija);
        $stmt->execute();
    }
}
?>