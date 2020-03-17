<?php
/**
 * Plugin Name: Goodlayers Soccer
 * Plugin URI: http://goodlayers.com/
 * Description: 
 * Version: 2.0.0
 * Author: Goodlayers
 * Author URI: http://goodlayers.com/
 * License: 
 */
	
	include_once('framework/meta-template.php');
	include_once('framework/player-option.php');
	include_once('framework/league-table-option.php');
	include_once('framework/fixtures-results-option.php');
	include_once('framework/admin-option.php');
	
	include_once('include/utility.php');
	include_once('include/player-item.php');
	include_once('include/league-table-item.php');
	include_once('include/fixture-result-item.php');
	
	// action to load plugin script
	// include script for front end
	add_action( 'wp_enqueue_scripts', 'gdlr_soccer_include_script' );
	function gdlr_soccer_include_script(){
		wp_enqueue_script( 'gdlr-soccer-script', plugins_url('javascript/gdlr-soccer.js', __FILE__), array(), '1.0.0', true );
	}
	
	// action to loaded the plugin translation file
	add_action('plugins_loaded', 'gdlr_soccer_textdomain_init');
	if( !function_exists('gdlr_soccer_textdomain_init') ){
		function gdlr_soccer_textdomain_init() {
			load_plugin_textdomain('gdlr-soccer', false, dirname(plugin_basename( __FILE__ ))  . '/languages/'); 
		}
	}


	register_activation_hook(__FILE__, 'gdlr_soccer_plugin_activate');
	if( !function_exists('gdlr_soccer_plugin_activate') ){
		function gdlr_soccer_plugin_activate() {
			global $wpdb;

			$results = $wpdb->get_results("SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = 'gdlr-soccer-player-settings'");

			foreach($results as $result){
				$player_options = json_decode(gdlr_lms_decode_preventslashes($result->meta_value), true);
				if( !empty($player_options['player-stats']['goals']) ){
					update_post_meta($result->post_id, 'gdlr-soccer-player-goals', $player_options['player-stats']['goals']);
				}
			}
		}
	}
	
?>