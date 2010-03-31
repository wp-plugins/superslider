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
   //error_reporting(E_ALL ^ E_NOTICE);

	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', 'superslider' ) );
		}
		
        $ssBase_newOptions = get_option('ssBase_options');   

		if (isset($_POST['set_defaults']))  { 
		
			$ssBase_OldOptions = array(
				"load_moo" => "on",
				"css_load" => "default",
				"css_theme" => "default",
				"ss_global_over_ride" => "on");
			
			update_option('ssBase_options', $ssBase_OldOptions);

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
				'ss_global_over_ride'	=> $_POST["op_global_over_ride"]				
			);	

		update_option('ssBase_options', $ssBase_newOptions);

		}
		
	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
?>

<div class="wrap">
<form name="ssBase_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssBase_options'); echo "\n"; 
		//settings_fields( 'ssBase_options' );

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
    </ul>
    <div id="fragment-1" class="ss-tabs-panel">
 	<h3 scope="row">Global Options</h3>
		
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- SLideshow options start -->
   <legend><b><?php _e(' Global Over ride',$ssBase_domain); ?>:</b></legend>
    	<label for="op_global_over_ride">
    	<input type="checkbox" name="op_global_over_ride" id="op_global_over_ride"
    	<?php if($ssBase_newOptions['ss_global_over_ride'] == "on") echo $checked; ?> />
    	<?php _e(' Global superslider plugin over ride .',$ssBase_domain); ?></label>
    	 <br /><span class="setting-description"><?php _e(' All SuperSlider plugins will use these Base plugin settings for: Themes,Mootools loading, and css file storage.<br />
    	 When global control is disabled, the Appearance and file storage controls only affect the SuperSlider <a href="admin.php?page=superslider-modules">Modules</a>',$ssBase_domain); ?></span>
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
            <!--<label for="op_css_load3">
                <input type="radio" name="op_css_load"  id="op_css_load3"
                <?php if($ssBase_newOptions['css_load'] == "theme") echo $checked; ?> value="theme" />
                <?php _e(' Load css from your theme folder, (themes/your_theme/superslider/ssBase).',$ssBase_domain); ?></label>
            <br />-->
            <label for="op_css_load4">
                <input type="radio" name="op_css_load"  id="op_css_load4"
                <?php if($ssBase_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
                <?php _e(' Don\'t load css, manually add to your theme css file.',$ssBase_domain); ?></label>
            <br />
            <p class="setting-description"><?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$ssBase_domain); ?></p>
                   
        
        </li>
        </ul>
    </fieldset>
     
		<p><?php _e(' If your theme or any other plugin loads the mootools 1.2 javascript framework into your file header, you can disactivate it here.',$ssBase_domain); ?></p>

		</div>
</div>	   
    <p class="submit">
		<input type="submit" name="set_defaults" value="<?php _e(' Reload Default Options',$ssBase_domain); ?> &raquo;" />
		<input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e(' Update options',$ssBase_domain); ?> &raquo;" />
		<input type="hidden" name="action" value="update" />
 	</p>
 </form>
</div>
<?php
	echo "";
?>