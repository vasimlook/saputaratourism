<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class HotelFacility_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
    
    public function get_facility_details($facilityId){
        $details = array();
        $facilityId = (int)$facilityId;

        if($facilityId === 0)
            return $details;
         
        $facility = $this->db->query("SELECT *
                                        FROM   saputara_hotel_facilities
                                    WHERE facility_id  = {$facilityId} ");
        $facility_details = $facility->getRowArray();      

        return $facility_details;    

    }
    
    public function create_facility($params) {       
        $params['is_active'] = 1;
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_hotel_facilities');
        $builder->insert($params);
        return $this->db->insertID();
    } 

   

    public function update_facility($params,$facilityId){        
        $params['updated_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_hotel_facilities');
        $builder->where('facility_id ', $facilityId);
        return $builder->update($params);
    }

    public function update_facility_status($facility_status,$facility_id){
        $facility_id = (int)$facility_id;

        if($facility_id === 0)
            return false;

        $params['is_active'] = (int)$facility_status;
        $builder = $this->db->table('saputara_hotel_facilities');
        $builder->where('facility_id', $facility_id);
        return $builder->update($params);
        
    }  
}
