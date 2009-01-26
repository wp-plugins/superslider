<?php
/*
Plugin Name: SuperSlider
Plugin URI: http://wp-superslider.com/superslider
Description: SuperSlider base, is a global admin plugin for all SuperSlider plugins. Superslider base includes the following modules: Reflection;(adds floor reflection to your images), Accordion;(add accordions to your post content). Scroll (add smooth scroll to your page) Zoomer (Adds a smooth image zoomer).
Author: Daiv Mowbray
Version: 0.3
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
		* @var 
		*/
		var $acc_id;
		var $js_path;
		var $css_path;
		var $base_over_ride;
		var $ssBaseOpOut;
		var $defaultAdminOptions;
		var $AdminOptionsName = 'ssBase_options';
	
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
				"auto_reflect" => "off",
				"accordion" => "on",
				"acc_css"       =>  "on",	
				"auto_accordion" => "on",
				"acc_container" => "accordion",
				"acc_toggler" => "toggler",
				"acc_elements" => "togcontent",
				"acc_togtag" => "h3",
                "acc_elemtag" => "div",
				"acc_openall" => "false",
				"acc_fixedheight" => "false",
				"acc_fixedwidth"  => "false",
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
				"scroll_css"       =>  "on",				
				"scroll_time"      =>  "1200",
				"scroll_trans"     =>  "sine",
				"scroll_transout"  =>  "out",
				"com"       =>  "on",
				"com_css"   =>  "on",
				"com_time"  =>  "1200",
				"com_trans"      =>  "sine",
				"com_transout"   =>  "out",
				"com_direction"   =>  "vertical",
				"com_open"        =>  "Open comments",
				"com_close" => "Close comments",
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
  			
  			$this->defaultAdminOptions = $this->set_default_admin_options();
  			$this->ssBaseOpOut = get_option($this->AdminOptionsName);
  			
  			extract($this->ssBaseOpOut);
  			$this->base_over_ride = $ss_global_over_ride;
  			
  			$this->set_base_paths($css_load, $css_theme);
  			
  			add_action( 'admin_menu', array(&$this,'ssBase_setup_optionspage'));					
			add_action('wp_print_scripts', array(&$this,'ssBase_add_javascript'),3); //this loads the mootools scripts.
            
            if ( $reflect == 'on'){			    
			      add_action ( 'template_redirect' , array(&$this,'reflect_scan') );
                  add_shortcode ( 'reflect' , array(&$this, 'reflect_shortcode_out') ); //disabled as it fails to work
                  add_action('admin_footer', array(&$this, 'reflect_footer_admin') );
               if ( $auto_reflect == 'on'){ 
                     add_filter( 'the_content', array(&$this, 'reflect_replace') );
                }        
            }
            if ( $accordion == 'on'){  
                  add_action ( 'template_redirect' , array(&$this,'accordion_scan') );	// Add look ahead for accordion
                  add_shortcode ( 'accordion' , array(&$this, 'accordion_shortcode_out'));
            }
            if ( $zoom == 'on'){  
                  add_action ( "template_redirect" , array(&$this,"zoom_scan") ); 
                  add_shortcode ( 'zoom' , array(&$this, 'zoom_shortcode_out') );
                  add_action('admin_footer', array(&$this, 'zoom_footer_admin') );
                if ( $zoom_auto == 'on'){ 
                     add_filter( 'the_content', array(&$this, 'zoom_replace') );
                }    
            }
         
            if ( $scroll == 'on'){  
            
                 //add_action ( 'init', array( &$this, 'scroll_tinymce_addbuttons' ) );// not in use, save for future useage
			     add_action ( 'admin_footer', array( &$this, 'scroll_codeview_button' ) );
			     add_action ( 'template_redirect' , array( &$this,'scroll_scan' ) );
			     //add_action('admin_header', array(&$this,'scroll_header_tinymce') );// this needs to load into tinymce
            }
            
            /*if ( $com == 'on' ){             
                 add_filter( 'comments_template', array(&$this,"com_slide_out"), 10 );
                 add_action('template_redirect', array(&$this,'comments_scan' ) );
                                   
            }*/
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

		$this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';

			if (!is_admin()) {				
				if (function_exists('wp_enqueue_script')) {
					if ($load_moo == 'on'){
					echo "\t<!-- SuperSlider Base plugin available at http://wp-superslider.com/ -->\n";		
						//wp_enqueue_script('moocore', $js_path.'mootools-1.2-core.js' NULL, 1.2);		
						//wp_enqueue_script('moomore', $js_path.'mootools-1.2-more.js', array('moocore'), 1.2);
						echo "\t".'<script src="'.$this->js_path.'mootools-1.2.1-core-yc.js" type="text/javascript"></script> '."\n";
						echo "\t".'<script src="'.$this->js_path.'mootools-1.2-more.js" type="text/javascript"></script> '."\n";
					}
					
				}
				
				
			}// is not admin
	}

	/**
	* add the ss admin css if over ride
	*/
	function ssbox_admin_style(){
		if ($this->base_over_ride == "on") {
			$css_path = WP_PLUGIN_URL.'/superslider-show/admin/ss_admin_style.css';    			
    		echo "\n"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$css_path."' media='screen' />\n";
    	}	
	}
	
	function ss_change_options( $atts ){
		global $post;
 
		$this->ssBaseOpOut = array_merge($this->ssBaseOpOut, array_filter($atts)); 		
  		return $this->ssBaseOpOut;
	}
	
function reflect_footer_admin() {
	// Javascript Code Courtesy Of WP-AddQuicktag (http://bueltge.de/wp-addquicktags-de-plugin/120/)
	echo '<script type="text/javascript">'."\n";
	echo "\t".'function insertreflect(where, myField) {'."\n";
	echo "\t\t".'var reflect_height = prompt("'.js_escape(__('Enter height (0.5 = 50%)', 'superslider')).'");'."\n";
	echo "\t\t".'var reflect_opacity = prompt("'.js_escape(__('Enter opacity (0.5 = 50%)', 'superslider')).'");'."\n";
	echo "\t\t".'if(where == "code") {'."\n";
	echo "\t\t\t".'edInsertContent(myField, "[reflect reflect_height=\"" + reflect_height + "\" reflect_opacity=\"" + reflect_opacity + "\" ]your content to reflect here[/reflect]");'."\n";
	echo "\t\t".'} else {'."\n";
	echo "\t\t\t".'return "[reflect id=\"" + reflect_id + "\"]";'."\n";
	echo "\t\t".'}'."\n";
	echo "\t".'}'."\n";
	echo "\t".'if(document.getElementById("ed_toolbar")){'."\n";
	echo "\t\t".'qt_toolbar = document.getElementById("ed_toolbar");'."\n";
	echo "\t\t".'edButtons[edButtons.length] = new edButton("ed_reflectmanager","'.js_escape(__('reflect', 'superslider')).'", "", "","");'."\n";
	echo "\t\t".'var qt_button = qt_toolbar.lastChild;'."\n";
	echo "\t\t".'while (qt_button.nodeType != 1){'."\n";
	echo "\t\t\t".'qt_button = qt_button.previousSibling;'."\n";
	echo "\t\t".'}'."\n";
	echo "\t\t".'qt_button = qt_button.cloneNode(true);'."\n";
	echo "\t\t".'qt_button.value = "'.js_escape(__('reflect', 'wp-reflectmanager')).'";'."\n";
	echo "\t\t".'qt_button.title = "'.js_escape(__('Insert File reflect', 'wp-reflectmanager')).'";'."\n";
	echo "\t\t".'qt_button.onclick = function () { insertreflect(\'code\', edCanvas);}'."\n";
	echo "\t\t".'qt_button.id = "ed_reflectmanager";'."\n";
	echo "\t\t".'qt_toolbar.appendChild(qt_button);'."\n";
	echo "\t".'}'."\n";
	echo '</script>'."\n";
}

    /**
    *   Reflect functions : to create the image reflections
	*	Look ahead to check if any posts contain the [gallery / slideshow] shortcode
	*/
	function reflect_scan () { 
	   global $posts; 
	   extract($this->ssBaseOpOut);
	   
        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $mypost ) {         
                
            if ( false !== strpos ( $mypost->post_content, 'reflect' ) ) { 
                    add_action ( "wp_head", array(&$this,"reflect_add_script"));  
                    add_action ( "wp_head", array(&$this,"reflect_starter"));
                    break; 
            } 
         }  
	}
    
    function reflect_replace($content) {
    
        $this->reflect_add_script();
        $this->reflect_starter();
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect$9$10 />";
        $content = preg_replace($pattern, $replacement, $content);
        
		return $content;
    }
    /**
    * The reflect shortcode must be enclosed , ie: [reflect][/reflect]
    */
    function reflect_shortcode_out($atts, $content){
        global $reflect_started;

        //extract(shortcode_atts(array(
        $atts = (shortcode_atts(array(
			'reflect_height' => '',
			'reflect_opacity' => ''), $atts));
			
		// opdate options if any changes with shortcode
        $this->ss_change_options($atts);         
        extract($this->ssBaseOpOut);
		
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect$9$10 />";
        $content = preg_replace($pattern, $replacement, $content);
        
        $content .= $this->reflect_starter($reflect_started);
        return do_shortcode($content);
        
    }
    function reflect_starter(){
        global $reflect_started;
        extract($this->ssBaseOpOut);
        
        $myreflect = '$$("img").filter(function(img) { return img.hasClass("reflect"); }).reflect({ height:'.$reflect_height.', opacity:'.$reflect_opacity.'});';

            $reflectOut = "\n\t"."<script type=\"text/javascript\">\n";
			$reflectOut .= "\t"."// <![CDATA[\n";		
			$reflectOut .= "window.addEvent('domready', function() {
			".$myreflect."
			});\n";
			$reflectOut .= "\t"."// ]]></script>\n";

			if ($reflect_started != 'true')echo $reflectOut;
			$reflect_started = 'true';
    
    }
    function reflect_add_script() {
    
        echo "\t<!-- SuperSlider Reflect script available at http://wp-superslider.com/ -->\n";							
        echo "\t".'<script src="'.$this->js_path.'reflection-compressed.js" type="text/javascript"></script> '."\n";
		
   }
    /**
    *   Start the accordion functions
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
                        break; 
                }  
         }
	}
    /**
	* add the accordion code
	*/
    function accordion_shortcode_out ($atts, $content=''){
         
        // extract(shortcode_atts(array(
         $atts = (shortcode_atts(array(
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
            ), $atts));

		// opdate options if any changes with shortcode
		if ($atts !='') {		
		      $this->ss_change_options($atts);	
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
        extract($this->ssBaseOpOut);
        
       	$js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
        
        echo "\t<!-- SuperSlider Accordion script available at http://wp-superslider.com/ -->\n";
		echo "\t".'<script src="'.$js_path.'multiopen-accordion-compressed.js" type="text/javascript"></script> '."\n";
		if ($css_load != 'off' && $acc_css == 'on') {
		      echo "\t".'<link type="text/css" rel="stylesheet" rev="stylesheet" href="'.$this->css_path.'/accordion.css" media="screen" />'."\n";
		}
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
		
		extract($this->ssBaseOpOut);
		include_once 'admin/superslider-acc-box.php';
		echo $box;		
		include_once 'admin/js/superslider-acc-box.js';
	}
	
	function zoom_footer_admin() {
	   extract($this->ssBaseOpOut);
	   $zoom_trans = 	$zoom_trans_type.':'.$zoom_trans_typeinout;
	   
        // Javascript Code Courtesy Of WP-AddQuicktag (http://bueltge.de/wp-addquicktags-de-plugin/120/)
        echo '<script type="text/javascript">'."\n";
        echo "\t".'function insertzoom(where, myField) {'."\n";
        //echo "\t\t".'var zoom_height = prompt("'.js_escape(__('Enter height (0.5 = 50%)', 'superslider')).'");'."\n";
        echo "\t\t".'if(where == "code") {'."\n";
        echo "\t\t\t".'edInsertContent(myField, "[zoom zoom_time=\"'.$zoom_time.'\" zoom_trans=\"'.$zoom_trans.'\" zoom_back=\"'.$zoom_back.'\" zoom_pad=\"'.$zoom_pad.'\" zoom_border=\"'.$zoom_border.'\"]your content to zoom here[/zoom]");'."\n";
        echo "\t\t".'} else {'."\n";
        echo "\t\t\t".'return "[zoom id=\"" + zoom_id + "\"]";'."\n";
        echo "\t\t".'}'."\n";
        echo "\t".'}'."\n";
        echo "\t".'if(document.getElementById("ed_toolbar")){'."\n";
        echo "\t\t".'qt_toolbar = document.getElementById("ed_toolbar");'."\n";
        echo "\t\t".'edButtons[edButtons.length] = new edButton("ed_zoommanager","'.js_escape(__('zoom', 'superslider')).'", "", "","");'."\n";
        echo "\t\t".'var qt_button = qt_toolbar.lastChild;'."\n";
        echo "\t\t".'while (qt_button.nodeType != 1){'."\n";
        echo "\t\t\t".'qt_button = qt_button.previousSibling;'."\n";
        echo "\t\t".'}'."\n";
        echo "\t\t".'qt_button = qt_button.cloneNode(true);'."\n";
        echo "\t\t".'qt_button.value = "'.js_escape(__('zoom', 'wp-zoommanager')).'";'."\n";
        echo "\t\t".'qt_button.title = "'.js_escape(__('Insert File zoom', 'wp-zoommanager')).'";'."\n";
        echo "\t\t".'qt_button.onclick = function () { insertzoom(\'code\', edCanvas);}'."\n";
        echo "\t\t".'qt_button.id = "ed_zoommanager";'."\n";
        echo "\t\t".'qt_toolbar.appendChild(qt_button);'."\n";
        echo "\t".'}'."\n";
        echo '</script>'."\n";
    }
    function zoom_add_script(){

        echo "\t<!-- SuperSlider Zoomer script available at http://wp-superslider.com/ -->\n";		
        echo "\t".'<script src="'.$this->js_path.'zoomer.js" type="text/javascript"></script> '."\n";
    }
    function zoom_starter(){ 
        global $zoom_started;
        extract($this->ssBaseOpOut);
        
		$zoom_trans = 	$zoom_trans_type.':'.$zoom_trans_typeinout;
		if ($css_load != 'off') {
		      $wait = $this->css_path.'/images/loading.gif';
		      $error = $this->css_path.'/images/error.png';
		}

		$myzoomer = 'var ssZoom'.$this->acc_id.' = new ByZoomer(\'zoom'.$this->acc_id.'\', {
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

            $zoomerOut = "\n\t"."<script type=\"text/javascript\">\n";
			$zoomerOut .= "\t"."// <![CDATA[\n";		
			$zoomerOut .= "window.addEvent('domready', function() {".$myzoomer."
						});\n";
			$zoomerOut .= "\t"."// ]]></script>\n";
			
			if ($zoom_started != 'true') echo $zoomerOut;
			$zoom_started = 'true';
    }
        /**
	*	Look ahead to check if any posts contain the [zoom ] shortcode or class
	*/
	function zoom_scan () { 
	   global $posts;
	   global $zoom_started;
	   extract($this->ssBaseOpOut);

        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $post ) { 
            if ( false !== strpos ( $post->post_content, 'zoom' ) ) {                 
                add_action ( "wp_head", array(&$this,"zoom_add_script"));
                //add_action ( "wp_head", array(&$this,"zoom_starter"));
                    break; 
            }  
         }
	}
	function zoom_replace($content) {
    
        $this->zoom_add_script();
        $this->zoom_starter();
        
        $pattern = "/<a(.*?)href=(.*?)><img(.*?)\/>(.*?)/i";
        $replacement = '<a$1href=$2 class="zoom"><img$3 />$4';
        $content = preg_replace($pattern, $replacement, $content);
        
		return $content;
    }
	    /**
    * The zoom shortcode must be enclosed , ie: [zoom][/zoom]
    */
    function zoom_shortcode_out($atts, $content){
        global $zoom_started;
        //extract(shortcode_atts(array(
        $atts = (shortcode_atts(array(
			'zoom_time' => '',
			'zoom_trans' => '',
			'zoom_border' => '',
			'zoom_pad' => '',
			'zoom_back' => ''), $atts));
	
		// opdate options if any changes with shortcode
		$this->ss_change_options($atts);
        extract($this->ssBaseOpOut);
	
		$pattern = "/<a(.*?)href=(.*?)><img(.*?)\/>(.*?)/i";
        $replacement = '<a$1href=$2 class="zoom"><img$3 />$4';
        $content = preg_replace($pattern, $replacement, $content);
        
        $content .= $this->zoom_starter($zoom_started);
        return do_shortcode($content);
    }
	/**
	*	Look ahead to check if any posts contain the <div id="slider">
	*/
	function scroll_scan () { 
	   global $posts; 
	   extract($this->ssBaseOpOut);
	   
        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $mypost ) {         
                if ( false !== strpos ( $mypost->post_content, '<div id="scroll"' ) ) {                 
                        add_action ( "wp_head", array(&$this,"scroll_add_script"));  
                        break; 
                } 
         }
	}
	function scroll_add_script() {
    
        extract($this->ssBaseOpOut);
        $scroll_trans = $scroll_trans.':'.$scroll_transout;
        echo "\t<!-- The following js and css is part of the SuperSlider Scroll script available at http://wp-superslider.com/ -->\n";							
		if ($css_load != 'off' && $scroll_css == 'on') {
		      echo "\t".'<link type="text/css" rel="stylesheet" rev="stylesheet" href="'.$this->css_path.'/scroll.css" media="screen" />'."\n";
		}

     $myscroll = "  var scroller = new Fx.Scroll(window,{      
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
                    scroller.toElement(elements[i]);
             });
         });

         $$('.totop').each(function(elem,i){
            elem.addEvent('click',function(e){
                    e.preventDefault();
                    e.stop();
                    //scroller.toElement(start);
                    scroller.toTop(0, 0);
             });
         });
         ";

        $scrollOut = "\n\t"."<script type=\"text/javascript\">\n";
        $scrollOut .= "\t"."// <![CDATA[\n";		
        $scrollOut .= "window.addEvent('domready', function() {
        ".$myscroll."
        });\n";
        $scrollOut .= "\t"."// ]]></script>\n";

        echo $scrollOut;
   }
    
    /**
	*  Add Quick Tag For slide In Code >= WordPress 2.5+
	*/
    function scroll_codeview_button() {
        // Javascript Code Courtesy Of WP-AddQuicktag (http://bueltge.de/wp-addquicktags-de-plugin/120/)
        echo '<script type="text/javascript">'."\n";
        echo "\t".'function insertscroll(where, myField) {'."\n";
        echo "\t\t".'if(where == "code") {'."\n";
        echo "\t\t\t".'edInsertContent(myField, "<div id=\"scroll\" class=\"scrollbar\"><a href=\"#\">your link1</a><a href=\"#\">your link2</a><a href=\"#\">your link3</a></div>\n<div id=\"scroll1\" class=\"scrollbox\">your content here. <a href=\"#\" class=\"totop\">link to top</a></div>\n<div id=\"scroll2\" class=\"scrollbox\">your content here. <a href=\"#\" class=\"totop\">link to top</a></div>\n<div id=\"scroll3\" class=\"scrollbox\">your content here. <a href=\"#\" class=\"totop\">link to top</a></div>");'."\n";
        echo "\t\t".'} else {'."\n";
        echo "\t\t\t".'return "[scroll id=\"" + superslider_id + "\"]";'."\n";
        echo "\t\t".'}'."\n";
        echo "\t".'}'."\n";
        echo "\t".'if(document.getElementById("ed_toolbar")){'."\n";
        echo "\t\t".'qt_toolbar = document.getElementById("ed_toolbar");'."\n";
        echo "\t\t".'edButtons[edButtons.length] = new edButton("ed_scroll","'.js_escape(__('scroll', 'superslider')).'", "", "","");'."\n";
        echo "\t\t".'var qt_button = qt_toolbar.lastChild;'."\n";
        echo "\t\t".'while (qt_button.nodeType != 1){'."\n";
        echo "\t\t\t".'qt_button = qt_button.previousSibling;'."\n";
        echo "\t\t".'}'."\n";
        echo "\t\t".'qt_button = qt_button.cloneNode(true);'."\n";
        echo "\t\t".'qt_button.value = "'.js_escape(__('scroll', 'superslider')).'";'."\n";
        echo "\t\t".'qt_button.title = "'.js_escape(__('Insert Page scroll', 'superslider')).'";'."\n";
        echo "\t\t".'qt_button.onclick = function () { insertscroll(\'code\', edCanvas);}'."\n";
        echo "\t\t".'qt_button.id = "ed_scroll";'."\n";
        echo "\t\t".'qt_toolbar.appendChild(qt_button);'."\n";
        echo "\t".'}'."\n";
        echo '</script>'."\n";
    }
    
    
    /**
    *   Function: Add Quick Tag In TinyMCE >= WordPress 2.5
    */
    function scroll_tinymce_addbuttons() {
        if(!current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
            return;
        }
       // if(get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', array(&$this,'scroll_tinymce_addplugin') );
            add_filter('mce_buttons', array(&$this,'scroll_tinymce_registerbutton'));
       // }
    }
    function scroll_tinymce_registerbutton($buttons) {

        array_push($buttons, 'separator', 'scroll');
        return $buttons;
    }
    function scroll_tinymce_addplugin($plugin_array) {

        $plugin_array['scroll'] = plugins_url('superslider/tinymce/plugins/scroll/editor_plugin.js');
// var_dump($plugin_array);
       return $plugin_array;
       
    }
        /**
    *   Add css to admin header for scroll
    
    function scroll_header_tinymce() {
            extract($this->ssBaseOpOut);
        	echo "\t".'<link type="text/css" rel="stylesheet" rev="stylesheet" href="'.$this->css_path.'/scroll.css" media="screen" />'."\n";

    }*/
    	
    	/**
    	*
    	  if( function_exists('slide_comments') ) 
  	         slide_comments(); 
             else 
  	         comments_template();
    	
    	function comments_scan() {
    	   if ( is_single() ) {
    	       add_action ( "wp_head", array(&$this,"com_add_script")); 
    	   }
    	}
    	function slide_comments(){
    	  // extract($this->ssBaseOpOut);
    	   if ( is_single() ) {        //is_singular()
    	       add_action ( "wp_head", array(&$this,"com_add_script")); 
    	    }
    	
    	}*/
    	/*
    	function com_add_script(){
            extract($this->ssBaseOpOut);
               
                echo "\t<!-- SuperSlider Comment Slider script available at http://wp-superslider.com/ -->\n";							
                if ($css_load != 'off' && $com_css == 'on') {
                      echo "\t".'<link type="text/css" rel="stylesheet" rev="stylesheet" href="'.$this->css_path.'/slide_comments.css" media="screen" />'."\n";
                }

				//"com_trans"      =>  "sine",
				//"com_transout"   =>  "out",
            

            $myslideCom = "var comSlide = new Fx.Reveal($('slide_comments'), {
                    duration: '".$com_time."', 
                    mode: '".$com_direction."'});
            comSlide.toggle();
            
            $('slidein').addEvent('click', function(e){
                e = new Event(e);	
                $$('#comment_bar .comselected').removeClass('comselected');
                    this.addClass('comselected');		
                comSlide.toggle();
                e.stop();
                });
            $('slideout').addEvent('click', function(e){
                e = new Event(e);	
                $$('#comment_bar .comselected').removeClass('comselected');
                    this.addClass('comselected');		
                comSlide.toggle();
                e.stop();
                });
            
            ";
        
            $slideComOut = "\n\t"."<script type=\"text/javascript\">\n";
			$slideComOut .= "\t"."// <![CDATA[\n";		
			$slideComOut .= "window.addEvent('domready', function() {
			".$myslideCom."
			});\n";
			$slideComOut .= "\t"."// ]]></script>\n";

			echo $slideComOut;
	
    	}
    	function com_slide_out(){
    	   /**
    	   * extract($this->ssBaseOpOut);
//echo 'comment slider is here, and com is :'.$com.' : ';
    	   //<?php comments_template();
    	   if ( file_exists( $include ) )
     	           require( $include );
    	      elseif ( file_exists( TEMPLATEPATH . $file ) )
     	           require( TEMPLATEPATH .  $file );
    	      else
    	           require( get_theme_root() . '/default/comments.php');



            $com_bar = '<div id="comment_bar"><div class="comslider comment_tab_open">
            <a href="#" id="slidein" title="view comments">'.$com_open;
            $com_bar .=  comments_number('0','1','%');
            $com_bar .= '</a></div><div class="comslider comment_tab_close" >
            <a href="#" id="slideout" class="comselected" title="hide comments">'.$com_close;
            $com_bar .= '</a></div></div><div id="slide_comments">';
            $com_bar .= comments_template().'</div><br style="clear:both;" />';
            
            echo $com_bar; 
    	}*/

    
}	//end class
} //End if Class ssBase

/**
*instantiate the class
*/	
if (class_exists('ssBase')) {
	$myssBase = new ssBase();
}
?>