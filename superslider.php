<?php
/*
Plugin Name: SuperSlider
Plugin URI: http://superslider.daivmowbray.com/superslider/
Description: SuperSlider base, is an optional global admin plugin for all SuperSlider plugins. Superslider base also includes the numerous web 2 motion modules.
Author: Daiv Mowbray
Author URI: http://superslider.daivmowbray.com
Version: 1.6

Credits:


Image reflect - http://www.digitalia.be/software/reflectionjs-for-mootools
Image zoomer - http://www.byscripts.info/mootools/byzoomer
Multiple Accordion - http://www.clientcide.com/wiki/cnet-libraries/08-layout/02.1-multipleopenaccordion
Page Scroller _ http://superslider.daivmowbray.com/superslider
Link Nudger - http://www.nwhite.net/2009/02/07/insights-from-link-nudging/
Fader - http://davidwalsh.name/opacity-focus 
Linker - http://davidwalsh.name/iphone-click 
Word wrap - http://davidwalsh.name/word-wrap-mootools-php (not activated)
Clickable - http://davidwalsh.name/dwclickable-entire-block-clickable-mootools

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

if (!class_exists("ssBase")) {
	class ssBase {
		
		/**
		* @var 
		*/
		var $my_id;
		var $my_acc_id;
		var $js_path;
		var $css_path;
		var $base_over_ride;
		var $Slim_over_ride;
		var $ssBaseOpOut;
		var $ssModOpOut;
		var $defaultOptions;
		var $AdminOptionsName = 'ssBase_options';
		var $reflect_started = 'false';
		var $reflect_script_added = 'false';
		var $zoom_started = 'false';
		var $has_zoomed = 'false';
		var $has_modal = 'false';
		var $modal_started ='false';
		var $nudger_started = 'false';
		var $fader_started = 'false';
		var $scroll_started = 'false';
		var $clicker_started = 'false';
		var $link_started = 'false';
		var $open_addEvent = '';
		var $close_addEvent = '';
	
	// Pre-2.6 compatibility
	function set_base_paths($css_load, $css_theme) {
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
        if ($css_load == 'default'){
            $this->css_path = WP_PLUGIN_URL.'/superslider/plugin-data/superslider/ssBase/'.$css_theme;	
        }elseif ($css_load == 'pluginData') {
            $this->css_path = WP_CONTENT_URL.'/plugin-data/superslider/ssBase/'.$css_theme;
        }elseif ($css_load == 'theme') {
            $this->css_path = get_stylesheet_directory_uri().'/plugin-data/superslider/ssBase/'.$css_theme;
        }elseif ($css_load == 'off') {
            $this->css_path = '';
        }
	}
		/**
		* PHP 4 Compatible Constructor
		*/
	function ssBase(){
	   ssBase::Base();
	}
		
		/**
		* PHP 5 Constructor
		*/		
	function __construct(){		
		self::Base();
	
	}// end construct
	
	
	function Base(){

        register_activation_hook(__FILE__, array(&$this,'ssBase_init') ); //http://codex.wordpress.org/Function_Reference/register_activation_hook
        register_deactivation_hook( __FILE__, array(&$this,'ssBase_ops_deactivation') ); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
        
        add_action( 'init', array(&$this,'ssBase_init' ) );
        add_action ( "admin_menu", array(&$this,"acc_print_box" ) ); 			// adds the shortcode meta box
        add_action ( 'admin_menu', array(&$this,'ssBase_setup_optionspage'));
        
	}
	
			/**
		* Retrieves the options from the database.
		* @return array
		*/			
	function set_default_admin_options() {
		
		$defaultOptions = array(
				"load_moo" => "on",
				"css_load" => "default",		
				"css_theme" => "default",
				"ss_global_over_ride" => "on",
				'delete_options' => 'off');
			
		$defaultModOptions = array(
				"reflect"	=>	"on",
				"reflect_height" => "0.33",
				"reflect_opacity" => "0.5",
				"auto_reflect" => "off",
				"accordion" => "on",
				"acc_mode" => "off",
				"acc_css"       =>  "on",	
				"auto_accordion" => "on",
				"acc_container" => "accordion",
				"acc_toggler" => "toggler",
				"acc_elements" => "togcontent",
				"acc_togtag" => "h3",
                "acc_elemtag" => "div",
				"acc_openall" => "false",
				"acc_fixedheight" => "",
				"acc_fixedwidth"  => "",
				"acc_height"    => "true",
				"acc_width"     => "false",
				"acc_opacity"   => "true",
				"acc_firstopen" => "0",
				"zoom"      => "on",
				"zoom_auto"      => "off",
				"zoom_time" => "1250",
				"zoom_trans_type"      => "sine",
				"zoom_trans_typeinout" => "out",
				"zoom_border"   =>  "10px solid silver",
				"zoom_pad"      =>  "10",
				"zoom_back"     =>  "#000",
				"scroll"           =>  "on",
				"scroll_auto"      =>  "on",
				"scroll_css"       =>  "on",				
				"scroll_time"      =>  "1200",
				"scroll_trans"     =>  "sine",
				"scroll_transout"  =>  "out",
				
				"tooltips"   =>  "on",
				"toolClass"	=> ".tooltips",
				"tt_showDelay"   =>  "1250",
				"tt_hideDelay"   =>  "950",
				"tt_offsetx"   =>  "40",
				"tt_offsety"   =>  "0",
				"tt_fixed"   =>  "true",
				"tt_tip_opacity"   =>  "0.8",
				"tipTitle" => 'title',
		        "tipText" => 'rel',
		        
				"totop_text"  =>  "goin up",				
				"modal"       =>  "off",
				"modal_css"   =>  "on",
				"modal_link" => "mmlink",
				"modal_width" => "220px",
				"modal_height" => "120px",
				"modal_box" => "mmbox",
				"modal_title"  =>  "myBox",
				"modal_overlay" => 'true',
        		"modal_overlay_color" => '#fff',
        		"modal_transition" => 'bouncefly',
        		"modal_buttons" => 'true',
        		"modal_button_text1" => 'Cancel',
        		"modal_button_text2" => 'OK',
				
				"moodropmenu" => 'off',
				"moomenu" => 'menu-main',
				
				"pro_code" => '',
				
				"com_trans"      =>  "sine",
				"com_transout"   =>  "out",
				"com_direction"   =>  "vertical",
				"com_open"        =>  "Open comments",
				"com_close" => "Close comments",
				
				"nudger" => "on",
				"nudge_amount" => "10",
                "nudge_duration" => "500",
                "nudge_family" => "#footer a, #sidebar a",
                "fader" => "on",
                "fader_family" => ".fader",
                "fader_opacity" => "0.5",
                "linker" => "on",
                "linker_tag" => "a",
                "linker_color" => "#4C8FC7",
                "clicker" => "on",
                "clicker_tag" => ".clickable li",
                "clicker_span" => "false",
                "clicker_color" => "#c9e0f4"
				);
		
		
		$getOptions = get_option($this->AdminOptionsName);
        $getModOptions = get_option('ssMod_options');

		if (!empty($getOptions)) {
			foreach ($getOptions as $key => $option) {
				$defaultOptions[$key] = $option;
			}
			
		}
		if (!empty($getModOptions)) {
		      foreach ($getModOptions as $key => $option) {
				$defaultModOptions[$key] = $option;
			}
		}
		update_option($this->AdminOptionsName, $defaultOptions);
		update_option('ssMod_options', $defaultModOptions);
		
	}		
		/**
		* load default options into data base
		* set up scripts
		*/		
	function ssBase_init() {
  		
  		// loading language files
			//load_plugin_textdomain('superslider', false, WP_CART_FOLDER . '/languages');
			

  			$this->defaultAdminOptions = $this->set_default_admin_options();
  			$this->ssBaseOpOut = get_option($this->AdminOptionsName);
  			$this->ssModOpOut = get_option('ssMod_options');
	           
  			extract($this->ssBaseOpOut);
  			extract($this->ssModOpOut);
            
  			$this->base_over_ride = $ss_global_over_ride;  			
  			$this->set_base_paths($css_load, $css_theme);
  			
  			$this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
  			$admin_js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/admin/js/';
  			
  			wp_register_script('moocore',$this->js_path.'mootools-core-1.4.5-full-compat-yc.js',NULL, '1.4.5');
			wp_register_script('moomore',$this->js_path. 'mootools-more-1.4.0.1.js',array( 'moocore' ), '1.4.0.1');
			
			wp_register_script('multiopen-accordion',$this->js_path.'multiopen-accordion.js',array( 'moomore' ), '1');			
			wp_register_script('byzoomer',$this->js_path.'byzoomer.js',array( 'moomore' ), '1');
			wp_register_script('mBox',$this->js_path.'mBox/mBox.Core.js',array( 'moomore' ), '1');
			wp_register_script('mBox_tooltip',$this->js_path.'mBox/mBox.Tooltip.js',array( 'mBox' ), '1');
			wp_register_script('mBox_modal',$this->js_path.'mBox/mBox.Modal.js',array( 'mBox' ), '1');
			wp_register_script('mBox_modal_confirm',$this->js_path.'mBox/mBox.Modal.Confirm.js',array( 'mBox_modal' ), '1');
			
			wp_register_style('accordion_style', $this->css_path.'/accordion.css');
			wp_register_style('scroll_style', $this->css_path.'/scroll.css');
			wp_register_style('mBox_core', $this->css_path.'/mBox/mBoxCore.css');
			wp_register_style('mBox_tooltip_style', $this->css_path.'/mBox/mBoxTooltip.css');
			wp_register_style('mBox_modal_style', $this->css_path.'/mBox/mBoxModal.css');
			
			$cssAdminPath = WP_PLUGIN_URL.'/superslider/admin/';    			
    		
    		wp_register_style('superslider_admin', $cssAdminPath.'ss_admin_style.css');
    		wp_register_style('superslider_admin_tool', $cssAdminPath.'ss_admin_tool.css');
  			
  			wp_register_script( 'jquery-dimensions', $admin_js_path.'jquery.dimensions.min.js', array( 'jquery-ui-core' ), '2', false);
  			wp_register_script( 'jquery-tooltip', $admin_js_path.'jquery.tooltip.min.js', array( 'jquery-dimensions' ), '2', false);
  			wp_register_script( 'superslider-admin-tool', $admin_js_path.'superslider-admin-tool.js', array( 'jquery', 'jquery-tooltip' ), '2', false);

  			if (!is_admin()) add_action('wp_enqueue_scripts', array(&$this,'ssBase_add_javascript'),3); //this loads the mootools scripts.
            
            if ($moodropmenu == 'on') {
            	wp_register_script('moodropmenu',$this->js_path.'MooDropMenu.js',array( 'moomore' ), '1');
            	wp_register_style('moodropmenu_style', $this->css_path.'/MooDropMenu.css');
            	if (!is_admin()) {
            		wp_enqueue_script('moodropmenu');
            		wp_enqueue_style('moodropmenu_style');
            		add_action ( "wp_footer", array(&$this,"moodropmenu_starter"));
            	}
            }
            
            if ( $accordion == 'on'){  
                  //add_action ( 'template_redirect' , array(&$this,'accordion_scan') );	// Add look ahead for accordion
                  add_shortcode ( 'accordion' , array(&$this, 'accordion_shortcode_out'));
            }
            if ( $zoom == 'on'){  
                  add_action ( "template_redirect" , array(&$this,"zoom_scan") ); 
                  add_shortcode ( 'zoom' , array(&$this, 'zoom_shortcode_out') );
                  add_action( 'admin_print_scripts', array(&$this,'zoom_footer_admin') );
                if ( $zoom_auto == 'on'){ 
                     add_filter( 'the_content', array(&$this, 'zoom_replace') );
                     if (!is_admin()) wp_enqueue_script('byzoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }    
            }
            if ( $scroll == 'on'){  
            	add_action( 'admin_enqueue_scripts', array(&$this,'scroll_quicktag') );
			    add_action ( 'template_redirect' , array( &$this,'scroll_scan' ) );   
            }          
            if ( $tooltips == 'on'){  
                 add_action ( 'wp_footer', array( &$this, 'tooltip_starter' ) );
                 if (!is_admin()) {
                 	wp_enqueue_script('mBox');
                	wp_enqueue_script('mBox_tooltip');
			     	$this->tooltip_add_css();
			     	}
            }
            if ( $scroll_auto == 'on'){  
			     add_action ( 'wp_footer', array(&$this,'scroll_button_out'));
			     add_action ( "wp_footer", array(&$this,"scroll_starter"));
			     if ($css_load != 'off' && $scroll_css == 'on') {
			         if (!is_admin()) $this->scroll_add_css();
			     }
            }
            if ( $reflect == 'on'){	
			      if (!is_admin()) add_action ( 'template_redirect' , array(&$this,'reflect_scan') );
                  add_shortcode ( 'reflect' , array(&$this, 'reflect_shortcode_out') ); 
                  add_action( 'admin_enqueue_scripts', array(&$this, 'reflect_quicktags') );

               if ( $auto_reflect == 'on'){       
                     add_filter( 'the_content', array(&$this, 'reflect_replace') );
                }        
            }
            if ( $modal == 'on'){	
            	add_action( 'admin_enqueue_scripts', array(&$this, 'modal_quicktags') );
            	add_shortcode ( 'modal' , array(&$this, 'modal_shortcode_out') );	
            }
            if ( $nudger == 'on'){                  
                   if (!is_admin()) add_action ( "wp_footer", array(&$this,"nudger_starter"));   
            }
            if ( $fader == 'on'){   
                   if (!is_admin()) add_action ( "wp_footer", array(&$this,"fader_starter"));   
            }
            if ( $clicker == 'on'){                    
                   if (!is_admin()) add_action ( "wp_footer", array(&$this,"clicker_starter"));
                   if (!is_admin()) add_action ( "wp_head", array(&$this,"clicker_add_css"));
            }
            if ( $linker == 'on'){
                   if (!is_admin()) add_action ( "wp_footer", array(&$this,"link_starter"), 10, 1);
                   if (!is_admin()) add_action ( "wp_head", array(&$this,"link_css"), 10, 1);   
            }
            /*
            if ( $com == 'on' ){             
                 add_filter( 'comments_template', array(&$this,"com_slide_out"), 10 );
                 add_action('template_redirect', array(&$this,'comments_scan' ) );                   
            }*/
	}
	
		/**
		* Initialize the admin panel, Add the plugin options page, loading in admin css and js
		*/
	function ssBase_setup_optionspage() {

		if (  function_exists('add_menu_page') ) {
			if (  current_user_can('manage_options') ) {
				add_filter ( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_base'), 'manage_options', 2 );
				
				$page = add_menu_page( 'SuperSlider', ' SuperSlider ', 'manage_options', 'superslider_options', array(&$this, 'ssBase_ui'), plugins_url('superslider/admin/img/logo_mini.png'));
				add_action('admin_print_scripts-'.$page, array(&$this,'ss_admin_script'));
				add_action ( 'admin_print_scripts-'.$page, array(&$this,'ss_admin_style'));	
				
				$sub_page = add_submenu_page('superslider_options', 'SuperSlider', ' SS -- Modules', 'manage_options', 'superslider-modules', array(&$this, 'ssBase_mod_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
			}					
		}
		
	if (function_exists('add_submenu_page')) {
	
		if (class_exists('ssShow')) {
				remove_submenu_page( 'options-general.php', 'superslider-show' );
				$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Show'), __(' SS -- Show '), 'manage_options', 'superslider-show', array(&$this, 'ssShow_ui'));
	    		add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
	    }
	    if (class_exists('ssMenu')){
	    		remove_submenu_page( 'options-general.php', 'superslider-menu' );
	    		$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Menu'), __(' SS -- Menu '), 'manage_options', 'superslider-menu', array(&$this, 'ssMenu_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));	    		
	    }
	    if (class_exists('ssImage')) {
	    		remove_submenu_page( 'options-general.php', 'superslider-image' );
	    		$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Image'), __(' SS -- Image '), 'manage_options', 'superslider-image', array(&$this, 'ssImage_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
		}
	    if (class_exists('ssPnext')){
	    		remove_submenu_page( 'options-general.php', 'superslider-pnext' );
	    		$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Pnext'), __(' SS -- PreviousNext'), 'manage_options', 'superslider-pnext', array(&$this, 'ssPnext_ui'));
	   			add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
		}
	    if (class_exists('ssSlim')) {
	    		remove_submenu_page( 'options-general.php', 'superslider-slimbox' );
	    		$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Slimbox'), __(' SS -- Slimbox'), 'manage_options', 'superslider-slimbox', array(&$this, 'ssSlim_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
		}
		if (class_exists('ssExcerpt')) {
				remove_submenu_page( 'options-general.php', 'superslider-excerpt' );
				$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Excerpt'), __(' SS -- Excerpt'), 'manage_options', 'superslider-excerpt', array(&$this, 'ssExcerpt_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
		}
		if (class_exists('ssLogin')) {
				remove_submenu_page( 'options-general.php', 'superslider-login' );
				$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Login'), __(' SS -- Login'), 'manage_options', 'superslider-login', array(&$this, 'ssLogin_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
		}
		
		if (class_exists('ssScale')) {
				remove_submenu_page( 'options-general.php', 'superslider-login' );
				$sub_page = add_submenu_page('superslider_options', __('SuperSlider-Scale'), __(' SS -- Scale'), 'manage_options', 'superslider-scale', array(&$this, 'ssScale_ui'));
				add_action ( 'admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_style'));	
				add_action('admin_print_scripts-'.$sub_page, array(&$this,'ss_admin_script'));
		}
	   }

	}
	
	
		/**
		* Load admin options page
		*/
	function ssBase_ui() {		
		$ssBase_domain = 'superslider';
		include_once 'admin/superslider-ui.php';
		
	}
	function ssBase_mod_ui() {		
		$ssBase_domain = 'superslider';
		include_once 'admin/superslider-modules-ui.php';
		
	}
	function ssShow_ui($name) {
	   $name = 'show';
	   if (class_exists('ssSlim')) $this->Slim_over_ride = 'true';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssMenu_ui($name) {
	   $name = 'menu';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssImage_ui($name) {
	   $name = 'image';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssPnext_ui($name) {
	   $name = 'pnext';
	   include_once WP_PLUGIN_DIR.'/superslider-previousnext-thumbs/admin/superslider-'.$name.'-ui.php';
	}
    function ssSlim_ui() {
	   $name = 'slimbox';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssCera_ui() {
	   $name = 'cerabox';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssExcerpt_ui() {
	   $name = 'excerpt';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssLogin_ui() {
	   $name = 'login';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	function ssFlow_ui() {
	   $name = 'flow';
	   include_once WP_PLUGIN_DIR.'/superslider-mooflow/admin/superslider-'.$name.'-ui.php';
	}
	function ssScale_ui() {
	   $name = 'scale';
	   include_once WP_PLUGIN_DIR.'/superslider-'.$name.'/admin/superslider-'.$name.'-ui.php';
	}
	
		/**
		* Add link to options page from plugin list WP 2.6.
		*/
	function filter_plugin_base($links, $file) {
		 static $this_plugin;
			if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

		if (  $file == $this_plugin )
			$settings_link = '<a href="admin.php?page=superslider_options">'.__('Settings').'</a>';
			array_unshift( $links, $settings_link ); //  before other links
			return $links;
	}
	
		/**
		* Removes user set options from data base upon deactivation
		*/		
	function ssBase_ops_deactivation(){
		if($this->ssBaseOpOut['delete_options'] == true){
		  delete_option($this->AdminOptionsName);
		  delete_option('ssMod_options');
		}
	}

	function ssBase_add_javascript(){
		extract($this->ssBaseOpOut);

			if (!is_admin()) {				
				if (function_exists('wp_enqueue_script')) {
					if ($load_moo == 'on'){
						wp_enqueue_script('moocore');		
						wp_enqueue_script('moomore');	
					}
				}
			}// is not admin
	}

	/**
	* add the ss admin css if over ride
	*/
	function ss_admin_style(){     	
        	wp_enqueue_style( 'superslider_admin');
    	    wp_enqueue_style( 'superslider_admin_tool');

	}
	
	function ss_admin_script(){
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-core');
            wp_enqueue_script( 'jquery-ui-tabs');
            //wp_enqueue_script( 'jquery-dimensions' );
            wp_enqueue_script( 'jquery-tooltip' );
            wp_enqueue_script( 'superslider-admin-tool' );
	}
	
	function ss_change_options( $atts ){
		global $post;
 
		$this->ssModOpOut = array_merge($this->ssModOpOut, array_filter($atts));
  		return $this->ssModOpOut;
	}

	function reflect_quicktags($hook) {
		if(('post-new.php' == $hook) || ('post.php' == $hook)) {

			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			   return;
			wp_enqueue_script('reflect_quicktags',$this->js_path. 'reflect-quicktags.js', array( 'quicktags' ));
		}
	}

    /**
    *   Reflect functions : to create the image reflections
	*	Look ahead to check if any posts contain the [reflect] shortcode
	*/
	function reflect_scan () { 
	   global $posts;
	   
        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $post ) {         
                
            if ( false !== strpos ( $post->post_content, 'reflect' ) ) {  
                    add_action ( "wp_footer", array(&$this,"reflect_starter"));
                    break; 
            } 
         }  
	}
    
    function reflect_replace($content) {
    
        $this->reflect_starter();
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect $9$10 style=\"margin:0!important\"/>";
        $content = preg_replace($pattern, $replacement, $content);
        
		return $content;
    }
    /**
    * The reflect shortcode must be enclosed , ie: [reflect][/reflect]
    */
    function reflect_shortcode_out($atts, $content){
       
        $atts = (shortcode_atts(array(
			'reflect_height' => '',
			'reflect_opacity' => ''), $atts));
			
		// opdate options if any changes with shortcode
        $this->ss_change_options($atts);
		
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect $9$10/>";
        $content = preg_replace($pattern, $replacement, $content);

        add_action ( "wp_footer", array(&$this,"reflect_starter"));
        return do_shortcode($content);
        
    }
    
    function reflect_starter(){
    
        extract($this->ssModOpOut);
               
        if ($this->reflect_started != 'true'){
			 				
			 $myreflect = '$$("img").filter(function(img) { return img.hasClass("reflect"); }).reflect({ height:'.$reflect_height.', opacity:'.$reflect_opacity.'});';

			 $this->open_addEvent() ;
			 	echo 'Element.implement({reflect:function(b){var a=this;if(a.get("tag")=="img"){b=Object.append({height:1/3,opacity:0.5},b);a.unreflect();function c(){var f=a.width,d=a.height,k,h,l,g,j;h=Math.floor((b.height>1)?Math.min(d,b.height):d*b.height);k=new Element("canvas");if(k.getContext){try{g=k.setProperties({width:f,height:h}).getContext("2d");g.save();g.translate(0,d-1);g.scale(1,-1);g.drawImage(a,0,0,f,d);g.restore();g.globalCompositeOperation="destination-out";j=g.createLinearGradient(0,0,0,h);j.addColorStop(0,"rgba(255, 255, 255, "+(1-b.opacity)+")");j.addColorStop(1,"rgba(255, 255, 255, 1.0)");g.fillStyle=j;g.rect(0,0,f,h);g.fill()}catch(i){return}}else{if(!Browser.ie){return}k=new Element("img",{src:a.src,styles:{width:f,height:d,marginBottom:h-d,filter:"FlipV progid:DXImageTransform.Microsoft.Alpha(Opacity="+(b.opacity*100)+", FinishOpacity=0, Style=1, StartX=0, StartY=0, FinishX=0, FinishY="+(h/d*100)+")"}})}k.setStyles({display:"block",border:0});l=new Element(($(a.parentNode).get("tag")=="a")?"span":"div").inject(a,"after").adopt(a,k);l.className=a.className;a.store("reflected",l.style.cssText=a.style.cssText);l.setStyles({width:f,height:d+h,overflow:"hidden"});a.style.cssText="display: block; border: 0px";a.className="reflected"}if(a.complete){c()}else{a.onload=c}}return a},unreflect:function(){var b=this,a=this.retrieve("reflected"),c;b.onload=function(){};if(a!==null){c=b.parentNode;b.className=c.className;b.style.cssText=a;b.eliminate("reflected");c.parentNode.replaceChild(b,c)}return b}});';
			 echo $myreflect;
			 $this->close_addEvent() ;  
			 
			 $this->reflect_started = 'true';	 
		}
    }
   
    /**
    *   Open the window add event
	*	
	*/   
   function open_addEvent() {
        
        $addEvent = "\n\t"."<script type=\"text/javascript\">\n";
		$addEvent .= "\t"."// <![CDATA[\n";		
		$addEvent .= "window.addEvent('domready', function() {";
        echo $addEvent;
        $this->open_addEvent = 'true';
   }
   function close_addEvent() {
    
        $closeEvent = "\n});\n";
        $closeEvent .= "// ]]>\n";
        $closeEvent .= "</script>\n";        
        echo $closeEvent;
        $this->close_addEvent = 'true';
    }
    /**
    *   Start the accordion functions
	*	Look ahead to check if any posts contain the [accordion] shortcode
	*/
	function accordion_scan () { 
	   global $posts; 
	   extract($this->ssModOpOut);

        if ( !is_array ( $posts ) ) 
        return; 	 
        foreach ( $posts as $mypost ) { 
            if ( false !== strpos ( $mypost->post_content, '[accordion' ) ) {                 
                   
               if ($acc_mode != 'on') {
                    wp_enqueue_script('multiopen-accordion');
                }
                if ($this->ssBaseOpOut['css_load'] != 'off' && $this->ssModOpOut['acc_css'] == 'on') {
                     //add_action('wp_print_styles', array(&$this,'accordion_add_css'));
                     wp_enqueue_style( 'accordion_style');
                }
            }  
         }
	}
    /**
	* add the accordion code
	*/
    function accordion_shortcode_out ($atts, $content=''){

        /**/ if ($this->ssModOpOut['acc_mode'] != 'on') {
                    wp_enqueue_script('multiopen-accordion');
                }
                if ($this->ssBaseOpOut['css_load'] != 'off' && $this->ssModOpOut['acc_css'] == 'on') {
                     //add_action('wp_print_styles', array(&$this,'accordion_add_css'));
                     wp_enqueue_style( 'accordion_style');
         }
         
         
         $atts = (shortcode_atts(array(
            'auto_accordion' => '',
            'acc_mode' => '',            
            'acc_container' => '',
            'acc_toggler' => '',
            'acc_elements' => '',            
            'acc_togtag' => '',
            'acc_elemtag' => '',            
            'acc_openall' => '',
            'acc_fixedheight' => '',
            'acc_fixedwidth' => '',
            'acc_height' => '',
            'acc_width' => '',
            'acc_opacity' => '',
            'acc_firstopen' => ''
            ), $atts));

		// opdate options if any changes with shortcode
		if ($atts !='') {		
		      $this->ss_change_options($atts);	
         }

        extract($this->ssModOpOut);
	        
		srand((double)microtime()*1000000); 
		$this->my_acc_id = rand(0,1000); 
		
        $pattern = "/<".$acc_togtag."(.*?)>/i";
        $replacement = "<".$acc_togtag." class=\"".$acc_toggler."\"$1>";
        $content = preg_replace($pattern, $replacement, $content);
        
        $pattern = "/<".$acc_elemtag."(.*?)>/i";
        $replacement = "<".$acc_elemtag." class=\"".$acc_elements."\"$1>";
        $content = preg_replace($pattern, $replacement, $content);

        $output = "<div id=\"accordion".$this->my_acc_id."\" class=\"".$acc_container."\">".$content."</div>";
        
        $output .= $this->accordion_starter();
        return do_shortcode($output);
        
    }

    /**
	* add the accordion css
	*/
    function accordion_add_css(){
        if (!is_admin()) {
            wp_enqueue_style( 'accordion_style');
        }
	}
	
	function accordion_starter(){

		extract($this->ssModOpOut);
		//$acc_mode = 'on';
		
		
		if(is_numeric($acc_fixedheight) && $acc_fixedheight !== '') $fh ='fixedHeight: \''.$acc_fixedheight.'px\',';    
        if(is_numeric($acc_fixedwidth) && $acc_fixedwidth !== '' ) $fw ='fixedWidth: \''.$acc_fixedwidth.'px\',';
		
		if ($acc_mode == 'on') {
		  $myaccordion = 'var ssAcc'.$this->my_acc_id.' = new Fx.Accordion($(\'accordion'.$this->my_acc_id.'\'), 
		                    \'#accordion'.$this->my_acc_id.' .'.$acc_toggler.'\',       
		                    \'#accordion'.$this->my_acc_id.' .'.$acc_elements.'\',  
		                    {'
		                    .$fh   
                            .$fw.'      
                            height: '.$acc_height.',              
                            opacity: '.$acc_opacity.',            
                            width: '.$acc_width.',                
                            display: ['.$acc_firstopen.']        
                            });
                            ';
                            
		  } else {
		  $myaccordion = 'var ssAcc'.$this->my_acc_id.' = new MultipleOpenAccordion($(\'accordion'.$this->my_acc_id.'\'), {
		                    togglers:$$(\'#accordion'.$this->my_acc_id.' .'.$acc_toggler.'\'),       
		                    elements:$$(\'#accordion'.$this->my_acc_id.' .'.$acc_elements.'\'),  		                    
                            openAll: '.$acc_openall.', '           
                            .$fh   
                            .$fw.'                            
                            height: '.$acc_height.',              
                            opacity: '.$acc_opacity.',            
                            width: '.$acc_width.',                
                            firstElementsOpen: ['.$acc_firstopen.']        
                            });
                           
                           var toggleAcc = $$(\'.toggleAllAcc\');
                           var openAcc = $$(\'.openAllAcc\');
                           var closeAcc = $$(\'.closeAllAcc\');
	                             toggleAcc.addEvent(\'click\',function(e) {
		                          ssAcc'.$this->my_acc_id.'.toggleAll();
                                 });
                                 openAcc.addEvent(\'click\',function(e) {
		                          ssAcc'.$this->my_acc_id.'.showAll();
		                          openAcc.setStyle(\'display\', \'none\');
		                          closeAcc.setStyle(\'display\', \'block\');
                                 });
                                 closeAcc.addEvent(\'click\',function(e) {
		                          ssAcc'.$this->my_acc_id.'.hideAll();
		                          closeAcc.setStyle(\'display\', \'none\');
		                          openAcc.setStyle(\'display\', \'block\');
                                 });
                                 
                                 ';                           
             }
			if (!is_admin()) {
			 $this->open_addEvent() ;
            
			  echo $myaccordion;
			
			 $this->close_addEvent() ;
			}
    }
    
        	/**
		*	creates accordion metabox in post window
		*/
		
	function acc_print_box() {
		global $ssBase_domain;
		$this->ssBaseOpOut = get_option($this->AdminOptionsName);
		extract($this->ssBaseOpOut);
		extract($this->ssModOpOut);

		if	($accordion == 'on' && is_admin())	{		
		
      	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages'))
           return;
				if( function_exists( 'add_meta_box' )) {
					add_meta_box( 'ss_acc', __( 'SuperSlider-Accordion', $ssBase_domain ), array(&$this,'acc_writebox'), 'post', 'advanced', 'high');
					add_meta_box( 'ss_acc', __( 'SuperSlider-Accordion', $ssBase_domain ), array(&$this,'acc_writebox'), 'page', 'advanced', 'high' );
				}
			
   		}
	}
	 
    function acc_writebox() {
		
		extract($this->ssModOpOut);
		include_once 'admin/superslider-acc-box.php';
		echo $box;		
		include_once 'admin/js/superslider-acc-box.js';
		
	}
	
	function tooltip_starter(){
	
		extract($this->ssModOpOut);
		
		if ( $toolClass == '' ) { $mytool = "'.tiplink'";
		} else { $mytool = "['.tiplink , ".$toolClass."']";
		}
		
		
		/*$mytootips = "var myTips = new Tips($$(".$mytool."), {
								className: 'tooltip',
								showDelay : ".$tt_showDelay.",
								hideDelay : ".$tt_hideDelay.",
								fixed: ".$tt_fixed.",
								title: '".$tipTitle."',
								text: '".$tipText."',
								windowPadding: {x:5, y:5},
								waiAria: true,
								offset: {x: ".$tt_offsetx.", y: ".$tt_offsety."},

					onShow: function() {
						this.tip.fade(".$tt_tip_opacity.");	
					},
					onHide: function() {
						this.tip.fade(0);
					}
				});				
				";
		
			*/
		
		$mytootips = "
		
		
		var myTips = new mBox.Tooltip({
			//id: '',
			//theme:'',
			delayOpen: ".$tt_showDelay.",
			delayClose: ".$tt_hideDelay.",
			//target:'',
			//attach: ".$mytool.",
			attach:  $$('*[title]'),
			//event: 'click',
			//preventDefault: false,
			width: 'auto',
			height: 'auto',
			//content: null,
			setContent: 'title',  //'data-setContent'
			title: null,
			//footer: 'my footer',
			//dragable: false,
			fixed: ".$tt_fixed.",	//The position of your mBox adjusts when scrolling or when you resize the window.
			pointer: ['bottom'],
	//	If at least one of the positions is outside, you can add a pointer to your mBox.
	//	To adjust the pointers position, use 'right', 'left', 'top', 'bottom' or 'center'.
	//	To add an offset you need to use a second variable in an array, e.g. ['left', 10]. 
			
			closeInTitle: false,
		/*	setStyles: {
				wrapper: {},
				container: {},
				content: {},
				title: {},
				footer: {}
			},
			position: {
				x: ['center', 'inside', 'center'],
				y: ['top', 'outside', 'bottom']
			},
			offset: {
				x: 0,
				y: 0
			},
			fade: {
				open:true,
				close: true
			},
			fadeDuration: {
				open: 400,
				close: 400
			},
			overlay: false,
			overlayStyles: {
				color: 'black',
				opacity: 0.75
			},
			overlayFadeDuration: 100,*/
			transition: 'bouncefly',
		
			//closeOnEsc: true,		//Closes your mBox when pressing esc.
			//closeOnClick: false,	//Closes your mBox when clicking anywhere.
			//closeOnBoxClick: false,	//Closes your mBox when clicking on the mBox itself.
			//closeOnWrapperClick: false,	//Closes your mBox when clicking on the wrapper (but won't close when clicking on any child)
			//closeOnBodyClick: true,	//Closes your mBox when clicking anywhere except on the mBox itself.
			//closeOnMouseleave: true	//Closes your mBox when the mouse leaves the mBox area. 
		}); 
		

  /*  $('[title]').each(function() {
        this = $(this);
        this.store('title','this.attr('title')');
        this.removeAttr('title');
        
        
        //set
document.id('myElement').store('key','value');
//get
var value = document.id('myElement').retrieve('key');


//get
var html = document.id('myElement').get('html');
//set
document.id('myElement').set('html','<b>Hello!</b>');     

}); */
		
		";
		
		
        if (!is_admin()) {
            $this->open_addEvent() ;
        
            echo $mytootips;
        
            $this->close_addEvent() ;
        }
    }

	function tooltip_add_css() {
		if (!is_admin()) {
		  wp_enqueue_style( 'mBox_tooltip_style');
	   }
	}
	function modal_quicktags($hook) {	
		if(( 'post.php' == $hook) ||('post-new.php' == $hook) ) {
			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages'))
			   return;
			wp_enqueue_script('modal_quicktags',$this->js_path. 'modal-quicktags.js', array( 'quicktags' ));
		}
	}
		    /**
    * The modal shortcode must be enclosed , ie: [modal][/modal]
    */
    function modal_shortcode_out($atts, $content){

        $atts = (shortcode_atts(array(
			'modal_link' => '',
			'modal_width' => '',
			'modal_height' => '',
			'modal_box' => '',
			'modal_title' => '',
			'modal_buttons' => '',
        	'modal_button_text1' => '',
        	'modal_button_text2' => ''
			), $atts));

		// opdate options if any changes with shortcode
		$this->ss_change_options($atts);
		
		extract($this->ssModOpOut);
 
		/*$pattern = "/<a(.*?)href=(.*?)><img(.*?)\/>(.*?)/i";
        $replacement = '<a$1href=$2 class="zoom"><img$3 />$4';
        $content = preg_replace($pattern, $replacement, $content);*/

        if (($this->has_modal != 'true') && (!is_admin())) {        			 
             wp_enqueue_script('mBox_modal');
              if($modal_css == 'on') {       
              	wp_enqueue_style('mBox_modal_style');
              }    
             add_action('wp_footer', array(&$this,'modal_starter'));
         }                
       $this->has_modal = 'true';

        return do_shortcode($content);
    }
     
     function modal_starter(){ 
    
        extract($this->ssModOpOut);
       
        if($modal_buttons == 'true'){ 
        	$my_buttons = "buttons: [
						{title: '".$modal_button_text1."'},
						{title: '".$modal_button_text2."'}
						],";
        }else{
        	$my_buttons = '';
        }

		$mymodal = "var ssModal".$this->my_id." = new mBox.Modal({
						content: '".$modal_box."',
						attach: '".$modal_link."',
						width: '".$modal_width."',
						height: '".$modal_height."',
						title: '".$modal_title."',
						".$my_buttons."
						//target:'',						
						//event: 'click',
						preventDefault: true,
						//setContent: null,  //data-setContent
						overlay: ".$modal_overlay.",
						overlayStyles: {
							color: '".$modal_overlay_color."',
							opacity: 0.8
						},
						overlayFadeDuration: 200,
						//footer: null,
						dragable: true,
                        transition: '".$modal_transition."'
	   
                           });";
    
		if ($this->modal_started != 'true') {
			$this->open_addEvent() ;
				echo $mymodal;
			$this->modal_started = 'true';	
			$this->close_addEvent() ;
		}
			   
			
    }
    
	function zoom_footer_admin($hook) {
		if( 'post.php' != $hook || 'post-new.php' != $hook )
        return;
		wp_enqueue_script('zoom_quicktags',plugin_dir_url( __FILE__ ) . 'js/zoom-quicktags.js',array( 'quicktags' ));
	}

    function zoom_starter(){ 
    
        extract($this->ssModOpOut);
        
		$zoom_trans = 	$zoom_trans_type.':'.$zoom_trans_typeinout;
		if ($this->ssBaseOpOut['css_load'] != 'off') {
		      $wait = $this->css_path.'/images/loading.gif';
		      $error = $this->css_path.'/images/error.png';
		}
		$myzoomer = 'var ssZoom'.$this->my_id.' = new ByZoomer(\'zoom\', {
		                    duration: \''.$zoom_time.'\',
                            transition: \''.$zoom_trans.'\',
                            border: \''.$zoom_border.'\',
                            padding: \''.$zoom_pad.'px\',
                            background: \''.$zoom_back.'\',
                            onZoomInStart: $empty,
                            onZoomInComplete: $empty,
                            onZoomOutStart: $empty,
                            onZoomOutComplete: $empty,
                            waitIcon: \''.$wait.'\',
                            errorIcon: \''.$error.'\'       
                            });';
			
			$this->open_addEvent() ;
			    
			    if ($this->zoom_started != 'true') echo $myzoomer;
			   
			$this->zoom_started = 'true';
			
			$this->close_addEvent() ;
    }
        /**
	*	Look ahead to check if any posts contain the [zoom ] shortcode or class
	*/
	function zoom_scan () { 
	   global $posts;
	    
	    if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $post ) { 
            if ( false !== strpos ( $post->post_content, 'zoom' ) ) {                 
               
                if ($this->has_zoomed != 'true') {	
                     wp_enqueue_script('byzoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }
                
                $this->has_zoomed = 'true';

            }  
         }
	}
	function zoom_replace($content) {
                
       $this->has_zoomed = 'true';
                
                $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 zoom$9$10 />";
        $content = preg_replace($pattern, $replacement, $content);     
		return $content;
    }
	    /**
    * The zoom shortcode must be enclosed , ie: [zoom][/zoom]
    */
    function zoom_shortcode_out($atts, $content){

        $atts = (shortcode_atts(array(
			'zoom_time' => '',
			'zoom_trans' => '',
			'zoom_border' => '',
			'zoom_pad' => '',
			'zoom_back' => ''), $atts));
	
		// opdate options if any changes with shortcode
		$this->ss_change_options($atts);
	
		$pattern = "/<a(.*?)href=(.*?)><img(.*?)\/>(.*?)/i";
        $replacement = '<a$1href=$2 class="zoom"><img$3 />$4';
        $content = preg_replace($pattern, $replacement, $content);
        

        if (($this->has_zoomed != 'true') && (!is_admin())) {	
                     wp_enqueue_script('byzoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }                
       $this->has_zoomed = 'true';

        return do_shortcode($content);
    }
	/**
	*	Look ahead to check if any posts contain the <div id="slider">
	*/
	function scroll_scan() { 
	   global $posts; 
	   
        if ( !is_array ( $posts ) ) 
        return; 	 
        foreach ( $posts as $mypost ) {         
                if ( false !== strpos ( $mypost->post_content, '<div id="scroll"' ) ) {                 
                        $this->scroll_add_script(); 
                } 
         }
         if ($this->ssBaseOpOut['css_load'] != 'off' && $this->ssModOpOut['scroll_css'] == 'on') {
            $this->scroll_add_css();
         }
	}
	function scroll_add_script() {
	   if (!is_admin()) {
	       add_action ( "wp_footer", array(&$this,"scroll_starter")); 
	   }
	}
	
	function scroll_add_css() {
	   if (!is_admin()) {
		  wp_enqueue_style( 'scroll_style');
	   }
	}

	function scroll_button_out() {
	   echo '<a href="#top" id="totop" class="toplink totop" style="opacity:0;">'.$this->ssModOpOut['totop_text'].'</a>';

	}
	function scroll_starter() {

        extract($this->ssModOpOut);
        
        $scroll_trans = $scroll_trans.':'.$scroll_transout;
        
     $myscroll = " 
    window.addEvent('domready',function() { var cc  = new Element('a#top', {'name': 'top', 'class': 'top'}).inject(document.body,'top'); 
    });
    new Fx.SmoothScroll({duration:1200});
	window.addEvent('scroll',function(e) {	    
			var gototop = $('totop');
		  gototop.fade((window.getScroll().y > 500) ? 'in' : 'out')	
	});";
     
     
/*     "  var ssScroller = new Fx.Scroll(window,{      
            links:'elements',
            wait: 'false',
            offset: {'x': 0, 'y': -20},
            wheelStops: 'false',
            duration:".$scroll_time.",
            transition:'".$scroll_trans."'
        });

        var elements = $$('#scroll1','#scroll2','#scroll3','#scroll4','#scroll5','#scroll6','#scroll7','#scroll8','#scroll9','#scroll10');
        var start = $$('#scroll');
        $$('#scroll a').each(function(elem,i){
            elem.addEvent('click',function(e){
                    e.preventDefault();
                    e.stop();
                    ssScroller.toElement(elements[i]);
             });
         });

         $$('.totop').each(function(elem,i){
            elem.addEvent('click',function(e){
                    e.preventDefault();
                    e.stop();
                    //scroller.toElement(start);
                    ssScroller.toTop(0, 0);
             });
         });
         ";*/
        
        
        if (!is_admin()) {
           
            $this->open_addEvent() ;			
			if ($this->scroll_started != 'true')echo $myscroll;
			$this->scroll_started = 'true';
			$this->close_addEvent() ;
		}
   }
    
    /**
	*  Add Quick Tag For slide In Code >= WordPress 2.5+
	*/
	function scroll_quicktag($hook) {
		if( ('post.php' == $hook) || ('post-new.php' == $hook)) {
			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages'))
			   return;
			wp_enqueue_script('scroller_quicktags',$this->js_path. 'scroller-quicktags.js', array( 'quicktags' ));
		}
	}
    
    function nudger_starter(){

        extract($this->ssModOpOut);
        
        srand((double)microtime()*1000000); 
		$this->my_id = rand(0,1000); 
		
        $mynudger = 'var ssNudg'.$this->my_id.' = new Nudger(\''.$nudge_family.' \', { 
                            amount: '.$nudge_amount.',    
                            duration: '.$nudge_duration.'    
                            });';                                    
        if (!is_admin()) {
           
           $this->open_addEvent() ;			
			if ($this->nudger_started != 'true'){
			 echo 'var Nudger=new Class({Implements:[Options],options:{transition:Fx.Transitions.linear,duration:400,amount:20},initialize:function(a,b){this.setOptions(b);this.elements=$$(a);this.elements.each(function(d){var c={fx:new Fx.Morph(d,{duration:this.options.duration,transition:this.options.transition,link:"cancel"}),enter:this.enter.bind(this,d),leave:this.leave.bind(this,d)};d.addEvents({mouseenter:c.enter,mouseleave:c.leave});d.store("nudge",c)},this)},enter:function(a){a.retrieve("nudge").fx.start({"padding-left":this.options.amount})},leave:function(a){a.retrieve("nudge").fx.start({"padding-left":0})},destroy:function(){this.elements.each(function(b){var a=b.retrieve("nudge");b.removeEvents({mouseenter:a.enter,mouseleave:a.leave})})}});';
			 echo $mynudger;
			 }
			$this->nudger_started = 'true';			
			$this->close_addEvent() ;
		}
    
    }
    
    function fader_starter(){

        extract($this->ssModOpOut);

        $myfader = "$$('".$fader_family."').each(function(container) {
			container.getChildren().each(function(child) {
				var siblings = child.getParent().getChildren().erase(child);
				child.addEvents({
					mouseenter: function() { siblings.tween('opacity',".$fader_opacity."); },
					mouseleave: function() { siblings.tween('opacity',1); }
				});
			});
		});";
                                                  
        if (!is_admin()) {
            
            $this->open_addEvent() ;
            
			if ($this->fader_started != 'true')echo $myfader;
			$this->fader_started = 'true';
			
			$this->close_addEvent() ;
		}
    
    }
    
   function link_starter(){

        $mylink = "	var lynx = $$('".$this->ssModOpOut['linker_tag']."');
	lynx.addEvent('click',function(e) {
		lynx.removeClass('clicked'); //remove from others
		this.addClass('clicked');
	});";
              
        if (!is_admin()) {            
            $this->open_addEvent() ;          
			if ($this->link_started != 'true')echo $mylink;
			$this->link_started = 'true';			
			$this->close_addEvent() ;
		}		
		
    }

    function link_css() {
        
        $mylinkstyle = "<style type=\"text/css\" media=\"screen\">.clicked { -moz-border-radius:5px; -webkit-border-radius:5px; background:".$this->ssModOpOut['linker_color'].";padding:0 4px; }</style>";
        
        if (!is_admin()) {        
             echo $mylinkstyle;
        
        }
    }
    
   function clicker_starter(){

        $myclicker = "var clix = new Clickables({
                         elements: '".$this->ssModOpOut['clicker_tag']."',
                         selectClass: '',
                         anchorToSpan: ".$this->ssModOpOut['clicker_span']."
                     });";
                     
        if (!is_admin()) {
            
            $this->open_addEvent() ;
            
			if ($this->clicker_started != 'true'){
			 echo 'var Clickables=new Class({Implements:[Options],options:{elements:"li",selectClass:"",anchorToSpan:false},initialize:function(a){this.setOptions(a);this.elements=$$(this.options.elements);this.doClickables()},doClickables:function(){this.elements.each(function(c){var a=c.getElements("a"+(this.options.selectClass?"."+this.options.selectClass:""))[0];if($defined(a)){this.setClick(c,a.get("href"));if(this.options.anchorToSpan){var b=new Element("span",{text:a.get("text")}).replaces(a)}}},this)},setClick:function(b,a){b.addEvent("click",function(){window.location=a})}});';
			 echo $myclicker;
			 }
			$this->clicker_started = 'true';
			$this->close_addEvent() ;
		}
    }
    function clicker_add_css(){
        
        $myclickstyle = "<style type=\"text/css\" media=\"screen\">".$this->ssModOpOut['clicker_tag'].":hover { background:".$this->ssModOpOut['clicker_color'].";cursor:pointer; }</style>";
        
        if (!is_admin()) {    
             echo $myclickstyle;
        }
    } 
    
    function moodropmenu_starter() {
    	$my_moodropmenu = "
    	var dropMenu = new MooDropMenu($('".$this->ssModOpOut['moomenu']."'),{
				onOpen: function(el){
					el.fade('in')
				},
				onClose: function(el){
					el.fade('out');
				},
				onInitialize: function(el){
					el.fade('hide').set('tween', {duration:500});
				}
		});";
    	
    	 if (!is_admin()) {
            
            $this->open_addEvent() ;            
			 echo $my_moodropmenu;
			$this->close_addEvent() ;
		}    	
    }

}	//end class
} //End if Class ssBase

/**
*instantiate the class
*/	
if (class_exists('ssBase')) {
	$myssBase = new ssBase();
}
?>