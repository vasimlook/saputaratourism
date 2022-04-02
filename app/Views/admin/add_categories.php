<?php

$edit_mode = false;

if (isset($edit_projects) && $edit_projects == true) {
    $edit_mode = true;
}

$pageTitle = "Create Category";
$ActionLink = ADMIN_ADD_CATEGORIES_LINK;

$projects_title = "";
$urgent_need = "";

if (isset($category_details) && (is_array($category_details) && sizeof($category_details) > 0)) {
    $category_title = (isset($category_details['category_title'])) ? $category_details['category_title'] : '';   

    if (isset($category_details['is_active'])) {
        if ($category_details['is_active'] == 1) {
            $is_active = "checked";
        }
    }
}

if ($edit_mode) {
    $ActionLink = ADMIN_EDIT_CATEGORY_LINK . '/' . $category_id;
    $pageTitle = "Edit Category";     
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
                            $attributes = ['id' => 'frm_projects_manipulation', 'class' => 'gy-3', 'enctype' => 'multipart/form-data'];
                            echo form_open($ActionLink, $attributes);
                            ?>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="category_title">Category Title:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" value="<?= $category_title ?>" class="form-control" name="category_title" id="category_title" placeholder="Enter category title" required="" autocomplete="off">
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