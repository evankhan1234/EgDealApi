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

if($_SERVER['REQUEST_METHOD'] === "GET"){





//            $datas = $user_obj->check_emails();

        $units=$user_obj->getBudget();

        if($units){

            http_response_code(200); // ok
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "data" => $units,
                "message" => "Budget Found"
            ));
        }else{

            http_response_code(200); //server error
            echo json_encode(array(

                "status" => 500,
                "success" => false,
                "message" => "No Budget Found"
            ));
        }


}

?>
