<?php

$edit_mode = false;

if (isset($edit_packages) && $edit_packages == true) {
    $edit_mode = true;
}

$pageTitle = "Create Package";
$ActionLink = ADMIN_ADD_PACKAGES_LINK;

$projects_title = "";
$package_price = "";
$package_duration = "";
$urgent_need = "";
$package_category  = 0;

if (isset($package_details) && (is_array($package_details) && sizeof($package_details) > 0)) {
    $package_title = (isset($package_details['package_title'])) ? $package_details['package_title'] : '';   
    $package_price = (isset($package_details['package_price'])) ? $package_details['package_price'] : '';   
    $package_duration = (isset($package_details['package_duration'])) ? $package_details['package_duration'] : '';   
    $package_category = (isset($package_details['category_id'])) ? $package_details['category_id'] : '';   
    

    if (isset($package_details['is_active'])) {
        if ($package_details['is_active'] == 1) {
            $is_active = "checked";
        }
    }
}

if ($edit_mode) {
    $ActionLink = ADMIN_EDIT_PACKAGES_LINK . '/' . $package_id;
    $pageTitle = "Edit Package";     
}

$category_options = '<option value = 0>Select package category</option>';

if(isset($categories) && is_array($categories) && sizeof($categories) > 0){
    foreach($categories as $key => $catgory){
        $category_name = $catgory['category_title'];
        $category_id = $catgory['category_id'];

        $selected = ($package_category == $category_id) ? 'selected'  : '';

        $category_options .= '<option '.$selected.' value='.$category_id.'>'.$category_name.'</option>';

    }
}

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
                                            <label class="form-label float-right" for="package_title">Package Title:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $package_title ?>" class="form-control" name="package_title" id="package_title" placeholder="Enter package title" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="category_id">Package Categories:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="category_id" name="category_id">
                                                    <?= $category_options ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="package_price">Package Price:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="number" value="<?= $package_price ?>" class="form-control" name="package_price" id="package_price" placeholder="Enter package price" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="package_duration">Package duration (In month):</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="number" value="<?= $package_duration ?>" class="form-control" name="package_duration" id="package_duration" placeholder="Enter package duration" required="" autocomplete="off">
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