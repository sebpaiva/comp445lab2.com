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

$uriParts = explode("/", $_SERVER["REQUEST_URI"]);

// Get first uri parameter
$id = $uriParts[4] ?? null;

$controller = new VideoController;
$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);

?>