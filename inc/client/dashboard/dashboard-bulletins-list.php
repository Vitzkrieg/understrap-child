<?php

add_action('ihk_dashboard_bulletins_list', 'ihk_list_user_bulletins');

function ihk_list_user_bulletins() {
    ob_start();

    $order_status_filter    = array(
        'key'     => 'ea_order_status',
        'value'   => array( 'processing', 'completed' ),
        'compare' => 'OR'
    );
    $attendees_search       = array(
        'post_type'         => array( 'mep_events_attendees' ),
        'posts_per_page'    => - 1,
        'meta_query'        => array(
            $order_status_filter
        ),
        'fields'            => 'ids', // only get post IDs
    );

    // Limit to customers if not admin
    if ( !current_user_can( 'manage_options' )) {
        $attendees_search['author__in'] = array( get_current_user_id() );
    }
    
    $loop               = new WP_Query( $attendees_search );

    $event_ids          = [];
    $event_bulletins    = [];

    foreach ( $loop->posts as $attendee_id ) {
        $event_id                   = get_post_meta( $attendee_id, 'ea_event_id', true );

        if ( empty( $event_id ) || !is_numeric( $event_id ) ) {
            continue;
        }
        // skip if already added
        if ( in_array( $event_id, $event_ids ) ) {
            continue;
        }
        $event_ids[]                = $event_id;
        $event_bulletins[$event_id] = [];
    }

    $bulletins_filter = [];
    array_walk($event_ids, function($event_id) use (&$bulletins_filter) {
        $bulletins_filter[] = "pm.meta_value LIKE '%:\"{$event_id}\";%'"; // set filter for each event ID
    });
    $bulletins_filter = join(' OR ', $bulletins_filter);

    if ( !empty($bulletins_filter) ) {
        $bulletins_filter = "({$bulletins_filter})";
    } else {
        $bulletins_filter = "1=0"; // no events found, so no bulletins
    }

    global $wpdb;
    $bulletins_sql = "SELECT DISTINCT p.*, pm.meta_value FROM {$wpdb->posts} AS p
        INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
        WHERE p.post_type = 'bulletins'
        AND p.post_status = 'publish'
        AND pm.meta_key = 'linked_post'
        AND ({$bulletins_filter})
        ORDER BY p.menu_order DESC, p.post_date DESC";
    $bulletins = $wpdb->get_results($bulletins_sql, OBJECT);

    $parent_bulletins   = [];
    $lp_id              = null;

    foreach ($bulletins as $bulletin) {
        $post_id = $bulletin->ID;
        // validate post is published
        if ( $bulletin->post_status != 'publish' ) {
            continue;
        }

        $pid = $bulletin->post_parent ?: $bulletin->ID;
        $linked_post = unserialize($bulletin->meta_value);
        $lp_id = $linked_post[0] ?? null;
        // only use parent bulletin for title and link
        if ( empty($bulletin->post_parent) ) {
            $parent_bulletins[$lp_id] = $bulletin;
            continue;
        }

        $menu_order = $bulletin->menu_order ?: 0;

        // make sure arrays are set
        if ( !isset($event_bulletins[$lp_id]) ) {
            $event_bulletins[$lp_id] = [];
        }

        // assign post to post type array
        $event_bulletins[$lp_id][$menu_order] = $bulletin;
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

    $flex_column    = $column;
    $mage_div_count = 0;
    $event_expire_on = mep_get_option('mep_event_expire_on_datetimes', 'general_setting_sec', 'event_start_datetime');
    $unq_id = 'dbl'.uniqid();

    // list bulletins by event
    foreach ($event_ids as $event_id) {
        $posts_array = $event_bulletins[$event_id] ?? [];

        if ( empty($posts_array) ) {
            continue;
        }

        $parent_bulletins[$event_id];
        $event_link = get_permalink($parent_bulletins[$event_id]);
?>
<div class="bulletins-list mep_event_list">
    <div class="row"><?php
        $section_title = '<a href="' . $event_link . '" class="bulletin-title-link">' . get_the_title($event_id) . '</a>';
        $post_type = "bulletins";

        include(locate_template( 'template-parts/posts/slider.php' ));
        ?>
    </div>
</div>
<?php
    }

    $content = ob_get_clean();
    echo html_entity_decode( $content );
  
}
