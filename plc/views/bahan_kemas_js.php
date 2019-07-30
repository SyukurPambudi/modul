<script>
function save_draft_btn_multiupload(grid, url, dis, isdraft) {
	//alert(isdraft);
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
		uploadLimit = 5242880;//$('#'+grid+'_fileupload').attr('limit');
	}

	
	if(isdraft != undefined) {
		//alert(isdraft);
		$('#form_create_'+grid+' #isdraft').val(isdraft);
		//alert($('#form_create_'+grid+' #isdraft').val());
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

	var j_p=0;
	var j_k=0;
	$(".pertama").each(function(){
		j_p +=1;
	});
	$(".kedua").each(function(){
		j_k +=1;
	});
	if(j_p==0){
		alert_message += '<br /><b>Upload File Primer</b> Upload File Primer Minimal 1';
		conf++;
	}
	if(j_k==0){
		alert_message += '<br /><b>Upload File Sekunder</b> Upload File Sekunder Minimal 1';
		conf++;
	}

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
						if(o.status == true) {
							if(isUpload) {
								var iframe = $('<iframe name="bahan_kemas_frame"/>');
								iframe.attr({'id':'bahan_kemas_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','bahan_kemas_frame');

								uploadfile('form_create_'+grid, grid, formAction, base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);							    

								//study_literatur_pd_tryUPload('form_create'+grid , grid, formAction, base_url+'processor/plc/study/literatur/pd?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id );
							
							}else{
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
function save_btn_multiupload(grid, url, dis) {
	var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_create_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	if(isUpload) {
		uploadLimit = 15728640;
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

	var j_p=0;
	var j_k=0;
	$(".pertama").each(function(){
		j_p +=1;
	});
	$(".kedua").each(function(){
		j_k +=1;
	});
	if(j_p==0){
		alert_message += '<br /><b>Upload File Primer</b> Upload File Primer Minimal 1';
		conf++;
	}
	if(j_k==0){
		alert_message += '<br /><b>Upload File Sekunder</b> Upload File Sekunder Minimal 1';
		conf++;
	}

	if(conf > 0) {
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_create_'+grid+' input.multifile', uploadLimit)) {
				alert('File max 15MB !');
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
					var foreign_id = o.foreign_id;
					if(isUpload) {
								var iframe = $('<iframe name="bahan_kemas_frame"/>');
								iframe.attr({'id':'bahan_kemas_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','bahan_kemas_frame');	

								uploadfile('form_create_'+grid, grid, formAction, base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);						
								/*$('#form_create_'+grid).submit();
									setTimeout(function(){
									_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
									$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
				                            $('div#form_'+grid).html(data);
				                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
				                     });

								},200);*/
							}else{
								//setTimeout(function(){
									_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
									$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
				                            $('div#form_'+grid).html(data);
				                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
				                     });

								//},200);
							}
							$('#grid_'+grid).trigger('reloadGrid');
					}
				})
			}
		})
	}		
}

function update_drf(grid, url, dis, isdraft) {
	var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	var batas=$('#ibb').val();
	var xx=0; var tempobb=0;
	var batass=$('#ism').val();
	var ss=0; var temposm=0;
	
	
	//alert($('#ibb').val());
	//alert($('.dokbb').attr('checked'));
	
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

	var j_p=0;
	var j_k=0;
	$(".pertama").each(function(){
		j_p +=1;
	});
	$(".kedua").each(function(){
		j_k +=1;
	});
	if(j_p==0){
		alert_message += '<br /><b>Upload File Primer</b> Upload File Primer Minimal 1';
		conf++;
	}
	if(j_k==0){
		alert_message += '<br /><b>Upload File Sekunder</b> Upload File Sekunder Minimal 1';
		conf++;
	}

	if(conf > 0) {
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
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
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
				
					if(isUpload) {
						var iframe = $('<iframe name="bahan_kemas_frame"/>');
						iframe.attr({'id':'bahan_kemas_frame'});
						$('#form_update_'+grid).parent().append(iframe);
								
						var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
								
								
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','bahan_kemas_frame');	

						uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);							
						//$('#form_update_'+grid).submit();
						/*setTimeout(function(){
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                            $('div#form_'+grid).html(data);
			                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                     });

							},200);*/
					}else{
						_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
						$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                     });
					}
					$('#grid_'+grid).trigger('reloadGrid');				
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
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	
	//alert('a '+isUpload);
	if(isUpload) {
		uploadLimit = 15728640;
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

	var j_p=0;
	var j_k=0;
	$(".pertama").each(function(){
		j_p +=1;
	});
	$(".kedua").each(function(){
		j_k +=1;
	});
	if(j_p==0){
		alert_message += '<br /><b>Upload File Primer</b> Upload File Primer Minimal 1';
		conf++;
	}
	if(j_k==0){
		alert_message += '<br /><b>Upload File Sekunder</b> Upload File Sekunder Minimal 1';
		conf++;
	}

	if(conf > 0) {
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		//alert('tes');	
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File max 15MB!');
			} else {
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
						var info = 'Info';
						var header = 'Info';
						var last_id = o.last_id;
						var company_id = o.company_id;
						var group_id = o.group_id;
						var modul_id = o.modul_id;
						var foreign_id = o.foreign_id;
					if(isUpload){
						var o = $.parseJSON(data);
						var info = 'Info';
						var header = 'Info';
						var iframe = $('<iframe name="bahan_kemas_frame"/>');
						iframe.attr({'id':'bahan_kemas_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						formAction+='&isUpload=1';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						formAction+='&company_id='+o.company_id;
						//alert('gh'+formAction);
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','bahan_kemas_frame');	

						uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);				
						//$('#form_update_'+grid).submit();	

						/*setTimeout(function(){
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
		                            $('div#form_'+grid).html(data);
		                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		                     });

						},200);	*/

					}else{
					 	//setTimeout(function(){
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$.get(base_url+'processor/plc/bahan/kemas?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
		                            $('div#form_'+grid).html(data);
		                             $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		                     });

						//},200);
					}
					$('#grid_'+grid).trigger('reloadGrid');
				}
				})
	  		}		
	 	})
	}
}


	
</script>
<iframe name="bahan_kemas_frame" id="bahan_kemas_frame" height="0" width="0"></iframe>
