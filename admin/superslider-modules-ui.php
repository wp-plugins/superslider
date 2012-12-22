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
   
	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', 'superslider' ) );
		}
		
        $ssMod_Options = get_option('ssMod_options');

		if (isset($_POST['set_defaults']))  {
			check_admin_referer('ssBase_module_options');
			$ssBase_OldOptions = array(
				"reflect" => "on",
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
				"acc_fixedwidth" => "",
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
				"scroll_auto"      =>  "on",
				"totop_text"      =>  "To Top",
				
				"scroll_css"   =>  "on",
				"scroll_time"   =>  "1200",
				"scroll_trans"   =>  "sine",
				"scroll_transout"   =>  "out",
				
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
				
				"modal"   =>  "off",
				"modal_css"   =>  "on",
				"modal_link" => "mmlink",
				"modal_width" => "220px",
				"modal_height" => "120px",
				"modal_box" => "mmbox",
				"modal_title"   =>  "myBox",
				"modal_overlay" => 'true',
        		"modal_overlay_color" => '#fff',
        		"modal_transition" => 'bouncefly',
        		"modal_buttons" => 'true',
        		"modal_button_text1" => 'Cancel',
        		"modal_button_text2" => 'OK',

				"moodropmenu" => 'off',
				"moomenu" => 'menu-main',
				
				"com_trans"   =>  "sine",
				"com_transout"   =>  "out",
				"com_direction"   =>  "virtical",
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
                );//end array
			
			update_option('ssMod_options', $ssBase_OldOptions);

			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Default Options reloaded.', 'superslider' ) . '</strong></p></div>';


		}
		elseif (isset($_POST['action']) && $_POST['action'] == 'update' ) {
			
			check_admin_referer('ssBase_module_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Module Options saved.', 'superslider' ) . '</strong></p></div>';
			
			
			$ssMod_newOptions = array(				
				'reflect' => isset($_POST['op_reflect']) ? $_POST["op_reflect"] : "",
				
				'reflect_height'=> $_POST["op_reflect_height"],
				'reflect_opacity'=> $_POST["op_reflect_opacity"],
				'auto_reflect' => isset($_POST['op_auto_reflect']) ? $_POST["op_auto_reflect"] : "",
				'accordion' => isset($_POST['op_accordion']) ? $_POST["op_accordion"] : "",
				'acc_mode' => isset($_POST['op_acc_mode']) ? $_POST["op_acc_mode"] : "",
				'acc_css' => isset($_POST['op_acc_css']) ? $_POST["op_acc_css"] : "",
				'auto_accordion' => isset($_POST['op_auto_accordion']) ? $_POST["op_auto_accordion"] : "",
				'acc_container'		=> $_POST["op_acc_container"],
				'acc_toggler'		=> $_POST["op_acc_toggler"],
				'acc_elements'		=> $_POST["op_acc_elements"],
				'acc_togtag'		=> $_POST["op_acc_togtag"],
				'acc_elemtag'		=> $_POST["op_acc_elemtag"],
				'acc_openall'		=> $_POST["op_acc_openall"],
				'acc_fixedheight'	=> $_POST["op_acc_fixedheight"],
				'acc_fixedwidth'	=> $_POST["op_acc_fixedwidth"],
				'acc_height'		=> $_POST["op_acc_height"],
				'acc_width'			=> $_POST["op_acc_width"],
				'acc_opacity'		=> $_POST["op_acc_opacity"],
				'acc_firstopen'		=> $_POST["op_acc_firstopen"],
				'zoom' => isset($_POST['op_zoom']) ? $_POST["op_zoom"] : "",
				'zoom_auto' => isset($_POST['op_zoom_auto']) ? $_POST["op_zoom_auto"] : "",
				
				'zoom_time'			=> $_POST["op_zoom_time"],
				'zoom_trans_type'		=> $_POST["op_zoom_trans"],
				'zoom_trans_typeinout'	=> $_POST["op_zoom_transinout"],
				'zoom_border'	=> $_POST["op_zoom_border"],
				'zoom_pad'		=> $_POST["op_zoom_pad"],
				'zoom_back'		=> $_POST["op_zoom_back"],
				'scroll' => isset($_POST['op_scroll']) ? $_POST["op_scroll"] : "",
				'scroll_auto' => isset($_POST['op_scroll_auto']) ? $_POST["op_scroll_auto"] : "",
				'totop_text'    => $_POST["op_totop_text"],
				'scroll_css' => isset($_POST['op_scroll_css']) ? $_POST["op_scroll_css"] : "",
				'scroll_time'	=> $_POST["op_scroll_time"],
				'scroll_trans'	=> $_POST["op_scroll_trans"],
				'scroll_transout'	=> $_POST["op_scroll_transout"],
				
				'tooltips'          => $_POST["op_tooltips"],
				'tt_showDelay'      => $_POST["op_tt_showDelay"],
				'tt_hideDelay'      => $_POST["op_tt_hideDelay"],
				'tt_offsetx'        => $_POST["op_tt_offsetx"],
				'tt_offsety'        => $_POST["op_tt_offsety"],
				'tt_fixed'          => $_POST["op_tt_fixed"],
				'tt_tip_opacity'    => $_POST["op_tt_tip_opacity"],
				'toolClass'			=> $_POST["op_toolClass"],
				'tipTitle'			=> $_POST["op_tipTitle"],
				'tipText'			=> $_POST["op_tipText"],
			
				'modal' => isset($_POST['op_modal']) ? $_POST["op_modal"] : "",
				'modal_css' => isset($_POST['op_modal_css']) ? $_POST["op_modal_css"] : "",
				"modal_link" 	=> $_POST["op_modal_link"],
				"modal_width"	=> $_POST["op_modal_width"],
				"modal_height" 	=> $_POST["op_modal_height"],
				"modal_box" 	=> $_POST["op_modal_box"],	
				'modal_title'	=> $_POST["op_modal_title"],
				'modal_overlay'	=> $_POST["op_modal_overlay"],
				'modal_overlay_color'	=> $_POST["op_modal_overlay_color"],
				'modal_transition'		=> $_POST["op_modal_transition"],
				'modal_buttons'			=> $_POST["op_modal_buttons"],
				'modal_button_text1'	=> $_POST["op_modal_button_text1"],
				'modal_button_text2'	=> $_POST["op_modal_button_text2"],
				
				'moodropmenu' => isset($_POST['op_moodropmenu']) ? $_POST["op_moodropmenu"] : "",
				'moomenu'	=> $_POST["op_moomenu"],
				
				
				//'com_trans'	=> $_POST["op_com_trans"],
				//'com_transout'	=> $_POST["op_com_transout"],
				'com_open'	=> $_POST["op_com_open"],
				'com_close'	=> $_POST["op_com_close"],
				'nudger' => isset($_POST['op_nudger']) ? $_POST["op_nudger"] : "",
				'nudge_amount' => $_POST['op_nudge_amount'],
                'nudge_duration' => $_POST['op_nudge_duration'],
                'nudge_family' => $_POST['op_nudge_family'],
                'fader' => isset($_POST['op_fader']) ? $_POST["op_fader"] : "",
                'fader_opacity' => $_POST['op_fader_opacity'],
                'fader_family' => $_POST['op_fader_family'],
                'linker' => isset($_POST['op_linker']) ? $_POST["op_linker"] : "",
                'linker_tag' => $_POST['op_linker_tag'],
                'linker_color' => $_POST['op_linker_color'],
                'clicker' => isset($_POST['op_clicker']) ? $_POST["op_clicker"] : "",
                'clicker_tag' => $_POST['op_clicker_tag'],
                'clicker_span' => $_POST['op_clicker_span'],
                'clicker_color' => $_POST['op_clicker_color']
			);	

		update_option('ssMod_options', $ssMod_newOptions);
// from here		
		}elseif (isset($_POST['proaction']) && $_POST['proaction'] == 'updatepro' ) {
			
			check_admin_referer('ssPro_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Pro Options saved.', 'superslider' ) . '</strong></p></div>';
			
			
			$ssPro_newOptions = array(				
				'pro_code' => isset($_POST['op_pro_code']) ? $_POST["op_pro_code"] : ""
				);
			update_option('ssPro_options', $ssPro_newOptions);
	
		}

	$ssPro_newOptions = get_option('ssPro_options'); 
	$ispro = '';
	if($ssPro_newOptions['pro_code'] == "We are all beautiful creative people")$ispro = true;

//to here	

    $ssMod_newOptions = get_option('ssMod_options');   
	
	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
	$plugin_name = 'superslider';
	
	
?>

<div class="wrap">
 <div class="ss_column1">
 
<form name="ssBase_module_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
<!-- possible auto save options : action="options.php" , bellow, update-options as nonce -->
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssBase_module_options'); echo "\n"; 
		?>
		
    <div style="">
    <a href="http://superslider.daivmowbray.com/">
    <img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-menu/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
      <h2 style="display:inline; position: relative;"><?php _e('SuperSlider Module Options', $plugin_name); ?></h2>
     </div><br style="clear:both;" />
 
 
 <script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function ($) {

	$(function() {
        $( "#ssslider" ).tabs();
    });
});	
// ]]>
</script>
 

<div id="ssslider" class="ui-tabs">
    <ul id="ssnav" class="ui-tabs-nav">

        <li class="ui-state-default"><a href="#fragment-1"><span><?php _e('Image Reflection', $plugin_name); ?></span></a></li>
        <li class="ui-state-default"><a href="#fragment-2"><span><?php _e('Accordion', $plugin_name); ?></span></a></li>
        <li class="ui-state-default"><a href="#fragment-3"><span><?php _e('Image Zoom', $plugin_name); ?></span></a></li>
        <li class="ui-state-default"><a href="#fragment-4"><span><?php _e('Page Scroller', $plugin_name); ?></span></a></li>
        <li class="ui-state-default"><a href="#fragment-5"><span><?php _e('Links', $plugin_name); ?></span></a></li>
        <li class="ui-state-default"><a href="#fragment-6"><span><?php _e('Fader', $plugin_name); ?> </span></a></li>
        <li class="ui-state-default"><a href="#fragment-7"><span><?php _e('ToolTips', $plugin_name); ?> </span></a></li>
        <li class="ui-state-default"><a href="#fragment-8"><span><?php _e('Modal Box', $plugin_name); ?></span></a></li>
        <li class="ui-state-default"><a href="#fragment-9"><span><?php _e('Moo Menu', $plugin_name); ?></span></a></li>
    </ul>
    
	<div id="fragment-1" class="ss-tabs-panel">
	<h3>Image Reflection</h3>
		
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	<legend><b><?php _e('Reflection', $plugin_name); ?>:</b></legend>        
    	    <ul style="list-style-type: none;margin-top:20px;">
            <li>
				<label for="op_reflect">
				<input type="checkbox" 
				<?php if($ssMod_newOptions['reflect'] == "on") echo $checked; ?> name="op_reflect" id="op_reflect" />
				<?php _e('Add reflection to your images.',$plugin_name); ?></label>
				</li>
			<li>
                <label for="op_reflect_height">
               <input type="text" class="span-text" name="op_reflect_height" id="op_reflect_height" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['reflect_height']); ?>" />
                <?php _e('Height of the reflection. (default is 0.33 which means 33%)',$plugin_name); ?></label>
                </li>
            <li>
                <label for="op_reflect_opacity">
                <input type="text" class="span-text" name="op_reflect_opacity" id="op_reflect_opacity" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['reflect_opacity']); ?>" />
                <?php _e('Opacity of the reflection. (default is 0.5 which means 50%)',$plugin_name); ?></label>
            	</li>
            <li>
                <label for="op_auto_reflect">
                <input type="checkbox" 
                <?php if($ssMod_newOptions['auto_reflect'] == "on") echo $checked; ?> name="op_auto_reflect" id="op_auto_reflect" />
                <?php _e('Automatically add reflect to all post images.',$plugin_name); ?></label>
            	</li>
    		<li>
              <p class="setting-description"><?php _e('If turned off, you can manually add class="reflect" to individual images, or wrap a post or group of images with the reflect shortcode, by clicking on the reflect button in the html view of your post screen.
              If the image does not align with the reflection you should add the css declaration: .reflected { margin:0px!important;} to your theme css file.',$plugin_name); ?></p>
              </li>
            </ul>
	  </fieldset>
        </div>
        
        <div id="fragment-2" class="ss-tabs-panel">
         
            <h3><?php _e('Accordion in post', $plugin_name); ?></h3>
            <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Accordion', $plugin_name); ?>:</b></legend>
            <div style="width: 50%; float:left;">
    	       
    	       
    	       <ul>
    	       	<li>
    	       
    	       <label for="op_accordion">
                <input type="checkbox" 
                <?php if($ssMod_newOptions['accordion'] == "on") echo $checked; ?> name="op_accordion" id="op_accordion" />
                <?php _e('Add the Accordion module.',$plugin_name); ?></label>
                </li>
    	       <li>
                <label for="op_acc_mode">
                <input type="checkbox" 
                <?php if($ssMod_newOptions['acc_mode'] == "on") echo $checked; ?> name="op_acc_mode" id="op_acc_mode" />
                <?php _e('Set the accordion to single open mode.',$plugin_name); ?></label>
               </li>
    	       <li>
                <label for="op_acc_css">
                <input type="checkbox" 
                <?php if($ssMod_newOptions['acc_css'] == "on") echo $checked; ?> name="op_acc_css" id="op_acc_css" />
                <?php _e('Add the Accordion css file.',$plugin_name); ?></label>
                
                </li>
    	       </ul>
    	       
                <ul style="list-style-type: none;margin-top:30px;">
                 <!-- <li>
                      <label for="op_auto_accordion">
                       <input type="checkbox" 
                        <?php if($ssMod_newOptions['auto_accordion'] == "on") echo $checked; ?> name="op_auto_accordion" id="op_auto_accordion" />
                        <?php _e('Automatic Accordion module.',$plugin_name); ?></label>
                  </li>-->
                  <li>
                      <label for="op_acc_container">
                     <input type="text" class="span-text" name="op_acc_container" id="op_acc_container" size="8" maxlength="20"
                     value="<?php echo ($ssMod_newOptions['acc_container']); ?>" />
                     <?php _e('Accordion container', $plugin_name); ?></label> 
                  <br />
                  <label for="op_acc_toggler">
                 <input type="text" class="span-text" name="op_acc_toggler" id="op_acc_toggler" size="8" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_toggler']); ?>" />
                 <?php _e('Toggler class', $plugin_name); ?></label> 
                 <br />
                 <label for="op_acc_togtag">
                 <input type="text" class="span-text" name="op_acc_togtag" id="op_acc_togtag" size="8" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_togtag']); ?>" />
                 <?php _e('Toggler item', $plugin_name); ?></label> 
                  <br />
                  <label for="op_acc_elements">
                 <input type="text" class="span-text" name="op_acc_elements" id="op_acc_elements" size="8" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_elements']); ?>" />
                 <?php _e('Toggled  class', $plugin_name); ?></label> 
                 <br />
                 <label for="op_acc_elemtag">
                 <input type="text" class="span-text" name="op_acc_elemtag" id="op_acc_elemtag" size="8" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_elemtag']); ?>" />
                 <?php _e('Toggled item ', $plugin_name); ?></label> 
                  </li>
                  
                   <li>
                    <label for="op_acc_openall">
                        <input type="radio" 
                        <?php if($ssMod_newOptions['acc_openall'] == "true") echo $checked; ?> name="op_acc_openall" id="op_acc_openall" value="true" /> 
                        <?php _e('Open all at start on.',$plugin_name); ?>
                        </label>
                    <label for="op_acc_openalloff">
                        <input type="radio" 
                        <?php if($ssMod_newOptions['acc_openall'] == "false") echo $checked; ?>  name="op_acc_openall" id="op_acc_openalloff" value="false" />
                        <?php _e('off.',$plugin_name); ?>
                    </label>
                   </li>
		          </ul>
		       </div>
		    <div style="width: 45%; float:left; padding-top: 70px;">
                  <ul>
                    <li>
                  <label for="op_acc_fixedheight"><?php _e('Fixed height', $plugin_name); ?>:
                 <input type="text" class="span-text" name="op_acc_fixedheight" id="op_acc_fixedheight" size="4" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_fixedheight']); ?>" /> px.</label> 
                  </li>
                  <li>
                  <label for="op_acc_fixedwidth"><?php _e('Fixed width', $plugin_name); ?>:
                 <input type="text" class="span-text" name="op_acc_fixedwidth" id="op_acc_fixedwidth" size="4" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_fixedwidth']); ?>" /> px.</label> 
                  </li>
                  <li>
                  <label for="op_acc_opacity"><?php _e('Transition opacity on', $plugin_name); ?>:
                 <input type="radio" 
                 <?php if($ssMod_newOptions['acc_opacity'] == "true") echo $checked; ?> name="op_acc_opacity" id="op_acc_opacity" value="true" />
                 </label> 
                 <label for="op_acc_opacityoff"><?php _e('off', $plugin_name); ?>:
                 <input type="radio" 
                 <?php if($ssMod_newOptions['acc_opacity'] == "false") echo $checked; ?> name="op_acc_opacity" id="op_acc_opacityoff" value="false" />
                 </label> 
                  </li>
                    <li>
                  <label for="op_acc_height"><?php _e('Transition height on', $plugin_name); ?>:
                 <input type="radio" 
                 <?php if($ssMod_newOptions['acc_height'] == "true") echo $checked; ?> name="op_acc_height" id="op_acc_height" value="true" />
                 </label> 
                 <label for="op_acc_heightoff"><?php _e('off', $plugin_name); ?>:
                 <input type="radio" 
                 <?php if($ssMod_newOptions['acc_height'] == "false") echo $checked; ?> name="op_acc_height" id="op_acc_heightoff" value="false" />
                 </label> 
                  </li>
                    <li>
                  <label for="op_acc_width"><?php _e('Transition width on', $plugin_name); ?>:
                 <input type="radio" 
                 <?php if($ssMod_newOptions['acc_width'] == "true") echo $checked; ?> name="op_acc_width" id="op_acc_width" value="true" />
                 </label> 
                 <label for="op_acc_widthoff"><?php _e('off', $plugin_name); ?>:
                 <input type="radio" 
                 <?php if($ssMod_newOptions['acc_width'] == "false") echo $checked; ?> name="op_acc_width" id="op_acc_widthoff" value="false" /></label> 
                  </li>
                     <li>
                  <label for="op_acc_firstopen"><?php _e('Open at first', $plugin_name); ?>:
                 <input type="text" class="span-text" name="op_acc_firstopen" id="op_acc_firstopen" size="4" maxlength="20"
                 value="<?php echo ($ssMod_newOptions['acc_firstopen']); ?>" /></label>
                 <br />
                 <span class="setting-description"><?php _e('Which toggle item should be opened at first view? Ordering starts at "0", -1 will leave all closed.',$plugin_name); ?></span>
                
                  </li>
                </ul>
               
            </div><br style="clear:both;" />
             </fieldset>
             
             <br />
                 <span class="setting-description"><?php _e('To use the accordion, click on the add accordion button found in the SuperSlider-Accordion meta box on your post screen (this works best in code view). This will insert the accordion structure. Edit the toggle bar titles, ie: toggle one, toggle two , then insert your content into content one and content two etc. to add more toggle bars and content just copy and paste the h3 followed by the div tags.',$plugin_name); ?></span>
                
	   </div>
	   
	   
    <div id="fragment-3" class="ss-tabs-panel">
        <h3>Image Zoom</h3>
    	<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Zoom', $plugin_name); ?>:</b></legend>
    	<label for="op_zoom">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['zoom'] == "on") echo $checked; ?> name="op_zoom" id="op_zoom" />
    	<?php _e('Add zoom to your images.',$plugin_name); ?></label>
    	<label for="op_zoom_auto">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['zoom_auto'] == "on") echo $checked; ?> name="op_zoom_auto" id="op_zoom_auto" />
    	<?php _e('Auto zoom your images.',$plugin_name); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
               <label for="op_zoom_trans"><?php _e('Transition type',$plugin_name); ?>:   </label>  
             <select name="op_zoom_trans" id="op_zoom_trans">
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "back") echo $selected; ?> id="back" value='back'> back</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_type'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
                </select>&nbsp;
            <label for="op_zoom_transinout"><?php _e('Transition action.',$plugin_name); ?></label>
            <select name="op_zoom_transinout" id="op_zoom_transinout">
                 <option <?php if($ssMod_newOptions['zoom_trans_typeinout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_typeinout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
                 <option <?php if($ssMod_newOptions['zoom_trans_typeinout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
            </select>&nbsp;&nbsp;
                <label for="op_zoom_time"><?php _e('zoom time',$plugin_name); ?>
               <input type="text" class="span-text" name="op_zoom_time" id="op_zoom_time" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['zoom_time']); ?>" /></label>
                <br />
            <span class="setting-description"><?php _e('IN is the begginning of transition. OUT is the end of transition.',$plugin_name); ?></span>

             </li>
             <li>
                <label for="op_zoom_border"><?php _e('Image border -',$plugin_name); ?>
                <input type="text" class="span-text" name="op_zoom_border" id="op_zoom_border" size="12" maxlength="50"
			 value="<?php echo ($ssMod_newOptions['zoom_border']); ?>" />
                </label>,&nbsp;

                <label for="op_zoom_pad"><?php _e('padding -',$plugin_name); ?>
                <input type="text" class="span-text" name="op_zoom_pad" id="op_zoom_pad" size="2" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['zoom_pad']); ?>" />
                </label>

                <label for="op_zoom_back"><?php _e('px, background color -',$plugin_name); ?>
                <input type="text" class="span-text" name="op_zoom_back" id="op_zoom_back" size="8" maxlength="20"
			 value="<?php echo ($ssMod_newOptions['zoom_back']); ?>" />
                </label>
            </li>
            <span class="setting-description"><?php _e('If You deactivate the auto zoom, you can add a zoom to your image by including class="zoom" to the a href tag surrounding your image. Or use the zoom button to add shortcode around a group of images. Colors can be named or hex values, ie: silver, transparent or #afafaf. And border style can be any of the following: solid, dotted, dashed, double, groove, ridge, inset, outset.',$plugin_name); ?></span>

 
         </ul>
	   </fieldset>
	   </div>
	   <div id="fragment-4" class="ss-tabs-panel">
        <h3>Page Scroller</h3>
        <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	     <ul>
   	     
   	     <li><legend><b><?php _e('Scroller', $plugin_name); ?>:</b></legend>
    	<label for="op_scroll_auto">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['scroll_auto'] == "on") echo $checked; ?> name="op_scroll_auto" id="op_scroll_auto" />
    	<?php _e('Add "To Top" link to your pages.',$plugin_name); ?></label>
    	</li>
    	<li>
    	<label for="op_totop_text"><?php _e('To Top Text',$plugin_name); ?>
               <input type="text" class="span-text" name="op_totop_text" id="op_totop_text" size="20" maxlength="120"
			 value="<?php echo ($ssMod_newOptions['totop_text']); ?>" /></label>
                <br />
    	</li>
    	<li>
    	<label for="op_scroll">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['scroll'] == "on") echo $checked; ?> name="op_scroll" id="op_scroll" />
    	<?php _e('Add scroller QuickTag button to your post / page edit screen.',$plugin_name); ?></label>
    	<br />
    	</li>
    
    	<li>
    	<label for="op_scroll_css">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['scroll_css'] == "on") echo $checked; ?> name="op_scroll_css" id="op_scroll_css" />
    	<?php _e('Load the complimentary scroll Css file. (Turn this off to style with your theme css.)',$plugin_name); ?></label>
         </li>
         <li>
               <label for="op_scroll_trans"><?php _e('Transition type',$plugin_name); ?>:   </label>  
             <select name="op_scroll_trans" id="op_scroll_trans">
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "back") echo $selected; ?> id="back" value='back'> back</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
                 <option <?php if($ssMod_newOptions['scroll_trans'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
                </select>&nbsp;
            <label for="op_scroll_transout"><?php _e('Transition action.',$plugin_name); ?></label>
            <select name="op_scroll_transout" id="op_scroll_transout">
                 <option <?php if($ssMod_newOptions['scroll_transout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
                 <option <?php if($ssMod_newOptions['scroll_transout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
                 <option <?php if($ssMod_newOptions['scroll_transout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
            </select>&nbsp;&nbsp;
                <label for="op_scroll_time"><?php _e('Scroll time',$plugin_name); ?>
               <input type="text" class="span-text" name="op_scroll_time" id="op_scroll_time" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['scroll_time']); ?>" /></label>
                <br />
        </li>
        <li>
           <p class="setting-description"><?php _e('IN is the begginning of transition. OUT is the end of transition.',$plugin_name); ?></p>
            <h3>Sliding table of page contents, howto:</h3>
            <p class="setting-description"><?php _e('Use the quick tag button in html/code view to insert a scroll structure to your page or post. Edit the content of the structure to your needs. Add more items by copy and paste. Content object divs must be number sequencially, ie: div id="scroll3"... div id="scroll4"...  This works for single posts and pages, but not for multiple posts per page.',$plugin_name); ?></p>
        </li>

       </ul>
	   </fieldset>
	   </div>
	   <div id="fragment-5" class="ss-tabs-panel">
	    <h3>Link Nudger</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Nudger', $plugin_name); ?>:</b></legend>
        
    	<label for="op_nudger">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['nudger'] == "on") echo $checked; ?> name="op_nudger" id="op_nudger" />
    	<?php _e('Add link nudger to your page.',$plugin_name); ?></label>

            <ul style="list-style-type: none;margin-top:20px;">
               <li>
                <label for="op_nudger_time"><?php _e('nudger time',$plugin_name); ?>
               <input type="text" class="span-text" name="op_nudge_duration" id="op_nudge_duration" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['nudge_duration']); ?>" /></label>
			 </li>
			 <li>
			 <label for="op_nudge_amount"><?php _e('nudger distance',$plugin_name); ?>
               <input type="text" class="span-text" name="op_nudge_amount" id="op_nudge_amount" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['nudge_amount']); ?>" /> .px</label>
			 </li>
			 <li>
			 <label for="op_nudge_family"><?php _e('nudger families',$plugin_name); ?>
               <input type="text" class="span-text" name="op_nudge_family" id="op_nudge_family" size="18" maxlength="200"
			 value="<?php echo ($ssMod_newOptions['nudge_family']); ?>" /><?php _e('css id\'s and or class\'s ex: #footer a.',$plugin_name); ?></label>			 
            </li>
         </ul>
	   </fieldset>
	   	   
	   	   <h3>Linker</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Linker', $plugin_name); ?>:</b></legend>
        
    	<label for="op_linker">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['linker'] == "on") echo $checked; ?> name="op_linker" id="op_linker" />
    	<?php _e('Add linker to your hyperlinks. Dynamically adds a subtle darkened background effect when you click a link.',$plugin_name); ?></label>

            <ul style="list-style-type: none;margin-top:20px;">
               <li>
			 <label for="op_linker_color"><?php _e('linker color',$plugin_name); ?>
               <input type="text" class="span-text" name="op_linker_color" id="op_linker_color" size="18" maxlength="60"
			 value="<?php echo ($ssMod_newOptions['linker_color']); ?>" /></label>
			 
			 </li>
            <li>
			 <label for="op_linker_tag"><?php _e('Linker tags',$plugin_name); ?>
               <input type="text" class="span-text" name="op_linker_tag" id="op_linker_tag" size="18" maxlength="60"
			 value="<?php echo ($ssMod_newOptions['linker_tag']); ?>" />
			 <?php _e('The tags you want to apply the Linker effect to. eg: #sidebar a',$plugin_name); ?></label>
			 
			 </li>
         </ul>
	   </fieldset>
	   
	   	   <h3>Clicker</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Clicker'); ?>:</b></legend>
        
    	<label for="op_clicker">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['clicker'] == "on") echo $checked; ?> name="op_clicker" id="op_clicker" />
    	<?php _e('Add clicker to your pages. Dynamically takes the first link from the contents of a list item and makes the whole list item a clickable link.',$plugin_name); ?></label>

            <ul style="list-style-type: none;margin-top:20px;">
               
            <li>
			 <label for="op_clicker_tag"><?php _e('clicker tags',$plugin_name); ?>
               <input type="text" class="span-text" name="op_clicker_tag" id="op_clicker_tag" size="18" maxlength="60"
			 value="<?php echo ($ssMod_newOptions['clicker_tag']); ?>" />
			 <?php _e('The tags you want to apply the clicker effect to. (default = .clickable li) *Tip - in this case you would need to add class="clickable" to the unordered list. Or you could set this to .entry li to apply clickable to all list items in the entry.',$plugin_name); ?></label>
			 
			 </li>
			 <li>
			 <label for="op_clicker_color"><?php _e('clicker color',$plugin_name); ?>
               <input type="text" class="color-text" name="op_clicker_color" id="op_clicker_color" size="18" maxlength="60"
			 value="<?php echo ($ssMod_newOptions['clicker_color']); ?>" />
			 <?php _e('What color should the clicker hover background be? (default = #c9e0f4) eg. silver, teal, or blue',$plugin_name); ?></label>
			 
			 </li>
			 <li>
			 <label for="op_clicker_span"><?php _e('clicker span',$plugin_name); ?>
               <input type="text" class="span-text" name="op_clicker_span" id="op_clicker_span" size="18" maxlength="60"
			 value="<?php echo ($ssMod_newOptions['clicker_span']); ?>" />
			 <?php _e('To remove the a link tag from the linked text add true, or to leave the link also active add false.',$plugin_name); ?></label>
			 
			 </li>
         </ul>
	   </fieldset>
	   
	   </div>
	   <div id="fragment-6" class="ss-tabs-panel">
	    <h3>Fader</h3>
	    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Fader', $plugin_name); ?>:</b></legend>
        
    	<label for="op_fader">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['fader'] == "on") echo $checked; ?> name="op_fader" id="op_fader" />
    	<?php _e('Add object fader to your page.',$plugin_name); ?></label>
            <ul style="list-style-type: none;margin-top:20px;">
               <li>
                <label for="op_fader_opacity"><?php _e('Fader opacity',$plugin_name); ?>
               <input type="text" class="span-text" name="op_fader_opacity" id="op_fader_opacity" size="3" maxlength="6"
			 value="<?php echo ($ssMod_newOptions['fader_opacity']); ?>" /></label>
			 <label for="op_fader_family"><?php _e('Fader families',$plugin_name); ?>
               <input type="text" class="span-text" name="op_fader_family" id="op_fader_family" size="18" maxlength="60"
			 value="<?php echo ($ssMod_newOptions['fader_family']); ?>" /></label>
			 <br />
			 <span class="setting-description"><?php _e('Add a Fade transition to one object of a group on mouseover. Draws attention to that object.<br /> To use, add class="fader" to an unordered list, or any object with child objects. Then fade will be applied to all the list/child items.',$plugin_name); ?></span>
            </li>
         </ul>
	   </fieldset>

	   </div>

<div id="fragment-7" class="ss-tabs-panel">
	<h3 class="title">Tool Tips (BETA)</h3>
	

    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- ToolTip options start -->
   <legend><b><?php _e('ToolTip Options ',$plugin_name); ?>:</b></legend>
   <ul style="list-style-type: none;">
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    
    	<label for="op_tooltipson">
    	<input type="radio"  name="op_tooltips" id="op_tooltipson"
    	<?php if($ssMod_newOptions['tooltips'] == "on") echo $checked; ?> value="on" /></input>
    	<?php _e('Tooltips turned on.', $plugin_name); ?> </label>
	<br />
		<label for="op_tooltipsoff">
    	<input type="radio"  name="op_tooltips" id="op_tooltipsoff"
    	<?php if($ssMod_newOptions['tooltips'] == "off") echo $checked; ?> value="off" /></input>
    	<?php _e('Tooltips turned off.', $plugin_name); ?> </label>	

	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
         <label for="op_tt_showDelay"><?php _e('Tooltip show delay', $plugin_name); ?>:
         <input type="text" name="op_tt_showDelay" id="op_tt_showDelay" size="6" maxlength="6"
         value="<?php echo ($ssMod_newOptions['tt_showDelay']); ?>"/></label> 
         <?php _e('milliseconds before tooltip appears when mouse enters link, (ie: 1000 = 1 second)',$plugin_name); ?>
     </li>
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
         <label for="op_tt_hideDelay"><?php _e('Tooltip hide delay', $plugin_name); ?>:
         <input type="text" name="op_tt_hideDelay" id="op_tt_hideDelay" size="6" maxlength="6"
         value="<?php echo ($ssMod_newOptions['tt_hideDelay']); ?>"/></label> 
         <?php _e('milliseconds after mouse leaves the link then tooltip fades out, (ie: 1000 = 1 second)',$plugin_name); ?>
     </li>
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
         <label for="op_tt_tip_opacityy"><?php _e('Tooltip Opacity', $plugin_name); ?>:
         <input type="text" name="op_tt_tip_opacity" id="op_tt_tip_opacity" size="6" maxlength="6"
         value="<?php echo ($ssMod_newOptions['tt_tip_opacity']); ?>"/></label> 
         <?php _e('(default 0.8)',$plugin_name); ?>
     </li>
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
         <label for="op_tt_offsetx"><?php _e('Offset x', $plugin_name); ?>:
         <input type="text" name="op_tt_offsetx" id="op_tt_offsetx" size="4" maxlength="7"
         value="<?php echo ($ssMod_newOptions['tt_offsetx']); ?>"/></label> 
         <?php _e('horizontal displacement from link, (default = 40)',$plugin_name); ?>
     <br />
         <label for="op_tt_offsety"><?php _e('Offset y', $plugin_name); ?>:
         <input type="text" name="op_tt_offsety" id="op_tt_offsety" size="4" maxlength="7"
         value="<?php echo ($ssMod_newOptions['tt_offsety']); ?>"/></label> 
         <?php _e('vertical displacement from link, (default = 0)',$plugin_name); ?>
     </li>
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
         <label for="op_toolClass"><?php _e('Add tooltips to objects with the class name of: ', $plugin_name); ?>
         <input type="text" name="op_toolClass" id="op_toolClass" size="35" maxlength="150"
         value="<?php echo ($ssMod_newOptions['toolClass']); ?>"/>         
         	<a href="#base_tips_info" class="ss_tool" style="padding: 2px 8px;"> ? </a></label>
    <div id ="base_tips_info" class="info_box" style="display:none;">
                       <h3><?php _e('field: tooltip class info ',$plugin_name); ?></h3>
                        <?php _e('Add the class of .tiplink to any object, or<br />
                        Enter a single class here, ie: .myclass a.<br />
                        You can also add a comma seperated list,<br />
                        ie: .myclass a, .myotherclass a.<br />',$plugin_name); ?></div>         
     </li>
          <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_tipTitle"><?php _e('Tip title, use the',$plugin_name); ?></label>
    <select name="op_tipTitle" id="op_tipTitle">
     <option <?php if($ssMod_newOptions['tipTitle'] == "title") echo $selected; ?> id="titletitle" value='title'> title</option>
     <option <?php if($ssMod_newOptions['tipTitle'] == "href") echo $selected; ?> id="titlehref" value='href'> href</option>
     <option <?php if($ssMod_newOptions['tipTitle'] == "rel") echo $selected; ?> id="titlerel" value='rel'> rel</option>     
    </select>
    <?php _e('from the link or object for your tooltip title.',$plugin_name); ?>
    </li>
    
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_tipText"><?php _e('Tip text, use the ',$plugin_name); ?></label>
    <select name="op_tipText" id="op_tipText">
     <option <?php if($ssMod_newOptions['tipText'] == "title") echo $selected; ?> id="texttitle" value='title'> title</option>
     <option <?php if($ssMod_newOptions['tipText'] == "href") echo $selected; ?> id="texthref" value='href'> href</option>
     <option <?php if($ssMod_newOptions['tipText'] == "rel") echo $selected; ?> id="textrel" value='rel'> rel</option>     
    </select>
    <?php _e('from the link or object for your tooltip text.',$plugin_name); ?>
    </li>
         <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">

    	<label for="op_tt_fixedon">
     		<input type="radio"
     		<?php if($ssMod_newOptions['tt_fixed'] == "true") echo $checked; ?>  name="op_tt_fixed" id="op_tt_fixedon" value="true" />
     		<?php _e('Tool tip possition, fixed on. (default)',$plugin_name); ?>
     		</label><br />
     	<label for="op_tt_fixedoff">
    		<input type="radio" 
    		<?php if($ssMod_newOptions['tt_fixed'] == "false") echo $checked; ?> name="op_tt_fixed" id="op_tt_fixedoff" value="false"/> 
    		<?php _e('fixed off, tip will follow the pointer.',$plugin_name); ?>
    		</label>    	
	</li>
   </ul>
  </fieldset>

</div><!-- close frag 7 -->   
	   
<div id="fragment-8" class="ss-tabs-panel">
        <h3>Modal Box "BETA"</h3>
    	<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Modal', $plugin_name); ?>:</b></legend>
    	<label for="op_com">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['modal'] == "on") echo $checked; ?> name="op_modal" id="op_modal" />
    	<?php _e('Add Modal Box to your page.',$plugin_name); ?></label>
    	<label for="op_modal_css">
    	<input type="checkbox" 
    	<?php if($ssMod_newOptions['modal_css'] == "on") echo $checked; ?> name="op_modal_css" id="op_modal_css" />
    	<?php _e('Add Modal Box Css file.',$plugin_name); ?></label>

           <ul style="list-style-type: none;margin-top:20px;">
            <li>
                <label for="op_modal_link">
               <input type="text" class="span-text" name="op_modal_link" id="op_modal_link" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['modal_link']); ?>" />
                <?php _e('op_modal_link',$plugin_name); ?></label>
             </li>
           <li>
                <label for="op_modal_height">
               <input type="text" class="span-text" name="op_modal_height" id="op_modal_height" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['modal_height']); ?>" />
                <?php _e('op_modal_height',$plugin_name); ?></label>
             </li>
             <li>
                <label for="op_modal_width">
               <input type="text" class="span-text" name="op_modal_width" id="op_modal_width" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['modal_width']); ?>" />
                <?php _e('op_modal_width',$plugin_name); ?></label>
             </li>
             <li>
                <label for="op_modal_box">
               <input type="text" class="span-text" name="op_modal_box" id="op_modal_box" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['modal_box']); ?>" />
                <?php _e('op_modal_box',$plugin_name); ?></label>
             </li>
             <li>
               <label for="op_modal_title">
               <input type="text" class="span-text" name="op_modal_title" id="op_modal_title" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['modal_title']); ?>" />
                <?php _e('op_modal_title',$plugin_name); ?></label>
             </li>
              <li>
               <label for="op_modal_overlay"><?php _e('modal_overlay',$plugin_name); ?>:   </label>  
             <select name="op_modal_overlay" id="op_modal_overlay">
                 <option <?php if($ssMod_newOptions['modal_overlay'] == "true") echo $selected; ?> id="overlay_true" value='true'> true</option>
                 <option <?php if($ssMod_newOptions['modal_overlay'] == "false") echo $selected; ?> id="overlay_false" value='false'> false</option>
              </select>&nbsp;
             </li>
             <li>
               <label for="op_modal_overlay_color">
               <input type="text" class="span-text" name="op_modal_overlay_color" id="op_modal_overlay_color" size="20" maxlength="20"
			 value="<?php echo ($ssMod_newOptions['modal_overlay_color']); ?>" />
                <?php _e('modal_overlay_color',$plugin_name); ?></label>
             </li>
             <li>
               <label for="op_modal_buttons"><?php _e('modal_buttons',$plugin_name); ?>:   </label>  
             <select name="op_modal_buttons" id="op_modal_buttons">
                 <option <?php if($ssMod_newOptions['modal_buttons'] == "true") echo $selected; ?> id="buttons_true" value='true'> true</option>
                 <option <?php if($ssMod_newOptions['modal_buttons'] == "false") echo $selected; ?> id="buttons_false" value='false'> false</option>
              </select>&nbsp;
              </li>
             <li>
               <label for="op_modal_button_text1">
               <input type="text" class="span-text" name="op_modal_button_text1" id="op_modal_button_text1" size="20" maxlength="40"
			 value="<?php echo ($ssMod_newOptions['modal_button_text1']); ?>" />
                <?php _e('modal_button_text1',$plugin_name); ?></label>
             </li>
             <li>
               <label for="op_modal_button_text2">
               <input type="text" class="span-text" name="op_modal_button_text2" id="op_modal_button_text2" size="20" maxlength="40"
			 value="<?php echo ($ssMod_newOptions['modal_button_text2']); ?>" />
                <?php _e('modal_button_text2',$plugin_name); ?></label>
             </li>
            
             
               <li>
               <label for="op_modal_transition"><?php _e('Transition type',$plugin_name); ?>:   </label>  
             <select name="op_modal_transition" id="op_modal_transition">
                 <option <?php if($ssMod_newOptions['modal_transition'] == "bouncefly") echo $selected; ?> id="bouncefly" value='bouncefly'> bouncefly</option>
                 <option <?php if($ssMod_newOptions['modal_transition'] == "flyin") echo $selected; ?> id="flyin" value='flyin'> flyin</option>
                 <option <?php if($ssMod_newOptions['modal_transition'] == "flyout") echo $selected; ?> id="flyout" value='flyout'> flyout</option>
                 <option <?php if($ssMod_newOptions['modal_transition'] == "flyinout") echo $selected; ?> id="flyinout" value='flyinout'> flyinout</option>
                 <option <?php if($ssMod_newOptions['modal_transition'] == "flyoutin") echo $selected; ?> id="flyoutin" value='flyoutin'> flyoutin</option>
                 <option <?php if($ssMod_newOptions['modal_transition'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
                 <option <?php if($ssMod_newOptions['modal_transition'] == "bouncefly") echo $selected; ?> id="bouncefly" value='bouncefly'> bouncefly</option>
                </select>&nbsp;
             </li>
             <li>
                <label for="op_com_open">
               <input type="text" class="span-text" name="op_com_open" id="op_com_open" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['com_open']); ?>" />
                <?php _e('open link text',$plugin_name); ?></label>
             </li>
             <li>
                <label for="op_com_close">
               <input type="text" class="span-text" name="op_com_close" id="op_com_close" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['com_close']); ?>" />
                <?php _e('close link text',$plugin_name); ?></label>
             </li>
 
         </ul>
	   </fieldset>
	   </div><!-- close frag 8 --> 

<div id="fragment-9" class="ss-tabs-panel">
        <h3>MooDrop Menu</h3>
    	<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   	        <legend><b><?php _e('Menu Options', $plugin_name); ?>:</b></legend>

           <ul style="list-style-type: none;margin-top:20px;">
           <li>
           	<label for="op_moodropmenu">
    			<input type="checkbox" 
    			<?php if($ssMod_newOptions['moodropmenu'] == "on") echo $checked; ?> name="op_moodropmenu" id="op_moodropmenu" />
    			<?php _e('Add MooDropMenu to your site.',$plugin_name); ?></label>
           </li>
            <li>
                <label for="op_moomenu">#
               <input type="text" class="span-text" name="op_moomenu" id="op_moomenu" size="20" maxlength="100"
			 value="<?php echo ($ssMod_newOptions['moomenu']); ?>" />
                <?php _e('Moo Drop Menu oject ID: ',$plugin_name); ?></label>
             </li>
             <li>
             	<p>To use this module, you'll want to add a menu to your site, then get the id of the top level UL (unordered list) and enter that id here. 
             	You should then have a fancy <a href="http://superslider.daivmowbray.com">fold down menu as seen here.</a><br />
             	To edit the css file for this module look here: /wp-content/plugins/superslider/plugin-data/superslider/ssBase/default/MooDropMenu.css
             	</p>
             </li>
 
         </ul>
	   </fieldset>
	   </div><!-- close frag 9 --> 
	   
</div>	   
    <p class="submit">
		<input type="submit" class="button" name="set_defaults" value="<?php _e('Reload Default Options',$plugin_name); ?> &raquo;" />
		<input type="submit" id="update2" class="button-primary" value="<?php _e('Update options',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
	</form>
</div><!-- close column1 -->


<div class="ss_column2">

<?php if( $ispro !== true) { ?>

	<div class="ss_donate ss_admin_box"> 
		<h2><span class="promo"><?php _e('Spread the Word!', $plugin_name); ?></span></h2>
		<p><?php _e('Want to help make this plugin even better? All donations are used to improve and maintain this plugin, so donate $5, $10, $20 or $50! We\'ll both be glad you did. Thanx. ', $plugin_name); ?></p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="N2F3EUVHPYY5G">
            <input type="image" class="paypal_button" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
       </form>
       
       
       <p><?php _e('Better yet, if you would like to join the exclusive pro members club,', $plugin_name); ?> <a href="http://superslider.daivmowbray.com/superslider-pro/"><?php _e('learn more'); ?></a><?php _e('or upgrade now!'); ?> </p>
       <h2><span class="promo">SuperSlider Pro</span></h2>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="83HF3CEUD4976">
			<input type="image" class="paypal_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

       <p><?php _e('Or if you find this plugin useful you could :'); ?></p><ul>
       	<li><a href="http://wordpress.org/extend/plugins/<?php echo $plugin_name; ?>/"><?php _e('Rate the plugin 5 stars on WordPress.org', $plugin_name); ?></a></li>
       	<li><a href="http://superslider.daivmowbray.com/superslider/<?php echo $plugin_name; ?>/"><?php _e('Blog about it &amp; link to the plugin page', $plugin_name); ?></a></li>
       	<li><a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $plugin_name; ?>"><?php _e('Post a glowing review on WordPress.org, that would be really nice.', $plugin_name); ?></a></li>
       	<li><a href="http://amzn.com/w/2GUXZ71357NX9"><?php _e('or buy me a gift from my wishlist ...', $plugin_name); ?></a></li></ul>
       
    </div>
    <div class="ss_admin_box" id="sitereview">
		<h2><?php _e('Improve your Site!', $plugin_name); ?></h2>
		<p><?php _e('Don\'t know where to start? Order a ', $plugin_name); ?><a href="http://superslider.daivmowbray.com/services/website-review/#order"><?php _e('website review', $plugin_name); ?></a> from SuperSlider!
		<a href="http://superslider.daivmowbray.com/services/website-review/"> Read more ... </a></p>	
	</div>

 
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please talk about them in the', $plugin_name); ?> <a href="http://wordpress.org/support/plugin/<?php echo $plugin_name; ?>/">Support forums</a>.</p>	
		</div>

 <?php 
 } else { ?>
	
		<div class="ss_donate ss_admin_box"> <h2><span class="promo">SuperSlider Pro</span></h2> </div>
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please contact me directly via this contact form', $plugin_name); ?><br /><a href="http://superslider.daivmowbray.com/pro-support/">Pro Support</a>.</p>	
		</div>
<?php }?>

	<h2><?php _e('More SuperSlider Plugins', $plugin_name); ?></h2>
	<p><?php _e('There are 11 different SuperSlider plugins. All are free to use. Take a minute and learn what each one can do for you. They save you time and money, while making a better web site.', $plugin_name); ?></p>
	 <div class="ss_plugins_list
	 <?php if (class_exists('ssBase') && class_exists('ssShow') &&  class_exists('ssMenu') && class_exists('ssMenu') && class_exists('ssImage') && class_exists('ssExcerpt') && class_exists('ssMediaPop') && class_exists('perpost_code') && class_exists('ssPnext') && class_exists('ss_postsincat_widget') && class_exists('ssLogin') && class_exists('ssSlim')) { echo "all-installed" ; } ?>
	 "> 
	 
		<div class="ss_plugin <?php if (class_exists('ssBase')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider/" title="visit this plugin at WordPress.org to learn more">SuperSlider</a>	
		<a href="#ss_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="ss_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider base, is a global admin plugin for all SuperSlider plugins and comes stocked full of eye candy in the form of modules.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssShow')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-show/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Show</a>
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-show&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMenu')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-menu/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Menu</a>		
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-menu&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssImage')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-image/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Image</a>
		<a href="#image_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-image&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="image_tips_info" class="info_box" style="display:none;">
		<p>Take control your photos and image display. Can add a randomly selected image to any post without an image. Provides a shortcode for adding a photo or image to your post. Provides an easy way to change image properties globally. At the click of a button all post size images can be changed from thumbnail size image to medium size image or any available image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssExcerpt')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-excerpt/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Excerpt</a>
		<a href="#excerpt_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-excerpt&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="excerpt_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Excerpts automatically adds thumbnails wherever you show excerpts (archive page, feed... etc). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload).</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMediaPop')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-media-pop/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Media-Pop</a>	
		<a href="#media_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-media-pop&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="media_tips_info" class="info_box" style="display:none;">
		<p>Soda pop for your media. Take control of your media. Access all size versions of your uploaded image for insert. SuperSlider-Media-Pop adds numerous image enhancements to your admin panels. Displays all attached files to this post/page in post listing screen. It adds image sizes to the Upload/Insert image screen, making all image sizes available to be inserted and adding to the image link field options. Insert any image size and link to any image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('perpost_code')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-perpost-code/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Perpost-Code</a>
		<a href="#code_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-perpost-code&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="code_tips_info" class="info_box" style="display:none;">
		<p>Write css and javascript code directly on your post edit screen on a per post basis. Meta boxes provide a quick and easy way to enter custom code to each post. It then loads the code into your frontend theme header if the post has custom code. You may also display your custom code directly into your post with the custom_css or custom_js shortcode.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssPnext')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-previousnext-thumbs/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Previousnext-Thumbs</a>
		<a href="#pnext_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-previousnext-thumbs&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pnext_tips_info" class="info_box" style="display:none;">
		<p>Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. Automaitcally insert before or after post content or both. Or you can manually insert into your single post theme file.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ss_postsincat_widget')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-postsincat/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Postsincat</a>
		<a href="#pinc_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-postsincat&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pinc_tips_info" class="info_box" style="display:none;">
		<p>This widget dynamically creates a list of posts from the active category. Displaying the first image and title. It will display the first image in your post as a thumbnail,it looks first for an attached image, then an embedded image then if it finds the image, it grabs the thumbnail version. Oh, and by the way, it's an animated vertical scroller, way cool.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssLogin')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-login/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Login</a>
		<a href="#login_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-login&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="login_tips_info" class="info_box" style="display:none;">
		<p>A tabbed slide in login panel. Theme based, animated, automatic user detection.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssSlim')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://superslider.daivmowbray.com/superslider/superslider-slimbox/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Slimbox</a>
		<a href="#slim_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-slimbox&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="slim_tips_info" class="info_box" style="display:none;">
		<p>Another pop over light box. Theme based, animated, automatic linking, autoplay show built with slimbox2 , uses mootools 1.4.5 java script</p>
		</div></div>
	
		<br style="clear:both;" />
	 </div>
 <h3><?php _e('Services', $plugin_name); ?></h3>
		<p><?php _e('Custom plugins, custom themes, custom solutions: I\'ve been developing WordPress Themes and plugins for many years. If you need a custom solution or simply some help with your set up I am avaiable at reasonable rates. ', $plugin_name); ?><a href="http://www.daivmowbray.com/contact"><?php _e('Just send a note to me, Daiv Mowbray, through this contact form', $plugin_name); ?></a>.</p>

<?php  if( $ispro !== true) { ?>

	<div class="promo_code_form" style="text-align: center;">
	<form name="ssPro_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
	<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssPro_options'); echo "\n"; 
		?>
    		<label for="op_pro_code">
               <input type="text" class="span-text" name="op_pro_code" id="op_pro_code" size="30" maxlength="200"
			 value="<?php echo ($ssPro_newOptions['pro_code']); ?>" />
               <br /> <?php _e('Enter your SuperSlider Pro code.',$plugin_name); ?></label>	
    <p class="margin-top: 5px;">
	
		<input type="submit" id="updatePro" class="button-primary" value="<?php _e('Enter',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="proaction" id="proaction" value="updatepro" />
		
 	</p>
 	</form>
 	</div>
<?php  } ?> 

</div><!-- close column2   --> 
</div><!-- close wrap to here --> 

<?php
	echo "";
?>