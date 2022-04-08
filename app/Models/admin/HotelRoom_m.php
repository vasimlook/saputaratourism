<?php namespace App\Models\admin;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class HotelRoom_m extends Model
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }  
    
    public function get_hotel_room_details($hotelRoomId){
        $details = array();
        $hotelRoomId = (int)$hotelRoomId;

        if($hotelRoomId === 0)
            return $details;
         
        $hotel_room = $this->db->query("SELECT *
                                        FROM   saputara_hotel_rooms
                                    WHERE room_id = {$hotelRoomId} ");
        $hotel_room_details = $hotel_room->getRowArray();      

        return $hotel_room_details;    

    }
    
    public function create_hotel_room($params) {       
        $params['is_active'] = 1;
        $params['created_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_hotel_rooms');
        $builder->insert($params);
        return $this->db->insertID();
    } 

   

    public function update_hotel_room($params,$hoteRoomlId){        
        $params['updated_at'] = date("Y-m-d H:i:s");
        $params['created_by'] = (int)$_SESSION['admin']['admin_user_id'];
        $builder = $this->db->table('saputara_hotel_rooms');
        $builder->where('room_id', $hoteRoomlId);
        return $builder->update($params);
    }

    public function update_hotel_room_status($hotel_room_status,$hotel_room_id){
        $hotel_room_id = (int)$hotel_room_id;

        if($hotel_room_id === 0)
            return false;

        $params['is_active'] = (int)$hotel_room_status;
        $builder = $this->db->table('saputara_hotel_rooms');
        $builder->where('room_id', $hotel_room_id);
        return $builder->update($params);
        
    }

    public function get_hotels(){             
         
        $hotel = $this->db->query("SELECT *
                                        FROM   saputara_hotel_modules where is_active = 1
                                    ");
        $hotel_details = $hotel->getResultArray();      

        return $hotel_details;  
    }  


    public function add_hotel_room_images($params) {       
        $builder = $this->db->table('saputara_room_images');
        $builder->insert($params);
        return $this->db->insertID();
    }

    public function get_hotel_room_images($hotelRoomId){
        $images = array();
        $hotelRoomId = (int)$hotelRoomId;

        if($hotelRoomId === 0)
            return $images;
         
        $image = $this->db->query("SELECT *
                                        FROM  saputara_room_images
                                    WHERE room_id = {$hotelRoomId} ");
        $room_images = $image->getResultArray();      

        return $room_images;  
    }

    public function delete_hotel_room_image($hotelRoomId){
        $hotelRoomId = (int)$hotelRoomId;

        if($hotelRoomId === 0)
            return false;
        
        $builder = $this->db->table('saputara_room_images');
        $builder->where('image_id', $hotelRoomId);
        
        $builder->delete();     
        return true;
    }
    
}
