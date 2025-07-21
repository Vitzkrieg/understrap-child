<?php
/**
 * List Events
 */
add_action('ihk_dashboard_content_events', 'ihk_list_user_events');

function ihk_list_user_events() {
    ob_start();

    $default_status      = apply_filters( 'ihk_default_order_status', array( 'processing', 'completed' ) );
    $_user_set_status    = mep_get_option( 'seat_reserved_order_status', 'general_setting_sec', $default_status  );
    $_order_status       = ! empty( $_user_set_status ) ? $_user_set_status : $default_status ;
    $order_status        = array_values( $_order_status );
    $order_status_filter = array(
        'key'     => 'ea_order_status',
        'value'   => $order_status,
        'compare' => 'OR'
    );
    $args_search_qqq     = array(
        'post_type'      => array( 'mep_events_attendees' ),
        'posts_per_page' => - 1,
        'meta_query'     => array(
            $order_status_filter
        ),
    );

    // Limit to customers if not admin
    if ( !current_user_can( 'manage_options' )) {
        $args_search_qqq['author__in'] = array( get_current_user_id() );
    }

    $loop               = new WP_Query( $args_search_qqq );

    $event_count = 0;
    $event_times = array();
    $event_ids = array();
    
    foreach ( $loop->posts as $attendee_id ) {
        $event_id   = get_post_meta( $attendee_id->ID, 'ea_event_id', true );
        $start_time = get_post_meta($event_id, 'event_start_datetime', true) ?: Date.now(); //$event_meta['event_start_time'][0];
        $start_time = (int)preg_replace('/(\s|:|-)/', '', $start_time);
        if ( !in_array($start_time, $event_ids) ) {
            $event_ids[$start_time]    = $event_id;
            $event_count++;
        }
    }

    // order oldest to newest
    $event_ids = array_reverse($event_ids);

    $current_event_ids      = array();
    $past_event_ids         = array();
    $future_event_ids       = array();

    $current_count          = 0;
    $past_count             = 0;
    $future_count           = 0;

    foreach ( $event_ids as $start_time => $event_id ) {
        $date = get_post_meta($event_id, 'event_start_datetime', true);
        if ( empty($date) ) {
            continue;
        }
        $date = date('Y-m-d', strtotime($date));
        if ( $date > current_time('Y-m-d') ) {
            // future
            $future_event_ids[$start_time] = $event_id;
            $future_count++;
        } elseif ( ihk_get_event_has_expired($event_id) ) {
            // past
            $past_event_ids[$start_time] = $event_id;
            $past_count++;
        } else {
            // current
            $current_event_ids[$start_time] = $event_id;
            $current_count++;
        }
    }

    $params = array(
        "cat"               => "0",
        "org"               => "0",
        "style"             => "ihk-events",
        "column"            => 3,
        "cat-filter"        => "no",
        "org-filter"        => "no",
        "show"              => "-1",
        "pagination"        => "yes",
        "pagination-style"  => "load_more",
        "city"              => "",
        "country"           => "",
        "carousal-nav"      => "no",
        "carousal-dots"     => "yes",
        "carousal-id"       => "7777777",
        "timeline-mode"     => "vertical",
        'sort'              => 'ASC',
        'status'            => 'upcoming',
        'search-filter'     => '',
        'title-filter'      => 'no',
        'category-filter'   => 'no',
        'organizer-filter'  => 'no',
        'city-filter'       => 'no',
        'date-filter'       => 'no'
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
    $status         = $params['status'];

    $filter = $params['search-filter'];
    $show = ($filter == 'yes' || $pagination == 'yes' && $style != 'timeline') ? -1 : $show;
    $main_div       = $pagination == 'carousal' ? '<div class="mage_grid_box owl-theme owl-carousel"  id="mep-carousel' . $cid . '">' : '<div class="mage_grid_box">';

    $time_line_div_start    = $style == 'timeline' ? '<div class="timeline"><div class="timeline__wrap"><div class="timeline__items">' : '';
    $time_line_div_end      = $style == 'timeline' ? '</div></div></div>' : '';

    $flex_column    = $column;
    $mage_div_count = 0;
    $event_expire_on = mep_get_option('mep_event_expire_on_datetimes', 'general_setting_sec', 'event_start_datetime');
    $unq_id_base = 'dec'.uniqid();

    $show = true;

?>
<nav class="nav nav-tabs" id="nav-tab" role="tablist">
  <a class="nav-link active" id="nav-current-tab" data-bs-toggle="tab" href="#nav-current" role="tab" aria-controls="nav-current" aria-selected="true">Current<span class="badge bg-secondary"><?php echo $current_count; ?></span></a>
  <a class="nav-link" id="nav-future-tab" data-bs-toggle="tab" href="#nav-future" role="tab" aria-controls="nav-future" aria-selected="false">Future<span class="badge bg-secondary"><?php echo $future_count; ?></span></a>
  <a class="nav-link" id="nav-past-tab" data-bs-toggle="tab" href="#nav-past" role="tab" aria-controls="nav-past" aria-selected="false">Past<span class="badge bg-secondary"><?php echo $past_count; ?></span></a>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active py-5" id="nav-current" role="tabpanel" aria-labelledby="nav-current-tab">
    <?php
    $unq_id = $unq_id_base . 'current';
     if ( empty($current_event_ids) ) {
         echo '<p class="no-events">No current events found.</p>';
     } else {
        $event_ids = $current_event_ids;
        include( 'dashboard-events-list.php' );
     }
    ?>
  </div>
  <div class="tab-pane fade py-5" id="nav-future" role="tabpanel" aria-labelledby="nav-future-tab">
    <?php
    $unq_id = $unq_id_base . 'future';
     if ( empty($future_event_ids) ) {
         echo '<p class="no-events">No future events found.</p>';
     } else {
        $event_ids = $future_event_ids;
        include( 'dashboard-events-list.php' );
     }
    ?>
  </div>
  <div class="tab-pane fade py-5" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
    <?php
    $unq_id = $unq_id_base . 'past';
     if ( empty($past_event_ids) ) {
         echo '<p class="no-events">No past events found.</p>';
     } else {
        $event_ids = $past_event_ids;
        include( 'dashboard-events-list.php' );
     }
    ?>
  </div>
</div>
<?php
    $content = ob_get_clean();
    echo $content;
}