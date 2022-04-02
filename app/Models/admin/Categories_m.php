<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class Categories_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
    
    public function get_category_details($categoryId){
        $details = array();
        $categoryId = (int)$categoryId;

        if($categoryId === 0)
            return $details;
         
        $category = $this->db->query("SELECT *
                                        FROM   saputara_facility_categories
                                    WHERE category_id  = {$categoryId} ");
        $category_details = $category->getRowArray();      

        return $category_details;    

    }
    
    public function create_category($params) {       
        $params['is_active'] = 1;
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_facility_categories');
        $builder->insert($params);
        return $this->db->insertID();
    } 

   

    public function update_category($params,$categoryId){        
        $params['updated_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_facility_categories');
        $builder->where('category_id ', $categoryId);
        return $builder->update($params);
    }

    public function update_category_status($category_status,$category_id){
        $category_id = (int)$category_id;

        if($category_id === 0)
            return false;

        $params['is_active'] = (int)$category_status;
        $builder = $this->db->table('saputara_facility_categories');
        $builder->where('category_id', $category_id);
        return $builder->update($params);
        
    }
    
}
