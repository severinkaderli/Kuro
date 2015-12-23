<?php
//Root path to the kuro directory -> /var/www/html/kuro
define("__ROOT__", __DIR__ . "/");

//Either http:// or https://
define("PROTOCOL", (isset($_SERVER["https"]) ? "https://" : "http://"));

//Url to the directory of kuro -> http://example.com/path/to/kuro
define("BASE_URL", PROTOCOL . dirname($_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']));

//Url of the server -> http://example.com
define("SERVER_URL", PROTOCOL . $_SERVER['SERVER_NAME']);

//Only the path of Kuro -> /path/to/kuro
define("BASE_PATH", str_replace(SERVER_URL, "", BASE_URL));