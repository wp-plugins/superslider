<?php
/*
Plugin Name: SuperSlider
Plugin URI: http://wp-superslider.com/superslider
Description: In production. 
Author: Daiv Mowbray
Version: 0.0
Author URI: http://wp-superslider.com
Tags: animation, animated, gallery, slideshow, mootools 1.2, mootools, slider, superslider, menu, lightbox

Copyright 2008
       SuperSlider-Show is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License as published by 
    the Free Software Foundation; either version 2 of the License, or (at your
    option) any later version.

    SuperSlider-show is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Collapsing Categories; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists("ss-Base")) {
	class ss-Base {
		
		/**
		* @var string   The name of this class.
		*/
	var $my_name;

	
	// Pre-2.6 compatibility
	function set_base_paths()
	{
		if ( !defined( 'WP_CONTENT_URL' ) )
			define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
		if ( !defined( 'WP_CONTENT_DIR' ) )
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		if ( !defined( 'WP_PLUGIN_URL' ) )
			define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
		if ( !defined( 'WP_PLUGIN_DIR' ) )
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
		if ( !defined( 'WP_LANG_DIR') )
			define( 'WP_LANG_DIR', WP_CONTENT_DIR . '/languages' );

	}
		/**
		* PHP 4 Compatible Constructor
		*/
	function ss_show(){$this->__construct();}
		
		/**
		* PHP 5 Constructor
		*/		
	function __construct(){
		
		self::ss-Base();
	
	}// end construct


}	//end class
} //End if Class ssShow

/**
*instantiate the class
*/	
if (class_exists('ss-Base')) {
	$ss-Base = new ss-Base();
}
?>