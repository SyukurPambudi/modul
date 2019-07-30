<script>
function update_btn_back(grid, url, dis) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
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
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File maks 5MB!');
			} 
			else{
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload > 0) {								
							var iframe = $('<iframe name="cek_dokumen_registrasi_frame"/>');
							iframe.attr({'id':'cek_dokumen_registrasi_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','cek_dokumen_registrasi_frame');							
						 	uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/cek/dokumen/registrasi?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
						 }
						 else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');
							info = 'info';
							header = 'Info';
							
							$.get(base_url+'processor/plc/cek/dokumen/registrasi?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
		                            $('div#form_'+grid).html(data);
		                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		                    });
	                    }
					}
					else{
						
						_custom_alert(o.message,header,info, grid, 1, 20000);
						info = 'info';
						header = 'Info';
					}
				}
				})
	  		 }	
			
	})		
}
}


function update_draft_btn(grid, url, dis, isdraft) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isdraft ==true) {
		$('#form_update_'+grid+' #isdraft').val(isdraft);
	}
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
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File maks 5MB!');
			} else {				
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload) {

							var iframe = $('<iframe name='+grid+'"_frame"/>');
							iframe.attr({'id':grid+'_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
							
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target',grid+'_frame');

							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/cek/dokumen/registrasi?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
													
							}else{
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$('#grid_'+grid).trigger('reloadGrid');
								info = 'info';
								header = 'Info';
								
								$.get(base_url+'processor/plc/cek/dokumen/registrasi?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                            $('div#form_'+grid).html(data);
			                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                    });
							}
							$('#grid_'+grid).trigger('reloadGrid');
	                }else{
						_custom_alert(o.message,header,info, grid, 1, 20000);
						info = 'info';
						header = 'Info';
					}				
				}
			})
		}
	})		
}
}	

function setuju(grid, url, dis, upbid, upbno,url2='processor/plc/cek/dokumen/registrasi?action=view',psn='Anda Yakin Confirm UPB :',upbm=true){
	if(upbm==false){
		upbno='';
	}
	custom_confirm(psn+' '+upbno+'?',function(){
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
				$.get(base_url+url2+'&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                        $('div#form_'+grid).html(data);
                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                });
			}		
		});
	});
}
</script>
<iframe name="cek_dokumen_frame" id="cek_dokumen_frame" height="0" width="0"></iframe>
