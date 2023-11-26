<?php
/**
 * Partial template for content in blogpage.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

extract(shortcode_atts(array(
    'post_element' => 'div',
    'post_class' => '',
    'image_size' => 'post-thumbnail',
    'title_style' => 'entry-title mt-3 mb-3',
    'title_element' => 'h3',
    'display_post_excerpt' => get_theme_mod( 'inharmony_post_single_display_excerpt', false ),
    'display_post_read_time' => get_theme_mod( 'inharmony_post_single_display_read_time', false ),
    'layout' => 'none',
), $args));
    
$article_style = '';
$sec_image_style = '';
$sec_content_style = '';

if ($layout == 'left') {
    $post_class = ($post_class != '') ? $post_class : 'text-start';
    $article_style = 'row g-0';
    $sec_image_style = 'col-sm-6 pe-sm-4';
    $sec_content_style = 'col-sm-6';
} else {
    $post_class = ($post_class != '') ? $post_class : 'text-center';
}

?>

<<?php echo $post_element; ?> id="ih-sc-post" class="<?php echo $post_class; ?>">
    <article class="<?php echo $article_style; ?>">
        <section class="section-image <?php echo $sec_image_style; ?>">        
            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                <div class="latest-post__featured-image">
                        <?php echo get_the_post_thumbnail( $id, $image_size ); ?>
                </div>
            </a>
        </section>
        <section class="section-content <?php echo $sec_content_style; ?>"> 
            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                <?php 
                    $title_tag_open = "<$title_element class='$title_style'>";
                    $title_tag_close = "</$title_element>";
                    the_title( $title_tag_open, $title_tag_close );
                ?>
            </a>
            <div class="latest-post__post-excerpt">
                <?php the_excerpt(); ?>
            </div>
            <?php
            //TODO: setting - display read time
            if ($display_post_read_time) :
            ?>
            <div class="ih-latest-post__post-read-time">
                <?php inharmony_read_time(); ?>
            </div>
            <?php
            endif;
            ?>
        </section>
    </article>
</<?php echo $post_element; ?>><!-- #ih-latest-post -->
