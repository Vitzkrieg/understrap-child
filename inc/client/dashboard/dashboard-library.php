<?php
/**
 * List Events
 */
add_action('ihk_dashboard_content_library', 'ihk_list_user_library');

function ihk_list_user_library() {
    ob_start();

    // slug display order
    $display_order = array(
        'loved',
        'completed',
        'listed',
    );

    // post type titles
    $section_titles = [
        'loved'        => 'Favorites',
        'completed'    => 'Have read',
        'listed'       => 'Want to read',
    ];
    $unq_id = 'del'.uniqid();
?>
<div class="list_with_filter_section mep_event_list">
    <div class="all_filter_item mep_event_list_sec" id="mep_event_list_<?php echo esc_attr($unq_id); ?>">
        <?php
        foreach ($display_order as $post_type) {
    
            $liked = array(
                'key'     => $post_type . '_ID',
                'value'   => get_current_user_id(),
                'compare' => 'LIKE'
            );
            $args_search_books   = array(
                'post_type'      => array( 'books' ),
                'posts_per_page' => - 1,
                'meta_query'     => array(
                    $liked
                ),
            );

            $books         = new WP_Query( $args_search_books );

            // Skip if no posts of this type
            if ( empty($books->posts) ) {
                continue;
            }
            ?>
            <div class="row">
            <?php

            $posts_array = $books->posts;
            $section_title = $section_titles[$post_type];

            $post_type = 'books';

            include(locate_template( 'template-parts/posts/slider.php' ));
            ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php

    $content = ob_get_clean();
    echo html_entity_decode( $content );
    
}
