<?php

//Here I set some PHP $_SERVER variables that are not set in cli mode but
//that I use in my code.
$_SERVER["SERVER_NAME"] = "example.com";

//Include the constants for the framework the classes.
require_once("./init.php");
require_once("./vendor/autoload.php");