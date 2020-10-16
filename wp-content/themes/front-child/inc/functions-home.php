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
				$categories[] = get_the_terms($value, 'job_listing_category');
			}
		}
		if (is_array($categories)) {
			foreach ($categories as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key2 => $value2) {
						$three_categories[] = array(
															'term_id' => $value2->term_id,
															'name' => $value2->name,
														);
					}
				}
			}
		}
		if (is_array($three_categories)) {
			$three_categories = array_map("unserialize", array_unique(array_map("serialize", $three_categories)));
			foreach ($three_categories as $key => $value) {
				++$i;
				if ($i <= 3) {
					$posts[] = get_posts(array(
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
		$html .= '<div class="wp-block-fgb-jobs container space-2 space-md-3">';
			$html .= '<div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">';
				$html .= '<h2 class="h3 font-weight-medium">'.$title.'</h2>';
				$html .= '<p>'.$sub_title.'</p>';
			$html .= '</div>';
			$html .= '<div class="row">';
				foreach ($three_categories as $key => $value) {
					$html .= '<div class="col-md-4">';
						for ($i = 0; $i <= 0; $i++) {
							$html .= '<div class="col-12 text-center">';
								$html .= $value['name'];
							$html .= '</div>';
						}
					$html .= '</div>';
				}
			$html .= '</div>';
			$html .= '<div class="row">';
				foreach ($posts as $key => $value) {
					$job_meta = $company_id = $company_meta = $job = $location = $company = $logo = null;
					$html .= '<div class="col-md-4">';
						for ($i = 0; $i <= 2; $i++) {
							$job_meta = get_post_meta($value[$i]->ID);
							$company_id = $job_meta['_company_id'][0];
							$company_meta = get_post_meta($company_id);
							$job = $job_meta['_job_title'][0];	
							$location = $job_meta['_job_location'][0];
							var_dump($company_id);
							$company = get_post($company_id)->post_title;
							$logo = $company_meta['_company_logo'][0];
							if (empty($logo)) {
								$logo = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
							}
							if (!empty($job_meta)) {
								$html .= '<div '.cosmos_job_listing_class('list-grid card card-frame transition-3d-hover mw-100 mb-3 p-0',$value[$i]->ID).'>';
									$html .= '<a href="'.$i.'" class="card-body p-3">';
										$html .= '<div class="media">';
											$html .= '<div class="u-avatar position-relative">';
												$html .= '<img class="img-fluid rounded" src="'.$logo.'" alt="'.$value[$i]->post_title.' Logo" loading="lazy">';
											$html .= '</div>';
											$html .= '<div class="media-body px-4">';
												$html .= '<h4 class="h6 text-dark mb-1">'.$job.'</h4>';
												$html .= '<small class="d-block text-muted">'.$location.'</small>';
												if (!is_null($company)) {
													$html .= '<small class="d-block text-muted">'.$company.'</small>';
												}
											$html .= '</div>';
										$html .= '</div>';
									$html .= '</a>';
								$html .= '</div>';
							}
						}
					$html .= '</div>';
				}			
			$html .= '</div>';
// </div></div></a></div>

				// foreach ($posts as $key => $value) {
				// 	foreach ($value as $key2 => $value2) {
				// 		++$ii;
				// 		$job_terms = get_the_terms($value2->ID, 'job_listing_category');
				// 		$meta = get_post_meta($value2->ID);
				// 		$company_id = get_post_meta($value2->ID, '_company_id');
				// 		$location = $meta['_job_location'][0];
				// 		$company = get_post($company_id[0]);
				// 		foreach ($job_terms as $key3 => $value3) {
				// 			if ($value3->name == $key) {
				// 				if (!empty(get_post_meta($company_id[0], '_company_logo'))) {
				// 					$image = get_post_meta($company_id[0], '_company_logo')[0];
				// 				}else{
				// 					$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
				// 				}
				// 				if ($i % $number_of_categories == 0) {
				// 					$html .= '<div class="col-12 col-md-4"><h3 class="h5 text-center">'.$key.'</h3>';
				// 				}
				// 				if ($i % $number_of_categories == 0) {
				// 					$html .= '<ul class="job_listings cosmos-job-listings-home row d-lg-flex list-unstyled mb-0 list-grid-view">';
				// 				}
				// 					$html .= '<li '.cosmos_job_listing_class(null,$value2->ID).'>';
				// 				   	$html .= '<div class="list-grid card card-frame transition-3d-hover h-100 mw-100 mt-0 p-0">';
				// 							$html .= '<a href="'.get_the_permalink($value2->ID).'" class="card-body p-3">';
				// 								$html .= '<div class="media">';
				// 									$html .= '<div class="u-avatar position-relative">';
				// 										if (isset($image)) {
				// 											$html .= '<img class="img-fluid rounded" src="'.$image.'" alt="'.$value2->post_title.' logo" loading="lazy">';
				// 										}
				// 									$html .= '</div>';
				// 									$html .= '<div class="media-body px-4">';
				// 										$html .= '<h4 class="h6 text-dark mb-1">'.$value2->post_title.'</h4>';
				// 										$html .= '<small class="d-block text-muted">'.$location.'</small>';
				// 										$html .= '<small class="d-block text-muted">'.$company->post_title.'</small>';
				// 									$html .= '</div>';
				// 								$html .= '</div>';
				// 							$html .= '</a>';
				// 						$html .= '</div>';
				// 					$html .= '</li>';
				// 				if ($ii % $number_of_categories == 0) {
				// 					$html .= '</ul>';
				// 				}
				// 				if ($ii % $number_of_categories == 0) {
				// 					$html .= '</div>';
				// 				}
				// 				++$i;
				// 			}
				// 		}
				// 	}
				// }					
			$html .= '</div>';
		$html .= '</div>';
	  return $html;
	}