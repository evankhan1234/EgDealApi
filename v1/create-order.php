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


    if(!empty($data->OrderNumber) && !empty($data->OrderDate)){


        $user_obj->order_number = $data->OrderNumber;
        $user_obj->order_date = $data->OrderDate;
        $user_obj->order_amount = $data->Amount;
        $user_obj->order_number_of_item = $data->NumberOfItem;
        $user_obj->order_customer_id = $data->CustomerId;
        $user_obj->order_customer_name = $data->CustomerName;
        $user_obj->order_customer_mobile = $data->CustomerMobile;
        $user_obj->order_delivery_contact_name = $data->DeliveryContactName;
        $user_obj->order_delivery_mobile_number = $data->DeliveryMobileNumber;
        $user_obj->order_alternative_mobile_number = $data->AlternativeMobileNumber;
        $user_obj->order_flat_house = $data->FlatHouse;
        $user_obj->order_colony_street = $data->ColonyStreet;
        $user_obj->order_landmark = $data->Landmark;
        $user_obj->order_city_name = $data->CityName;
        $user_obj->order_state_name = $data->StateName;
        $user_obj->order_country_name = $data->CountryName;
        $user_obj->order_entry_date_time = $data->EntryDateTime;
        $user_obj->order_status = $data->OrderStatus;
        $user_obj->order_delivery_by = $data->DeliveryBy;
        $user_obj->order_delivery_discount = $data->Discount;
        $user_obj->order_delivery_charge = $data->Charge;
        $user_obj->order_delivery_date_time = $data->DeliveryDateTime;

        if ($user_obj->create_order())
        {
            $datas = $user_obj->check_order();
            $id=$datas["order_id"];
            $user_obj->create_order_details();
            foreach ($data->data as $val)
            {
                $user_obj->order_id = $id;
                $user_obj->order_details_item_id = $val->ItemId;
                $user_obj->order_details_item_quantity = $val->Quantity;
                $user_obj->order_details_old_price = $val->OldPrice;
                $user_obj->order_details_price = $val->Price;
                $user_obj->order_details_amount = $val->Amount;
                $user_obj->order_details_product_code = $val->ProductCode;
                $user_obj->order_details_item_name = $val->ItemName;
                $user_obj->order_details_category_name = $val->CategoryName;
                $user_obj->order_details_sub_category_name = $val->SubCategoryName;
                $user_obj->order_details_color = $val->Color;
                $user_obj->order_details_size = $val->Size;
                if($user_obj->create_order_details()){
                }
            }
            http_response_code(200);
            echo json_encode(array(
                "status" => 200,
                "success" => true,
                "message" => "Order  has been created"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "status" => 500,
                "success" => false,
                "message" => "Failed to save Order"
            ));
        }


    }


}else{

    http_response_code(500);
    echo json_encode(array(
        "status" => 500,
        "success" => false,
        "message" => "Access Denied"
    ));
}

?>
