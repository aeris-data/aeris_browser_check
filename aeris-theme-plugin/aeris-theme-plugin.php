/*
Plugin Name: Aeris Theme Plugin
Plugin URI: http://github.com/aeris-data/aeris-theme-plugin
Description: Add theme in webcomponent for plugin wordpress
Version: 0.0.1
Author: Miled
Author URI: http://github.com/aeris-data/aeris-theme-plugin
License: MIT License
Text Domain: wordpress-social-login
Domain Path: /languages
*/

<?php 


add_action('wp_head', 'aeris_orcid_import_components');


add_action( 'init', 'aeris_load_scripts_orcid' );



function aeris_orcid_import_components() {
	
	if(!is_customize_preview() && !is_admin() ) {

		echo '<script type="text/javascript" component="aeris-data/aeris-commons-components-vjs@latest" src="https://rawgit.com/aeris-data/aeris-component-loader/master/aerisComponentLoader.js" ></script>';
	
	}
}




?>