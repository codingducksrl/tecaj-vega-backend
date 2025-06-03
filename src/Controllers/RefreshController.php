<?php

namespace Vscode\TecajVegaBackend\Controllers;

class RefreshController {

    public $API_KEY = "E0018A4719E4720F851B48118F8FF458"; // app id
    public $STEAM_ID = "76561199339613784"; // steam id

    public function hello() {
        
        $client = new \GuzzleHttp\Client(); // za povezavo

        // pridobimo podatke z Steam API
        $igre_uporabnik = $client->request('GET', 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v1/', [
            "query"=>[
                "key" => $this->API_KEY,
                "steamid" => $this->STEAM_ID,
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


        // pridobivanje najbolj igranih iger od steam
        $igre_najbolj_igrane = $client->request('GET', 'https://steamspy.com/api.php/', [
            "query"=>[
                "request" => "top100forever",
            ]
        ]);
        $res_igre_najbolj_igrane = json_decode((string)$igre_najbolj_igrane->getBody(), true); // dekodiramo podatke


        echo json_encode([
            // get playtime
            // "playtime" => $res["response"]["games"][0]["playtime_forever"],
            // get id
            // "id" => $res["response"]["games"][0]["appid"],
            "message1" => $kategorije,
            "message2" => $res_igre_najbolj_igrane,
        ]);
    }

}
