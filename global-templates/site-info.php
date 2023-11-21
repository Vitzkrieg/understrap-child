<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$header_show_title = get_theme_mod( "inharmony_header_show_title", false );
$header_show_tagline = get_theme_mod( "inharmony_header_show_tagline", false );

?>
<?php if ( $header_show_title || $header_show_tagline ) : ?>
    <div id="site-info" class="d-flex flex-column align-content-center justify-content-center">
        <?php if ( $header_show_title ) : ?>
            <h1 class="header-title text-center"><?php bloginfo( 'name' ); ?></h1>
        <?php endif; ?>
        <?php if ( $header_show_tagline ) : ?>
            <div class="header-tagline text-center"><?php echo bloginfo( 'description' ); ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>