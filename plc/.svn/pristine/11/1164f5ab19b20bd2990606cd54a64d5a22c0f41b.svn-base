<script>
function save_draft_btn_multiupload(grid, url, dis, isdraft) {
	var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_create_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	var isTam=1;
	
	$('#table_komposisi_sas input[type=text]').each(function() {
		var name = this.name;
		if (name == 'name_kom_bahan[]') {
			if(this.value!=''){
				tempobahan++;
			}
		}
	});
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
							_custom_alert(o.message,header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
							
							$('#grid_'+grid).trigger('reloadGrid');
							$.get(base_url+'processor/plc/permintaan/komparator?action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
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
	var isTam=1;
	
	$('#table_komposisi_sas input[type=text]').each(function() {
		var name = this.name;
		if (name == 'name_kom_bahan[]') {
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
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
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
					if(o.status==true){
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;
							
							_custom_alert(o.message,header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							
							$('#grid_'+grid).trigger('reloadGrid');
							$.get(base_url+'processor/plc/permintaan/komparator?action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});

					}else{
						_custom_alert(o.message,header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
						return;
					}
				}
					
				})
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
	isTam=1;
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
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if (o.status==true){
						_custom_alert('Data Berhasil Update!',header,info, grid, 1, 20000);
						$('#grid_'+grid).trigger('reloadGrid');	
						var o = $.parseJSON(data);
						var last_id = o.last_id;
						var company_id = o.company_id;
						var group_id = o.group_id;
						var modul_id = o.modul_id;
						var foreign_id = o.foreign_id;
					
						$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						o = $.parseJSON(data);
						last_id = o.last_id;
						group_id = o.group_id;
						company_id = o.company_id;
						modul_id = o.modul_id;
						$.get(base_url+'processor/plc/permintaan/komparator?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                        $('div#form_'+grid).html(data);
	                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });

					}
					else{
						_custom_alert(o.message,header,info, grid, 1, 20000);
						info = 'info';
						header = 'Info';
						last_id = o.last_id;
						group_id = o.group_id;
						company_id = o.company_id;
						modul_id = o.modul_id;
					}
				}
			})
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
					
					//alert(isUpload);
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
					$('#grid_'+grid).trigger('reloadGrid');
					}
				})
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
						
						$.get(base_url+'processor/plc/permintaan/komparator?action=view&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});
	  		 }	
			
	})		
}
}

	
</script>
<iframe name="sas_dokumen_frame" id="sas_dokumen_frame" height="0" width="0"></iframe>
