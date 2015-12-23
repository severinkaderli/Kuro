<?php

//Declaring some constants and $_SERVER variables that are needed for the 
//framework but are set by the cli-php by default.
$_SERVER["SERVER_NAME"] = "example.com";

define("__ROOT__", __DIR__ . "/");
define("PROTOCOL", "http://");
define("BASE_URL", PROTOCOL . $_SERVER["SERVER_NAME"] . "/subdir/kuro");
define("SERVER_URL", PROTOCOL . $_SERVER['SERVER_NAME']);
define("BASE_PATH", str_replace(SERVER_URL, "", BASE_URL));

//Include the composer autoload file
require_once("./vendor/autoload.php");