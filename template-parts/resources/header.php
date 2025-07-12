<?php
/**
 * Template part for displaying resources header
 */
$isSidebar  = $isSidebar ?? false;
$term_name = $term_name ?? '';
$term_description = $term_description ?? '';
$term_image = $term_image ?? array(
    'url' => get_site_icon_url(),
    'alt' => get_bloginfo('name')
);
$headerClass = $isSidebar ? 'sidebar-title' : 'page-title';
?>
<header class="<?php echo $headerClass; ?>" class="aligncenter">
<?php if( $term_image ) : ?>
<figure class="tax-icon-wrap">
    <img 
        src="<?php echo esc_url($term_image['url']); ?>" 
        alt="<?php echo esc_attr($term_image['alt']); ?>"
        class="tax-icon"
    />
</figure>
<?php endif; ?>
<?php if ($isSidebar ) : ?>
    <h3><?php echo esc_attr($term_name); ?></h3>
<?php else : ?>
    <h1><?php echo esc_attr($term_name); ?></h1>
<?php endif; ?>
<?php if( $term_description ) : ?>
<p><?php echo esc_html($term_description); ?></p>
<?php endif; ?>
</header>
<?php
if( is_category() && category_description() != '' ){
    echo '<div class="category_description '.$text_align.'">'.category_description().'</div>';
}