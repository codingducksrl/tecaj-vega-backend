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
        $GENRES = str_replace(' ', '%20', $GENRES);

        $client = new \GuzzleHttp\Client();
        $igre_najbolj_igrane = $client->request('GET', 'https://store.steampowered.com/api/getappsingenre/', [
            "query"=>[
                "genre" => $GENRES,
            ]
        ]);

        $podatki = json_decode((string)$igre_najbolj_igrane->getBody(), true);

        $steam_ids = array();

        if (isset($podatki['tabs']) && is_array($podatki['tabs'])) {
            foreach ($podatki['tabs'] as $tab) {
                if (isset($tab['items']) && is_array($tab['items'])) {
                    foreach ($tab['items'] as $item) {
                        if (isset($item['id'])) {
                            $steam_ids[] = $item['id'];
                        }
                    }
                }
            }
        }

        // Odstrani duplikate
        $steam_ids = array_unique($steam_ids);

        echo json_encode(array_values($steam_ids)); // array_values za reindeksiranje
    }

}
