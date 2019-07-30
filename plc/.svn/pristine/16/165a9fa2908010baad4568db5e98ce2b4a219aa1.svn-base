<script>
function update_draft_btn(grid, url, dis, isdraft) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isdraft ==true) {
		//alert(isdraft);
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
		//$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
			//if(!isUpload) {
				//alert('File limit!');
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

							var iframe = $('<iframe name="coa_pilot_lab_frame"/>');
							iframe.attr({'id':'coa_pilot_lab_frame'});
							$('#form_update_'+grid).parent().append(iframe);
									
							var formAction = $('#form_update_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;	
									
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','coa_pilot_lab_frame');								
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
							//coa_pilot_lab_tryUPload('form_update_'+grid , grid, formAction, base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id );
							//$('#form_update_'+grid).submit();
							/*setTimeout(function(){
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$.get(base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                            $('div#form_'+grid).html(data);
			                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                    });

							},200);*/
						}else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$.get(base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
		                            $('div#form_'+grid).html(data);
		                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		                    });
						}
						$('#grid_'+grid).trigger('reloadGrid');
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


function update_btn_back(grid, url, dis) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	//alert("test");
	var uploadField = $('#form_update_'+grid+' input.multifile');
	//console.log(uploadField.files());
	var uploadLimit = 0;
	var isUpload = uploadField.length;

	$('#table_komposisi_sas input[type=text]').each(function() {
		var name = this.name;
		if (name == 'name_kom_bahan[]') {
			//console.log(this.value);
			if(this.value!=''){
				tempobahan++;
			}
		}
	});
	
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
	//return false;
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
			//if(!isUpload) {
				alert('File maks 5MB!');
			} 
			else{
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					
					//alert(isUpload);
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload > 0) {				
							//alert('tes');								
							var iframe = $('<iframe name="coa_pilot_lab_frame"/>');
							iframe.attr({'id':'coa_pilot_lab_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							//alert(formAction);
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','coa_pilot_lab_frame');
							/*
							$('#form_update_'+grid).submit();	
							setTimeout(function(){
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$.get(base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                            $('div#form_'+grid).html(data);
			                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                    });

							},200);*/
							//coa_pilot_lab_tryUPload('form_update_'+grid , grid, formAction, base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id );
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
						 
						 }else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							$.get(base_url+'processor/plc/coa/pilot/lab?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
		                            $('div#form_'+grid).html(data);
		                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		                    });
						}
						$('#grid_'+grid).trigger('reloadGrid');
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
				$.get(base_url+'processor/plc/coa/pilot/lab?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                        $('div#form_'+grid).html(data);
                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                });
			}		
		});
	});
}
</script>
<iframe name="coa_pilot_lab_frame" id="coa_pilot_lab_frame" height="0" width="0"></iframe>
