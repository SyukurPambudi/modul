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
	if($("#draft_soi_mikro_fg_vPIC_draft").val()==''){
		var label = $("label[for='draft_soi_mikro_fg_vPIC_draft']").text();
		label = label.replace('*','');
		$("#draft_soi_mikro_fg_vPIC_draft_text").addClass('error_text');
		alert_message += '<br /><b>'+label+'</b> '+required_message;	
		$("#draft_soi_mikro_fg_vPIC_draft_text").val("");
		conf++;
	}
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

							var iframe = $('<iframe name="draft_soi_mikro_fg_frame"/>');
							iframe.attr({'id':'draft_soi_mikro_fg_frame'});
							$('#form_update_'+grid).parent().append(iframe);
									
							var formAction = $('#form_update_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
									
									
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','draft_soi_mikro_fg_frame');								
							//$('#form_update_'+grid).submit();
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/draft/soi/mikro/fg?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);

						}else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');	

							$.get(base_url+'processor/plc/draft/soi/mikro/fg?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
						
						$.get(base_url+'processor/plc/draft/soi/mikro/fg?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
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
	$('#table_komposisi_sas input[type=text]').each(function() {
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
					if(o.status == true){
						if(isUpload > 0) {				
							//alert('tes');								
							var iframe = $('<iframe name="draft_soi_mikro_fg_frame"/>');
							iframe.attr({'id':'draft_soi_mikro_fg_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							//alert(formAction);
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','draft_soi_mikro_fg_frame');
							
							//$('#form_update_'+grid).submit();	
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/draft/soi/mikro/fg?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);

						 }else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');
							info = 'info';
							header = 'Info';
							
							$.get(base_url+'processor/plc/draft/soi/mikro/fg?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
						
						$.get(base_url+'processor/plc/draft/soi/mikro/fg?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});*/
	  		 }	
			
	})		
}
}	
</script>
<iframe name="draft_soi_mikro_fg_frame" id="draft_soi_mikro_fg_frame" height="0" width="0"></iframe>
