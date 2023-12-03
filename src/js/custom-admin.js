/**
 * WP Admin Custom JS
 */

jQuery(function ($) {
    var colorOptions = {
        palettes: ihl_admin['colors']
    };
    console.log('pickers:', $('.wp-picker-container'));
    $('.wp-picker-container').iris(colorOptions);
});