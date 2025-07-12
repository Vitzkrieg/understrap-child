<?php
global $cpt_slugs;
$cpt_slugs[] = 'children';

/**
 * Post Type: Children.
 */


function ihk_register_cpts_children() {

    $singular = "Child";
    $plural = "Children";

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
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "children", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-reddit",
		"supports" => [ "title", "thumbnail", "custom-fields", "revisions", "page-attributes" ],
		"taxonomies" => [ ],
		"show_in_graphql" => false,
	];

	register_post_type( "children", $args );
}
