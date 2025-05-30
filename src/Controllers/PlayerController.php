<?php

namespace Vscode\TecajVegaBackend\Controllers;

class PlayerController {

    public static function getID($id) {

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002', [
            "query"=>[
                "key" => "E0018A4719E4720F851B48118F8FF458",
                "steamids" => "$id"
            ]
        ]);

        $podatki = json_decode((string)$res->getBody(), true);

        echo json_encode([
                "username" => $podatki["response"]["players"][0]["personaname"],
                "slika" => $podatki["response"]["players"][0]["avatarfull"],     
        ]);

    }

}
