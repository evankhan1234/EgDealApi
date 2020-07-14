<?php

ini_set("display_errors", 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

// including files
include_once("../config/database.php");
include_once("../classes/Users.php");

//objects
$db = new Database();

$connection = $db->connect();

$user_obj = new Users($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){

    // body
    $data = json_decode(file_get_contents("php://input"));



    if(!empty($data->ServiceId) && !empty($data->CustomerId)){




        $user_obj->customer_id = $data->CustomerId;
        $user_obj->service_id = $data->ServiceId;


        if ($user_obj->create_favorite()) {

            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Favorite has been created"

            ));
        } else {

            http_response_code(500);
            echo json_encode(array(
                "status" => 500,
                "success" => false,
                "message" => "Failed to save Favorite"
            ));
        }


    }


}else{

    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}

?>
