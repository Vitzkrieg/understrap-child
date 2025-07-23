/*!
  * Understrap v0.1.0 (https://inharmonyarts.com)
  * Copyright 2013-2025 In Harmony Arts
  * Licensed under undefined (undefined)
  */
(function (factory) {
    typeof define === 'function' && define.amd ? define(factory) :
    factory();
})((function () { 'use strict';

    /**
     * IHK Admin JS
     */

    let ihk = ihk || {};
    (function ($, ihk) {
      ihk.init = function () {
        setTimeout(() => {
          // this.moveProductDataWrapper();
        }, 500);
      };
      ihk.moveProductDataWrapper = function () {
        let productDataBox = document.getElementById('woocommerce-product-data');
        if (!productDataBox) {
          return;
        }
        let wrapper = productDataBox.querySelector('.product-data-wrapper');
        let productData = productDataBox.querySelector('.inside');
        if (wrapper && productData) {
          productData.prepend(wrapper);
        }
      };

      //$(document).ready($.proxy(ihk.init, ihk));
    })(jQuery, ihk);

}));
//# sourceMappingURL=admin.js.map
