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


//TODO: setting: post block colors
$post_block_style = '';
//bg-primary bg-opacity-25
$post_block_bg = '';
if ($post_block_bg != '') {
    $post_block_style .= 'bg-' . $post_block_bg;
}
$post_block_border_color = 'primary';
if ($post_block_border_color != '') {
    $post_block_style .= 'border-' . $post_block_border_color;
}
$post_block_border_size = '1';
if ($post_block_border_color != '') {
    $post_block_style .= ' border-' . $post_block_border_size;
}
if ($post_block_border_color != '' ||  $post_block_border_size != '') {
    $post_block_style .= ' border';
}
$post_block_color = '';
if ($post_block_color != '') {
    $post_block_style .= 'text-' . $post_block_color;
}

$post_classes = array(
    'ih-latest-posts__list-item',
    'ih-post-' . get_the_ID(),
    'col-md-6 col-lg-4 text-center mb-3',
    $post_class,
);
?>

<<?php echo $post_element; ?> class="<?php echo join(' ', $post_classes); ?>">
    <a href="<?php the_permalink(); ?>" class="text-decoration-none">
        <div class="ih-latest-posts_post p-4 <?php echo $post_block_style; ?>">
            <div class="ih-latest-posts__featured-image mb-3">   
                <?php echo get_the_post_thumbnail( $id, 'medium', array( 'class' => 'img-cover' ) ); ?>
            </div>
            <div class="ih-latest-posts__text p-3">
                <?php 
                    $title_tag_open = '<h3 class="'. $title_style . '">';
                    $title_tag_close = '</h3>';
                    the_title( $title_tag_open, $title_tag_close ); ?>
                <?php
                //TODO: setting - display excerpt
                if ($display_post_excerpt) :
                ?>
                <div class="ih-latest-posts__post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <?php
                endif;
                ?>
                <?php
                //TODO: setting - display read time
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
