<?php
    // $dateFormat = ($isDashEvent) ? 'm/d/y' : 'F j, Y g:i a';
    $dateFormat = 'm/d/y';
?>
<?php $event_date_icon = mep_get_option('mep_event_date_icon', 'icon_setting_sec', 'fa fa-calendar'); ?>
<li>
    <?php do_action('mep_single_before_event_date_list_item',$event_id,$start_datetime); ?>    
    <span class="mep-more-date">
        <i class="<?php echo $event_date_icon; ?>"></i>
        <span class='mep_date_scdl_start_datetime'>
            <?php echo date($dateFormat , strtotime($start_datetime)); ?>
        </span>
        <?php if ($end_date_display_status == 'yes') { ?>
            <span class='mep_date_scdl_end_datetime'>
                 &nbsp;<span class="mep_date_scdl_separator"> - </span>&nbsp;
                <?php
                if ($start_date != $end_date) {
                    echo date('F j, Y', strtotime($end_datetime));
                }
                echo ' ' . date('g:i a', strtotime($end_datetime));
                ?>
            </span>
        <?php
        } ?>
    </span>
    <?php do_action('mep_single_after_event_date_list_item',$event_id,$start_datetime); ?>  
</li>