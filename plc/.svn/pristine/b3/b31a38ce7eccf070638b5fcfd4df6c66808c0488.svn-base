<script>
function save_draft_btn_multiupload(grid, url, dis, isdraft) {
	var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_create_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;

	if(isUpload) {
		uploadLimit = 5242880;
	}

	
	if(isdraft != undefined) {
		$('#form_create_'+grid+' #isdraft').val(isdraft);
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
	}else {
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
						if(o.status == true) {
							if(isUpload) {
								var iframe = $('<iframe name="sas_dokumen_frame"/>');
								iframe.attr({'id':'sas_dokumen_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','sas_dokumen_frame');								
								$('#form_create_'+grid).submit();
							}
							_custom_alert(o.message,header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
							
							$('#grid_'+grid).trigger('reloadGrid');
							$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});
							
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
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
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
						if (o.status==true){
							if(isUpload) {
								var iframe = $('<iframe name="sas_dokumen_frame"/>');
								iframe.attr({'id':'sas_dokumen_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','sas_dokumen_frame');								
								$('#form_create_'+grid).submit();
							}
							_custom_alert(o.message,header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
							
							$('#grid_'+grid).trigger('reloadGrid');
							$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});	
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

function update_draft_1(grid, url, dis, isdraft) {
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
		$.ajax({
			url: base_url+'processor/plc/dokumen/dt/sas?action=cekupd',
			type: 'post',
			data: $('#form_update_'+grid).serialize(),
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.status==true){
					custom_confirm(comfirm_message,function(){
						if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
						} else {				
							$.ajax({
								url: $('#form_update_'+grid).attr('action'),
								type: 'post',
								data: $('#form_update_'+grid).serialize()+'&update=1',
								success: function(data) {
									var o = $.parseJSON(data);
									var info = 'Info';
									var header = 'Info';
								
									if(isUpload) {
										var iframe = $('<iframe name="sas_dokumen_frame"/>');
										iframe.attr({'id':'sas_dokumen_frame'});
										$('#form_update_'+grid).parent().append(iframe);
												
										var formAction = $('#form_update_'+grid).attr('action');
											formAction+='&isUpload=1';
											formAction+='&lastId='+o.last_id;
											formAction+='&uploadLimit='+uploadLimit;
											formAction+='&company_id='+o.company_id;
											formAction+='&isdraft='+isdraft;
												
												
										$('#form_update_'+grid).attr('action',formAction);
										$('#form_update_'+grid).attr('target','sas_dokumen_frame');								
										$('#form_update_'+grid).submit();
									}
									_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
									$('#grid_'+grid).trigger('reloadGrid');	
									$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
				                        $('div#form_'+grid).html(data);
				                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
				                	});				
								}
								
							})
						
						}
					})	
				}else{
					var info = 'error';
					var header = 'error';
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
			}		
		});


			
}
}

function update_btn_1(grid, url, dis) {
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
		$.ajax({
			url: base_url+'processor/plc/dokumen/dt/sas?action=cekupd',
			type: 'post',
			data: $('#form_update_'+grid).serialize(),
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.status==true){
					custom_confirm(comfirm_message,function(){
						if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
							alert('File maks 5MB!');
						} 
						else{
							$.ajax({
							url: $('#form_update_'+grid).attr('action'),
							type: 'post',
							data: $('#form_update_'+grid).serialize()+'&update=1',
							success: function(data) {
								var o = $.parseJSON(data);
								var info = 'Info';
								var header = 'Info';
								if(isUpload > 0) {								
									var iframe = $('<iframe name="sas_dokumen_frame"/>');
									iframe.attr({'id':'sas_dokumen_frame'});
									$('#form_update_'+grid).parent().append(iframe);
									
									var formAction = $('#form_update_'+grid).attr('action');
									formAction+='&isUpload=1';
									formAction+='&lastId='+o.last_id;
									formAction+='&uploadLimit='+uploadLimit;
									formAction+='&company_id='+o.company_id;
									$('#form_update_'+grid).attr('action',formAction);
									$('#form_update_'+grid).attr('target','sas_dokumen_frame');
									
									$('#form_update_'+grid).submit();								
								 }
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$('#grid_'+grid).trigger('reloadGrid');	
								$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                        $('div#form_'+grid).html(data);
			                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                	});		
								}
							})
				  		 }	
						
					})
			}else{
					var info = 'error';
					var header = 'error';
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
			}		
		});

}
}

function update_draft_2(grid, url, dis, isdraft) {
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
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
			} else {				
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize()+'&update=2',
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload) {

							var iframe = $('<iframe name="dokumen_dt_sas_frame"/>');
							iframe.attr({'id':'dokumen_dt_sas_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
							
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','dokumen_dt_sas_frame');

							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
							
						}else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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


function update_btn_2(grid, url, dis) {
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
				data: $('#form_update_'+grid).serialize()+'&update=2',
				success: function(data) {
					
					//alert(isUpload);
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload > 0) {								
							var iframe = $('<iframe name="'+grid+'_frame"/>');
							iframe.attr({'id':grid+'_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target',grid+'_frame');
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
							
						 }else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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

function update_draft_3(grid, url, dis, isdraft) {
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
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
			} else {				
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize()+'&update=3',
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload) {

							var iframe = $('<iframe name="dokumen_dt_sas_frame"/>');
							iframe.attr({'id':'dokumen_dt_sas_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
							
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','dokumen_dt_sas_frame');

							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
							
						}else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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


function update_btn_3(grid, url, dis) {
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
				data: $('#form_update_'+grid).serialize()+'&update=3',
				success: function(data) {
					
					//alert(isUpload);
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true){
						if(isUpload > 0) {								
							var iframe = $('<iframe name="'+grid+'_frame"/>');
							iframe.attr({'id':grid+'_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target',grid+'_frame');
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
							
						 }else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
function setuju1(grid, url, dis, id, no){
	var dkirim_bpom=$('#dokumen_dt_sas_dkirim_bpom').val();
	$('#dokumen_dt_sas_dkirim_bpom').removeClass('error_text');
	if(dkirim_bpom==''){
		_custom_alert("Tanggal Kirim BPOM Required!",'Info','Info', grid, 1, 20000);
		$('#dokumen_dt_sas_dkirim_bpom').addClass('error_text');
		return false;
	}else{
		custom_confirm('Anda Yakin Accept Dokumen Tambahan : '+no,function(){
			$.ajax({
				url: url,
				type: 'post',
				data: 'grid='+grid+'&id='+id+'&dkirim_bpom='+dkirim_bpom,
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
					$.get(base_url+'processor/plc/dokumen/dt/sas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
	                        $('div#form_'+grid).html(data);
	                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                });
				}		
			});
		});
	}
}
	
</script>
<iframe name="sas_dokumen_frame" id="sas_dokumen_frame" height="0" width="0"></iframe>
