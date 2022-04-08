<?php

$edit_mode = false;

if (isset($edit_hotel) && $edit_hotel == true) {
    $edit_mode = true;
}

$hotel_facilities = array();

if(isset($get_client_hotel_facilities) && is_array($get_client_hotel_facilities) && sizeof($get_client_hotel_facilities)){
    foreach($get_client_hotel_facilities as $key=> $f){
        $hotel_facilities [] = $f['hotel_facility_id'];
    }
}

$imageRequired = true;
$hotelImage = "";

$pageTitle = "Create Hotel";
$ActionLink = ADMIN_ADD_HOTEL_LINK;

$hotel_title = "";
$hotel_descriptions = "";
$is_active = "";
$client_id  = 0;
$ads_package_id  = 0;
$main_category = 0;

if (isset($hotel_details) && (is_array($hotel_details) && sizeof($hotel_details) > 0)) {
    $hotel_title = (isset($hotel_details['hotel_title'])) ? $hotel_details['hotel_title'] : '';   
    $hotel_descriptions = (isset($hotel_details['hotel_descriptions'])) ? $hotel_details['hotel_descriptions'] : '';   
    $ads_package_id = (isset($hotel_details['ads_package_id'])) ? (int)$hotel_details['ads_package_id'] : 0;        
    $hotel_client_id = (isset($hotel_details['client_id'])) ? (int)$hotel_details['client_id'] : 0;   
    $main_category = (isset($hotel_details['main_category'])) ? (int)$hotel_details['main_category'] : 0;   
  
    
    

    if (isset($hotel_details['is_active'])) {
        if ($hotel_details['is_active'] == 1) {
            $is_active = "checked";
        }
    }
}

if ($edit_mode) {
    $ActionLink = ADMIN_EDIT_HOTEL_LINK . '/' . $hotel_id;
    $pageTitle = "Edit Hotel"; 
    
    if (isset($hotel_details['hotel_main_image']) && $hotel_details['hotel_main_image'] != '') {
        $imageRequired = false;
        $hotelImage = $hotel_details['hotel_main_image'];
    }
}

$category_options = '<option value = 0>Select Category</option>';
$client_options = '<option value = 0>Select client</option>';
$ads_package_options = '<option value = 0>Select ads package</option>';
$hotel_facilities_option = '<option value = 0 >Select hotel facilities</option>';


if(isset($facilities) && is_array($facilities) && sizeof($facilities) > 0){

    foreach($facilities as $key => $facility){
        $facility_name = $facility['facility_title'];
        $facility_id = $facility['facility_id'];        

        $selected =  (in_array($facility_id,$hotel_facilities)) ? 'selected' : '';
        
        

        $hotel_facilities_option .= '<option '.$selected.' value='.$facility_id.'>'.$facility_name.'</option>';

    }
}


if(isset($categories) && is_array($categories) && sizeof($categories) > 0){
    foreach($categories as $key => $catgory){
        $category_name = $catgory['category_title'];
        $category_id = $catgory['category_id'];        

        $selected = ($main_category == $category_id) ? 'selected'  : '';

        $category_options .= '<option '.$selected.' value='.$category_id.'>'.$category_name.'</option>';

    }
}

if(isset($clients) && is_array($clients) && sizeof($clients) > 0){
    foreach($clients as $key => $client){
        $client_name = $client['user_firstname'].' '.$client['user_lastname'];
        $client_id = $client['client_user_id'];

        $selected = ($hotel_client_id == $client_id) ? 'selected'  : '';

        $client_options .= '<option '.$selected.' value='.$client_id.'>'.$client_name.'</option>';

    }
}

if(isset($adsPackages) && is_array($adsPackages) && sizeof($adsPackages) > 0){
    foreach($adsPackages as $key => $ads){
        $package_title = $ads['package_title'];
        $package_id = $ads['package_id'];

        $selected = ($ads_package_id == $package_id) ? 'selected'  : '';

        $ads_package_options .= '<option '.$selected.' value='.$package_id.'>'.$package_title.'</option>';

    }
}

$otherImageHtml = '';

if(isset($hotel_details['other_images']) && is_array(($hotel_details['other_images'])) && sizeof($hotel_details['other_images']) > 0){
    foreach($hotel_details['other_images'] as $key => $other_image){
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
                            $attributes = ['id' => 'frm_package_manipulation', 'class' => 'gy-3', 'enctype' => 'multipart/form-data'];
                            echo form_open($ActionLink, $attributes);
                            ?>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="main_category">Main Category:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="main_category" name="main_category">
                                                    <?= $category_options ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="hotel_title">Hotel Title:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $hotel_title ?>" class="form-control" name="hotel_title" id="hotel_title" placeholder="Enter Hotel title" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="client_id">Hotel Client:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="client_id" name="client_id">
                                                    <?= $client_options ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="client_id">Hotel Facilities:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="facilities" name="facilities[]" multiple>
                                                    <?= $hotel_facilities_option ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                               
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="hotel_descriptions">Hotel Description:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">                                                
                                                <textarea name="hotel_descriptions" id="hotel_descriptions" class="form-control"><?= $hotel_descriptions ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="hotel_main_image">Hotel Image: </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="file" accept="image/*" name="hotel_main_image" id="hotel_main_image" <?= ($imageRequired) ? "required" : "" ?>>
                                            </div>
                                            <?php if ($edit_mode && $hotelImage != '') : ?>
                                                <div style="margin-top: 10px;">
                                                    <img src="<?= UPLOAD_FOLDER . 'original/' . $hotelImage ?>">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="other_images">Other images: </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="file" name="other_hotel_images[]" id="other_hotel_images" accept="image/*" multiple>
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
                                                <label class="form-label float-right" for="top_package_id">Top package:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="top_package_id" name="top_package_id">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>            
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="ads_package_id">ADS package:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="ads_package_id" name="ads_package_id">
                                                    <?= $ads_package_options ?>
                                                </select>
                                            </div>
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