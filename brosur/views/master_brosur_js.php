
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
				alert('File max 5MB!');
			} else {
				$.ajax({
				url: $('#form_create_'+grid).attr('action'),
				type: 'post',
				data: $('#form_create_'+grid).serialize(),
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
							if(isUpload) {
								var iframe = $('<iframe name="master_brosur_frame"/>');
								iframe.attr({'id':'master_brosur_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target','master_brosur_frame');								
								$('#form_create_'+grid).submit();
							}
							_custom_alert(o.message,header,info, grid, 1, 20000);
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

		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {


		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File max 5MB!');
			} else {

				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					//alert(data);											
					var o = $.parseJSON(data);
					var info = 'Info';
					var header = 'Info';
					
					if(isUpload) {

						var iframe = $('<iframe name="master_brosur_frame"/>');
						iframe.attr({'id':'master_brosur_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						formAction+='&isUpload=1';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						formAction+='&company_id='+o.company_id;
						
						//alert(formAction);
						
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','master_brosur_frame');								
						$('#form_update_'+grid).submit();
					}
					_custom_alert(o.message,header,info, grid, 1, 20000);
					$('#grid_'+grid).trigger('reloadGrid');
				}
			})
			
		}
	})	

}
}


	
</script>
<iframe name="master_brosur_frame" id="master_brosur_frame" height="0" width="0"></iframe>