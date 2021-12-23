<div id="header-menu-container">
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