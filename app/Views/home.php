<?php
    $slider_html = '';
    $data_target_html = '';
    if(is_array($slider) && sizeof($slider) > 0){
        foreach($slider as $key => $slide){

            $active = '';
            if($key == 0)
                $active = 'active';
            $image = $slide['image'];
            $sliderId = $slide['id'];
            
            
            $slider_html .= '<div class="item slidebackground '.$active.'" style="background:url('.BASE_URL.'/assets/img/'.$image.');">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="carousel-caption">
                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>'; 

            $data_target_html .= '<li data-target="#slider-experience" data-slide-to="'.$key.'" class="'.$active.'" style="width: 8px;height: 8px;"></li>';
          
        }
    }

 ?> 
<section id="slider"><!--
<div class="tp-banner-container" style="overflow: visible;">  -->
    <!-- Full Page Image Background Carousel Header -->  
    <!-- start work experience -->
    <div class="experience">
        <div class="row">
            <div class="col-md-12">                               
                <div id="slider-experience" class="carousel slide" data-ride="carousel">
                    <!-- indicators dot nav -->
                    <ol class="carousel-indicators">
                        <?=  $data_target_html ?>
                        <!--<li data-target="#slider-experience" data-slide-to="3"></li>-->
                    </ol>
                    <!-- wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                       <?= $slider_html ?>
                    </div>
                    <!-- controls next and prev buttons -->

                    <!--                        <a href="#slider-experience" class="left carousel-control" role="button" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                            </a>
                    
                                            <a href="#slider-experience" class="right carousel-control" role="button" data-slide="next">
                                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                            </a>-->

                </div> <!-- end slider bootstrap -->
            </div> <!-- end div experience -->
        </div> <!-- end row experience -->
    </div> <!-- end container experience -->

    <!-- end work experience -->

    <!--</div>
    --></section> 


  



<!-- Featured Jobs Section Start -->
<section class="featured-jobs section" style="padding: 25px 0;">
    <div class="container">      
        <div class="row">

            <?php
                if(is_array($categories) && sizeof($categories) > 0){
                    foreach($categories as $key => $category){
                        $categoryId     = $category['category_id'];
                        $categoryTitle = $category['category_name'];
                        $categoryImage  = $category['category_image'];

                        ?>
                         <div class="col-md-4 col-sm-6 col-xs-6">
                            <div class="featured-item">
                                <div class="featured-wrap">
                                    <div class="featured-inner">
                                        <figure class="item-thumb">
                                            <a class="hover-effect" href="<?php echo LISTING_LINK.$categoryId; ?>">
                                                <img src="<?php echo BASE_URL; ?>/assets/img/categories/<?= $categoryImage ?>" alt="">
                                            </a>
                                        </figure>
                                        <div class="item-body">
                                            <a href="<?php echo LISTING_LINK.$categoryId; ?>" class="btn btn-sm btn-common" style="width: 100%"><?= $categoryTitle ?></a>
                                        </div>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                        <?php
                    }
                    
                }
            ?>
                     
        </div>
    </div>
</section>
<!-- Featured Jobs Section End -->

<!-- Counter Section Start -->
<section id="counter">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="counting">
                    <div class="icon">
                        <i class="ti-face-smile"></i>
                    </div>
                    <div class="desc">                
                        <h2>Happy Tourist</h2>
                        <h1 class="counter">10312</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="counting">
                    <div class="icon">
                        <i class="ti-user"></i>
                    </div>
                    <div class="desc">
                        <h2>Our Members</h2>
                        <h1 class="counter">166</h1>                
                    </div>
                </div>
            </div>          
        </div>
    </div>
</section>

   <!-- Pricing Table Section -->
      <section id="pricing-table" class="section">
        <div class="container">
          <div class="row">
            <div class="col-sm-4">
              <div class="table">
                <div class="title">
                  <h3>Silver</h3>
                </div>
                 <div class="pricing-header">
                    <p class="price-value"> <sup>$</sup>0</p>
                    <p class="price-quality">/forever</p>
                 </div>
                <ul class="description">
                  <li>Post 1 Job</li>
                  <li>No Featured Job</li>
                  <li>Edit Your Job Listing</li>
                  <li>Manage Application</li>
                  <li>30-day Expired</li>
                </ul>
                <button class="btn btn-common" type="submit">Get Started</button>
              </div> 
            </div>
            <div class="col-sm-4">
              <div class="table" id="active-tb">
                <div class="title">
                  <h3>Gold</h3>
                </div>
                 <div class="pricing-header">
                    <p class="price-value"> <sup>$</sup>99</p>
                    <p class="price-quality">/90 DAYS</p>
                 </div>
                <ul class="description">
                  <li>Post 1 Job</li>
                  <li>No Featured Job</li>
                  <li>Edit Your Job Listing</li>
                  <li>Manage Application</li>
                  <li>30-day Expired</li>
                </ul>
                <button class="btn btn-common" type="submit">Get Started</button>
             </div> 
            </div>
            <div class="col-sm-4">
              <div class="table">
                <div class="title">
                  <h3>Platinum</h3>
                </div>
                 <div class="pricing-header">
                    <p class="price-value"> <sup>$</sup>199</p>
                    <p class="price-quality">/180 DAYS</p>                    
                 </div>
                <ul class="description">
                  <li>Post 1 Job</li>
                  <li>No Featured Job</li>
                  <li>Edit Your Job Listing</li>
                  <li>Manage Application</li>
                  <li>30-day Expired</li>
                </ul>
                <button class="btn btn-common" type="submit">Get Started</button>
              </div> 
            </div>
          </div>
        </div>
      </section>
      <!-- Pricing Table Section End -->

<!-- Counter Section End -->
<!-- Main container Start -->  
      <div class="about section">
        <div class="container">
          <div class="row">        
            <?php
                $aboutImage = "";
                $aboutTitle = "";
                $aboutDescription = "";
                if(isset($saputara_about) && is_array($saputara_about)){
                    $aboutImage = $saputara_about['image'];
                    $aboutTitle = $saputara_about['title'];
                    $aboutDescription = $saputara_about['description'];

                }
            ?>    
            <div class="col-md-6 col-sm-12">
              <img src="<?php echo BASE_URL; ?>/assets/img/<?=  $aboutImage ?>" alt="">              
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="about-content">
                <h2 class="medium-title"><?= $aboutTitle ?></h2>
                    <?= $aboutDescription ?>
                    <br>
                <a href="<?php echo CONTACT_LINK; ?>" class="btn btn-common">Enquire now</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Main container End -->

