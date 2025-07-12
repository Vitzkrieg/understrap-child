<?php
class IHKSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_footer', array( $this, 'page_footer' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'IHK Settings', 
            'manage_options', 
            'ihk-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'ihk_theme_settings' );
        ?>
        <div class="wrap">
            <h1>IHK Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'ihk_option_group' );
                do_settings_sections( 'ihk-settings-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'ihk_option_group', // Option group
            'ihk_theme_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'IHK Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'ihk-settings-admin' // Page
        );

        add_settings_field(
            'ihk_favorite_image', // ID
            'IHK Favorite Image', // Title 
            array( $this, 'ihk_favorite_image_callback' ), // Callback
            'ihk-settings-admin', // Page
            'setting_section_id' // Section
        );

        // add_settings_field(
        //     'title',
        //     'Title',
        //     array( $this, 'title_callback' ),
        //     'ihk-settings-admin',
        //     'setting_section_id'
        // );

        
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        if( isset( $input['ihk_favorite_image'] ) )
            $new_input['ihk_favorite_image'] = sanitize_text_field( $input['ihk_favorite_image'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="ihk_theme_settings[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }


    public function ihk_favorite_image_callback() {

        $image_id = esc_attr($this->options['ihk_favorite_image'] ?: '');
        $source = !empty($image_id) ? wp_get_attachment_image_src($image_id, 'thumbnail')[0] : '';

        wp_enqueue_media();

        ?><div class='image-preview-wrapper'>
            <img id='image-preview' src='<?php echo $source ; ?>' width='100' height='100' style='max-height: 100px; width: 100px;'>
        </div>
        <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
        <?php
        printf(
            '<input type="hidden" id="ihk_favorite_image" name="ihk_theme_settings[ihk_favorite_image]" value="%s">',
            $image_id
        );
    }

    function page_footer() {
        // Set class property
        $this->options = get_option( 'ihk_theme_settings' );

        ?><script type='text/javascript'>

            jQuery( document ).ready( function( $ ) {

                // Uploading files
                var file_frame;
                var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
                var set_to_post_id = "<?php echo $this->options['ihk_favorite_image'] ?: 0; ?>"; // Set this

                jQuery('#upload_image_button').on('click', function( event ){

                    event.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( file_frame ) {
                        // Set the post ID to what we want
                        file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                        // Open frame
                        file_frame.open();
                        return;
                    } else {
                        // Set the wp.media post id so the uploader grabs the ID we want when initialised
                        wp.media.model.settings.post.id = set_to_post_id;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.file_frame = wp.media({
                        title: 'Select a image to upload',
                        button: {
                            text: 'Use this image',
                        },
                        multiple: false	// Set to true to allow multiple files to be selected
                    });

                    // When an image is selected, run a callback.
                    file_frame.on( 'select', function() {
                        // We set multiple to false so only get one image from the uploader
                        attachment = file_frame.state().get('selection').first().toJSON();

                        // Do something with attachment.id and/or attachment.url here
                        $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                        $( '#ihk_favorite_image' ).val( attachment.id );

                        // Restore the main post ID
                        wp.media.model.settings.post.id = wp_media_post_id;
                    });

                        // Finally, open the modal
                        file_frame.open();
                });

                // Restore the main ID when the add media button is pressed
                jQuery( 'a.add_media' ).on( 'click', function() {
                    wp.media.model.settings.post.id = wp_media_post_id;
                });
            });

        </script><?php

    }
}

if( is_admin() )
    $ihk_settings_page = new IHKSettingsPage();