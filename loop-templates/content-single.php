<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title_style = 'entry-title';

$sec_image_style = '';
$image_style = '';
$sec_content_style = '';
$article_style = '';

$auto_format_post = get_theme_mod( 'inharmony_auto_format_post' , 'yes' );
$sticky_image = get_theme_mod( 'inharmony_post_sticky_image', 'yes' );

if ($auto_format_post == 'yes') {
	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
	//$meta =  [(str) src, (int) width, (int) height, (bool) resize]
	$meta = wp_get_attachment_image_src($post_thumbnail_id, 'post-thumbnail');
	// If NOT landscape, place image to left of content
	if ($meta && $meta[1] <= $meta[2]) {
		$article_style = 'row g-0';
		$sec_image_style = 'col-sm-6 pe-sm-4';
		$image_style = 'sticky-img';
		$sec_content_style = 'col-sm-6';
	}
}

$post_thumbnail = get_the_post_thumbnail( $post->ID, 'full' );

?>

<article <?php post_class($article_style); ?> id="post-<?php the_ID(); ?>">

	<section class="section-image <?php echo $sec_image_style; ?>">
		<div id="post-img" class="<?php echo $image_style; ?>">
			<?php echo $post_thumbnail ?>
		</div>
	</section><!-- .section-image -->

	<section class="section-content <?php echo $sec_content_style; ?>">
		<header class="post-content entry-header">

			<?php 
			$title_tag_open = '<h1 class="'. $title_style . '">';
			$title_tag_close = '</h1>';
			the_title( $title_tag_open, $title_tag_close );
			?>

			<div class="entry-meta">

			<?php understrap_posted_on(); ?>

			</div><!-- .entry-meta -->

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php
			the_content();
			understrap_link_pages();
			?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</section><!-- .section-content -->

</article><!-- #post-## -->
