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
$custom_header = get_custom_header();
$header_placement = get_theme_mod( 'inharmony_header_placement', 'top' );
$has_header_image = isset($custom_header->url);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">
	<header>
<?php get_template_part( 'global-templates/header-menu' ); ?>
<?php if ( $has_header_image && $header_placement == "above" ) : ?>
	<?php get_template_part( 'global-templates/custom-header' ); ?>
<?php endif; ?>
	<!-- ******************* The Navbar Area ******************* -->
		<div id="wrapper-navbar">

			<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

			<nav id="main-nav" class="navbar navbar-expand-md navbar-light" aria-labelledby="main-nav-label">

				<h2 id="main-nav-label" class="sr-only">
					<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
				</h2>

			<?php if ( 'container' === $container ) : ?>
				<div class="container flex-wrap">
			<?php else : ?>
				<div class="container-fluid flex-wrap">
			<?php endif; ?>
					<div class="brand-col col-lg-2 col-md-12 text-center">
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
						}
						?>
						<!-- end custom logo -->
					</div>
					<div class="nav-col col-lg-8 col-md-12 text-center mt-3">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- The WordPress Menu goes here -->
					<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => 'navbar navbar-nav ml-auto mr-auto',
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'depth'           => 2,
							'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
						)
					);
					?>
					</div>
					<div class="widget-col col-lg-2">
					</div>
				<?php if ( 'container' === $container ) : ?>
				</div><!-- .container -->
			<?php else : ?>
				<div class="container-fluid flex-wrap">
				</div><!-- .container-fluid -->
				<?php endif; ?>

			</nav><!-- .site-navigation -->

		</div><!-- #wrapper-navbar end -->

<?php if ( $has_header_image && $header_placement == "below" ) : ?>
		<?php get_template_part( 'global-templates/custom-header' ); ?>
<?php endif; ?>
	</header>