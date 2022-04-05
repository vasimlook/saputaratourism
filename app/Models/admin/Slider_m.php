<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class Slider_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
    
    public function get_slider_details($sliderId){
        $details = array();
        $sliderId = (int)$sliderId;

        if($sliderId === 0)
            return $details;
         
        $slider = $this->db->query("SELECT *
                                        FROM   saputara_slider
                                    WHERE slider_id  = {$sliderId} ");
        $slider_details = $slider->getRowArray();      

        return $slider_details;    

    }
    
    public function create_slider($params) {       
        $params['is_active'] = 1;
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_slider');
        $builder->insert($params);
        return $this->db->insertID();
    } 

   

    public function update_slider($params,$sliderId){        
        $params['updated_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_slider');
        $builder->where('slider_id ', $sliderId);
        return $builder->update($params);
    }

    public function update_slider_status($slider_status,$slider_id){
        $slider_id = (int)$slider_id;

        if($slider_id === 0)
            return false;

        $params['is_active'] = (int)$slider_status;
        $builder = $this->db->table('saputara_slider');
        $builder->where('slider_id', $slider_id);
        return $builder->update($params);
        
    }
    
}
