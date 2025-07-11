<?php
/**
 * Understrap Child Theme widget areas
 *
 * @package UnderstrapChild
 */


/**
 * Function overrides the parent theme's widget areas.
 */

function understrap_widget_classes( $params ) {

    global $sidebars_widgets;

    /*
        * When the corresponding filter is evaluated on the front end
        * this takes into account that there might have been made other changes.
        */
    $sidebars_widgets_count = apply_filters( 'sidebars_widgets', $sidebars_widgets );

    // Only apply changes if sidebar ID is set and the widget's classes depend on the number of widgets in the sidebar.
    if ( isset( $params[0]['id'] ) && strpos( $params[0]['before_widget'], 'dynamic-classes' ) ) {
        $sidebar_id   = $params[0]['id'];

        $widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );

        $widget_classes = 'widget-count-' . $widget_count;

        if ($sidebar_id == 'footerfull') {
            // Get theme mod layout for footer full widget area.
            $footer_layout = get_theme_mod( 'inharmony_footer_widget_layout_direction', 'row' );
            if ( 'column' === $footer_layout ) {
                // If the footer full widget area is set to columns, use 'col-md-3' for each widget.
                $widget_classes = 'col-md-12';

                // Replace the placeholder class 'dynamic-classes' with the classes stored in $widget_classes.
                $params[0]['before_widget'] = str_replace( 'dynamic-classes', $widget_classes, $params[0]['before_widget'] );
                return $params;
            }
        }
        
        if ( 0 === $widget_count % 4 || $widget_count > 6 ) {
            // Four widgets per row if there are exactly four or more than six widgets.
            $widget_classes .= ' col-md-3';
        } elseif ( 6 === $widget_count ) {
            // If exactly six widgets are published.
            $widget_classes .= ' col-md-2';
        } elseif ( $widget_count >= 3 ) {
            // Three widgets per row if there's three or more widgets.
            $widget_classes .= ' col-md-4';
        } elseif ( 2 === $widget_count ) {
            // If two widgets are published.
            $widget_classes .= ' col-md-6';
        } elseif ( 1 === $widget_count ) {
            // If just on widget is active.
            $widget_classes .= ' col-md-12';
        }

        // Replace the placeholder class 'dynamic-classes' with the classes stored in $widget_classes.
        $params[0]['before_widget'] = str_replace( 'dynamic-classes', $widget_classes, $params[0]['before_widget'] );
    }

    return $params;

}

// Import parent widgets settings
require get_parent_theme_file_path( '/inc/widgets.php' );



function register_custom_widget_area() {
    register_sidebar(
        array(
        'id' => 'header-menu',
        'name' => esc_html__( 'Header Menu', 'inharmony' ),
        'description' => esc_html__( 'Displays in the header menu at the top of the site.', 'inharmony' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
        'after_title' => '</h3></div>'
        )
    );

    register_sidebar(
        array(
        'id' => 'header-widget',
        'name' => esc_html__( 'Header Widget', 'inharmony' ),
        'description' => esc_html__( 'Displays in the header widget area.', 'inharmony' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
        'after_title' => '</h3></div>'
        )
    );

    register_sidebar(
        array(
        'id' => 'home-widget',
        'name' => esc_html__( 'Home Widget', 'inharmony' ),
        'description' => esc_html__( 'Displays in the home widget area.', 'inharmony' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
        'after_title' => '</h3></div>'
        )
    );
}
add_action( 'widgets_init', 'register_custom_widget_area' );

