<?php namespace App\Controllers;
use App\Models\Home_model;
class Home_c extends BaseController
{
    private $security;     
    protected $session;
    private $Home_m;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Home_m = new Home_model();
        $this->security = \Config\Services::security();                        
    }
    public function index() {
        $categories = $this->Home_m->get_categories();                 
        $data['categories'] = $categories;        
        $data['title'] = HOME_TITLE;        
        echo front_view('home',$data);
    }
  
    public function listing($cat_id) {
        
        $cat_id = (int)$cat_id;
        $categoryDetails = array();
        $categoryDetails = $this->Home_m->get_category_details($cat_id);
        $categoryDetails['facilities'] = $this->Home_m->get_facilities($cat_id);
        $data['categoryDetails'] = $categoryDetails;
        $data['title'] = LISTING;        
        echo front_view('listing',$data);
    }

    public function details($id) {
        $data['title'] = DETAILS;        
        echo front_view('details',$data);
    }
    
    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }    
}
