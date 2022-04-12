<?php

namespace App\Controllers;
use App\Models\admin\Hotel_m;
use App\Models\admin\Login_m;
class Hotel_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->Hotel_m = new Hotel_m();
        $this->security = \Config\Services::security();        
        sessionCheckAdmin();                   
        if (isset($_SESSION['admin']['admin_user_id'])) {            
                $result = $this->Login_m->getTokenAndCheck('admin', $_SESSION['admin']['admin_user_id']);
                if ($result) {
                    $token = $result['token'];
                    if ($_SESSION['admin']['admin_tokencheck'] != $token) {                                                                       
                            logoutUser('admin');
                            header('Location: ' . ADMIN_LOGIN_LINK);
                            exit();                        
                    }   
                }else{
                    logoutUser('admin');
                    header('Location: ' . ADMIN_LOGIN_LINK);
                    exit();
                } 
            
        }                      
    }

    public function view(){    
        $data['title'] = VIEW_HOTEL; 
        echo admin_view('admin/view_hotel',$data);
    }
    
    public function add(){
      

        $has_error = false;
        $error_messages  = array();
    
        $hotel_details = array();
    
        if (
          isset($_POST['hotel_title']) ) {
    
          $validate = self::validate_hotel($_POST);

                   
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $hotel_details = $validate['hotel_details'];  
          
          $main_img = singleImageUpload('hotel_main_image');
          $hotelImage = $main_img[2]['file_name']; 

          if (empty($hotelImage) || $hotelImage == '') {
            $has_error = true;
            $error_messages[] = "Please select hotel image!";
          } else {
            $hotel_details['hotel_main_image'] = $hotelImage;
          }
        }
    
        if (!$has_error && (is_array($hotel_details) && sizeof($hotel_details) > 0)) {
          //create hotel
          $hotelId = $this->Hotel_m->create_hotel($hotel_details);
    
          if ($hotelId) {               

            $top_package_id = isset($hotel_details['top_package_id']) ? (int)$hotel_details['top_package_id'] : 0;        
            $ads_package_id = isset($hotel_details['ads_package_id']) ? (int)$hotel_details['ads_package_id'] : 0;        

            if($ads_package_id !== 0){
              $ads_package_details = $this->Hotel_m->ads_package_details($ads_package_id);
              $this->Hotel_m->update_ads_last_payments($hotelId);

              $package_data = array(
                'module_type' => 'hotel',
                'module_id' => $hotelId,
                'package_id' => $ads_package_id,
                'total_price' => $ads_package_details['package_price'],
                'last_payments' => 1
              );

              $paymentId = $this->Hotel_m->add_hotel_ads_package_details($package_data);

              if($paymentId){
                $this->Hotel_m->add_hotel_ads_payment_id($hotelId,$paymentId);
              }
            }  
            
            if($top_package_id !== 0){
              $package_details = $this->Hotel_m->top_package_details($top_package_id);
              $this->Hotel_m->update_last_payments($hotelId);

              $package_data = array(
                'module_type' => 'hotel',
                'module_id' => $hotelId,
                'package_id' => $top_package_id,
                'total_price' => $package_details['package_price'],
                'last_payments' => 1
              );

              $paymentId = $this->Hotel_m->add_hotel_package_details($package_data);

              if($paymentId){
                $this->Hotel_m->add_hotel_payment_id($hotelId,$paymentId);
              }
            }
            
            if (($_FILES['other_hotel_images']['name'][0]) != '') {
              $other_hotel_images = multiImageUpload('other_hotel_images');
              foreach ($other_hotel_images as $poi) {
                  $params = array();
                  $params['hotel_id'] = $hotelId;
                  $params['image_path'] = $poi[2]['file_name'];
                  $params['is_active'] = 1;
                  $this->Hotel_m->add_hotel_images($params);
              }
           }

           if(isset($_REQUEST['facilities']) && is_array($_REQUEST['facilities']) && sizeof($_REQUEST['facilities']) > 0){           
              foreach($_REQUEST['facilities'] as $key => $facility_id){
                $data = array(
                  'hotel_id' => $hotelId,
                  'hotel_facility_id' => $facility_id
                );
                $this->Hotel_m->add_hotel_facilities($data);
              }
            }         
    
            successOrErrorMessage("Hotel has been successfully created", 'success');
            return redirect()->to(ADMIN_VIEW_HOTEL_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
    
        helper('form');

        $clients =  $this->Hotel_m->get_clients();            
        $adsPackages  = $this->Hotel_m->get_ads_packges();
        $categories =  $this->Hotel_m->get_categories();    
        $facilities =  $this->Hotel_m->get_hotel_facilities();    
    
        $data['clients'] = $clients;        
        $data['facilities'] = $facilities;        
        $data['categories'] = $categories;        
        $data['adsPackages'] = $adsPackages;
        $data['hotel_details'] = $hotel_details;
        $data['title'] = ADD_HOTEL; 
        echo admin_view('admin/add_hotel',$data);
    }

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
    

    function validate_hotel($hotelData){
        $hotel_title = trim($hotelData['hotel_title']);
        $main_category = (int)$hotelData['main_category'];
        $hotel_descriptions = trim($hotelData['hotel_descriptions']);
        $client_id = (int)$hotelData['client_id'];

        $has_facilities = false;

        $hotel_facilities = array();

        if(isset($_REQUEST['facilities']) && is_array($_REQUEST['facilities']) && sizeof($_REQUEST['facilities']) > 0){       
          foreach($_REQUEST['facilities'] as $key=> $facility_id){
            $has_facilities = true;
            if((int)$facility_id === 0){
              $has_facilities = false;
            }else{
              $hotel_facilities [] = $facility_id;
            }
              
          }         
        }

        

        $has_error = false;
        $hotel_details = array();  

        if ($main_category === 0) {
          $has_error = true;
          $error_messages[] = "Please select main category!";
        } else {
          $hotel_details['main_category'] = $main_category;
        }
    
    
        if (empty($hotel_title) || $hotel_title == '') {
          $has_error = true;
          $error_messages[] = "Hotel title can not be empty!";
        } else {
          $hotel_details['hotel_title'] = $hotel_title;
        }

        if (!$has_facilities) {
          $has_error = true;
          $error_messages[] = "Please select hotel facilities!";
        } else {
          // $hotel_details['hotel_facilities'] = $hotel_facilities;
        } 

        if ($client_id === 0) {
          $has_error = true;
          $error_messages[] = "Please select hotel client!";
        } else {
          $hotel_details['client_id'] = $client_id;
        } 



        if (empty($hotel_descriptions) || $hotel_descriptions == '') {
          $has_error = true;
          $error_messages[] = "Hotel description can not be empty!";
        } else {
          $hotel_details['hotel_descriptions'] = $hotel_descriptions;
        }           

       
        if (isset($hotelData['is_active']) && $hotelData['is_active'] == "on") {
          $hotel_details['is_active'] = 1;
        }

        $hotel_details['ads_package_id'] = (int)$hotelData['ads_package_id'];
        $hotel_details['top_package_id'] = (int)$hotelData['top_package_id'];        
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'hotel_details' => $hotel_details
        );
    }

    public function edit_hotel($hotel_id){
        helper('form');  
        $hotel_details = $this->Hotel_m->get_hotel_details($hotel_id);
        $top_payment_id = isset($hotel_details['top_payment_id']) ? (int)$hotel_details['top_payment_id'] : 0;
        $ads_payment_id = isset($hotel_details['ads_payment_id']) ? (int)$hotel_details['ads_payment_id'] : 0;
        $hotel_images = $this->Hotel_m->get_hotel_images($hotel_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;

        if(is_array($hotel_details) && sizeof($hotel_details) > 0){          
  
          $hotel_details['other_images'] = $hotel_images;
        }
      
       
  
        if (isset($_POST['hotel_title']) ) {
    
          $submitForm = true;
          $validate = self::validate_hotel($_POST);        
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $hotel_details = $validate['hotel_details'];               

          if(isset($_FILES['hotel_main_image'])){
            $main_img = singleImageUpload('hotel_main_image');
            $hotelImage = $main_img[2]['file_name'];
      
            if (empty($hotelImage) || $hotelImage == '') {            
            } else {
              $hotel_details['hotel_main_image'] = $hotelImage;
            }
          } 
    
        }
  
        if ($submitForm && !$has_error && (is_array($hotel_details) && sizeof($hotel_details) > 0)) {
          //edit hotel
    
          $update = $this->Hotel_m->update_hotel($hotel_details,$hotel_id);
    
          if ($update) {

            $top_package_id = isset($hotel_details['top_package_id']) ? (int)$hotel_details['top_package_id'] : 0;                      
            $ads_package_id = isset($hotel_details['ads_package_id']) ? (int)$hotel_details['ads_package_id'] : 0;   
            
            if($ads_package_id !== 0){
              $ads_package_details = $this->Hotel_m->ads_package_details($ads_package_id);              

              $package_data = array(
                'module_type' => 'hotel',
                'module_id' => $hotel_id,
                'package_id' => $ads_package_id,
                'total_price' => $ads_package_details['package_price'],
                'last_payments' => 1
              );

              if($ads_payment_id){//update payment entry

                $this->Hotel_m->update_hotel_ads_package_details($ads_payment_id,$hotel_id,$package_data);

              }else{// add new entry
                $paymentId = $this->Hotel_m->add_hotel_ads_package_details($package_data);

              if($paymentId){
                $this->Hotel_m->add_hotel_ads_payment_id($hotel_id,$paymentId);
              }
              }

              
            } 

            if($top_package_id !== 0){
              $package_details = $this->Hotel_m->top_package_details($top_package_id);              

              $package_data = array(
                'module_type' => 'hotel',
                'module_id' => $hotel_id,
                'package_id' => $top_package_id,
                'total_price' => $package_details['package_price'],
                'last_payments' => 1
              );

              if($top_payment_id){//update payment entry

                $this->Hotel_m->update_hotel_package_details($top_payment_id,$hotel_id,$package_data);

              }else{// add new entry
                $paymentId = $this->Hotel_m->add_hotel_package_details($package_data);

              if($paymentId){
                $this->Hotel_m->add_hotel_payment_id($hotel_id,$paymentId);
              }
              }

              
            }  


            $this->Hotel_m->delete_client_hotel_facilities($hotel_id);

            if(isset($_REQUEST['facilities']) && is_array($_REQUEST['facilities']) && sizeof($_REQUEST['facilities']) > 0){           
              foreach($_REQUEST['facilities'] as $key => $facility_id){
                $data = array(
                  'hotel_id' => $hotel_id,
                  'hotel_facility_id' => $facility_id
                );
                $this->Hotel_m->add_hotel_facilities($data);
              }
            }  

            if (($_FILES['other_hotel_images']['name'][0]) != '') {
              $other_hotel_images = multiImageUpload('other_hotel_images');
              foreach ($other_hotel_images as $poi) {
                  $params = array();
                  $params['hotel_id'] = $hotel_id;
                  $params['image_path'] = $poi[2]['file_name'];
                  $params['is_active'] = 1;
                  $this->Hotel_m->add_hotel_images($params);
            }         

          }

            successOrErrorMessage("Hotel has been successfully updated", 'success');
            return redirect()->to(ADMIN_VIEW_HOTEL_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }

        $clients =  $this->Hotel_m->get_clients();          
        $adsPackages  = $this->Hotel_m->get_ads_packges();
        $categories =  $this->Hotel_m->get_categories(); 
         
        $get_client_hotel_facilities = $this->Hotel_m->get_client_hotel_facilities($hotel_id);
        

        $top_package_id = (isset($hotel_details['top_package_id'])) ?(int)$hotel_details['top_package_id'] : 0;
        $facilities =  $this->Hotel_m->get_hotel_facilities();
        $data['facilities'] = $facilities;
        $data['get_client_hotel_facilities'] = $get_client_hotel_facilities;
        $data['categories'] = $categories;
        $data['top_package_id'] = $top_package_id;
        $data['clients'] = $clients;
        $data['adsPackages'] = $adsPackages;  
        $data['edit_hotel'] = true;        
        $data['hotel_id'] = $hotel_id;
        $data['hotel_details'] = $hotel_details;
        $data['title'] = ADMIN_EDIT_HOTEL_TITLE; 
        echo admin_view('admin/add_hotel',$data);
      }

    
    public function update_status(){
        $hotel_status = (int) $_REQUEST['hotel_status'];
        $hotel_id = (int) $_REQUEST['hotel_id'];
        $update =  $this->Hotel_m->update_hotel_status($hotel_status,$hotel_id);
    
        if($update){
          $output = array(
            'success' => 'success'
          );
        }else{
          $output = array(
            'error' => true
          );
        }
    
        echo json_encode($output);
        
    }

    public function load_package(){
      if($_REQUEST['cat_id']){            
        $package = $this->Hotel_m->load_package($_POST);			           
        $result=array();
        $result['package']=$package; 			                    
        echo json_encode($result);
      }
    }

    public function delete_hotel_image(){
      $imageId = (int)$_REQUEST['image_id'];
      $delete =  $this->Hotel_m->delete_hotel_image($imageId);
  
      if($delete){
        $output = array(
          'success' => 'success'
        );
      }else{
        $output = array(
          'error' => true
        );
      }
  
      echo json_encode($output);
    }

    public function make_hotel_top_package_payments(){
      $payments_id = (int) $_REQUEST['payments_id'];      
      $update =  $this->Hotel_m->make_hotel_top_package_payments($payments_id);
  
      if($update){
        $output = array(
          'success' => 'success'
        );
      }else{
        $output = array(
          'error' => true
        );
      }
  
      echo json_encode($output);
      
  }
}
?>