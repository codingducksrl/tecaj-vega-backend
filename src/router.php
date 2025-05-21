<?php
// Create Router instance
$router = new \Bramus\Router\Router();

$router->get('/', function() {

    

    echo json_encode([
        "message" => "Hello world",
    ]);
});

$router->before('GET|POST|PUT|DELETE', '/.*', function() {
    header('Content-Type: application/json');
});

// Run it!
$router->run();
