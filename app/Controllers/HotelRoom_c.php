<?php

namespace App\Controllers;
use App\Models\admin\HotelRoom_m;
use App\Models\admin\Login_m;
class HotelRoom_c extends BaseController{
    private $Login_m;
    private $security;     
    protected $session;
    public function __construct() {   
        $this->session = \Config\Services::session();
        $this->session->start(); 
        helper('url');
        helper('functions');
        $this->Login_m = new Login_m();
        $this->HotelRoom_m = new HotelRoom_m();
        $this->security = \Config\Services::security();        
        sessionCheckAdmin();                   
        if (isset($_SESSION['admin']['admin_user_id'])) {            
                $result = $this->Login_m->getTokenAndCheck('admin', $_SESSION['admin']['admin_user_id']);
                if ($result) {
                    $token = $result['token'];
                    if ($_SESSION['admin']['admin_tokencheck'] != $token) {                                                                       
                            logoutUser('admin');
                            header('Location: ' . ADMIN_LOGIN_LINK);
                            exit();                        
                    }   
                }else{
                    logoutUser('admin');
                    header('Location: ' . ADMIN_LOGIN_LINK);
                    exit();
                } 
            
        }                      
    }

    public function view(){    
        $data['title'] = VIEW_HOTEL_ROOM; 
        echo admin_view('admin/view_hotel_room',$data);
    }
    
    public function add(){
      

        $has_error = false;
        $error_messages  = array();
    
        $hotel_room_details = array();
    
        if (
          isset($_POST['room_title']) ) {
    
          $validate = self::validate_hotel_room($_POST);

                   
    
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $hotel_room_details = $validate['hotel_room_details'];           
          
        }
    
        if (!$has_error && (is_array($hotel_room_details) && sizeof($hotel_room_details) > 0)) {
          //create hotel  
    
          $hotelRoomId = $this->HotelRoom_m->create_hotel_room($hotel_room_details);
    
          if ($hotelRoomId) {   
            
            if (($_FILES['other_hotel_room_images']['name'][0]) != '') {
              $other_hotel_images = multiImageUpload('other_hotel_room_images');            
              foreach ($other_hotel_images as $poi) {
                  $params = array();
                  $params['room_id'] = $hotelRoomId;
                  $params['image_path'] = $poi[2]['file_name'];
                  $this->HotelRoom_m->add_hotel_room_images($params);
              }
           }                  
    
            successOrErrorMessage("Hotel room has been successfully created", 'success');
            return redirect()->to(ADMIN_VIEW_HOTEL_ROOM_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }
    
        helper('form');

        $hotels = $this->HotelRoom_m->get_hotels();    
        $data['hotels'] = $hotels;       
        $data['hotel_room_details'] = $hotel_room_details;
        $data['title'] = ADD_HOTEL_ROOM; 
        echo admin_view('admin/add_hotel_room',$data);
    }

    public function page404() {        
        $data['title'] = 'error';        
        echo single_page('errors/html/custome_error_404',$data);
    }
    

    function validate_hotel_room($hotelRoomsData){
        $room_title = trim($hotelRoomsData['room_title']);       
        $room_type = trim($hotelRoomsData['room_type']);       
        $room_description = trim($hotelRoomsData['room_description']);       
        $hotel_id = (int)$hotelRoomsData['hotel_id'];        

        $has_error = false;
        $hotel_room_details = array();  

        if ($hotel_id === 0) {
          $has_error = true;
          $error_messages[] = "Please select hotel!";
        } else {
          $hotel_room_details['hotel_id'] = $hotel_id;
        }    
    
        if (empty($room_title) || $room_title == '') {
          $has_error = true;
          $error_messages[] = "Room title can not be empty!";
        } else {
          $hotel_room_details['room_title'] = $room_title;
        }

        if (empty($room_type) || $room_type == '') {
          $has_error = true;
          $error_messages[] = "Room type can not be empty!";
        } else {
          $hotel_room_details['room_type'] = $room_type;
        }

        if (empty($room_description) || $room_description == '') {
          $has_error = true;
          $error_messages[] = "Room description can not be empty!";
        } else {
          $hotel_room_details['room_description'] = $room_description;
        }
       
        if (isset($hotelRoomsData['is_active']) && $hotelRoomsData['is_active'] == "on") {
          $hotel_room_details['is_active'] = 1;
        }               
    
        return array(
          'has_error' => $has_error,
          'error_messages' => $error_messages,
          'hotel_room_details' => $hotel_room_details
        );
    }

    public function edit_hotel_room($hotel_room_id){
        helper('form');  
        $hotel_room_details = $this->HotelRoom_m->get_hotel_room_details($hotel_room_id);
        $hotel_room_images = $this->HotelRoom_m->get_hotel_room_images($hotel_room_id);
        
        $has_error = false;
        $error_messages  = array();
        $submitForm = false;

        if(is_array($hotel_room_details) && sizeof($hotel_room_details) > 0){          
  
          $hotel_room_details['other_images'] = $hotel_room_images;
        }
      
       
  
        if (isset($_POST['room_title']) ) {
    
          $submitForm = true;
          $validate = self::validate_hotel_room($_POST);        
          $has_error = $validate['has_error'];
          $error_messages = $validate['error_messages'];
          $hotel_room_details = $validate['hotel_room_details'];               

          if(isset($_FILES['hotel_room_main_image'])){
            $main_img = singleImageUpload('hotel_room_main_image');
            $hotelRoomImage = $main_img[2]['file_name'];
      
            if (empty($hotelRoomImage) || $hotelRoomImage == '') {            
            } else {
              $hotel_room_details['hotel_room_main_image'] = $hotelRoomImage;
            }
          } 
    
        }
  
        if ($submitForm && !$has_error && (is_array($hotel_room_details) && sizeof($hotel_room_details) > 0)) {
          //edit hotel ROOM
    
          $update = $this->HotelRoom_m->update_hotel_room($hotel_room_details,$hotel_room_id);
    
          if ($update) {

            if (($_FILES['other_hotel_room_images']['name'][0]) != '') {
              $other_hotel_room_images = multiImageUpload('other_hotel_room_images');
              foreach ($other_hotel_room_images as $poi) {
                  $params = array();
                  $params['room_id'] = $hotel_room_id;
                  $params['image_path'] = $poi[2]['file_name'];                 
                  $this->HotelRoom_m->add_hotel_room_images($params);
            }         

          }

            successOrErrorMessage("Room has been successfully updated", 'success');
            return redirect()->to(ADMIN_VIEW_HOTEL_ROOM_LINK);
          }
        } else if (is_array($error_messages) && sizeof($error_messages) > 0) {
          $errors = implode('<br>', $error_messages);
          successOrErrorMessage($errors, 'error');
        }

        $hotels =  $this->HotelRoom_m->get_hotels();          
       
        $data['hotels'] = $hotels;       
        $data['edit_hotel_room'] = true;        
        $data['hotel_room_id'] = $hotel_room_id;
        $data['hotel_room_details'] = $hotel_room_details;
        $data['title'] = ADMIN_EDIT_HOTEL_ROOM_TITLE; 
        echo admin_view('admin/add_hotel_room',$data);
      }

    
    public function update_status(){
        $hotel_room_status = (int) $_REQUEST['hotel_room_status'];
        $hotel_room_id = (int) $_REQUEST['hotel_room_id'];
        $update =  $this->HotelRoom_m->update_hotel_room_status($hotel_room_status,$hotel_room_id);
    
        if($update){
          $output = array(
            'success' => 'success'
          );
        }else{
          $output = array(
            'error' => true
          );
        }
    
        echo json_encode($output);
        
    }   

    public function delete_hotel_room_image(){
      $imageId = (int)$_REQUEST['image_id'];
      $delete =  $this->HotelRoom_m->delete_hotel_room_image($imageId);
  
      if($delete){
        $output = array(
          'success' => 'success'
        );
      }else{
        $output = array(
          'error' => true
        );
      }
  
      echo json_encode($output);
    }
}
?>