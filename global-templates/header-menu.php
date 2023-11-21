<?php
$container = get_theme_mod( 'understrap_container_type' );
$header_container = get_theme_mod( 'inharmony_header_container_type' );
if (! $header_container) {
	$header_container = $container;
}

$container_classes = array(
    'container' === $header_container ? 'container' : 'container-fluid',
    'flex-wrap',
);
?>

    <div id="header-menu-container" class="<?php echo join(' ', $container_classes); ?>">
    <!-- Header menu goes here -->
    <?php
    //TODO: make alignment/justify settings
    wp_nav_menu(
        array(
            'theme_location'  => 'header',
            'container_class' => 'navbar navbar-expand container-fluid ml-auto justify-content-center justify-content-lg-end',
            'container_id'    => 'navbarNavHeader',
            'menu_class'      => 'navbar-nav',
            'fallback_cb'     => '',
            'menu_id'         => 'header-menu',
            'depth'           => 1,
            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
        )
    );
    ?>
</div>