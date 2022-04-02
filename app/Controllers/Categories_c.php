<?php

namespace App\Controllers;
use App\Models\admin\Categories_m;
use App\Models\admin\Login_m;
class Categories_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->Categories_m = new Categories_m();
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
        $data['title'] = VIEW_CATEGOIRES; 
        echo admin_view('admin/view_categories',$data);
    }
    
    public function add(){

        $has_error = false;
        $error_messages  = array();
    
        $category_details = array();
    
        if (
          isset($_POST['category_title']) ) {
    
          $validate = self::validate_category($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $category_details = $validate['category_details'];         
        }
    
        if (!$has_error && (is_array($category_details) && sizeof($category_details) > 0)) {
          //create category
    
          $categoryId = $this->Categories_m->create_category($category_details);
    
          if ($categoryId) {  
            
    
            successOrErrorMessage("Category has been successfully created", 'success');
            return redirect()->to(ADMIN_VIEW_CATEGORIES_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
    
        helper('form');
    
        $data['projects_details'] = $category_details;
        $data['title'] = ADD_CATEGOIRES; 
        echo admin_view('admin/add_categories',$data);
    }

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
    

    function validate_category($categoryData){
        $category_title = trim($categoryData['category_title']);      
    
        $has_error = false;
        $category_details = array();  
    
    
        if (empty($category_title) || $category_title == '') {
          $has_error = true;
          $error_messages[] = "Category title can not be empty!";
        } else {
          $category_details['category_title'] = $category_title;
        }
    
        if (isset($categoryData['is_active']) && $categoryData['is_active'] == "on") {
          $category_details['is_active'] = 1;
        }
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'category_details' => $category_details
        );
    }

    public function edit_category($category_id){
        helper('form');  
        $category_details = $this->Categories_m->get_category_details($category_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;
      
       
  
        if (isset($_POST['category_title']) ) {
    
          $submitForm = true;
          $validate = self::validate_category($_POST);
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $category_details = $validate['category_details'];               
        }
  
        if ($submitForm && !$has_error && (is_array($category_details) && sizeof($category_details) > 0)) {
          //create projects
    
          $update = $this->Categories_m->update_category($category_details,$category_id);
    
          if ($update) {
            successOrErrorMessage("Category has been successfully updated", 'success');
            return redirect()->to(ADMIN_VIEW_CATEGORIES_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
  
        $data['edit_projects'] = true;
        $data['category_id'] = $category_id;
        $data['category_details'] = $category_details;
        $data['title'] = ADMIN_EDIT_CATEGORY_TITLE; 
        echo admin_view('admin/add_categories',$data);
      }

    
    public function update_status(){
        $category_status = (int) $_REQUEST['category_status'];
        $projects_id = (int) $_REQUEST['category_id'];
        $update =  $this->Categories_m->update_category_status($category_status,$projects_id);
    
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