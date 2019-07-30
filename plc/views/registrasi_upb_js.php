
<script>

function update_btn_back(grid, url, dis) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
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
	else if(($('#tambahdata').is (':checked'))&&(!$( "#divPR" ).is (':checked')) && (!$( "#divPD" ).is (':checked')) && (!$( "#divAD" ).is (':checked'))&& (!$( "#divQA" ).is (':checked')) && (!$( "#divQAM" ).is (':checked'))&& (!$( "#divQC" ).is (':checked'))&& (!$( "#divPDV" ).is (':checked'))){
		alert('Pilih salah satu divisi tujuan !')
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File maks 5MB!');
			} else {
				//alert($('#form_update_'+grid).attr('action'));
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
										
					var o = $.parseJSON(data);
					//alert(o.lastId);
					var info = 'Info';
					var header = 'Info';
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					//alert('aa : '+isUpload);
					if(isUpload) {
						var iframe = $('<iframe name="reg_upb_frame"/>');
						iframe.attr({'id':'reg_upb_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						//alert(formAction);
						formAction+='&isUpload=1';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						//formAction+='&company_id='+o.company_id;
						
						//alert(formAction);
						
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','reg_upb_frame');								
						//$('#form_update_'+grid).submit();
						uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/registrasi/upb?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
					}else{
						_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
						$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						
						$.get(base_url+'processor/plc/registrasi/upb?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
					}
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
						
					 $.get(base_url+'processor/plc/registrasi/upb?action=update&foreign_key='+foreign_id+'&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                             $('div#form_'+grid).html(data);
	                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	 });
				 });*/
		}
	})		
}
}

function setuju(grid, url, dis, upbid, upbno){
	custom_confirm('Anda Yakin Confirm UPB : '+upbno,function(){
		$.ajax({
			url: url,
			type: 'post',
			data: 'grid='+grid+'&iupb_id='+upbid,
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.status==true){
					var info = 'success';
					var header = 'success';
					_custom_alert(o.message,header,info, grid, 1, 20000);
					$('#grid_'+grid).trigger('reloadGrid');
				}else{
					var info = 'error';
					var header = 'error';
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
				$.get(base_url+'processor/plc/registrasi/upb?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                        $('div#form_'+grid).html(data);
                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                });
			}		
		});
	});
}
	
</script>
<iframe name="reg_upb_frame" id="reg_upb_frame" height="0" width="0"></iframe>