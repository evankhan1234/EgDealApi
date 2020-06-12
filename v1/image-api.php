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

if($_SERVER['REQUEST_METHOD'] === "POST") {


    if (isset($_FILES["uploaded_file"]["name"])) {
        $name = $_FILES['uploaded_file']["name"];
        $tmp_name = $_FILES['uploaded_file']["tmp_name"];
        $error = $_FILES['uploaded_file']["error"];

        if (!empty($name)) {
            $location = "./customer_img/";
            try {

                if (!is_dir($location)) {
                    mkdir($location);
                }
                if (move_uploaded_file($tmp_name, $location . $name)) {
                    $total="deal/v1/". $location . $name;
                    echo json_encode(array(
                        "status" => 200,
                        "success" => true,
                        "img_address" => $total,
                        "message" => "User Image Uploaded SuccessFull"
                    ));

                } else {
                    http_response_code(500); //server error
                    echo json_encode(array(
                        "status" => 501,
                        "success" => false,
                        "message" =>"UserId Missing"
                    ));
                }

            } catch (Exception $ex) {

                http_response_code(500); //server error
                echo json_encode(array(
                    "status" => 501,
                    "success" => false,
                    "message" => $ex->getMessage()
                ));
            }
        } else {
            echo json_encode("Please select a file");
        }
    }
}
?>
