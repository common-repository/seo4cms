<?php
/*
Plugin Name: SEO4CMS
Plugin URI: https://seo.goldorange.app/
Description: Nutze SEO4CMS um deine Website oder Blog für Suchmaschinen zu optimieren. Du kannst jede Seite oder jeden Beitrag auf dem SEO-Dashboard aufrufen und auf fehlende Auszeichnungen überprüfen und auf ein passendes Keyword optimieren. Um zu beginnen: Aktiviere das SEO4CMS Plugin und gehe dann auf deine Einstellungen-Seite, um deine Nutzer-ID und deinen API-Schlüssel einzurichten.
Author: Lars Flick
Version: 1.0.7.1
Author URI: https://www.goldorange.com/
License: GPLv2 or later
*/

// Direkten Aufruf verhindern
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu', 'seo4cms_plugin_setup_menu');

//registering javascript and css
 wp_register_script ( 'seo4cms-js', plugins_url ( '_inc/js/seo4cms.js', __FILE__ ) );
 wp_register_style ( 'seo4cms-css', plugins_url ( '_inc/css/seo4cms.css', __FILE__ ) );

function seo4cms_plugin_setup_menu(){
	add_menu_page( 'SEO4CMS Plugin Page', 'SEO4CMS', 'manage_options', 'seo4cms-plugin', 'seo4cms' );
}

function seo4cms(){
	// check if user has permissions to access this page
	if(!current_user_can("manage_options")) {
		wp_die(__("You do not have sufficient permissions to access this page."));
	}

	//implementing the registerd javascript and css in the page
	wp_enqueue_script('seo4cms-js');
	wp_enqueue_style('seo4cms-css');

	// start ob to handle easier output
	ob_start();

	include_once (WP_PLUGIN_DIR . '/seo4cms/dashboard-view.php');

	// get all written stuff
	echo ob_get_clean();
}

/* Register meta box(es). */
function seo4cms_register_meta_boxes() {
  add_meta_box( 'meta-box-seo4cms', __( 'SEO4CMS', 'textdomain' ), 'seo4cms_display_callback', 'post', 'side', 'default'); // for Posts
	add_meta_box( 'meta-box-seo4cms', __( 'SEO4CMS', 'textdomain' ), 'seo4cms_display_callback', 'page', 'side', 'default'); // for Pages
}
add_action( 'add_meta_boxes', 'seo4cms_register_meta_boxes' );

function seo4cms_display_callback($post) {
  // here the Display code/markup
  $url = "https://seo.goldorange.app/dashboard/?id=".esc_attr(get_option("seo4cms_plugin_uid")) ."&c=".esc_attr(get_option("seo4cms_plugin_key"))."&url=".urlencode(get_permalink($post->ID));
	echo "<a class=\"components-external-link\" href=\"".$url."\" target=\"_blank\" rel=\"external\" type=\"buttonv\">SEO4CMS Dashboard aufrufen <span class=\"screen-reader-text\">(öffnet in neuem Tab)</span><svg aria-hidden=\"true\" role=\"img\" focusable=\"false\" class=\"dashicon dashicons-external components-external-link__icon\" xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" viewBox=\"0 0 20 20\"><path d=\"M9 3h8v8l-2-1V6.92l-5.6 5.59-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z\"></path></svg></a>";
}
?>
