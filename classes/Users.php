<?php

class Users
{
    // define properties
    public $reset_mobile_number;
    public $reset_code;
    public $reset_password;
    public $owner_name;
    public $owner_phone;
    public $type;
    public $password;
    public $status;
    public $latitude;
    public $longitude;
    public $username;
    public $customer_mobile_number;
    public $created;
    public $user_id;
    public $banner_id;
    public $item_id;
    public $service_id;
    public $customer_id;
    public $category_id;
    public $category_name;
    public $service_banner;
    public $service_image;
    public $service_type;
    public $service_country;
    public $service_city;
    public $service_owner_name;
    public $service_contact_number;
    public $service_details;
    public $service_dialog;
    public $service_name;
    public $product_name;
    public $product_price;
    public $product_code;
    public $product_description;
    public $product_image1;
    public $product_image2;
    public $product_image3;
    public $product_image4;
    public $search;
    public $sub_category_id;
    public $income_type;
    public $customer_name;
    public $customer_image;
    public $customer_email;
    public $customer_android;
    public $customer_password;
    public $help_name;
    public $help_email;
    public $help_mobile;
    public $help_subject;
    public $help_comments;
    public $limit;
    public $page;
    public $order_number;
    public $order_date;
    public $order_amount;
    public $order_number_of_item;
    public $order_customer_id;
    public $order_customer_name;
    public $order_customer_mobile;
    public $order_delivery_contact_name;
    public $order_delivery_mobile_number;
    public $order_alternative_mobile_number;
    public $order_flat_house;
    public $order_colony_street;
    public $order_landmark;
    public $order_city_name;
    public $order_state_name;
    public $order_country_name;
    public $order_entry_date_time;
    public $order_status;
    public $order_delivery_by;
    public $order_delivery_charge;
    public $order_delivery_discount;
    public $order_delivery_date_time;
    public $customer_address_customer_id;
    public $customer_address_customer_name;
    public $customer_address_mobile;
    public $customer_address_alternative_mobile;
    public $customer_address_flat;
    public $customer_address_colony;
    public $customer_address_landmark;
    public $customer_address_city_name;
    public $customer_address_state_name;
    public $customer_address_country_name;

    public $comments;
    public $review;
    public $order_id;

    public $order_details_item_id;
    public $order_details_item_quantity;
    public $order_details_price;
    public $order_details_old_price;
    public $order_details_amount;
    public $order_details_product_code;
    public $order_details_item_name;
    public $order_details_category_name;
    public $order_details_sub_category_name;
    public $order_details_color;
    public $order_details_size;

    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function check_customer()
    {

        $user_query = "SELECT * from mkt_customer WHERE mobile_number = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("s", $this->customer_mobile_number);
        if ($usr_obj->execute()) {
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_user()
    {

        $user_query = "SELECT * from mkt_service WHERE username = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("s", $this->username);
        if ($usr_obj->execute()) {
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_order()
    {
        $query = "INSERT INTO sls_order SET order_number =?, order_date =?, order_amount =?, number_of_item =?, customer_id =?,customer_name =?, customer_mobile =?, delivery_contact_name=?, delivery_mobile_number =?, alternative_mobile_number =?,flat_house =?, colony_street =?, landmark=?, city_name =?, state_name =?,country_name =?, entry_dttm =?,delivery_dttm=?,order_status=?,delivery_by=?,delivery_charge=?,discount=?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("ssssssssssssssssssssss", $this->order_number, $this->order_date, $this->order_amount, $this->order_number_of_item, $this->order_customer_id, $this->order_customer_name, $this->order_customer_mobile, $this->order_delivery_contact_name, $this->order_delivery_mobile_number, $this->order_alternative_mobile_number, $this->order_flat_house, $this->order_colony_street, $this->order_landmark, $this->order_city_name, $this->order_state_name, $this->order_country_name, $this->order_entry_date_time, $this->order_delivery_date_time, $this->order_status, $this->order_delivery_by, $this->order_delivery_charge, $this->order_delivery_discount);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function check_order()
    {

        $email_query = "Select * from sls_order WHERE customer_id = ? AND entry_dttm = ?";
        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param("ss", $this->order_customer_id, $this->order_entry_date_time);

        if ($usr_obj->execute()) {

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }

    public function create_order_details()
    {

        $product_querys = "INSERT INTO sls_order_details SET order_id = ?, item_id = ?, item_qty = ?, price =?, old_price =?,amount =?,product_code =?, item_name =?, category_name=?,subcategory_name=?,item_color=?,item_size=?";

        $product_objs = $this->conn->prepare($product_querys);

        $product_objs->bind_param("ssssssssssss", $this->order_id, $this->order_details_item_id, $this->order_details_item_quantity, $this->order_details_price, $this->order_details_old_price, $this->order_details_amount, $this->order_details_product_code, $this->order_details_item_name, $this->order_details_category_name, $this->order_details_sub_category_name, $this->order_details_color, $this->order_details_size);

        if ($product_objs->execute()) {
            return true;

        } else {

            return false;
        }


    }

    public function create_user()
    {

        $supplier_query = "INSERT INTO  mkt_service SET owner_name = ?, contact_number = ?, status = ?, created_date =?, latitude =?,longitude =?,username=?, password=?,type=?";

        $supplier_obj = $this->conn->prepare($supplier_query);

        $supplier_obj->bind_param("sssssssss", $this->owner_name, $this->owner_phone, $this->status, $this->created, $this->latitude, $this->longitude, $this->username, $this->password, $this->type);

        if ($supplier_obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function create_customer()
    {
        $query = "INSERT INTO  mkt_customer SET customer_name = ?, mobile_number = ?, email_address = ?, password =?, android =?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("sssss", $this->customer_name, $this->customer_mobile_number, $this->customer_email, $this->customer_password, $this->customer_android);
        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function create_product()
    {

        $query = "INSERT INTO  inv_item SET item_name = ?,product_code = ?, price = ?, product_desc = ?, product_img1 =?, product_img2 =?,product_img3 =?,product_img4=?, service_id=?,category_id=?,category_name=?,subcategory_id=?";

        $obj = $this->conn->prepare($query);

        $obj->bind_param("ssssssssssss", $this->product_name,$this->product_code, $this->product_price, $this->product_description, $this->product_image1, $this->product_image2, $this->product_image3, $this->product_image4, $this->service_id, $this->category_id, $this->category_name, $this->sub_category_id);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function create_help()
    {
        $query = "INSERT INTO  help SET name = ?, email = ?, mobile = ?, subject =?, comments =?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("sssss", $this->help_name, $this->help_email, $this->help_mobile, $this->help_subject, $this->help_comments);
        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getBudget()
    {
        $result = $this->conn->query("Select * from budget_category");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;
    }

    public function create_favorite()
    {

        $query = "INSERT INTO  mkt_service_favorite SET service_id = ?, customer_id = ?";

        $obj = $this->conn->prepare($query);

        $obj->bind_param("ss", $this->service_id, $this->customer_id);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function create_rating()
    {

        $query = "INSERT INTO  mkt_service_review SET service_id = ?, customer_id = ?,comments=?,review=?";

        $obj = $this->conn->prepare($query);

        $obj->bind_param("ssss", $this->service_id, $this->customer_id, $this->comments, $this->review);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function create_follow()
    {

        $query = "INSERT INTO  mkt_service_follow SET service_id = ?, customer_id = ?";

        $obj = $this->conn->prepare($query);

        $obj->bind_param("ss", $this->service_id, $this->customer_id);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_product()
    {
        $purchase_delete_type_query = "DELETE FROM inv_item  Where item_id=? and service_id=? ";
        $purchase_delete_type_obj = $this->conn->prepare($purchase_delete_type_query);
        $purchase_delete_type_obj->bind_param("ss", $this->item_id, $this->service_id);
        if ($purchase_delete_type_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_favorite()
    {
        $query = "DELETE FROM mkt_service_favorite Where service_id=?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->service_id);
        if ($obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_follow()
    {
        $query = "DELETE FROM mkt_service_follow Where service_id=?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->service_id);
        if ($obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_address()
    {

        $query = "INSERT INTO  mkt_customer_address SET customer_id = ?, contact_name = ?, mobile_number = ?, alternative_mobile_number =?, flat_house =?,colony_street =?,landmark=?, city_name=?, state_name=?, country_name=?";

        $obj = $this->conn->prepare($query);

        $obj->bind_param("ssssssssss", $this->customer_address_customer_id, $this->customer_address_customer_name, $this->customer_address_mobile, $this->customer_address_alternative_mobile, $this->customer_address_flat, $this->customer_address_colony, $this->customer_address_landmark, $this->customer_address_city_name, $this->customer_address_state_name, $this->customer_address_country_name);

        if ($obj->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_customer_login_details()
    {
        $user_query = "Select * from mkt_service WHERE username = ? AND password = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("ss", $this->username, $this->password);
        if ($usr_obj->execute()) {
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_customer_login()
    {

        $email_query = "Select * from mkt_customer WHERE
  (mobile_number = ? AND password = ?) OR
  (email_address = ? AND password = ?)";
        $usr_obj = $this->conn->prepare($email_query);
        $usr_obj->bind_param("ssss", $this->customer_mobile_number, $this->customer_password, $this->customer_mobile_number, $this->customer_password);
        if ($usr_obj->execute()) {
            $data = $usr_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_customer_for()
    {

        $user_query = "Select * from mkt_service WHERE username = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("s", $this->username);

        if ($usr_obj->execute()) {

            $data = $usr_obj->get_result();

            return $data->fetch_assoc();
        }

        return array();
    }

    public function customer_login()
    {

        $user_query = "Select * from mkt_customer WHERE mobile_number = ?";
        $usr_obj = $this->conn->prepare($user_query);
        $usr_obj->bind_param("s", $this->customer_mobile_number);


        if ($usr_obj->execute()) {

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

    public function getBannerByEnglish()
    {
        $result = $this->conn->query("Select banner_id, banner_title as title,	banner_img as image,banner_desc as description from gbl_banner WHERE banner_position=1 AND 	category_id=0");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getBannerByBangla()
    {
        $result = $this->conn->query("Select banner_id,banner_title_bn as title,	banner_img_bn as image,banner_desc_bn as description from gbl_banner WHERE banner_position=1 AND category_id=0");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getBannerByArabic()
    {
        $result = $this->conn->query("Select banner_id,banner_title_ar as title,	banner_img_ar as image,banner_desc_ar as description from gbl_banner WHERE banner_position=1 AND 	category_id=0");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getBannerByHindi()
    {
        $result = $this->conn->query("Select banner_id,banner_title_hi as title,banner_img_hi as image,banner_desc_hi as description from gbl_banner WHERE banner_position=1 AND 	category_id=0");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getCategory()
    {
        $query = ("Select category_id,category_name from inv_category ORDER BY category_id  LIMIT? OFFSET?");
        $obj = $this->conn->prepare($query);
        $page=$this->page-1;
        $offset_page=$this->limit*$page;
        $obj->bind_param("ss",$this->limit,$offset_page);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSearchByEnglish()
    {
        $query = ("SELECT item_id,item_name as item_name,category_id,category_name as category_name,subcategory_id,subcategory_name as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1 as meta_keyword1,meta_keyword2 as meta_keyword2,meta_keyword3 as meta_keyword3,earning_point,service_id,category_ind  from inv_item where  item_name LIKE ?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->search);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getFavoriteServiceList()
    {
        $query = ("SELECT s.service_name,s.service_banner FROM mkt_service_favorite AS mk INNER JOIN mkt_service AS s ON mk.service_id=s.service_id WHERE  mk.customer_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->customer_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getCommentList()
    {
        $query = ("SELECT c.customer_name,mk.comments,mk.review FROM mkt_service_review AS mk INNER JOIN mkt_customer AS c ON mk.customer_id=c.customer_id WHERE  mk.service_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->service_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSearchByBangla()
    {
        $query = ("SELECT item_id,item_name as item_name,category_id,category_name as category_name,subcategory_id,subcategory_name as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1 as meta_keyword1,meta_keyword2 as meta_keyword2,meta_keyword3 as meta_keyword3,earning_point,service_id,category_ind  from inv_item where  item_name_bn LIKE ?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->search);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSearchByArabic()
    {
        $query = ("SELECT item_id,item_name_ar as item_name,category_id,category_name_ar as category_name,subcategory_id,subcategory_name_ar as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_ar as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_ar as meta_keyword1,meta_keyword2_ar as meta_keyword2,meta_keyword3_ar as meta_keyword3,earning_point,service_id,category_ind  from inv_item where  item_name_ar LIKE ?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->search);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSearchByHindi()
    {
        $query = ("SELECT item_id,item_name_hi as item_name,category_id,category_name_hi as category_name,subcategory_id,subcategory_name_hi as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_hi as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_hi as meta_keyword1,meta_keyword2_hi as meta_keyword2,meta_keyword3_hi as meta_keyword3,earning_point,service_id,category_ind  from inv_item where  item_name_hi LIKE ?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->search);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductForSearchByEnglish()
    {
        $result = $this->conn->query("SELECT item_id,item_name as item_name,category_id,category_name as category_name,subcategory_id,subcategory_name as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1 as meta_keyword1,meta_keyword2 as meta_keyword2,meta_keyword3 as meta_keyword3,earning_point,service_id,category_ind  from inv_item");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getProductForSearchByBangla()
    {
        $result = $this->conn->query("SELECT item_id,item_name_bn as item_name,category_id,category_name_bn as category_name,subcategory_id,subcategory_name_bn as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_bn as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_bn as meta_keyword1,meta_keyword2_bn as meta_keyword2,meta_keyword3_bn as meta_keyword3,earning_point,service_id,category_ind  from inv_item");

        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getProductForSearchByHindi()
    {
        $result = $this->conn->query("SELECT item_id,item_name_hi as item_name,category_id,category_name_hi as category_name,subcategory_id,subcategory_name_hi as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_hi as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_hi as meta_keyword1,meta_keyword2_hi as meta_keyword2,meta_keyword3_hi as meta_keyword3,earning_point,service_id,category_ind  from inv_item");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getProductForSearchByArabic()
    {
        $result = $this->conn->query("SELECT item_id,item_name_ar as item_name,category_id,category_name_ar as category_name,subcategory_id,subcategory_name_ar as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_ar as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_ar as meta_keyword1,meta_keyword2_ar as meta_keyword2,meta_keyword3_ar as meta_keyword3,earning_point,service_id,category_ind  from inv_item ");

        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getProductByCategoryIdByEnglish()
    {
        $query = ("SELECT item_id,item_name as item_name,category_id,category_name as category_name,subcategory_id,subcategory_name as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1 as meta_keyword1,meta_keyword2 as meta_keyword2,meta_keyword3 as meta_keyword3,earning_point,service_id,category_ind  from inv_item where category_id=?");
        $obj = $this->conn->prepare($query);
        $page=$this->page-1;
        $offset_page=$this->limit*$page;
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductByCategoryIdByBangla()
    {
        $query = ("SELECT item_id,item_name_bn as item_name,category_id,category_name_bn as category_name,subcategory_id,subcategory_name_bn as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_bn as product_desc,product_feature_bn as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_bn as meta_keyword1,meta_keyword2_bn as meta_keyword2,meta_keyword3_bn as meta_keyword3,earning_point,service_id,category_ind  from inv_item where category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductByCategoryIdByHindi()
    {
        $query = ("SELECT item_id,item_name_hi as item_name,category_id,category_name_hi as category_name,subcategory_id,subcategory_name_hi as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_hi as product_desc,product_feature_hi as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_hi as meta_keyword1,meta_keyword2_hi as meta_keyword2,meta_keyword3_hi as meta_keyword3,earning_point,service_id,category_ind  from inv_item where category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }



    public function getBudgetProductByCategoryIdByArabic()
    {
        $query = ("SELECT item_id,item_name_ar as item_name,category_id,category_name_ar as category_name,subcategory_id,subcategory_name_ar as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_ar as product_desc,product_feature_ar as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_ar as meta_keyword1,meta_keyword2_ar as meta_keyword2,meta_keyword3_ar as meta_keyword3,earning_point,service_id,category_ind  from inv_item where budget_category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }


    public function getBudgetProductByCategoryIdByBangla()
    {
        $query = ("SELECT item_id,item_name_bn as item_name,category_id,category_name_bn as category_name,subcategory_id,subcategory_name_bn as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_bn as product_desc,product_feature_bn as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_bn as meta_keyword1,meta_keyword2_bn as meta_keyword2,meta_keyword3_bn as meta_keyword3,earning_point,service_id,category_ind  from inv_item where budget_category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getBudgetProductByCategoryIdByHindi()
    {
        $query = ("SELECT item_id,item_name_hi as item_name,category_id,category_name_hi as category_name,subcategory_id,subcategory_name_hi as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_hi as product_desc,product_feature_hi as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_hi as meta_keyword1,meta_keyword2_hi as meta_keyword2,meta_keyword3_hi as meta_keyword3,earning_point,service_id,category_ind  from inv_item where budget_category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }
    public function getBudgetProductByCategoryIdByEnglish()
    {
        $query = ("SELECT item_id,item_name as item_name,category_id,category_name as category_name,subcategory_id,subcategory_name as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc as product_desc,product_feature as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1 as meta_keyword1,meta_keyword2 as meta_keyword2,meta_keyword3 as meta_keyword3,earning_point,service_id,category_ind  from inv_item where budget_category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductByCategoryIdByArabic()
    {
        $query = ("SELECT item_id,item_name_ar as item_name,category_id,category_name_ar as category_name,subcategory_id,subcategory_name_ar as subcategory_name,vendor_id,vendor_name,price,old_price,size_dtl,color_dtl,product_code,product_desc_ar as product_desc,product_feature_ar as product_feature,product_img,product_img1,product_img2,product_img3,product_img4,active_ind,rating,featured_ind,package_ind,home_ind,display_serial,popular_ind,meta_keyword1_ar as meta_keyword1,meta_keyword2_ar as meta_keyword2,meta_keyword3_ar as meta_keyword3,earning_point,service_id,category_ind  from inv_item where category_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductBySubCategoryId()
    {
        $query = ("SELECT * from inv_item where subcategory_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->sub_category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getOrderByCustomerId()
    {
        $query = ("SELECT * from sls_order where customer_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->order_customer_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getOrderByOrderId()
    {
        $query = ("SELECT i.product_img,s.order_id,s.item_qty,s.price,s.old_price,s.item_name from sls_order_details as s inner join inv_item as i on s.item_id=i.item_id where order_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->order_customer_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getAddressByCustomerId()
    {
        $query = ("SELECT * from mkt_customer_address where customer_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->customer_address_customer_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getBannerByCategoryIdArabic()
    {
        $user_details_query = ("Select banner_id,banner_title_ar as title,banner_img_ar as image,banner_desc_ar as description from gbl_banner  where category_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->category_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getBannerByCategoryIdBangla()
    {
        $user_details_query = ("Select banner_id,banner_title_bn as title,banner_img_bn as image,banner_desc_bn as description from gbl_banner  where category_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->category_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getInfoEnPolicy()
    {
        $user_details_query = ("Select info_policy as info_policy from gbl_setting");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getInfoArPolicy()
    {
        $user_details_query = ("Select info_policy_ar as info_policy from gbl_setting");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getInfoBnPolicy()
    {
        $user_details_query = ("Select info_policy_bn as info_policy from gbl_setting");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getInfoHiPolicy()
    {
        $user_details_query = ("Select info_policyhi as info_policy from gbl_setting");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getBannerByCategoryIdHindi()
    {
        $user_details_query = ("Select banner_id,banner_title_hi as title,banner_img_hi as image,banner_desc_hi as description from gbl_banner  where category_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->category_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getBannerByCategoryIdEnglish()
    {
        $user_details_query = ("Select banner_id, banner_title as title,	banner_img as image,banner_desc as description from gbl_banner  where category_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->category_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getProductList()
    {
        $query = ("SELECT item_id,item_name,price,product_desc,product_img1,product_img2,product_img3,product_img4,service_id from inv_item where service_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->service_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductListByHindiBannerId()
    {
        $query = ("SELECT  inv.item_id, inv.item_name_hi as item_name, inv.category_id, inv.category_name_hi as category_name, inv.subcategory_id, inv.subcategory_name_hi as subcategory_name, inv.vendor_id, inv.vendor_name, inv.price, inv.old_price, inv.size_dtl, inv.color_dtl,inv.product_code,inv.product_desc_hi as product_desc,inv.product_feature_hi as product_feature,inv.product_img,inv.product_img1,inv.product_img2,inv.product_img3,inv.product_img4,inv.active_ind,inv.rating,inv.featured_ind,inv.package_ind,inv.home_ind,inv.display_serial,inv.popular_ind,inv.meta_keyword1_hi as meta_keyword1,inv.meta_keyword2_hi as meta_keyword2,inv.meta_keyword3_hi as meta_keyword3,inv.earning_point,inv.service_id,inv.category_ind FROM inv_banner_related_item AS  rel INNER JOIN gbl_banner AS ban ON rel.banner_id = ban.banner_id 
INNER JOIN inv_item inv ON rel.item_id = inv.item_id WHERE rel.banner_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->banner_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductListByEnglishBannerId()
    {
        $query = ("SELECT  inv.item_id, inv.item_name as item_name, inv.category_id, inv.category_name as category_name, inv.subcategory_id, inv.subcategory_name as subcategory_name, inv.vendor_id, inv.vendor_name, inv.price, inv.old_price, inv.size_dtl, inv.color_dtl,inv.product_code,inv.product_desc as product_desc,inv.product_feature as product_feature,inv.product_img,inv.product_img1,inv.product_img2,inv.product_img3,inv.product_img4,inv.active_ind,inv.rating,inv.featured_ind,inv.package_ind,inv.home_ind,inv.display_serial,inv.popular_ind,inv.meta_keyword1 as meta_keyword1,inv.meta_keyword2 as meta_keyword2,inv.meta_keyword3 as meta_keyword3,inv.earning_point,inv.service_id,inv.category_ind FROM inv_banner_related_item AS  rel INNER JOIN gbl_banner AS ban ON rel.banner_id = ban.banner_id 
INNER JOIN inv_item inv ON rel.item_id = inv.item_id WHERE rel.banner_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->banner_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductListByBanglaBannerId()
    {
        $query = ("SELECT  inv.item_id, inv.item_name_bn as item_name, inv.category_id, inv.category_name_bn as category_name, inv.subcategory_id, inv.subcategory_name_bn as subcategory_name, inv.vendor_id, inv.vendor_name, inv.price, inv.old_price, inv.size_dtl, inv.color_dtl,inv.product_code,inv.product_desc_bn as product_desc,inv.product_feature_bn as product_feature,inv.product_img,inv.product_img1,inv.product_img2,inv.product_img3,inv.product_img4,inv.active_ind,inv.rating,inv.featured_ind,inv.package_ind,inv.home_ind,inv.display_serial,inv.popular_ind,inv.meta_keyword1_bn as meta_keyword1,inv.meta_keyword2_bn as meta_keyword2,inv.meta_keyword3_bn as meta_keyword3,inv.earning_point,inv.service_id,inv.category_ind FROM inv_banner_related_item AS  rel INNER JOIN gbl_banner AS ban ON rel.banner_id = ban.banner_id 
INNER JOIN inv_item inv ON rel.item_id = inv.item_id WHERE rel.banner_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->banner_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getProductListByArabicBannerId()
    {
        $query = ("SELECT  inv.item_id, inv.item_name_ar as item_name, inv.category_id, inv.category_name_ar as category_name, inv.subcategory_id, inv.subcategory_name_ar as subcategory_name, inv.vendor_id, inv.vendor_name, inv.price, inv.old_price, inv.size_dtl, inv.color_dtl,inv.product_code,inv.product_desc_ar as product_desc,inv.product_feature_ar as product_feature,inv.product_img,inv.product_img1,inv.product_img2,inv.product_img3,inv.product_img4,inv.active_ind,inv.rating,inv.featured_ind,inv.package_ind,inv.home_ind,inv.display_serial,inv.popular_ind,inv.meta_keyword1_ar as meta_keyword1,inv.meta_keyword2_ar as meta_keyword2,inv.meta_keyword3_ar as meta_keyword3,inv.earning_point,inv.service_id,inv.category_ind FROM inv_banner_related_item AS  rel INNER JOIN gbl_banner AS ban ON rel.banner_id = ban.banner_id 
INNER JOIN inv_item inv ON rel.item_id = inv.item_id WHERE rel.banner_id=?");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->banner_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getCustomerUserInformation()
    {
        $user_details_query = ("Select * from mkt_service where service_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->user_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getMKTCustomerUserInformationFor()
    {
        $user_details_query = ("Select * from mkt_customer where customer_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->customer_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getBannerDetailsArabic()
    {
        $user_details_query = ("Select banner_id,banner_title_ar as title,banner_img_ar as image,banner_desc_ar as description from gbl_banner WHERE banner_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->banner_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getBannerDetailsBangla()
    {
        $user_details_query = ("Select banner_id,banner_title_bn as title,banner_img_bn as image,banner_desc_bn as description from gbl_banner  WHERE banner_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->banner_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }


    public function getBannerDetailsHindi()
    {
        $user_details_query = ("Select banner_id,banner_title_hi as title,banner_img_hi as image,banner_desc_hi as description from gbl_banner  WHERE banner_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->banner_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getBannerDetailsEnglish()
    {
        $user_details_query = ("Select banner_id, banner_title as title,	banner_img as image,banner_desc as description from gbl_banner  WHERE banner_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->banner_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }


    public function getIncomeDetailsArabic()
    {
        $user_details_query = ("Select image_ar as image,link_ar as link,text_ar as text,description_ar as description from mkt_income");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getItemSize()
    {
        $user_details_query = ("Select * from inv_item_size where item_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->item_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getItemColor()
    {
        $user_details_query = ("Select * from inv_item_color where item_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->item_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getIncomeDetailsBengali()
    {
        $user_details_query = ("Select image_bn as image,link_bn as link,text_bn as text,description_bn as description from mkt_income");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getIncomeDetailsHindi()
    {
        $user_details_query = ("Select image_hi as image,link_hi as link,text_hi as text,description_hi as description from mkt_income");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getIncomeDetailsEnglish()
    {
        $user_details_query = ("Select image_en as image,link_en as link,text_en as text,description_en as description  from mkt_income");
        $user_details_obj = $this->conn->prepare($user_details_query);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function update_service()
    {
        $delivery_query = "UPDATE mkt_service SET service_banner=?,service_image=?,owner_name=?,type=?,contact_number=?,service_name=?,service_dialog=?,service_details=? Where service_id=?  ";
        $delivery_obj = $this->conn->prepare($delivery_query);
        $delivery_obj->bind_param("sssssssss", $this->service_banner, $this->service_image, $this->service_owner_name, $this->service_type, $this->service_contact_number, $this->service_name, $this->service_dialog, $this->service_details, $this->service_id);
        if ($delivery_obj->execute()) {
            return true;
        }
        return false;

    }

    public function update_customer()
    {
        $delivery_query = "UPDATE mkt_customer SET customer_name=?,customer_img=?,email_address=?,mobile_number=? Where customer_id=?";
        $delivery_obj = $this->conn->prepare($delivery_query);
        $delivery_obj->bind_param("sssss", $this->customer_name, $this->customer_image, $this->customer_email, $this->customer_mobile_number, $this->customer_id);
        if ($delivery_obj->execute()) {
            return true;
        }
        return false;

    }

    public function update_service_map()
    {
        $delivery_query = "UPDATE mkt_service SET latitude=?,longitude=?,Country=?,City=? Where service_id=?  ";
        $delivery_obj = $this->conn->prepare($delivery_query);
        $delivery_obj->bind_param("sssss", $this->latitude, $this->longitude, $this->service_country, $this->service_city, $this->service_id);
        if ($delivery_obj->execute()) {
            return true;
        }
        return false;

    }

    public function getCategoryByArabic()
    {
        $result = $this->conn->query("SELECT category_id ,category_name_ar as category_name,category_img,category_img_circle  from inv_category order by display_serial");
        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getCategoryByHindi()
    {
        $result = $this->conn->query("SELECT category_id ,category_name_hi as category_name,category_img,category_img_circle  from inv_category order by display_serial ");

        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getCategoryByBangla()
    {
        $result = $this->conn->query("SELECT category_id ,category_name_bn as category_name,category_img,category_img_circle  from inv_category  order by display_serial ");

        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getCategoryByEnglish()
    {
        $result = $this->conn->query("SELECT category_id ,category_name as category_name,category_img,category_img_circle  from inv_category order by display_serial ");

        $units = array();
        while ($item = $result->fetch_assoc())
            $units[] = $item;
        return $units;

    }

    public function getSubCategoryByEnglish()
    {
        $query = ("SELECT subcategory_id ,subcategory_name as subcategory_name ,subcategory_img from inv_subcategory where category_id=? order by display_serial");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSubCategoryByArabic()
    {
        $query = ("SELECT subcategory_id ,subcategory_name_ar as subcategory_name ,subcategory_img from inv_subcategory where category_id=? order by display_serial");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSubCategoryByBangla()
    {
        $query = ("SELECT subcategory_id ,subcategory_name_bn as subcategory_name ,subcategory_img from inv_subcategory where category_id=? order by display_serial");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getSubCategoryByHindi()
    {
        $query = ("SELECT subcategory_id ,subcategory_name_hi as subcategory_name ,subcategory_img from inv_subcategory where category_id=? order by display_serial");
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $this->category_id);
        $units = array();
        if ($obj->execute()) {
            $data = $obj->get_result();
            while ($item = $data->fetch_assoc())
                $units[] = $item;
            return $units;
        }
    }

    public function getFavorite()
    {
        $user_details_query = ("Select * from mkt_service_favorite  where service_id=? AND customer_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("ss", $this->service_id, $this->customer_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getFollow()
    {
        $user_details_query = ("Select * from mkt_service_follow  where service_id=? AND customer_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("ss", $this->service_id, $this->customer_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getServiceDetails()
    {
        $user_details_query = ("Select * from mkt_service  where service_id=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->service_id);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getMobileNumber()
    {
        $user_details_query = ("Select * from mkt_service  where contact_number=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->customer_mobile_number);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function getCustomerMobileNumber()
    {
        $user_details_query = ("Select * from mkt_customer  where mobile_number=?");
        $user_details_obj = $this->conn->prepare($user_details_query);
        $user_details_obj->bind_param("s", $this->customer_mobile_number);
        if ($user_details_obj->execute()) {
            $data = $user_details_obj->get_result();
            return $data->fetch_assoc();
        }
        return NULL;
    }

    public function update_reset_password_service()
    {
        $delivery_query = "UPDATE mkt_service SET password=? Where contact_number=?";
        $delivery_obj = $this->conn->prepare($delivery_query);
        $delivery_obj->bind_param("ss", $this->reset_password, $this->reset_mobile_number);
        if ($delivery_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_reset_password_customer()
    {
        $delivery_query = "UPDATE mkt_customer SET password=? Where mobile_number=?";
        $delivery_obj = $this->conn->prepare($delivery_query);
        $delivery_obj->bind_param("ss", $this->reset_password, $this->reset_mobile_number);
        if ($delivery_obj->execute()) {
            return true;
        }
        return false;
    }
}

?>
