jQuery(function ($) {
console.log('search-area.js loaded');
    const searchArea = $('header .search-area');
    if ( !searchArea.length ) {
        return;
    }
    // Open search area
    jQuery('header .search-button').click(function(){
        searchArea.addClass('opened');
        return false;
    });
    // Close search area
    searchArea.find('.close-search').click(function(){
        searchArea.removeClass('opened');
        return false;
    });
    // Close on escape key
    $(document).keyup(function(e) {
        if (e.key === "Escape") { // escape key maps to keycode `27`
            searchArea.removeClass('opened');
        }
    });
});