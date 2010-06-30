<?php
$box = '
<div id="acc-box">
<form id="accshort" name="accshort"  action="">

				<label class ="ss_label" for="acc_first">Opened: 
			<input tabindex="25" type="text" class="ss_input" name="acc_first" id="acc_first" size="4" maxlength="4" value="" />					
			<a href="#base_info_first" class="ss_tool" style="padding: 2px 8px;"> ? </a></label>
        <div id ="base_info_first" class="info_box" style="display:none;">
                       <h3>field: Opened first info </h3>
                        The accordion count starts at 0<br />
                        To have the second item open by default<br />
                        You would enter 1
                        </div>			
					
					
			<label class ="ss_label" for="acc_all">
			<input tabindex="26" name="acc_all" id="acc_all" type="checkbox" /> All opened </label> 
			
			<label class ="ss_label" for="acc_mode">
			<input tabindex="27" name="acc_mode" id="acc_mode" type="checkbox" /> Single Open on
			<a href="#base_info_single" class="ss_tool" style="padding: 2px 8px;"> ? </a></label>
        <div id ="base_info_single" class="info_box" style="display:none;">
                       <h3>field: Single open info </h3>
                        With single open set on<br />
                        Only one tab can be opened at a time.
                        </div>	
	
			<label class ="ss_label" for="acc_opacity">
			<input tabindex="24" name="acc_opacity" id="acc_opacity" type="checkbox" /> Transition opacity</label> 
			
		
        <br style="clear:both;" />
        <div class="ss-acc-advanced" style="display: none;">
			<div>	
			
			<label class ="ss_label" for="acc_height">
			<input tabindex="22" name="acc_height" id="acc_height" type="checkbox" /> Transition height</label>

            <label class ="ss_label" for="acc_width">
			<input tabindex="23" name="acc_width" id="acc_width" type="checkbox" /> Transition width</label> 
		
			<label class ="ss_label" for="fixheight">Fixed height: 
			<input tabindex="20" type="text" class="ss_input" name="fixheight" id="fixheight" size="4" maxlength="4" value="" /> px.</label> 
			
			<label class ="ss_label" for="fixwidth">Fixed width:
			<input tabindex="21" type="text" class="ss_input" name="fixwidth" id="fixwidth" size="4" maxlength="4" value="" /> px.</label>
			
				

		<div style=" padding: 10px; clear: left;">
		<a href="" class="ss-toggler-close" >close</a>
	</div>
				</div></div>
				
			<input type="button" tabindex="28" value="Add Accordion" name="acctotextfield" id="acctotextfield" class="button-primary action" style="margin:10px 40px 0 10px; float: right;" onclick="addacc(); return false;" />

<div id="ss-toggler-holder" style=" padding: 10px; clear: left;">
		<a href="" class="ss-toggler-open" >advanced</a>
</div>			

			<input name="acc_togtag" id="acc_togtag" type="hidden" value="'.$acc_togtag.'" />
			<input name="acc_elemtag" id="acc_elemtag" type="hidden" value="'.$acc_elemtag.'" />
</form>
<br style="clear:both;" /><p>This shortcode helper presently only works for the Html view.</p>
</div>
';
?>