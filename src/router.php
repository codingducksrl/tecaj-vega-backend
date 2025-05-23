<?php
// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace("Vscode\TecajVegaBackend\Controllers");
$router->get('/player/{id}',"PlayerController@getID");
$router->get('/test',"HelloController@hello");

$router->get('/', function() {

    $client = new GuzzleHttp\Client();

    $query = array();
    parse_str($_SERVER["QUERY_STRING"], $query);


    $res = $client->request('GET', 'https://store.steampowered.com/api/appdetails', [
        "query"=>[
        "appids" => "570"
        ]
    ]);

    $podatki = json_decode((string)$res->getBody(), true);

    echo json_encode([
        "message" => "Hello world",
        "status" => $res->getStatusCode(),
        "name" => $podatki["570"]["data"]["name"],
        "category" => $podatki["570"]["data"]["categories"],
        "genre" => $podatki["570"]["data"]["genres"],
        "short_description" => $podatki["570"]["data"]["short_description"],
        "header_image" => $podatki["570"]["data"]["header_image"],
        "link" => "https://store.steampowered.com/app/570",
        "query" => $query
    ]);
});

$router->before('GET|POST|PUT|DELETE', '/.*', function() {
    header('Content-Type: application/json');
});

// Run it!
$router->run();
