<?php

namespace App\Controllers;
use App\Models\admin\Slider_m;
use App\Models\admin\Login_m;
class Slider_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->Slider_m = new Slider_m();
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
        $data['title'] = VIEW_SLIDER; 
        echo admin_view('admin/view_slider',$data);
    }
    
    public function add(){

        $has_error = false;
        $error_messages  = array();
    
        $slider_details = array();
    
        if (
          isset($_POST['slider_title']) ) {
    
          $validate = self::validate_slider($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $slider_details = $validate['slider_details']; 
          
          $main_img = singleImageUpload('slider_image');
          $sliderImage = $main_img[2]['file_name'];     
    
          if (empty($sliderImage) || $sliderImage == '') {
            $has_error = true;
            $error_messages[] = "Please select slider image!";
          } else {
            $slider_details['slider_image'] = $sliderImage;
          }
        }
    
        if (!$has_error && (is_array($slider_details) && sizeof($slider_details) > 0)) {
          //create package
    
          $sliderId = $this->Slider_m->create_slider($slider_details);
    
          if ($sliderId) {              
    
            successOrErrorMessage("Slider has been successfully created", 'success');
            return redirect()->to(ADMIN_VIEW_SLIDER_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
    
        helper('form');
        
        $data['slider_details'] = $slider_details;
        $data['title'] = ADD_SLIDER; 
        echo admin_view('admin/add_slider',$data);
    }

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
    

    function validate_slider($sliderData){
        $slider_title = trim($sliderData['slider_title']);    
        $slider_position = trim($sliderData['slider_position']);
    
        $has_error = false;
        $slider_details = array();  
    
    
        if (empty($slider_title) || $slider_title == '') {
          $has_error = true;
          $error_messages[] = "Slider title can not be empty!";
        } else {
          $slider_details['slider_title'] = $slider_title;
        }

        if (empty($slider_position) || $slider_position == '') {
          $has_error = true;
          $error_messages[] = "Slider position can not be empty!";
        } else {
          $slider_details['slider_position'] = $slider_position;
        }     

      
    
        if (isset($sliderData['is_active']) && $sliderData['is_active'] == "on") {
          $slider_details['is_active'] = 1;
        }
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'slider_details' => $slider_details
        );
    }

    public function edit_slider($slider_id){
        helper('form');  
        $slider_details = $this->Slider_m->get_slider_details($slider_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;
      
       
  
        if (isset($_POST['slider_title']) ) {
    
          $submitForm = true;
          $validate = self::validate_slider($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $slider_details = $validate['slider_details'];     
          
          if(isset($_FILES['slider_image'])){
            $main_img = singleImageUpload('slider_image');
            $sliderImage = $main_img[2]['file_name'];
      
            if (empty($sliderImage) || $sliderImage == '') {            
            } else {
              $slider_details['slider_image'] = $sliderImage;
            }
          } 
        }
  
        if ($submitForm && !$has_error && (is_array($slider_details) && sizeof($slider_details) > 0)) {
          //create slider
    
          $update = $this->Slider_m->update_slider($slider_details,$slider_id);
    
          if ($update) {
            successOrErrorMessage("Slider has been successfully updated", 'success');
            return redirect()->to(ADMIN_VIEW_SLIDER_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
  
        $data['edit_slider'] = true;        
        $data['slider_id'] = $slider_id;
        $data['slider_details'] = $slider_details;
        $data['title'] = ADMIN_EDIT_SLIDER_TITLE; 
        echo admin_view('admin/add_slider',$data);
      }

    
    public function update_status(){
        $slider_status = (int) $_REQUEST['slider_status'];
        $slider_id = (int) $_REQUEST['slider_id'];
        $update =  $this->Slider_m->update_slider_status($slider_status,$slider_id);
    
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