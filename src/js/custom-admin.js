/**
 * WP Admin Custom JS
 */

  jQuery(function ($) {
    const pickers = $('.wp-picker-container');
    //update_iris(pickers);
  });

  function update_iris(pickers){
    try {
        pickers.iris({
            color: !1,
            mode: "hsl",
            controls: { horiz: "s", vert: "l", strip: "h" },
            hide: !0,
            border: !0,
            target: !1,
            width: 200,
            palettes: !1,
            type: "full",
            slider: "horizontal",
        });
    } catch (e) {
        setTimeout(() => {
            update_iris();
        }, 200);
    }
  }