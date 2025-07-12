<?php

// only logged in usesrs can see this
if ( !is_user_logged_in() )  return;

?>
<div class="post-like-container">
<?php
if( function_exists('ihkGetPostLikeLink') ) {
    $post_id = get_the_ID();
    echo ihkGetPostLikeLink( $post_id, 'loved' );
    echo ihkGetPostLikeLink( $post_id, 'completed' );
    echo ihkGetPostLikeLink( $post_id, 'listed' );
}
?>
</div>