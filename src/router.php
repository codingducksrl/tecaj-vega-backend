<?php
// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace("Vscode\TecajVegaBackend\Controllers");
$router->get('/player/{id}/refresh/',"RefreshController@refresh");
$router->get('/player/{id}/genres/',"GenresController@genres");
$router->get('/player/{id}/genres/{genre}',"GenresController@reccomendations");
$router->get('/player/{id}',"PlayerController@getID");
$router->get('/test',"HelloController@hello");

$router->get('/env', function() {
    echo json_encode( [
        "name"=> $_ENV['DB_DATABASE'],
        "host"=> $_ENV['DB_HOST'],
        "username"=> $_ENV['DB_USER'],
    ]);
});

$router->get('/', function() {

});

$router->before('GET|POST|PUT|DELETE', '/.*', function() {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

});

// Run it!
$router->run();
