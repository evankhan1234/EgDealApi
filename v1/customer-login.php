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

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->Password)) {

        $user_obj->customer_mobile_number = $data->ContactNumber;
        $user_obj->customer_password = md5($data->Password);
        $user_data = $user_obj->check_customer_login();
        if ($user_data != null)
        { //
            $datas = $user_obj->customer_login();
            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "data" => $datas,
                "message" => "User logged in successfully"
            ));

        } else {

            http_response_code(200);

            echo json_encode(array(
                "status" => 200,
                "success" => false,
                "message" => "Invalid credentials"
            ));
        }

    } else {

        http_response_code(404);
        echo json_encode(array(
            "status" => 503,
            "success" => false,
            "message" => "All data needed"
        ));
    }
}
