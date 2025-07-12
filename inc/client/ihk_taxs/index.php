<?php
/**
 * IHK Custom Taxonomies
 * 
 * Package: IHK/Taxonomies
 */
global $tax_slugs;
$tax_slugs = array();


// CPT specific taxs
require_once('book-authors.php');
require_once('local-resources-categories.php');
require_once('local-resources-locations.php');
require_once('book-studies-categories.php');
require_once('seed_categories.php');

// General taxs
require_once('cycles.php');
require_once('seasons.php');
require_once('continents.php');
require_once('subjects.php');
require_once('values.php');


// init
function ihk_init_taxs() {
    global $tax_slugs;

    foreach ($tax_slugs as $value) {
        $slug = str_replace('-', '_', $value);
        // init the taxonomy
        if ( function_exists("ihk_register_tax_{$slug}") ) {
            call_user_func("ihk_register_tax_{$slug}");
        }
    }
}

add_action('init', 'ihk_init_taxs');