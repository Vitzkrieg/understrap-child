<?php
$container = get_theme_mod( 'understrap_container_type', 'container' );
$header_container = get_theme_mod( 'inharmony_header_container_type', $container );
if ( $header_container === 'container' ) {
    $header_container = 'container-lg';
} else {
    $header_container = 'container-fluid no-gutters';
}

$layout_mobile = get_theme_mod( 'inharmony_header_menu_layout_mobile' );
$layout_desktop = get_theme_mod( 'inharmony_header_menu_layout_desktop' );

$container_classes = array(
    $header_container,
    'd-flex',
    inharmony_get_bs_css_from_theme_mod($layout_mobile),
    inharmony_get_bs_css_from_theme_mod($layout_desktop, 'lg'),
);

$show_widgets = get_theme_mod( 'inharmony_header_show_widgets', 1 );
?>

<div id="header-menu-container" class="<?php echo join(' ', $container_classes); ?>">
    <!-- Header menu goes here -->
    <?php
    wp_nav_menu(
        array(
            'theme_location'  => 'header',
            'container_class' => 'navbar navbar-expand d-flex',
            'container_id'    => 'navbarNavHeader',
            'menu_class'      => 'navbar-nav',
            'fallback_cb'     => '',
            'menu_id'         => 'header-menu',
            'depth'           => 1,
            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
        )
    );
    ?>
    <?php if ($show_widgets &&  is_active_sidebar( 'header-menu' ) ) : ?>
    <aside class="widget-area header-menu-widget">
        <?php dynamic_sidebar( 'header-menu' ); ?>
    </aside><!-- .widget-area -->
    <?php endif; ?>
</div>