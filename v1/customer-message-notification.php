<?php
ini_set("display_errors", 1);

//include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] === "POST"){

    // body
    $data = json_decode(file_get_contents("php://input"));

    /*Variable :
            MobileNumber
            EmailAddress
            MessageBody
            MessageSubject
    */

    if(!empty($data->MobileNumber) && preg_match("/\+?(88)?01[3456789][0-9]{8}\b/",substr($data->MobileNumber,-11))){

        $username = "engrmahi22";
        $hash = "9884d70a969a52a8c2fe8df89901d27b";
        $number = substr($data->MobileNumber,-11);
        $params = array('app'=>'ws', 'u'=>$username, 'h'=>$hash, 'op'=>'pv', 'unicode'=>'1','to'=>$number, 'msg'=>'Code: 9#ERTKSKSKSHHA289');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://alphasms.biz/index.php?".http_build_query($params, "", "&"));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Accept:application/json"));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($ch);

        $res = json_decode($response);
        if (strtoupper($res->data[0]->status) == 'OK'):
            http_response_code(200); // ok
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Send Successfully"
            ));
        endif;
        curl_close ($ch);
    }


}else{

    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied"
    ));
}

?>
