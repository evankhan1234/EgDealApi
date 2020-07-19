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



    if(!empty($data->MobileNumber) && !empty($data->Code)){



        $user_obj->reset_mobile_number = $data->MobileNumber;
        $user_obj->reset_code = $data->Code;
        $user_obj->reset_password = md5($data->Password);
        if ($data->Code==="3#GDKSKSKSHHA234"){
            if($user_obj->update_reset_password_service()){

                http_response_code(200); // ok
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Updated SuccessFull"
                ));
            }else{

                http_response_code(500); //server error
                echo json_encode(array(

                    "status" => 200,
                    "success" => false,
                    "message" => "Failed to Updated "
                ));
            }

        }
        else{
            echo json_encode(array(
                "status" => 200,
                "success" => false,
                "message" => "Code is invalid"
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
