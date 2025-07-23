<?php
/**
 * Sidebar setup for footer full
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'footerfull' ) ) {
	return;
}

$container = get_theme_mod( 'inharmony_container_type' );

// Get the footer style from theme customizer
$footer_style = get_theme_mod( 'understrap_footer_style', 'light' );
$footer_style = ' bg-' . get_theme_mod( 'inharmony_footer_bg', 'primary');
$footer_style .= ' text-' . get_theme_mod( 'inharmony_footer_text', 'light' );
$footer_style = esc_attr( $footer_style );
// Add the footer style to the wrapper class
$wrapper_class = 'wrapper ' . $footer_style;

// Get the footer layout
$footer_layout = get_theme_mod( 'inharmony_footer_widget_layout_direction', 'row' );

?>

<!-- ******************* The Footer Full-width Widget Area ******************* -->

<div class="<?php echo esc_attr( $wrapper_class ); ?>" id="wrapper-footer-full" role="complementary">

	<div class="<?php echo esc_attr( $container ); ?>" id="footer-full-content" tabindex="-1">

		<div class="<?php echo esc_attr( $footer_layout ); ?>">

			<?php dynamic_sidebar( 'footerfull' ); ?>

		</div>

	</div>

</div><!-- #wrapper-footer-full -->
