<?php

function register_custom_widget_area() {
    register_sidebar(
        array(
        'id' => 'header-menu',
        'name' => esc_html__( 'Header Menu', 'theme-domain' ),
        'description' => esc_html__( 'Displays in the header menu at the top of the site.', 'inharmony' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
        'after_title' => '</h3></div>'
        )
    );
}
add_action( 'widgets_init', 'register_custom_widget_area' );