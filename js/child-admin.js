(function (factory) {
    typeof define === 'function' && define.amd ? define(factory) :
    factory();
})((function () { 'use strict';

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

}));
//# sourceMappingURL=child-admin.js.map
