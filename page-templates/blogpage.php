<?php
/**
 * Template Name: Blog Page
 *
 * Template for displaying blogs with latest at the top and the rest in columns below.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

if ( is_front_page() ) {
	get_template_part( 'global-templates/hero' );
}

$title_style = 'mt-3 mb-3';
//TODO: make title styling setting
$display_post_excerpt = get_theme_mod( 'inharmony_display_post_excerpt', false );
$display_post_read_time = get_theme_mod( 'inharmony_display_post_read_time', false );
$title_decoration = get_theme_mod( 'inharmony_post_list_title_decoration', 'cap' );
switch ($title_decoration) {
	case 'upper':
		$title_style .= ' t-upper';
	  break;
	case 'lower':
		$title_style .= ' t-lower';
	  break;
	case 'cap':
		$title_style .= ' t-cap';
	  break;
	default:
}

//TODO: setting - blog page post display count
$display_count = get_theme_mod( 'inharmony_post_list_count', 6 );
$page = ( int ) get_query_var( 'paged' );
$offset = max(0, $page - 1) * $display_count; // max() = don't go below 0

?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">
                            <!-- $page: <?php echo $page; ?> -->
                            <!-- $offset: <?php echo $offset; ?> -->
                    <?php
                    $ids;
                    $latest_post = new WP_Query(array(
                        'posts_per_page' => 1, // Displays the latest 10 posts, change 10 to what you require
                        'post_type' => 'post', // Pulls posts from 'post' post type only
                        'ignore_sticky_posts' => true, // Ignores the sticky posts
                        'order' => 'DESC',
                        'order_by' => 'date',
                    ));

                    while ($latest_post->have_posts()) :
                        $latest_post->the_post();
                        $id = get_the_ID();
                        $ids[] = $id;

                        if ($offset == 0) :
                        ?>
                        <div id="latest-post" class="text-center mb-5 pb-5">

                            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                <div class="latest-post__featured-image">
                                        <?php echo get_the_post_thumbnail( $id, 'large' ); ?>
                                </div>
                                <?php 
                                    $title_tag_open = '<h2 class="'. $title_style . '">';
                                    $title_tag_close = '</h2>';
                                    the_title( $title_tag_open, $title_tag_close );
                                ?>
                            </a>
                            <div class="latest-post__post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <?php
                            //TODO: setting - display read time
                            if ($display_post_read_time) :
                            ?>
                            <div class="ih-latest-post__post-read-time">
                                <?php inharmony_read_time(); ?>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div><!-- #ih-latest-post -->
                        <?php
                        endif;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                    
                    <div id="ih-latest-posts">
                        <ul id="ih-latest-posts__list" class="list-unstyled row">
                    <?php
                        $latest_posts = new WP_Query(array(
                            'posts_per_page' => $display_count, // Displays the latest # posts
                            'post_type' => 'post', // Pulls posts from 'post' post type only
                            'ignore_sticky_posts' => true, // Ignores the sticky posts
                            'post__not_in' => $ids, // ignore the first post
                            'order' => 'DESC',
                            'order_by' => 'date',
                            'offset' => $offset,
                            'paged' => $args['paged'],
                        ));

                        while ($latest_posts->have_posts()) :
                            $latest_posts->the_post();

                            get_template_part( 'loop-templates/content', 'blogposts', 
                                array(
                                    'title_style' => $title_style,
                                    'display_post_excerpt' => $display_post_excerpt,
                                    'display_post_read_time' => $display_post_read_times,
                                )
                            );
                        endwhile;
                        ?>
                        </ul>
                    </div><!-- #ih-latest-posts -->
                    <div id="load-older-posts" class="text-center">
                        <?php
                            if ( $latest_posts->max_num_pages > 1 ) :
                                next_posts_link( __( '<button class="btn btn-primary text-light understrap-load-more-posts">More Posts</button>', 'inharmony' ), $latest_posts->max_num_pages );
                            endif;
                         ?>
                    </div>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php
	
wp_localize_script( 'child-understrap-scripts', 'loadmore_params', array(
    'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
    'posts' => json_encode( $latest_posts->query_vars ), // everything about your loop is here
    'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
    'max_page' => $latest_posts->max_num_pages,
    'skip_ids' => $latest_posts->post__not_in,
    'security' => wp_create_nonce( 'load_more_posts' ),
    'page_count' => 6,
    'str_loading' => "Loading...",
    'str_load_more' => "More Posts",
) );

get_footer();
