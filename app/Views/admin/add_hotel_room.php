<?php

$edit_mode = false;

if (isset($edit_hotel_room) && $edit_hotel_room == true) {
    $edit_mode = true;
}

$pageTitle = "Create Hotel Room";
$ActionLink = ADMIN_ADD_HOTEL_ROOM_LINK;

$room_title = "";
$room_type = "";
$is_active = "";
$room_description  = "";
$hotel_id = 0;


if (isset($hotel_room_details) && (is_array($hotel_room_details) && sizeof($hotel_room_details) > 0)) {
    $room_title = (isset($hotel_room_details['room_title'])) ? $hotel_room_details['room_title'] : '';   
    $room_type = (isset($hotel_room_details['room_type'])) ? $hotel_room_details['room_type'] : '';   
    $room_description = (isset($hotel_room_details['room_description'])) ? $hotel_room_details['room_description'] : "";        
    $hotel_id = (isset($hotel_room_details['hotel_id'])) ? (int)$hotel_room_details['hotel_id'] : 0;   
    
  
    
    

    if (isset($hotel_room_details['is_active'])) {
        if ($hotel_room_details['is_active'] == 1) {
            $is_active = "checked";
        }
    }
}

if ($edit_mode) {
    $ActionLink = ADMIN_EDIT_HOTEL_ROOM_LINK . '/' . $hotel_room_id;
    $pageTitle = "Edit Hotel Room";    
   
}

$hotel_options = '<option value = 0>Select Hotel</option>';



if(isset($hotels) && is_array($hotels) && sizeof($hotels) > 0){

    foreach($hotels as $key => $hotel){
        $hotel_title = $hotel['hotel_title'];
        $chotel_id = $hotel['hotel_id'];        

        $selected =  ($chotel_id == $hotel_id) ? 'selected' : '';       
        

        $hotel_options .= '<option '.$selected.' value='.$chotel_id.'>'.$hotel_title.'</option>';

    }
}


$otherImageHtml = '';

if(isset($hotel_room_details['other_images']) && is_array(($hotel_room_details['other_images'])) && sizeof($hotel_room_details['other_images']) > 0){
    foreach($hotel_room_details['other_images'] as $key => $other_image){
        $imageName = $other_image['image_path'];
        $imageId = $other_image['image_id'];      
        $imagePATH = UPLOAD_FOLDER.'original/'.$imageName;     

        $otherImageHtml .= '<div class="outer col-md-2" id="img_'.$imageId.'">
                                <ion-card class="inner" *ngFor="let i of images">
                                    <img src="'.$imagePATH.'" />
                                    <span  class="close-icon delete-image" data-id="'.$imageId.'">X</span>
                                </ion-card>
                            </div> ';
    }
}

echo " <style>

    .close-icon {
      position: absolute;
      right: -8rem;
      margin-top: -10rem;
      color: red;
      font-size: 18px;
     }
    
    .inner {
      position: relative;
      /* background: #ccc; */
      height: 40px;
      width: 100%;
      margin: 5px;
    }
    .close-icon:hover{
      cursor: pointer;
    }
    .outer {
      height: 90px;
      width: 100px;
    }
    </style>";

?>

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"><?= $pageTitle ?></h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <?php
                            $attributes = ['id' => 'frm_hotel_room_manipulation', 'class' => 'gy-3', 'enctype' => 'multipart/form-data'];
                            echo form_open($ActionLink, $attributes);
                            ?>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="hotel_id">Hotel:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="hotel_id" name="hotel_id">
                                                    <?= $hotel_options ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="room_title">Room Title:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $room_title ?>" class="form-control" name="room_title" id="room_title" placeholder="Enter Room title" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="room_type">Room Type:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $room_type ?>" class="form-control" name="room_type" id="room_type" placeholder="Enter Room type" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                               
                               
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="room_description">Room Description:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">                                                
                                                <textarea name="room_description" id="room_description" class="form-control"><?= $room_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>                               
                               

                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="other_images">Room images: </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="file" name="other_hotel_room_images[]" id="other_hotel_room_images" accept="image/*" multiple>
                                            </div>

                                            <?php if ($edit_mode && $otherImageHtml != '') : ?>                                           
                                                <div class="form-group bordered-group">
                                                    <div class="row">
                                                        <?=  $otherImageHtml ?>                                                  
                                                    </div>
                                                </div>                                           
                                            <?php endif; ?>    
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="is_active">Is active?: </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="checkbox" <?= $is_active ?> name="	is_active" id="	is_active">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary"><?= $pageTitle ?></button>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        </div><!-- card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>