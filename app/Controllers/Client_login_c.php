<?php
namespace App\Controllers;

use App\Models\client\Login_m;

class Client_login_c extends BaseController {
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
    }
    public function index() {         
        helper('form');        
        if (isset($_SESSION['client']['client_user_id'])) {     
            if ($_SESSION['client']['client_user_id'] > 0) {                
                logoutUser('client');                 
                return redirect()->to(CLIENT_LOGIN_LINK);
            }
        }  
        
        if (isset($_POST['username']) && isset($_POST['password'])) {            
            $result = $this->Login_m->client_login_select($_POST['username'], $_POST['password']);
            if ($result == true) {
                $userId = $_SESSION['client']['client_user_id'];
                $userType = $_SESSION['client']['client_usertype'];
                // log_message('info', "$userType id $userId logged into the system");                
                return redirect()->to(CLIENT_DASHBOARD_LINK);
            }
        }        
        $data['title'] = CLIENT_LOGIN_TITLE;
        echo single_page('client/login', $data);
    }
    public function logout() {
        logoutUser('client');
        return redirect()->to(CLIENT_LOGIN_LINK);
    }
}
