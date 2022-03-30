<?php
namespace App\Controllers;

use App\Models\admin\Login_m;

class Admin_login_c extends BaseController {
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
        if (isset($_SESSION['admin']['admin_user_id'])) {     
            if ($_SESSION['admin']['admin_user_id'] > 0) {                
                logoutUser('admin');                 
                return redirect()->to(ADMIN_LOGIN_LINK);
            }
        }  
        
        if (isset($_POST['username']) && isset($_POST['password'])) {            
            $result = $this->Login_m->admin_login_select($_POST['username'], $_POST['password']);
            if ($result == true) {
                $userId = $_SESSION['admin']['admin_user_id'];
                $userType = $_SESSION['admin']['admin_usertype'];
                // log_message('info', "$userType id $userId logged into the system");                
                return redirect()->to(ADMIN_DASHBOARD_LINK);
            }
        }        
        $data['title'] = ADMIN_LOGIN_TITLE;
        echo single_page('admin/login', $data);
    }
    public function logout() {
        logoutUser('admin');
        return redirect()->to(ADMIN_LOGIN_LINK);
    }
}
