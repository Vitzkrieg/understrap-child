<?php
$event_location_list_icon = mep_get_option('mep_event_location_list_icon', 'icon_setting_sec', 'fa fa-arrow-circle-right');
?>
<ul>
    <?php if ($venue) { ?>
        <li>
            <i class="fa fa-arrow-circle-right"></i><span><?php do_action('mep_event_location_venue'); ?></span>
        </li>
    <?php } // $venue ?>
    <?php if ($street) { ?>
        <li class="align-start">
        <i class="fa fa-arrow-circle-right"></i><span><?php do_action('mep_event_location_street'); ?>
        <?php if($city) { ?>
        <br /><?php do_action('mep_event_location_city'); ?>, <?php do_action('mep_event_location_state'); ?></span>
        <?php } // $city ?>
    </li>
    <?php } // $street ?>
</ul>