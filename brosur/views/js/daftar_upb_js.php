<script type="text/javascript">
	function btn_cancel_upb(grid, url, dis) {
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
		
		
		if(isUpload) {
			uploadLimit = 5242880;
		}
		
		
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
				}
			})		
		}
	}

	
</script>
<iframe name="upb_daftar_frame" id="upb_daftar_frame" height="0" width="0"></iframe>