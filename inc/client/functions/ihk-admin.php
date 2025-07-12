<?php



/**
 * Replace the color pallet in Gutenberg
 */
function ihk_add_new_color_pallet() {
    // The new colors we are going to add
    $newColorPalette = [
        [
            'name' => esc_attr__('May', 'ihk'),
            'slug' => 'may',
            'color' => '#efd5cb',
        ],
        [
            'name' => esc_attr__('June', 'ihk'),
            'slug' => 'jun',
            'color' => '#efbba4',
        ],
        [
            'name' => esc_attr__('November', 'ihk'),
            'slug' => 'nov',
            'color' => '#efa17c',
        ],
        [
            'name' => esc_attr__('August', 'ihk'),
            'slug' => 'aug',
            'color' => '#e3aa56',
        ],
        [
            'name' => esc_attr__('October', 'ihk'),
            'slug' => 'oct',
            'color' => '#d6b22f',
        ],
        [
            'name' => esc_attr__('September', 'ihk'),
            'slug' => 'sep',
            'color' => '#ad9f45',
        ],
        [
            'name' => esc_attr__('March', 'ihk'),
            'slug' => 'mar',
            'color' => '#b8c190',
        ],
        [
            'name' => esc_attr__('April', 'ihk'),
            'slug' => 'apr',
            'color' => '#c3e3db',
        ],
        [
            'name' => esc_attr__('July', 'ihk'),
            'slug' => 'jul',
            'color' => '#82b3b4',
        ],
        [
            'name' => esc_attr__('December', 'ihk'),
            'slug' => 'dec',
            'color' => '#41828c',
        ],
        [
            'name' => esc_attr__('January', 'ihk'),
            'slug' => 'jan',
            'color' => '#78939e',
        ],
        [
            'name' => esc_attr__('February', 'ihk'),
            'slug' => 'feb',
            'color' => '#aea3b0',
        ],
        [
            'name' => esc_attr__('White', 'ihk'),
            'slug' => 'white',
            'color' => '#fff',
        ],
        [
            'name' => esc_attr__('Gray Light', 'ihk'),
            'slug' => 'gray-lt',
            'color' => '#f7f7f7',
        ],
        [
            'name' => esc_attr__('Gray', 'ihk'),
            'slug' => 'gray',
            'color' => '#a7a7a7',
        ],
        [
            'name' => esc_attr__('Gray Med', 'ihk'),
            'slug' => 'gray-med',
            'color' => '#666',
        ],
        [
            'name' => esc_attr__('Gray Dark', 'ihk'),
            'slug' => 'gray-dark',
            'color' => '#333',
        ],
        [
            'name' => esc_attr__('Black', 'ihk'),
            'slug' => 'black',
            'color' => '#000',
        ],
        [
            'name' => esc_attr__('Africa', 'ihk'),
            'slug' => 'africa',
            'color' => '#ff6875',
        ],
        [
            'name' => esc_attr__('Ease Asia', 'ihk'),
            'slug' => 'east-asia',
            'color' => '#ffbd77',
        ],
        [
            'name' => esc_attr__('West Asia', 'ihk'),
            'slug' => 'west-asia',
            'color' => '#eed24e',
        ],
        [
            'name' => esc_attr__('Europe', 'ihk'),
            'slug' => 'europe',
            'color' => '#c5d483',
        ],
        [
            'name' => esc_attr__('North America', 'ihk'),
            'slug' => 'north-america',
            'color' => '#6cccce',
        ],
        [
            'name' => esc_attr__('South America', 'ihk'),
            'slug' => 'south-america',
            'color' => '#6f9acd',
        ],
        [
            'name' => esc_attr__('Oceania', 'ihk'),
            'slug' => 'oceania',
            'color' => '#a681bc',
        ],
        [
            'name' => esc_attr__('Spring', 'ihk'),
            'slug' => 'spring',
            'color' => '#c5bf1f',
        ],
        [
            'name' => esc_attr__('Summer', 'ihk'),
            'slug' => 'summmer',
            'color' => '#d899c5',
        ],
        [
            'name' => esc_attr__('Autumn', 'ihk'),
            'slug' => 'autumn',
            'color' => '#dc8a30',
        ],
        [
            'name' => esc_attr__('Winter', 'ihk'),
            'slug' => 'winter',
            'color' => '#3c71a0',
        ],
    ];

    // Apply the color palette
    add_theme_support( 'editor-color-palette', $newColorPalette);
}
add_action( 'after_setup_theme', 'ihk_add_new_color_pallet' );