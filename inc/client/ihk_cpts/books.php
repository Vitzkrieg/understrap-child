<?php
global $cpt_slugs;
$cpt_slugs[] = 'books';

/**
 * Post Type: Books.
 */


function ihk_register_cpts_books() {

    $singular = "Book";
    $plural = "{$singular}s";

	$labels = ihk_get_cpt_labels($singular, $plural, "Library");

	$args = [
		"label" => esc_html__( $singular, "ihk" ),
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
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "library", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-book-alt",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions", "page-attributes" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "books", $args );
}
