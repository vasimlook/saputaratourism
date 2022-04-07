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
    
        $data['clients'] = $clients;        
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
        $hotel_descriptions = trim($hotelData['hotel_descriptions']);
        $client_id = (int)$hotelData['client_id'];

        $has_error = false;
        $hotel_details = array();  
    
    
        if (empty($hotel_title) || $hotel_title == '') {
          $has_error = true;
          $error_messages[] = "Hotel title can not be empty!";
        } else {
          $hotel_details['hotel_title'] = $hotel_title;
        }

        if (empty($hotel_descriptions) || $hotel_descriptions == '') {
          $has_error = true;
          $error_messages[] = "Hotel description can not be empty!";
        } else {
          $hotel_details['hotel_descriptions'] = $hotel_descriptions;
        }

        if ($client_id === 0) {
          $has_error = true;
          $error_messages[] = "Please select hotel client!";
        } else {
          $hotel_details['client_id'] = $client_id;
        }      

       
        if (isset($hotelData['is_active']) && $hotelData['is_active'] == "on") {
          $hotel_details['is_active'] = 1;
        }

        $hotel_details['ads_package_id'] = (int)$hotelData['ads_package_id'];
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'hotel_details' => $hotel_details
        );
    }

    public function edit_hotel($hotel_id){
        helper('form');  
        $hotel_details = $this->Hotel_m->get_hotel_details($hotel_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;
      
       
  
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

        $data['categories'] = $categories;
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
}
?>