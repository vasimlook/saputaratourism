<?php namespace App\Controllers;
class Home_c extends BaseController
{
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->security = \Config\Services::security();                        
    }
    public function index() {        
        $data['title'] = HOME_TITLE;        
        echo front_view('home',$data);
    }
    public function about() {        
        $data['title'] = ABOUT_TITLE;        
        echo front_view('about',$data);
    }
    public function explore() {        
        $data['title'] = EXPLORE_TITLE;        
        echo front_view('explore',$data);
    }
    public function contact() {        
        $data['title'] = CONTACT_TITLE;        
        echo front_view('contact',$data);
    }
    public function festival() {        
        $data['title'] = FESTIVAL_TITLE;        
        echo front_view('festival',$data);
    }
    public function news() {        
        $data['title'] = NEWS_TITLE;        
        echo front_view('news',$data);
    }
    public function listing($cat_id) {        
        $data['title'] = LISTING;        
        echo front_view('listing',$data);
    }
    
    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }    
}
