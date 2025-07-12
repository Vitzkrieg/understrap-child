<?php
global $cpt_slugs;
$cpt_slugs[] = 'seasonal-foundations';

/**
 * Post Type: Seasonal Foundations.
 */


function ihk_register_cpts_seasonal_foundations() {

    $singular = "Seasonal Foundation";
    $plural = "{$singular}s";

    $labels = ihk_get_cpt_labels($singular, $plural);

	$args = [
		"label" => esc_html__( "{$singular}", "ihk" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"can_export" => true,
		"rewrite" => [ "slug" => "seasonal-foundations", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-grid-view",
		"supports" => [ "title", "editor", "thumbnail", "custom-fields", "revisions", "page-attributes" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "seasonal-foundations", $args );
}
