<?php
/*
Plugin Name: Arzamath_17th
Description: A simple wordpress plugin template
Version: 1.0
Author: Anton Shlikhta
Author URI:
License: GPL2
*/
/*
Copyright 2014  Anton Shlikhta  (email : suddyadred@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software

*/

if(!class_exists('WP_Plugin_Template')) //перевірка чи був оголошений клас
{
    class WP_Plugin_Template
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // Initialize Settings
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            $WP_Plugin_Template_Settings = new WP_Plugin_Template_Settings();

            // Register custom post types
            require_once(sprintf("%s/post-types/post_type_template.php", dirname(__FILE__)));
            $Post_Type_Template = new Post_Type_Template();

            $plugin = plugin_basename(__FILE__);
            add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));

        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate

        // Add the settings link to the plugins page
        function plugin_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=wp_plugin_template">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }


    } // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if(class_exists('WP_Plugin_Template'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WP_Plugin_Template', 'activate'));
    register_deactivation_hook(__FILE__, array('WP_Plugin_Template', 'deactivate'));



    // instantiate the plugin class
    $wp_plugin_template = new WP_Plugin_Template();

}

add_action( 'admin_footer', 'wp_action_javascript' );

function wp_action_javascript() {

    ?>

    <script type="text/javascript">

        jQuery (function buttonClicked ($) {

            $(" #button ").click( function () {
                $a = $( " #meta-text " ).val();
                $b = $( " #meta-multi-select " ).val();
                $c = $( " #meta-add-img " ).val();
                $d = <?php the_ID(); ?>;

                var data = {
                    'action' : 'my_action',
                    'text'   : $a,
                    'select' : $b,
                    'file'   : $c,
                    'post'   : $d
                };

                $.post( ajaxurl, data, function ( response ) {
                    alert( response );
                });

            });

        });

    </script>

<?php
}

add_action( 'wp_ajax_my_action', 'wp_action_callback');

function wp_action_callback()
{
    global $homework_db;

    $post_id = $_POST['post'];

    update_post_meta($post_id, 'meta-text', $_POST['text']);
    update_post_meta($post_id, 'meta-multi-select', $_POST['select']);
    update_post_meta($post_id, 'meta-add-img', $_POST['file']);

    echo(' Congratulation your results saved :)');

    die();
};
