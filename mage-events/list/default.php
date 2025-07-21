<?php
$day                            = mep_get_event_upcomming_date($event_id, 'day'); 
$month                          = mep_get_event_upcomming_date($event_id, 'month-name'); 
$recurring                      = get_post_meta($event_id, 'mep_enable_recurring', true) ? get_post_meta($event_id, 'mep_enable_recurring', true) : 'no';
$mep_hide_event_hover_btn       = mep_get_option('mep_hide_event_hover_btn', 'event_list_setting_sec', 'no');
$mep_hide_event_hover_btn_text  = mep_get_option('mep_hide_event_hover_btn_text', 'general_setting_sec', __('Book Now','mage-eventpress'));
$sold_out_ribbon                = mep_get_option('mep_show_sold_out_ribbon_list_page', 'general_setting_sec', 'no');
$taxonomy_category              = MPWEM_Helper::all_taxonomy_as_text($event_id, 'mep_cat');
$taxonomy_organizer             = MPWEM_Helper::all_taxonomy_as_text($event_id, 'mep_org');
$date                           = get_post_meta($event_id, 'event_upcoming_datetime', true);
$event_location_icon            = mep_get_option('mep_event_location_icon', 'icon_setting_sec', 'fas fa-map-marker-alt');
$event_organizer_icon           = mep_get_option('mep_event_organizer_icon', 'icon_setting_sec', 'far fa-list-alt');
$cat_color                      = ihk_get_event_category_color($event_id);
$external_event                 = get_field('external_event', $event_id);

$dashpage = get_query_var('ihkdash');
$is_ihkdash = !empty($dashpage);
$isDashEvent = $dashpage == 'ihk-events';

debug_log(array(
    'event_id' => $event_id,
    'date' => $date,
    'end_date' => get_post_meta($event_id, 'event_end_datetime', true),
    'now' => current_time('Y-m-d'),
));

/*
 * override is on IHK Dashboard
 */
$event_multidate = $is_ihkdash ? false : $event_multidate;
$show_price = !$show_price  && $show_price;

global $event_index;
if ( ! isset($event_index) ) {
    $event_index = 1;
} else {
    $event_index++;
}

$event_index = 'event-index-' . $event_index;
$event_index_class = '.' . $event_index;
?>
<style>
    .mep-default-sidrbar-events-schedule <?php echo $event_index_class; ?> h3 i,
    /* .mep_event_list <?php echo $event_index_class; ?> .mep_list_date, */
    .mep-event-theme-1 <?php echo $event_index_class; ?> .mep-social-share li a,
    .mep-template-2-hamza <?php echo $event_index_class; ?> .mep-social-share li a,
    .mep-default-sidrbar-meta <?php echo $event_index_class; ?> .fa-list-alt,
    <?php echo $event_index_class; ?> .mep-list-footer ul li i
    {
        color: <?php echo $cat_color; ?>;
    }
    .mep_event_list_item<?php echo $event_index_class; ?> .mep-list-header:before,
    .mep_event_grid_item<?php echo $event_index_class; ?> .mep-list-header:before
    {
        border-color: <?php echo $cat_color; ?>;
    }
    <?php echo $event_index_class; ?> .mep_more_date_btn,
    <?php echo $event_index_class; ?> .mep_more_date_btn:before,
    <?php echo $event_index_class; ?> .mep-day,
    .mep-default-feature-cart-sec <?php echo $event_index_class; ?> h3,
    .mep-event-theme-1 <?php echo $event_index_class; ?> h3.ex-sec-title,
    <?php echo $event_index_class; ?> .mep-tem3-mid-sec h3.ex-sec-title,
    <?php echo $event_index_class; ?> .mep-tem3-title-sec,
    .royal_theme <?php echo $event_index_class; ?> h3.ex-sec-title,
    .mep-events-wrapper .royal_theme <?php echo $event_index_class; ?> table.mep_event_add_cart_table,
    .vanilla_theme.mep-default-theme <?php echo $event_index_class; ?> div.mep-default-feature-date,
    .vanilla_theme.mep-default-theme <?php echo $event_index_class; ?> div.mep-default-feature-time,
    .vanilla_theme.mep-default-theme <?php echo $event_index_class; ?> div.mep-default-feature-location,
    .vanilla_theme <?php echo $event_index_class; ?> h3.ex-sec-title,
    .vanilla_theme <?php echo $event_index_class; ?> div.df-dtl h3,
    .vanilla_theme <?php echo $event_index_class; ?> div.df-dtl p,
    <?php echo $event_index_class; ?> .ex-sec-title,
    <?php echo $event_index_class; ?> .mep_everyday_date_secs {
        background-color: <?php echo $cat_color; ?>;
        border-color: <?php echo $cat_color; ?>;
    }
    <?php echo $event_index_class; ?> .mep_list_details--tickets a {
        background-color: <?php echo $cat_color; ?>;
    }
    <?php echo $event_index_class; ?> .mep_list_details--reserve a {
        background-color: <?php echo $cat_color; ?>;
    }
</style>
<?php
$eventClasses = array(
    'filter_item',
    'mep-event-list-loop',
    $event_index,
    esc_attr($columnNumber),
    esc_attr($class_name),
    'mep_event_' . esc_attr($style) . '_item',
    'mix',
    esc_attr($org_class) . ' ' . esc_attr($cat_class),
);
?>
<div class='<?php echo join(' ', $eventClasses); ?>' data-title="<?php echo esc_attr(get_the_title($event_id)); ?>" data-city-name="<?php echo esc_attr(get_post_meta($event_id, 'mep_city', true)); ?>" data-category="<?php echo esc_attr($taxonomy_category); ?>" data-organizer="<?php echo esc_attr($taxonomy_organizer); ?>" data-date="<?php echo esc_attr(date('m/d/Y',strtotime($date))); ?>" style="width:calc(<?php echo esc_attr($width); ?>% - 14px);">
    <?php do_action('mep_event_list_loop_header', $event_id); ?>
    <div class="mep_list_thumb">
        <?php if ( !$isDashEvent) { ?>
        <a href="<?php echo esc_url(get_the_permalink()); ?>">
        <?php } else { ?>
            <div class="mep-list-header">
                <h2 class='mep_list_title'><?php echo esc_attr(get_the_title($event_id)); ?></h2>
            </div>
            <span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span>
        <?php } ?>
            <div class="mep_bg_thumb" data-bg-image="<?php ihk_get_list_thumbnail_src($event_id, 'large'); ?>"></div>
        <?php if ( !$isDashEvent) { ?>
        </a>
        <?php } ?>
        <?php
        if ( !$is_ihkdash ) {
        ?>
            <div class="mep-ev-start-date">
                <div class="mep-day"><?php echo esc_html(apply_filters('mep_event_list_only_day_number', $day, $event_id)); ?></div>
                <div class="mep-month"><?php echo esc_html(apply_filters('mep_event_list_only_month_name', $month, $event_id)); ?></div>
            </div>

        <?php
        }

        if (is_array($event_multidate) && sizeof($event_multidate) > 0 && $recurring == 'no') { ?>

            <div class='mep-multidate-ribbon mep-tem3-title-sec'>
                <span><?php echo mep_get_option('mep_event_multidate_ribon_text', 'label_setting_sec', __('Multi Date Event', 'mage-eventpress')); ?></span>
            </div>

        <?php } elseif ($recurring != 'no') {  ?>

            <div class='mep-multidate-ribbon mep-tem3-title-sec'>
                <span><?php echo mep_get_option('mep_event_recurring_ribon_text', 'label_setting_sec', __('Recurring Event', 'mage-eventpress')); ?></span>
            </div>

        <?php  }  if ($event_type == 'online') { ?>

            <div class='mep-eventtype-ribbon mep-tem3-title-sec'>
                <span><?php echo mep_get_option('mep_event_virtual_label', 'label_setting_sec', __('Virtual Event', 'mage-eventpress')); ?></span>
            </div>

        <?php } if($sold_out_ribbon == 'yes' && $total_left <= 0 && !$external_event) {  ?>

            <div class="mep-eventtype-ribbon mep-tem3-title-sec sold-out-ribbon"><?php echo mep_get_option('mep_event_sold_out_label', 'label_setting_sec', __('Sold Out', 'mage-eventpress')); ?></div>
        
        <?php } ?>        
    </div>
    <div class="mep_list_event_details">
        <?php if ( !$isDashEvent) { ?>
        <a href="<?php the_permalink(); ?>">
        <?php } ?>
            <?php if ( !$isDashEvent) { ?>
            <div class="mep-list-header">
                <h2 class='mep_list_title'><?php echo esc_attr(get_the_title($event_id)); ?></h2>
                <?php if ($available_seat == 0) {
                    do_action('mep_show_waitlist_label');
                } ?>
                <?php if ($show_price == 'yes' && !$external_event) { ?>
                    <h3 class='mep_list_date'>
                    <?php
                        echo esc_html($show_price_label). " " . mep_event_list_price($event_id);
                    ?>
                    </h3>
                <?php
                }
                ?>
            </div>
            <?php } ?>
            <?php
            if ($style == 'list') {
                ?>
                <div class="mep-event-excerpt">
                    <?php the_excerpt(); ?>
                </div>
            <?php } ?>

            <div class="mep-list-footer">
                <ul>
                    <?php
                    if ($hide_org_list == 'no') {
                        if (sizeof($author_terms) > 0) {
                            ?>
                            <li class="mep_list_org_name">
                                <div class="evl-ico"><i class="<?php echo esc_attr($event_organizer_icon); ?>"></i></div>
                                <div class="evl-cc">
                                    <h5>
                                        <?php echo mep_get_option('mep_organized_by_text', 'label_setting_sec', __('Organized By:', 'mage-eventpress')); ?>
                                    </h5>
                                    <h6><?php echo esc_html($author_terms[0]->name); ?></h6>
                                </div>
                            </li>
                        <?php }
                    }
                    if ($event_type != 'online') {
                        if ($hide_location_list == 'no') { ?>

                            <li class="mep_list_location_name">
                                <div class="evl-ico"><i class="<?php echo esc_attr($event_location_icon); ?>"></i></div>
                                <div class="evl-cc">
                                    <?php
                                    if ( !$isDashEvent ) { ?>
                                    <h5>
                                        <?php echo mep_get_option('mep_location_text', 'label_setting_sec', __('Location:', 'mage-eventpress')); ?>
                                    </h5>
                                    <?php
                                    } ?>
                                    <h6><?php mep_get_event_city($event_id); ?></h6>
                                </div>
                            </li>
                        <?php }
                    }
                    if ($hide_time_list == 'no') {
                        if ($recurring == 'no') {
                            do_action('mep_event_list_date_li', $event_id, 'grid');
                        } else {
                            do_action('mep_event_list_upcoming_date_li', $event_id);
                        }
                    } ?>

                </ul>
        
        <?php if ( !$isDashEvent) { ?>
        </a>
        <?php } ?>
        <?php do_action('mep_event_list_loop_footer', $event_id); ?>
        <?php 
        if ( !$is_ihkdash) {
            if ( $external_event ) { 
                echo ihk_get_ticket_link($event_id);
            } else {
                echo ihk_get_reserve_link($event_id);
            }
        } else {
            // shows individual dates/times
            mep_date_in_default_theme($event_id, false);
        }
        ?>
    </div>
    <?php if ('yes' == $mep_hide_event_hover_btn) { ?>
        <div class="item_hover_effect">
            <a href="<?php echo esc_url(get_the_permalink($event_id)); ?>"><?php echo esc_html($mep_hide_event_hover_btn_text); ?></a>
        </div>
    <?php } ?>
</div>