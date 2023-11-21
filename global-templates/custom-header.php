<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

extract($args);

$has_header_image = isset($has_header_image) && $has_header_image;

$header_classes = array(
    'd-flex',
    'align-content-center',
    'justify-content-center',
    $has_header_image ? 'site-header-image' : '',
)

?>

<div id="site-header" class="<?php echo trim(join(' ', $header_classes)); ?>">
    <?php get_template_part( 'global-templates/site-info', '', false ); ?>
</div>