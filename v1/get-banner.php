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
    $user_obj->income_type = $data->Type;
    if( $data->Type=="ar"){
        $banners=$user_obj->getBannerByArabic();
    }
    else if($data->Type=="bn"){
        $banners=$user_obj->getBannerByBangla();
    }
    else if($data->Type=="hi"){
        $banners=$user_obj->getBannerByHindi();
    }
    else if($data->Type=="en"){
        $banners=$user_obj->getBannerByEnglish();
    }

    http_response_code(200); // ok
    echo json_encode(array(
        "status" => 200,
        "success" => true,
        "data" => $banners,
        "message" => "Banners Found"
    ));


}

?>
