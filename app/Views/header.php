<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="author" content="Jobboard">

        <title><?php echo $title; ?></title>    

        <!-- Favicon -->
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css" type="text/css">    
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/jasny-bootstrap.min.css" type="text/css">  
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap-select.min.css" type="text/css">  
        <!-- Material CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/material-kit.css" type="text/css">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fonts/font-awesome.min.css" type="text/css"> 
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fonts/themify-icons.css"> 

        <!-- Animate CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/extras/animate.css" type="text/css">
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/extras/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/extras/owl.theme.css" type="text/css">
        <!-- Rev Slider CSS -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/extras/settings.css" type="text/css"> 
        <!-- Slicknav js -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/slicknav.css" type="text/css">
        <!-- Main Styles -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/main.css" type="text/css">
        <!-- Responsive CSS Styles -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/responsive.css" type="text/css">

        <!-- Color CSS Styles  -->
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/assets/css/colors/lightgreen.css" media="screen" />   

        <style>
            @import url(https://fonts.googleapis.com/css?family=Lato:400,700|Montserrat:400,700);        
            div.border {
                border-bottom: 4px solid #40E0D0;
                content: '';
                width: 25px;
                margin-bottom: 4%;
            }

            h4 {
                color: #008080;
                font-weight: 700;
                font-size: 32px;
                font-family: 'Lato', sans-serif;
            }


            /*/ start about work experience /*/  

            .experience h4 {
                color: #fff;
            }

            .experience {
                /* margin-top: 5%; */
                width: 100%;
                background-color: #222;
                height: auto;
                background: -webkit-radial-gradient(center, ellipse cover, rgba(232,255,168,1) 0%, rgba(0,163,163,0.35) 100%), url(http://2.1m.yt/tPpsnnE.jpg)  no-repeat top center scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
                -o-background-size: cover;
            }
            /*
            #slider-experience {
              padding-top: 30px;
              padding-bottom: 30px;
            }*/

            img.work {
                width: 50%;
                margin-bottom: 25px;
            }

            .experience date {
                font-style: italic;
                font-size: 17px;
            }

            .experience h5 {
                color: #008080;
                font-size: 27px;
                text-transform: uppercase;
                font-weight: bold;
            }


            .carousel-caption {
                position: static; /*/ this is to replace the images of bootstrap slider /*/
                margin-right: 15%;
                margin-left: 15%;
                margin-top: 5%;
                font-size: 22px;
                color: #333;
                min-height: 180px;
            }

            .carousel-control.left, .carousel-control.right {
                background: none;
            }
            .slidebackground{
                background-position: center !important;
                background-repeat: no-repeat !important;
                background-size: cover !important;
            }
            /*/ end about work experience /*/  
            
            .listingbox{
                box-shadow: 5px 6px 3px -4px rgba(0,0,0,0.65);
-webkit-box-shadow: 5px 6px 3px -4px rgba(0,0,0,0.65);
-moz-box-shadow: 5px 6px 3px -4px rgba(0,0,0,0.65);
            }
            
        </style>        
    </head>
    <body>  
        <!-- Header Section Start -->
        <div class="header">    
            <!-- Start intro section -->
            <section id="intro" class="section-intro">
                <div class="logo-menu">
                    <nav class="navbar navbar-default" role="navigation" data-offset-top="50" style="min-height: 100px;">
                        <div class="container">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand logo" href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>/assets/img/logo.png" alt="" style="width: 116px;height: 84px;"></a>
                            </div>

                            <div class="collapse navbar-collapse" id="navbar">              
                                <!-- Start Navigation List -->
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a class="active" href="<?php echo BASE_URL; ?>">
                                            Home
                                        </a>                                       
                                    </li> 
                                    <li>
                                        <a href="<?php echo ABOUT_US_LINK; ?>">
                                            About us
                                        </a>                                       
                                    </li>
                                    <li>
                                        <a href="<?php echo EXPLORE_LINK; ?>">
                                            Explore Saputara
                                        </a>                                       
                                    </li>
                                    <li>
                                        <a href="<?php echo CONTACT_LINK; ?>">
                                            Contact us
                                        </a>                                       
                                    </li>
                                    <li>
                                        <a href="<?php echo FESTIVAL_LINK; ?>">
                                            Festival
                                        </a>                                       
                                    </li>
                                    <li>
                                        <a href="<?php echo NEWS_LINK; ?>">
                                            News
                                        </a>                                       
                                    </li>
                                </ul>              
                            </div>                           
                        </div>
                        <!-- Mobile Menu Start -->
                        <ul class="wpb-mobile-menu">                           
                            <li>
                                <a class="active" href="<?php echo BASE_URL; ?>">
                                    Home
                                </a>                                       
                            </li> 
                            <li>
                                <a href="<?php echo ABOUT_US_LINK; ?>">
                                    About us
                                </a>                                       
                            </li>
                            <li>
                                <a href="<?php echo EXPLORE_LINK; ?>">
                                    Explore Saputara
                                </a>                                       
                            </li>
                            <li>
                                <a href="<?php echo CONTACT_LINK; ?>">
                                    Contact us
                                </a>                                       
                            </li>
                            <li>
                                <a href="<?php echo FESTIVAL_LINK; ?>">
                                    Festival
                                </a>                                       
                            </li>
                            <li>
                                <a href="<?php echo NEWS_LINK; ?>">
                                    News
                                </a>                                       
                            </li>                              
                        </ul>
                        <!-- Mobile Menu End --> 
                    </nav>
                </div>
                <!-- Header Section End -->    
            </section>
            <!-- end intro section -->
        </div> 