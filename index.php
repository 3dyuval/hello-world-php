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

    $id = $conn->insert_id;
    
    echo "Hello $firstName $lastName! Your id is $id";
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

if ($method == "PUT"){

    $body = file_get_contents('php://input');
    $data = json_decode($body);

    $firstName = $data->firstName;
    $lastName = $data->lastName;
    $id = $data->id;
    
    $sql = "UPDATE names
    SET first_name = '$firstName', last_name = '$lastName'
    WHERE id=$id";

    $result = $conn->query($sql);

    if ($result && $conn->affected_rows > 0) {
        echo 'Deleted';
    } else {
        http_response_code(404);
        header("Content-Type: application-json");
        echo json_encode(["error" => "Resource not found"]);
    }
}

if ($method == 'DELETE') {
    $body = file_get_contents("php://input");
    $data = json_decode($body);

    $id = $data->id;

    $sql = "DELETE FROM names WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $conn->affected_rows > 0) {
        echo 'Deleted';
    } else {
        http_response_code(404);
        header("Content-Type: application-json");
        echo json_encode(["error" => "Resource not found"]);
    }
}


?>