<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class Hotel_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
    
    public function get_hotel_details($hotelId){
        $details = array();
        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return $details;
         
        $hotel = $this->db->query("SELECT *
                                        FROM   saputara_hotel_modules
                                    WHERE hotel_id = {$hotelId} ");
        $hotel_details = $hotel->getRowArray();      

        return $hotel_details;    

    }
    
    public function create_hotel($params) {       
        $params['is_active'] = 1;
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_hotel_modules');
        $builder->insert($params);
        return $this->db->insertID();
    } 

   

    public function update_hotel($params,$hotelId){        
        $params['updated_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_hotel_modules');
        $builder->where('hotel_id', $hotelId);
        return $builder->update($params);
    }

    public function update_hotel_status($hotel_status,$hotel_id){
        $hotel_id = (int)$hotel_id;

        if($hotel_id === 0)
            return false;

        $params['is_active'] = (int)$hotel_status;
        $builder = $this->db->table('saputara_hotel_modules');
        $builder->where('hotel_id', $hotel_id);
        return $builder->update($params);
        
    }

    public function get_clients(){             
         
        $client = $this->db->query("SELECT *
                                        FROM   client
                                    ");
        $client_details = $client->getResultArray();      

        return $client_details;  
    }
   

    public function get_ads_packges(){             
         
        $package = $this->db->query("SELECT *
                                        FROM   saputara_ads_packages
                                    WHERE is_active = 1 ");
        $package_details = $package->getResultArray();      

        return $package_details;  
    }
    
}
