<?php

$edit_mode = false;

if (isset($edit_facility) && $edit_facility == true) {
    $edit_mode = true;
}

$pageTitle = "Create Facility";
$ActionLink = ADMIN_ADD_HOTEL_FACILITY_LINK;

$facility_title = "";
$facility_descriptions = "";
$icon = "";


if (isset($facility_details) && (is_array($facility_details) && sizeof($facility_details) > 0)) {
    $facility_title = (isset($facility_details['facility_title'])) ? $facility_details['facility_title'] : '';   
    $facility_descriptions = (isset($facility_details['facility_descriptions'])) ? $facility_details['facility_descriptions'] : '';   
    $icon = (isset($facility_details['icon'])) ? $facility_details['icon'] : '';       
    

    if (isset($facility_details['is_active'])) {
        if ($facility_details['is_active'] == 1) {
            $is_active = "checked";
        }
    }
}

if ($edit_mode) {
    $ActionLink = ADMIN_EDIT_HOTEL_FACILITY_LINK . '/' . $facility_id;
    $pageTitle = "Edit Facility";     
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
                            $attributes = ['id' => 'frm_hotel_facility_manipulation', 'class' => 'gy-3', 'enctype' => 'multipart/form-data'];
                            echo form_open($ActionLink, $attributes);
                            ?>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="facility_title">Facility Title:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $facility_title ?>" class="form-control" name="facility_title" id="facility_title" placeholder="Enter facility title" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="facility_descriptions">Facility Description:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea name="facility_descriptions" id="facility_descriptions" class="form-control"><?= $facility_descriptions ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="icon">Facility Icon:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $icon ?>" class="form-control" name="icon" id="icon" placeholder="Enter facility icon" required="" autocomplete="off">
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