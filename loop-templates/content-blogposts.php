<?php
/**
 * Partial template for content in blogpage.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

extract(shortcode_atts(array(
    'post_element' => 'article',
    'post_class' => '',
    'title_style' => '',
    'display_post_excerpt' => false,
    'display_post_read_time' => false,
), $args));

//bg-primary bg-opacity-25
$post_block_style = 'bg-' . get_theme_mod( 'inharmony_post_block_bg', 'transparent');
$post_block_style .= ' bg-opacity-' . get_theme_mod( 'inharmony_post_block_bg_opacity', '100');
$post_block_style .= ' border';
$post_block_style .= ' border-' . get_theme_mod( 'inharmony_post_block_border_color', 'primary');
$post_block_style .= ' border-' . get_theme_mod( 'inharmony_post_block_border_size', '1');
$post_block_style .= ' rounded-' . get_theme_mod( 'inharmony_post_block_border_radius', '0');
$post_block_style .= ' text-' . get_theme_mod( 'inharmony_post_block_color', 'black');
$post_block_style .= ' p-' . get_theme_mod( 'inharmony_post_block_padding', '4');


$post_classes = array(
    'ih-latest-posts__list-item',
    'ih-post-' . get_the_ID(),
    'col-md-6 col-lg-4 text-center mb-3',
    $post_class,
);

$post_image_height = get_theme_mod( 'inharmony_post_block_image_height', '300px');
?>

<<?php echo $post_element; ?> class="<?php echo join(' ', $post_classes); ?>">
    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
        <div class="ih-latest-posts_post <?php echo $post_block_style; ?>">
            <div class="ih-latest-posts__featured-image mb-3" style="height: <?php echo $post_image_height; ?>;">   
                <?php echo get_the_post_thumbnail( $id, 'medium', array( 'class' => 'img-cover' ) ); ?>
            </div>
            <div class="ih-latest-posts__text p-3">
                <?php 
                    $title_tag_open = '<h3 class="'. $title_style . '">';
                    $title_tag_close = '</h3>';
                    the_title( $title_tag_open, $title_tag_close ); ?>
                <?php
                if ($display_post_excerpt) :
                ?>
                <div class="ih-latest-posts__post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <?php
                endif;
                ?>
                <?php
                if ($display_post_read_time) :
                ?>
                <div class="ih-latest-posts__post-read-time small">
                    <?php inharmony_read_time(); ?>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </a>
</<?php echo $post_element; ?>>
