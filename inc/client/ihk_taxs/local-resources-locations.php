<?php
global $tax_slugs;
$tax_slugs[] = "lr-locations";

/**
 * Taxonomy: Local Resources Locations.
 */

function ihk_register_tax_lr_locations()
{

    $singular = "LR Location";
    $plural = "{$singular}s";

    $labels = ihk_get_tax_labels($singular);

    $args = [
        "label" => esc_html__("{$plural}", "custom-post-type-ui"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'lr-locations', 'with_front' => true],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "lr-locations",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => true,
        "sort" => false,
        "show_in_graphql" => false,
    ];

    register_taxonomy(
        "lr-locations",
        ["local-resources"],
        $args
    );
}
