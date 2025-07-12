<?php


//TODO: check if plugin exists/active
include_once ABSPATH . 'wp-admin/includes/plugin.php';

// check for plugin using plugin name
if ( !is_plugin_active( 'mage-eventpress/woocommerce-event-press.php' ) ) {
	return;
} 

function ihk_get_event_category_color($id) {
    $terms = get_the_terms($id, 'mep_cat');
    $term = $terms[0];
    $color = get_field('category_color', 'term_' . $term->term_id) ?: get_field('category_color', 'term_' . $term->parent);
    return $color;
}

function ihk_get_ticket_link($event_id) {
    $tix_link = get_field('ticket_link', $event_id);
    if ( !isset($tix_link['url']) ) return;
    ob_start();
    ?>
    <div class="mep_list_details--tickets">
        <?php
            $url = $tix_link['url'] ?: '';
            $title = $tix_link['title'] ?: 'Get Tickets';
            $target = $tix_link['target'] ?: '_blank';
            
            echo '<a href="' . $url . '" target="' . $target . '">' . $title . '</a>';
        ?>
    </div>
    <?php
    return ob_get_clean();
}

function ihk_get_reserve_link($event_id) {
    ob_start();
    ?>
    <div class="mep_list_details--reserve">
        <?php
            $title = "Register";
            $target = "_self";
            $url = get_the_permalink($event_id);
            echo '<a href="' . $url . '" target="' . $target . '">' . $title . '</a>';
        ?>
    </div>
    <?php
    return ob_get_clean();
}


/**
 * This is the Shortcode For Display Event Calendar
 */
remove_shortcode('event-calendar');
add_shortcode('ihk-event-calendar', 'ihk_cal_func');
function ihk_cal_func($atts, $content = null)
{
    ob_start();
    echo ihk_event_calender();
    return ob_get_clean();
}



function ihk_event_calender()
{
    wp_enqueue_script('ihk-calendar-scripts');
?>
    <div class="event-calendar"></div>
    <script id="ihk-event-calendar-script">
        jQuery(document).ready(function() {
            const myEvents = [
                <?php
                // $loop       = mep_event_query('all',-1);
                // mep_hide_expired_date_in_calendar
                $event_expire_on_old = (function_exists('mep_get_option') ? mep_get_option('mep_event_expire_on_datetimes', 'general_setting_sec', 'event_start_datetime') : 'event_start_datetime');
                $hide_expired = 'no'; // mep_get_option('mep_hide_expired_date_in_calendar', 'general_setting_sec', 'no');
                $event_expire_on    = $event_expire_on_old == 'event_expire_datetime' ? 'end' : 'start';                   
                $args = array(
                    'post_type'         => array('mep_events'),
                    'posts_per_page'    => -1,
                    'order'             => 'ASC',
                    'orderby'           => 'meta_value',
                    'meta_key'          => 'event_start_datetime'
                );
                $loop = new WP_Query($args);
                $i          = 1;
                $count      = $loop->post_count - 1;
                while ($loop->have_posts()) {
                    $loop->the_post();
                    $post_id = get_the_ID();
                    $event_meta = get_post_custom($post_id);
                    $event_dates = mep_get_event_dates_arr($post_id);
                    $now 		= current_time('Y-m-d H:i:s');
                    foreach ($event_dates as $_dates) {


                    if($hide_expired == 'no') {
                        ?>
                    {
                        start   : '<?php echo date_i18n('Y-m-d H:i', strtotime($_dates['start'])); ?>',
                        end     : '<?php echo date_i18n('Y-m-d H:i', strtotime($_dates['end'])); ?>',
                        title   : '<?php the_title(); ?>',
                        url     : '<?php the_permalink(); ?>',
                        class   : '',
                        color   : '<?php echo ihk_get_event_category_color($post_id); ?>',
                        data    : {}
                    },
                    <?php
                } else {


                    if(strtotime($now) < strtotime($_dates[$event_expire_on]) ){
                    ?>
                {
                        start   : '<?php echo date_i18n('Y-m-d H:i', strtotime($_dates['start'])); ?>',
                        end     : '<?php echo date_i18n('Y-m-d H:i', strtotime($_dates['end'])); ?>',
                        title   : '<?php the_title(); ?>',
                        url     : '<?php the_permalink(); ?>',
                        class   : '',
                        color   : '<?php echo ihk_get_event_category_color($post_id); ?>',
                        data    : {}
                    },
                    <?php
                    }
                }
                }
                }
                $i++;
                    wp_reset_postdata(); 
                ?>
            ];

            let monthClass = '';
            const updateMonthClass = (target, month) => {
                target.removeClass(monthClass);
                monthClass = 'ihk-' + month.format('MMM').toLowerCase();
                target.addClass(monthClass);
            };

            const onLoadEnd = (data) => {
                updateMonthClass(data.target, data.activeMonth);
            };

            jQuery('.event-calendar').equinox({
                events: myEvents,
                onLoadEnd: onLoadEnd,
            });
        });
    </script>
<?php
}

remove_action('mep_event_list_date_li', 'mep_event_list_upcoming_date_li');
add_action('mep_event_list_date_li', 'ihk_mep_event_list_upcoming_date_li', 10, 2);
function ihk_mep_event_list_upcoming_date_li($event_id, $type = 'grid') {
    $event_date_icon = mep_get_option('mep_event_date_icon', 'icon_setting_sec', 'far fa-calendar');
    $hide_only_end_time_list = mep_get_option('mep_event_hide_end_time_list', 'event_list_setting_sec', 'no');
    $event_start_datetime = get_post_meta($event_id, 'event_start_datetime', true);
    $event_end_datetime = get_post_meta($event_id, 'event_end_datetime', true);
    $event_multidate = get_post_meta($event_id, 'mep_event_more_date', true) ? get_post_meta($event_id, 'mep_event_more_date', true) : [];
    $event_std[] = array(
        'event_std' => $event_start_datetime,
        'event_etd' => $event_end_datetime
    );
    $a = 1;
    if (sizeof($event_multidate) > 0) {
        foreach ($event_multidate as $event_mdt) {
            $event_std[$a]['event_std'] = $event_mdt['event_more_start_date'] . ' ' . $event_mdt['event_more_start_time'];
            $event_std[$a]['event_etd'] = $event_mdt['event_more_end_date'] . ' ' . $event_mdt['event_more_end_time'];
            $a++;
        }
    }
    $cn = 0;
    // custom variables
    $isPublic = has_term('public-events', 'mep_cat', $event_id);
    $dashpage = get_query_var('ihkdash');
    $isEvent = $dashpage == 'ihk-events';

    foreach ($event_std as $_event_std) {
        // print_r($_event_std);
        $std = $_event_std['event_std'];
        $start_date = date('Y-m-d', strtotime($_event_std['event_std']));
        $end_date = date('Y-m-d', strtotime($_event_std['event_etd']));
        if (strtotime(current_time('Y-m-d H:i')) < strtotime($std) && $cn == 0) {
            if ($type == 'grid') { ?>
                <?php
                // Public Event
                if ( $isPublic ) : ?>
                <li class="mep_list_event_date">
                    <div class="evl-ico"><i class="<?php echo $event_date_icon; ?>"></i></div>
                    <div class="evl-cc">
                        <h5>
                            <?php echo date('F j, Y', strtotime($_event_std['event_std'])); ?>
                        </h5>
                        <h5><?php
                            if ($hide_only_end_time_list == 'no') { ?> - <?php 
                                if ($start_date == $end_date) {
                                    echo get_mep_datetime($_event_std['event_etd'], 'time');
                                } else {
                                    echo date('F j, Y', strtotime($_event_std['event_etd']));
                                }
                            } ?></h5>
                    </div>
                </li>
                <?php
                elseif ($isEvent) :
                    $weekdays        = get_field('weekday', $event_id);
                    $time_format    = mep_get_datetime_format($event_id,'time');
                    if ( !empty($weekdays) ) :
                        if ( isset($weekdays[1]) || $event_multidate ) {
                            // make each day plural
                            foreach ($weekdays as $key => $day) {
                                $weekdays[$key] = $day . 's';
                            }
                        }
                ?>
                <li class="mep_list_event_weekday ihk-weekday">
                    <div class="evl-ico"><i class="far fa-calendar"></i></div>
                    <div class="evl-cc">
                        <h5><?php echo implode(' & ', $weekdays); ?></h5>
                    </div>
                </li>
                <?php
                    endif; // $weekdays
                ?>
                <li class="mep_list_event_time">
                    <div class="evl-ico"><i class="far fa-clock"></i></div>
                    <div class="evl-cc">
                        <h5><?php
                        $start_meridian = date('a', strtotime($_event_std['event_std']));
                        $end_meridian = date('a', strtotime($_event_std['event_etd']));
                        $match_meridians = $start_meridian == $end_meridian;
                        echo date('g:i', strtotime($_event_std['event_std']));
                            if ( !$match_meridians ) {
                                echo $start_meridian;
                            }
                            if ($hide_only_end_time_list == 'no') { ?> - <?php
                                echo date('g:i a', strtotime($_event_std['event_etd']));
                            }
                        ?></h5>
                    </div>
                </li>
                <?php
                else :
                    $weekdays        = get_field('weekday', $event_id);
                    $time_format    = mep_get_datetime_format($event_id,'time');
                    if ( !empty($weekdays) ) :
                        if ( isset($weekdays[1]) || $event_multidate ) {
                            // make each day plural
                            foreach ($weekdays as $key => $day) {
                                $weekdays[$key] = $day . 's';
                            }
                        }
                ?>
                <li class="mep_list_event_weekday">
                    <div class="evl-ico"><i class="fas fa-calendar"></i></div>
                    <div class="evl-cc">
                        <h5><?php echo implode(' & ', $weekdays); ?></h5>
                    </div>
                </li>
                <?php
                    endif; // $weekdays
                ?>
                <li class="mep_list_event_time">
                    <div class="evl-ico"><i class="fas fa-clock"></i></div>
                    <div class="evl-cc">
                        <h5><?php
                        $start_meridian = date('a', strtotime($_event_std['event_std']));
                        $end_meridian = date('a', strtotime($_event_std['event_etd']));
                        $match_meridians = $start_meridian == $end_meridian;
                        echo date('g:i', strtotime($_event_std['event_std']));
                            if ( !$match_meridians ) {
                                echo $start_meridian;
                            }
                            if ($hide_only_end_time_list == 'no') { ?> - <?php
                                echo date('g:i a', strtotime($_event_std['event_etd']));
                            }
                        ?></h5>
                    </div>
                </li>
                <?php
                // END Public/Private
                endif;
                ?>
            <?php
            } elseif ($type == 'minimal') {
            ?>
                <span class='mep_minimal_list_date'><i class="<?php echo $event_date_icon; ?>"></i> <?php echo get_mep_datetime($std, 'date-text') . ' ';
                    echo get_mep_datetime($_event_std['event_std'], 'time');
                    if ($hide_only_end_time_list == 'no') { ?> - <?php if ($start_date == $end_date) {
                        echo get_mep_datetime($_event_std['event_etd'], 'time');
                    } else {
                        echo get_mep_datetime($_event_std['event_etd'], 'date-time-text');
                    }
                    } ?></span>
            <?php
            }

            $cn++;
        }
    }
}