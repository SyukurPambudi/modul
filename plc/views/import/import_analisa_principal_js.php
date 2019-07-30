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
	
	
	var batas=$('#ibb').val();
	var xx=0; var tempobb=0;
	var batass=$('#ism').val();
	var ss=0; var temposm=0;
	var tempobahan=0;
	
	$('#table_komposisi_upb input[type=text]').each(function() {
		var name = this.name;
		if (name == 'name_kom_bahan[]') {
			//console.log(this.value);
			if(this.value!=''){
				tempobahan++;
			}
		}
	});
	
	
	for(xx=0;xx<batas;xx++){
		if($('#bb'+xx).attr('checked')){
		 tempobb++;
	 }
	}
	for(ss=0;ss<batass;ss++){
		if($('#sm'+ss).attr('checked')){
		 temposm++;
	 }
	}
	
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
	
	if(conf > 0) {
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	//else if(tempobahan==0){
		// alert('Data tidak bisa disimpan tanpa Komposisi Upb!');
		// return false;
	// }
	// else if(tempobb==0){
		 // alert('Data tidak bisa disimpan tanpa dokumen bahan baku!');
		 // return false;
	 // }
	// else if(temposm==0){
		// alert('Data tidak bisa disimpan tanpa dokumen standar mutu!');
		// return false;
	// }
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
								var iframe = $('<iframe name="upb_daftar_frame"/>');
								iframe.attr({'id':'upb_daftar_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','upb_daftar_frame');								
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
							$.get(base_url+'processor/plc/import/analisa/principal?action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});
							
						}else{

							_custom_alert(o.message,header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							o = $.parseJSON(data);
							last_id = o.last_id;
							group_id = o.group_id;
							company_id = o.company_id;
							modul_id = o.modul_id;

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
	
	var batas=$('#ibb').val();
	var xx=0; var tempobb=0;
	var batass=$('#ism').val();
	var ss=0; var temposm=0;
	var tempobahan=0;
	
	$('#table_komposisi_upb input[type=text]').each(function() {
		var name = this.name;
		if (name == 'name_kom_bahan[]') {
			//console.log(this.value);
			if(this.value!=''){
				tempobahan++;
			}
		}
	});
	//alert(tempobahan);
	//return false;
	for(xx=0;xx<batas;xx++){
		if($('#bb'+xx).attr('checked')){
		 tempobb++;
	 }
	}
	for(ss=0;ss<batass;ss++){
		if($('#sm'+ss).attr('checked')){
		 temposm++;
	 }
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
	//else if(tempobahan==0){
		// alert('Data tidak bisa disimpan tanpa Komposisi Upb!');
		// return false;
	// }
	// else if(tempobb==0){
		 // alert('Data tidak bisa disimpan tanpa dokumen bahan baku!');
		 // return false;
	 // }
	// else if(temposm==0){
		// alert('Data tidak bisa disimpan tanpa dokumen standar mutu!');
		// return false;
	// }
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
								var iframe = $('<iframe name="upb_daftar_frame"/>');
								iframe.attr({'id':'upb_daftar_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','upb_daftar_frame');								
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
							$.get(base_url+'processor/plc/import/analisa/principal?action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    	});
							
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
	var batas=$('#ibb').val();
	var xx=0; var tempobb=0;
	var batass=$('#ism').val();
	var ss=0; var temposm=0;
	
	//alert('aa'+uploadField2);
	
	for(xx=0;xx<batas;xx++){
		if($('#bb'+xx).attr('checked')){
		 tempobb++;
	 }
	}
	for(ss=0;ss<batass;ss++){
		if($('#sm'+ss).attr('checked')){
		 temposm++;
	 }
	}
	
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
				
					if(isUpload) {
						var iframe = $('<iframe name="upb_daftar_frame"/>');
						iframe.attr({'id':'upb_daftar_frame'});
						$('#form_update_'+grid).parent().append(iframe);
								
						var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
								
								
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','upb_daftar_frame');								
						$('#form_update_'+grid).submit();
					}
					_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
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
					
					$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						
						$.get(base_url+'processor/plc/upb/daftar?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});*/
		}
	})		
	}
}

function update_pilih_btn(grid, url, dis,ispilih, isdraft) {
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

	var iPrincipal_terpilih=$('#iPrincipal_terpilih').val();
	var ss=0; var temposm=0;
	
	
	//alert('aa'+uploadField2);
	
	for(xx=0;xx<batas;xx++){
		if($('#bb'+xx).attr('checked')){
		 tempobb++;
	 }
	}
	for(ss=0;ss<batass;ss++){
		if($('#sm'+ss).attr('checked')){
		 temposm++;
	 }
	}
	
	//alert($('#ibb').val());
	//alert($('.dokbb').attr('checked'));
	if(isdraft ==true) {
		//alert(isdraft);
		$('#form_update_'+grid+' #isdraft').val(isdraft);
	}
	if(ispilih ==true) {
		//alert(isdraft);
		$('#form_update_'+grid+' #ispilih').val(ispilih);
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
				
					if(isUpload) {
						var iframe = $('<iframe name="upb_daftar_frame"/>');
						iframe.attr({'id':'upb_daftar_frame'});
						$('#form_update_'+grid).parent().append(iframe);
								
						var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
								
								
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','upb_daftar_frame');								
						$('#form_update_'+grid).submit();
					}
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
						
						$.get(base_url+'processor/plc/import/analisa/principal?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            //$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});
			
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
			$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					if(o.status == true) {
						//$('#form_update_'+grid)[0].reset();
						info = 'info';
						header = 'Info';
					}
					_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
					$('#grid_'+grid).trigger('reloadGrid');
				}
			})
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
	var batas=$('#ibb').val();
	var xx=0; var tempobb=0;
	var batass=$('#ism').val();
	var ss=0; var temposm=0; var tempobahan=0; 
	
	//alert('aa'+uploadField2);
	
	for(xx=0;xx<batas;xx++){
		if($('#bb'+xx).attr('checked')){
		 tempobb++;
	 }
	}
	for(ss=0;ss<batass;ss++){
		if($('#sm'+ss).attr('checked')){
		 temposm++;
	 }
	}
	
	
	//alert('test');
	$('#table_komposisi_upb input[type=text]').each(function() {
		var name = this.name;
		if (name == 'name_kom_bahan[]') {
			//console.log(this.value);
			if(this.value!=''){
				tempobahan++;
			}
		}
	});
		
	//alert(tempobahan);
	
	//alert($('#ibb').val());
	//alert($('.dokbb').attr('checked'));
	
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
					if(isUpload > 0) {				
						//alert('tes');								
						var iframe = $('<iframe name="upb_daftar_frame"/>');
						iframe.attr({'id':'upb_daftar_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						formAction+='&isUpload=1';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						formAction+='&company_id='+o.company_id;
						//alert(formAction);
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','upb_daftar_frame');
						
						$('#form_update_'+grid).submit();								
					 }
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
						
						$.get(base_url+'processor/plc/import/analisa/principal?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            //$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});
	  		 }	
			
	})		
}
}
function btn_cancel_upb(grid, url, dis) {
	//var req = $('#form_update_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
	var conf=0;
	var alert_message = '';
	var uploadField = $('#form_update_'+grid+' input.multifile');
	var uploadLimit = 0;
	var isUpload = uploadField.length;
	var batas=$('#ibb').val();
	var xx=0; var tempobb=0;
	var batass=$('#ism').val();
	var ss=0; var temposm=0;
	
	//alert('aa'+uploadField2);
	
	for(xx=0;xx<batas;xx++){
		if($('#bb'+xx).attr('checked')){
		 tempobb++;
	 }
	}
	for(ss=0;ss<batass;ss++){
		if($('#sm'+ss).attr('checked')){
		 temposm++;
	 }
	}
	
	//alert($('#ibb').val());
	//alert($('.dokbb').attr('checked'));
	
	if(isUpload) {
		uploadLimit = 5242880;
	}
	
	// $.each(req, function(i,v){
		// $(this).removeClass('error_text');
		// if($(this).val() == '') {
			// var id = $(this).attr('id');
			// var label = $("label[for='"+id+"']").text();
			// label = label.replace('*','');
			// alert_message += '<br /><b>'+label+'</b> '+required_message;			
			// $(this).addClass('error_text');			
			// conf++;
		// }		
	// })
	if(conf > 0) {
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			//if(!isUpload) {
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
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
					if(isUpload > 0) {				
						//alert('tes');								
						var iframe = $('<iframe name="upb_daftar_frame"/>');
						iframe.attr({'id':'upb_daftar_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						formAction+='&isUpload=1';
						formAction+='&cancel=2';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						formAction+='&company_id='+o.company_id;
						
						//alert(formAction);
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','upb_daftar_frame');
						$('#form_update_'+grid).submit();
					}
					_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
				}		
			})
			/*.done(function(data) {
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					var company_id = o.company_id;
					var group_id = o.group_id;
					var modul_id = o.modul_id;
					var foreign_id = o.foreign_id;
					
					$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						
						$.get(base_url+'processor/plc/upb/daftar?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&cancel=2', function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});*/
		}
	})		
}
}

	
</script>
<iframe name="upb_daftar_frame" id="upb_daftar_frame" height="0" width="0"></iframe>
