<?php

header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connections failed:" . $conn->connect_error);
}


if ($method == "POST") {
    $body = file_get_contents('php://input');
    $data = json_decode($body);

    $firstName = $data->firstName;
    $lastName = $data->lastName;

    
    $sql = "INSERT INTO names (first_name, last_name) VALUES ('$firstName', '$lastName')";
    
    $result = $conn->query($sql);
    echo "Hello $firstName $lastName";

    echo $result;
}

if ($method == "GET") {

    $sql = "SELECT * from names";
    $result = $conn->query($sql);

    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    

    echo json_encode($rows);

}

// POST {firstName: string, lastName: string},

// get /names     -> firstNames...lastNames...


?>