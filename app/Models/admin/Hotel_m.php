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

    public function get_categories(){             
         
        $category = $this->db->query("SELECT *
                                        FROM   saputara_facility_categories
                                    WHERE is_active = 1 ");
        $category_details = $category->getResultArray();      

        return $category_details;  
    }

    public function load_package($params){
        $cat_id = (int)$params['cat_id'];
        $result = $this->db->query("SELECT * FROM saputara_facility_packages WHERE category_id = {$cat_id}");
        return $result->getResultArray();
    }

    public function add_hotel_images($params) {       
        $builder = $this->db->table('saputara_hotel_images');
        $builder->insert($params);
        return $this->db->insertID();
    }

    public function get_hotel_images($hotelId){
        $images = array();
        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return $images;
         
        $image = $this->db->query("SELECT *
                                        FROM  saputara_hotel_images
                                    WHERE hotel_id = {$hotelId} ");
        $hotel_images = $image->getResultArray();      

        return $hotel_images;  
    }

    public function delete_hotel_image($hotelId){
        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return false;
        
        $builder = $this->db->table('saputara_hotel_images');
        $builder->where('image_id', $hotelId);
        
        $builder->delete();     
        return true;
    }

    public function get_hotel_facilities(){
        $facility = $this->db->query("SELECT *
                                        FROM   	saputara_hotel_facilities
                                    WHERE is_active = 1 ");
        $facility_details = $facility->getResultArray();      

        return $facility_details; 
    }

    public function add_hotel_facilities($params){
        $builder = $this->db->table('saputara_client_hotel_facilities');
        $builder->insert($params);
        return $this->db->insertID();        
    }

    public function get_client_hotel_facilities($hotelId){

        $facilities = array();

        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return $facilities;

        $facility = $this->db->query("SELECT *
                                        FROM  saputara_client_hotel_facilities
                                    WHERE hotel_id = {$hotelId} ");
        $facility_details = $facility->getResultArray();      

        return $facility_details; 
    }

    public function delete_client_hotel_facilities($hotelId){
        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return false;
        
        $builder = $this->db->table('saputara_client_hotel_facilities');
        $builder->where('hotel_id', $hotelId);
        
        $builder->delete();     
        return true;
    }

    public function top_package_details($package_id){
        $details = array();
        $package_id = (int)$package_id;

        if($package_id === 0)
            return $details;
         
        $package = $this->db->query("SELECT *
                                        FROM   saputara_facility_packages
                                    WHERE package_id = {$package_id} ");
        $package_details = $package->getRowArray();      

        return $package_details;
    }

    public function add_hotel_package_details($params) {               
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_top_package_payment_history');
        $builder->insert($params);
        return $this->db->insertID();
    } 

    public function add_hotel_payment_id($hotelId,$paymentId){
        $hotelId = (int)$hotelId;
        $paymentId = (int)$paymentId;

        if($hotelId === 0 || $paymentId === 0)
            return false;
        
        $params['top_payment_id'] = $paymentId;        
        $builder = $this->db->table('saputara_hotel_modules');
        $builder->where('hotel_id', $hotelId);
        return $builder->update($params);    
    }

    public function update_last_payments($hotelId){
        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return false;
        
        $params['last_payments'] = 1;        
        $builder = $this->db->table('saputara_top_package_payment_history');
        $builder->where('module_id', $hotelId);
        $builder->where('module_type', 'hotel');
        return $builder->update($params);     
    }

    public function update_hotel_package_details($paymentId,$hotelId,$params){
        $hotelId = (int)$hotelId;

        if($hotelId === 0)
            return false;        
              
        $builder = $this->db->table('saputara_top_package_payment_history');
        $builder->where('module_id', $hotelId);
        $builder->where('module_type', 'hotel');
        $builder->where('payment_id', $paymentId);
        return $builder->update($params);     
    }

    
}
