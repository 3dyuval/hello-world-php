<?php

header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];


echo "Hello World. Your request: '$method'";


?>