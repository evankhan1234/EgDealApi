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

    if(!empty($data->Username) && !empty($data->Content)){

        try{

            $user_obj->reply_comments_id = $data->CommentId;
            $user_obj->reply_type = $data->Type;
            $user_obj->reply_content= $data->Content;
            $user_obj->reply_created = $data->Created;
            $user_obj->reply_image = $data->UserImage;
            $user_obj->reply_name= $data->Username;
            $user_obj->reply_status = $data->Status;
            $user_obj->reply_country = $data->Country;

            if($user_obj->create_reply()){

                http_response_code(200); // ok
                echo json_encode(array(
                    "status" => 200,
                    "success" => true,
                    "message" => "Reply has been created"
                ));
            }else{

                http_response_code(500); //server error
                echo json_encode(array(

                    "status" => 500,
                    "success" => false,
                    "message" => "Failed to Create Reply"
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
