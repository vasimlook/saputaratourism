<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class AdsPackages_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
    
    public function get_package_details($packageId){
        $details = array();
        $packageId = (int)$packageId;

        if($packageId === 0)
            return $details;
         
        $package = $this->db->query("SELECT *
                                        FROM   saputara_ads_packages
                                    WHERE package_id  = {$packageId} ");
        $package_details = $package->getRowArray();      

        return $package_details;    

    }
    
    public function create_package($params) {       
        $params['is_active'] = 1;
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_ads_packages');
        $builder->insert($params);
        return $this->db->insertID();
    } 

   

    public function update_package($params,$packageId){        
        $params['updated_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_ads_packages');
        $builder->where('package_id ', $packageId);
        return $builder->update($params);
    }

    public function update_package_status($package_status,$package_id){
        $package_id = (int)$package_id;

        if($package_id === 0)
            return false;

        $params['is_active'] = (int)$package_status;
        $builder = $this->db->table('saputara_ads_packages');
        $builder->where('package_id', $package_id);
        return $builder->update($params);
        
    }

    public function get_categories(){             
         
        $category = $this->db->query("SELECT *
                                        FROM   saputara_ads_packages
                                    WHERE is_active = 1 ");
        $category_details = $category->getResultArray();      

        return $category_details;  
    }
    
}
