<?php
/*
Plugin Name: SuperSlider
Plugin URI: http://wp-superslider.com/superslider
Description: In production. 
Author: Daiv Mowbray
Version: 0.1
Author URI: http://wp-superslider.com
Tags: animation, animated, gallery, slideshow, mootools 1.2, mootools, accordion, slider, superslider, menu, lightbox

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
		* set up to load mootools and disable other plugun js loaders
		* define theme globally or mainyain plugin independent themes
		* activate mini plugs: reflection, tabs, milkbox, mediabox, folding comments, other?
		* 
		*/
		
		/**
		* @var string   The name the options are saved under in the database.
		*/
		var $acc_id;
		var $js_path;
		var $base_over_ride;
		var $ssBaseOpOut;
		var $defaultAdminOptions;
		var $AdminOptionsName = 'ssBase_options';
	
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
	}
	
			/**
		* Retrieves the options from the database.
		* @return array
		*/			
	function set_default_admin_options() {
		global $defaultAdminOptions; 
		
		$defaultAdminOptions = array(
				'load_moo' => "on",
				'css_load' => "default",		
				'css_theme' => "default",
				'reflect'	=>	"on",
				"reflect_height" => "0.33",
				"reflect_opacity" => "0.5",
				"auto_reflect" => "on",
				"accordion" => "on",
				"auto_accordion" => "on",
				"acc_container" => "accordion",
				"acc_toggler" => "toggler",
				"acc_elements" => "togcontent",
				"acc_togtag" => "h3",
                "acc_elemtag" => "div",
				"acc_openall" => "false",
				"acc_fixedheight" => "false",
				"acc_fixedwidth" => "false",
				"acc_height" => "true",
				"acc_width" => "false",
				"acc_opacity" => "true",
				"acc_firstopen" => "0",
				'ss_global_over_ride' => "on");
		
		$defaultOptions = get_option($this->AdminOptionsName);
		if (!empty($defaultOptions)) {
			foreach ($defaultOptions as $key => $option) {
				$defaultAdminOptions[$key] = $option;
			}
		}
		update_option($this->AdminOptionsName, $defaultAdminOptions);
		return $defaultAdminOptions;
		
	}

		/**
		* Saves the admin options to the database.
		*/
	function save_default_show_options(){
		update_option($this->AdminOptionsName, $this->defaultAdminOptions);
	}
		
		/**
		* load default options into data base
		*/		
	function ssBase_init() {
  			$this->set_base_paths();
  			$this->defaultAdminOptions = $this->set_default_admin_options();
  			$this->ssBaseOpOut = get_option($this->AdminOptionsName);
  			
  			extract($this->ssBaseOpOut);
  			$this->base_over_ride = $ss_global_over_ride;
  			
  			add_action( 'admin_menu', array(&$this,'ssBase_setup_optionspage'));					
			add_action('wp_print_scripts', array(&$this,'ssBase_add_javascript'),3); //this loads the mootools scripts.
			
			if ( $reflect == 'on'){			    
			    add_action ( "template_redirect" , array(&$this,"reflect_scan") );
                //add_shortcode ( 'reflect' , array(&$this, 'reflect_shortcode_out')); //disabled as it fails to work
                if ( $auto_reflect == 'on'){ 
                     add_filter( "the_content", array(&$this, "reflect_replace"));
                }        
            }
            if ( $accordion == 'on'){  
                    add_action ( "template_redirect" , array(&$this,"accordion_scan") );	// Add look ahead for accordion
                //if ( $auto_accordion == 'on'){
                    add_shortcode ( 'accordion' , array(&$this, 'accordion_shortcode_out'));
                 //}
            }
	}
	
		/**
		* Initialize the admin panel, Add the plugin options page, loading it in from superslider-show-ui.php
		*/
	function ssBase_setup_optionspage() {
		if (  function_exists('add_options_page') ) {
			if (  current_user_can('manage_options') ) {
				add_options_page(__('SuperSlider'),__('SuperSlider-Base'), 8, 'superslider', array(&$this, 'ssBase_ui'));
				add_filter('plugin_action_links', array(&$this, 'filter_plugin_show'), 10, 2 );
				add_action('admin_head', array(&$this,'ssbox_admin_style'));
			}					
		}
		/* possible to add as top level menu and other plugins as sub pages.
		if (function_exists('add_menu_page')) {
		      add_menu_page('SuperSlider', 'SuperSlider', 'superslider', array(&$this, 'ssBase_ui'));
	   }*/

	}
		/**
		* Load admin options page
		*/
	function ssBase_ui() {
		
		$ssBase_domain = 'superslider';
		include_once 'admin/superslider-ui.php';
		
	}
	
		/**
		* Add link to options page from plugin list WP 2.6.
		*/
	function filter_plugin_show($links, $file) {
		 static $this_plugin;
			if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

		if (  $file == $this_plugin )
			$settings_link = '<a href="options-general.php?page=superslider">'.__('Settings').'</a>';
			array_unshift( $links, $settings_link ); //  before other links
			return $links;
	}
	
		/**
		* Removes user set options from data base upon deactivation
		*/		
	function ssBase_ops_deactivation(){
		delete_option($this->AdminOptionsName);
	}

	function ssBase_add_javascript(){
		extract($this->ssBaseOpOut);

		$js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';

			if (!is_admin()) {				
				if (function_exists('wp_enqueue_script')) {
					if ($load_moo == 'on'){
					echo "\t<!-- The following js is part of the SuperSlider Base plugin available at http://wp-superslider.com/ -->\n";		
						//wp_enqueue_script('moocore', $js_path.'mootools-1.2-core.js' NULL, 1.2);		
						//wp_enqueue_script('moomore', $js_path.'mootools-1.2-more.js', array('moocore'), 1.2);
						echo "\t".'<script src="'.$js_path.'mootools-1.2.1-core-yc.js" type="text/javascript"></script> '."\n";
						echo "\t".'<script src="'.$js_path.'mootools-1.2-more.js" type="text/javascript"></script> '."\n";
					}				
				}	
			
				
			}// is not admin
	}
		/**
		* register and Add css script into head 
		*/
	function ssBase_add_css(){
		
		extract($this->ssBaseOpOut);

		echo "<!-- The following css is part of the SuperSlider-Base plugin available at http://wp-superslider.com/ -->\n";
   		if ($css_load == 'default'){
    			$cssPath = WP_PLUGIN_URL.'/superslider/plugin-data/superslider/ssBase/'.$css_theme.'/'.$css_theme.'.css';	
    			echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    		}elseif ($css_load == 'pluginData') {
    			$cssPath = WP_CONTENT_URL.'/plugin-data/superslider/ssBase/'.$css_theme.'/'.$css_theme.'.css';
    			echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    		}elseif ($css_load == 'off') {
    			$cssPath = '';
    		}    		
	}
	
	/**
	* add the ss admin css if over ride
	*/
	function ssbox_admin_style(){
		if ($this->base_over_ride == "on") {
			$cssPath = WP_PLUGIN_URL.'/superslider-show/admin/ss_admin_style.css';    			
    		echo "\n"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    	}	
	}
	
	function ss_change_options( $attr ){
		global $post;
 
		$this->ssBaseOpOut = array_merge($this->ssBaseOpOut, array_filter($attr)); 		
  		return $this->ssBaseOpOut;
	}
	
    /**
	*	Look ahead to check if any posts contain the [gallery / slideshow] shortcode
	*/
	function reflect_scan () { 
	   global $posts; 
	   extract($this->ssBaseOpOut);
	   
        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $mypost ) {         
                if ( false !== strpos ( $mypost->post_content, '<img' ) ) {                 
                        add_action ( "wp_head", array(&$this,"reflect_add_script"));                                              
                        break; 
                } 
         }
	}
    
    function reflect_replace($content) {

        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect$9$10 />";
        $content = preg_replace($pattern, $replacement, $content);
        
		return $content;
    }
    /**
    * This reflect shortcode isn't working
    */
    function reflect_shortcode_out($attr, $content){
        
        extract(shortcode_atts(array(
			'reflect_height' => '',
			'reflect_opacity' => ''), $attr));
			
		// opdate options if any changes with shortcode
		if ($attr !='') {		
		      $this->ss_change_options($attr);	
         }
         
        extract($this->ssBaseOpOut);
		
		$pattern = "/(.*?)<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>(.*?)/i";
        $replacement = "$1<img$2src=$3$4.$5$6$7class=$8$9 reflect$10$11 />$12";
        $content = preg_replace($pattern, $replacement, $content);
        
        return do_shortcode($content);
    }
    
    function reflect_add_script() {
        $js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
        extract($this->ssBaseOpOut);
        
        echo "\t<!-- The following js is part of the SuperSlider Reflect script available at http://wp-superslider.com/ -->\n";							
        echo "\t".'<script src="'.$js_path.'reflection-compressed.js" type="text/javascript"></script> '."\n";
		
		
        $myreflect = '$$("img").filter(function(img) { return img.hasClass("reflect"); }).reflect({ height:'.$reflect_height.', opacity:'.$reflect_opacity.'});';

            $reflectOut = "\n\t"."<script type=\"text/javascript\">\n";
			$reflectOut .= "\t"."// <![CDATA[\n";		
			$reflectOut .= "window.addEvent('domready', function() {
			".$myreflect."
			});\n";
			$reflectOut .= "\t"."// ]]></script>\n";

			echo $reflectOut;
   }
    /**
	*	Look ahead to check if any posts contain the [gallery / slideshow] shortcode
	*/
	function accordion_scan () { 
	   global $posts; 
	   extract($this->ssBaseOpOut);

        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $mypost ) { 
                if ( false !== strpos ( $mypost->post_content, '[accordion' ) ) {                 
                        add_action ( "wp_head", array(&$this,"accordion_add_script"));
                        add_action ( 'wp_head', array(&$this,'ssBase_add_css'));                                               
                        break; 
                }  
         }
	}
    /**
	* add the accordion code
	*/
    function accordion_shortcode_out ($attr, $content=''){
         
         extract(shortcode_atts(array(
            'auto_accordion' => '',
            'acc_container' => '',
            'acc_toggler' => '',
            'acc_elements' => '',            
            'acc_togtag' => 'h3',
            'acc_elemtag' => 'div',            
            'acc_openall' => '',
            'acc_fixedheight' => '',
            'acc_fixedwidth' => '',
            'acc_height' => '',
            'acc_width' => '',
            'acc_opacity' => '',
            'acc_firstopen' => ''
            ), $attr));

		// opdate options if any changes with shortcode
		if ($attr !='') {		
		      $this->ss_change_options($attr);	
         }
	       
        extract($this->ssBaseOpOut);
	        
		srand((double)microtime()*1000000); 
		$this->acc_id = rand(0,1000); 
		
        $pattern = "/<".$acc_togtag."(.*?)>/i";
        $replacement = "<".$acc_togtag." class=\"".$acc_toggler."\"$1>";
        $content = preg_replace($pattern, $replacement, $content);
        
        $pattern = "/<".$acc_elemtag."(.*?)>/i";
        $replacement = "<".$acc_elemtag." class=\"".$acc_elements."\"$1>";
        $content = preg_replace($pattern, $replacement, $content);

        $output = "<div id=\"accordion".$this->acc_id."\" class=\"".$acc_container."\">".$content."</div>";
        
        $output .= $this->accordion_starter();
        return do_shortcode($output);
        
    }

    /**
	* add the accordion code
	*/
    function accordion_add_script(){
       	$js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
        
        echo "\t<!-- The following js is part of the SuperSlider Accordion script available at http://wp-superslider.com/ -->\n";
		echo "\t".'<script src="'.$js_path.'multiopen-accordion-compressed.js" type="text/javascript"></script> '."\n";
		
	}
	function accordion_starter(){
		extract($this->ssBaseOpOut);
		$myaccordion = 'var ssAcc'.$this->acc_id.' = new MultipleOpenAccordion($(\'#accordion'.$this->acc_id.'\'), {
		                    togglers:$$(\'#accordion'.$this->acc_id.' .'.$acc_toggler.'\'),       
		                    elements:$$(\'#accordion'.$this->acc_id.' .'.$acc_elements.'\'),     
                            openAll: '.$acc_openall.',             
                            fixedHeight: '.$acc_fixedheight.',    
                            fixedWidth: '.$acc_fixedwidth.',      
                            height: '.$acc_height.',              
                            opacity: '.$acc_opacity.',            
                            width: '.$acc_width.',                
                            firstElementsOpen: ['.$acc_firstopen.']        
                            });';

            $accordionOut = "\n\t"."<script type=\"text/javascript\">\n";
			$accordionOut .= "\t"."// <![CDATA[\n";		
			$accordionOut .= "window.addEvent('domready', function() {".$myaccordion."
						});\n";
			$accordionOut .= "\t"."// ]]></script>\n";

			echo $accordionOut;
				
    }
    	/**
		*	creates accordion metabox in post window
		*/	
	function acc_print_box() {
		global $ssBase_domain;
		$this->ssBaseOpOut = get_option($this->AdminOptionsName);
		extract($this->ssBaseOpOut);

		if	($accordion == 'on')	{
			if (is_admin ()) {			
				if( function_exists( 'add_meta_box' )) {
					add_meta_box( 'ss_acc', __( 'SuperSlider-Accordion', $ssBase_domain ), array(&$this,'acc_writebox'), 'post', 'advanced', 'high');
					add_meta_box( 'ss_acc', __( 'SuperSlider-Accordion', $ssBase_domain ), array(&$this,'acc_writebox'), 'page', 'advanced', 'high' );
				}
			}
   		}
	}
    function acc_writebox() {
		
		include_once 'admin/superslider-acc-box.php';
		echo $box;		
		include_once 'admin/js/superslider-acc-box.js';
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