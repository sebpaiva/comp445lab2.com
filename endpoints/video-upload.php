<?php

// Used for CORS
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Methods:GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Origin,Accept,X-Requested-With,Content-Type,Access-Control-Request-Method,Access-Control-Request-Headers,Access-Control-Allow-Credentials");
header("Access-Control-Allow-Origin: *");

// Used for imports
spl_autoload_register(function ($class){
    require __DIR__ . "./src/$class.php";
});

// Get the URI parts
$uriParts = explode("/", $_SERVER["REQUEST_URI"]);

// Determine the requested endpoint
$endpoint = $uriParts[4] ?? null;

// Determine the requested endpoint
$vid_ID = $uriParts[5] ?? null;

// Instantiate the appropriate controller based on the endpoint
if ($endpoint == "getVideoId" && $_SERVER["REQUEST_METHOD"] == "GET") {
    $controller = new VideoController;
    $controller->getVideoId();
} else if ($endpoint == "getVideoId") {
    // CORS will do two calls to an endpoint (1.preflight(cors valition), 2.fetch(actual call)) and the first one is not a GET
    // This else if is exclusively so that the preflight call doesn't increase the id before the actual call
    http_response_code(200);
} else if ($endpoint == "uploadSegment" && $_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new VideoController;
    $controller->uploadSegment();
} else if ($endpoint == "uploadSegment"){
    // CORS will do two calls to an endpoint (1.preflight(cors valition), 2.fetch(actual call)) and the first one is not a GET
    // This else if is exclusively so that the preflight call doesn't increase the id before the actual call
    http_response_code(200);
} else if ($endpoint == "finishUpload/{$vid_ID}" && $_SERVER["REQUEST_METHOD"] == "GET") {
    $controller = new VideoController;
    $controller->finishUpload($vid_ID);
} else if ($endpoint == "finishUpload/{$vid_ID}"){
    // CORS will do two calls to an endpoint (1.preflight(cors valition), 2.fetch(actual call)) and the first one is not a GET
    // This else if is exclusively so that the preflight call doesn't increase the id before the actual call
    http_response_code(200);
} else {
    http_response_code(404);
}



