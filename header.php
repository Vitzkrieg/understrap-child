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

$container = get_theme_mod( 'understrap_container_type', 'container' );
$header_container = get_theme_mod( 'inharmony_header_container_type', $container );

$custom_header = get_custom_header();
$has_header_image = !empty($custom_header->url);
$header_placement = $has_header_image ? get_theme_mod( 'inharmony_header_placement', 'top' ) : 'top';
$header_size = $has_header_image ? get_theme_mod( 'inharmony_header_image_size', 'cover' ) : 'cover';
$header_height = $has_header_image ? get_theme_mod( 'inharmony_header_image_height', '800px' ) : '800px';


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

$post_title_decoration = get_theme_mod( 'inharmony_post_title_decoration', 'capitalize' );

$show_widget_column = get_theme_mod( 'inharmony_header_show_widget_column', false );

$logo_placement = get_theme_mod( 'inharmony_logo_placement', 'above' );
$logo_alignment = get_theme_mod( 'inharmony_logo_alignment', 'center' );
$logo_desktop_size = $logo_placement == 'inline' ? 'col-lg-2' : 'col-lg-12';


$logo_classes = array(
	'brand-col',
	$logo_desktop_size,
	'col-12',
	'd-flex',
	'justify-content-' . $logo_alignment,
	'sz-' . get_theme_mod( 'inharmony_logo_size_desktop', 'md' ),
);

$menu_align = get_theme_mod( 'inharmony_menu_align' , 'center' );
$menu_margin_bottom_mobile = get_theme_mod( 'inharmony_menu_margin_bottom_mobile', '0' );
$menu_margin_bottom_desktop = get_theme_mod( 'inharmony_menu_margin_bottom_desktop', '0' );

$nav_col_classes = array(
	'nav-col',
	$show_widget_column ? 'col-9' : 'col-12',
	$show_widget_column ? 'col-lg-10' : 'col-lg-12',
	'd-flex',
	'flex-row',
	'align-items-center',
	'justify-content-center',
	'justify-content-md-' . $menu_align,
	'mt-3',
	'mb-' . $menu_margin_bottom_mobile,
	'mb-md-' . $menu_margin_bottom_desktop,
);
$nav_col_classes = apply_filters( 'understrap_nav_col_classes', $nav_col_classes );
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
		.entry-title, .entry-title a {
			text-transform: <?php echo $post_title_decoration; ?>;
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
<?php
// This menu displays at the top of the page
get_template_part( 'global-templates/header-menu' );
?>
<?php if ( get_theme_mod('inharmony_header_search_button', false) ) { ?>
<div class="search-area modal" tabindex="-1">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content">
			<div class="modal-header justify-content-end">
				<a href="#" class="close-search"><i class="la la-times"></i></a>
			</div>
			<div class="modal-body d-flex justify-content-center align-items-center">
				<form class="container col-12 d-flex justify-content-center" action="<?php echo esc_url(home_url('/')); ?>" id="header-searchform" method="get">
					<div class="col-12 col-md-10 col-lg-8 col-xl-6">
						<div class="search-label mb-4 text-center">
							<h2><?php esc_html_e('What are you looking for?', 'inharmony'); ?></h2>
						</div>
						<div class="input-group search-box">
							<label class="sr-only" for="header-s"><?php esc_html_e('Search for:', 'inharmony'); ?></label>
							<input class="form-control" type="text" id="header-s" name="s" value="" placeholder="<?php esc_attr_e('Search...', 'inharmony'); ?>" autocomplete="off" />
							<button class="btn btn-primary" type="submit"><i class="la la-search"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>
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

			<nav id="main-nav" class="navbar navbar-expand-lg navbar-light" aria-labelledby="main-nav-label">

				<h2 id="main-nav-label" class="sr-only">
					<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
				</h2>

				<div class="<?php echo join(' ', $container_classes) ?>">
					<div class="<?php echo join(' ', $logo_classes); ?>">
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
					<?php // .nav-col ?>
					<div class="<?php echo join(' ', $nav_col_classes); ?>">
						<button class="navbar-toggler col-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
							<span class="navbar-toggler-icon"></span>
						</button>

						<!-- The WordPress Menu goes here -->
						<?php
						$menu_class = "navbar navbar-nav mt-3 mt-md-0 ms-auto me-auto";
						switch ($menu_align) {
							case 'left':
								$menu_class .= ' ms-lg-0 flex-grow-0';
								break;
							case 'right':
								$menu_class .= ' me-lg-0 flex-grow-0';
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
						<?php if ( is_active_sidebar( 'header-widget' ) ) : ?>
							<?php $widget_classes = apply_filters( 'inharmony_header_widget_class', ["header-widget", "widget-col", "col-12","col-lg-2","col-xl-1"] ); ?>
							<div class="<?php echo join(' ', $widget_classes); ?>">
								<?php dynamic_sidebar( 'header-widget' ); ?>
							</div>
						<?php endif; ?>
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