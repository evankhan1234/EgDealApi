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

    $data = json_decode(file_get_contents("php://input"));

    $user_obj->service_id = $data->ServiceId;
    $user_obj->service_banner = $data->Banner;
    $user_obj->service_image = $data->Image;
    $user_obj->service_owner_name = $data->OwnerName;
    $user_obj->service_type = $data->Type;
    $user_obj->service_contact_number = $data->ContactNumber;
    $user_obj->service_name = $data->ServiceName;
    $user_obj->service_dialog = $data->ServiceDialog;
    $user_obj->service_details = $data->ServiceDetails;


    if($user_obj->update_service()){

        http_response_code(200); // ok
        echo json_encode(array(
            "status" => 200,
            "success" => true,
            "message" => "Updated SuccessFull"
        ));
    }else{

        http_response_code(500); //server error
        echo json_encode(array(

            "status" => 500,
            "success" => false,
            "message" => "Failed to Updated "
        ));
    }

}

?>
