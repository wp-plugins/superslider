<?php
$box = '
<form id="accshort" name="accshort"  action="">
			
			
			<label class ="ss_label" for="fixheight">Fixed height: 
			<input tabindex="20" type="text" class="ss_input" name="fixheight" id="fixheight" size="4" maxlength="4" value="" /> px.</label> 
			
			<label class ="ss_label" for="fixwidth">Fixed width:
			<input tabindex="21" type="text" class="ss_input" name="fixwidth" id="fixwidth" size="4" maxlength="4" value="" /> px.</label>
			
			<label class ="ss_label" for="acc_height">
			<input tabindex="22" name="acc_height" id="acc_height" type="checkbox" value="true" /> Transition height</label>
			
		<div class="ss-scroll-advanced" style="display: none;">
		<div>
		
			<label class ="ss_label" for="acc_width">
			<input tabindex="23" name="acc_width" id="acc_width" type="checkbox" value="true" /> Transition width</label> 
			
			<label class ="ss_label" for="acc_opacity">
			<input tabindex="24" name="acc_opacity" id="acc_opacity" type="checkbox" value="true" /> Transition opacity</label> 
			
			<label class ="ss_label" for="acc_first">Opened: 
			<input tabindex="25" type="text" class="ss_input" name="acc_first" id="acc_first" size="4" maxlength="4" value="" /> 0 = first</label>			
			
			<label class ="ss_label" for="acc_all">
			<input tabindex="26" name="acc_all" id="acc_all" type="checkbox" value="" /> All opened at start</label> 
			
			<div style=" padding: 10px; clear: left;">
		<a href="" class="ss-toggler-close" >close</a>
	</div>
</div></div>
				
			<input type="button" tabindex="27" value="Add Accordion" name="acctotextfield" id="acctotextfield" class="button-primary action" style="margin:10px 40px 0 10px; float: right;" onclick="addacc(); return false;" />
	
	   <div id="ss-toggler-holder" style=" padding: 10px; clear: left;">
	<a href="" class="ss-toggler-open" >advanced</a>
</div>		

			<input name="acc_togtag" id="acc_togtag" type="hidden" value="'.$acc_togtag.'" />
			<input name="acc_elemtag" id="acc_elemtag" type="hidden" value="'.$acc_elemtag.'" />
</form>
<br style="clear:both;" /><p>This shortcode helper presently only works for the Html view. </p>

';
?>