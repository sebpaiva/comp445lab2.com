<?php

// Used for CORS
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Methods:GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Origin,Accept,X-Requested-With,Content-Type,Access-Control-Request-Method,Access-Control-Request-Headers,Access-Control-Allow-Credentials");

// Used for imports
spl_autoload_register(function ($class){
    require __DIR__ . "./src/$class.php";
});

// Get the URI parts
$uriParts = explode("/", $_SERVER["REQUEST_URI"]);

// Determine the requested endpoint
$endpoint = $uriParts[4] ?? null;

// Instantiate the appropriate controller based on the endpoint
if ($endpoint == "getVideoId") {
    $controller = new VideoController;
    $controller->getVideoId();
} else {
    http_response_code(404);
}