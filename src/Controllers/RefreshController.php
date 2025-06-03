<?php

namespace Vscode\TecajVegaBackend\Controllers;
use Vscode\TecajVegaBackend\Models\Kategorije;
use Vscode\TecajVegaBackend\Models\Database;
use Vscode\TecajVegaBackend\Models\Uporabnik;
use Vscode\TecajVegaBackend\Models\Uporabnik_ima_kategorije;

class RefreshController {

    public function hello($STEAM_ID) {
        
        $client = new \GuzzleHttp\Client(); // za povezavo

        // pridobimo podatke z Steam API
        $igre_uporabnik = $client->request('GET', 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/', [
            "query"=>[
                "key" => $_ENV["STEAM_API_KEY"],
                "steamid" => $STEAM_ID,
                "include_appinfo" => 1,
                "include_played_free_games" => 1,
                "format" => "json"
            ]
        ]);

        // api klic ki pridobi vse igre uporabnika
        $res_igre_uporabnik = json_decode((string)$igre_uporabnik->getBody(), true); // pretvorimo v array

        // hrani vse kategorije
        $kategorije = [];

        // vmesni array
        $value = [];        
        for($i = 0; $i < count($res_igre_uporabnik["response"]["games"]); $i++){ // iteriramo skozi odgovor
            $igre_podatki = $client->request('GET', 'https://store.steampowered.com/api/appdetails', [ // za vsak odgovor / igro pridobimo vse podatke
                "query"=>[
                    "appids" => $res_igre_uporabnik["response"]["games"][$i]["appid"],
                    "language" => "english",
                    "cc" => "us",
                ]
            ]);
            $res_igre_podatki = json_decode((string)$igre_podatki->getBody(), true); // dekodiramo podatke igre
            
            // shranimo v polje ki bo shranilo v bazo
            $value[] = [
                "id" => $res_igre_uporabnik["response"]["games"][$i]["appid"],
                "name" => $res_igre_podatki[$res_igre_uporabnik["response"]["games"][$i]["appid"]]["data"]["name"],
                "playtime" => $res_igre_uporabnik["response"]["games"][$i]["playtime_forever"],
                "category" => $res_igre_podatki[$res_igre_uporabnik["response"]["games"][$i]["appid"]]["data"]["categories"],
                "genre" => $res_igre_podatki[$res_igre_uporabnik["response"]["games"][$i]["appid"]]["data"]["genres"],
                "short_description" => $res_igre_podatki[$res_igre_uporabnik["response"]["games"][$i]["appid"]]["data"]["short_description"],
                "header_image" => $res_igre_podatki[$res_igre_uporabnik["response"]["games"][$i]["appid"]]["data"]["header_image"],
                "link" => "https://store.steampowered.com/app/" . $res_igre_uporabnik["response"]["games"][$i]["appid"]
            ];

            // iteriramo skozi kategorije in jih shranimo v array in dodamo playtime
            for($j = 0; $j < count($value[$i]["genre"]); $j++){
                if(!in_array($value[$i]["genre"][$j]["description"], $kategorije)){
                    $kategorije[$value[$i]["genre"][$j]["description"]] = $value[$i]["playtime"];
                }
                else {
                    $kategorije[$value[$i]["genre"][$j]["description"]] += $value[$i]["playtime"];
                }

            }
        }

        // shranimo v bazo
        Uporabnik::add($STEAM_ID);

        if(count($kategorije) == 0){
            $kategorije = "No categories found";
        }
        else {
            $keys = array_keys($kategorije); // pridobimo ključe kategorij
            for($i = 0; $i < count($keys); $i++) { // iteriramo skozi ključe
                if($kategorije[$keys[$i]] != 0) {
                    Kategorije::set($keys[$i]); // shranimo kategorije v bazo
                    Uporabnik_ima_kategorije::set($STEAM_ID, $keys[$i], ceil($kategorije[$keys[$i]] / 60)); // shranimo relacije uporabnik-kategorija v bazo
                }
            }
        }
    }

}
