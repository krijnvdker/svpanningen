<?php
	/*	
	*	Goodlayers Player File
	*/	
	
	function gdlr_soccer_get_match_thumbnail($size = 'full'){
		$image_id = get_post_thumbnail_id();
	
		if( function_exists('gdlr_get_image') && !empty($image_id) ){
			return '<div class="gdlr-soccer-match-thumbnail">' . gdlr_get_image($image_id, $size, true) . '</div>';
		}
		return '';
	}	
	
	function gdlr_soccer_get_match_info($match_options = array(), $additional = ''){ 
		global $theme_option;
			
		if( !empty($match_options['date-of-match']) || !empty($match_options['location']) ){
			$ret  = '<span class="match-result-info-wrapper">';
			$ret .= $additional;
			if( !empty($match_options['date-of-match']) ){
				$date_format = $theme_option['date-format'];
				$match_time = empty($match_options['match-time'])? '00:00': $match_options['match-time'];
				$match_date = strtotime($match_options['date-of-match'] . ' ' . $match_time);		

				$ret .= '<span class="match-result-info">';
				$ret .= '<i class="icon-calendar"></i>';		
				if( !empty($match_options['match-time']) ){
					$date_format .= ' - H:i';
				}
				$ret .= date_i18n($date_format, $match_date);
				$ret .= '</span>'; // match-result-info
			}
			
			if( !empty($match_options['location']) ){
				$ret .= '<span class="match-result-info">';
				$ret .= '<i class="icon-location-arrow"></i>';
				$ret .= $match_options['location'];
				$ret .= '</span>'; // match-result-info
			}
			$ret .= '</span>'; // match-result-info-wrapper
		}
		return $ret;
	}	
	
	// add action to check for fixture result item
	add_action('gdlr_print_item_selector', 'gdlr_check_fixture_result_item', 10, 2);
	function gdlr_check_fixture_result_item( $type, $settings = array() ){
		if($type == 'fixture-result'){
			gdlr_print_fixture_result_item( $settings );
		}else if($type == 'upcoming-match'){
			gdlr_print_upcoming_match_item( $settings );
		}else if($type == 'recent-match'){
			gdlr_print_recent_match_item( $settings );
		}
	}	
	
	function gdlr_print_fixture_result_item( $settings ){
		$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

		global $gdlr_spaces;
		$margin = (!empty($settings['margin-bottom']) && 
			$settings['margin-bottom'] != $gdlr_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
		$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';

		$settings['style'] = empty($settings['style'])? '': $settings['style'];
		$settings['filter'] = empty($settings['filter'])? 'disable': $settings['filter'];
		$settings['year-filter'] = empty($settings['year-filter'])? 'disable': $settings['year-filter'];

		// query posts section
		$args = array('post_type' => 'fixture_and_result', 'suppress_filters' => false);
		$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
		$args['meta_key'] = 'gdlr-start-date';
		$args['meta_type'] = 'date';
		if( empty($settings['order']) || $settings['order'] == 'asc' ){ 
			$args['meta_compare'] = '>';
			$args['meta_value'] = date('Y-m-d');
			$args['order'] = 'asc';
		}else{
			$args['order'] = 'desc';
		}
		$args['orderby'] = 'meta_value';
		$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
		if( !empty($settings['category']) ){
			$args['tax_query'] = array(
				array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'result_category', 'field'=>'slug')
			);	
		}
		
		echo '<div class="fixture-result-item-wrapper" ' . $item_id . $margin_style . ' data-ajax="' . AJAX_URL . '" >'; 		
		echo gdlr_get_item_title($settings);

		// create the player filter
		if( $settings['filter'] == 'enable' || ($settings['year-filter'] == 'enable' && $settings['style'] == 'full') ){
			

			// ajax infomation
			if( $settings['filter'] == 'enable' ){
				echo '<div class="gdlr-ajax-info" data-num-fetch="' . $args['posts_per_page'] . '" data-pagination="' . $settings['pagination'] . '" data-year-filter="' . $settings['year-filter'] . '" '; 
				echo 'data-style="' . $settings['style'] . '" data-button-link="' . esc_attr($settings['button-link']) . '" data-button-text="' . esc_attr($settings['button-text']) . '" ';
				echo 'data-order="' . $args['order'] . '" data-ajax="' . admin_url('admin-ajax.php') . '" data-category="' . $settings['category'] . '" ></div>';
			}

			echo '<div class="fixture-result-item-filter">';
			if( $settings['filter'] == 'enable' ){

				// category filter
				if( empty($settings['category']) ){
					$parent = array('gdlr-all'=>__('All', 'gdlr-soccer'));
					$settings['category-id'] = '';
				}else{
					$term = get_term_by('slug', $settings['category'], 'result_category');
					$parent = array($settings['category']=>$term->name);
					$settings['category-id'] = $term->term_id;
				}
				
				// $filters = $parent + gdlr_get_term_list('result_category', $settings['category-id']);
				$filters = gdlr_get_term_list('result_category', $settings['category-id']);
				$filter_category = empty($_GET['result-filter'])? '': $_GET['result-filter']; 
				foreach($filters as $filter_id => $filter){
					$filter_id = ($filter_id == 'gdlr-all')? '': $filter_id;
					
					echo '<span class="gdlr-saperator">|</span>';
					if( empty($filter_category) ){
						$filter_category = 'gdlr-player-selected';
						$selected_category = $filter_id;
						echo '<a class="gdlr-title-font active" href="#" ';
					}else if($filter_category != 'gdlr-player-selected' && $filter_category == $filter_id){
						$selected_category = $filter_id;
						echo '<a class="gdlr-title-font active" href="#" ';
					}else{
						echo '<a class="gdlr-title-font" href="#" ';
					}
					echo 'data-category="' . $filter_id . '" >' . $filter . '</a>';
				}

				if( !empty($selected_category) ){
					$args['tax_query'] = array(
						array('terms'=>explode(',', $selected_category), 'taxonomy'=>'result_category', 'field'=>'slug')
					);	
				}		
			}

			$query = new WP_Query( $args );		

			if( ($settings['year-filter'] == 'enable' && $settings['style'] == 'full') ){
				$item_holder_class = 'with-year-filter';

				$years = array();
				while( $query->have_posts() ){ $query->the_post();
					$match_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-soccer-fixture-result-settings', true));
					$match_options = empty($match_val)? array(): json_decode($match_val, true);	
					$year = date_i18n('Y', strtotime($match_options['date-of-match']));
					
					if( !in_array($year, $years) ){
						$years[] = $year;
					}
				}
				
				echo '<div class="gdlr-soccer-combobox" >';
				echo '<select class="gdlr-soccer-fixture-result-year-filter  gdlr-title-font" >';
				echo '<option value="all" >' . esc_html__('All', 'gdlr-soccer') . '</option>';
				foreach( $years as $year ){
					echo '<option value="' . esc_attr($year) . '" >' . esc_attr($year) . '</option>';
				} 
				echo '</select>';
				echo '</div>';
				
				$query->rewind_posts();
				wp_reset_postdata();

			}
			echo '</div>';
		}else{
			$query = new WP_Query( $args );		
		}
		
		echo '<div class="fixture-result-item-holder ' . (empty($item_holder_class)? '': esc_attr($item_holder_class)) . '" >';
		if(empty($settings['style']) || $settings['style'] == 'full'){
			gdlr_print_result_by_month($query);
		}else{
			gdlr_print_small_result($query, $settings);
		}		
		echo '</div>';

		// create pagination
		if($settings['filter'] == 'enable' && $settings['pagination'] == 'enable'){
			echo gdlr_get_ajax_pagination($query->max_num_pages, $args['paged']);
		}else if($settings['pagination'] == 'enable'){
			echo gdlr_get_pagination($query->max_num_pages, $args['paged']);
		}	
		echo '</div>'; // fixture result item wrapper
	}
	
	// ajax function for player filter / pagination
	add_action('wp_ajax_gdlr_get_result_ajax', 'gdlr_get_result_ajax');
	add_action('wp_ajax_nopriv_gdlr_get_result_ajax', 'gdlr_get_result_ajax');
	function gdlr_get_result_ajax(){
		$settings = $_POST['args'];
		$settings['year-filter'] = empty($settings['year-filter'])? 'disable': $settings['year-filter'];

		// query posts section
		$args = array('post_type' => 'fixture_and_result', 'suppress_filters' => false);
		$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
		$args['meta_key'] = 'gdlr-start-date';
		$args['orderby'] = 'meta_value';
		$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
		$args['paged'] = (empty($settings['paged']))? 1: $settings['paged'];
		if( !empty($settings['category']) ){
			$args['tax_query'] = array();
			if( !empty($settings['category']) ){
				array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'result_category', 'field'=>'slug'));
			}			
		}			
		$query = new WP_Query( $args );	

		if( ($settings['year-filter'] == 'enable' && $settings['style'] == 'full') ){
			$item_holder_class = 'with-year-filter';
		}
		
		echo '<div class="fixture-result-item-holder ' . (empty($item_holder_class)? '': esc_attr($item_holder_class)) . '" >';
		if(empty($settings['style']) || $settings['style'] == 'full'){
			gdlr_print_result_by_month($query);
		}else{
			gdlr_print_small_result($query, $settings);
		}	
		echo '</div>';
		
		// pagination section
		if($settings['pagination'] == 'enable'){
			echo gdlr_get_ajax_pagination($query->max_num_pages, $args['paged']);
		}
		die("");
	}	
	
	function gdlr_print_result_by_month($query){
		$year = ''; $month = ''; $first = true; $count = 0;
	
		echo '<div class="gdlr-result-by-month-wrapper gdlr-item">';
		while( $query->have_posts() ){ $query->the_post();
			$match_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-soccer-fixture-result-settings', true));
			$match_options = empty($match_val)? array(): json_decode($match_val, true);	
			
			$match_time = empty($match_options['match-time'])? '00:00': $match_options['match-time'];
			$match_date = strtotime($match_options['date-of-match'] . ' ' . $match_time);
			$match_year = date_i18n('Y', $match_date);
			if( $year != $match_year ){
				if( !empty($year) ){ echo '</div>'; }

				$year = $match_year;
				echo '<div class="gdlr-result-by-month-year-wrap" data-year="' . esc_attr($year) . '" >';
			}

			if( $month != date_i18n('F Y', $match_date) ){
				$month = date_i18n('F Y', $match_date); $count = 0;
				echo '<h4 class="gdlr-result-by-month-header ';
				echo ($first)? 'gdlr-first': '';
				echo '">' . $month . '</h4>';
				
				$first = false;
			}
				
			echo '<div class="result-in-month ';
			echo ($count % 2 == 0)? 'even': 'odd';
			echo '">';	
			echo '<div class="gdlr-result-date">' . date_i18n('d D - H:i', $match_date) . '</div>';

			echo '<div class="gdlr-result-match-team-wrapper">';	
			echo '<span class="gdlr-result-match-team gdlr-left">' . (empty($match_options['home-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['home-flag']) . '</span>') . $match_options['home'] . '</span>';
			if( $match_options['home-goal'] === "" && $match_options['away-goal'] === "" ){
				echo '<span class="gdlr-result-match-versus">' . __('VS', 'gdlr-soccer') . '</span>';
			}else{
				echo '<span class="gdlr-result-match-score">' . $match_options['home-goal'] . '</span>';
				echo '<span class="gdlr-result-match-separator">-</span>';
				echo '<span class="gdlr-result-match-score">' . $match_options['away-goal'] . '</span>';
			}
			echo '<span class="gdlr-result-match-team gdlr-right">' . $match_options['away'] . (empty($match_options['away-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['away-flag']) . '</span>') . '</span>';

			echo '</div>';
			
			if( $match_date < current_time('timestamp')){
				echo '<a class="gdlr-result-read-more" href="' . get_permalink() . '" >' . __('Match Report', 'gdlr-soccer') . '</a>';
			}else if( !empty($match_options['show-match-detail']) && $match_options['show-match-detail'] == 'enable' ){
				echo '<a class="gdlr-result-read-more" href="' . get_permalink() . '" >' . __('Match Detail', 'gdlr-soccer') . '</a>';
			}
			echo '<div class="clear"></div>';
			echo '</div>'; // result-in-month
			$count++;
		}	
		echo '</div>'; // gdlr-result-by-month-year-wrap
		echo '</div>'; // gdlr-result-by-month-wrapper
		wp_reset_postdata();
	}
	
	function gdlr_print_small_result($query, $settings){
		$first = true; $count = 0;
	
		echo '<div class="gdlr-small-result-wrapper gdlr-item">';
		while( $query->have_posts() ){ $query->the_post();
			$match_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-soccer-fixture-result-settings', true));
			$match_options = empty($match_val)? array(): json_decode($match_val, true);	

			echo '<div class="small-result-item ';
			echo ($count % 2 == 0)? 'even': 'odd';
			echo '">';	
	
			echo '<span class="gdlr-result-match-team gdlr-left">';
			echo (empty($match_options['home-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['home-flag']) . '</span>');
			echo $match_options['home']; 
			if( $match_options['home-goal'] !== "" && $match_options['away-goal'] !== "" ){
				echo '<span class="gdlr-result-match-score"> ' . $match_options['home-goal'] . ' </span>';
			}
			echo '</span>';
			echo '<span class="gdlr-result-match-versus">' . __('VS', 'gdlr-soccer') . '</span>';
			echo '<span class="gdlr-result-match-team gdlr-right">';
			if( $match_options['home-goal'] !== "" && $match_options['away-goal'] !== "" ){
				echo '<span class="gdlr-result-match-score"> ' . $match_options['away-goal'] . ' </span>';
			}
			echo $match_options['away'];
			echo (empty($match_options['away-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['away-flag']) . '</span>');
			echo '</span>';
			echo '</div>'; // small-result
			$count++;
		}	
		
		if( !empty($settings['button-link']) ){
			echo '<a class="gdlr-full-result-link gdlr-button with-border" href="' . $settings['button-link'] . '">' . $settings['button-text'] . '</a>';
		}		
		echo '</div>';
		wp_reset_postdata();
	}	
	
	function gdlr_print_upcoming_match_item( $settings ){
		$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

		global $gdlr_spaces;
		$margin = (!empty($settings['margin-bottom']) && $settings['margin-bottom'] != $gdlr_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
		if( !empty($settings['image-id']) ){
			$image_url = is_numeric($settings['image-id'])? wp_get_attachment_url($settings['image-id']): $settings['image-id'];
			$margin .= ' background-image: url(\'' . $image_url . '\'); ';
		}
		$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';

		$current_date = date_i18n('Y-m-d H:i', current_time('timestamp'));

		// query posts section
		$args = array('post_type' => 'fixture_and_result', 'suppress_filters' => false);
		$args['posts_per_page'] = 1;
		$args['meta_key'] = 'gdlr-start-date';
		$args['orderby'] = 'meta_value';
		$args['order'] = 'asc';
		$args['paged'] = 1;
		$args['meta_query'] = array(
			array(
				'key' => 'gdlr-start-date',
				'value' => $current_date,
				'compare' => '>',
				'type' => 'DATE'
			)
		);
		if( !empty($settings['category']) ){
			$args['tax_query'] = array();
			if( !empty($settings['category']) ){
				array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'result_category', 'field'=>'slug'));
			}			
		}			
		$query = new WP_Query( $args );	
		
		while( $query->have_posts() ){ $query->the_post();
			$match_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-soccer-fixture-result-settings', true));
			$match_options = empty($match_val)? array(): json_decode($match_val, true);	
		
			echo '<div class="upcoming-match-item-wrapper gdlr-item" ' . $item_id . $margin_style . ' >';
			echo '<div class="upcoming-match-overlay"></div>';
			
			echo '<div class="gdlr-upcoming-match-team-wrapper">';	
			if( !empty($settings['title']) ){
				echo '<div class="gdlr-upcoming-match-item-title">' . $settings['title'] . '</div>';
			}

			echo '<span class="gdlr-upcoming-match-team gdlr-left">';
			echo (empty($match_options['home-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['home-flag']) . '</span>');
			echo $match_options['home'] . '</span>';
			echo '<span class="gdlr-upcoming-match-versus">' . __('VS', 'gdlr-soccer') . '</span>';
			echo '<span class="gdlr-upcoming-match-team gdlr-right">' . $match_options['away'];
			echo (empty($match_options['away-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['away-flag']) . '</span>');
			echo '</span>';
			echo '</div>';	// upcoming-match-team
			
			echo gdlr_soccer_get_match_info($match_options, '<span class="upcoming-match-info-overlay"></span>');
			echo '</div>';
		}
		wp_reset_postdata();
	}	

	function gdlr_print_recent_match_item( $settings ){
		$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

		global $gdlr_spaces;
		$margin = (!empty($settings['margin-bottom']) && $settings['margin-bottom'] != $gdlr_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
		$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';

		$current_date = date_i18n('Y-m-d H:i', current_time('timestamp'));

		// query posts section
		$args = array('post_type' => 'fixture_and_result', 'suppress_filters' => false);
		$args['posts_per_page'] = 1;
		$args['meta_key'] = 'gdlr-start-date';
		$args['orderby'] = 'meta_value';
		$args['order'] = 'desc';
		$args['paged'] = 1;
		$args['meta_query'] = array(
			array(
				'key' => 'gdlr-start-date',
				'value' => $current_date,
				'compare' => '<=',
				'type' => 'DATE'
			)
		);
		if( !empty($settings['category']) ){
			$args['tax_query'] = array();
			if( !empty($settings['category']) ){
				array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'result_category', 'field'=>'slug'));
			}			
		}			
		$query = new WP_Query( $args );	
		
		while( $query->have_posts() ){ $query->the_post();
			$match_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-soccer-fixture-result-settings', true));
			$match_options = empty($match_val)? array(): json_decode($match_val, true);	
		
			echo '<div class="recent-match-item-wrapper gdlr-item" ' . $item_id . $margin_style . ' >';
			
			echo '<div class="gdlr-recent-match-team-wrapper">';	
			if( !empty($settings['title']) ){
				echo '<div class="gdlr-recent-match-item-title">' . $settings['title'] . '</div>';
			}

			echo '<span class="gdlr-recent-match-team gdlr-left">';
			echo $match_options['home'];
			echo (empty($match_options['home-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['home-flag']) . '</span>');
			echo '</span>';
			if( $match_options['home-goal'] === "" && $match_options['away-goal'] === "" ){
				echo '<span class="gdlr-recent-match-versus gdlr-title-font">' . __('VS', 'gdlr-soccer') . '</span>';
			}else{
				echo '<span class="gdlr-recent-match-score gdlr-title-font">' . $match_options['home-goal'] . '</span>';
				echo '<span class="gdlr-recent-match-separator gdlr-title-font">-</span>';
				echo '<span class="gdlr-recent-match-score gdlr-title-font">' . $match_options['away-goal'] . '</span>';
			}
			echo '<span class="gdlr-recent-match-team gdlr-right">';
			echo (empty($match_options['away-flag'])? '': '<span class="gdlr-team-flag">' . gdlr_get_image($match_options['away-flag']) . '</span>');
			echo $match_options['away'];
			echo '</span>';
			echo '</div>';	// recent-match-team
			
			echo gdlr_soccer_get_match_info($match_options, '');

			echo '<a class="gdlr-recent-match-read-more" href="' . get_permalink() . '" >' . __('View Match Report', 'gdlr-soccer') . '</a>';
			echo '</div>';
		}
		wp_reset_postdata();
	}

?>