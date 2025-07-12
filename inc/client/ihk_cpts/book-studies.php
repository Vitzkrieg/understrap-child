<?php
global $cpt_slugs;
$cpt_slugs[] = 'book-studies';

/**
 * Post Type: Book Studies.
 */

 
function ihk_register_cpts_book_studies() {

    $singular = "Book Study";
    $plural = "Book Studies";

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
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"can_export" => true,
		"rewrite" => [ "slug" => "book-studies", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 7,
		"menu_icon" => "dashicons-portfolio",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions", "page-attributes" ],
		"taxonomies" => [ "bs-cats" ],
		"show_in_graphql" => false,
	];

	register_post_type( "book-studies", $args );
}
