<?php

function register_custom_widget_area() {
    register_sidebar(
        array(
        'id' => 'header-menu-widget',
        'name' => esc_html__( 'My new widget area', 'theme-domain' ),
        'description' => esc_html__( 'A new widget area made for testing purposes', 'theme-domain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title-holder"><h3 class="widget-title">',
        'after_title' => '</h3></div>'
        )
    );
}
add_action( 'widgets_init', 'register_custom_widget_area' );