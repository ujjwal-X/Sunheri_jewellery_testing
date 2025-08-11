<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Keon Toolset
Plugin URI:  
Description: A demo importer plugin that makes importing starter sites effortless for building your website!
Version:     2.1.8
Author:      Keon Themes
Author URI:  https://keonthemes.com
License:     GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /languages
Text Domain: keon-toolset
*/
define( 'KEON_TOOLSET_URL', plugin_dir_url( __FILE__ ).'demo/' );
define( 'KEON_TEMPLATE_URL', plugin_dir_url( __FILE__ ) );
define( 'KEON_TOOLSET_PATH', plugin_dir_path( __FILE__ ) );
define( 'KEON_TOOLSET_VERSION', '2.1.8');

/**
 * Returns the currently active theme's name.
 *
 * @since    1.0.1
 */
function keon_toolset_get_theme_slug(){
    $demo_theme = wp_get_theme();
   	return $demo_theme->get( 'TextDomain' );
}

/**
 * Returns the currently active theme's screenshot.
 *
 * @since    1.0.0
 */
function keon_toolset_get_theme_screenshot(){
	$demo_theme = wp_get_theme();
    return $demo_theme->get_screenshot();
}
/**
 * The core plugin class that is used to define internationalization,admin-specific hooks, 
 * and public-facing site hooks..
 *
 * @since    1.0.0
 */   
require KEON_TOOLSET_PATH . 'demo/functions.php';
require KEON_TOOLSET_PATH . 'includes/class-template-library-base.php';
require KEON_TOOLSET_PATH . 'includes/theme-check-functions.php';
require KEON_TOOLSET_PATH . 'includes/admin-notices.php';
if ( keon_toolset_theme_check( 'bosa' ) && !keon_toolset_theme_check( 'bosa-pro' ) ){
    require KEON_TOOLSET_PATH . 'includes/class-bosa-pro-upgrade-notice.php';
}

/**
 * Register all of the hooks related to the admin area functionality
 * of the plugin.
 *
 * @since    1.0.0
 */
$plugin_admin = keon_toolset_hooks();
add_filter( 'advanced_import_demo_lists', array( $plugin_admin,'keon_toolset_demo_import_lists'), 10, 1 );
add_filter( 'admin_menu', array( $plugin_admin, 'import_menu' ), 10, 1 );
add_filter( 'wp_ajax_keon_toolset_getting_started', array( $plugin_admin, 'install_advanced_import' ), 10, 1 );
add_filter( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ), 10, 1 );
add_filter( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ), 10, 1 );
add_action( 'advanced_import_replace_term_ids', array( $plugin_admin, 'replace_term_ids' ), 20 );
add_action( 'advanced_import_replace_post_ids', array( $plugin_admin, 'replace_attachment_ids' ), 30 );

if( ( keon_toolset_theme_check( 'shoppable' ) && !keon_toolset_theme_check( 'hello-shoppable' ) ) || ( keon_toolset_theme_check( 'bosa-media-marketing' ) || keon_toolset_theme_check( 'bosa-business-firm' ) || keon_toolset_theme_check( 'bosa-photograph' ) || keon_toolset_theme_check( 'bosa-interior-design' ) || keon_toolset_theme_check( 'bosa-cleaning-service' ) || keon_toolset_theme_check( 'bosa-veterinary' ) || keon_toolset_theme_check( 'bosa-yoga' ) || keon_toolset_theme_check( 'bosa-logistics' ) || keon_toolset_theme_check( 'bosa-crypto' ) || keon_toolset_theme_check( 'bosa-clinic' ) || keon_toolset_theme_check( 'bosa-it-services' ) || keon_toolset_theme_check( 'bosa-university' ) || keon_toolset_theme_check( 'bosa-creative-agency' ) || keon_toolset_theme_check( 'bosa-garden-care' ) || keon_toolset_theme_check( 'bosa-construction-company' ) || keon_toolset_theme_check( 'bosa-travel-agency' ) || keon_toolset_theme_check( 'bosa-business-agency' ) || keon_toolset_theme_check( 'bosa-online-marketing' ) || keon_toolset_theme_check( 'bosa-law-firm' ) || keon_toolset_theme_check( 'bosa-veterinary-care' ) || keon_toolset_theme_check( 'bosa-ai-robotics-sector' ) || keon_toolset_theme_check( 'bosa-charity-firm' ) || keon_toolset_theme_check( 'bosa-restaurant-inn' ) || keon_toolset_theme_check( 'bosa-business-solutions' ) || keon_toolset_theme_check( 'bosa-portfolio-bio' ) || keon_toolset_theme_check( 'bosa-event-organizer' ) ) ){
    require KEON_TOOLSET_PATH . 'demo/base-install/base-install.php';
    add_action('advanced_import_after_complete_screen', array( $plugin_admin, 'kt_advance_import' ));
    add_action('advanced_import_after_content_screen', array( $plugin_admin, 'kt_advance_import_transient' )); 
}
