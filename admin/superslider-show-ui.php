<?php
/*
Copyright 2008 daiv Mowbray

This file is part of superslider-show

superslider-show is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

superslider-show is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fancy Categories; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	/**
   * Should you be doing this?
   */ 	
   
	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', 'superslider-show' ) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('ssShow_options');
			$ssShow_OldOptions = array(
				"ss_shortcode" => "gallery",
				"show_class" => "",
				"load_moo" => "on",
				"css_load" => "default",
				"css_theme" => "default",//end header ops 
				'show_type' => "push", //default, kenburns, push, fold
				'ss_href' => "",
				'ss_image_size' => "large",
				'ss_first_slide' => "0",
				'ss_zoom' => "25",
				'ss_pan' => "25, 70",
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
				'ss_duration' => "1500",
				'ss_trans_type' => "sine",
				'ss_trans_typeinout' => "in:out",
				'ss_tool_tips' => "true",
				'ss_lightbox' => "on",
				'ss_lightbox_add' => "on",
				'ss_lightbox_type' => "Lightbox");//end array
			
			update_option($this->AdminOptionsName, $ssShow_OldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider-show Default Options reloaded.', 'superslider-show' ) . '</strong></p></div>';
			
		}
		elseif ($_POST['action'] == 'update' ) {
			
			check_admin_referer('ssShow_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider-show Options saved.', 'superslider-show' ) . '</strong></p></div>';
			
			$ssShow_newOptions = array(			
				'ss_shortcode' 	=> $_POST['op_shortcode'],
				'load_moo'		=> $_POST['op_load_moo'],
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'show_type'		=> $_POST["op_show_type"],
				'ss_href'		=> $_POST["op_href"],
				'ss_image_size'		=> $_POST["op_image_size"],
				'ss_first_slide'		=> $_POST["op_first_slide"],
				'ss_zoom'		=> $_POST["op_zoom"],
				'ss_pan'		=> $_POST["op_pan"],
				'ss_color'		=> $_POST["op_color"],
				'ss_height'		=> $_POST["op_height"],
				'ss_width'		=> $_POST["op_width"],
				'ss_center'		=> $_POST["op_center"],
				'ss_resize'		=> $_POST["op_resize"],
				'ss_linked'		=> $_POST["op_linked"],
				'ss_fast'		=> $_POST["op_fast"],
				'ss_captions'		=> $_POST["op_captions"],
				'ss_overlap'		=> $_POST["op_overlap"],
				'ss_thumbnails'		=> $_POST["op_thumbnails"],
				'ss_mouseover'		=> $_POST["op_mouseover"],
				'ss_thumb_height'	=> $_POST["op_thumb_height"],
				'ss_thumb_width'	=> $_POST["op_thumb_width"],
				'ss_paused'		=> $_POST["op_paused"],
				'ss_random'		=> $_POST["op_random"],
				'ss_loop'		=> $_POST["op_loop"],
				'ss_loader'		=> $_POST["op_loader"],
				'ss_delay'		=> $_POST["op_delay"],
				'ss_controller'		=> $_POST["op_controller"],
				'ss_duration'		=> $_POST["op_duration"],
				'ss_trans_type'		=> $_POST["op_trans_type"],
				'ss_trans_typeinout'	=> $_POST["op_trans_typeinout"],			
				'ss_tool_tips'			=> $_POST["op_tool_tips"],
				'ss_lightbox'			=> $_POST["op_lightbox"],
				'ss_lightbox_add'		=> $_POST["op_lightbox_add"],
				'ss_lightbox_type'		=> $_POST["op_lightbox_type"]
			);	

		update_option($this->AdminOptionsName, $ssShow_newOptions);

		}	

		$ssShow_newOptions = get_option($this->AdminOptionsName);   

	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_settings('siteurl'); 
?>

<div class="wrap">
<form name="ssShow_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<!-- possible auto save options : action="options.php" , bellow, update-options as nonce -->
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssShow_options'); echo "\n"; ?>
		
<div style="">
<a href="http://wp-superslider.com/">
<img src="<?php echo $site ?>/wp-content/plugins/superslider-show/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-Show Options</h2>
 </div><br style="clear:both;" />
 <table class="form-table">
	<tr><th scope="row">SlideShow Appearance</th>
		<td width="70%" valign="top">
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  	
		<legend><b><?php _e(' Themes',$ssShow_domain); ?>:</b></legend>
	<table width="100%" cellpadding="10" align="center"><optgroup label="op_css_theme">
	<tr>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-show/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-show/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-show/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-show/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
	</tr>
	<tr>
		<td><label for="op_css_theme1">
			 <input type="radio"  name="op_css_theme" id="op_css_theme1"
			 <?php if($ssShow_newOptions['css_theme'] == "default") echo $checked; ?> value="default" /></input>
			</label>
		</td>
		<td> <label for="op_css_theme2">
			 <input type="radio"  name="op_css_theme" id="op_css_theme2"
			 <?php if($ssShow_newOptions['css_theme'] == "blue") echo $checked; ?> value="blue" /></input>
			 </label>
  		</td>
		<td><label for="op_css_theme3">
			 <input type="radio"  name="op_css_theme" id="op_css_theme3"
			 <?php if($ssShow_newOptions['css_theme'] == "black") echo $checked; ?> value="black" /></input>
			 </label>
  		</td>
		<td> <label for="op_css_theme4">
			 <input type="radio"  name="op_css_theme" id="op_css_theme4"
			 <?php if($ssShow_newOptions['css_theme'] == "custom") echo $checked; ?> value="custom" /></input>
			</label>
     </td>
	</tr>
	<tr>
		<td></td>
		<td>Blue is preset for thumbs at 50px.</td>
		<td></td>
		<td>Thumbs vertical on right side.</td>
	</tr>
	</table>
     <br /><span class="setting-description"><?php _e('  Choose a theme for your SlideShow.  Set for thumbs at 150px, you can edit the css files to suit your needs. ',$ssShow_domain); ?></span>
    </optgroup>
  
  <!--<ul style="list-style-type: none;">
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    <optgroup label="op_tool_tips">
    	<label for="op_tool_tipson">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_tool_tips'] == "true") echo $checked; ?> name="op_tool_tips" id="op_tool_tipson" value="true"/> 
    		<?php _e(' Animated Tooltips on (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_tool_tipsoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_tool_tips'] == "false") echo $checked; ?>  name="op_tool_tips" id="op_tool_tipsoff" value="false" />
     		<?php _e(' off.',$ssShow_domain); ?>
     		</label>
     		</input>
     	 <br /><span class="setting-description"><?php _e(' Presents Image description in an Animated float over tooltip.',$ssShow_domain); ?></span>
    
     </optgroup>
	</li>
	</ul>-->
  </fieldset>
  </td>
		<td width="30%" valign="top">
		<p class="submit">
		<input type="submit" id="update" class="button-primary" value="<?php _e(' Update options',$ssShow_domain); ?> &raquo;" />
		</p>
		</td>
	</tr>
	
	<tr><th scope="row">SlideShow Shortcode</th>
		<td width="70%" valign="top">
				<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  
   <legend><b><?php _e(' Shortcode',$ssShow_domain); ?>:</b></legend>
		 <ul style="list-style-type: none;">
		 	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_shortcode">
    	<label for="op_shortcodegal">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_shortcode'] == "gallery") echo $checked; ?> name="op_shortcode" id="op_shortcodegal" value="gallery"/> 
    		<?php _e('Use the default gallery shortcode.',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_shortcodeslide">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_shortcode'] == "slideshow") echo $checked; ?>  name="op_shortcode" id="op_shortcodeslide" value="slideshow" />
     		<?php _e(' Use slideshow as your shortcode.',$ssShow_domain); ?>
     		</label>
     		</input>
     	</optgroup>
     	  <br /><span class="setting-description"><?php _e('  By setting this to slideshow, you can keep your default WordPress galleries. You must then add the [slideshow] shortcode to your page or post. Gallery options will not interfeer with slideshow, nor will slideshow options interfeer with gallery. ',$ssShow_domain); ?></span>
   			
    		</li>
		 </ul>
	</fieldset>
  </td>
		<td valign="top">
		<p> <?php _e('Full shortcode options example, starting with either slideshow or gallery: <br /> [slideshow id="post id" show_class="family" first="0" show_type="kenburns/push/fold/default" height="400" width="200" transition="elastic:In:Out" thumbnails="true" image_size="thumbnail/medium/large/full" delay="milliseconds" duration="milliseconds" center="true" resize="true" overlap="true" random="true" loop="true" linked="true" fast="true" captions="true" controller="true" paused ="true"]',$ssShow_domain); ?>
		</p>
		</td>
	</tr>
		
	<tr><th scope="row">Options</th>
		<td>
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- SLideshow options start -->
   <legend><b><?php _e(' Personalize Transitions',$ssShow_domain); ?>:</b></legend>
   <ul style="list-style-type: none;">
     
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    <label for="op_show_type"><?php _e(' Slideshow transition style.',$ssShow_domain); ?></label>
    <select name="op_show_type" id="op_show_type">
		 <option <?php if($ssShow_newOptions['show_type'] == "default") echo $selected; ?> id="op_show_type1" value='default'> default</option>
		 <option <?php if($ssShow_newOptions['show_type'] == "kenburns") echo $selected; ?> id="op_show_type2" value='kenburns'> kenburns</option>
		 <option <?php if($ssShow_newOptions['show_type'] == "push") echo $selected; ?> id="op_show_type3" value='push'> push</option>
		 <option <?php if($ssShow_newOptions['show_type'] == "fold") echo $selected; ?> id="op_show_type4" value='fold'> fold</option>
		 <option <?php if($ssShow_newOptions['show_type'] == "flash") echo $selected; ?> id="op_show_type5" value='flash'> flash</option>
	</select>
    <span class="setting-description"><?php _e(' View samples here,- <a href="http://www.electricprism.com/aeron/slideshow/">slideshow2 demos</a>.',$ssShow_domain); ?></span>
     </li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_trans_type"><?php _e(' Transition type',$ssShow_domain); ?>:   </label>  
		 <select name="op_trans_type" id="op_trans_type">
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "sine") echo $selected; ?> id="sine" value='sine'> sine</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "elastic") echo $selected; ?> id="elastic" value='elastic'> elastic</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "bounce") echo $selected; ?> id="bounce" value='bounce'> bounce</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "back") echo $selected; ?> id="back" value='back'> back</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "expo") echo $selected; ?> id="expo" value='expo'> expo</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "circ") echo $selected; ?> id="circ" value='circ'> circ</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "quad") echo $selected; ?> id="quad" value='quad'> quad</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "cubic") echo $selected; ?> id="cubic" value='cubic'> cubic</option>
			 <option <?php if($ssShow_newOptions['ss_trans_type'] == "linear") echo $selected; ?> id="linear" value='linear'> linear</option>
			</select><br />
		<label for="op_trans_typeinout"><?php _e(' Transition action.',$ssShow_domain); ?></label>
		<select name="op_trans_typeinout" id="op_trans_typeinout">
			 <option <?php if($ssShow_newOptions['ss_trans_typeinout'] == "in") echo $selected; ?> id="in" value='in'> in</option>
			 <option <?php if($ssShow_newOptions['ss_trans_typeinout'] == "out") echo $selected; ?> id="out" value='out'> out</option>
			 <option <?php if($ssShow_newOptions['ss_trans_typeinout'] == "in:out") echo $selected; ?> id="inout" value='in:out'> in:out</option>     
		</select>
		<span class="setting-description"><?php _e(' IN is the beginning of transition. OUT is the end.',$ssShow_domain); ?></span>
     </li><!-- //'quad:in:out'sine:out, elastic:out, bounce:out, expo:out, circ:out, quad:out, cubic:out, linear:out, -->    
     
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_delay"><?php _e(' Slide viewing time'); ?>:
		 <input type="text" class="span-text" name="op_delay" id="op_delay" size="6" maxlength="6"
		 value="<?php echo ($ssShow_newOptions['ss_delay']); ?>"/></label> 
		 <span class="setting-description"><?php _e('  In milliseconds, ie: 1000 = 1 second, (default 4000)',$ssShow_domain); ?></span>
	</li>
      
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_duration"><?php _e(' Transition time '); ?>:
		 <input type="text" class="span-text" name="op_duration" id="op_duration" size="6" maxlength="6"
		 value="<?php echo ($ssShow_newOptions['ss_duration']); ?>"/></label> 
		 <span class="setting-description"><?php _e('  In milliseconds, ie: 1000 = 1 second, (default 1500)',$ssShow_domain); ?></span>
	</li>
      
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_zoom"><?php _e(' Slideshow zoom '); ?>:
		 <input type="text" class="span-text" name="op_zoom" id="op_zoom" size="20" maxlength="20"
		 value="<?php echo ($ssShow_newOptions['ss_zoom']); ?>"/></label> 
		 <span class="setting-description"><?php _e('  For Kenburns transition, zoom amount, (default 25)',$ssShow_domain); ?></span>
	 	<small>(integer or array) An integer, or range of integers as an array, from 0 to 100 that zooms the slide 1x to 2x of the size of the slideshow. If you use an array of numbers, be sure to enclose them in square brackets.</small>
	 </li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_pan"><?php _e(' Slideshow pan '); ?>:
		 <input type="text" class="span-text" name="op_pan" id="op_pan" size="20" maxlength="20"
		 value="<?php echo ($ssShow_newOptions['ss_pan']); ?>"/></label> 
		 <span class="setting-description"><?php _e(' For Kenburns, this is the pan start and finish. (default [25, 75])',$ssShow_domain); ?></span>
		<small>(integer or array) An integer, or range of integers as an array, from 0 to 100 that pans the slide 0% to 100% of it's overflow. If you use an array of numbers, be sure to enclose them in square brackets.</small>
	</li> 
	<!-- -->
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_color"><?php _e(' Slide flash colors '); ?>:
		 <input type="text" class="span-text" name="op_color" id="op_color" size="8" maxlength="150"
		 value="<?php echo ($ssShow_newOptions['ss_color']); ?>"/></label> 
		 <span class="setting-description"><?php _e(' For Flash from color to image',$ssShow_domain); ?></span>
		<br /><small>color - (default #FFF) A single color: #cdcdcd. <!-- string or array: or an array of colors: ["#FFF", "#000"], which are applied incrementally to the slides in the show.-->
		</small>
	</li> 
			
		
     </ul>
  </fieldset>
  </td>
		<td valign="top">
		<p><?php _e('These options are global. You can modify most options within your individual post by adding options to the shortcode, as viewed in the above example.',$ssShow_domain); ?>
		</p>
		<p><?php _e('You can further edit and or modify your image transitions, captions transitions, controller transitions, loading icon transitions and thumbnail transitions by editing your chosen css file. All css is commented explaining which class does what.',$ssShow_domain); ?></p>
		</td>
	</tr>
	<tr><th scope="row">Image Options</th>
		<td width="70%" valign="top">
				<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  
   <legend><b><?php _e(' Slide Images',$ssShow_domain); ?>:</b></legend>
		 <ul style="list-style-type: none;">
		 	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
				<label for="op_image_size"><?php _e(' Slideshow Image size to use.',$ssShow_domain); ?></label>
				<select name="op_image_size" id="op_image_size">
					 <option <?php if($ssShow_newOptions['ss_image_size'] == "thumbnail") echo $selected; ?> id="op_image_size1" value='thumbnail'> thumbnail</option>
					 <option <?php if($ssShow_newOptions['ss_image_size'] == "medium") echo $selected; ?> id="op_image_size2" value='medium'> medium</option>
					 <option <?php if($ssShow_newOptions['ss_image_size'] == "large") echo $selected; ?> id="op_image_size3" value='large'> large</option>
					 <option <?php if($ssShow_newOptions['ss_image_size'] == "full") echo $selected; ?> id="op_image_size4" value='full'> full</option>
				</select>
				<span class="setting-description"><?php _e(' Which image size to set as default for all slide shows. Overrides the gallery size defined in WordPress insert gallery window.',$ssShow_domain); ?></span>
			</li>
			 <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
				<optgroup label="op_center">
				<label for="op_centeron">
					<input type="radio" 
					<?php if($ssShow_newOptions['ss_center'] == "true") echo $checked; ?> name="op_center" id="op_centeron" value="true"/> 
					<?php _e(' Image centered on (default).',$ssShow_domain); ?>
					</label>
					<br />
				<label for="op_centeroff">
					<input type="radio" 
					<?php if($ssShow_newOptions['ss_center'] == "false") echo $checked; ?>  name="op_center" id="op_centeroff" value="false" />
					<?php _e(' Image centered off.',$ssShow_domain); ?>
					</label>
					</input>
			 </optgroup>
		 </li>
		 <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_resize"><?php _e(' Slideshow image resizing.',$ssShow_domain); ?></label>
			 <select name="op_resize" id=op_resize">
				 <option <?php if($ssShow_newOptions['ss_resize'] == "true") echo $selected; ?> id="op_resize1" value='true'> true</option>
				 <option <?php if($ssShow_newOptions['ss_resize'] == "false") echo $selected; ?> id="op_resize2" value='false'> false</option>
				 <option <?php if($ssShow_newOptions['ss_resize'] == "length") echo $selected; ?> id="op_resize3" value='length'> length</option>
				 <option <?php if($ssShow_newOptions['ss_resize'] == "width") echo $selected; ?> id="op_resize4" value='width'> width</option>
			</select>
			 <br /><small><?php _e(' True will scale the image to fit your viewing area based on the shortest side. Length will scale to fit the longest side of the image and width will scale to fit width.',$ssShow_domain); ?></small>
			
		</li>
		 <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
			<optgroup label="op_overlap">
				<label for="op_overlapon">
					<input type="radio" 
					<?php if($ssShow_newOptions['ss_overlap'] == "true") echo $checked; ?> name="op_overlap" id="op_overlapon" value="true"/> 
					<?php _e(' Overlap images in transition (default).',$ssShow_domain); ?>
					</label>
					<br />
				<label for="op_overlapoff">
					<input type="radio" 
					<?php if($ssShow_newOptions['ss_overlap'] == "false") echo $checked; ?>  name="op_overlap" id="op_overlapoff" value="false" />
					<?php _e(' Prevent image overlap.',$ssShow_domain); ?>
					</label>
					</input>
		 </optgroup>
		</li>
		 </ul>
	</fieldset>
  </td>
		<td valign="top">
		
		</td>
	</tr>
	<tr><th scope="row">General Options</th>
		<td>
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- SLideshow options start -->
   <legend><b><?php _e(' Personalize your SlideShow',$ssShow_domain); ?>:</b></legend>
   <ul style="list-style-type: none;">
		 
		 <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_first_slide"><?php _e(' Starting slide '); ?>:
			 <input type="text" class="span-text" name="op_first_slide" id="op_first_slide" size="2" maxlength="2"
			 value="<?php echo ($ssShow_newOptions['ss_first_slide']); ?>"/></label> 
			 <span class="setting-description"><?php _e('  Which slide should be the first? the count starts at 0. (default 0)',$ssShow_domain); ?></span>
		 </li>
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_height"><?php _e(' Slideshow height '); ?>:
			 <input type="text" class="span-text" name="op_height" id="op_height" size="6" maxlength="6"
			 value="<?php echo ($ssShow_newOptions['ss_height']); ?>"/></label> 
			 <span class="setting-description"><?php _e('  Measurment in pixels, do not add px, this is the viewing area',$ssShow_domain); ?></span>
		 </li>     
		 <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_width"><?php _e(' Slideshow width '); ?>:
			 <input type="text" class="span-text" name="op_width" id="op_width" size="6" maxlength="6"
			 value="<?php echo ($ssShow_newOptions['ss_width']); ?>"/></label> 
			 <span class="setting-description"><?php _e('  Measurment in pixels, do not add px, this is the viewing area',$ssShow_domain); ?></span>
		 </li>
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		<optgroup label="op_controller">
			<label for="op_controlleron">
				<input type="radio" 
				<?php if($ssShow_newOptions['ss_controller'] == "true") echo $checked; ?> name="op_controller" id="op_controlleron" value="true"/> 
				<?php _e(' Controller on (default).',$ssShow_domain); ?>
				</label>
				<br />
			<label for="op_controlleroff">
				<input type="radio" 
				<?php if($ssShow_newOptions['ss_controller'] == "false") echo $checked; ?>  name="op_controller" id="op_controlleroff" value="false" />
				<?php _e(' off.',$ssShow_domain); ?>
				</label>
				</input>
		 </optgroup>
		</li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    <optgroup label="op_mouseover">
    	<label for="op_mouseoveron">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_mouseover'] == "true") echo $checked; ?> name="op_mouseover" id="op_mouseoveron" value="true"/> 
    		<?php _e(' Mouseover stop slides on (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_mouseoveroff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_mouseover'] == "false") echo $checked; ?>  name="op_mouseover" id="op_mouseoveroff" value="false" />
     		<?php _e(' off.',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
     	 <span class="setting-description"><?php _e('  Your slideshow will pause while the users mouse is over the images. Be carfull how you use this in conjunction with the controller.',$ssShow_domain); ?>
     	 </span>
	 
	</li>
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_captions">
    	<label for="op_captionson">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_captions'] == "true") echo $checked; ?> name="op_captions" id="op_captionson" value="true"/> 
    		<?php _e(' Image captions on (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_captionsoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_captions'] == "false") echo $checked; ?>  name="op_captions" id="op_captionsoff" value="false" />
     		<?php _e(' off.',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
    </li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_paused">
    	<label for="op_pausedoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_paused'] == "false") echo $checked; ?>  name="op_paused" id="op_pausedoff" value="false" />
     		<?php _e(' Starts activated (default).',$ssShow_domain); ?>
     		</label>
     		</input>
     		<br />
    	<label for="op_pausedon">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_paused'] == "true") echo $checked; ?> name="op_paused" id="op_pausedon" value="true"/> 
    		<?php _e(' Paused at start.',$ssShow_domain); ?>
    		</label>
     </optgroup>
    </li>
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_random">
    	<label for="op_randomon">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_random'] == "true") echo $checked; ?> name="op_random" id="op_randomon" value="true"/> 
    		<?php _e(' Random image order on.',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_randomoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_random'] == "false") echo $checked; ?>  name="op_random" id="op_randomoff" value="false" />
     		<?php _e(' off (default).',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
    </li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_loop">
    	<label for="op_loopon">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_loop'] == "true") echo $checked; ?> name="op_loop" id="op_loopon" value="true"/> 
    		<?php _e(' Loop image group from end to start (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_loopoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_loop'] == "false") echo $checked; ?>  name="op_loop" id="op_loopoff" value="false" />
     		<?php _e(' Looping of image group off.',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
    </li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_loader">
    	<label for="op_loaderon">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_loader'] == "true") echo $checked; ?> name="op_loader" id="op_loaderon" value="true"/> 
    		<?php _e(' Show loading graphic while loading (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_loaderoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_loader'] == "false") echo $checked; ?>  name="op_loader" id="op_loaderoff" value="false" />
     		<?php _e(' No loading graphic.',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
    </li>
     
    </ul>
  </fieldset>
  </td>
		<td valign="top">
		<p class="submit">
		<input type="submit" id="update" class="button-primary" value="<?php _e(' Update options',$ssShow_domain); ?> &raquo;" />
		</p>
		</td>
	</tr>
<tr><th scope="row">Thumbnails</th>
		<td><fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Thumbnails options start -->
   			<legend><b><?php _e(' Thumb Options'); ?>:</b></legend>
		<ul style="list-style-type: none;">
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_thumbnails">
    	<label for="op_thumbnailson">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_thumbnails'] == "true") echo $checked; ?> name="op_thumbnails" id="op_thumbnailson" value="true"/> 
    		<?php _e(' Image thumbnails on (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_thumbnailsoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_thumbnails'] == "false") echo $checked; ?>  name="op_thumbnails" id="op_thumbnailsoff" value="false" />
     		<?php _e(' Image thumbnails off.',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
    </li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_fast">
    	<label for="op_faston">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_fast'] == "true") echo $checked; ?> name="op_fast" id="op_faston" value="true"/> 
    		<?php _e(' Thumbnail click, jumps to new image.',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_fastoff">
     		<input type="radio" 
     		<?php if($ssShow_newOptions['ss_fast'] == "false") echo $checked; ?>  name="op_fast" id="op_fastoff" value="false" />
     		<?php _e(' Thumbnail click transitions to new image (default).',$ssShow_domain); ?>
     		</label>
     		</input>
     </optgroup>
    </li>
   <!--  
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_thumb_height"><?php _e(' Thumb height '); ?>:
		 <input type="text" class="span-text" name="op_thumb_height" id="op_thumb_height" size="3" maxlength="3"
		 value="<?php echo ($ssShow_newOptions['ss_thumb_height']); ?>"/></label> 
		 <span class="setting-description"><?php _e('  Measurment in pixels, do not add px, this is the thumb size',$ssShow_domain); ?></span>
	</li>
     
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_thumb_width"><?php _e(' Thumb width '); ?>:
		 <input type="text" class="span-text" name="op_thumb_width" id="op_thumb_width" size="3" maxlength="3"
		 value="<?php echo ($ssShow_newOptions['ss_thumb_width']); ?>"/></label> 
		 <span class="setting-description"><?php _e('  Measurment in pixels, do not add px, this is the thumb width',$ssShow_domain); ?></span>
	</li>-->
     
		</ul></fieldset>
		</td>
		<td>
		<p class="submit">
		<input type="submit" id="update" class="button-primary" value="<?php _e(' Update options',$ssShow_domain); ?> &raquo;" />
		</p>
		</td>
	</tr>
	<tr><th scope="row">Lightbox Popovers</th>
		<td>
		
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Header files options start -->
   	<legend><b><?php _e(' Lightbox Options'); ?>:</b></legend>
  	<ul style="list-style-type: none;">
  		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_href"><?php _e(' Show links to '); ?>:
			 <input type="text" class="span-text" name="op_href" id="op_href" size="30" maxlength="150"
			 value="<?php echo ($ssShow_newOptions['ss_href']); ?>"/></label> 
			 <br /><span class="setting-description"><?php _e('  Add a global link destination for all slides. Image linked option bellow needs to be off. (http://www.yercoolsite.com)',$ssShow_domain); ?></span>
		 </li>
  	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<optgroup label="op_linked">
    	<label for="op_linkedon">
    		<input type="radio" 
    		<?php if($ssShow_newOptions['ss_linked'] == "true") echo $checked; ?> name="op_linked" id="op_linkedon" value="true"/> 
    		<?php _e(' Image linked on (default).',$ssShow_domain); ?>
    		</label>
    		<br />
    	<label for="op_linkedoff">
     		<input type="radio"
     		<?php if($ssShow_newOptions['ss_linked'] == "false") echo $checked; ?>  name="op_linked" id="op_linkedoff" value="false" />
     		<?php _e(' Image linked off.',$ssShow_domain); ?>
     		</label>
     </optgroup>
      <br /><span class="setting-description"><?php _e('  Turn on if the main slideshow image should be linked to either the Wordpress attachment page or a lightbox popover. ',$ssShow_domain); ?></span>
   
    </li>
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<label for="op_lightbox">
    	<input type="checkbox" name="op_lightbox" id="op_lightbox"
    	<?php if($ssShow_newOptions['ss_lightbox'] == "on") echo $checked; ?> />
    	<?php _e(' Link to lightbox popover turned on.',$ssShow_domain); ?></label>
    	 <br /><span class="setting-description"><?php _e('  Otherwise image will link to the attachment page. ',$ssShow_domain); ?></span>
   
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<label for="op_lightbox_add">
    	<input type="checkbox" name="op_lightbox_add" id="op_lightbox_add"
    	<?php if($ssShow_newOptions['ss_lightbox_add'] == "on") echo $checked; ?> />
    	<?php _e(' Add built in SuperSlider lightbox .',$ssShow_domain); ?></label>
    	 <br /><span class="setting-description"><?php _e('  If you want to link to a lightbox popover, and you don\'t have the lightbox plugin installed. This will install for the slideshow only. ',$ssShow_domain); ?></span>
   
	</li>
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    
    <p><?php _e(' Select which Lightbox plugin you have installed. (untested)',$ssShow_domain); ?></p>
    <optgroup label="op_lightbox_type">
    
    	<label for="op_lightbox_type1">
			<input type="radio" name="op_lightbox_type" id="op_lightbox_type1"
			<?php if($ssShow_newOptions['ss_lightbox_type'] == "Lightbox") echo $checked; ?> value="Lightbox" />
			<?php _e(' Lightbox for pop over. (Recommended)',$ssShow_domain); ?></label><br />
    	<label for="op_lightbox_type2">
			<input type="radio" name="op_lightbox_type"  id="op_lightbox_type2"
			<?php if($ssShow_newOptions['ss_lightbox_type'] == "Milkbox") echo $checked; ?> value="Milkbox" />
			<?php _e(' Milkbox for pop over. ',$ssShow_domain); ?></label><br />
    <!--<label for="op_lightbox_type3">
			<input type="radio" name="op_lightbox_type"  id="op_lightbox_type3"
			<?php if($ssShow_newOptions['ss_lightbox_type'] == "Slimbox") echo $checked; ?> value="Slimbox" />
			<?php _e(' Slimbox with pop over.',$ssShow_domain); ?></label><br />
		<label for="op_lightbox_type4">
			<input type="radio" name="op_lightbox_type"  id="op_lightbox_type4"
			<?php if($ssShow_newOptions['ss_lightbox_type'] == "greybox") echo $checked; ?> value="greybox" />
			<?php _e(' Greybox with pop over.',$ssShow_domain); ?></label><br />
		<label for="op_lightbox_type5">
			<input type="radio" name="op_lightbox_type"  id="op_lightbox_type5"
			<?php if($ssShow_newOptions['ss_lightbox_type'] == "shadowbox") echo $checked; ?> value="shadowbox" />
			<?php _e(' Shadowbox with pop over.',$ssShow_domain); ?></label>
    	<br />-->
    	</optgroup>
    </li>
    </ul>
     </fieldset>
     </td>
		<td valign="top"><p><?php _e(' If you want the slideshow image to link to a pop over lightbox, activate it here. If you have a lightbox plugin installed do not sellect the Add lightbox option. If you do have a lightbox plugin, select which one.',$ssShow_domain); ?></p></td>
	</tr>
	<tr><th scope="row">File Storage</th>
		<td>
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Header files options start -->
   			<legend><b><?php _e(' Loading Options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<label for="op_load_moo">
    	<input type="checkbox" 
    	<?php if($ssShow_newOptions['load_moo'] == "on") echo $checked; ?> name="op_load_moo" id="op_load_moo" />
    	<?php _e(' Load Mootools 1.2 into your theme header.',$ssShow_domain); ?></label>
    	
	</li>
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    <optgroup label="op_css_load">
    	<label for="op_css_load1">
			<input type="radio" name="op_css_load" id="op_css_load1"
			<?php if($ssShow_newOptions['css_load'] == "default") echo $checked; ?> value="default" />
			<?php _e(' Load css from default location. superslider-show plugin folder.',$ssShow_domain); ?></label><br />
    	<label for="op_css_load2">
			<input type="radio" name="op_css_load"  id="op_css_load2"
			<?php if($ssShow_newOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
			<?php _e(' Load css from plugin-data folder, see side note. (Recommended)',$ssShow_domain); ?></label><br />
    	<label for="op_css_load3">
			<input type="radio" name="op_css_load"  id="op_css_load3"
			<?php if($ssShow_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
			<?php _e(' Don\'t load css, manually add to your theme css file.',$ssShow_domain); ?></label>
    	</optgroup>
    </li>
    </ul>
     </fieldset>
     </td>
		<td valign="top"><p><?php _e(' If your theme or any other plugin loads the mootools 1.2 javascript framework into your file header, you can disactivate it here.',$ssShow_domain); ?></p><p><?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$ssShow_domain); ?></p></td>
	</tr>
	
</table>
<p class="submit">
		<input type="submit" name="set_defaults" value="<?php _e(' Reload Default Options',$ssShow_domain); ?> &raquo;" />
		<input type="submit" id="update" class="button-primary" value="<?php _e(' Update options',$ssShow_domain); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form
</div>
<?php
	echo "";
?>