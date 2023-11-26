<?php

/**
 * Display multiple posts
 */
function inharmony_display_posts( $atts = array() ) {

    ob_start();
    
    $display_post_excerpt = get_theme_mod( 'inharmony_post_multi_display_excerpt', false );
    $display_post_read_time = get_theme_mod( 'inharmony_post_multi_display_read_time', false );

    //TODO: setting - blog page post display count
    if ( isset($atts['count'])) {
        $atts['posts_per_page'] = $atts['count'];
    } else {
        $atts['posts_per_page'] =  get_theme_mod( 'inharmony_post_list_count', 6 );
    }
    $display_count = $atts['posts_per_page'] ||
    $page = ( int ) $atts['page'];
    $offset = max(0, $page - 1) * $display_count; // max() = don't go below 0

    // set up default parameters
    $disp_atts = shortcode_atts(array(
        'container_element' => 'div',
        'container_id' => 'ih-sc-posts',
        'container_class' => '',
        'post_element' => 'li',
        'post_class' => '',
        'ignore_first' => false,
        'load_more' => false,
        'title_style' => 'entry-title',
    ), $atts, 'ih_posts');

    // set up default parameters
    $query_atts = shortcode_atts(array(
        'posts_per_page' => $display_count,
        'page' => $page,
        'offset' => $offset,
        'order' => 'desc',
        'post_type' => 'post',
        'ignore_sticky_posts' => true,
        'post__not_in' => [],
        'order_by' => 'date',
    ), $atts, 'ih_posts');

    if ($disp_atts['ignore_first'] == true) {
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
            $query_atts['post__not_in'][] = $id;
        endwhile;
        wp_reset_postdata();
    }

    $sc_query = new WP_Query($query_atts);

    $container_element = $disp_atts['container_element'];
    $container_style = $disp_atts['container_class'];
    $container_id = $disp_atts['container_id'];
    
    if ($container_element != '') {
        echo "<$container_element id='$container_id' class='$container_style'>";
    }
    while ($sc_query->have_posts()) :
        $sc_query->the_post();

        get_template_part( 'loop-templates/content', 'blogposts', $disp_atts );
    endwhile;
    
    if ($container_element != '') {
        echo "</$container_element>";
    }

    if ($disp_atts['load_more'] == true) {
        
        echo "<div id='load-older-posts' class='text-center'>";
            if ( $sc_query->max_num_pages > 1 ) :
                next_posts_link( __( '<button class="btn btn-primary text-light understrap-load-more-posts">More Posts</button>', 'inharmony' ), $sc_query->max_num_pages );
            endif;
        echo "</div>";
        
        wp_localize_script( 'child-understrap-scripts', 'loadmore_params', array(
            'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
            'posts' => json_encode( $sc_query->query_vars ), // everything about your loop is here
            'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
            'max_page' => $sc_query->max_num_pages,
            'skip_ids' => $sc_query->post__not_in,
            'security' => wp_create_nonce( 'load_more_posts' ),
            'page_count' => $display_count,
            'str_loading' => "Loading...",
            'str_load_more' => "More Posts",
            'container_id' => $container_id,
        ) );
    }

    return ob_get_clean();

}
add_shortcode('ih_posts', 'inharmony_display_posts');


/**
 * Display single post
 */
function inharmony_display_post( $atts = array() ) {

    ob_start();

    // set up default parameters
    $disp_atts = shortcode_atts(array(
        'container_element' => 'div',
        'container_class' => 'text-center mb-5 pb-5',
        'post_element' => 'div',
        'post_class' => '',
        'image_size' => 'post-thumbnail',
        'ignore_first' => false,
        'display_post_excerpt' => 0,
        'display_post_read_time' => 0,
        'title_decoration' => '',
        'title_style' => 'entry-title mt-3 mb-3',
        'title_element' => 'h3',
        'sec_image_style' => '',
        'sec_content_style' => '',
        'layout' => '',
    ), $atts, 'ih_posts');

    // set up default parameters
    $query_atts = shortcode_atts(array(
        'posts_per_page' => 1,
        'page' => 0,
        'offset' => 0,
        'order' => 'desc',
        'order_by' => 'date',
        'post_type' => 'post',
        'ignore_sticky_posts' => true,
        'post__not_in' => [],
    ), $atts, 'ih_posts');

    $sc_query = new WP_Query($query_atts);

    //TODO: setting - blog page post display count
    $display_count = $query_atts['posts_per_page'];

    $container_element = $disp_atts['container_element'];
    $container_style = $disp_atts['container_class'];
    
    if ($container_element != '') {
        echo "<$container_element id='ih-sc-post' class='$container_style'>";
    }

    while ($sc_query->have_posts()) :
        $sc_query->the_post();

        get_template_part( 'loop-templates/content', 'blogpost', $disp_atts );
    endwhile;
    
    if ($container_element != '') {
        echo "</$container_element>";
    }

    return ob_get_clean();

}
add_shortcode('ih_post', 'inharmony_display_post');

 
/**
 * Display menu by name
 */
function inharmony_menu_shortcode($atts){
 
	return wp_nav_menu(
        shortcode_atts(array(  
            'menu'            => '', 
            'container'       => 'div', 
            'container_class' => '', 
            'container_id'    => '', 
            'menu_class'      => 'menu', 
            'menu_id'         => '',
            'echo'            => false,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'depth'           => 0,
            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
            'theme_location'  => ''), 
		$atts, 'ih_disp_menu')
    );
}
add_shortcode('ih_disp_menu', 'inharmony_menu_shortcode');