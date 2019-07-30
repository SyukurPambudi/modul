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
	if(conf > 0) {
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

							var iframe = $('<iframe name="kelengkapan_dokumen4_export_frame"/>');
							iframe.attr({'id':'kelengkapan_dokumen4_export_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
							
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target','kelengkapan_dokumen4_export_frame');

							//import_uji_labs_tryUPload('form_update_'+grid , grid, formAction, base_url+'processor/plc/study/literatur/ad?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id );
							uploadfile('form_update_'+grid, grid, formAction, base_url+'processor/plc/kelengkapan/dokumen4/export?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
						
						}else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
						}
						$('#grid_'+grid).trigger('reloadGrid');
						$('div#form_'+grid).html("");
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

function setuju(grid, url, dis, updno, idrev){
	custom_confirm('Anda Yakin Release UPD : '+updno,function(){
		$.ajax({
			url: url,
			type: 'post',
			data: 'idreview='+idrev,
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
				$.get(base_url+'processor/plc/kelengkapan/dokumen4/export?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                        $('div#form_'+grid).html(data);
                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                });
			}		
		});
	});
}

function uploadfile(formgrid, grid, formAction, url){
	var obj = $('#'+formgrid);
	var j=0;	
	var x=1;					   
    var formData = new FormData();
    $.each($(obj).find("input[type='file']"), function(i, tag) {
        $.each($(tag)[0].files, function(i, file) {
        	if(x<=20){
	            formData.append(tag.name, file);
	            j += file.size;
            }
            
        });
        x++;
    }); 
    if(j>=100000000){
    	_custom_alert("Maximal keselurah size upload 100MB, Mohon Upload secara bertahap!",'info','info', grid, 1, 20000);
    	return false;
    }
    if(x>=1000000){
    	alert("Jumlah upload file melebihi 20, file yang akan di simpan 20 file teratas!");
    }
    var params = $(obj).serializeArray();
    $.each(params, function (i, val) {
        formData.append(val.name, val.value);
    });
   
    //return false;
    waitDialog("Waiting... Upload File...");
	$.ajax({
   		url: formAction,  
   		type: 'POST',
   		xhr: function() {  // Custom XMLHttpRequest
	   	    var myXhr = $.ajaxSettings.xhr();
	   	    if(myXhr.upload){ // Check if upload property exists
	   	        myXhr.upload.addEventListener('progress',progress, false); 
	   	    }
	   	    return myXhr;
	   	}, 						
   		success: function(data) {
   				//var o = $.parseJSON(data);	
   				$(".Dialog").dialog('close');															
				_custom_alert('Data Berhasil Disimpan !','info','info', grid, 1, 20000);
				$.get(url, function(data) {
					$('div#form_'+grid).html(data);
					$('#grid_'+grid).trigger('reloadGrid');
				});
   		},
   		// Form data
   		data: formData,
   		cache: false,
   		contentType: false,
   		processData: false
   	});
}

function progress(e){
	if(e.lengthComputable){
        $('#progress').attr({value:e.loaded,max:e.total});
    }
}
function waitDialog(h3=''){
	console.log('RaidenArmy');
	$(".Dialog").dialog({
		title: "Uploading File...",
		autoOpen: true, 
       	resizable: false,
       	height:350,
       	width:350,
		hide: {
			effect: "explode",
			duration: 500
		},
       	modal: true,
		open:function(){
		 	h2 = (h3 == "") ? "Proccess Uploading ..." : h3; 
		 	$("#h3").html(h2);
		},
		close : function(){
			$(this).dialog("destroy");
		}
    });	
}

	
</script>
<iframe name="kelengkapan_dokumen4_export_frame" id="kelengkapan_dokumen4_export_frame" height="0" width="0"></iframe>
