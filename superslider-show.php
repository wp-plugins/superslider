<?php
/*
Plugin Name: SuperSlider
Plugin URI: http://wp-superslider.com/superslider
Description: Animated Gallery slideshow uses Mootools 1.2 javascript and Slideshow2 to replace wordpress gallery with a slideshow. 
Author: Daiv Mowbray
Version: 1.0
Author URI: http://wp-superslider.com
Tags: animation, animated, gallery, slideshow, mootools 1.2, mootools, slider, superslider

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

if (!class_exists("ssShow")) {
	class ssShow {
		
		/**
		* @var string   The name of this class.
		*/
	var $my_name;

	
	// Pre-2.6 compatibility
	function set_show_paths()
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
		
		self::superslider_show();
	
	}// end construct
		
		/**
		 * language switcher
		 */
	function language_switcher(){
		global $ssShow_domain, $ssShow_is_setup;

  				if ( $ssShow_is_setup) {
     				return;
  				} 
  			// define some language related variables
		$ssShow_domain = 'superslider-show';
  		$ss_show_locale = get_locale();
		$ss_show_mofile = WP_LANG_DIR."/superslider_show-".$ss_show_locale.".mo";
  				//load the language
  			load_plugin_textdomain($ssShow_domain, $ss_show_mofile);
  			$plugin_text_loaded = true; // language is loaded
	}// end language switcher
	
			/**
		* Retrieves the options from the database.
		* @return array
		*/			
	function set_default_admin_options() {
		$defaultAdminOptions = array(
				'ss_shortcode' => "gallery",
				'load_moo' => "on",
				'css_load' => "default",		
				'css_theme' => "default",
				'show_class' => "",
				'ss_href'	=>	"",
				'show_type' => "default", //default, kenburns, push, fold
				'ss_image_size' => "large",
				'ss_first_slide' => "0",
				'ss_zoom' => "25",
				'ss_pan' => "[25, 75]",
				'ss_color' => "#fff",
				'ss_height' => "400",
				'ss_width' => "450",
				'ss_center' => "true",
				'ss_resize' => "true",
				'ss_linked' => "true",
				'ss_fast' => "false",
				'ss_captions' => "true",
				'ss_overlap' => "true",
				'ss_thumbnails' => "true",
				'ss_mouseover'	=> "false",
				'ss_thumb_height' => "40",
				'ss_thumb_width' => "40",
				'ss_paused' => "false",
				'ss_random' => "false",
				'ss_loop' => "true",
				'ss_loader' => "true",
				'ss_delay' => "4000",
				'ss_controller' => "true",
				'ss_duration' => "1200",
				'ss_trans_type' => "sine",
				'ss_trans_typeinout' => "out",
				'ss_tool_tips' => "true",
				'ss_lightbox' => "on",
				'ss_lightbox_add' => "on",
				'ss_lightbox_type' => "Lightbox");//end array
		
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
	function ssShow_init() {
  				
  			$this->defaultAdminOptions = $this->set_default_admin_options();
  			

	}
		
		/**
		* Load admin options page
		*/
	function ssShow_ui() {
	
		include_once 'admin/superslider-show-ui.php';
		
	}

		/**
		* Initialize the admin panel, Add the plugin options page, loading it in from superslider-show-ui.php
		*/
	function ssShow_setup_optionspage() {
		if (  function_exists('add_options_page') ) {
			if (  current_user_can('manage_options') ) {
				add_options_page(__('SuperSlider Show'),__('ss-Show'), 8, 'superslider-show', array(&$this, 'ssShow_ui'));
				
				//if ( VERSION >= 2.7)add_filter('plugin_action_links_'. plugin_basename(__FILE__), 'add_settings_link' );
				add_filter('plugin_action_links', array(&$this, 'filter_plugin_show'), 10, 2 );
				//add_action('in_admin_footer', array(&$this, 'ssShow_admin_footer'), 11 );
			}					
		}
	}
	
	function ssShow_admin_footer() {
		$plugin_data = get_plugin_data( __FILE__ );
		printf('%1$s plugin | Version %2$s | by %3$s<br />', $plugin_data['Title'], $plugin_data['Version'], $plugin_data['Author']);
	}

		/**
		* Add link to options page from plugin list WP 2.6.
		*/
	function filter_plugin_show($links, $file) {
		 static $this_plugin;
			if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

		if (  $file == $this_plugin )
			$settings_link = '<a href="options-general.php?page=superslider-show">'.__('Settings').'</a>';
			array_unshift( $links, $settings_link ); //  before other links
	
		return $links;
	}
		/**
		* Add link to options page from plugin list WP 2.7.
		*/
	function add_settings_link( $links ) { 
		  $settings_link = '<a href="superslider-show.php">Settings</a>'; 
		  array_unshift( $links, $settings_link ); 
		  return $links; 
	}
		 
		
			/**
   			 * plugin settings link for WP 2.7
   			 *add_action('plugin_action_links_' . plugin_basename(__FILE__), 'filter_plugin_actions');
			function filter_plugin_actions($links) {
  				$settings_link = '<a href="options-general.php?page=superslider-show">'.__('Settings').'</a>';
				array_unshift( $links, $settings_link ); // before other links
			return $links;
			}
   			 */
   			 
   			 
		/**
		* Removes user set options from data base upon deactivation
		*/
		
	function options_deactivation(){
		delete_option($this->AdminOptionsName);
	}

	function ssShow_add_javascript(){
		$js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
		global $kenburns_js;
		global $push_js;
		global $fold_js;
		global $flash_js;
		
		$t = $this->ssShowOpOut;
		$ss_loadMoo = $t['load_moo'];	
		$ssShow_type = $t['show_type'];
		$ss_lightbox_add = $t['ss_lightbox_add'];
		$ss_lightbox_type = strtolower($t['ss_lightbox_type']);
		
		$kenburns_js = "\t".'<script src="'.$js_path.'slideshow.kenburns.js" type="text/javascript"></script> '."\n";
		$push_js = "\t".'<script src="'.$js_path.'slideshow.push.js" type="text/javascript"></script> '."\n";
		$fold_js = "\t".'<script src="'.$js_path.'slideshow.fold.js" type="text/javascript"></script> '."\n";
		$flash_js = "\t".'<script src="'.$js_path.'slideshow.flash.js" type="text/javascript"></script> '."\n";
		$lightbox_js = "\t".'<script src="'.$js_path.''.$ss_lightbox_type.'.js" type="text/javascript"></script> '."\n";
		
		echo "\t<!-- The following js is part of the SuperSlider-show plugin available at http://wp-superslider.com/ -->\n";
	if (!is_admin())
			{				
				if (function_exists('wp_enqueue_script')) {
					if ($ss_loadMoo == 'on'){
						//wp_enqueue_script('moocore', $js_path.'mootools-1.2-core.js' NULL, 1.2);		
						//wp_enqueue_script('moomore', $js_path.'mootools-1.2-more.js', array('moocore'), 1.2);
						echo "\t".'<script src="'.$js_path.'mootools-1.2-core.js" type="text/javascript"></script> '."\n";
						echo "\t".'<script src="'.$js_path.'mootools-1.2-more.js" type="text/javascript"></script> '."\n";
					};
						
					//wp_enqueue_scrip('superslider_show', $js_path.'superslider_show.js', array($libtitle));
					echo "\t".'<script src="'.$js_path.'slideshow.js" type="text/javascript"></script> '."\n";	
					
					if ($ssShow_type == 'kenburns')
						
						echo $kenburns_js;	
						
					elseif ($ssShow_type == 'push')
						
						echo $push_js;
						
					elseif ($ssShow_type == 'fold')
						
						echo $fold_js;	
						
					elseif ($ssShow_type == 'flash')
						
						echo $flash_js;
					
					// add the lightbox if needed
					if ($ss_lightbox_add == 'on')
						
						echo $lightbox_js;
				
				}	
			}
	}
		/**
		* register and Add js and css script into head 
		*/
	function ssShow_add_css(){
		
		$t = $this->ssShowOpOut;
		$cssLoad = $t['css_load'];
		$cssTheme = $t['css_theme'];	
		$ss_lightbox_add = $t['ss_lightbox_add'];
		$ss_lightbox_type = strtolower($t['ss_lightbox_type']);
		$ss_tool_tips = $t['ss_tool_tips'];
		
		$url = get_settings('siteurl');

		echo "\t<!-- The following css is part of the SuperSlider-show plugin available at http://wp-superslider.com/ -->\n";


   		if ($cssLoad == 'default'){
    			$cssPath = WP_PLUGIN_URL.'/superslider-show/plugin-data/superslider/ssShow/'.$cssTheme.'/'.$cssTheme.'.css';
    			
    			echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    			if ($ss_lightbox_add == 'on'){
    				$lightPath = WP_PLUGIN_URL.'/superslider-show/plugin-data/superslider/ssShow/'.$ss_lightbox_type.'/'.$ss_lightbox_type.'.css';
    				echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$lightPath."' media='screen' />\n";	
    			}
    		/*	if ($ss_tool_tips == 'true'){
    				$toolPath = WP_PLUGIN_URL.'/superslider-show/plugin-data/superslider/ssShow/tool_tips_'.$cssTheme.'.css';
    				echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$toolPath."' media='screen' />\n";	
    			}*/
    		}elseif ($cssLoad == 'pluginData') {
    			$cssPath = WP_CONTENT_URL.'/plugin-data/superslider/ssShow/'.$cssTheme.'/'.$cssTheme.'.css';
    			
    			echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$cssPath."' media='screen' />\n";
    			
    			if ($ss_lightbox_add == 'on'){
    				$lightPath = WP_CONTENT_URL.'/plugin-data/superslider/ssShow/'.$ss_lightbox_type.'/'.$ss_lightbox_type.'.css';
    				echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$lightPath."' media='screen' />\n";	
    			}
    		/*	if ($ss_tool_tips == 'true'){
    				$toolPath = WP_CONTENT_URL.'/plugin-data/superslider/ssShow/tool_tips_'.$cssTheme.'.css';
    				echo "\t"."<link type='text/css' rel='stylesheet' rev='stylesheet' href='".$toolPath."' media='screen' />\n";	
    			}*/
    		}elseif ($cssLoad == 'off') {
    			$cssPath = '';
    		}    		
	}	// end function ssShow_add_css
	
		/**
		* Write the slideshow code 
		*/
	function ssShow_set_show($attr) {
		
		$t = $this->ssShowOpOut;
		$cssLoad = $t['css_load'];
		$show_class = $t['show_class'];
		$ssShow_type = $t['show_type'];
		$ss_href = $t['ss_href'];
		$ss_first_slide = $t['ss_first_slide'];
		$ss_zoom = $t['ss_zoom'];
		$ss_pan = $t['ss_pan'];
		$ss_color =$t['ss_color'];
		$ss_height = $t['ss_height'];
		$ss_width = $t['ss_width'];
		$ss_center = $t['ss_center'];
		$ss_resize = $t['ss_resize'];
		$ss_linked = $t['ss_linked'];
		$ss_fast = $t['ss_fast'];
		$ss_captions = $t['ss_captions'];
		$ss_overlap = $t['ss_overlap'];
		$ss_thumbnails = $t['ss_thumbnails'];
		$ss_mouseover = $t['ss_mouseover'];
		
		$ss_paused = $t['ss_paused'];
		$ss_random = $t['ss_random'];
		$ss_loop = $t['ss_loop'];
		$ss_loader = $t['ss_loader'];
		$ss_delay = $t['ss_delay'];
		$ss_controller = $t['ss_controller'];
		$ss_duration = $t['ss_duration'];
		$ttype = $t['ss_trans_type'];
		$ttypeinout = $t['ss_trans_typeinout'];
		if ( $attr['transition'] != '') {
			$ss_transition = $attr['transition'];
			} else {
			$ss_transition = $ttype.':'.$ttypeinout;	
		}
		$ss_lightbox = $t['ss_lightbox'];
		
		
		//set the path for the loader graphics
		if ($cssLoad == 'default') {
			$loaderPath = WP_PLUGIN_URL.'/superslider-show/plugin-data/superslider/ssShow/loader/loader-#.png';
		}elseif ($cssLoad == 'pluginData') {
			$loaderPath = WP_CONTENT_URL.'/plugin-data/superslider/ssShow/loader/loader-#.png';
		}
		
		// Create the lightbox binders
		
		//Milkbox still isn't working
		if ($ss_lightbox == 'on') {
			$ss_lightbox_type = $t['ss_lightbox_type'];
			$ss_lightbox_newtype = strtolower($t['ss_lightbox_type']);
			if ($ss_lightbox_type == 'Milkbox') { $start = 'openMilkbox'; $stop = 'closeMilkbox'; }
			if ($ss_lightbox_type == 'Lightbox') { $start = 'onOpen'; $stop = 'onClose'; }

/*			if ($ss_lightbox_type == 'Smoothbox') { $start = 'TB_show'; $stop = 'TB_remove'; }
			if ($ss_lightbox_type == 'Slimbox') { $start = 'Slimbox.open'; $stop = 'Slimbox.close'; }
			if ($ss_lightbox_type == 'slightbox') { $ss_lightbox_type = 'Lightbox'; $ss_lightbox_newtype = strtolower($ss_lightbox_type); $start = 'open'; $stop = 'close'; }// this class is Lightbox
*/			

			// Bind lightbox to slideshow
			$mylightbox =	'
		/*	ssShow'.$this->show_id.'.slideshow.retrieve(\'images\').getElements(\'a\').set(\'rel\',\''.$ss_lightbox_newtype.'\'); 
			*/var popbox = new '.$ss_lightbox_type.'({ 
			  \''.$stop.'\': function(){ this.pause(false); }.bind(ssShow'.$this->show_id.'), 
			  \''.$start.'\': function(){ this.pause(true); }.bind(ssShow'.$this->show_id.') 
			});
		/*	popbox.image.addEvent(\'click\', function()
					{ this.close(); }.bind(popbox)); */
			';
			}
			
		// Add mouseover image stop function
		if ($ss_mouseover == 'true') {
			$mymouse = '
				ssShow'.$this->show_id.'.slideshow.retrieve(\'images\').addEvents({
			  \'mouseenter\': function(){ this.pause(1); }.bind(ssShow'.$this->show_id.'),
			  \'mouseleave\': function() { this.pause(0); }.bind(ssShow'.$this->show_id.')			
			});
			';
		}
	
	/* tool tips is deactivated untill we find a way to update the content to the new image
		this could be a good way to add description.
		$tooltips = 'on';
		if ($tooltips == 'on'){
			$addTooltips = "	
	
				//store titles and text
				$$('a.tool').each(function(element,index) {
					var content = element.get('title').split('::');
					element.store('tip:title', content[0]);
					element.store('tip:text', content[1]);
				});		
				var myTips = new Tips($$('.tool'), {
								className: 'tool',
								showDelay : 350,
								hideDelay : 80,
								offsets: {'x': 0, 'y': 0},
								fixed: 'true',
								timeOut: 900,
								maxTitleChars: 50,
								maxOpacity: .9,
					initialize:function(){
						this.fxopen = new Fx.Morph(this.tip, {
								duration: 750,
								transition: Fx.Transitions.Sine.easeInOut});
						this.fxclose = new Fx.Morph(this.tip, {
								duration: 250,
								transition: Fx.Transitions.Sine.easeInOut});
					},
					onShow: function(tip) {
						tip.fade(.8);
						this.fxopen.start('.tipOpen');	
					},
					onHide: function(tip) {
						tip.fade(0);
						this.fxclose.start('.tool');
					}
				});";
		}else{
			$addTooltips = '';
		}*/
		
		// transfer options into objects befor constructing the slideshow js call.
		
		if ($ss_thumbnails == 'true') {
			$mythumb = 'fast: '.$ss_fast.',thumbnails: {duration: 700, transition: Fx.Transitions.Sine.easeOut},';
			$mythumbcover = "['a', 'b'].each(function(p){ 
						  new Element('div', { 'class': 'overlay ' + p }).inject(ssShow".$this->show_id.".slideshow.retrieve('thumbnails'));
				  }, this);";
			} else{
			$mythumb = 'fast: false,thumbnails: false,';
			}
		if ($ss_controller == 'true') {
			$mycontroller = 'controller: {duration: 1300, transition: Fx.Transitions.Sine.easeOut},';
			}
		if ($ss_loader == 'true') {
			$myloader = 'loader: { duration: 700, transition: Fx.Transitions.Sine.easeOut, \'animate\': [\''.$loaderPath.'\', 12] },';
			}
		if ($ss_captions == 'true') {
			$mycaptions = 'captions: {duration: 700, transition: Fx.Transitions.Sine.easeOut},';
			}
		if (!$ss_height == '') {$myheight = 'height:'.$ss_height.',';}
		if (!$ss_width == '') {$mywidth = 'height:'.$ss_width.',';}
		
		if ($ssShow_type == 'kenburns'){
			global $kenburns_js;
			$mynewjs = $kenburns_js;
			$new_type = 'Slideshow.KenBurns';
			$type_ops = 'zoom: '.$ss_zoom.', pan: '.$ss_pan;
			
			}
		elseif ($ssShow_type == 'push'){
			global $push_js;
			$mynewjs = $push_js;
			$new_type = 'Slideshow.Push';
			$type_ops = "transition: '".$ss_transition."'";
			//$mynewjs = $this->push_js;
			}
		elseif ($ssShow_type == 'fold'){
			global $fold_js;
			$mynewjs = $fold_js;
			$new_type = 'Slideshow.Fold';
			$type_ops = "transition: '".$ss_transition."'";
			//$mynewjs = $this->fold_js;
			}
			elseif ($ssShow_type == 'flash'){
			global $flash_js;
			$mynewjs = $flash_js;
			$new_type = 'Slideshow.Flash';
			//$type_ops = "color: ['#999', '#000', '#fff', '#cdcdcd']";
			$type_ops = "color: '".$ss_color."'";
			//$mynewjs = $this->flash_js;
			}
		elseif ($ssShow_type == 'default'){
			$mynewjs = '';
			$new_type = 'Slideshow';
			$type_ops = "transition: '".$ss_transition."'";
			//$mynewjs = $this->default_js;
			}
	
		// if shortcode has set a new show type we need to load the required javascript		
		if ($this->shortcode_showtype == 'true') echo $mynewjs;
			
		// set an href if there is one
		if ( $ss_href != '') { $myhref = 'href: "'.$ss_href.'",';}
		
		//options which could be added to the initshow slideshow
		// onEnd handler to act at end of non looping show
		// to be built in, something like this: function(){ window.location.href = 'http://some.url'; }
		// onStart, onComplete, onEnd
		
		//classes: [ 'Slideshow', 'first', 'prev', 'play', 'pause', 'next', 'last', 'controller', 'thumbnails', 'captions', 'images', 'hidden', 'visible', 'inactive', 'active', 'loader' ]
		//classes: ['', '', '', '', '', '', '', 'alternate-images'],
		//if thumbnails on right verticle - classes: ['', '', '', '', '', '', '', '', '', '', 'alternate-thumbnails'],
		//classes: ['', '', '', '', '', '', '', '', '', 'alternate-controller'],
		//match: /\?slide=(\d+)$/,
		//replace: [/(\.[^\.]+)$/, 't$1'],

		$initshow = "
			this.el = $('slide_gallery".$this->show_id."');
			var ssShow".$this->show_id." = new ".$new_type."(this.el, null,{
						center: ".$ss_center.",
						delay: ".$ss_delay.",
						duration: ".$ss_duration.",
						hu: '',
						linked: ".$ss_linked.",
						resize: ".$ss_resize.",
						overlap: ".$ss_overlap.",
						paused: ".$ss_paused.",
						random: ".$ss_random.",
						loop: ".$ss_loop.",
						slide: ".$ss_first_slide.",
						".$mycaptions."
						".$mycontroller."
						".$myheight."
						".$mywidth."
						".$mythumb."
						".$myhref."
						".$myloader."
						".$type_ops."
						});";
						
				$headoutput = "\n\t"."<script type=\"text/javascript\">\n";
				$headoutput .= "\t"."// <![CDATA[\n";		
				$headoutput .= "window.addEvent('domready', function() {
						".$initshow."
						".$mylightbox."
						".$mymouse."
						".$mythumbcover."
						});\n";
				$headoutput .= "\t"."// ]]></script>\n";
				
				//".$addTooltips." removed from domready untill fix for content is found.
				
		return $headoutput;
		}
		
	function ss_change_options( $attr ){
	
		global $post;	
			
			if ( $attr['show_class'] != '') $this->ssShowOpOut['show_class'] = $attr['show_class'];
			
			if ( $attr['show_type'] != '') $this->shortcode_showtype = 'true';
			if ( $attr['show_type'] != '') $this->ssShowOpOut['show_type'] = $attr['show_type'];
			//if ( $attr['transition'] != '') $this->ssShowOpOut['ss_transition'] = $attr['transition'];
			if ( $attr['mouseover'] != '') $this->ssShowOpOut['ss_mouseover'] = $attr['mouseover'];
			if ( $attr['href'] != '') $this->ssShowOpOut['ss_href'] = $attr['href'];
			
			if ( $attr['image_size'] != '') $this->ssShowOpOut['ss_image_size'] = $attr['image_size']; 
			if ( $attr['height'] != '') $this->ssShowOpOut['ss_height'] = $attr['height'];
			if ( $attr['width'] != '') $this->ssShowOpOut['ss_width'] = $attr['width'];
			if ( $attr['center'] != '') $this->ssShowOpOut['ss_center'] = $attr['center'];
			if ( $attr['first'] != '') $this->ssShowOpOut['ss_first_slide'] = $attr['first'];
			
			if ( $attr['resize'] != '') $this->ssShowOpOut['ss_resize'] = $attr['resize'];
			if ( $attr['linked'] != '') $this->ssShowOpOut['ss_linked'] = $attr['linked'];
			if ( $attr['fast'] != '') $this->ssShowOpOut['ss_fast'] = $attr['fast'];
			if ( $attr['captions'] != '') $this->ssShowOpOut['ss_captions'] = $attr['captions'];
			if ( $attr['overlap'] != '') $this->ssShowOpOut['ss_overlap'] = $attr['overlap'];
			if ( $attr['thumbnails'] != '') $this->ssShowOpOut['ss_thumbnails'] = $attr['thumbnails'];
			
			if ( $attr['paused'] != '') $this->ssShowOpOut['ss_paused'] = $attr['paused'];
			if ( $attr['random'] != '') $this->ssShowOpOut['ss_random'] = $attr['random'];
			if ( $attr['loop'] != '') $this->ssShowOpOut['ss_loop'] = $attr['loop'];
			if ( $attr['loader'] != '') $this->ssShowOpOut['ss_loader'] = $attr['loader'];
			if ( $attr['delay'] != '') $this->ssShowOpOut['ss_delay'] = $attr['delay'];
			if ( $attr['duration'] != '') $this->ssShowOpOut['ss_duration'] = $attr['duration'];
			if ( $attr['controller'] != '') $this->ssShowOpOut['ss_controller'] = $attr['controller'];
			
			//if ( $attr['folder'] != '') $this->ssShowOpOut['ss_hu'] = $attr['folder'];
			
	/*[slideshow href="http://mydomain.com" show_type="kenburns/push/fold/default" show_id ="myshow" transition="" thumbnails="true" image_size="thumbnail/medium/large/full" delay="1000" duration="4000"
	center="true" resize="true" overlap="true" random="true" loop="true" linked="true" fast="true" captions="true" controller="true" paused ="true"]
	*/
	}
		
		/**
		* Write the Slideshow html structure.
		*/	
	function slideshow_shortcode_out ( $attr ) {
				
		global $post;
		
		srand((double)microtime()*1000000); 
		$this->show_id = rand(0,1000); 
		
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}
		extract(shortcode_atts(array(
			'order' => 'ASC',
			'orderby' => 'menu_order ID',
			'id' => $post->ID,
			'show_class' => '',
			'href' => '',
			'first' => '',
			'mouseover' => '',			
			'image_size' => '',
			'type' => '',
			'center' => '', 
			'resize' => '', 
			'linked' => '', 
			'fast' => '', 
			'captions' => '',
			'overlap' => '', 
			'thumbnails' => '', 
			'paused' => '', 
			'random' => '', 
			'loop' => '', 
			'loader' => '', 
			'delay' => '',
			'duration' => '',
			'controller' => '', 
			'folder' => '',  
			'transition' => ''), $attr));
		
		// opdate options if any changes with shortcode
		$this->ss_change_options($attr);
		
		// get options from array for this function
		$t = $this->ssShowOpOut;
		$show_class = $t['show_class'];
		$ss_image_size = $t['ss_image_size'];
		$ss_captions = $t['ss_captions'];
		$ss_thumbnails = $t['ss_thumbnails'];
		$ss_linked = $t['ss_linked'];
		$ss_thumb_height = $t['ss_thumb_height'];
		$ss_thumb_width = $t['ss_thumb_width'];
		$ss_loader = $t['ss_loader'];
		$ss_controller = $t['ss_controller'];
		$ss_lightbox = $t['ss_lightbox'];
		$ss_lightbox_type = $t['ss_lightbox_type'];

	
	
		/*$ttype = $t['ss_trans_type'];
		$ttypeinout = $t['ss_trans_typeinout'];
		if ( $attr['transition'] != '') {
			$ss_transition = $attr['transition'];
			} else {
			$ss_transition = $ttype.':'.$ttypeinout;	
		}
		echo '<p>the ss_transition is '.$ss_transition.' .</p>';*/
		
		$id = intval($id);
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		
		if ( empty($attachments) )
			return '';
	
		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $id => $attachment )
				$output .= wp_get_attachment_link($id, $size = $ss_image_size, true) . "\n";
			return $output;
		}
			
	// Open gallery
		$output = apply_filters('gallery_style', "<div id='slide_gallery".$this->show_id."' class='slideshow ".$show_class."'><div class='slideshow-images show-$post->ID'>");

	// Loop through each gallery item
		foreach ( $attachments as $id => $attachment ) {
	
			$att_page = get_attachment_link($id, $size , true);
			//$a_img = wp_get_attachment_url($id, $size = $ss_image_size);
			$image = wp_get_attachment_image_src($id, $size = $ss_image_size);
			$att_image = wp_get_attachment_image_src($id, $size = 'large');
			
		
		// If using Lightbox, set the link to the img URL
		// Else, set the link to the attachment URL
		// change Lightbox to lightbox
		$ss_lightbox_type = strtolower($ss_lightbox_type);
			if ( $ss_lightbox == on) {
				$linkto = $att_image[0];
				$a_rel = $ss_lightbox_type.":ssShow-$post->ID";
				$a_class = $ss_lightbox_type.' tool';
			}
			else { 
				$linkto = $att_page;
				$a_rel = '';
				$a_class = ' tool';
			}			
			
			
			
		// Do we link the image 
			if ($ss_linked == 'true') {
				$output .= "\n\t"."<a  rel=\"$a_rel\" class=\"$a_class\" href=\"$linkto\" title=\"{$attachment->post_excerpt} :: {$attachment->post_content}\" >"."\n";
			}
		// output the main images
			$output .= "<img id=\"slide-$id\" src=\"$image[0]\" alt=\"{$attachment->post_excerpt}\" width=\"$image[1]\" height=\"$image[2]\" style=\"visibility: hidden; opacity: 0;\" />";		
			
			if ($ss_linked == 'true') {
				$output .= "</a>"."\n";
			}


		} // end foreach	
	
		// Check if user wants to show the caption
			if ( $ss_captions == 'true') {
					$output .= "\n<div class='slideshow-captions'></div>";
			}
		
		// Add loader
			if ( $ss_loader == 'true')	{		
				$output .= '<div class="slideshow-loader"></div>';
			}		
	// CLose the Images div
		$output .= '</div>';		
	
	// Add description
		/* 
		if ( $ss_description == 'true')	{
				$output .= '<div class="tool_description" style="">';
				
				foreach ( $attachments as $id => $attachment ) {							
					$output .= "<span>{$attachment->post_content}</span>";							
					}		
				$output .= '</div >';
		}*/
		
	// Add controller
		if ( $ss_controller == 'true')	{
			$output .= '<div class="slideshow-controller" style="visibility: hidden; opacity: 0;">
					 <ul>
						<li class="first"><a></a></li>
						<li class="prev"><a></a></li>
						<li class="pause play"><a></a></li>
						<li class="next"><a></a></li>
						<li class="last"><a></a></li>
					</ul>
				</div>';
		}
	// Add thumbnails
				//check if the minithumb is there, if not create one, put this into the for each
				//image_resize( $file, $max_w, $max_h, $crop=false, $suffix=null, $dest_path=null, $jpeg_quality=90)
				//image_resize( $id, $ss_thumb_width, $ss_thumb_height, $crop=true, $suffix=null, $dest_path=null, $jpeg_quality=90)
				//$image = minithumb($id, $ss_thumb_height, $ss_thumb_width);				
				//$img = image_resize( $image, $ss_thumb_width, $ss_thumb_height, $crop='true', $jpeg_quality='90');
		if ( $ss_thumbnails == 'true')	{
			$output .= '<div class="slideshow-thumbnails"><ul>';			
			foreach ( $attachments as $id => $attachment ) {
				$image = wp_get_attachment_image_src($id, $size='thumbnail', $icon = false);
				$output .= "<li><a href=\"$link\" title=\"$title\">";
				$output .= "<img id=\"slide-$id\" src=\"$image[0]\" alt=\"$title\" width=\"$image[1]\" height=\"$image[2]\" />";			
				$output .= "</a></li>";
				}			
			$output .= '</ul></div><br style="clear:both;" />';			
		}
	
	// Close slideshow
	$output .= '</div><br style="clear:both;" />';
	
	$output .= $this-> ssShow_set_show($attr);
	return $output;	
	
	}

	/**
	*	Look ahead to check if any posts contain the [gallery / slideshow] shortcode
	*/
	function ssShow_slide_scan () { 
			$this->set_show_paths();
			$this->ssShowOpOut = get_option($this->AdminOptionsName);
			$ss_shortcode = $this->ssShowOpOut['ss_shortcode'];
			
			if ($ss_shortcode == 'gallery'){
				remove_shortcode ( gallery );			// Remove included WordPress [gallery] shortcode function
				add_shortcode ( 'gallery' , array(&$this, 'slideshow_shortcode_out') );	// Add not [gallery] shortcode function
			} else {
				add_shortcode ( 'slideshow' , array(&$this, 'slideshow_shortcode_out') );	// Add not [slideshow] shortcode function
			}
			global $posts; 
			
			if ( !is_array ( $posts ) ) 
					return; 	 
			foreach ( $posts as $post ) { 
					if ( false !== strpos ( $post->post_content, '[gallery' ) ) { 
							
							add_action('wp_head', array(&$this,'ssShow_add_css'));
							add_action('wp_print_scripts', array(&$this,'ssShow_add_javascript')); //this loads the mootools scripts.
							// removed to shortcode function for multiple shows : add_action('wp_head', array(&$this,'ssShow_set_show')); //this writes the show script into head.

							break; 
					} 
					elseif ( false !== strpos ( $post->post_content,'[slideshow' ) ) { 
							
							add_action('wp_head', array(&$this,'ssShow_add_css'));
							add_action('wp_print_scripts', array(&$this,'ssShow_add_javascript')); //this loads the mootools scripts.
							//removed to shortcode function for multiple shows : add_action('wp_head', array(&$this,'ssShow_set_show')); //this writes the show script into head.

							break; 
					}
			} 
	} 
	
	function superslider_show() {
		
		register_activation_hook(__FILE__, array(&$this,'ssShow_init') ); //http://codex.wordpress.org/Function_Reference/register_activation_hook
		register_deactivation_hook( __FILE__, array(&$this,'options_deactivation') ); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
		
		add_action ( 'init', array(&$this,'ssShow_init' ) );
		add_action ( 'admin_menu', array(&$this,'ssShow_setup_optionspage' ) ); // start the backside options page		
		add_action ( 'template_redirect' , array(&$this,'ssShow_slide_scan') );		// Add look ahead for [gallery] shortcode
		
		$ssShow_is_setup = 'true';
	
	}
	// options variable names
	var $kenburns_js = '';
	var $push_js = '';
	var $flash_js = '';
	var $fold_js = '';
	
	var $shortcode_showtype;
	var $ssShowOpOut;	
	var $AdminOptionsName = 'ssShow_options';
	// get a number to make the slideshow unique
	var $show_id;
	

}	//end class
} //End if Class ssShow

/**
*instantiate the class
*/	
if (class_exists('ssShow')) {
	$ssShow = new ssShow();
}
?>