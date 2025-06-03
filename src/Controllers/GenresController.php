<?php

namespace Vscode\TecajVegaBackend\Controllers;
use Vscode\TecajVegaBackend\Models\Uporabnik;
use Vscode\TecajVegaBackend\Models\Database;
use Vscode\TecajVegaBackend\Models\Uporabnik_ima_kategorije;

class GenresController {

    public static function genres($STEAM_ID) {

        echo json_encode(
            Uporabnik_ima_kategorije::get($STEAM_ID)
        );
    }

    public static function reccomendations($_STEAM_ID, $GENRES) {

    }

}
