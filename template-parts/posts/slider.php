<?php
/**
 * The template for displaying slider on the blog page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( empty($posts_array) ) {
	return;
}

// $slideshow = get_theme_mod('malina_home_slider_slideshow','true') || 'true';
$slideshow = 'false';
// $loop = get_theme_mod('malina_home_slider_loop','false');
// $loop = false; // Force loop to false for now
// $sliderwidth = get_theme_mod('malina_home_slider_width', 'fullwidth');
$sliderwidth = 'fullwidth'; // Force slider width to fullwidth
// $style = get_theme_mod('malina_home_slider_style', 'center');
$style = 'three_per_row'; // Force slider style
$description_style = 'style_1';
$nav = 'false';
$loop = ($loop) ? 'true' : 'false';
// $overlay = get_theme_mod('malina_home_slider_overlay', 1);
$overlay = 1; // Force overlay to 1
$show_date = false;
$readmore = false;
$meta_categories = 1;
$slider_height = '';
$orderby = 'date';
$slider_height_style = '';
if($slider_height != ''){
	$slider_height_style = 'height:'.$slider_height.'px;';
}
$thumbsize = 'large';

$out = '';

$post_count = 0;
$post_total = count($posts_array);

if( $style == 'center' ){
	$center = 'true';
	$items = '2';
	$margin = '25';
	$loop = 'true';
	$nav = 'true';
	$centerClass = 'post-slider-center';
	if($sliderwidth == 'container'){
		$thumbsize = 'post-thumbnail';
	}
} elseif( $style == 'center2' ){
	$center = 'true';
	$items = '2';
	$margin = '0';
	$loop = 'true';
	$nav = 'true';
	$overlay = !$show_date;
	// $thumbsize = 'malina-masonry';
	$centerClass = 'post-slider-center';
	$description_style = 'style_4';
	if($sliderwidth == 'container'){
		$thumbsize = 'large';
	}

} elseif ($style == 'three_per_row') {
	$center = 'false';
	$items = '3';
	$margin = '10';
	$thumbsize = 'malina-extra-medium';
	$nav = ($post_total > 3) ? 'true' : 'false';
	if($sliderwidth == 'fullwidth'){
		$margin = '25';
		$thumbsize = 'large';
	}
	// $thumbsize = 'malina-masonry';
	$centerClass = 'slider-three-per-row';
	$description_style = 'style_3';
} elseif ($style == 'two_per_row') {
	$center = 'false';
	$items = '2';
	$centerClass = '';
	$margin = '25';
	$description_style = 'style_2';
	$overlay = 'false';
	$show_date = false;
	if($sliderwidth == 'fullwidth'){
		$centerClass = 'post-slider-fullwidth';
	}
} else {
	$center = 'false';
	$items = '1';
	$centerClass = '';
	$margin = '0';
	if($sliderwidth == 'fullwidth'){
		$centerClass = 'post-slider-fullwidth';
		$thumbsize = 'malina-fullwidth-slider';
	}
}

if ( !isset($post_type) ) {
	$post_type = get_post_type();
}

$slider_id = 'post-slider-blog-' . $post_type;

wp_enqueue_script('owl-carousel');
wp_enqueue_style( 'owl-carousel' );
$owl_custom = 'jQuery(document).ready(function($){
		"use strict";
		setTimeout(
			function(){
				var owl = $(".post-slider-blog").owlCarousel(
			{
				items: '.$items.',
				center: '.$center.',
				margin: '.$margin.',
				dots: false,
				nav: '.$nav.',
				navText: [\'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\'],
				autoplay: '.$slideshow.',
				responsiveClass:true,
				loop: '.$loop.',
				smartSpeed: 450,
				autoHeight: false,
				autoWidth:'.$center.',
				themeClass: "owl-post-slider",';
			if($style == 'three_per_row'){
				$owl_custom .= 'responsive:{
					0:{
						items:1,
					},
					782:{
						items:2,
					},
					960:{
						items:3
					}
				},';
			}
			if($style == 'two_per_row'){
				$owl_custom .= 'responsive:{
					0:{
						items:1,
					},
					782:{
						items:2,
					}
				},';
			}
			$owl_custom .= '});
	}, 100);
		
	});';
	wp_add_inline_script('owl-carousel', $owl_custom);
if ($sliderwidth == 'container') {
	$out .= '<div id="blog-page-slider" class="container"><div class="span12">'; }
	
$out .= '<h2>' . $section_title . '</h2>';
$out .= '<div id="' . $slider_id . '" class="owl-carousel post-slider-blog post-slider '.$style.' '.$centerClass.' '.$sliderwidth.' post_more_'.$description_style.'">';


global $post;

foreach ($posts_array as $cat_post) {
	setup_postdata($cat_post);
	$post = $cat_post;
	$post_count++;
	if( $post_count +1 == $post_total && $post_total % 2 != 0 ){
		$last = ' last-one';
		$thumbsize = 'large';
	} else {
		$last = '';
	}
	if( $style == 'center2' && $post_count == 1 ){
		$out .= '<div class="post-slider-double-item'.$last.'">';
	}

	$img_classes = array(
		'post-img-block',
		'mb-4',
		'p-0',
	);

	// reset
	$ihk_favorite_icon = null;
	$family_read_aloud = null;
	$ihk_favorite = null;
	
	if ( $post_type == 'books' ) {
		$thumbsize = 'ihk-book';
		extract(get_field( 'ratings' ) ?? []);
		$rating 			= $rating ?? false;
		$ihk_favorite 		= $ihk_favorite ?? false;
		$family_read_aloud 	= $family_read_aloud ?? false;
	
		if ( $ihk_favorite ) {
			extract( get_option( 'ihk_theme_settings' ) );
			$ihk_favorite_icon	= !empty($ihk_favorite_image) ? wp_get_attachment_image_src($ihk_favorite_image, 'thumbnail')[0] : '';
		}

		if ($family_read_aloud ) {
			$img_classes[] = 'family-read-aloud';
		}
		if ($ihk_favorite ) {
			$img_classes[] = 'ihk-favorite';
		}
	}

	$post_title = get_the_title();
	$out .= '<div class="post-slider-item">';
	if ( has_post_thumbnail( $post->ID )) {
		$img_url = get_the_post_thumbnail_url($post->ID, $thumbsize);
	} else if ( has_post_thumbnail( $post->post_parent ) ) {
		$img_url = get_the_post_thumbnail_url( $post->post_parent, $thumbsize);
	} else {
		$img_url = get_site_icon_url( 'large' );
	}

	if( $img_url ) {
		$out .= '<div class="' . join(' ', $img_classes) . '">';
		if( $show_date ) {
			$out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
		}
		$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">';
		$out .= '<img src="' . $img_url . '" style="'.esc_attr($slider_height_style).'" alt="' . $post_title . '" laoding="lazy"></a></figure>';
		if ( !empty($ihk_favorite_icon) ) :
			$out .= '<figure class="ihk-favorite-icon">';
			$out .= '<img src="' . $ihk_favorite_icon . '" alt="An IHK Favorite Book" width="100" height="100">';
			$out .= '</figure>';
		endif;
		$out .= '</div>';
	}
	$out .= '<div class="post-content-block"><header class="title">';
	$out .= '<h3 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr($post_title).'</a></h3>';
	$out .= '</header></div>';
	$out .= '</div>';
	if( $style == 'center2' && ( $post_count == 2 || $last == ' last-one' ) ){
		$out .= '</div>';
		$post_count = 0;
	}
}
$out .= '</div>';
if($sliderwidth == 'container' ){ $out .= '</div></div>'; }
echo ''.$out;

$out = '';
?>