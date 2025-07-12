<?php
$has_producst = false;
$posts_array = [];

// $sf = get_field( 'seasonal_foundations' );
// $hu = get_field( 'harmony_u' );
// $bh = get_field( '100_book_homeschool' );
// $bs = get_field( 'used_in_book_study' );

// if ( !empty($bs) ) {
//     $posts_array[] = $bs;
// }

if ( !$has_producst ) {
    return;
}

?>
<div id="book-products" class="book-products span12">
    <h2>Products for this Book</h2>
    <?php
        $section_title = false;
        $post_type = "book-products";

        include(locate_template( 'template-parts/posts/slider.php' ));
    ?>
</div>