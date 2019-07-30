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
		$('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File max 5MB!');
			} else {
				var urlx = ($('#form_update_'+grid).attr('action')).replace('updateproses', 'update');
				$.ajax({
				url: $('#form_update_'+grid).attr('action'),
				type: 'post',
				data: $('#form_update_'+grid).serialize(),
				success: function(data) {
					//alert(isUpload);
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					var info = 'Info';
					var header = 'Info';
					if(isUpload > 0) {				
						//alert('tes');								
						var iframe = $('<iframe name="bahan_baku_rls_frame"/>');
						iframe.attr({'id':'bahan_baku_rls_frame'});
						$('#form_update_'+grid).parent().append(iframe);
						
						var formAction = $('#form_update_'+grid).attr('action');
						formAction+='&isUpload=1';
						formAction+='&lastId='+o.last_id;
						formAction+='&uploadLimit='+uploadLimit;
						formAction+='&company_id='+o.company_id;
						//alert(formAction);
						$('#form_update_'+grid).attr('action',formAction);
						$('#form_update_'+grid).attr('target','bahan_baku_rls_frame');
						
						$('#form_update_'+grid).submit();								
					 }
					_custom_alert(o.message,header,info, grid, 1, 20000);
					}
				})/*.done(function(data) {
					var o = $.parseJSON(data);
					var last_id = o.last_id;
					
					$('#grid_'+grid).trigger('reloadGrid');
						info = 'info';
						header = 'Info';
						if(urlx.indexOf('?') === -1) {
                            urlx = urlx+'?&id='+last_id;
                        } else {
							urlx = urlx+'&id='+last_id;
                        }
						//alert(urlx);
						$.get(urlx, function(data) {
						//$.get(base_url+'processor/plc/bahan/baku/release/bb?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
	                            $('div#form_'+grid).html(data);
	                            $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
	                    });
				});*/
	  		 }		
	 	 })
	 	}
	}


	
</script>
<iframe name="bahan_baku_rls_frame" id="bahan_baku_rls_frame" height="0" width="0">
</iframe>
