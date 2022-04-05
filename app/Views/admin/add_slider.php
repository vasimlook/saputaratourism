<?php

$edit_mode = false;

if (isset($edit_slider) && $edit_slider == true) {
    $edit_mode = true;
}

$imageRequired = true;
$sliderImage = "";

$pageTitle = "Create Slider";
$ActionLink = ADMIN_ADD_SLIDER_LINK;

$slider_title = "";
$slider_position = "";
$is_active = "";

if (isset($slider_details) && (is_array($slider_details) && sizeof($slider_details) > 0)) {
    $slider_title = (isset($slider_details['slider_title'])) ? $slider_details['slider_title'] : '';
    $slider_position = (isset($slider_details['slider_position'])) ? $slider_details['slider_position'] : '';
    

    if (isset($slider_details['is_active'])) {
        if ($slider_details['is_active'] == 1) {
            $is_active = "checked";
        }
    }
}

if ($edit_mode) {
    $ActionLink = ADMIN_EDIT_SLIDER_LINK . '/' . $slider_id;
    $pageTitle = "Edit Slider";

    if (isset($slider_details['slider_image']) && $slider_details['slider_image'] != '') {
        $imageRequired = false;
        $sliderImage = $slider_details['slider_image'];
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
                            $attributes = ['id' => 'frm_slider_manipulation', 'class' => 'gy-3', 'enctype' => 'multipart/form-data'];
                            echo form_open($ActionLink, $attributes);
                            ?>
                            <div class="row g-3 align-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label float-right" for="slider_title">Slider Title:</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="text" value="<?= $slider_title ?>" class="form-control" name="slider_title" id="slider_title" placeholder="Enter slider title" required="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row g-3 align-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label float-right" for="slider_image">Slider Image: </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="file" accept="image/*" name="slider_image" id="slider_image" <?= ($imageRequired) ? "required" : "" ?>>
                                        </div>
                                        <?php if ($edit_mode && $sliderImage != '') : ?>
                                            <div style="margin-top: 10px;">
                                                <img src="<?= UPLOAD_FOLDER . 'original/' . $sliderImage ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label float-right" for="slider_position">Slider Position: </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <select id="slider_position" name="slider_position">
                                                <option value="">Select position</option>
                                                <option <?= ($slider_position == 'left') ? 'selected' : '' ?> value="left">LEFT</option>
                                                <option <?= ($slider_position == 'right') ? 'selected' : '' ?> value="right">RIGHT</option>
                                                <option <?= ($slider_position == 'center') ? 'selected' : '' ?> value="center">CENTER</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                            
                            
                            <div class="row g-3 align-center">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label float-right" for="urgent_need">Is Active?: </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="checkbox" <?= $is_active ?> name="is_active" id="is_active">
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