<?php

namespace Vscode\TecajVegaBackend\Controllers;

class HelloController {

    public static function hello() {
        echo json_encode([
            "message" => "fljeno",
        ]);
    }

}
