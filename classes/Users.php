<?php

class Users{
  // define properties
  public $owner_name;
  public $owner_phone;
  public $type;
  public $password;
  public $status;
  public $latitude;
  public $longitude;
  public $username;
  public $created;
  public $user_id;
  public $service_id;
  public $category_id;
  public $service_banner;
  public $service_image;
  public $service_type;
  public $service_owner_name;
  public $service_contact_number;
  public $service_details;
  public $service_dialog;
  public $service_name;
  public $product_name;
  public $product_price;
  public $product_description;
  public $product_image1;
  public $product_image2;
  public $product_image3;
  public $product_image4;

  private $conn;




  public function __construct($db){
     $this->conn = $db;
  }

    public function check_user(){

        $user_query = "SELECT * from mkt_service WHERE username = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("s",  $this->username);
        if($usr_obj->execute()){
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }
    public function create_user(){

        $supplier_query = "INSERT INTO  mkt_service SET owner_name = ?, contact_number = ?, status = ?, created_date =?, latitude =?,longitude =?,username=?, password=?,type=?";

        $supplier_obj = $this->conn->prepare($supplier_query);

        $supplier_obj->bind_param("sssssssss", $this->owner_name, $this->owner_phone,$this->status, $this->created, $this->latitude, $this->longitude, $this->username, $this->password, $this->type);

        if($supplier_obj->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function create_product(){

        $query = "INSERT INTO  inv_item SET item_name = ?, price = ?, product_desc = ?, product_img1 =?, product_img2 =?,product_img3 =?,product_img4=?, service_id=?";

        $obj = $this->conn->prepare($query);

        $obj->bind_param("ssssssss", $this->product_name, $this->product_price,$this->product_description, $this->product_image1, $this->product_image2, $this->product_image3, $this->product_image4, $this->service_id);

        if($obj->execute()){
            return true;
        }
        else{
            return false;
        }
    }
    public function check_customer_login_details(){
        $user_query = "Select * from mkt_service WHERE username = ? AND password = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("ss", $this->username,$this->password);
        if($usr_obj->execute()){
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }

        return array();
    }
    public function check_customer_for(){

        $user_query = "Select * from mkt_service WHERE username = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("s", $this->username);

        if($usr_obj->execute()){

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }
        public function getUser()
        {
            $result = $this->conn->query("Select * from mkt_service WHERE status=1");
            $units = array();
            while ($item = $result->fetch_assoc())
                $units[] = $item;
            return $units;

        }
    public function getCategory()
    {
        $result = $this->conn->query("Select category_id,category_name from inv_category");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }
    public function getProductLByCategoryId(){
        $query=("SELECT * from inv_item where category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s",$this->category_id);
        $units=array();
        if($obj->execute()){
            $data = $obj->get_result();
            while ($item=$data->fetch_assoc())
                $units[]=$item;
            return $units;
        }
    }

    public function getBannerByCategoryId(){
        $user_details_query=("Select * from gbl_banner  where category_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s",$this->category_id);
        if($user_details_obj->execute()){
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }
    public function getProductList(){
        $query=("SELECT item_name,price,product_desc,product_img1,product_img2,product_img3,product_img4 from inv_item where service_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s",$this->service_id);
        $units=array();
        if($obj->execute()){
            $data = $obj->get_result();
            while ($item=$data->fetch_assoc())
                $units[]=$item;
            return $units;
        }
    }
    public function getCustomerUserInformation(){
        $user_details_query=("Select * from mkt_service where service_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s",$this->user_id);
        if($user_details_obj->execute()){
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }
    public function update_service(){
        $delivery_query = "UPDATE mkt_service SET service_banner=?,service_image=?,owner_name=?,type=?,contact_number=?,service_name=?,service_dialog=?,service_details=? Where service_id=?  ";
        $delivery_obj = $this->conn->prepare($delivery_query);
        $delivery_obj->bind_param("sssssssss", $this->service_banner, $this->service_image, $this->service_owner_name, $this->service_type, $this->service_contact_number, $this->service_name, $this->service_dialog, $this->service_details, $this->service_id);
        if($delivery_obj->execute()){
            return true;
        }
        return false;

    }
}

 ?>
