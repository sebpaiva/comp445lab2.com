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
if ($endpoint == "getVideoId" && $_SERVER["REQUEST_METHOD"] == "GET") {
    $controller = new VideoController;
    $controller->getVideoId();
}
// Don't add an `else` here with an error, CORS will do two calls to an endpoint (1.preflight(cors valition), 2.fetch(actual call)) and the first one is not a GET but an OPTION
// Adding an else makes that preflight fail and the fetch never happens