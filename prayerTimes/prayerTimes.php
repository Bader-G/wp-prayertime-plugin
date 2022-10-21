<?php
/**
 * @package PrayerTimes
 */
/*
Plugin Name: Prayer Times Bar
Plugin URI: https://bader-g.github.io
Description: A bar on top of the site to show prayer times
Version: 1.1
Author: Bader
Author URI: https://bader-g.github.io
License: GPLv2 or later
Text Domain: prayerTimes
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
define( 'PRAYERTIMES__PLUGIN_DIR', plugin_dir_path(__FILE__) );

require_once( PRAYERTIMES__PLUGIN_DIR . 'admin/class.prayerTimes.php' );
require_once( PRAYERTIMES__PLUGIN_DIR . 'admin/api.php' );
require_once( PRAYERTIMES__PLUGIN_DIR . 'admin/settings.php' );


function my_load_scripts() {
   wp_register_script( 'prayerTimes_js', plugin_dir_url( __FILE__ ) . '_inc/prayerTimes.js?v=1.2.1');
   wp_register_style( 'prayerTimes_css',    plugin_dir_url( __FILE__ ) . '_inc/style.css',   '1.1' );
   wp_enqueue_style ( 'prayerTimes_css' );
   wp_register_style( 'dashicon',    includes_url() . 'css/dashicons.min.css', '1.0' );
   wp_enqueue_style('dashicon');

$dataToBePassed = array(
    'home'            => get_site_url(),
);
wp_localize_script( 'prayerTimes_js', 'php_vars', $dataToBePassed );
wp_enqueue_script( 'prayerTimes_js' );

}
add_action('wp_enqueue_scripts', 'my_load_scripts');

add_action('wp_footer', 'my_view_function');
function my_view_function() {
    $file = dirname( __FILE__ )  . '/views/prayerBar.php';
    include($file);
}



