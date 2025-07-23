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