<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

extract($args);

if (! isset($custom_header->url) ) {
    exit;
}

$header_show_title = get_theme_mod( "inharmony_header_show_title", false );
$header_show_tagline = get_theme_mod( "inharmony_header_show_tagline", false );

?>

<div id="site-header"  class="d-flex align-content-center justify-content-center" 
style="background-image: url('<?php echo $custom_header->url; ?>'); background-repeat: no-repeat; background-size: cover; width: 2000px; height: 100vh; max-height: 800px; max-width: 100%;">
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
</div>