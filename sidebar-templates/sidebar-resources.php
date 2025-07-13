<?php

/**
 * Sidebar for Resources page
 *
 * @package understrap-child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Sidebar for Resources page
 * @param array $args
 * Optional. Arguments for the sidebar.
 * @type string $link_base Base URL for the filter form action.
 * @type array $fields Array of fields for the filter form.
 * @type array $fieldKeys Array of field keys for the filter form.
 * @type array $selections Array of selected filter values.
 * @type string $single_tax The single taxonomy for the filter form.
 * @var string $link_base Base URL for the filter form action
 */
extract($args);

$link_base = $link_base ?? get_permalink();
$fields = $fields ?? ihk_get_resources_fields();
$fieldKeys = $fieldKeys ?? array_keys($fields);
$single_tax = $single_tax ?? null;

$selections = $selections ?? array();
// Check if the selections array is empty
if ( !is_array($selections) ) {
    $selections = array();
}
$hasFilters = !empty( $selections );

$sidebar_name = 'malina_sticky_sidebar' . ( is_archive() ? '_archive' : '' );
$sticky = get_theme_mod($sidebar_name, 'scrolled');

if (is_string($single_tax)) {
	$parts = explode(':', $single_tax);
	$terms = get_terms(array(
		'taxonomy'      => $parts[0],
		'hide_empty'    => false,
		'orderby'       => 'term_order',
		'order'         => 'DESC',
		'hierarchical'  => false,
		'parent'        => 0,
		'slug'          => $parts[1],
	));
	if (!empty($terms) && !is_wp_error($terms)) {
		$queried_object = $terms[0];
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id;
		$term_slug = $queried_object->slug;
		$term_name = str_replace('-', ' ', $queried_object->name ?? '');
		$term_description = $queried_object->description;
		$term_image = get_field('icon', $taxonomy.'_'.$term_id);
	}
}

$isSidebar = true;
?>
<div id="sidebar" class="span2 <?php echo esc_attr($sticky); ?> sidebar-resources">
	<?php
    include(locate_template( 'template-parts/resources/header.php' ));

    echo '<div class="filter-selectors">';
    $filterClasses = array(
        'reset-filters',
        ($hasFilters ) ? 'has-filters' : '',
    );
    echo '<a href="' . $link_base . '" class="' . trim(join(' ', $filterClasses)) . '">' . __('Clear Filters', 'ihk') . '</a>';
    // Display the form
    echo '<form id="filter-form" class="resources-form" method="get" onSubmit="return validateFilters(this);" action="'. $link_base . '">';
    echo '<input type="hidden" name="filter" value="1" />';

    // Get taxonomies Category, Seasons, Cycles, Subjects, Continents
    // and display each with their name and values in a select dropdown
    $exclude_slugs = array('uncategorized', 'the-harmony-7');
	foreach ($fields as $key => $value) {
        $terms = get_terms(array(
            'taxonomy'      => $key,
            'hide_empty'    => false,
            'orderby'       => 'term_order',
            'order'         => 'DESC',
            'hierarchical'  => false,
            'parent'        => 0,
        ));

        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<div class="filter-selector">';
            echo '<h3 id="' . esc_attr($key) . '-label" class="filter-title"><span>' . ucwords($key) . '</span><i class="la la-location-arrow"></i></h3>';
            $term_size = 0;
            foreach ($terms as $term) {
                // Check if term is excluded
                if ( in_array($term->slug, $exclude_slugs) ) {
                    continue;
                }
                $term_size++;
            }
            // Check if there are any terms to display
            if ($term_size == 0) {
                continue;
            }
            echo '<select name="' . $key . '" id="' . $key . '" multiple size="' . $term_size . '" aria-labelledby="' . $key . '-label" class="form-control filter-select">';
            foreach ($terms as $term) {
                // Check if term is excluded
                if ( in_array($term->slug, $exclude_slugs) ) {
                    continue;
                }
                // Check if the term is selected
                $selected = '';
                if (isset($selections[$key]) && in_array($term->slug, $selections[$key])) {
                    $selected = 'selected';
                }
                // Term name to display
                $term_name = $term->name;
                if ($key == 'cycles') {
                    $term_name .= ' (' . $term->description . ')';
                }
                // Display the term in the select dropdown
                echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term_name) . '</option>';
            }
            echo '</select>';

        echo '<ul class="selected-filters-list">';

            // Loop through the selected values and display them
            if (isset($selections[$key])) {
                foreach ($selections[$key] as $value) {
                    $rm_selections = $selections;

                    // Check if the value is empty
                    if (empty($value)) {
                        continue;
                    }
                    // Remove the selected value from the array
                    $rm_selections[$key] = array_diff($rm_selections[$key], array($value));

                    echo '<li>';
        
                    $link = $link_base;
        
                    if (!empty($rm_selections)) {
                        $link = add_query_arg($rm_selections, $link);
                    }
                    echo '<a href="' . esc_url($link) . '" class="remove-filter">' . ucwords(str_replace('-', ' ', $value)) . '</a>';
                    echo '</li>';
                }
            }
            echo '</ul>';
            
            echo '</div>';
        }
    }

    echo '<br /><input type="submit" value="' . __('Filter', 'ihk') . '" class="btn btn-primary form-control rounded-0" />';
    echo '</form>';
    echo '</div>';

	?>
    <script>
    function validateFilters(form) {
        const submit = form.querySelector('input[type="submit"]');
        submit.disabled = true;

        const fields = [<?php echo '"' . implode('", "', $fieldKeys) . '"'; ?>];
        let isEmpty = true;

        for (let i = 0; i < fields.length; i++) {
            const field = form[fields[i]];
            if (field.value !== '') {
                isEmpty = false;
            }
        }
        
        if (isEmpty) {
            return false;
        }

        submit.disabled = false; 

        return true;
    }
    function toggleFilter(filter) {
        filter.classList.toggle('closed');
    }
    function initSelectorForm() {
        const filterForm = document.getElementById('filter-form');
        validateFilters(filterForm);

        const filters = document.querySelectorAll('.filter-selector');
        filters.forEach(filter => {
            filter.classList.add('toggle');
            filter.classList.add('closed');
            const title = filter.querySelector('.filter-title');
            title.addEventListener('click', function() {
                toggleFilter(filter);
            });
            const select = filter.querySelector('select');
            select.addEventListener('change', function() {
                validateFilters(filterForm);
            });
        });
    }
    initSelectorForm();
    </script>
</div>