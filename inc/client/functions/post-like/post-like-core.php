<?php

remove_action('wp_enqueue_scripts', 'post_like_scripts');
remove_action('wp_ajax_nopriv_post-like', 'post_like');
remove_action('wp_ajax_post-like', 'post_like');

add_action('wp_enqueue_scripts', 'ihk_post_like_scripts');
add_action('wp_ajax_nopriv_post-like', 'ihk_post_like');
add_action('wp_ajax_post-like', 'ihk_post_like');

function ihk_get_post_like_icons() {
	return array(
		'loved' => 'fa-heart',
		'completed' => 'fa-bookmark',
		'listed' => 'fa-rectangle-list',
	);
}

function ihk_post_like_scripts(){
	wp_register_script('ihk_like_post', trailingslashit( IHK_URL ).'inc/functions/post-like/post-like.js', array('jquery'), '2.1', TRUE );
	wp_localize_script('ihk_like_post', 'ihk_like_post', array_merge(array(
			'url' => admin_url('admin-ajax.php'),
		), 
		ihk_get_post_like_labels()
	));
}

function ihk_validate_vote_type($type) {
	$valid_types = array('loved', 'completed', 'listed');
	return in_array($type, $valid_types);
}

function ihk_post_like()
{
	if (!isset ($_SERVER['REMOTE_ADDR']) || strpos($_SERVER['HTTP_REFERER'], site_url()) !== 0) {
		return false;
	}
	
	$post_id = $_POST['post_id'];
	$type = $_POST['type'] ?? 'faked';

	if ( !ihk_validate_vote_type($type) ) {
		return false; // invalid type
	}

	if ( !ihkUserHasAlreadyVoted($post_id, $type, true) ) {
		echo esc_html__($type, 'ihk');
	} else {
		echo esc_html__("already-" . $type, 'ihk');
	}

	exit(0);
}

if( !function_exists('ihkUserHasAlreadyVoted') ){
	function ihkUserHasAlreadyVoted($post_id, $type = 'faked', $update = false)
	{
		if (
			!ihk_validate_vote_type($type)
			|| !($user_id = get_current_user_id())
			|| (empty($post_id) || !is_numeric($post_id))
		) {
			return false;
		}

		$type_id = $type . "_ID";
		$type_count = $type . "_count";

		$meta_ID = get_post_meta($post_id, $type_id);
		$voted_ID = $meta_ID[0] ?? array();
		$voted = isset($voted_ID[$user_id]);

		if ($update) {
			$meta_count = get_post_meta($post_id, $type_count, true);
			if (!$voted) {
				// update the post meta with the current user ID
				$voted_ID[$user_id] = time();
				update_post_meta($post_id, $type_id, $voted_ID);
				update_post_meta($post_id, $type_count, ++$meta_count);
			} else {
				// remove the current user ID from the post meta
				unset($voted_ID[$user_id]);
				update_post_meta($post_id, $type_id, $voted_ID);
				// update the count but don't decrement if it is already 0
				if ($meta_count > 0) {
					$meta_count--;
				}
				update_post_meta($post_id, $type_count, $meta_count);
			}
		}
		
		return $voted;
	}
}

if( !function_exists('ihkGetPostLikeCount') ){
	function ihkGetPostLikeCount($post_id){
		return ihkGetPostLikeLink($post_id, 'loved');
	}
}


if( !function_exists('ihkGetPostLikeLink') ){
	function ihkGetPostLikeLink($post_id, $type)
	{
		wp_enqueue_script('ihk_like_post');

		if ( !ihk_validate_vote_type($type) ) {
			return ''; // invalid type
		}

		$output = '';
		$output .= '<div class="post-'.$type.'">';
		$output .= '<div class="item-vote item-'.$type.'">';
		$output .= '<a href="#" data-post_id="'.$post_id.'" data-type="'.$type.'">';

		$icons = ihk_get_post_like_icons();
		$labels = ihk_get_post_like_labels();

		if(ihkUserHasAlreadyVoted($post_id, $type)) {
			$icon_class= "fa-solid " . $icons[$type];
			$label = $labels[$type] ?? esc_html__('Liked', 'ihk');
		} else {
			$icon_class= "fa-regular " . $icons[$type];
			$label = $labels['already-' . $type] ?? esc_html__('Like', 'ihk');
		}

		$output .= '<span class="qtip '.$type.'"><i class="'. $icon_class . '"></i></span>';
		$output .= '<span class="label">' . esc_html__($label, 'ihk') . '</span>';
		
		$output .= '</a>';
		$output .='</div>';
		$output .='</div>';

		return $output;
	}
}