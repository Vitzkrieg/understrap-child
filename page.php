<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<?php if ( is_front_page() && is_active_sidebar( 'home-widget' ) ) {
		$home_widget_classes = get_theme_mod( 'inharmony_home_widget_classes', 'col-md-12' );
		$home_widget_classes .= ' mt-3 mb-3';
		$hero_container = get_theme_mod( 'inharmony_home_widget_container', 'container' );
		$hero_container = 'container' === $hero_container ? 'container' : 'container-fluid no-gutters';
		$hero_container .= ' ' . $home_widget_classes;
	?>
		<section class="<?php echo esc_attr( $hero_container ); ?>" id="home-hero" role="complementary">
			<div class="col">
				<!-- Home widget area -->
				<section class="widget-area home-widget">
					<!-- Display the home widget area -->
					<?php dynamic_sidebar( 'home-widget' ); ?>
				</section><!-- .widget-area -->
			</div>
		</section><!-- .widget-area -->
	<?php } ?>

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'loop-templates/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				}
				?>

			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
