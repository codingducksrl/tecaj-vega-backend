<?php

namespace Vscode\TecajVegaBackend\Models;

use mysqli;

class Database {

    public static function connect() {

        
        $host = $_ENV["DB_HOST"];
        $dbname = $_ENV["DB_DATABASE"];
        $user = $_ENV["DB_USER"];
        $pass = $_ENV["DB_PASSWORD"];
        $port = $_ENV["DB_PORT"]; 
    
        
        return new mysqli($host, $user, $pass, $dbname, (int)$port);
        
    }
}
?>