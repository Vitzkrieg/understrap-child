<?php

global $CACHE_DIR;
$CACHE_DIR = WP_CONTENT_DIR . '/ihk-cache/';

global $cache_file;
$cache_file = '';


function ihk_convert_to_cache_file_path($post_url) {
    global $CACHE_DIR, $cache_file;

    if (isset($cache_file) && !empty($cache_file)) {
        return $cache_file;
    }

    $post_path = parse_url($post_url, PHP_URL_PATH);
    // remove trailing slash
    // $post_path = rtrim($post_path, '/');
    // replace all non-alphanumeric characters with underscores
    // $post_path = preg_replace('/[^a-zA-Z0-9]/', '_', $post_path);
    // convert to lowercase
    $post_path = strtolower($post_path);
    // add .html extension
    $post_path = $post_path . 'cache.html';
    // set cache file path
    $file = rtrim($CACHE_DIR, '/') . $post_path;

    return $file;
}


function ihk_get_cache_file_path($post_id) {
    global $CACHE_DIR;
    
    // get post url path
    $post_url = get_permalink($post_id);

    return ihk_convert_to_cache_file_path($post_url);
}

function write_file_in_directory($file_path, $content) {
    // Extract the directory path from the file path
    $directory = dirname($file_path);

    // Check if the directory exists
    if (!file_exists($directory)) {
        // Create the directory with recursive flag and proper permissions
        mkdir($directory, 0777, true);
    }

    // Write the content to the file
    file_put_contents($file_path, $content);

    return $file_path;
}


function ihk_save_cache($minified) {
    global $cache_file;

    // Administrator
    if ( ihk_user_is_admin() ) {
        return $minified;
    }

    // check if cache file is set
    if (empty($cache_file)) {
        return $minified;
    }

    if (!empty($minified)) {
        // save to cache file
        write_file_in_directory($cache_file, $minified);
    }

    return $minified;
}


function ihk_cache_init() {
    global $CACHE_DIR, $cache_file;

    // Administrator
    if ( ihk_user_is_admin() ) {
        return;
    }

    if (!file_exists($CACHE_DIR)) {
        mkdir($CACHE_DIR, 0777, true);
    }

    // get request url path
    $request_uri = $_SERVER['REQUEST_URI'];

    if (preg_match('(\?|wp-|ihk-|cart|feed|member-|my-account)', $request_uri) !== false) {
        return;
    }

    // if contains '.', return
    if (strpos($request_uri, '.') !== false) {
        return;
    }
    
    // convert to cache file path
    $cache_file = ihk_convert_to_cache_file_path($request_uri);

    // check if cache file exists
    // if it does, output the cache file and exit
    if (file_exists($cache_file)) {
        $content = file_get_contents($cache_file);
        // check if content is empty
        if (!empty($content)) {
            debug_log(array(
                'success' => 'yes',
            ));
            echo $content;
            exit;
        }
    }

    // if it doesn't, start output buffering
    // and set the cache file path as the output buffer callback
    // so that the output buffer is saved to the cache file
    // when the script finishes
    ob_start('ihk_save_cache');

    add_filter('ihk_minify_after', 'ihk_save_cache', 10, 1);
}

$ihk_cache_enabled = get_option('ihk_cache_enabled');
if ( $ihk_cache_enabled && !is_user_logged_in()) {
    add_action('init', 'ihk_cache_init');
}


// clear post cache on save
function ihk_clear_post_cache($post_id) {
    global $CACHE_DIR;

    // get post url path
    $post_url = get_permalink($post_id);

    // convert to cache file path
    $cache_file = ihk_convert_to_cache_file_path($post_url);

    // delete cache file if it exists
    if (file_exists($cache_file)) {
        unlink($cache_file);
    }
}
// clear post cache on save
add_action('save_post', 'ihk_clear_post_cache');
// clear post cache on delete
add_action('delete_post', 'ihk_clear_post_cache');
// clear post cache on update
add_action('post_updated', 'ihk_clear_post_cache');
// clear post cache on publish
add_action('publish_post', 'ihk_clear_post_cache');
// clear post cache on trash
add_action('trash_post', 'ihk_clear_post_cache');
// clear post cache on untrash
add_action('untrash_post', 'ihk_clear_post_cache');
// clear post cache on delete attachment
add_action('delete_attachment', 'ihk_clear_post_cache');
// clear post cache on update attachment
add_action('edit_attachment', 'ihk_clear_post_cache');
// clear post cache on publish attachment
add_action('publish_attachment', 'ihk_clear_post_cache');
// clear post cache on trash attachment
add_action('trash_attachment', 'ihk_clear_post_cache');
// clear post cache on untrash attachment
add_action('untrash_attachment', 'ihk_clear_post_cache');


function ihk_clear_term_cache( $term_id, $tt_id, $taxonomy ) {
    
}

// clear post cache on delete term
add_action('delete_term', 'ihk_clear_post_cache');
// clear post cache on update term
add_action('edit_term', 'ihk_clear_post_cache');
// clear post cache on delete term taxonomy
add_action('delete_term_taxonomy', 'ihk_clear_post_cache');
// clear post cache on update term taxonomy
add_action('edit_term_taxonomy', 'ihk_clear_post_cache');
// clear post cache on delete term relationship
add_action('delete_term_relationships', 'ihk_clear_post_cache');
// clear post cache on update term relationship
add_action('edit_term_relationships', 'ihk_clear_post_cache');
// clear post cache on delete term relationship
add_action('delete_term_relationship', 'ihk_clear_post_cache');
// clear post cache on update term relationship
add_action('edit_term_relationship', 'ihk_clear_post_cache');



// clear all cache
function ihk_clear_cache_all() {
    global $CACHE_DIR;

    // delete all cache files
    $files = glob($CACHE_DIR . '*.html');
    foreach ($files as $file) {
        unlink($file);
    }
}
add_action('ihk_clear_cache_all', 'ihk_clear_cache_all');


// add option to clear cache in admin menu
function ihk_add_clear_cache_option() {
    add_submenu_page(
        'options-general.php',
        'IHK Cache',
        'IHK Cache',
        'manage_options',
        'ihk-clear-cache',
        'ihk_clear_cache_page'
    );

    add_action('admin_post_ihk_clear_cache', 'ihk_clear_cache_all');
}
add_action('admin_menu', 'ihk_add_clear_cache_option');


// add clear cache button to admin bar
function ihk_add_clear_cache_admin_bar($wp_admin_bar) {
    $wp_admin_bar->add_menu(array(
        'id' => 'ihk-clear-cache',
        'title' => 'IHK Cache',
        'href' => admin_url('options-general.php?page=ihk-clear-cache'),
    ));

    $wp_admin_bar->add_menu(array(
        'id' => 'ihk-clear-cache-all',
        'title' => 'Clear All Cache',
        'href' => admin_url('admin-post.php?action=ihk_clear_cache_all_bar&post_id=' . get_the_ID()),
        'parent' => 'ihk-clear-cache',
    ));

    $wp_admin_bar->add_menu(array(
        'id' => 'ihk-clear-cache-post',
        'title' => 'Clear Post Cache',
        'href' => admin_url('admin-post.php?action=ihk_clear_cache_post&post_id=' . get_the_ID()),
        'parent' => 'ihk-clear-cache',
    ));
}
add_action('admin_bar_menu', 'ihk_add_clear_cache_admin_bar', 999);

// handle clear cache post request
function ihk_clear_cache_post() {
    $post_id = $_GET['post_id'];
    ihk_clear_post_cache($post_id);
    wp_redirect(get_permalink( $post_id ));
    exit;
}
add_action('admin_ihk_clear_cache_post', 'ihk_clear_cache_post');

// handle clear cache post request
function ihk_clear_cache_all_bar() {
    $post_id = $_GET['post_id'];
    do_action('ihk_clear_cache_all');
    wp_redirect(get_permalink( $post_id ));
    exit;
}
add_action('admin_ihk_clear_cache_all', 'ihk_clear_cache_all_bar');

// handle clear cache all request
function ihk_clear_cache_page() {
    $response = false;
    // updating enabled
    if (isset($_GET['enable'])) {
        update_option('ihk_cache_enabled', $_GET['enable'] == 1 );
        $response = '<div class="updated"><p>Setting updated</p></div>';
    }
    // clear all cache
    if (isset($_GET['clear_all'])) {
        do_action('ihk_clear_cache_all');
        $response = '<div class="updated"><p>All cache cleared.</p></div>';
    }

    // display page content
    $enabled = get_option('ihk_cache_enabled');
    $classes = array(
        "wrap",
        "ihk-clear-cache",
        $enabled ? "cache-enabled" : "",
    )
    ?>
    <div class="<?php echo join(' ', $classes); ?>">
        <div class="response">
            <?php if ($response) {
                echo $response;
            } ?>
        </div>
        <style>
            .ihk-clear-cache .enabled-only { display: none; }
            .ihk-clear-cache.cache-enabled .enabled-only { display: block; }
        </style>
        <script>
            var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            var ihk_ajax_object = {
                nonce: "<?php echo wp_create_nonce('ihk_update_cache_setting'); ?>"
            };
            jQuery(document).ready(function($) {
                $wrapper = $('.ihk-clear-cache');
                $container = $('.ihk-clear-cache .response');
                function show_response(msg, good) {
                    if (good) {
                        $status = $('<div class="updated"></div>');
                    } else {
                        $status = $('<div class="error"></div>');
                    }
                    $status.append(msg);
                    $container.html($status);
                }
                
                $('#toggle-cache').on('click', function(e) {
                    e.preventDefault();
                    const $this = $(this);
                    const enabled = $(this).data('enabled') ? 0 : 1;

                    $.ajax({
                        url: ajaxurl, // WordPress AJAX URL
                        method: 'POST',
                        data: {
                            action: 'ihk_update_cache_setting',
                            nonce: ihk_ajax_object.nonce, // Pass the nonce
                            enabled: enabled,
                        },
                        success: function(response) {
                            if (response.success) {
                                show_response(response.data.message, true);
                                $this.data('enabled', enabled);
                                $this.text(enabled ? 'Disable Cache' : 'Enable Cache');
                                $wrapper.toggleClass('cache-enabled', (enabled == 1));
                            } else {
                                show_response(response.data.message, false);
                            }
                        },
                        error: function(xhr) {
                            show_response('Error: ' + xhr.responseJSON.data.message, false);
                        }
                    });

                    return false;
                });
                $('#clear-all').on('click', function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: ajaxurl, // WordPress AJAX URL
                        method: 'POST',
                        data: {
                            action: 'ihk_update_cache_setting',
                            nonce: ihk_ajax_object.nonce, // Pass the nonce
                            clear_all: 1,
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.data.message);
                            } else {
                                alert(response.data.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON.data.message);
                        }
                    });

                    return false;
                });
            });
        </script>
        <h1>IHK Cache</h1>
    <?php
    $val = $enabled ? 0 : 1;
    $title = $enabled ? 'Disable' : 'Enable';
    // enable toggle
    echo '<p><a id="toggle-cache" href="' . admin_url('options-general.php?page=ihk-clear-cache&enable=' . $val) . '" data-enabled=' . $val . '>' . $title  . '</a></p>';
    // clear all
    echo '<p class="enabled-only"><a id="clear-all" href="' . admin_url('options-general.php?page=ihk-clear-cache&clear_all=1') . '">Clear All Cache</a></p>';
    ?>
    </div>
    <?php
}

function ihk_update_htccess_to_cache() {
    // Get the .htaccess file path
    $htaccess_file = get_home_path() . '.htaccess';

    // Check if the file is writable
    if (is_writable($htaccess_file) || (!file_exists($htaccess_file) && is_writable(dirname($htaccess_file)))) {
        // Open the file for appending or create it if it doesn't exist
        $htaccess_content = "
# BEGIN IHK Cache
<IfModule mod_rewrite.c>
  RewriteEngine On

  # Check if a cached file exists in the ihk-cache directory
  RewriteCond %{DOCUMENT_ROOT}/wp-content/ihk-cache/%{REQUEST_URI}cache.html -f
  RewriteRule ^(.*)$ /wp-content/ihk-cache/%{REQUEST_URI}cache.html [L]
</IfModule>
# END IHK Cache
";

        // Write the content to the .htaccess file
        file_put_contents($htaccess_file, $htaccess_content, FILE_APPEND | LOCK_EX);
    } else {
        // fail silently
    }
}

function ihk_remove_htaccess_cache() {
    // Get the .htaccess file path
    $htaccess_file = get_home_path() . '.htaccess';

    // Check if the file exists and is writable
    if (file_exists($htaccess_file) && is_writable($htaccess_file)) {
        // Read the current content of the .htaccess file
        $htaccess_content = file_get_contents($htaccess_file);

        // Define the block to remove
        $start_marker = '# BEGIN IHK Cache';
        $end_marker = '# END IHK Cache';

        // Use regex to remove the block
        $pattern = '/' . preg_quote($start_marker, '/') . '.*?' . preg_quote($end_marker, '/') . '\s*/s';
        $updated_content = preg_replace($pattern, '', $htaccess_content);

        // Write the updated content back to the .htaccess file
        file_put_contents($htaccess_file, $updated_content, LOCK_EX);
    } else {
        // fail silently
    }
}

// Handle AJAX request to update ihk_cache_enabled option
function ihk_update_cache_settings() {
    // Check for required permissions
    if (!ihk_user_is_admin()) {
        wp_send_json_error(['message' => 'Unauthorized'], 403);
    }

    // Verify the nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ihk_update_cache_setting')) {
        wp_send_json_error(['message' => 'Invalid nonce'], 400);
    }

    // Check if the 'enabled' parameter is set
    if (isset($_POST['enabled'])) {
        // Update the option
        $enabled = filter_var($_POST['enabled'], FILTER_VALIDATE_BOOLEAN);
        update_option('ihk_cache_enabled', $enabled);

        if ($enabled) {
            ihk_update_htccess_to_cache();
        } else {
            ihk_remove_htaccess_cache();
        }
    
        // Respond with success
        wp_send_json_success(['message' => 'Cache setting updated', 'enabled' => $enabled]);
    }

    // Check if the 'clear_all' parameter is set
    if (isset($_POST['clear_all'])) {
        // Update the option
        $clear_all = filter_var($_POST['clear_all'], FILTER_VALIDATE_BOOLEAN);
        if ($clear_all) {
            do_action('ihk_clear_cache_all');
            // Respond with success
            wp_send_json_success(['message' => 'Cache cleared']);
        }

        wp_send_json_error(['message' => 'Invalid parameter: clear_all', 'value' => $clear_all], 400);
    }

    // Response with generice error
    wp_send_json_error(['message' => 'Missing parameter'], 400);
}
add_action('wp_ajax_ihk_update_cache_setting', 'ihk_update_cache_settings');




// add clear cache button to post edit screen
function ihk_add_clear_cache_post_button() {
    echo '<div class="misc-pub-section"><a href="' . admin_url('admin-post.php?action=ihk_clear_cache_post&post_id=' . get_the_ID()) . '">Clear Cache</a></div>';
}
add_action('post_submitbox_misc_actions', 'ihk_add_clear_cache_post_button');

// add clear cache button to term edit screen
function ihk_add_clear_cache_form_button() {
    echo '<div class="submit"><a href="' . admin_url('admin-post.php?action=ihk_clear_cache_post&post_id=' . get_the_ID()) . '" class="button">Clear Cache</a></div>';
}
add_action('edit_term_form', 'ihk_add_clear_cache_form_button');
// add clear cache button to attachment edit screen
add_action('edit_attachment', 'ihk_add_clear_cache_form_button');
// add clear cache button to media edit screen
add_action('media_buttons', 'ihk_add_clear_cache_form_button');
// add clear cache button to media upload screen
add_action('media_upload_form', 'ihk_add_clear_cache_form_button');
// add clear cache button to media library screen
add_action('media_library_form', 'ihk_add_clear_cache_form_button');
// add clear cache button to media library upload screen
add_action('media_library_upload_form', 'ihk_add_clear_cache_form_button');
