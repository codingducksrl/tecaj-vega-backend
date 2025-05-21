<?php
// Create Router instance
$router = new \Bramus\Router\Router();

$router->get('/', function() {


    $client = new GuzzleHttp\Client();

    $query = array();
    parse_str($_SERVER["QUERY_STRING"], $query);

    $appid = $query["appid"] ?? "";

    $res = $client->request('GET', 'https://store.steampowered.com/api/appdetails',[
        "query" => [
            "appids" => $appid
        ]
     ]);

    $podatki = json_decode( (string)$res->getBody(), true );

    echo json_encode([
        "message" => "Hello world",
        "body" => $podatki[$appid]["data"]["name"],
        "query" => $query,
    ]);
});

$router->before('GET|POST|PUT|DELETE', '/.*', function() {
    header('Content-Type: application/json');
});

// Run it!
$router->run();
