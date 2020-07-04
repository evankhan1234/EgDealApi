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



    if(!empty($data->CustomerId) && !empty($data->CustomerName)){



        $user_obj->customer_address_customer_id = $data->CustomerId;
        $user_obj->customer_address_customer_name = $data->CustomerName;
        $user_obj->customer_address_mobile = $data->MobileNumber;
        $user_obj->customer_address_alternative_mobile = $data->AlternativeMobileNumber;
        $user_obj->customer_address_flat = $data->Flat;
        $user_obj->customer_address_colony = $data->Colony;
        $user_obj->customer_address_landmark = $data->Landmark;
        $user_obj->customer_address_city_name = $data->City;
        $user_obj->customer_address_state_name = $data->State;
        $user_obj->customer_address_country_name = $data->Country;



        if ($user_obj->create_address()) {

            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Address has been created"

            ));
        } else {

            http_response_code(500);
            echo json_encode(array(
                "status" => 500,
                "success" => false,
                "message" => "Failed to save Address"
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
