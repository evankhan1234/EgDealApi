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
    $user_obj->income_type = $data->Type;
    $user_obj->limit = $data->limit;
    $user_obj->page = $data->page;

    $users=$user_obj->getCategory();
    $result_array = array();
    $sub_user_array = array();

    if($users){
        foreach ($users as $val) {
            $user_obj->category_id =$val['category_id'];


            if($data->Type=="ar"){
                $banner=$user_obj->getBannerByCategoryIdArabic();
                $result_array=$user_obj->getProductByCategoryIdByArabic();
            }
            else if($data->Type=="bn"){
                $banner=$user_obj->getBannerByCategoryIdBangla();
                $result_array=$user_obj->getProductByCategoryIdByBangla();
            }
            else if($data->Type=="hi"){
                $banner=$user_obj->getBannerByCategoryIdHindi();
                $result_array=$user_obj->getProductByCategoryIdByHindi();
            }
            else if($data->Type=="en"){
                $banner=$user_obj->getBannerByCategoryIdEnglish();
                $result_array=$user_obj->getProductByCategoryIdByEnglish();
            }
            //$banner=$user_obj->getBannerByCategoryId();
            $sub_user_array[$val['category_id']]['category_id']=$val['category_id'];
            $sub_user_array[$val['category_id']]['category_name']=$val['category_name'];
            $sub_user_array[$val['category_id']]['banner']=$banner;
            $sub_user_array[$val['category_id']]['category']=$result_array;
        }
        $return_data = array();
        foreach($sub_user_array as $value){
            $return_data[] = $value;
        }
        http_response_code(200); // ok
        echo json_encode(array(
            "status" => 200,
            "success" => true,
            "data" => $return_data,
            "message" => "Users Found"
        ));
    }else {
        http_response_code(200); //server error
        echo json_encode(array(
            "status" => 200,
            "success" => false,
            "message" => "No Users Found"
        ));
    }
}
?>
