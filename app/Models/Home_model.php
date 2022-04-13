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

    public function get_hotels(){
        $hotel = $this->db->query("SELECT *
                                    FROM   saputara_hotel_modules
                                    WHERE is_active = 1 ");
        $hotels = $hotel->getResultArray();      
        return $hotels;
    }

    public function get_category_details($categoryId){
        $category = $this->db->query("SELECT *
                                    FROM   saputara_facility_categories
                                    WHERE category_id = {$categoryId} ");
        $categories = $category->getRowArray();      
        return $categories;
    }
    
    public function get_facilities($categoryId){
        $facility = $this->db->query("SELECT *
                                    FROM   saputara_facility
                                    WHERE is_active = 1
                                    AND category_id = {$categoryId} ");
        $facilities = $facility->getResultArray();      
        return $facilities;

    }

    public function get_home_slider(){
        $slider = $this->db->query("SELECT *
                                    FROM   saputara_home_slider
                                    WHERE is_active = 1 ");
        $sliders = $slider->getResultArray();      
        return $sliders;
    }

    public function get_saputara_about(){
        $about = $this->db->query("SELECT *
                                    FROM   saputara_about
                                    WHERE is_active = 1 ");
        $about = $about->getRowArray();      
        return $about;
    }
   
}
