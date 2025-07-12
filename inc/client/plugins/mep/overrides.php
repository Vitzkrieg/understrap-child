<?php

function mep_date_in_default_theme($event_id, $title='yes')
{ 
    $event_meta                 = get_post_custom($event_id); 
    $start_datetime             = get_post_meta($event_id, 'event_start_datetime', true) ? get_post_meta($event_id, 'event_start_datetime', true) : ''; //$event_meta['event_start_datetime'][0];
    $start_date                 = get_post_meta($event_id, 'event_start_date', true) ? get_post_meta($event_id, 'event_start_date', true) : ''; //$event_meta['event_start_date'][0];
    $start_time                 = get_post_meta($event_id, 'event_start_time', true) ? get_post_meta($event_id, 'event_start_time', true) : ''; //$event_meta['event_start_time'][0];
    $end_datetime               = get_post_meta($event_id, 'event_end_datetime', true) ? get_post_meta($event_id, 'event_end_datetime', true) : ''; //$event_meta['event_end_datetime'][0];
    $end_date                   = get_post_meta($event_id, 'event_end_date', true) ? get_post_meta($event_id, 'event_end_date', true) : ''; //$event_meta['event_end_date'][0];
    $end_time                   = get_post_meta($event_id, 'event_end_time', true) ? get_post_meta($event_id, 'event_end_time', true) : ''; //$event_meta['event_end_time'][0];
    $cn                         = 1;
    // $more_date               = array(get_post_meta($event_id, 'event_start_date', true) . ' ' . get_post_meta($event_id, 'event_start_time', true));
    $recurring                  = get_post_meta($event_id, 'mep_enable_recurring', true) ? get_post_meta($event_id, 'mep_enable_recurring', true) : 'no';
    $mep_show_upcoming_event    = get_post_meta($event_id, 'mep_show_upcoming_event', true) ? get_post_meta($event_id, 'mep_show_upcoming_event', true) : 'no';               
    $_more_date                 = get_post_meta($event_id, 'mep_event_more_date', true) ? maybe_unserialize(get_post_meta($event_id, 'mep_event_more_date', true)) : array();            
    $more_date                  = apply_filters('mep_event_date_more_date_array',$_more_date,$event_id);
    $show_end_date              = get_post_meta($event_id, 'mep_show_end_datetime', true) ? get_post_meta($event_id, 'mep_show_end_datetime', true) : 'yes';
    $end_date_display_status    = apply_filters('mep_event_datetime_status',$show_end_date,$event_id);  

  
    $dashpage = get_query_var('ihkdash');
    $is_ihkdash = !empty($dashpage);
    $isDashEvent = $dashpage == 'ihk-events';

    $more_date_size = sizeof($more_date);
    $more_date_count = 0;
    $more_date_format = ($isDashEvent) ? 'Y-m-d' : 'Y-m-d H:i';
    $current_timedate = strtotime(current_time('Y-m-d H:i'));


    if($title == 'yes'){
        require(mep_template_file_path('single/date_list_title.php')); 
    }
    if ($more_date_size > 2) {
        echo '<ul id="mep_event_date_sch">';
    } else {
        echo '<ul>';
    }

    if ($recurring == 'yes') {
        if ($current_timedate < strtotime($start_datetime)) {
            require(mep_template_file_path('single/date_list.php')); 
        }
        foreach ($more_date as $_more_date) {
            $start_date         = $_more_date['event_more_start_date'];
            $end_date           = $_more_date['event_more_end_date'];
            $start_datetime     = $_more_date['event_more_start_date'] . ' ' . $_more_date['event_more_start_time'];
            $end_datetime       = $_more_date['event_more_end_date'] . ' ' . $_more_date['event_more_end_time'];
            $more_date_count++;

            if ($current_timedate < strtotime($_more_date['event_more_start_date'] . ' ' . $_more_date['event_more_start_time'])) {
                if ($mep_show_upcoming_event == 'yes') {
                    $cnt = 1;
                } else {
                    $cnt = $cn;
                }
                if ($cn == $cnt) {
                    require(mep_template_file_path('single/date_list.php')); 
                    $cn++;
                }
            }
        }
    }elseif ($recurring == 'everyday') { 
        do_action('mep_event_everyday_date_list_display',$event_id);
    }else {
        if (is_array($more_date) && $more_date_size > 0) {
            require(mep_template_file_path('single/date_list.php')); 
            foreach ($more_date as $_more_date) {
                $start_date         = $_more_date['event_more_start_date'];
                $end_date           = $_more_date['event_more_end_date'];
                $start_datetime     = $_more_date['event_more_start_date'] . ' ' . $_more_date['event_more_start_time'];
                $end_datetime       = $_more_date['event_more_end_date'] . ' ' . $_more_date['event_more_end_time'];
                $more_date_count++;
                require(mep_template_file_path('single/date_list.php')); 
            }
        } else {
            require(mep_template_file_path('single/date_list.php')); 
        }
    }
    echo '</ul>';
    if ($more_date_size > $more_date_count) {
        ?>
        <p id="mep_single_view_all_date" class="mep-tem3-title-sec mep_single_date_btn"><i class="fa fa-plus"></i><?php echo mep_get_option('mep_event_view_more_date_btn_text', 'label_setting_sec', __('View More Date', 'mage-eventpress')); ?></p>
        <p id="mep_single_hide_all_date" class="mep-tem3-title-sec mep_single_date_btn"><i class="fa fa-minus"></i><?php echo mep_get_option('mep_event_hide_date_list_btn_text', 'label_setting_sec', __('Hide Date Lists', 'mage-eventpress')); ?></p>
        <?php
    }
}

// don't show end time
add_action('mep_event_datetime_status', 'ihk_event_datetime_status');
function ihk_event_datetime_status($show_end_date) {
   return 'no';
}



add_action('ihk_event_list_footer', 'ihk_event_list_footer');
function ihk_event_list_footer($params) {
    ob_start();

    extract($params);

    ?>
    <ul class="mep_list_ihk_details">
        <?php
        if ($hide_org_list == 'no') {
            if (sizeof($author_terms) > 0) {
                ?>
                <li class="mep_list_org_name">
                    <div class="evl-ico"><i class="<?php echo esc_attr($event_organizer_icon); ?>"></i></div>
                    <div class="evl-cc">
                        <h5>
                            <?php echo mep_get_option('mep_organized_by_text', 'label_setting_sec', __('Organized By:', 'mage-eventpress')); ?>
                        </h5>
                        <h6><?php echo esc_html($author_terms[0]->name); ?></h6>
                    </div>
                </li>
            <?php }
        }
        if ($event_type == 'local') {
            if ($hide_location_list == 'no') { ?>

                <li class="mep_list_location_name">
                    <div class="evl-ico">
                        <i class="<?php echo esc_attr($event_location_icon); ?>"></i>
                    </div>
                    <div class="evl-cc">
                        <h5>
                            <?php echo mep_get_option('mep_location_text', 'label_setting_sec', __('Location:', 'mage-eventpress')); ?>
                        </h5>
                        <h6><?php mep_get_event_city($event_id); ?></h6>
                    </div>
                </li>
            <?php }
        }
        if ($hide_time_list == 'no' && $recurring == 'no') {
            do_action('mep_event_list_date_li', $event_id, 'grid');
        } elseif ($hide_time_list == 'no' && $recurring != 'no') {
            do_action('mep_event_list_upcoming_date_li', $event_id);
        } ?>
    </ul>
    <?php

    $content = ob_get_clean();
    echo html_entity_decode( $content );
}


function malina_add_meta_viewport(){
    if( get_theme_mod('malina_responsiveness', true) ) {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">';
    }
}
add_action('malina_header_meta', 'malina_add_meta_viewport');



if( !function_exists('malina_single_post_format_content') ){
	function malina_single_post_format_content($echo = true) {
		$post_format = get_post_format();
        $post_type = get_post_type();
		global $post;
		global $_wp_additional_image_sizes;
		$img_size = 'large';
		if( rwmb_get_value('malina_post_layout') == 'fullwidth' || rwmb_get_value('malina_post_layout') == 'fullwidth-alt' || rwmb_get_value('malina_post_layout') == 'fullwidth-alt2' || get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth' || get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth-alt' || get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth-alt2' ) {
			$img_size = 'malina-fullwidth-slider';
		} elseif( rwmb_get_value('malina_post_layout') == 'wide' || rwmb_get_value('malina_post_layout') == 'wide2' || get_theme_mod('malina_single_post_layout', 'standard') == 'wide' || get_theme_mod('malina_single_post_layout', 'standard') == 'wide2' ) {
			$img_size = 'large';
		} elseif( rwmb_get_value('malina_post_layout') == 'sideimage' || get_theme_mod('malina_single_post_layout', 'standard') == 'sideimage' ){
			$img_size = 'malina-masonry';
		} else {
			if( rwmb_get_value('malina_post_sidebar') == 'none' || ( rwmb_get_value('malina_post_sidebar') == 'default' && get_theme_mod('malina_single_post_sidebar', 'sidebar-right') == 'none' ) ) {
				$img_size = 'large';
			} else {
				$img_size = 'post-thumbnail';
			}
		}
		$width  = get_option( "{$img_size}_size_w" );
		$height = get_option( "{$img_size}_size_h" );
		if( !$width || !$height ){
			$width = $_wp_additional_image_sizes["{$img_size}"]['width'];
			$height = $_wp_additional_image_sizes["{$img_size}"]['height'];
		}
		if( !$width || !$height || $img_size == 'malina-masonry'){
			$proportions = '56.25';
		} else {
			$proportions = ($height/$width) * 100;
		}
		$out = '';
		switch ($post_format) {
			case 'gallery':
				$out = malina_single_post_gallery(false, false);
				break;
			case 'video':
				$media = rwmb_meta('malina_post_format_video', $post->ID);
				$url = rwmb_get_value( 'malina_post_format_video' );

				if( $media && $url != '' ){
					$out = '<div class="video-container">'.$media.'</div>';
				}
				break;
			case 'audio':
				$media = rwmb_get_value('malina_post_format_audio');
				$url = rwmb_get_value( 'malina_post_format_audio' );
				$media_sites = array('soundcloud', 'mixcloud', 'reverbnation', 'spotify');
				$check = false;
				global $wp_embed;
				if( $media && $url != '' ){
					foreach ($media_sites as $site) {
						if( strpos( $media, $site ) ){
							$check = true;
						}
					}
					if($check){
						$out = '<div class="video-container" style="padding-bottom:'.$proportions.'%">'.$wp_embed->run_shortcode("[embed]".$media."[/embed]").'</div>';
					} else {
						if( has_post_thumbnail() ){
							$out = '<div class="audio-block">';
							$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size, array('fetchpriority' => 'high', 'loading' => 'eager')).'</a></figure>';
							$out .= '<div class="audio-overlay">'.do_shortcode('[audio src="'.$media.'" loop="off" autoplay="0" preload="none"]').'</div>';
							$out .= '</div>';
						} else {
							$out = do_shortcode('[audio src="'.$media.'" loop="off" autoplay="0" preload="none"]');
						}
					}
					
				}
				break;
			case 'link':
				$out = malina_single_post_link(false, false);
				break;
			case 'quote':
				$text = rwmb_get_value( 'malina_post_format_quote_text' );
				if ( $text != '' ){
					$cite = rwmb_get_value( 'malina_post_format_quote_cite' );
					$text_color = rwmb_get_value( 'malina_post_format_quote_text_color' );
					$bg_color = rwmb_get_value( 'malina_post_format_quote_bg_color' );
					$style = $style_cite = '';
					if($text_color){
						$style .= $style_cite = 'color:'.$text_color.';';
					}
					if($bg_color) {
						$style .= 'background-color:'.$bg_color.';';
					}
					$out = '<blockquote style="'.$style.'">';
					$out .= '<p class="mb0">'.esc_html($text).'</p>';
					if($cite){
						$out .='<cite style="'.$style_cite.'">'.esc_html($cite).'</cite>';
					}
					$out .= '</blockquote>';
					
				}
				break;
			case 'image':
				$out = '';
				break;
			default:
				$check_media = rwmb_get_value('malina_post_format_embed_replace');
				$media = rwmb_get_value( 'malina_post_format_embed' );
				$url = rwmb_get_value( 'malina_post_format_embed' );
				if( $check_media && $media && $url != ''){
					$proportions_supports = array('cloudup','collegehumor', 'funnyordie', 'flickr', 'youtube', 'dailymotion', 'vimeo', 'ted', 'videopress', 'vine', 'wordpress.tv');
					$check = false;
					foreach ($proportions_supports as $site) {
						if( strpos( $media, $site ) ){
							$check = true;
						}
					}
					if($media && $url != '') {
						if($check){
							$out = '<div class="video-container">'.$media.'</div>';
						} else {
							$out = '<div class="iframe-container">'.$media.'</div>';
						}
					}
				} elseif( has_post_thumbnail() && $post_type != "bulletins" ){
					$out = '<figure class="post-img"><img src="'.get_the_post_thumbnail_url($post->ID, $img_size).'" alt="'.get_the_title().'" fetchpriority="high" loading="eager")></figure>';
				}
				break;
		}
		if( $echo ){
			echo ''.$out;
		} else {
			return $out;
		}
	}
}