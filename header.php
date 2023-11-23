<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
$header_container = get_theme_mod( 'inharmony_header_container_type' );
if (! $header_container) {
	$header_container = $container;
}

$custom_header = get_custom_header();
$header_placement = get_theme_mod( 'inharmony_header_placement', 'top' );
$has_header_image = isset($custom_header->url) && $custom_header->url != '';
$header_size = get_theme_mod( 'inharmony_header_image_size', 'cover' );
$header_height = get_theme_mod( 'inharmony_header_image_height', '800px' );

$logo_placement = get_theme_mod( 'inharmony_logo_placement', 'left' );
$menu_align = get_theme_mod( 'inharmony_menu_align' , 'center' );

$home_nav_style = '';
if ( is_front_page() && is_home() ) {
	$home_nav_style .=  ' d-' . get_theme_mod( 'inharmony_home_nav_display', 'block');
}

$home_hide_header = is_front_page() && get_theme_mod( 'inharmony_home_hide_header' );

$container_classes = array(
	'container' === $header_container ? 'container' : 'container-fluid',
	'flex-wrap',
	$header_placement == 'behind' ? 'site-header-image' : '',
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ($has_header_image) : ?>
	<style id="inharmony-site-header">
		.site-header-image {
			background-image: url(<?php echo $custom_header->url; ?>);
			background-size: <?php echo $header_size; ?>;
			<?php if ( !empty( $header_height ) ) : ?>
			height: 1000vh;
			max-height: <?php echo $header_height; ?>;
			<?php endif; ?>
		}
	</style>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">
<?php if ( !$home_hide_header ) : ?>
	<header>
<?php get_template_part( 'global-templates/header-menu' ); ?>
<?php
if ( $header_placement == "above" ) :
	get_template_part( 'global-templates/custom-header', null, array(
		'has_header_image' => $has_header_image,
	) );
endif;
?>
	<!-- ******************* The Navbar Area ******************* -->
		<div id="wrapper-navbar" class="<?php echo $home_nav_style; ?>">

			<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

			<nav id="main-nav" class="navbar navbar-expand-md navbar-light" aria-labelledby="main-nav-label">

				<h2 id="main-nav-label" class="sr-only">
					<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
				</h2>

				<div class="<?php echo join(' ', $container_classes) ?>">
					<div class="brand-col col-lg-2 col-12 text-center">
						<!-- Your site title as branding in the menu -->
						<?php if ( ! has_custom_logo() ) { ?>

							<?php if ( is_front_page() && is_home() ) : ?>

								<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

							<?php else : ?>

								<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

							<?php endif; ?>

							<?php
						} else {
							the_custom_logo();

							if ( "behind" === $header_placement ) {
								get_template_part( 'global-templates/site-info', '', array() );
							}
						}
						?>
						<!-- end custom logo -->
					</div>
					<div class="nav-col col-lg-8 col-12 text-center mt-3">
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- The WordPress Menu goes here -->
					<?php
					$menu_class = "navbar navbar-nav mt-3 mt-md-0 ms-auto me-auto";
					switch ($menu_align) {
						case 'left':
							$menu_class .= ' ms-lg-0';
							break;
						case 'right':
							$menu_class .= ' me-lg-0';
							break;						
						default:
							$menu_class .= '';
							break;
					}

					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => $menu_class,
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'depth'           => 2,
							'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
						)
					);
					?>
					</div>
					<?php $widget_class = ( $show_widget_column ) ? "widget-col col-lg-2" : "d-none"; ?>
					<div class="<?php echo $widget_class; ?>">
					</div>
				</div><!-- .container -->
			</nav><!-- .site-navigation -->
		</div><!-- #wrapper-navbar end -->
<?php
if ( $header_placement == "below" ) :
	get_template_part( 'global-templates/custom-header', null, array(
		'has_header_image' => $has_header_image,
	) );
endif;
?>
	</header>
<?php endif; //if ( !$home_hide_header ) ?>