<?php

//add seo custom for site
function seo_information(){
    //some of this can be customized.
    $ogproperty1 = 'website'; //change base on your site's purpose, see the Open Graph documentation
    $ogproperty2 = 'homestead'; // "
    $twittercard = 'summary_large_image'; //look up twitter's card documentation for the type you want
    $twittersite = 'inharmonylife'; // e.g. @someone
    $seoimage = get_site_icon_url(null, 'https://inharmonylife.com/wp-content/uploads/2022/01/ih-life-site-icon.png'); //site icon!
    $seosite_name = get_bloginfo('name');
    if(is_single()){
        $qpost = get_queried_object();
        $seodescript = $qpost->post_excerpt;
        $seotitle = $qpost->post_title;
        $seoname = $qpost->post_name;
        $seourl = home_url('/') . $seoname;
    } else {
        $seotitle = get_bloginfo('name');
        $seodescript = get_bloginfo('description');
        $seoname = get_bloginfo('name');
        $seourl = home_url('/');
    }
    //assemble meta in array.
    $seo_array = array(
        'og-property1' => '<meta content="' . $ogproperty1 . '" property="og:type">',
        'og-property2' => '<meta content="' . $ogproperty2 . '" property="og:type">',
        'og-description' => '<meta content="' . $seodescript . '" property="og:description">',
        'og-url' => '<meta content="' . $seourl . '/" property="og:url">',
        'og-title' => '<meta content="' . $seotitle . '" property="og:title">',
        'og-image' => '<meta content="' . $seoimage . '" property="og:image">',
        'og-site-name' => ' <meta content="' . $seosite_name . '" property="og:site_name">',
        'twitter-card' => '<meta content="' . $twittercard . '" property="twitter:card">',
        'twitter-site' => '<meta content="' . $twittersite . '" property="twitter:site">',
        'twitter-title' => '<meta content="' . $seotitle . '" property="twitter:title">',
        'twitter-description' => '<meta content="' . $seodescript . '" name="twitter:description">',
        'twitter-url' => '<meta content="' . $seourl . '" property="twitter:url">',
        'twitter-image' => '<meta content="' . $seoimage . '" property="twitter:image">'
    );
     //echo meta
    foreach($seo_array as $item){
        echo $item;
    }
}
add_action('wp_head','seo_information');