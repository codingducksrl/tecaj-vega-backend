<?php
namespace Vscode\TecajVegaBackend\Controllers;


class MostPlayedGames {

    public static function getGames($genre){

// pridobivanje najbolj igranih iger od steam
    $client = new \GuzzleHttp\Client();
    $igre_najbolj_igrane = $client->request('GET', 'https://store.steampowered.com/api/getappsingenre/', [
        "query"=>[
            "genre" => $genre,
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
?>