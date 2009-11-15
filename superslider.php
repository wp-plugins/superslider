<?php
/*
Plugin Name: SuperSlider
Plugin URI: http://wp-superslider.com/superslider
Description: SuperSlider base, is an optional global admin plugin for all SuperSlider plugins. Superslider base also includes the following numerous web 2 motion modules.
Author: Daiv Mowbray
Version: 0.9.1
Author URI: http://wp-superslider.com
Tags: animation, animated, gallery, slideshow, mootools 1.2, mootools, accordion, slider, superslider, lightbox, link, effects, web2


Credits:

Image reflect - http://www.digitalia.be/software/reflectionjs-for-mootools
Image zoomer - http://www.byscripts.info/mootools/byzoomer
Multiple Accordion - http://www.clientcide.com/wiki/cnet-libraries/08-layout/02.1-multipleopenaccordion
Page Scroller _ http://wp-superslider.com/superslider
Link Nudger - http://www.nwhite.net/2009/02/07/insights-from-link-nudging/
Fader - http://davidwalsh.name/opacity-focus 
Linker - http://davidwalsh.name/iphone-click 
Word wrap - http://davidwalsh.name/word-wrap-mootools-php
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
		var $ssBaseOpOut;
		var $defaultAdminOptions;
		var $AdminOptionsName = 'ssBase_options';
		var $reflect_started = 'false';
		var $reflect_script_added = 'false';
		var $zoom_started = 'false';
		var $has_zoomed = 'false';
		var $nudger_started = 'false';
		var $fader_started = 'false';
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
		global $defaultAdminOptions; 
		
		$defaultAdminOptions = array(
				"load_moo" => "on",
				"css_load" => "default",		
				"css_theme" => "default",
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
				"nudger" => "on",
				"nudge_amount" => "20",
                "nudge_duration" => "500",
                "nudge_family" => "#footer a, #sidebar a",
                "fader" => "on",
                "fader_family" => ".fader",
                "fader_opacity" => "0.5",
                "linker" => "on",
                "linker_tag" => "a",
                "linker_color" => "#ffbdd2",
                "clicker" => "on",
                "clicker_tag" => ".clickable li",
                "clicker_span" => "false",
                "clicker_color" => "#c9e0f4",
                "wrap" => "off",
				"ss_global_over_ride" => "on");
		
		
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
//var_dump($this->ssBaseOpOut);
//echo " ss_global_over_ride is : ".$ss_global_over_ride;
  			$this->base_over_ride = $ss_global_over_ride;
  			
  			$this->set_base_paths($css_load, $css_theme);
  			
  			$this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
  			
  			wp_register_script(
			'moocore',
			$this->js_path.'mootools-1.2.3-core-yc.js',
			NULL, '1.2.3');
			
			wp_register_script(
			'moomore',
			$this->js_path. 'mootools-1.2.3.1-more.js',
			array( 'moocore' ), '1.2.3');
			
			/** new script registry */
			
			/*wp_register_script(
			'reflection',
			$this->js_path.'reflection.js',
			array( 'moocore' ), '1');*/
			
			wp_register_script(
			'multiopen-accordion',
			$this->js_path.'multiopen-accordion.js',
			array( 'moocore' ), '1', true);
			
			wp_register_style(
			'accordion_style', 
			$this->css_path.'/accordion.css');
			
			wp_register_style(
			'scroll_style', 
			$this->css_path.'/scroll.css');
			
			wp_register_script(
			'zoomer',
			$this->js_path.'zoomer.js',
			array( 'moomore' ), '1', true);
			
			/*wp_register_script(
			'nudger',
			$this->js_path.'nudger.js',
			array( 'moocore' ), '1');*/
			
			/*wp_register_script(
			'clicker',
			$this->js_path.'clicker.js',
			array( 'moocore' ), '1');*/

			/*wp_register_script(
			'word_wrap',
			$this->js_path.'word_wrap.js',
			array( 'moocore' ), '1');*/

  			//add_action( 'admin_menu', array(&$this,'ssBase_setup_optionspage'));					
			add_action('wp_enqueue_scripts', array(&$this,'ssBase_add_javascript'),3); //this loads the mootools scripts.
            
            
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
                     wp_enqueue_script('zoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }    
            }
         
            if ( $scroll == 'on'){  
                 add_action ( 'admin_footer', array( &$this, 'scroll_codeview_button' ) );
			     add_action ( 'template_redirect' , array( &$this,'scroll_scan' ) );
			    
            }
            
            if ( $reflect == 'on'){			    
			      add_action ( 'template_redirect' , array(&$this,'reflect_scan') );
                  add_shortcode ( 'reflect' , array(&$this, 'reflect_shortcode_out') ); //disabled as it fails to work
                  add_action('admin_footer', array(&$this, 'reflect_footer_admin') );
               if ( $auto_reflect == 'on'){ 
                     add_filter( 'the_content', array(&$this, 'reflect_replace') );
                }        
            }

            if ( $nudger == 'on'){                  
                   add_action ( "wp_footer", array(&$this,"nudger_starter"));
                  
            }
            if ( $fader == 'on'){   
                   add_action ( "wp_footer", array(&$this,"fader_starter"));
                  
            }
           
            if ( $clicker == 'on'){                    
                   add_action ( "wp_footer", array(&$this,"clicker_starter"));
                   add_action ( "wp_head", array(&$this,"clicker_add_css"));
            }
            
            if ( $linker == 'on'){
                   add_action ( "wp_footer", array(&$this,"link_starter"), 10, 1);
                   add_action ( "wp_head", array(&$this,"link_css"), 10, 1);
                   
            }
            
            if ( $wrap == 'on'){ 
                add_action('wp_enqueue_scripts', array(&$this,'word_wrap_add_script'),3);
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
				$plugin_page = add_options_page(__('SuperSlider'),__('SuperSlider-Base'), 8, 'superslider', array(&$this, 'ssBase_ui'));
				add_filter('plugin_action_links', array(&$this, 'filter_plugin_show'), 10, 2 );
				
				add_action ( 'admin_print_styles', array(&$this,'ssBase_admin_style'));
				add_action ('admin_print_scripts-'.$plugin_page, array(&$this,'ssBase_admin_script'));
	
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
	function ssBase_admin_style(){

			$cssAdminFile = WP_PLUGIN_URL.'/superslider/admin/ss_admin_style.css';  
    	    
    	    wp_register_style('superslider_admin', $cssAdminFile);
        	wp_enqueue_style( 'superslider_admin');

	}
	
	function ssBase_admin_script(){
		wp_enqueue_script('jquery-ui-tabs');	// this should load the jquery tabs script into head
		
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
                    add_action ( "wp_footer", array(&$this,"reflect_starter"));
                    break; 
            } 
         }  
	}
    
    function reflect_replace($content) {
    
        $this->reflect_starter();
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect$9$10 rel='test'/>";
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
        extract($this->ssBaseOpOut);
		
        $pattern = "/<img(.*?)src=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)class=('|\")(.*?)('|\")(.*?) \/>/i";
        $replacement = "<img$1src=$2$3.$4$5$6class=$7$8 reflect$9$10 />";
        $content = preg_replace($pattern, $replacement, $content);

        add_action ( "wp_footer", array(&$this,"reflect_starter"));
        return do_shortcode($content);
        
    }
    
    function reflect_starter(){
      
        extract($this->ssBaseOpOut);
               
        if ($this->reflect_started != 'true'){
			 
			 $myreflect = '$$("img").filter(function(img) { return img.hasClass("reflect"); }).reflect({ height:'.$reflect_height.', opacity:'.$reflect_opacity.'});';

			 $this->open_addEvent() ;
			 echo'Element.implement({reflect:function(b){var a=this;if(a.get("tag")=="img"){b=$extend({height:0.33,opacity:0.5},b);a.unreflect();function c(){var i,f=Math.floor(a.height*b.height),j,d,h;if(Browser.Engine.trident){i=new Element("img",{src:a.src,styles:{width:a.width,height:a.height,marginBottom:-a.height+f,filter:"flipv progid:DXImageTransform.Microsoft.Alpha(opacity="+(b.opacity*100)+", style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy="+(b.height*100)+")"}})}else{i=new Element("canvas");if(!i.getContext){return}try{d=i.setProperties({width:a.width,height:f}).getContext("2d");d.save();d.translate(0,a.height-1);d.scale(1,-1);d.drawImage(a,0,0,a.width,a.height);d.restore();d.globalCompositeOperation="destination-out";h=d.createLinearGradient(0,0,0,f);h.addColorStop(0,"rgba(255, 255, 255, "+(1-b.opacity)+")");h.addColorStop(1,"rgba(255, 255, 255, 1.0)");d.fillStyle=h;d.rect(0,0,a.width,f);d.fill()}catch(g){return}}i.setStyles({display:"block",border:0});j=new Element(($(a.parentNode).get("tag")=="a")?"span":"div").injectAfter(a).adopt(a,i);j.className=a.className;a.store("reflected",j.style.cssText=a.style.cssText);j.setStyles({width:a.width,height:a.height+f,overflow:"hidden"});a.style.cssText="display: block; border: 0px";a.className="reflected"}if(a.complete){c()}else{a.onload=c}}return a},unreflect:function(){var b=this,a=this.retrieve("reflected"),c;b.onload=$empty;if(a!==null){c=b.parentNode;b.className=c.className;b.style.cssText=a;b.store("reflected",null);c.parentNode.replaceChild(b,c)}return b}});';
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
			
        //if ($this->open_addEvent != 'true') 
        echo $addEvent;
        
        $this->open_addEvent = 'true';
   }
   function close_addEvent() {
    
        $closeEvent = "\n});\n";
        $closeEvent .= "// ]]>\n";
        $closeEvent .= "</script>\n";
        
        //if ($this->close_addEvent != 'true' & $this->open_addEvent == 'true' ) 
        
        echo $closeEvent;
        
       $this->close_addEvent = 'true';
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
                       
                       if ($acc_mode != 'on') {
                            wp_enqueue_script('multiopen-accordion');
                        }
                        if ($css_load != 'off' && $acc_css == 'on') {
                             add_action('wp_print_styles', array(&$this,'accordion_add_css'));
                        }
                        //break; 
                }  
         }
	}
    /**
	* add the accordion code
	*/
    function accordion_shortcode_out ($atts, $content=''){
         
         $atts = (shortcode_atts(array(
            'auto_accordion' => '',
            'acc_mode' => '',            
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
		$this->my_acc_id = rand(0,1000); 
		
        $pattern = "/<".$acc_togtag."(.*?)>/i";
        $replacement = "<".$acc_togtag." class=\"".$acc_toggler."\"$1>";
        $content = preg_replace($pattern, $replacement, $content);
        
        $pattern = "/<".$acc_elemtag."(.*?)>/i";
        $replacement = "<".$acc_elemtag." class=\"".$acc_elements."\"$1>";
        $content = preg_replace($pattern, $replacement, $content);

        $output = "<div id=\"accordion".$this->my_acc_id."\" class=\"".$acc_container."\">".$content."</div>";
        
        //add_action ( "wp_footer", array(&$this,"accordion_starter"));
        $output .= $this->accordion_starter();
        return do_shortcode($output);
        
    }

    /**
	* add the accordion css
	*/
    function accordion_add_css(){
        wp_enqueue_style( 'accordion_style');

	}
	
	function accordion_starter(){

		extract($this->ssBaseOpOut);
		if ($acc_mode == 'on') {
		  $myaccordion = 'var ssAcc'.$this->my_acc_id.' = new Accordion($(\'accordion'.$this->my_acc_id.'\'), 
		                    \'#accordion'.$this->my_acc_id.' .'.$acc_toggler.'\',       
		                    \'#accordion'.$this->my_acc_id.' .'.$acc_elements.'\',  
		                    {           
                            fixedHeight: '.$acc_fixedheight.',    
                            fixedWidth: '.$acc_fixedwidth.',      
                            height: '.$acc_height.',              
                            opacity: '.$acc_opacity.',            
                            width: '.$acc_width.',                
                            display: ['.$acc_firstopen.']        
                            });';
		  } else {  		  
		  $myaccordion = 'var ssAcc'.$this->my_acc_id.' = new MultipleOpenAccordion($(\'accordion'.$this->my_acc_id.'\'), {
		                    togglers:$$(\'#accordion'.$this->my_acc_id.' .'.$acc_toggler.'\'),       
		                    elements:$$(\'#accordion'.$this->my_acc_id.' .'.$acc_elements.'\'),  		                    
                            openAll: '.$acc_openall.',            
                            fixedHeight: '.$acc_fixedheight.',    
                            fixedWidth: '.$acc_fixedwidth.',      
                            height: '.$acc_height.',              
                            opacity: '.$acc_opacity.',            
                            width: '.$acc_width.',                
                            firstElementsOpen: ['.$acc_firstopen.']        
                            });';
             }
			
			$this->open_addEvent() ;

			  echo $myaccordion;
			
			 $this->close_addEvent() ;
				
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

    function zoom_starter(){ 
        extract($this->ssBaseOpOut);
        
		$zoom_trans = 	$zoom_trans_type.':'.$zoom_trans_typeinout;
		if ($css_load != 'off') {
		      $wait = $this->css_path.'/images/loading.gif';
		      $error = $this->css_path.'/images/error.png';
		}
		$myzoomer = 'var ssZoom'.$this->my_id.' = new ByZoomer(\'zoom\', { //'.$this->my_id.'
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
	   extract($this->ssBaseOpOut);

        if ( !is_array ( $posts ) ) 
                return; 	 
        foreach ( $posts as $post ) { 
            if ( false !== strpos ( $post->post_content, 'zoom' ) ) {                 
               
                if ($this->has_zoomed != 'true') {	
                     wp_enqueue_script('zoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }
                
                $this->has_zoomed = 'true';
                
                //break; 
            }  
         }
	}
	function zoom_replace($content) {

       /* if ($this->has_zoomed != 'true') {	
                     wp_enqueue_script('zoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }*/
                
       $this->has_zoomed = 'true';
                
        $pattern = "/<a(.*?)href=(.*?)><img(.*?)\/>(.*?)/i";
        $replacement = '<a$1href=$2 class="zoom"><img$3 />$4';
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
        extract($this->ssBaseOpOut);
	
		$pattern = "/<a(.*?)href=(.*?)><img(.*?)\/>(.*?)/i";
        $replacement = '<a$1href=$2 class="zoom"><img$3 />$4';
        $content = preg_replace($pattern, $replacement, $content);
        
        if ($this->has_zoomed != 'true') {	
                     wp_enqueue_script('zoomer');
                     add_action('wp_footer', array(&$this,'zoom_starter'));
                }
                
       $this->has_zoomed = 'true';

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
                        add_action ( "wp_footer", array(&$this,"scroll_add_script")); 
                        if ($css_load != 'off' && $scroll_css == 'on') {
                             add_action('wp_print_styles', array(&$this,'scroll_add_css'));
                             }
                        break; 
                } 
         }
	}
	
	function scroll_add_css() {
		wp_enqueue_style( 'scroll_style');
	
	}
	function scroll_add_script() {
    
        extract($this->ssBaseOpOut);
        $scroll_trans = $scroll_trans.':'.$scroll_transout;
        

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
/*
        $scrollOut = "\n\t"."<script type=\"text/javascript\">\n";
        $scrollOut .= "\t"."// <![CDATA[\n";		
        $scrollOut .= "window.addEvent('domready', function() {
        ".$myscroll."
        });\n";
        $scrollOut .= "\t"."// ]]></script>\n";

        echo $scrollOut;
        */
        
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
    
   /* function nudger_add_script(){
    
        if (!is_admin()) {	
            //wp_enqueue_script('nudger');
        }

    }*/
    function nudger_starter(){

        extract($this->ssBaseOpOut);
        
        // do not make these available on options page.
        $nudge_trans='linear'; // linear, sine, circ
        $nudge_transout='inout';
        //$nudge_trans = $nudge_trans.':'.$nudge_transout;
      
        
        srand((double)microtime()*1000000); 
		$this->my_id = rand(0,1000); 
		
        $mynudger = 'var ssNudg'.$this->my_id.' = new Nudger(\''.$nudge_family.' \', { 
                            transition:  Fx.Transitions.'.$nudge_trans.',
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

        extract($this->ssBaseOpOut);

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
    
   function link_starter($linker_tag){

        extract($this->ssBaseOpOut);

        $mylink = "	var lynx = $$('".$linker_tag."');
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
        
        extract($this->ssBaseOpOut);
        
        $mylinkstyle = "<style type=\"text/css\" media=\"screen\">.clicked { -moz-border-radius:5px; -webkit-border-radius:5px; background:".$linker_color.";padding:0 4px; }</style>";
        
        if (!is_admin()) {  
         
             echo $mylinkstyle;
        
        }
    }
    
   function clicker_starter(){

        extract($this->ssBaseOpOut);

        $myclicker = "var clix = new Clickables({
                         elements: '".$clicker_tag."',
                         selectClass: '',
                         anchorToSpan: ".$clicker_span."
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
    
        extract($this->ssBaseOpOut);
        
        $myclickstyle = "<style type=\"text/css\" media=\"screen\">".$clicker_tag.":hover { background:".$clicker_color.";cursor:pointer; }</style>";
        
        if (!is_admin()) {    
             echo $myclickstyle;
        }
    }
    
    /*function clicker_add_script(){
    
        if (!is_admin()) {	
            wp_enqueue_script('clicker');
        }
    }*/
    /**
    function word_wrap_add_script(){
    
        if (!is_admin()) {	
            //wp_enqueue_script('word_wrap');
        }

    }
    
    *   Function: Add Quick Tag In TinyMCE >= WordPress 2.5
    
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
       
    }*/
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
            
var comSlide = new Fx.Slide('slide_comments', {duration: 3000, mode: 'vertical',transition: Fx.Transitions.Pow.easeOut

            $myslideCom = "var comSlide = new Fx.Slide($('slide_comments'), {
                    duration: '".$com_time."', 
                    mode: '".$com_direction."',
                    transition:".$com_trans."});
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