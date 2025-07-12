<?php

function ihk_book_display_links($type) {
    $links = get_field( $type );
    if (empty($links)) {
        return;
    }

    $single = substr($type, 0, strlen($type) -1);
    $group = get_field($type);

    $out = '';

    for ( $i = 1; $i <5; $i++) {
        if ( $link = $group[$single . '_' . $i] ?? false ) {
            $url = $link['url'];
            $title = $link['title'];
            $target = '_blank';

            $out .= "<li class='book-links-item'><a href='{$url}' target='{$target}'>{$title}</a></li>";
        }
    }

    if ( !empty($out) ) {
        echo '<ul class="book-links-list">' . $out . '</ul>';
    } else {
        echo '<p>No Links</p>';
    }
}

?>
<div class="book-links-container span12">
    <div id="borrow" class="book-links-type book-borrow">
        <h2>Borrow</h2>
        <?php ihk_book_display_links( 'borrow_links' ); ?>
    </div>
    <div id="buy-used" class="book-links-type book-buy-used">
        <h2>Buy Used</h2>
        <?php ihk_book_display_links( 'purchase_used_links' ); ?>
    </div>
    <div id="buy-new" class="book-links-type book-buy-new">
        <h2>Buy New</h2>
        <?php ihk_book_display_links( 'purchase_new_links' ); ?>
    </div>
</div>