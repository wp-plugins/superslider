<script language="javascript" type="text/javascript">

	function addacc() {
		var show_code = '[accordion ';
			
		var f = document.getElementById('fixheight'); 
		if (f.value != "") {
			show_code = show_code+'acc_fixedheight="'+f.value+'" ';
			}
		var f = document.getElementById('fixwidth'); 
		if (f.value != "") {
			show_code = show_code+'acc_fixedwidth="'+f.value+'" ';
			}
		var f = document.getElementById('acc_height'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_height="'+f.value+'" ';
			}
		var f = document.getElementById('acc_width'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_width="'+f.value+'" ';
			}
		var f = document.getElementById('acc_opacity'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_opacity="'+f.value+'" ';
			}
		var f = document.getElementById('acc_first'); 
		if (f.value != "") {
			show_code = show_code+'acc_firstopen="'+f.value+'" ';
			}
		var f = document.getElementById('acc_all'); 
		if (f.checked != "") {
			f.value = 'true';
			show_code = show_code+'acc_openall="'+f.value+'" ';
			}
		var f = document.getElementById('acc_togtag');
			var g = f.value;
		var f = document.getElementById('acc_elemtag');
			var h = f.value;
		
				show_code = show_code+']\n<'+g+'>toggle one</'+g+'>\n<'+h+'>content one</'+h+'>\n<'+g+'>toggle two</'+g+'>\n<'+h+'>content two</'+h+'>\n<'+g+'>toggle three</'+g+'>\n<'+h+'>content three</'+h+'>\n[/accordion]';
				var destination1 = document.getElementById('content');
				
				if (destination1) {
					destination1.SelStart = 0;
					destination1.value += show_code;
					}
				
				/*var destination2 = content_ifr.tinymce;
				var destination2 = window.frames[0].document.getelementbyid('tinymce')
				if (destination2) {
					destination2.value += show_code;
					 alert(document.frames("content_ifr").document.getelementbyid('tinymce').value);
					}*/
			
}

</script>