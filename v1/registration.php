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



    if(!empty($data->OwnerName) && !empty($data->ContactNumber)){



            $user_obj->owner_name = $data->OwnerName;
            $user_obj->type = $data->Type;
            $user_obj->owner_phone = $data->ContactNumber;
            $user_obj->username = $data->UserName;
            $user_obj->password = md5($data->Password);
            $user_obj->status = $data->Status;
            $user_obj->latitude = $data->Latitude;
            $user_obj->longitude = $data->Longitude;
            $user_obj->created = $data->Created;

            $user_data = $user_obj->check_user();

            if (!empty($user_data)) {
                // some data we have - insert should not go
                http_response_code(200);
                echo json_encode(array(
                    "status" => 200,
                    "success" => false,
                    "message" => "User already exists, try another user"
                ));
            } else {

                if ($user_obj->create_user()) {

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "message" => "User has been created"

                    ));
                } else {

                    http_response_code(500);
                    echo json_encode(array(
                        "status" => 500,
                        "success" => false,
                        "message" => "Failed to save User"
                    ));
                }
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
