<?php
/*
Copyright 2008 daiv Mowbray

This file is part of superslider

superslider is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

superslider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fancy Categories; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	/**
   * Turn php warnings down/ off.
   */ 	
   error_reporting(E_ALL ^ E_NOTICE);
   
	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', 'superslider' ) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('ssBase_options');
			$ssBase_OldOptions = array(
				"load_moo" => "on",
				"css_load" => "default",
				"css_theme" => "default",
				"reflect" => "on",
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
				"acc_fixedwidth" => "false",
				"acc_height" => "true",
				"acc_width" => "false",
				"acc_opacity" => "true",
				"acc_firstopen" => "0",
				"zoom"      => "on",
				"zoom_auto" => "off",
				"zoom_time" => "1250",
				"zoom_trans_type" => "sine",
				"zoom_trans_typeinout" => "out",
				"zoom_border"   =>  "10px solid silver",
				"zoom_pad"   =>  "10",
				"zoom_back"   =>  "#000",
				"scroll"   =>  "on",
				"scroll_css"   =>  "on",
				"scroll_time"   =>  "1200",
				"scroll_trans"   =>  "sine",
				"scroll_transout"   =>  "out",
				"com"   =>  "on",
				"com_css"   =>  "on",
				"com_time"   =>  "1200",
				"com_trans"   =>  "sine",
				"com_transout"   =>  "out",
				"com_direction"   =>  "virtical",
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
				"ss_global_over_ride" => "on");//end array
			
			update_option($this->AdminOptionsName, $ssBase_OldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Default Options reloaded.', 'superslider' ) . '</strong></p></div>';
			
		}
		elseif ($_POST['action'] == 'update' ) {
			
			check_admin_referer('ssBase_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Options saved.', 'superslider' ) . '</strong></p></div>';
			
			$ssBase_newOptions = array(
				'load_moo'		=> $_POST['op_load_moo'],
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'reflect'		=> $_POST["op_reflect"],
				'reflect_height'=> $_POST["op_reflect_height"],
				'reflect_opacity'=> $_POST["op_reflect_opacity"],
				'auto_reflect'=> $_POST["op_auto_reflect"],				
				'accordion'		=> $_POST["op_accordion"],
				'acc_css'		=> $_POST["op_acc_css"],
				'auto_accordion'		=> $_POST["op_auto_accordion"],
				'acc_container'		=> $_POST["op_acc_container"],
				'acc_toggler'		=> $_POST["op_acc_toggler"],
				'acc_elements'		=> $_POST["op_acc_elements"],
				'acc_togtag'		=> $_POST["op_acc_togtag"],
				'acc_elemtag'		=> $_POST["op_acc_elemtag"],
				'acc_openall'		=> $_POST["op_acc_openall"],
				'acc_fixedheight'		=> $_POST["op_acc_fixedheight"],
				'acc_fixedwidth'		=> $_POST["op_acc_fixedwidth"],
				'acc_height'		=> $_POST["op_acc_height"],
				'acc_width'		=> $_POST["op_acc_width"],
				'acc_opacity'		=> $_POST["op_acc_opacity"],
				'acc_firstopen'		=> $_POST["op_acc_firstopen"],
				'zoom'      		=> $_POST["op_zoom"],
				'zoom_auto'      		=> $_POST["op_zoom_auto"],
				'zoom_time'		=> $_POST["op_zoom_time"],
				'zoom_trans_type'		=> $_POST["op_zoom_trans"],
				'zoom_trans_typeinout'		=> $_POST["op_zoom_transinout"],
				'zoom_border'		=> $_POST["op_zoom_border"],
				'zoom_pad'		=> $_POST["op_zoom_pad"],
				'zoom_back'		=> $_POST["op_zoom_back"],
				'scroll'         => $_POST["op_scroll"],
				'scroll_css'         => $_POST["op_scroll_css"],
				'scroll_time'	=> $_POST["op_scroll_time"],
				'scroll_trans'	=> $_POST["op_scroll_trans"],
				'scroll_transout'	=> $_POST["op_scroll_transout"],
				'com'         => $_POST["op_com"],
				'com_css'         => $_POST["op_com_css"],
				'com_time'	=> $_POST["op_com_time"],
				'com_trans'	=> $_POST["op_com_trans"],
				'com_transout'	=> $_POST["op_com_transout"],
				'com_open'	=> $_POST["op_com_open"],
				'com_close'	=> $_POST["op_com_close"],
				'nudger' => $_POST['op_nudger'],
				'nudge_amount' => $_POST['op_nudge_amount'],
                'nudge_duration' => $_POST['op_nudge_duration'],
                'nudge_family' => $_POST['op_nudge_family'],
                'fader' => $_POST['op_fader'],
                'fader_opacity' => $_POST['op_fader_opacity'],
                'fader_family' => $_POST['op_fader_family'],
                'linker' => $_POST['op_linker'],
                'linker_tag' => $_POST['op_linker_tag'],
                'linker_color' => $_POST['op_linker_color'],
                'clicker' => $_POST['op_clicker'],
                'clicker_tag' => $_POST['op_clicker_tag'],
                'clicker_span' => $_POST['op_clicker_span'],
                'clicker_color' => $_POST['op_clicker_color'],
                //'wrap' => $_POST['op_wrap'],
				'ss_global_over_ride'	=> $_POST["op_global_over_ride"]
			);	

		update_option($this->AdminOptionsName, $ssBase_newOptions);

		}	

		$ssBase_newOptions = get_option($this->AdminOptionsName);   

	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
?>

<div class="wrap">
<form name="ssBase_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<!-- possible auto save options : action="options.php" , bellow, update-options as nonce -->
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssBase_options'); echo "\n"; 
		?>
		
    <div style="">
    <a href="http://wp-superslider.com/">
    <img src="<?php echo $site ?>/wp-content/plugins/superslider/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
      <h2 style="display:inline; position: relative;">SuperSlider Base Options</h2>
     </div><br style="clear:both;" />
 
 
 <script type="text/javascript">
// <![CDATA[
function create_ui_tabs() {


    jQuery(function() {
        var selector = '#ssslider';
            if ( typeof jQuery.prototype.selector === 'undefined' ) {
            // We have jQuery 1.2.x, tabs work better on UL
            selector += ' > ul';
        }
        jQuery( selector ).tabs({ fxFade: true, fxSpeed: 'slow' });

    });
}

jQuery(document).ready(function(){
        create_ui_tabs();
});

	
// ]]>
</script>
 
 
<div id="ssslider" class="ui-tabs">
    <ul id="ssnav" class="ui-tabs-nav">
        <li class="ui-tabs-selected"><a href="#fragment-1"><span>Global Options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-2"><span>Plugins Appearance</span></a></li>
        <li class="ui-state-default"><a href="#fragment-3"><span>File Storage</span></a></li>
        <li class="ui-state-default"><a href="#fragment-4"><span>Image Reflection</span></a></li>
        <li class="ui-state-default"><a href="#fragment-5"><span>Accordion in post</span></a></li>
        <li class="ui-state-default"><a href="#fragment-6"><span>Image Zoom</span></a></li>
        <li class="ui-state-default"><a href="#fragment-7"><span>Page Scroller</span></a></li>
        <li class="ui-state-default"><a href="#fragment-8"><span>Links</span></a></li>
        <li class="ui-state-default"><a href="#fragment-9"><span>Fader </span></a></li>
        <li class="ui-state-default" style="display: none;"><a href="#fragment-10"><span>Comment Slider</span></a></li>
    </ul>
    <div id="fragment-1" class="ui-tabs-panel">
 	<h3 scope="row">Global Options</h3>
		
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- SLideshow options start -->
   <legend><b><?php _e(' Global Over ride',$ssBase_domain); ?>:</b></legend>
    	<label for="op_global_over_ride">
    	<input type="checkbox" name="op_global_over_ride" id="op_global_over_ride"
    	<?php if($ssBase_newOptions['ss_global_over_ride'] == "on") echo $checked; ?> />
    	<?php _e(' Global superslider plugin over ride .',$ssBase_domain); ?></label>
    	 <br /><span class="setting-description"><?php _e(' All SuperSlider plugins will use these Base plugin settings for: Themes,Mootools loading, and css file storage. ',$ssBase_domain); ?></span>
  </fieldset>
 
    </div>
    
	<div id="fragment-2" class="ss-tabs-panel">
	<h3>SuperSlider Plugins Appearance</h3>
		
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  	
		<legend><b><?php _e(' Themes',$ssBase_domain); ?>:</b></legend>

	<table width="100%" cellpadding="10" align="center">
        <tr>
            <td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
            <td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
            <td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
            <td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
        </tr>
        <tr>
            <td><label for="op_css_theme1">
                 <input type="radio"  name="op_css_theme" id="op_css_theme1"
                 <?php if($ssBase_newOptions['css_theme'] == "default") echo $checked; ?> value="default" />
                </label>
            </td>
            <td> <label for="op_css_theme2">
                 <input type="radio"  name="op_css_theme" id="op_css_theme2"
                 <?php if($ssBase_newOptions['css_theme'] == "blue") echo $checked; ?> value="blue" />
                 </label>
            </td>
            <td><label for="op_css_theme3">
                 <input type="radio"  name="op_css_theme" id="op_css_theme3"
                 <?php if($ssBase_newOptions['css_theme'] == "black") echo $checked; ?> value="black" />
                 </label>
            </td>
            <td> <label for="op_css_theme4">
                 <input type="radio"  name="op_css_theme" id="op_css_theme4"
                 <?php if($ssBase_newOptions['css_theme'] == "custom") echo $checked; ?> value="custom" />
                </label>
         </td>
        </tr>
	</table>
    
    </fieldset>
    </div>
		
    <div id="fragment-3" class="ss-tabs-panel">
    <h3>File Storage</h3>
		
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
        <legend><b><?php _e(' Loading Options'); ?>:</b></legend>
        <ul style="list-style-type: none;">
        <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
            <label for="op_load_moo">
            <input type="checkbox" 
            <?php if($ssBase_newOptions['load_moo'] == "on") echo $checked; ?> name="op_load_moo" id="op_load_moo" />
            <?php _e(' Load Mootools 1.2 into your theme header.',$ssBase_domain); ?></label>
            
        </li>
        <li>
            <label for="op_css_load1">
                <input type="radio" name="op_css_load" id="op_css_load1"
                <?php if($ssBase_newOptions['css_load'] == "default") echo $checked; ?> value="default" />
                <?php _e(' Load css from default location. superslider plugin folder.',$ssBase_domain); ?></label><br />
            <label for="op_css_load2">
                <input type="radio" name="op_css_load"  id="op_css_load2"
                <?php if($ssBase_newOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
                <?php _e(' Load css from plugin-data folder, see side note. (Recommended)',$ssBase_domain); ?></label><br />
            <label for="op_css_load3">
                <input type="radio" name="op_css_load"  id="op_css_load3"
                <?php if($ssBase_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
                <?php _e(' Don\'t load css, manually add to your theme css file.',$ssBase_domain); ?></label>
            <br />
            <span class="setting-description"><?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$ssBase_domain); ?></span>
                   
        
        </li>
        </ul>
    </fieldset>
     
		<p><?php _e(' If your theme or any other plugin loads the mootools 1.2 javascript framework into your file header, you can disactivate it here.',$ssBase_domain); ?></p>

		</div>
	<div id="fragment-4" class="ss-tabs-panel">
	<h3>Image Reflection</h3>
		
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	<legend><b><?php _e(' Reflection'); ?>:</b></legend>        
    	<label for="op_reflect">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['reflect'] == "on") echo $checked; ?> name="op_reflect" id="op_reflect" />
    	<?php _e(' Add reflection to your images.',$ssBase_domain); ?></label>
    	
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
                <label for="op_reflect_height">
               <input type="text" class="span-text" name="op_reflect_height" id="op_reflect_height" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['reflect_height']); ?>" />
                <?php _e(' Height of the reflection. (default is 0.33 which means 33%)',$ssBase_domain); ?></label>
                </li>
                <li>
                <label for="op_reflect_opacity">
                <input type="text" class="span-text" name="op_reflect_opacity" id="op_reflect_opacity" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['reflect_opacity']); ?>" />
                <?php _e(' Opacity of the reflection. (default is 0.5 which means 50%)',$ssBase_domain); ?></label>
            </li>
            <li>
                <label for="op_auto_reflect">
                <input type="checkbox" 
                <?php if($ssBase_newOptions['auto_reflect'] == "on") echo $checked; ?> name="op_auto_reflect" id="op_auto_reflect" />
                <?php _e(' Automatically add reflect to all post images.',$ssBase_domain); ?></label>
              <br />
              <span class="setting-description"><?php _e(' If turned off, you can manually add class="reflect" to individual images, or wrap a post or group of images with the reflect shortcode, by clicking on the reflect button in the html view of your post screen..',$ssBase_domain); ?></span>
                
              </li>
            </ul>
	  </fieldset>
        </div>
        
        <div id="fragment-5" class="ss-tabs-panel">
         
            <h3>Accordion in post</h3>
            <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Accordion'); ?>:</b></legend>
            <div style="width: 50%; float:left;">
    	       <label for="op_accordion">
                <input type="checkbox" 
                <?php if($ssBase_newOptions['accordion'] == "on") echo $checked; ?> name="op_accordion" id="op_accordion" />
                <?php _e(' Add the Accordion module.',$ssBase_domain); ?></label>
                <br />
                <label for="op_acc_css">
                <input type="checkbox" 
                <?php if($ssBase_newOptions['acc_css'] == "on") echo $checked; ?> name="op_acc_css" id="op_acc_css" />
                <?php _e(' Add the Accordion css file.',$ssBase_domain); ?></label>
                <ul style="list-style-type: none;margin-top:20px;">
                 <!-- <li>
                      <label for="op_auto_accordion">
                       <input type="checkbox" 
                        <?php if($ssBase_newOptions['auto_accordion'] == "on") echo $checked; ?> name="op_auto_accordion" id="op_auto_accordion" />
                        <?php _e(' Automatic Accordion module.',$ssBase_domain); ?></label>
                  </li>-->
                  <li>
                      <label for="op_acc_container">
                     <input type="text" class="span-text" name="op_acc_container" id="op_acc_container" size="8" maxlength="20"
                     value="<?php echo ($ssBase_newOptions['acc_container']); ?>" />
                     <?php _e(' Accordion container'); ?></label> 
                  <br />
                  <label for="op_acc_toggler">
                 <input type="text" class="span-text" name="op_acc_toggler" id="op_acc_toggler" size="8" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_toggler']); ?>" />
                 <?php _e(' Toggler class'); ?></label> 
                 <br />
                 <label for="op_acc_togtag">
                 <input type="text" class="span-text" name="op_acc_togtag" id="op_acc_togtag" size="8" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_togtag']); ?>" />
                 <?php _e(' Toggler item'); ?></label> 
                  <br />
                  <label for="op_acc_elements">
                 <input type="text" class="span-text" name="op_acc_elements" id="op_acc_elements" size="8" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_elements']); ?>" />
                 <?php _e(' Toggled  class'); ?></label> 
                 <br />
                 <label for="op_acc_elemtag">
                 <input type="text" class="span-text" name="op_acc_elemtag" id="op_acc_elemtag" size="8" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_elemtag']); ?>" />
                 <?php _e(' Toggled item '); ?></label> 
                  </li>
                  
                   <li>
                    <label for="op_acc_openall">
                        <input type="radio" 
                        <?php if($ssBase_newOptions['acc_openall'] == "true") echo $checked; ?> name="op_acc_openall" id="op_acc_openall" value="true" /> 
                        <?php _e(' Open all at start on.',$ssBase_domain); ?>
                        </label>
                    <label for="op_acc_openalloff">
                        <input type="radio" 
                        <?php if($ssBase_newOptions['acc_openall'] == "false") echo $checked; ?>  name="op_acc_openall" id="op_acc_openalloff" value="false" />
                        <?php _e(' off.',$ssBase_domain); ?>
                    </label>
                   </li>
		          </ul>
		       </div>
		    <div style="width: 45%; float:left; padding-top: 50px;">
                  <ul>
                    <li>
                  <label for="op_acc_fixedheight"><?php _e(' Fixed height'); ?>:
                 <input type="text" class="span-text" name="op_acc_fixedheight" id="op_acc_fixedheight" size="4" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_fixedheight']); ?>" /> px.</label> 
                  </li>
                  <li>
                  <label for="op_acc_fixedwidth"><?php _e(' Fixed width'); ?>:
                 <input type="text" class="span-text" name="op_acc_fixedwidth" id="op_acc_fixedwidth" size="4" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_fixedwidth']); ?>" /> px.</label> 
                  </li>
                  <li>
                  <label for="op_acc_opacity"><?php _e(' Transition opacity on'); ?>:
                 <input type="radio" 
                 <?php if($ssBase_newOptions['acc_opacity'] == "true") echo $checked; ?> name="op_acc_opacity" id="op_acc_opacity" value="true" />
                 </label> 
                 <label for="op_acc_opacityoff"><?php _e(' off'); ?>:
                 <input type="radio" 
                 <?php if($ssBase_newOptions['acc_opacity'] == "false") echo $checked; ?> name="op_acc_opacity" id="op_acc_opacityoff" value="false" />
                 </label> 
                  </li>
                    <li>
                  <label for="op_acc_height"><?php _e(' Transition height on'); ?>:
                 <input type="radio" 
                 <?php if($ssBase_newOptions['acc_height'] == "true") echo $checked; ?> name="op_acc_height" id="op_acc_height" value="true" />
                 </label> 
                 <label for="op_acc_heightoff"><?php _e(' off'); ?>:
                 <input type="radio" 
                 <?php if($ssBase_newOptions['acc_height'] == "false") echo $checked; ?> name="op_acc_height" id="op_acc_heightoff" value="false" />
                 </label> 
                  </li>
                    <li>
                  <label for="op_acc_width"><?php _e(' Transition width on'); ?>:
                 <input type="radio" 
                 <?php if($ssBase_newOptions['acc_width'] == "true") echo $checked; ?> name="op_acc_width" id="op_acc_width" value="true" />
                 </label> 
                 <label for="op_acc_widthoff"><?php _e(' off'); ?>:
                 <input type="radio" 
                 <?php if($ssBase_newOptions['acc_width'] == "false") echo $checked; ?> name="op_acc_width" id="op_acc_widthoff" value="false" /></label> 
                  </li>
                     <li>
                  <label for="op_acc_firstopen"><?php _e(' Open at first'); ?>:
                 <input type="text" class="span-text" name="op_acc_firstopen" id="op_acc_firstopen" size="4" maxlength="20"
                 value="<?php echo ($ssBase_newOptions['acc_firstopen']); ?>" /></label>
                 <br />
                 <span class="setting-description"><?php _e(' Which toggle item should be opened at first view? Ordering starts at "0", -1 will leave all closed.',$ssBase_domain); ?></span>
                
                  </li>
                </ul>
               
            </div><br style="clear:both;" />
             </fieldset>
             
             <br />
                 <span class="setting-description"><?php _e(' To use the accordion, click on the add accordion button found in the SuperSlider-Accordion meta box on your post screen (this works best in code view). This will insert the accordion structure. Edit the toggle bar titles, ie: toggle one, toggle two , then insert your content into content one and content two etc. to add more toggle bars and content just copy and paste the h3 followed by the div tags.',$ssBase_domain); ?></span>
                
	   </div>
	   
	   
    <div id="fragment-6" class="ss-tabs-panel">
        <h3>Image Zoom</h3>
    	<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Zoom'); ?>:</b></legend>
    	<label for="op_zoom">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['zoom'] == "on") echo $checked; ?> name="op_zoom" id="op_zoom" />
    	<?php _e(' Add zoom to your images.',$ssBase_domain); ?></label>
    	<label for="op_zoom_auto">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['zoom_auto'] == "on") echo $checked; ?> name="op_zoom_auto" id="op_zoom_auto" />
    	<?php _e(' Auto zoom your images.',$ssBase_domain); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
               <label for="op_zoom_trans"><?php _e(' Transition type',$ssBase_domain); ?>:   </label>  
             <select name="op_zoom_trans" id="op_zoom_trans">
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "back") echo $selected; ?> id="back" value='back'> back</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_type'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
                </select>&nbsp;
            <label for="op_zoom_transinout"><?php _e(' Transition action.',$ssBase_domain); ?></label>
            <select name="op_zoom_transinout" id="op_zoom_transinout">
                 <option <?php if($ssBase_newOptions['zoom_trans_typeinout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_typeinout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
                 <option <?php if($ssBase_newOptions['zoom_trans_typeinout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
            </select>&nbsp;&nbsp;
                <label for="op_zoom_time"><?php _e(' zoom time',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_zoom_time" id="op_zoom_time" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['zoom_time']); ?>" /></label>
                <br />
            <span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$ssBase_domain); ?></span>

             </li>
             <li>
                <label for="op_zoom_border"><?php _e('Image border -',$ssBase_domain); ?>
                <input type="text" class="span-text" name="op_zoom_border" id="op_zoom_border" size="12" maxlength="50"
			 value="<?php echo ($ssBase_newOptions['zoom_border']); ?>" />
                </label>,&nbsp;

                <label for="op_zoom_pad"><?php _e(' padding -',$ssBase_domain); ?>
                <input type="text" class="span-text" name="op_zoom_pad" id="op_zoom_pad" size="2" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['zoom_pad']); ?>" />
                </label>

                <label for="op_zoom_back"><?php _e('px, background color -',$ssBase_domain); ?>
                <input type="text" class="span-text" name="op_zoom_back" id="op_zoom_back" size="8" maxlength="20"
			 value="<?php echo ($ssBase_newOptions['zoom_back']); ?>" />
                </label>
            </li>
            <span class="setting-description"><?php _e(' If You deactivate the auto zoom, you can add a zoom to your image by including class="zoom" to the a href tag surrounding your image. Or use the zoom button to add shortcode around a group of images. Colors can be named or hex values, ie: silver, transparent or #afafaf. And border style can be any of the following: solid, dotted, dashed, double, groove, ridge, inset, outset.',$ssBase_domain); ?></span>

 
         </ul>
	   </fieldset>
	   </div>
	   <div id="fragment-7" class="ss-tabs-panel">
        <h3>Page Scroller</h3>
        <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Scroller'); ?>:</b></legend>
    	<label for="op_scroll">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['scroll'] == "on") echo $checked; ?> name="op_scroll" id="op_scroll" />
    	<?php _e(' Add scroller to your page.',$ssBase_domain); ?></label>
    	<label for="op_scroll_css">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['scroll_css'] == "on") echo $checked; ?> name="op_scroll_css" id="op_scroll_css" />
    	<?php _e(' Add scroll Css file.',$ssBase_domain); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
               <label for="op_scroll_trans"><?php _e(' Transition type',$ssBase_domain); ?>:   </label>  
             <select name="op_scroll_trans" id="op_scroll_trans">
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "back") echo $selected; ?> id="back" value='back'> back</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
                 <option <?php if($ssBase_newOptions['scroll_trans'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
                </select>&nbsp;
            <label for="op_scroll_transout"><?php _e(' Transition action.',$ssBase_domain); ?></label>
            <select name="op_scroll_transout" id="op_scroll_transout">
                 <option <?php if($ssBase_newOptions['scroll_transout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
                 <option <?php if($ssBase_newOptions['scroll_transout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
                 <option <?php if($ssBase_newOptions['scroll_transout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
            </select>&nbsp;&nbsp;
                <label for="op_scroll_time"><?php _e(' Scroll time',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_scroll_time" id="op_scroll_time" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['scroll_time']); ?>" /></label>
                <br />
            <span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$ssBase_domain); ?></span>
            <br />
            <span class="setting-description"><?php _e(' Use the quick tag button in html/code view to insert a scroll structure to your page or post. Edit the content of the structure to your needs. Add more items by copy and paste. Content object divs must be number sequencially, ie: div id="scroll3"... div id="scroll4"...  This works for single posts and pages, but not for multiple posts per page.',$ssBase_domain); ?></span>


             </li>
 
         </ul>
	   </fieldset>
	   </div>
	   <div id="fragment-8" class="ss-tabs-panel">
	    <h3>Link Nudger</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Nudger'); ?>:</b></legend>
        
    	<label for="op_nudger">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['nudger'] == "on") echo $checked; ?> name="op_nudger" id="op_nudger" />
    	<?php _e(' Add link nudger to your page.',$ssBase_domain); ?></label>
    	<label for="op_nudger_css">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['nudger_css'] == "on") echo $checked; ?> name="op_nudger_css" id="op_nudger_css" />
    	<?php _e(' Add nudger Css file.',$ssBase_domain); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
              <!--<label for="op_nudger_trans"><?php _e(' Transition type',$ssBase_domain); ?>:   </label>  
             <select name="op_nudger_trans" id="op_nudger_trans">
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "back") echo $selected; ?> id="back" value='back'> back</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
                 <option <?php if($ssBase_newOptions['nudger_trans'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
                </select>&nbsp;
            <label for="op_nudger_transout"><?php _e(' Transition action.',$ssBase_domain); ?></label>
            <select name="op_nudger_transout" id="op_nudger_transout">
                 <option <?php if($ssBase_newOptions['nudger_transout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
                 <option <?php if($ssBase_newOptions['nudger_transout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
                 <option <?php if($ssBase_newOptions['nudger_transout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
            </select>-->
                <label for="op_nudger_time"><?php _e(' nudger time',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_nudge_duration" id="op_nudge_duration" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['nudge_duration']); ?>" /></label>
			 <label for="op_nudge_amount"><?php _e(' nudger distance',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_nudge_amount" id="op_nudge_amount" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['nudge_amount']); ?>" /></label>
			 <label for="op_nudge_family"><?php _e(' nudger families',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_nudge_family" id="op_nudge_family" size="60" maxlength="200"
			 value="<?php echo ($ssBase_newOptions['nudge_family']); ?>" /></label>
            </li>
         </ul>
	   </fieldset>
	   	   
	   	   <h3>Linker</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Linker'); ?>:</b></legend>
        
    	<label for="op_linker">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['linker'] == "on") echo $checked; ?> name="op_linker" id="op_linker" />
    	<?php _e(' Add linker to your hyperlinks. Dynamically adds a subtle darkened background effect when you click a link.',$ssBase_domain); ?></label>

            <ul style="list-style-type: none;margin-top:20px;">
               <li>
			 <label for="op_linker_color"><?php _e(' linker color',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_linker_color" id="op_linker_color" size="18" maxlength="60"
			 value="<?php echo ($ssBase_newOptions['linker_color']); ?>" /></label>
			 
			 </li>
            <li>
			 <label for="op_linker_tag"><?php _e(' Linker tags',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_linker_tag" id="op_linker_tag" size="18" maxlength="60"
			 value="<?php echo ($ssBase_newOptions['linker_tag']); ?>" />
			 <?php _e(' The tags you want to apply the Linker effect to. eg: #sidebar a',$ssBase_domain); ?></label>
			 
			 </li>
         </ul>
	   </fieldset>
	   
	   	   <h3>Clicker</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Clicker'); ?>:</b></legend>
        
    	<label for="op_clicker">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['clicker'] == "on") echo $checked; ?> name="op_clicker" id="op_clicker" />
    	<?php _e('Add clicker to your pages. Dynamically takes the first link from the contents of a list item and makes the whole list item a clickable link.',$ssBase_domain); ?></label>

            <ul style="list-style-type: none;margin-top:20px;">
               
            <li>
			 <label for="op_clicker_tag"><?php _e(' clicker tags',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_clicker_tag" id="op_clicker_tag" size="18" maxlength="60"
			 value="<?php echo ($ssBase_newOptions['clicker_tag']); ?>" />
			 <?php _e(' The tags you want to apply the clicker effect to. (default = .clickable li) *Tip - in this case you would need to add class="clickable" to the unordered list. Or you could set this to .entry li to apply clickable to all list items in the entry.',$ssBase_domain); ?></label>
			 
			 </li>
			 <li>
			 <label for="op_clicker_color"><?php _e(' clicker color',$ssBase_domain); ?>
               <input type="text" class="color-text" name="op_clicker_color" id="op_clicker_color" size="18" maxlength="60"
			 value="<?php echo ($ssBase_newOptions['clicker_color']); ?>" />
			 <?php _e('What color should the clicker hover background be? (default = #c9e0f4) eg. silver, teal, or blue',$ssBase_domain); ?></label>
			 
			 </li>
			 <li>
			 <label for="op_clicker_span"><?php _e(' clicker span',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_clicker_span" id="op_clicker_span" size="18" maxlength="60"
			 value="<?php echo ($ssBase_newOptions['clicker_span']); ?>" />
			 <?php _e('To remove the a link tag from the linked text add true, or to leave the link also active add false.',$ssBase_domain); ?></label>
			 
			 </li>
         </ul>
	   </fieldset>
	   
	   </div>
	   <div id="fragment-9" class="ss-tabs-panel">
	    <h3>Fader</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Fader'); ?>:</b></legend>
        
    	<label for="op_fader">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['fader'] == "on") echo $checked; ?> name="op_fader" id="op_fader" />
    	<?php _e(' Add object fader to your page.',$ssBase_domain); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
                <label for="op_fader_opacity"><?php _e(' Fader opacity',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_fader_opacity" id="op_fader_opacity" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['fader_opacity']); ?>" /></label>
			 <label for="op_fader_family"><?php _e(' Fader families',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_fader_family" id="op_fader_family" size="18" maxlength="60"
			 value="<?php echo ($ssBase_newOptions['fader_family']); ?>" /></label>
			 <br />
			 <span class="setting-description"><?php _e('Add a Fade transition to one object of a group on mouseover. Draws attention to that object.<br /> To use, add class="fader" to an unordered list, or any object with child objects. Then fade will be applied to all the list/child items.',$ssBase_domain); ?></span>
            </li>
         </ul>
	   </fieldset>
	   
	 <!--  <h3>Widow wrapper</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Wrap'); ?>:</b></legend>
        
    	<label for="op_wrap">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['wrap'] == "on") echo $checked; ?> name="op_wrap" id="op_wrap" />
    	<?php _e(' Prevent widowed text, (single words on a new line).',$ssBase_domain); ?></label>
          
	   </fieldset>-->

	   </div>
	   
	   <div id="fragment-10" class="ss-tabs-panel" style="display: none;">
        <h3>Comment Slider</h3>
    	<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e(' Nudger'); ?>:</b></legend>
    	<label for="op_com">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['com'] == "on") echo $checked; ?> name="op_com" id="op_com" />
    	<?php _e(' Add Commmet Slider to your page.',$ssBase_domain); ?></label>
    	<label for="op_com_css">
    	<input type="checkbox" 
    	<?php if($ssBase_newOptions['com_css'] == "on") echo $checked; ?> name="op_com_css" id="op_com_css" />
    	<?php _e(' Add Com Slider Css file.',$ssBase_domain); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
               <label for="op_com_trans"><?php _e(' Transition type',$ssBase_domain); ?>:   </label>  
             <select name="op_com_trans" id="op_com_trans">
                 <option <?php if($ssBase_newOptions['com_trans'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "back") echo $selected; ?> id="back" value='back'> back</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
                 <option <?php if($ssBase_newOptions['com_trans'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
                </select>&nbsp;
            <label for="op_com_transout"><?php _e(' Transition action.',$ssBase_domain); ?></label>
            <select name="op_com_transout" id="op_com_transout">
                 <option <?php if($ssBase_newOptions['com_transout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
                 <option <?php if($ssBase_newOptions['com_transout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
                 <option <?php if($ssBase_newOptions['com_transout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
            </select>&nbsp;&nbsp;
                <label for="op_com_time"><?php _e(' com time',$ssBase_domain); ?>
               <input type="text" class="span-text" name="op_com_time" id="op_com_time" size="3" maxlength="6"
			 value="<?php echo ($ssBase_newOptions['com_time']); ?>" /></label>
                <br />
            <span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$ssBase_domain); ?></span>

             </li>
             <li>
                <label for="op_com_open">
               <input type="text" class="span-text" name="op_com_open" id="op_com_open" size="20" maxlength="100"
			 value="<?php echo ($ssBase_newOptions['com_open']); ?>" />
                <?php _e(' open link text',$ssBase_domain); ?></label>
             </li>
             <li>
                <label for="op_com_close">
               <input type="text" class="span-text" name="op_com_close" id="op_com_close" size="20" maxlength="100"
			 value="<?php echo ($ssBase_newOptions['com_close']); ?>" />
                <?php _e(' close link text',$ssBase_domain); ?></label>
             </li>
 
         </ul>
	   </fieldset>
	   </div>
</div>	   
    <p class="submit">
		<input type="submit" name="set_defaults" value="<?php _e(' Reload Default Options',$ssBase_domain); ?> &raquo;" />
		<input type="submit" id="update2" class="button-primary" value="<?php _e(' Update options',$ssBase_domain); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
</div>
<?php
	echo "";
?>