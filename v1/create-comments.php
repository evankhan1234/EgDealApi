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

    if(!empty($data->Name) && !empty($data->Content)){

        try{

            $user_obj->comments_user_id = $data->Id;
            $user_obj->comments_post_id = $data->PostId;
            $user_obj->comments_type = $data->Type;
            $user_obj->comments_content= $data->Content;
            $user_obj->comments_created = $data->Created;
            $user_obj->comments_image = $data->Image;
            $user_obj->comments_name= $data->Name;
            $user_obj->comments_love = $data->Love;
            $user_obj->comments_status = $data->Status;
            $user_obj->comments_country = $data->Country;
            if($user_obj->create_comments()){

                http_response_code(200); // ok
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Comments has been created"
                ));
            }else{

                http_response_code(500); //server error
                echo json_encode(array(

                    "status" => 500,
                    "success" => false,
                    "message" => "Failed to Create Comments"
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
    }else{

        http_response_code(404); // not found
        echo json_encode(array(
            "status" => 503,
            "success" => false,
            "message" => "All data needed"
        ));
    }
}

?>
