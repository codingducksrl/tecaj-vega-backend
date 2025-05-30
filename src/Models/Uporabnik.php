<?php

namespace Vscode\TecajVegaBackend\Models;

use mysqli;

class Uporabnik {

    public static function set($id) {
        
        $conn = Database::connect();

        $conn->query("INSERT IGNORE INTO Uporabnik (SteamID) VALUES ($id)");
    }

    

}
?>























































<!-- SEND HELP -->