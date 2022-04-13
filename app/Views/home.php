<?php

	$categories_html = '';

	if(isset($categories) && is_array($categories) && sizeof($categories) > 0){
		foreach($categories as $key => $category){
			$title = $category['category_title'];
			$id = $category['category_id'];
			$link = LISTING_LINK;
			$image = FRONT_ASSETS_FOLDER.'img/home_cat_1.jpg';

			$categories_html .= '<div class="col-lg-4 col-sm-6">
									<a href="'.$link.'" class="grid_item">
										<figure>
											<img src="'.$image.'" alt="">
											<div class="info">												
												<h3>'.$title.'</h3>
											</div>
										</figure>
									</a>
								</div>';
		}
	}
?>


<div class="bg_color_1">
	<div class="container margin_80_55">
		<div class="main_title_2">
			<span><em></em></span>
			<h2>Popular Categories</h2>
			<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
		</div>
		<div class="row">
			<?= $categories_html ?>				
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->	
</div>
<!-- /bg_color_1 -->

	

