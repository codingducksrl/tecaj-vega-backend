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

    public static function reccomendations($STEAM_ID, $GENRES) {
        $client = new \GuzzleHttp\Client();
            $igre_najbolj_igrane = $client->request('GET', 'https://store.steampowered.com/api/getappsingenre/', [
                "query"=>[
                    "genre" => $GENRES,
                ]
            ]);
            
            $podatki = json_decode((string)$igre_najbolj_igrane->getBody(), true); // dekodiramo podatke

            for( $i = 0; $i < count($podatki["tabs"]["newreleases"]["items"]); $i++) {
                echo json_encode([
                    "idNewrelese" => $podatki["tabs"]["newreleases"]["items"][$i]["id"],
                    "idTopseller" => $podatki["tabs"]["topsellers"]["items"][$i]["id"],
                ]);
            
            }
    }

}
