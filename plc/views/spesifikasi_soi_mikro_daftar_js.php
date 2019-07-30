
<script>
function save_draft_btn_multiupload(grid, url, dis, isdraft) {
	//alert(grid);
	//return false;
	
	var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	//var uploadField = $('#'+grid+'_fileupload');
	var uploadField = $('#form_create_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	//alert('Is Upload : '+isUpload+' = > '+uploadField.val());
	if(isUpload) {
		uploadLimit = 50000000000;//$('#'+grid+'_fileupload').attr('limit');
	}

	var isdraft = isdraft;
	if(isdraft != undefined) {
		$('#form_create_'+grid+' #isdraft').val( isdraft );
	}
	$.each(req, function(i,v){
		$(this).removeClass('error_text');
		if($(this).val() == '') {
			var id = $(this).attr('id');
			var label = $("label[for='"+id+"']").text();
			label = label.replace('*','');
			alert_message += '<br /><b>'+label+'</b> '+required_message;			
			$(this).addClass('error_text');			
			conf++;
		}		
	})
	
	if(conf > 0) {
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidFileSize('#form_create_'+grid+' input.multifile', uploadLimit)) {
				alert('File limit!');
			} else {
				$.ajax({
					url: $('#form_create_'+grid).attr('action'),
					type: 'post',
					data: $('#form_create_'+grid).serialize(),
					success: function(data) {	
						var o = $.parseJSON(data);												
						var info = 'Error';
						var header = 'Error';		
						if(o.status == true) {
							if(isUpload) {
								var iframe = $('<iframe name="upb_daftar_frame"/>');
								iframe.attr({'id':'upb_daftar_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','upb_daftar_frame');								
								$('#form_create_'+grid).submit();
							}
						
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
							
							//alert(url)
								$.get(base_url+'processor/plc/spesifikasi/soi/mikrobiologi?action=create&foreign_key=&company_id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                                $('div#grid_wraper_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});
						}
						
					}
				})
			}
		})
	}		
}

function save_btn_multiupload(grid, url, dis) {
	var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_create_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isUpload) {
		uploadLimit = 50000000000;
	}
	
	$.each(req, function(i,v){
		$(this).removeClass('error_text');
		if($(this).val() == '') {
			var id = $(this).attr('id');
			var label = $("label[for='"+id+"']").text();
			label = label.replace('*','');
			alert_message += '<br /><b>'+label+'</b> '+required_message;			
			$(this).addClass('error_text');			
			conf++;
		}		
	})
	if(conf > 0) {
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidFileSize('#form_create_'+grid+' input.multifile', uploadLimit)) {
				alert('File limit!');
			} else {
				$.ajax({
				url: $('#form_create_'+grid).attr('action'),
				type: 'post',
				data: $('#form_create_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Error';
					var header = 'Error';
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					if(isUpload) {
								var iframe = $('<iframe name="upb_daftar_frame"/>');
								iframe.attr({'id':'upb_daftar_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','upb_daftar_frame');								
								$('#form_create_'+grid).submit();
							}
						
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
						
						//$('#form_create_'+grid)[0].reset();
						info = 'info';
						header = 'Info';
					}
					//_custom_alert(o.message,header,info, grid, 1, 20000);
				})
			}
		})
	}		
}

function update_draft_btn(grid, url, dis, isdraft) {
	//alert(grid);
	//return false;
	
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	//var uploadField = $('#'+grid+'_fileupload');
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	//alert('Is Upload : '+isUpload+' = > '+uploadField.val());
	if(isUpload) {
		uploadLimit = 50000000000;//$('#'+grid+'_fileupload').attr('limit');
	}

	var isdraft = isdraft;
	if(isdraft != undefined) {
		$('#form_update_'+grid+' #isdraft').val( isdraft );
	}
	$.each(req, function(i,v){
		$(this).removeClass('error_text');
		if($(this).val() == '') {
			var id = $(this).attr('id');
			var label = $("label[for='"+id+"']").text();
			label = label.replace('*','');
			alert_message += '<br /><b>'+label+'</b> '+required_message;			
			$(this).addClass('error_text');			
			conf++;
		}		
	})
	
	if(conf > 0) {
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File limit!');
			} else {
				$.ajax({
					url: $('#form_update_'+grid).attr('action'),
					type: 'post',
					data: $('#form_update_'+grid).serialize(),
					success: function(data) {	
						var o = $.parseJSON(data);												
						var info = 'Error';
						var header = 'Error';		
						if(o.status == true) {
							if(isUpload) {
								var iframe = $('<iframe name="upb_daftar_frame"/>');
								iframe.attr({'id':'upb_daftar_frame'});
								$('#form_update_'+grid).parent().append(iframe);
								
								var formAction = $('#form_update_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_update_'+grid).attr('action',formAction);
								$('#form_update_'+grid).attr('target','upb_daftar_frame');								
								$('#form_update_'+grid).submit();
							}
						
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
							
							//alert(url)
							$.get(base_url+'processor/plc/spesifikasi/soi/mikrobiologi?action=create&foreign_key=&company_id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                                $('div#grid_wraper_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});
						}
					
					}
				})
			}
		})
	}		
}

function update_btn(grid, url, dis) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isUpload) {
		uploadLimit = 50000000000;
	}
	$.each(req, function(i,v){
		$(this).removeClass('error_text');
		if($(this).val() == '') {
			var id = $(this).attr('id');
			var label = $("label[for='"+id+"']").text();
			label = label.replace('*','');
			alert_message += '<br /><b>'+label+'</b> '+required_message;			
			$(this).addClass('error_text');			
			conf++;
		}		
	})
	if(conf > 0) {
		//$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Error';
					var header = 'Error';
					if(o.status == true) {
						//$('#form_update_'+grid)[0].reset();
						info = 'info';
						header = 'Info';
					}
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
			})
		})
	}		
}

function update_btn_back(grid, url, dis) {
	var req = $('#form_update_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isUpload) {
		uploadLimit = 50000000000;
	}
	
	$.each(req, function(i,v){
		$(this).removeClass('error_text');
		if($(this).val() == '') {
			var id = $(this).attr('id');
			var label = $("label[for='"+id+"']").text();
			label = label.replace('*','');
			alert_message += '<br /><b>'+label+'</b> '+required_message;			
			$(this).addClass('error_text');			
			conf++;
		}		
	})
	if(conf > 0) {
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File limit!');
			} else {
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Error';
					var header = 'Error';
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					if(isUpload) {
								var iframe = $('<iframe name="upb_daftar_frame"/>');
								iframe.attr({'id':'upb_daftar_frame'});
								$('#form_update_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_update_'+grid).attr('action',formAction);
								$('#form_update_'+grid).attr('target','upb_daftar_frame');								
								$('#form_update_'+grid).submit();
							}
						
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
						
						$('#form_update_'+grid)[0].reset();
						info = 'info';
						header = 'Info';
					}
					//_custom_alert(o.message,header,info, grid, 1, 20000);
			})
		}
	})		
}
}


	
</script>
<iframe name="upb_daftar_frame" id="upb_daftar_frame" height="0" width="0"></iframe>