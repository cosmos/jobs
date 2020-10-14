<?php
	// Creates the shortcode for the home page job listing grid
	add_shortcode('cosmos_jobs_grid', 'cosmos_jobs_grid'); // [cosmos_jobs_grid title="" sub_title=""]

	add_action('init','cosmos_jobs_grid');
	function cosmos_jobs_grid($atts = array() ) {
	  // default parameters
	  extract(shortcode_atts(array(
	   'title' 											=> 'Projects hiring now',
	   'sub_title'									=> 'We’ve got more than 7 thousand of \'em—so you\'ve got plenty of options. Search your next job now.',
	   'number_of_jobs_per_category'=> 3,
	   'load_more'									=> true,
	   'number_of_categories'				=> 3, 
	  ), $atts));

		$html =  null;
		$i = $ii = 0;
		$args = array(
			'post_type'									=> 'job_listing',
			'orderby'										=> 'date',
			'order'											=> 'DESC',
			'numberposts' 							=> -1,
		);
	  $jobs = get_posts($args);
	  if (is_array($jobs)) {
		  foreach ($jobs as $key => $value) {
		  	$job_ids[] = $value->ID;
		  }
		}
		if (is_array($job_ids)) {
			foreach ($job_ids as $key => $value) {
				$categories1[] = get_the_terms($value, 'job_listing_category');
			}
		}
		if (is_array($categories1)) {
			foreach ($categories1 as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						$categories2[] = array(
															'term_id' => $value2->term_id,
															'name' => $value2->name,
														);
					}
				}
			}
		}
		//var_dump(array_unique(array_map("serialize", $categories2)));
		// var_dump($categories2);
		if (is_array($categories2)) {
			$categories2 = array_map("unserialize", array_unique(array_map("serialize", $categories2)));
		  // var_dump($categories2);
			foreach ($categories2 as $key => $value) {
				// var_dump($value);
				++$i;
				if ($i <= 3) {
					$posts[$value['name']] = get_posts(array(
					  'post_type' 							=> 'job_listing',
					  'post_status' 						=> 'publish',
					  'numberposts' 						=> 3,
					  'orderby'									=> 'date',
						'order'										=> 'DESC',
					  'tax_query' 							=> array(
		          array(
					      'taxonomy' 						=> 'job_listing_category',
					      'terms' 							=> $value['term_id'],
					      'field' 							=> 'term_id',
					    ),
					  ),
					));
				}
			}
		}

		// echo '<pre>';
		// // var_dump($categories2);
		// // var_dump($posts);
		// echo '</pre>';
		$i = $ii = 0;
		$html .= '<div id="cgb-jobs-i08oonx55" class="wp-block-fgb-jobs container space-2 space-md-3">';
			$html .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
				$html .= '<h2 class="text-primary"><span class="font-weight-medium"><span style="color:#313131" class="has-inline-color">'.$title.'</span></span></h2>';
				$html .= '<p>'.$sub_title.'</p>';
			$html .= '</div>';
			$html .= '<div class="row job_listings is_filtered columns-3" data-location="" data-keywords="" data-show_filters="false" data-show_pagination="false" data-per_page="9" data-orderby="date" data-order="DESC" data-categories="" data-view="list-grid" data-columns="3">';
				foreach ($posts as $key => $value) {
					foreach ($value as $key2 => $value2) {
						++$ii;
						// echo '<pre>';
						// var_dump(get_the_terms($value2->ID, 'job_listing_category'));
						// echo '</pre>';
						$meta = get_post_meta($value2->ID);
						$location = $meta['_job_location'][0];
						if (!empty($meta['_thumbnail_id'])) {
							$image = get_post_meta($meta['_thumbnail_id'][0],'_wp_attached_file')[0];
						}
						if ($i % $number_of_categories == 0) {
							$html .= '<div class="col-12 col-md-4"><h3 class="h5 text-center">'.$key.'</h3>';
						}
						if ($i % $number_of_categories == 0) {
							$html .= '<ul class="job_listings cosmos-job-listings-home row d-lg-flex list-unstyled mb-0 list-grid-view">';
						}
							$html .= '<li '.cosmos_job_listing_class(null,$value2->ID).'>';
						   	$html .= '<div class="list-grid card card-frame transition-3d-hover h-100 mw-100 mt-0 p-0">';
									$html .= '<a href="'.get_the_permalink($value2->ID).'" class="card-body p-3">';
										$html .= '<div class="media">';
											$html .= '<div class="u-avatar position-relative">';
												if (isset($image)) {
													$html .= '<img width="150" height="150" src="'.wp_upload_dir()['baseurl'].'/'.$image.'" alt="'.$value2->post_title.' logo" loading="lazy">';
												}
											$html .= '</div>';
											$html .= '<div class="media-body px-4">';
												$html .= '<h4 class="h6 text-dark mb-1">'.$key.'-'.$value2->post_title.'</h4>';
												$html .= '<small class="d-block text-muted">'.$location.'</small>';
											$html .= '</div>';
										$html .= '</div>';
									$html .= '</a>';
								$html .= '</div>';
							$html .= '</li>';
						if ($ii % $number_of_categories == 0) {
							$html .= '</ul>';
						}
						if ($ii % $number_of_categories == 0) {
							$html .= '</div>';
						}
						++$i;
					}
				}					
			$html .= '</div>';
		$html .= '</div>';
	  return $html;
	}




