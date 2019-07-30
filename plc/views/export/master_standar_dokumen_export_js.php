<script type="text/javascript">
var urli='processor/plc/master/standar/dokumen/export';
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
					var foreign_id = o.foreign_id;
					if(o.status==true){
						if(isUpload) {
							var iframe = $('<iframe name="'+grid+'_frame"/>');
							iframe.attr({'id':grid+'_frame'});
							$('#form_create_'+grid).parent().append(iframe);
							
							var formAction = $('#form_create_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							
							$('#form_create_'+grid).attr('action',formAction);
							$('#form_create_'+grid).attr('target',grid+'_frame');								
							$('#form_create_'+grid).submit();
						}else{
							_custom_alert(o.message,header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');		
							$.get(base_url+urli+'?action=update&id='+last_id+'&foreign_key='+foreign_id+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                        $('div#form_'+grid).html(data);
		                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
		                	});
						}
					}
					else{
						_custom_alert(o.message,header,info, grid, 1, 20000);
						return false;
					}	
				}
				})
			}
		})
	}		
}
</script>