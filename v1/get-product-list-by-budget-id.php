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
    $user_obj->category_id = $data->CategoryId;
    $user_obj->type = $data->Type;
    if( $data->Type=="ar"){
        $users=$user_obj->getBudgetProductByCategoryIdByArabic();
    }
    else if($data->Type=="bn"){
        $users=$user_obj->getBudgetProductByCategoryIdByBangla();
    }
    else if($data->Type=="hi"){
        $users=$user_obj->getBudgetProductByCategoryIdByHindi();
    }
    else if($data->Type=="en"){
        $users=$user_obj->getBudgetProductByCategoryIdByEnglish();
    }
    if($users){
        http_response_code(200); // ok
        echo json_encode(array(
            "status" => 200,
            "success" => true,
            "data" => $users,
            "message" => "Item Found"
        ));
    }else{

        http_response_code(200); //server error
        echo json_encode(array(

            "status" => 200,
            "success" => false,
            "data" => $users,
            "message" => "No Item Found"
        ));
    }


}

?>
