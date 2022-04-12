<?php

namespace App\Controllers;
use App\Models\admin\TopPackagePayment_m;
use App\Models\admin\Login_m;
class TopPackagePayment_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->TopPackagePayment_m = new TopPackagePayment_m();
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
        $data['title'] = VIEW_TOP_PACKAGE_PAYMENT; 
        echo admin_view('admin/view_top_package_payment',$data);
    }  
    
    public function make_top_package_payments(){
        $payments_id = (int) $_REQUEST['payments_id'];      
        $update =  $this->TopPackagePayment_m->make_top_package_payments($payments_id);
    
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
  

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
}
?>