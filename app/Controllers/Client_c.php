<?php

namespace App\Controllers;
use App\Models\client\Login_m;
class Client_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->security = \Config\Services::security();        
        sessionCheckClient();                   
        if (isset($_SESSION['client']['client_user_id'])) {            
                $result = $this->Login_m->getTokenAndCheck('client', $_SESSION['client']['client_user_id']);
                if ($result) {
                    $token = $result['token'];
                    if ($_SESSION['client']['client_tokencheck'] != $token) {                                                                       
                            logoutUser('client');
                            header('Location: ' .CLIENT_LOGIN_LINK);
                            exit();                        
                    }   
                }else{
                    logoutUser('client');
                    header('Location: ' . CLIENT_LOGIN_LINK);
                    exit();
                } 
            
        }                      
    }
    public function client_dashboard(){       
      
        $data['title'] = CLIENT_DASHBOARD; 
        echo client_view('client/dashboard',$data);
    }

    public function update_profile(){         
        $result=array();               
        if(isset($_POST['user_current_password']) && $_POST['user_current_password']!=''){            
            if($this->Login_m->check_current_password($_POST['user_current_password'])){                
                $res = $this->Login_m->update_password($_POST);                    
                if($res){
                    successOrErrorMessage("Password changed successfully", 'success');
                    $result['success']="success";                   
                }                
            }
            else{
                successOrErrorMessage("Current password does not match", 'error');
                $result['success']="fail";
            }                    
        } 
        helper('form');
        $data['title']= CLIENT_UPDATE_PROFILE_TITLE;        
        echo client_view('client/update_profile',$data);
    } 

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
}
?>