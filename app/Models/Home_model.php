<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Home_model extends Model {
    
    protected $db;
    protected $session;   
    public function __construct() {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }

    public function get_categories(){

        $category = $this->db->query("SELECT *
                                    FROM   saputara_facility_categories
                                    WHERE is_active = 1 ");
        $categories = $category->getResultArray();      
        return $categories;
        
    } 
   
}
