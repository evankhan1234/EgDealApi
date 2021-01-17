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



    if(!empty($data->ProductName) && !empty($data->Description)){



        $user_obj->product_name = $data->ProductName;
        $user_obj->product_price = $data->Price;
        $user_obj->product_code = $data->Code;
        $user_obj->product_description = $data->Description;
        $user_obj->product_image1 = $data->Image1;
        $user_obj->product_image2 = $data->Image2;
        $user_obj->product_image3 = $data->Image3;
        $user_obj->product_image4 = $data->Image4;
        $user_obj->service_id = $data->ServiceId;
        $user_obj->category_id = $data->CategoryId;
        $user_obj->category_name = $data->CategoryName;
        $user_obj->sub_category_id = $data->SubCategoryId;



        if ($user_obj->create_product()) {

            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Product has been created"

            ));
        } else {

            http_response_code(500);
            echo json_encode(array(
                "status" => 500,
                "success" => false,
                "message" => "Failed to save Product"
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
