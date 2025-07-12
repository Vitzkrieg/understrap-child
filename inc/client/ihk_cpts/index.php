<?php
// this gets added to with each cpt file
global $cpt_slugs;
$cpt_slugs = array();


// custom post types
require_once('bulletins.php');
require_once('books.php');
require_once('book-studies.php');
require_once('seeds.php');
require_once('children.php');
require_once('local-resources.php');
require_once('seasonal-foundations.php');
require_once('harmony-u.php');


// init
function ihk_init_cpts() {
    global $cpt_slugs, $ct_slugs;

    foreach ($cpt_slugs as $value) {
        $slug = str_replace('-', '_', $value);
        // init the cpt
        if ( function_exists("ihk_register_cpts_{$slug}")) {
            call_user_func("ihk_register_cpts_{$slug}");
        }
    }
}

add_action('init', 'ihk_init_cpts');