<?php namespace App\Models\client;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class Login_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
     public function client_login_select($username, $password) {
         
        $password = md5($password);
        $resclient = $this->db->query("SELECT * FROM `client` WHERE (user_email_id = '$username') AND user_email_password = '$password' AND user_status = 'ACTIVE' AND user_locked_status=0");
        $client_data = $resclient->getRowArray();
        
        if (isset($client_data)) {                     
           if (($username == $client_data['user_email_id']) && ($password == $client_data['user_email_password'])) {               

                $this->db->query("UPDATE client SET user_attempt =0,user_locked_status=0 WHERE client_user_id = '{$client_data['client_user_id']}'");
                
                $this->db->query("UPDATE client SET user_login_active = 1 WHERE client_user_id='" . $client_data['client_user_id'] . "' ");
                
//                $token=generateToken();                
//                $_SESSION['client']['client_tokencheck'] = $token;
//                sessionclient($client_data);
                $token=generateToken();                 
                $client_data['client_tokencheck'] = $token;
                $user_data=sessionClient($client_data);                                                
                $this->session->set($user_data);
                
                $uid=$client_data['client_user_id'];                                               
                $result_token = $this->db->query("select count(*) as allcount from client_token WHERE client_user_id='$uid'");
                $row_token = $result_token->getRowArray();                               
                if ($row_token['allcount'] > 0) {                    
                    $this->db->query("update client_token set token='$token' where client_user_id='$uid'");
                } else {
                    $this->db->query("insert into client_token(client_user_id,token) values('$uid','$token')");
                }
                
                return true;
            }
        } else {
            $get_user = $this->db->query("SELECT * FROM client WHERE user_email_id = '$username' ");
            $check = $get_user->getRowArray();
            if (is_array($check)) {
                $attempt=$check['user_attempt'];
                if ($attempt == 0 || $attempt == 1) {
                    $msgAttempt=2-$attempt;
                    $this->db->query("UPDATE client SET user_attempt = user_attempt+1 WHERE client_user_id = '{$check['client_user_id']}'");
                    successOrErrorMessage("Invalid Username & Password. Account will be locked after $msgAttempt unsuccessful attempts", 'error');
                }
                if ($attempt >= 2) {
                    $this->db->query("UPDATE client SET user_attempt=user_attempt+1,user_locked_status=1 WHERE client_user_id = '{$check['client_user_id']}'");                  
                    successOrErrorMessage('Your account is locked after consecutive failure attempts. Please contact your school with your email id to unlock', 'error');
                }
                return false;
            }
        }
        successOrErrorMessage("Invalid Username & Password", 'error');
        return false;
    }
        
    public function getTokenAndCheck($table,$user_id) {
        $table=$table.'_token';
        $result = $this->db->query("SELECT token FROM $table where client_user_id='$user_id'");
        $data = $result->getRowArray();        
        if($data){
            return $data;
        }
        return false;
    }
    public function update_logout_status($user_id) {
        $query_res = $this->db->query("UPDATE client SET user_login_active = 0 WHERE client_user_id='" . $user_id . "' ");
        if ($query_res) {
            return true;
        }
    }
    
    public function check_current_password($current_password) {
        $current_password = md5($current_password);
        $client_user_id = $_SESSION['client']['client_user_id'];        
        $check = $this->db->query("SELECT * FROM client
                                       WHERE client_user_id = '" . $client_user_id . "'
                                       AND user_email_password ='" . $current_password . "'");
        $row = $check->getRowArray();        
        if (isset($row)) {
            if ($current_password == $row['user_email_password']) {
                return true; //matched
            }
        }
        return false; //not matched
    }

    public function update_password($params) {
        $new_password = md5($params['user_new_password']);
        $client_user_id = $_SESSION['client_user_id'];
        $result = $this->db->query("UPDATE client
                              SET user_email_password = '" . $new_password . "'
                              WHERE client_user_id = '" . $client_user_id . "'");
        return $result; //return true/false
    }
}
