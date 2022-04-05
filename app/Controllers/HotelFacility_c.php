<?php

namespace App\Controllers;
use App\Models\admin\HotelFacility_m;
use App\Models\admin\Login_m;
class HotelFacility_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->HotelFacility_m = new HotelFacility_m();
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
        $data['title'] = VIEW_HOTEL_FACILITY; 
        echo admin_view('admin/view_hotel_facility',$data);
    }
    
    public function add(){

        $has_error = false;
        $error_messages  = array();
    
        $facility_details = array();
    
        if (
          isset($_POST['facility_title']) ) {
    
          $validate = self::validate_facility($_POST);          
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $facility_details = $validate['facility_details'];         
        }
    
        if (!$has_error && (is_array($facility_details) && sizeof($facility_details) > 0)) {
          //create facility
    
          $facilityId = $this->HotelFacility_m->create_facility($facility_details);
    
          if ($facilityId) {              
    
            successOrErrorMessage("Facility has been successfully created", 'success');
            return redirect()->to(ADMIN_VIEW_HOTEL_FACILITY_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
    
        helper('form');
       
        $data['facility_details'] = $facility_details;
        $data['title'] = ADD_HOTEL_FACILITY; 
        echo admin_view('admin/add_hotel_facility',$data);
    }

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
    

    function validate_facility($facilityData){
        $facility_title = trim($facilityData['facility_title']);
        $facility_descriptions = trim($facilityData['facility_descriptions']);    
        $icon = trim($facilityData['icon']);    
    
        $has_error = false;
        $facility_details = array();  
    
    
        if (empty($facility_title) || $facility_title == '') {
          $has_error = true;
          $error_messages[] = "Facility title can not be empty!";
        } else {
          $facility_details['facility_title'] = $facility_title;
        }
        
        if (empty($facility_descriptions) || $facility_descriptions == '') {
          $has_error = true;
          $error_messages[] = "Facility description can not be empty!";
        } else {
          $facility_details['facility_descriptions'] = $facility_descriptions;
        }
        
        if (empty($icon) || $icon == '') {
          $has_error = true;
          $error_messages[] = "Facility icon can not be empty!";
        } else {
          $facility_details['icon'] = $icon;
        } 
    
        if (isset($facilityData['is_active']) && $facilityData['is_active'] == "on") {
          $facility_details['is_active'] = 1;
        }
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'facility_details' => $facility_details
        );
    }

    public function edit_facility($facility_id){
        helper('form');  
        $facility_details = $this->HotelFacility_m->get_facility_details($facility_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;
      
       
  
        if (isset($_POST['facility_title']) ) {
    
          $submitForm = true;
          $validate = self::validate_facility($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $facility_details = $validate['facility_details'];               
        }
  
        if ($submitForm && !$has_error && (is_array($facility_details) && sizeof($facility_details) > 0)) {
          //create facility
    
          $update = $this->HotelFacility_m->update_facility($facility_details,$facility_id);
    
          if ($update) {
            successOrErrorMessage("Facility has been successfully updated", 'success');
            return redirect()->to(ADMIN_VIEW_HOTEL_FACILITY_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
  
        $data['edit_facility'] = true;        
        $data['facility_id'] = $facility_id;
        $data['facility_details'] = $facility_details;
        $data['title'] = ADMIN_EDIT_HOTEL_FACILITY_TITLE; 
        echo admin_view('admin/add_hotel_facility',$data);
      }

    
    public function update_status(){
        $facility_status = (int) $_REQUEST['facility_status'];
        $facility_id = (int) $_REQUEST['facility_id'];
        $update =  $this->HotelFacility_m->update_facility_status($facility_status,$facility_id);
    
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