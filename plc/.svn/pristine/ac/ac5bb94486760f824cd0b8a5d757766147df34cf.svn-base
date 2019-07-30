
<script>
function save_btn_multiupload(grid, url, dis) {
	var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_create_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isUpload) {
		uploadLimit = 5242880;
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
			if(isUpload && !isValidAFileSize('#form_create_'+grid+' input.multifile', uploadLimit)) {
				alert('File Size Max 5MB!');
			} else {
				$.ajax({
				url: $('#form_create_'+grid).attr('action'),
				type: 'post',
				data: $('#form_create_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Error';
					var header = 'Error';
							if(isUpload) {
								var iframe = $('<iframe name="mikro_fg_frame"/>');
								iframe.attr({'id':'mikro_fg_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','mikro_fg_frame');								
								$('#form_create_'+grid).submit();
							}
							_custom_alert(o.message,header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');
					}		
			})
			/*.done(function(data) {
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					
					info = 'info';
						header = 'Info';
						$('#grid_'+grid).trigger('reloadGrid');
						
						$.get(base_url+'processor/plc/spesifikasi/soi/mikrobiologi?action=update&foreign_key='+foreign_id+'&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                        $('div#form_'+grid).html(data);
	                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                  });
				});*/
			}
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
	
	//alert(isUpload);
	if(isUpload) {
		uploadLimit = 5242880;
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
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File Size Max 5MB!');
			} else {
				//alert($('#form_update_'+grid).attr('action'));
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
										
					var o = $.parseJSON(data);
					//alert(o);
					var info = 'Error';
					var header = 'Error';
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					//alert('aa : '+isUpload);
					if(isUpload) {
						var iframe = $('<iframe name="mikro_fg_frame"/>');
						iframe.attr({'id':'mikro_fg_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						formAction+='&isUpload=1';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						formAction+='&company_id='+o.company_id;
						
						//alert(formAction);
						
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','mikro_fg_frame');								
						$('#form_update_'+grid).submit();
					}
					_custom_alert(o.message,header,info, grid, 1, 20000);
					$('#grid_'+grid).trigger('reloadGrid');	
				}
					//_custom_alert(o.message,header,info, grid, 1, 20000);
			})
			/*.done(function(data) {
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					
					info = 'info';
						header = 'Info';
						$('#grid_'+grid).trigger('reloadGrid');
						
					$.get(base_url+'processor/plc/spesifikasi/soi/mikrobiologi?action=update&foreign_key='+foreign_id+'&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});*/
		}
	})		
}
}	
</script>
<iframe name="mikro_fg_frame" id="mikro_fg_frame" height="0" width="0"></iframe>