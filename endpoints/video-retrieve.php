<?php

// include("./src/VideoController.php");

// Used for imports
spl_autoload_register(function ($class){
    require __DIR__ . "./src/$class.php";
});

$uriParts = explode("/", $_SERVER["REQUEST_URI"]);
// print_r($uriParts);

// Get first uri parameter
$id = $uriParts[4] ?? null;

$controller = new VideoController;
$controller->processRequest($_SERVER["REQUEST_METHOD"], $id);

?>