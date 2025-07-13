<?php

/**
 * Template part for displaying resources list
 *
 * $fields array
 * $selections array
 */


$split_events = false; // TODO: make this a setting toggle somewhere
$is_logged_in = is_user_logged_in();

// post slugs to display
$cpt_order = array(
	'post',
	'books',
	'product',
	'mep_events'
);

// Check if the form is submitted
if ( !empty($fields) ) {

    $hasFilters = false;
    $query_args = array(
        'post_type'         => $cpt_order,
        'posts_per_page'    => -1,
        'orderby'           => 'date',
        'order'             => 'DESC',
        'post_status'       => 'publish',
    );

    // Create tax_query args
    $tax_query = array();
    foreach ($selections as $key => $value) {
        $tax_query[] = array(
            'taxonomy' => $key,
            'field' => 'slug',
            'terms' => $value,
            'operator' => 'IN',
        );

        $hasFilters = true;
    }

    if ($hasFilters ) {
        $tax_query['relation'] = 'AND';
        $query_args['tax_query'] = $tax_query;
    }

    $the_query = new WP_Query($query_args);
} else {
    // use default WP query
    $the_query = $wp_query;
}


// stored posts arrays
$cat_posts = [];

// slug display order
$display_order = array(
	'post',
	$is_logged_in ? 'books': false,
	'product',
	!$split_events ? 'mep_events' : false,
	$split_events ? 'for_all' : false,
	$split_events && $is_logged_in ? 'member_only' : false,
);

// post type titles
$section_titles = [
	'post'          => 'Articles',
	'books'         => 'Books',
	'product'       => 'Products',
	'mep_events'    => 'Events',
	'for_all'       => 'Public Events',
	'member_only'   => 'Member Events',
];

if ( $the_query->have_posts() ) :
	while( $the_query->have_posts() ) : $the_query->the_post();
		$post_id = get_the_ID();
		$post_type = get_post_type();

        // validate post is published
        if ( get_post_status() != 'publish' ) {
            continue;
        }

		// make sure array is created
		if ( !isset($cat_posts[$post_type]) ) {
			$cat_posts[$post_type] = array();
		}

		// get split event slug
		if ( $post_type == 'mep_events' ) {
            // don't show if past start date
            $event_start_datetime = get_post_meta($post_id, 'event_start_datetime', true);
            if ( strtotime(current_time('Y-m-d H:i')) > strtotime($event_start_datetime) ) {
                continue;
            }
            // split member only and online
            if ( $split_events ) {
                $post_type = get_post_meta($post_id, 'mep_member_only_event', true);
            }
        }

        // filter out proucts that are linked to events
        if ( $post_type == 'product' && !empty(get_post_meta($post_id, 'link_mep_event')) ) {
            continue;
        }

		// assign post to post type array
		$cat_posts[$post_type][] = $post;
	endwhile;
endif;

wp_reset_query();
wp_reset_postdata();

$columns = get_theme_mod( 'malina_archive_columns', 'span6');
$display_categories = false;
$display_date = get_theme_mod( 'malina_display_post_date_archive', true);

$pagination = get_theme_mod( 'malina_display_post_pagination_archive', 'standard');
$display_readmore = 'true';
$ignore_featured = $ignore_sticky_posts = true;
$text_align = get_theme_mod( 'malina_archive_elements_align', 'textcenter');
$out = '';
$post_style = get_theme_mod('malina_archive_style', 'style_1');
$excerpt_count = get_theme_mod('malina_archive_excerpt_count','17');


if ($post_style == 'style_4'){
    $thumbsize = 'malina-masonry';
} else if ($post_style == 'style_2' || $post_style == 'style_3' ){
    $thumbsize = 'post-thumbnail';
} else {
    $thumbsize = get_theme_mod('malina_archive_thumbnail_size','malina-extra-medium');
}

if (($post_style == 'style_1' || $post_style == 'style_4') || $pagination == 'true' ) {
    include(locate_template( './template-parts/infinite-scroll.php' ));
}
?>

<article <?php post_class($article_style); ?> id="post-<?php the_ID(); ?>">

    <?php
        inharmony_get_page_header();
    ?>

    <header class="post-content entry-header">
        <?php
        $title_tag_open = '<h1 class="'. $title_style . '">';
        $title_tag_close = '</h1>';
        the_title( $title_tag_open, $title_tag_close );
        ?>
    </header>
<div class="resources-list">
<?php

foreach ($display_order as $post_type) {
    // Skip if no posts of this type
    if ( empty($cat_posts[$post_type]) ) {
        continue;
    }
    ?>
    <div class="row">
        <?php

    $posts_array = $cat_posts[$post_type];
    $section_title = $section_titles[$post_type];

    include(locate_template( 'template-parts/posts/slider.php' ));
    ?>
    </div>
<?php
}
?>
</div>