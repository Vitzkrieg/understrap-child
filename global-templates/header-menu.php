<div id="header-menu-container">
    <!-- Header menu goes here -->
    <?php
    wp_nav_menu(
        array(
            'theme_location'  => 'header',
            'container_class' => 'navbar navbar-expand container-fluid',
            'container_id'    => 'navbarNavHeader',
            'menu_class'      => 'navbar-nav ml-auto justify-content-end',
            'fallback_cb'     => '',
            'menu_id'         => 'header-menu',
            'depth'           => 1,
            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
        )
    );
    ?>
</div>