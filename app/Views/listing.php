  <?php
        $cover = 'banner1.jpg';
        $categoryTitle = '';

        $facilitiesListHtml = '';
        if(isset($categoryDetails) && is_array($categoryDetails) && sizeof($categoryDetails) > 0){
            $cover = $categoryDetails['category_cover_image'];
            $categoryTitle = $categoryDetails['category_name'];

            if(isset($categoryDetails['facilities']) &&
             is_array($categoryDetails['facilities']) &&
             sizeof($categoryDetails['facilities']) > 0){
                 $facilities = $categoryDetails['facilities'];

                 foreach($facilities as $key => $facility){
                     $facility_title = $facility['facility_title'];
                     $image = $facility['image'];
                     $check_in_time = $facility['check_in_time'];
                     $check_out_time = $facility['check_out_time'];

                     $facilitiesListHtml .= ' <div class="row listingbox" style="padding:5px;">          
                                                <div class="col-md-2 col-sm-4 col-xs-4" style="padding: 0px 0px 0px 5px;background: url('.BASE_URL.'/assets/img/rooms/'.$image.') no-repeat;background-size: cover;min-height: 110px;">               
                                                </div>
                                                <div class="col-md-4 col-sm-8 col-xs-8" style="padding: 0px 0px 0px 2px;">
                                                    <div style="padding: 0px 8px;">                    
                                                        <h6>Hotel Sunotel</h6>
                                                        <p>
                                                            Check-in time: '.$check_in_time.'<br>
                                                            Check-out time: '.$check_out_time.'
                                                        </p>                    
                                                        <a href="<?php echo CONTACT_LINK; ?>" class="btn btn-xs btn-common" style="width:50%">Enquire now</a>
                                                        <p style="font-size:14px;">
                                                        4.4
                                                        <img src="'.BASE_URL.'/assets/img/star.png" alt="" style="height:12px;width:12px;">
                                                        <img src="'.BASE_URL.'/assets/img/star.png" alt="" style="height:12px;width:12px;">
                                                        <img src="'.BASE_URL.'/assets/img/star.png" alt="" style="height:12px;width:12px;">
                                                        <img src="'.BASE_URL.'/assets/img/star.png" alt="" style="height:12px;width:12px;">
                                                        <img src="'.BASE_URL.'/assets/img/star.png" alt="" style="height:12px;width:12px;">(376)
                                                    </p>
                                                    </div>
                                                </div>
                                            </div>';
                        $facilitiesListHtml .= '<br>';                    
                 }
             }
        }
  ?>
  
  
  <!-- Page Header Start -->
      <div class="page-header" style="background: url(<?php echo BASE_URL; ?>/assets/img/<?= $cover; ?>);">
        <div class="container">
          <div class="row">         
            <div class="col-md-12">
              <div class="breadcrumb-wrapper">
                <h2 class="product-title"><?= $categoryTitle ?></h2>
                <ol class="breadcrumb">
                  <li><a href="#"><i class="ti-home"></i> Home</a></li>
                  <li class="current"><?= $categoryTitle ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Page Header End --> 
<!-- Main container Start -->  
<div class="about section">
    <div class="container">      
           <?= $facilitiesListHtml ?>
    </div>
</div>
<!-- Main container End -->
