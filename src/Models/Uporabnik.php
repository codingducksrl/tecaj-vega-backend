<?php

namespace Vscode\TecajVegaBackend\Models;

use mysqli;

class Uporabnik {

    public static function add($STEAM_ID) {
        
        $conn = Database::connect();

        $conn->query("INSERT IGNORE INTO Uporabnik (SteamID) VALUES ($STEAM_ID)");
    }


}
?>