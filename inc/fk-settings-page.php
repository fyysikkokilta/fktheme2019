<?php 
/**
 * Create Theme options page for FK2019 Theme
 * 
 * As seen on https://www.wpexplorer.com/wordpress-theme-options/
 */

 // Exit if accessed directly
 if(!defined('ABSPATH')){
     exit;
 }

 if(!class_exists('fk_theme_settings')) {
     class fk_theme_settings {

        /**
         * Register at admin site
         */
        public function __construct() {
            if(is_admin()){
                add_action('admin_menu', array('fk_theme_settings', 'add_admin_menu'));
                add_action('admin_init', array('fk_theme_settings', 'register_settings'));
            }
        }

        /**
         * Return all theme options
         */
        public static function get_theme_options() {
            return get_option('theme_options');
        }

         /**
          * Return theme option by id
          */
        public static function get_theme_option($id) {
            $options = self::get_theme_options();
            if (isset($options[$id])) {
                return $options[$id];
            }
        }

        /**
         * Add menu page
         */
        public static function add_admin_menu() {
            add_menu_page(
                'Theme Settings',
                'Theme Settings',
                'manage_options',
                'fk-theme-settings',
                array('fk_theme_settings', 'create_admin_page')
            );
        }

        /**
         * Register setting
         * 
         * We will register only one setting, and store all options in a single option
         * as an array. Could also register multiple settings, but then functions above
         * would have to be redesigned
         */

        public static function register_settings() {
            register_setting('theme_options', 'theme_options', array('fk_theme_settings', 'sanitize'));
        }

        /**
         * Sanitazion
         * 
         * This has to be edited regarding to the settings
         */

        public static function sanitize($options) {
            // if there is options, sanitize
            if($options) {

                // IG token
                if ( ! empty( $options['ig_token'] ) ) {
					$options['ig_token'] = sanitize_text_field( $options['ig_token'] );
				} else {
					unset( $options['ig_token'] ); // Remove from options if empty
                }
                
                // Cache timeout
                if ( ! empty( $options['cache_timeout'] ) ) {
					$options['cache_timeout'] = sanitize_text_field( $options['cache_timeout'] );
				} else {
					unset( $options['cache_timeout'] ); // Remove from options if empty
				}
                
            }
            return $options;

        }

        /**
         * Settings page itself
         */
        
        public static function create_admin_page() { ?>
            <div class="wrap">

            <h1><?php esc_html_e( 'Theme Options', 'text-domain' ); ?></h1>

            <form method="post" action="options.php">

                <?php settings_fields( 'theme_options' ); ?>

                <table class="form-table fk-custom-admin-login-table">

                    <?php // Checkbox example ?>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Instagram API token', 'text-domain' ); ?></th>
                        <td>
                            <?php $value = self::get_theme_option( 'ig_token' ); ?>
                            <input type="text" name="theme_options[ig_token]" value="<?php echo esc_attr( $value ); ?>">
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Cache timeout (seconds)', 'text-domain' ); ?></th>
                        <td>
                            <?php $value = self::get_theme_option( 'cache_timeout' ); ?>
                            <input type="text" name="theme_options[cache_timeout]" value="<?php echo esc_attr( $value ); ?>">
                        </td>
                    </tr>

                </table>

                <?php submit_button(); ?>

            </form>

            </div><!-- .wrap -->
            <?php }
    }
 }

new fk_theme_settings();

// Helper function to use in your theme to return a theme option value
function fk_get_theme_option( $id = '' ) {
	return fk_theme_settings::get_theme_option( $id );
}
