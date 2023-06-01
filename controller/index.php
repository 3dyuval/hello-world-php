<?php
require_once 'config/database.php';

header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {

    $sql = "SELECT * from names";
    $result = $conn->query($sql);

    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    
    echo json_encode($rows);

}

if ($method == "POST") {
    $body = file_get_contents('php://input');
    $data = json_decode($body);
    $firstName = $data->firstName ?? '';
    $lastName = $data->lastName ?? '';
    
    if (strlen($firstName) === 0 || strlen($lastName) === 0) {
        http_response_code(400);
        echo "Invalid first name or last name";
        return;
    }

    $sql = "INSERT INTO names (first_name, last_name) VALUES ('$firstName', '$lastName')";    
    $result = $conn->query($sql);
        
    if (!$result) {
        http_response_code(500);
        echo 'Error inserting data into database';
        return;
    }

    $id = $conn->insert_id;
    http_response_code(201);
    echo "Hello $firstName $lastName! Your id is $id";
}


if ($method == "PUT"){

    $body = file_get_contents('php://input');
    $data = json_decode($body);

    $firstName = $data->firstName ?? '';
    $lastName = $data->lastName ?? '';
    $id = $data->id;
    
    if (strlen($firstName) === 0 || strlen($lastName) === 0) {
        http_response_code(400);
        echo "Invalid first name or last name";
        return;
    }

    $sql = "UPDATE names
    SET first_name = '$firstName', last_name = '$lastName'
    WHERE id=$id";

    $result = $conn->query($sql);

    if ($result && $conn->affected_rows > 0) {
        http_response_code(202);
        echo 'Deleted';
        return;
    } 

    http_response_code(404);
    header("Content-Type: application-json");
    echo json_encode(["error" => "Resource not found"]);

}

if ($method == 'DELETE') {
    $body = file_get_contents("php://input");
    $data = json_decode($body);

    $id = $data->id;

    $sql = "DELETE FROM names WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $conn->affected_rows > 0) {
        http_response_code(204);
        echo 'Deleted';
        return;
    } 

    http_response_code(404);
    header("Content-Type: application-json");
    echo json_encode(["error" => "Resource not found"]);
    
}


?>