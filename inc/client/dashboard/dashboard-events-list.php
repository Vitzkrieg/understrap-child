<?php

/**
 * This is the hook where Event List Header fired from inc/template-parts/event_list_header.php File
 */
do_action('mep_event_list_header', $params, $event_count, $unq_id);
?>
<div class="list_with_filter_section mep_event_list">
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
        echo $main_div_end;
        ?>
</div><!-- .mep_event_list_sec -->
<?php
do_action('mpwem_pagination',$params,$total_item);

do_action('mep_event_list_footer', $params, $event_count, $unq_id);
$content = ob_get_clean();
echo html_entity_decode( $content );