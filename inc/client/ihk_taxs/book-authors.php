<?php
global $tax_slugs;
$tax_slugs[] = "book-authors";

function ihk_register_tax_book_authors()
{

/**
 * Taxonomy: Authors.
 */
    $singular = "Author";
    $plural = "{$singular}s";

    $labels = ihk_get_tax_labels($singular);

    $args = [
        "label" => esc_html__("{$plural}", "custom-post-type-ui"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'book-authors', 'with_front' => true],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "book-authors",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => true,
        "sort" => false,
        "show_in_graphql" => false,
        "default_term" => ['name' => 'Anonymous'],
    ];
    register_taxonomy("book-authors", ["books"], $args);
}
