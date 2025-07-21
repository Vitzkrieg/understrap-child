<?php
$event_type = get_post_meta(get_the_id(), 'mep_event_type', true) ? get_post_meta(get_the_id(), 'mep_event_type', true) : 'offline';

$taxonomy_category = MPWEM_Helper::all_taxonomy_as_text($event_id, 'mep_cat');
$taxonomy_organizer = MPWEM_Helper::all_taxonomy_as_text($event_id, 'mep_org');
// $date = mep_get_event_upcomming_date($event_id, 'date');
$date = get_post_meta($event_id, 'event_upcoming_datetime', true);
$event_date_icon            = mep_get_option('mep_event_date_icon', 'icon_setting_sec', 'fa fa-calendar');
$event_time_icon            = mep_get_option('mep_event_time_icon', 'icon_setting_sec', 'fas fa-clock');
$event_location_icon        = mep_get_option('mep_event_location_icon', 'icon_setting_sec', 'fas fa-map-marker-alt');

$start_date = get_post_meta($event_id, 'event_start_datetime', true);
// $start_date = date('Y-m-d H:i:s', strtotime(get_post_meta($event_id, 'event_start_datetime', true)));
$end_date = get_post_meta($event_id, 'event_end_date', true);
// mep_get_event_upcomming_date($event_id, 'day');
// echo get_mep_datetime(get_post_meta($event_id,'event_upcoming_datetime',true),'day');

$month = date('M', strtotime($start_date));
$start_day = date('j', strtotime($start_date));
$end_day = date('j', strtotime($end_date));
$year = date('Y', strtotime($start_date));

?>
<div class='ihk-event-item filter_item mep-event-list-loop  mep_event_list_item mep_event_winter_list mix <?php echo esc_attr($org_class) . ' ' . esc_attr($cat_class); ?>'
     data-title="<?php echo esc_attr(get_the_title($event_id)); ?>"
     data-city-name="<?php echo esc_attr(get_post_meta($event_id, 'mep_city', true)); ?>"
     data-category="<?php echo esc_attr($taxonomy_category); ?>"
     data-organizer="<?php echo esc_attr($taxonomy_organizer); ?>"
     data-date="<?php echo esc_attr(date('m/d/Y',strtotime($date))); ?>"
>
    <?php do_action('mep_event_winter_list_loop_header', $event_id); ?>
    <div class="mep_list_date_wrapper">
        <i class="fas fa-caret-right"></i>
        <h4 class='mep_winter_list_date'>
            <span class="mep_winter_list_date mep_winter_list_month">
                <?php echo esc_html($month); ?>
            </span>
            <span class="mep_winter_list_date mep_winter_list_day">
                <?php echo esc_html($start_day . '-' . $end_day); ?>
            </span>
            <span class="mep_winter_list_date mep_winter_list_year">
                <?php echo esc_html($year); ?>
            </span>
        </h4>
    </div>
    <div class="mep_list_winter_thumb_wrapper">
        <a href="<?php echo get_the_permalink($event_id); ?>">
            <div class="mep_list_winter_thumb" data-bg-image="<?php ihk_get_list_thumbnail_src($event_id, 'full'); ?>"></div>
        </a>
    </div>
    <div class="mep_list_event_details">
        <h4 class="mep_list_title"><a href="<?php the_permalink(); ?>"><?php get_the_title($event_id); ?></a></h4>
        <div class="mep_list_details_col_wrapper">
            <div class="mep_list_details_col_one">
                <a href="<?php the_permalink(); ?>">
                    <span class='mep_winter_event_location'><i class="<?php echo esc_attr($event_location_icon); ?>"></i> <?php mep_get_event_city($event_id); ?></span>
                </a>
            </div>

            <div class="mep_list_details_col_two">
                <?php if ($event_type == 'online') { ?>
                    <div class='mep-eventtype-ribbon mep-tem3-title-sec'>
                        <span><?php echo mep_get_option('mep_event_virtual_label', 'label_setting_sec', __('Virtual Event', 'mage-eventpress')); ?></span>
                    </div>
                <?php } ?>
                <?php do_action('mep_event_list_loop_footer', $event_id); ?>
            </div>
        </div>
        <?php echo ihk_get_ticket_link($event_id); ?>
    </div>
    <?php do_action('mep_event_winter_list_loop_end', $event_id); ?>
</div>