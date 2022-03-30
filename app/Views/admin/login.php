<!DOCTYPE html>
<html lang="en" class="js">
    <head>        
        <meta charset="utf-8">
        <meta name="author" content="Softnio">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>images/favicon.png">
        <!-- Page Title  -->
        <title><?php echo $title; ?></title>
        <!-- StyleSheets  -->
        <link rel="stylesheet" href="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>css/dashlite.css">
        <link id="skin-default" rel="stylesheet" href="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>css/theme.css">
        <link href="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>css/toastr.min.css" rel="stylesheet" type="text/css"/>        
    </head>
    <body class="nk-body bg-white npc-general pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                            <div class="brand-logo pb-4 text-center">
                                <a href="<?php echo BASE_URL; ?>" class="logo-link">
                                   <h5>Child Wish Admin</h5>
                                </a>
                            </div>
                            <div class="card">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Sign-In</h4>
                                            <div class="nk-block-des">
                                                <p>Enter username and password for access</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                                
                                    <?php
                                    $attributes = ['class' => 'login-form', 'method' => 'POST', 'name' => 'login_form'];
                                    echo form_open(ADMIN_LOGIN_LINK, $attributes);
                                ?>                                                          
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="default-01">Email or Username</label>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" name="username" id="default-01" placeholder="Enter your email address or username" required="" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="password">Password</label>
                                                <!-- <a class="link link-primary link-sm" href="#">Forgot Code?</a> -->
                                            </div>
                                            <div class="form-control-wrap">
                                                <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                </a>
                                                <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Enter your password" autocomplete="off" required="" autocomplete="off"> 
                                            </div>
                                        </div>                                                                                                                                                                                          
                                        <div class="form-group">                                            
                                            <input type="submit" value="Sign in" class="btn btn-lg btn-primary btn-block">
                                        </div>
                                      <?php echo form_close();?>        
                                </div>
                            </div>
                        </div>
                        <div class="nk-footer nk-auth-footer-full">
                            <div class="container wide-lg">
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <div class="nk-block-content text-center text-lg-center">
                                            <p class="text-soft">&copy; <?php echo date("Y"); ?> <?php echo APPNAME; ?> All Rights Reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- wrap @e -->
                </div>
                <!-- content @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/bundle.js"></script>
        <script src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/scripts.js"></script>
        <script src="<?php echo EMPLOYEE_ASSETS_FOLDER; ?>js/toastr.min.js" type="text/javascript"></script>
        <?php include(APPPATH . "Views/admin/common/notify.php"); ?>
</html>