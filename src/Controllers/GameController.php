<?php

namespace Vscode\TecajVegaBackend\Controllers;
use Vscode\TecajVegaBackend\Models\Uporabnik;
use Vscode\TecajVegaBackend\Models\Database;



class GameController {

    public static function getID($id) {
        $client = new \GuzzleHttp\Client();
        $igre_podatki = $client->request('GET', 'https://store.steampowered.com/api/appdetails', [ // za vsak odgovor / igro pridobimo vse podatke
                "query"=>[
                    "appids" => $id,
                    "language" => "english",
                    "cc" => "us",
                ]
            ]);
        $res_igre_podatki = json_decode((string)$igre_podatki->getBody(), true); // dekodiramo podatke igre


        echo json_encode($res_igre_podatki);

    }

}
