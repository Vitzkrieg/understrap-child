<?php
/**
 * List Events
 */
add_action('ihk_dashboard_content_events', 'ihk_list_user_events');

function ihk_list_user_events() {
    ob_start();

    $event_ids = array();

    $_user_set_status    = mep_get_option( 'seat_reserved_order_status', 'general_setting_sec', array( 'processing', 'completed' ) );
    $_order_status       = ! empty( $_user_set_status ) ? $_user_set_status : array( 'processing', 'completed' );
    $order_status        = array_values( $_order_status );
    $order_status_filter = array(
        'key'     => 'ea_order_status',
        'value'   => $order_status,
        'compare' => 'OR'
    );
    $args_search_qqq     = array(
        'post_type'      => array( 'mep_events_attendees' ),
        'posts_per_page' => - 1,
        'author__in'     => array( get_current_user_id() ),
        'meta_query'     => array(
            $order_status_filter
        ),
    );
    $loop               = new WP_Query( $args_search_qqq );
    
    foreach ( $loop->posts as $attendee_id ) {
        $event_id       = get_post_meta( $attendee_id->ID, 'ea_event_id', true );
        $event_ids[]    = $event_id;
    }

    $params = array(
        "cat"           => "0",
        "org"           => "0",
        "style"         => "grid",
        "column"        => 3,
        "cat-filter"    => "no",
        "org-filter"    => "no",
        "show"          => "-1",
        "pagination"    => "yes",
        "pagination-style"    => "load_more",
        "city"          => "",
        "country"       => "",
        "carousal-nav"  => "yes",
        "carousal-dots" => "yes",
        "carousal-id" => "7777777",
        "timeline-mode" => "vertical",
        'sort'          => 'ASC',
        'status'        => 'upcoming',
        'search-filter' => '',
        'title-filter' => 'no',
        'category-filter' => 'no',
        'organizer-filter' => 'no',
        'city-filter' => 'no',
        'date-filter' => 'no'
    );
    $cat            = $params['cat'];
    $org            = $params['org'];
    $style          = $params['style'];
    $cat_f          = $params['cat-filter'];
    $org_f          = $params['org-filter'];
    $show           = $params['show'];
    $pagination     = $params['pagination'];
    $sort           = $params['sort'];
    $column         = $style != 'grid' ? 1 : $params['column'];
    $nav            = $params['carousal-nav'] == 'yes' ? 1 : 0;
    $dot            = $params['carousal-dots'] == 'yes' ? 1 : 0;
    $city           = $params['city'];
    $country        = $params['country'];
    $cid            = $params['carousal-id'];
    $status            = $params['status'];

    $filter = $params['search-filter'];
    $show = ($filter == 'yes' || $pagination == 'yes' && $style != 'timeline') ? -1 : $show;
    $main_div       = $pagination == 'carousal' ? '<div class="mage_grid_box owl-theme owl-carousel"  id="mep-carousel' . $cid . '">' : '<div class="mage_grid_box ihk-test">';

    $time_line_div_start    = $style == 'timeline' ? '<div class="timeline"><div class="timeline__wrap"><div class="timeline__items">' : '';
    $time_line_div_end      = $style == 'timeline' ? '</div></div></div>' : '';

    $flex_column    = $column;
    $mage_div_count = 0;
    $event_expire_on = mep_get_option('mep_event_expire_on_datetimes', 'general_setting_sec', 'event_start_datetime');
    $unq_id = 'dbe'.uniqid();  

?>
    <div class="list_with_filter_section mep_event_list ihk-test">
        <?php if ($cat_f == 'yes') {
            /**
             * This is the hook where category filter lists are fired from inc/template-parts/event_list_tax_name_list.php File
             */
            do_action('mep_event_list_cat_names',$cat,$unq_id);
        }
        if ($org_f == 'yes') {
            /**
             * This is the hook where Organization filter lists are fired from inc/template-parts/event_list_tax_name_list.php File
             */
            do_action('mep_event_list_org_names',$org,$unq_id);
        }
        if ($filter == 'yes' && $style != 'timeline') {
            do_action('mpwem_list_with_filter_section', $loop, $params);
        }
        ?>

        <div class="all_filter_item mep_event_list_sec" id="mep_event_list_<?php echo esc_attr($unq_id); ?>">
            <?php
            $total_item = $loop->post_count;
            echo $main_div;
            echo $time_line_div_start;

            foreach ($event_ids as $event_id) {

                mep_update_event_upcoming_date( $event_id );

                if ($style == 'grid' && (int)$column>0 && $pagination != 'carousal') {
	                $columnNumber='column_style';
	                $width=100/(int)$column;
                }elseif($pagination == 'carousal' && $style == 'grid'){
                    $columnNumber = 'grid';
                    $width=100;                    
                } else {
                    $columnNumber = 'one_column';
                    $width=100;
                }

                /**
                 * This is the hook where Event Loop List fired from inc/template-parts/event_loop_list.php File
                 */
                do_action('mep_event_list_shortcode', $event_id, $columnNumber, $style, $width, $unq_id);
            }

            echo $time_line_div_end;
            ?>
        </div>
    </div>
    <?php
    do_action('mpwem_pagination',$params,$total_item);
    ?>
    </div>
    <script>
    jQuery(document).ready(function() {
            var containerEl = document.querySelector('#mep_event_list_<?php echo esc_attr($unq_id); ?>');
            var mixer = mixitup(containerEl, {
            selectors: {
                target: '.mep-event-list-loop',
                control: '[data-mixitup-control]'
            }
            });
            <?php if ($pagination == 'carousal') { ?>
                jQuery('#mep-carousel<?php echo esc_attr($cid); ?>').owlCarousel({
                    autoplay:  <?php echo mep_get_option('mep_autoplay_carousal', 'carousel_setting_sec', 'true'); ?>,
                    autoplayTimeout:<?php echo mep_get_option('mep_speed_carousal', 'carousel_setting_sec', '5000'); ?>,
                    autoplayHoverPause: true,
                    loop: <?php echo mep_get_option('mep_loop_carousal', 'carousel_setting_sec', 'true'); ?>,
                    margin: 20,
                    nav: <?php echo esc_attr($nav); ?>,
                    dots: <?php echo esc_attr($dot); ?>,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        600: {
                            items: 2,
                        },
                        1000: {
                            items: <?php echo esc_attr($column); ?>,
                        }
                    }
                });
            <?php } ?>
            <?php do_action('mep_event_shortcode_js_script', $params); ?>
        });
    </script>
<?php

    $content = ob_get_clean();
    echo html_entity_decode( $content );
    
}
