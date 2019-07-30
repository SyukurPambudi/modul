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
		//$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		$.ajax({
			url:base_url+'processor/plc/product/trial/stabilita/pilot?action=cekstabilita',
			type:'post',
			data: $('#form_create_product_trial_stabilita_pilot').serialize(),
			success: function(data) {
				var c = $.parseJSON(data);
				if(c.status==false){
					_custom_alert(c.message,'Info','Info', grid, 1, 20000);
					return false;
				}else{
					custom_confirm(comfirm_message,function(){
						if(isUpload && !isValidAFileSize('#form_create_'+grid+' input.multifile', uploadLimit)) {
							alert('File maks 5MB!');
						} else {
							$.ajax({
							url: $('#form_create_'+grid).attr('action'),
							type: 'post',
							data: $('#form_create_'+grid).serialize(),
							success: function(data) {
								var o = $.parseJSON(data);
								var info = 'Info';
								var header = 'Info';
								var last_id = o.last_id;
								var company_id = o.company_id;
								var group_id = o.group_id;
								var modul_id = o.modul_id;
									if(o.status == true){
										if(isUpload) {
											var iframe = $('<iframe name="product_trial_stabilita_pilot_frame"/>');
											iframe.attr({'id':'product_trial_stabilita_pilot_frame'});
											$('#form_create_'+grid).parent().append(iframe);
											
											var formAction = $('#form_create_'+grid).attr('action');
											formAction+='&isUpload=1';
											formAction+='&lastId='+o.last_id;
											formAction+='&uploadLimit='+uploadLimit;
											formAction+='&company_id='+o.company_id;
											
											$('#form_create_'+grid).attr('action',formAction);
											$('#form_create_'+grid).attr('target','product_trial_stabilita_pilot_frame');								
											//$('#form_create_'+grid).submit();
											uploadfile('form_create_'+grid, grid, formAction, base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);

										}else{
											_custom_alert(o.message,header,info, grid, 1, 20000);
											$('#grid_'+grid).trigger('reloadGrid');
											info = 'info';
											header = 'Info';
											
											$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
								
							})/*
							.done(function(data) {
								var o = $.parseJSON(data);
								var last_id = o.last_id;
								var company_id = o.company_id;
								var group_id = o.group_id;
								var modul_id = o.modul_id;
								var foreign_id = o.foreign_id;
								
								$('#grid_'+grid).trigger('reloadGrid');
									info = 'info';
									header = 'Info';
									
									$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
				                            $('div#form_'+grid).html(data);
				                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
				                    });
							});*/
						}
					})
				}
			}
		});
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

							var iframe = $('<iframe name="product_trial_stabilita_lab_frame"/>');
							iframe.attr({'id':'product_trial_stabilita_lab_frame'});
							$('#form_update_'+grid).parent().append(iframe);
									
							var formAction = $('#form_update_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
									
									
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','product_trial_stabilita_lab_frame');								
							//$('#form_update_'+grid).submit();
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
						}else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');	

							$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
			})/*
			.done(function(data) {
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						
						$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});*/
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
							var iframe = $('<iframe name="product_trial_stabilita_pilot_frame"/>');
							iframe.attr({'id':'product_trial_stabilita_pilot_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							//alert(formAction);
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','product_trial_stabilita_pilot_frame');
							
							//$('#form_update_'+grid).submit();	
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);							
						 }else{
						_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
						$('#grid_'+grid).trigger('reloadGrid');
							info = 'info';
							header = 'Info';
							
							$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
				})/*
				.done(function(data) {
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					
					$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						
						$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
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
				$.get(base_url+'processor/plc/product/trial/stabilita/pilot?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                        $('div#form_'+grid).html(data);
                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                });
			}		
		});
	});
}	
</script>
<iframe name="product_trial_stabilita_pilot_frame" id="product_trial_stabilita_pilot_frame" height="0" width="0"></iframe>
