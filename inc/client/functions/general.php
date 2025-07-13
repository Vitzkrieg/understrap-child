<?php


/**
 * Generates the labels array for CPTs
 * @param string $singular              Singular name
 * @param string $plural                Plural name
 * @param string|boolean $menu_name     Custom menu name
 * @return array                        Array of label names
 */
function ihk_get_cpt_labels($singular, $plural, $menu_name = false)
{

	$menu = $menu_name ?: $plural;

	return [
		"name" => esc_html__("{$plural}", "ihk"),
		"singular_name" => esc_html__("{$singular}", "ihk"),
		"menu_name" => esc_html__("{$menu}", "ihk"),
		"all_items" => esc_html__("All {$plural}", "ihk"),
		"add_new" => esc_html__("Add new {$singular}", "ihk"),
		"add_new_item" => esc_html__("Add new {$singular}", "ihk"),
		"edit_item" => esc_html__("Edit {$singular}", "ihk"),
		"new_item" => esc_html__("New {$singular}", "ihk"),
		"view_item" => esc_html__("View {$singular}", "ihk"),
		"view_items" => esc_html__("View {$plural}", "ihk"),
		"search_items" => esc_html__("Search {$plural}", "ihk"),
		"not_found" => esc_html__("No {$plural} found", "ihk"),
		"not_found_in_trash" => esc_html__("No {$plural} found in trash", "ihk"),
		"parent" => esc_html__("Parent {$singular}:", "ihk"),
		"featured_image" => esc_html__("Featured image for this {$singular}", "ihk"),
		"set_featured_image" => esc_html__("Set featured image for this {$singular}", "ihk"),
		"remove_featured_image" => esc_html__("Remove featured image for this {$singular}", "ihk"),
		"use_featured_image" => esc_html__("Use as featured image for this {$singular}", "ihk"),
		"archives" => esc_html__("{$singular} archives", "ihk"),
		"insert_into_item" => esc_html__("Insert into {$singular}", "ihk"),
		"uploaded_to_this_item" => esc_html__("Upload to this {$singular}", "ihk"),
		"filter_items_list" => esc_html__("Filter {$plural} list", "ihk"),
		"items_list_navigation" => esc_html__("{$plural} list navigation", "ihk"),
		"items_list" => esc_html__("{$plural} list", "ihk"),
		"attributes" => esc_html__("{$plural} attributes", "ihk"),
		"name_admin_bar" => esc_html__("{$singular}", "ihk"),
		"item_published" => esc_html__("{$singular} published", "ihk"),
		"item_published_privately" => esc_html__("{$singular} published privately.", "ihk"),
		"item_reverted_to_draft" => esc_html__("{$singular} reverted to draft.", "ihk"),
		"item_trashed" => esc_html__("{$singular} trashed.", "ihk"),
		"item_scheduled" => esc_html__("{$singular} scheduled", "ihk"),
		"item_updated" => esc_html__("{$singular} updated.", "ihk"),
		"parent_item_colon" => esc_html__("Parent {$singular}:", "ihk"),
	];
}


function ihk_get_tax_labels($singular, $plural = false, $menu_name = false)
{

	$plural = $plural ?: "{$singular}s";
	$menu_name = $menu_name ?: $plural;

	return [
		"name" => esc_html__("{$plural}", "custom-post-type-ui"),
		"singular_name" => esc_html__("{$singular}", "custom-post-type-ui"),
		"menu_name" => esc_html__("{$menu_name}", "custom-post-type-ui"),
		"all_items" => esc_html__("All {$plural}", "custom-post-type-ui"),
		"edit_item" => esc_html__("Edit {$singular}", "custom-post-type-ui"),
		"view_item" => esc_html__("View {$singular}", "custom-post-type-ui"),
		"update_item" => esc_html__("Update {$singular} name", "custom-post-type-ui"),
		"add_new_item" => esc_html__("Add new {$singular}", "custom-post-type-ui"),
		"new_item_name" => esc_html__("New {$singular} name", "custom-post-type-ui"),
		"parent_item" => esc_html__("Parent {$singular}", "custom-post-type-ui"),
		"parent_item_colon" => esc_html__("Parent {$singular}:", "custom-post-type-ui"),
		"search_items" => esc_html__("Search {$plural}", "custom-post-type-ui"),
		"popular_items" => esc_html__("Popular {$plural}", "custom-post-type-ui"),
		"separate_items_with_commas" => esc_html__("Separate {$plural} with commas", "custom-post-type-ui"),
		"add_or_remove_items" => esc_html__("Add or remove {$plural}", "custom-post-type-ui"),
		"choose_from_most_used" => esc_html__("Choose from the most used {$plural}", "custom-post-type-ui"),
		"not_found" => esc_html__("No {$plural} found", "custom-post-type-ui"),
		"no_terms" => esc_html__("No {$plural}", "custom-post-type-ui"),
		"items_list_navigation" => esc_html__("{$plural} list navigation", "custom-post-type-ui"),
		"items_list" => esc_html__("{$plural} list", "custom-post-type-ui"),
		"back_to_items" => esc_html__("Back to {$plural}", "custom-post-type-ui"),
		"name_field_description" => esc_html__("The name is how it appears on your site.", "custom-post-type-ui"),
		"parent_field_description" => esc_html__("Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "custom-post-type-ui"),
		"slug_field_description" => esc_html__("The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "custom-post-type-ui"),
		"desc_field_description" => esc_html__("The description is not prominent by default; however, some themes may show it.", "custom-post-type-ui"),
	];
}


// get taxonomy slug
function get_taxonomy_slug($taxonomy) {
	$taxonomy = get_taxonomy($taxonomy);
	return $taxonomy->rewrite['slug'];
}


function unregister_post_types() {
	$cpts = array('malina-header', 'malina-footer');

	foreach ($cpts as $cpt) {
		$success = unregister_post_type($cpt);
	}
}
add_action('init', 'unregister_post_types');

add_filter( 'login_redirect', 'ihk_login_redirect', 10, 3 );
add_filter('woocommerce_login_redirect', 'ihk_login_redirect', 10, 3);

function ihk_login_redirect( $redirect_to, $request ) {
	$user = wp_get_current_user();
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		if ( in_array( 'customer', $user->roles )) {
			$redirect_to = '/my-account';
		}
	}
	return $redirect_to;
}

add_action('wp_logout','ihk_redirect_after_logout');
function ihk_redirect_after_logout(){

  wp_redirect( '/member-login' );
  exit();
}
   
function malina_get_custom_header_list() {
	$custom_headers = get_posts(array(
		'post_type' => 'malina-header',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'orderby' => 'title',
		'order' => 'ASC',
	));

	$custom_header_list = array();
	foreach ($custom_headers as $header) {
		$custom_header_list[$header->ID] = $header->post_title;
	}

	return $custom_header_list;
}



global $ihk_resources_fields;
$ihk_resources_fields = array(
	'category' 		=> 'Category',
	'seasons' 		=> 'Seasons',
	'cycles' 		=> 'Cycles',
	'subjects' 		=> 'Subjects',
	'continents' 	=> 'Continents',
);

function ihk_get_resources_fields() {
	global $ihk_resources_fields;
	return $ihk_resources_fields;
}


add_filter( 'body_class', 'ihk_body_classes' );
function ihk_body_classes( $classes ) {

	if ( is_user_logged_in()) {
		$classes[] = 'logged-in';
	} else {
		$classes[] = 'not-logged-in';
	}
	
	if ( $parent = get_post_parent() ) {
		$classes[] = 'has-parent';
		$classes[] = 'parent-' . $parent->ID;
	}

	if (is_ihk_dashboard_page()) {
		$classes[] = 'is-ihk-dashboard';
	}

	return $classes;
}


add_action( 'after_setup_theme', 'ihk_theme_setup' );
function ihk_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'ihk-book', 800, 1200, false );
}

add_filter( 'image_size_names_choose', 'ihk_custom_sizes' );
function ihk_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'ihk-book' => __( 'IHK Book' ),
	));
}


// prevent media from assigning default slug
add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', '__return_true' );


function ihk_user_is_admin() {
	// Can't be an admin if not logged in
	if ( !is_user_logged_in() ) {
		return false;
	}

	// return current_user_can('manage_options');
	// Check if the user has the 'administrator' role
	if ( current_user_can( 'administrator' ) ) {
		return true;
	}

	// If we are using the "Login As User" plugin
	// check if the old user is admin
	// https://wordpress.org/plugins/login-as-user/
	if (class_exists('w357LoginAsUser')) {
		// get old user id
		$loginAsUser = new w357LoginAsUser();
		$old_user = $loginAsUser->get_old_user();
		// check if old user is admin
		if ($old_user && in_array('administrator', $old_user->roles ?? array())) {
			return true;
		}
	}

	return false;
}


add_filter('single_template', 'ihk_single_template');
function ihk_single_template($single_template) {
	global $post;

	$cpts = array(
		'books',
		'book-authors',
		'bulletins',
		'seasonal-foundations'
	);

	// check if restricted post type
	if (in_array($post->post_type, $cpts)) {
		if (!is_user_logged_in()) {
			// if not logged in, restricted access
			return locate_template('/templates/not-logged-in.php');
		}
	}

	return $single_template;
}
add_filter('archive_template', 'ihk_archive_template');
function ihk_archive_template($archive_template) {
	$queried_object = get_queried_object();
	$post_type = $queried_object->name ?? '';
	// If we are on a custom post type archive page
	$template = locate_template('/templates/posts/template-' . $post_type . '.php');
	$cpts = array(
		'books',
		'book-authors',
		'bulletins',
		'seasonal-foundations',
	);

	// check if restricted post type
	if (in_array($post_type, $cpts)) {
		if (!is_user_logged_in()) {
			// if not logged in, restricted access
			return locate_template('/templates/not-logged-in.php');
		}
	}

	if ( !empty($template) ) {
		// if template exists, return it
		return $template;
	}

	return $archive_template;
}


/*
WooCommerce Lost Password Shortcode
*/

function wc_lost_password_form( $atts ) {

	return wc_get_template( 'myaccount/form-lost-password.php',
	array( 'form' => 'lost_password' ) );
	
}
add_shortcode( 'wc_lost_password_form', 'wc_lost_password_form' );



add_action( 'wp_head', 'ihk_preload_fonts', 1 );

function ihk_preload_fonts() : void {
	// Preload fonts
	?>
	<link rel="preload" href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic|Open+Sans:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic|Bad+Script:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" as="font" onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="https://inharmonykids.com/wp-content/themes/malina-ihk/framework/fonts/line-awesome/fonts/la-regular-400.woff2" as="font" type="font/woff2" crossorigin onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="https://inharmonykids.com/wp-content/themes/malina-ihk/framework/fonts/line-awesome/fonts/la-solid-900.woff2" as="font" type="font/woff2" crossorigin onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="https://fonts.gstatic.com/s/opensans/v40/memvYaGs126MiZpBA-UvWbX2vVnXBbObj2OVTS-mu0SC55I.woff2" as="font" type="font/woff2" crossorigin onload="this.onload=null;this.rel='stylesheet'">
	<link rel="preload" href="https://fonts.gstatic.com/s/josefinsans/v32/Qw3aZQNVED7rKGKxtqIqX5EUDXx4Vn8sig.woff2" as="font" type="font/woff2" crossorigin onload="this.onload=null;this.rel='stylesheet'">
	<?php
}
