<?php

function ihk_exclude_product_categories_from_search($query) {
    // Check if we are in the main query and on the search results page
    debug_log(array(
        'is_search' => $query->is_search() ? 'true' : 'false',
        'is_admin' => is_admin() ? 'true' : 'false',
    ));
    
    if ($query->is_search() && !is_admin()) {
        // Define the categories to exclude (replace 'category-slug' with your actual category slugs)
        $excluded_categories = array('physical');

        // Add the tax_query to exclude the specified categories
        $query->set('tax_query', array(
            array(
                'taxonomy' => 'product_cat', // WooCommerce product category taxonomy
                'field'    => 'slug',        // Use 'slug' to specify the category by slug
                'terms'    => $excluded_categories, // Categories to exclude
                'operator' => 'NOT IN',      // Exclude these categories
            ),
        ));
    }
}
add_action('pre_get_posts', 'ihk_exclude_product_categories_from_search');


add_filter( 'woocommerce_product_categories', 'ihk_woocommerce_product_categories');
function ihk_woocommerce_product_categories($categories) {

    debug_log($categories);

    return $categories;
}