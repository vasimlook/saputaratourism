<?php

namespace App\Controllers;
use App\Models\admin\Packages_m;
use App\Models\admin\Login_m;
class Packages_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->Packages_m = new Packages_m();
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
        $data['title'] = VIEW_PACKAGES; 
        echo admin_view('admin/view_packages',$data);
    }
    
    public function add(){

        $has_error = false;
        $error_messages  = array();
    
        $package_details = array();
    
        if (
          isset($_POST['package_title']) ) {
    
          $validate = self::validate_package($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $package_details = $validate['package_details'];         
        }
    
        if (!$has_error && (is_array($package_details) && sizeof($package_details) > 0)) {
          //create package
    
          $packageId = $this->Packages_m->create_package($package_details);
    
          if ($packageId) {              
    
            successOrErrorMessage("Package has been successfully created", 'success');
            return redirect()->to(ADMIN_VIEW_PACKAGES_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
    
        helper('form');

        $categories =  $this->Packages_m->get_categories();       
    
        $data['categories'] = $categories;
        $data['package_details'] = $package_details;
        $data['title'] = ADD_PACKAGES; 
        echo admin_view('admin/add_packages',$data);
    }

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
    

    function validate_package($packageData){
        $package_title = trim($packageData['package_title']);    
        $package_price = (float)($packageData['package_price']);    
        $package_duration = (int)($packageData['package_duration']);    
        $package_category = (int)($packageData['category_id']);    
    
        $has_error = false;
        $package_details = array();  
    
    
        if (empty($package_title) || $package_title == '') {
          $has_error = true;
          $error_messages[] = "Package title can not be empty!";
        } else {
          $package_details['package_title'] = $package_title;
        }

        if ($package_category === 0) {
          $has_error = true;
          $error_messages[] = "Please select package category!";
        } else {
          $package_details['category_id'] = $package_category;
        }

        if (empty($package_price) || $package_price <= 0) {
          $has_error = true;
          $error_messages[] = "Please enter valid package price!";
        } else {
          $package_details['package_price'] = $package_price;
        }

        if (empty($package_duration) || $package_duration <= 0) {
          $has_error = true;
          $error_messages[] = "Please enter valid package duration!";
        } else {
          $package_details['package_duration'] = $package_duration;
        }
    
        if (isset($packageData['is_active']) && $packageData['is_active'] == "on") {
          $package_details['is_active'] = 1;
        }
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'package_details' => $package_details
        );
    }

    public function edit_package($package_id){
        helper('form');  
        $package_details = $this->Packages_m->get_package_details($package_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;
      
       
  
        if (isset($_POST['package_title']) ) {
    
          $submitForm = true;
          $validate = self::validate_package($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $package_details = $validate['package_details'];               
        }
  
        if ($submitForm && !$has_error && (is_array($package_details) && sizeof($package_details) > 0)) {
          //create projects
    
          $update = $this->Packages_m->update_package($package_details,$package_id);
    
          if ($update) {
            successOrErrorMessage("Package has been successfully updated", 'success');
            return redirect()->to(ADMIN_VIEW_PACKAGES_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }

        $categories =  $this->Packages_m->get_categories();
  
        $data['edit_packages'] = true;
        $data['categories'] = $categories;
        $data['package_id'] = $package_id;
        $data['package_details'] = $package_details;
        $data['title'] = ADMIN_EDIT_PACKAGES_TITLE; 
        echo admin_view('admin/add_packages',$data);
      }

    
    public function update_status(){
        $package_status = (int) $_REQUEST['package_status'];
        $package_id = (int) $_REQUEST['package_id'];
        $update =  $this->Packages_m->update_package_status($package_status,$package_id);
    
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