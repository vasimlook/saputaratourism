<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">   
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Profile</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">                   
                    <div class="card">
                        <div class="card-inner">
                             <?php
                                $attributes = ['id' => 'frm_change_password','class'=>'gy-3'];
                                echo form_open(ADMIN_UPDATE_PROFILE_LINK,$attributes);
                               ?>                            
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="user_current_password">Current Password:</label>                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" name="user_current_password" id="user_current_password" placeholder="Enter Current Password" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">                                            
                                            <label class="form-label float-right" for="user_new_password">New Password:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control" name="user_new_password" id="user_new_password" placeholder="Enter New Password" required="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-4">
                                        <div class="form-group">                                             
                                             <label class="form-label float-right" for="user_confirm_password">Confirm Password: </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                 <input type="password" class="form-control" name="user_confirm_password" id="user_confirm_password" placeholder="Enter Confirm Password" required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>                                
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary">Update</button>                                          
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close();?> 
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>