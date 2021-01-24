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


    $headers = getallheaders();



    try{


        $user_obj->user_id = $data->Id;
        $user_obj->limit = $data->limit;
        $user_obj->page = $data->page;
        $user_obj->type = $data->type;

        $posts=$user_obj->getOwnPostPagination();

        if($posts){

            http_response_code(200); // ok
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "data" => $posts,
                "message" => "Post Found"
            ));
        }else{

            http_response_code(200); //server error
            echo json_encode(array(

                "status" => 200,
                "success" => true,
                "data" => $posts,
                "message" => "No Post Found"
            ));
        }
    }catch(Exception $ex){

        http_response_code(500); //server error
        echo json_encode(array(
            "status" => 501,
            "success" => false,
            "message" => $ex->getMessage()
        ));
    }


}

?>
