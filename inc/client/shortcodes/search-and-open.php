<?php
/**
 * Template: displays header search, account, cart icons
 */
?><div class="search-and-open d-flex justify-content-around align-items-center">
    <?php debug_log(array(
        'show_search' => get_theme_mod('inharmony_header_search_button', false) ? 'true' : 'false',
        'show_cart' => get_theme_mod('inharmony_header_shopping_cart', false) ? 'true' : 'false',
        'is_woocommerce' => class_exists('WooCommerce') ? 'true' : 'false',
    )); ?>
    <?php if ( get_theme_mod('inharmony_header_search_button', false) ) { ?>
        <div class="search-link">
            <a href="javascript:void(0);" class="search-button" title="Open Search" rel="nofollow"><i class="la la-search"></i></a>
        </div>
    <?php } ?>
    <?php if ( class_exists('WooCommerce') ) {
        $title = "Login";
        $classes = array(
            'account-link',
            'cart-main',
            'menu-item',
        );
        $icon = 'fa-regular fa-user';
        $account_link = get_permalink( get_page_by_path( 'member-login' ) );
    ?>
        <div class="<?php echo implode(' ', $classes); ?>">
            <a href="<?php echo $account_link; ?>" class="my-account" title="<?php echo $title; ?>"><i class="<?php echo $icon; ?>"></i></a>
        </div>
        <?php if ( get_theme_mod('inharmony_header_shopping_cart', false) ) { ?>
        <div class="cart-main menu-item cart-contents">
            <a class="my-cart-link" href="<?php echo wc_get_cart_url(); ?>" title="<?php echo esc_attr_e( 'Shopping Cart', 'inharmonylife' ); ?>"><i class="la la-shopping-cart"></i>
                <span class="cart-contents-count"></span>
            </a>
        </div>
        <?php } ?>
    <?php } ?>
    <?php
        $nav_mobile_classes = array(
            'dropdown-menu',
            'd-none',
        );
        if ( is_ihk_dashboard_page() ) {
            $nav_mobile_classes = array_merge($nav_mobile_classes, ['d-lg-block']);
        }
    ?>
    <ul id="nav-mobile" class="<?php echo join(' ', $nav_mobile_classes); ?>">
        <?php
        if (is_ihk_dashboard_page()) {
            do_action( 'ihk_dashboard_navigation' );
        } elseif ( has_nav_menu('mobile_navigation') ){
            wp_nav_menu(array(
                'theme_location' => 'mobile_navigation',
                'container' => false,
                'menu_id' => 'nav-mobile',
                'items_wrap'=>'%3$s',
                'fallback_cb' => false,
                'walker' => new Malina_Mobile_Walker_Nav_Menu()
            ));
        } ?>
    </ul>
</div>