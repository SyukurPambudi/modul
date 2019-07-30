<?php
$grid=isset($grid)?$grid:"grid_button";
$urlpath="processor/reformulasi/export/best/formula";
?>
<script>
function save_draft_<?php echo $grid ?>(grid, url, dis, isdraft) {
	
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

	/*Cek Untuk Upload Minimal 1*/
	var nn=0;
	$.each($(".num_rows_tb_details_export_uji_mikro_fg"), function(i,v){
		nn++;
	});

	if(nn==0){
		alert_message += '<br /><b>Minimal 1 Upload File</b>';
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
								var iframe = $('<iframe name="'+grid+'_frame"/>');
								iframe.attr({'id':grid+'_frame'});
								$('#form_create_'+grid).parent().append(iframe);
								
								var formAction = $('#form_create_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;
								formAction+='&isdraft='+isdraft;
								
								$('#form_create_'+grid).attr('action',formAction);
								$('#form_create_'+grid).attr('target',grid+'_frame');

								uploadfile_<?php echo $grid ?>('form_create_'+grid, grid, formAction, base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);					
							
							}else{
								_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
								$.get(base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                        $('div#form_'+grid).html(data);
			                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                    });
			                    var  full = $("#infomodule").text().split(':');
								var part1 = full[1].split('/');
								reload_grid_new(part1[1],grid);
							}							
													
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

function save_submit_<?php echo $grid ?>(grid, url, dis) {
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

	/*Cek Untuk Upload Minimal 1*/
	var nn=0;
	$.each($(".num_rows_tb_details_export_uji_mikro_fg"), function(i,v){
		nn++;
	});

	if(nn==0){
		alert_message += '<br /><b>Minimal 1 Upload File</b>';
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
						if(o.status == true){
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

								uploadfile_<?php echo $grid ?>('form_create_'+grid, grid, formAction, base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);

							}else{
								_custom_alert(o.message,header,info, grid, 1, 20000);
								var  full = $("#infomodule").text().split(':');
								var part1 = full[1].split('/');
								reload_grid_new(part1[1],grid);
								info = 'info';
								header = 'Info';
								
								$.get(base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
					
				})
			}
		})
	}		
}

function update_draft_<?php echo $grid ?>(grid, url, dis, isdraft) {
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

	/*Cek Untuk Upload Minimal 1*/
	var nn=0;
	$.each($(".num_rows_tb_details_export_uji_mikro_fg"), function(i,v){
		nn++;
	});

	if(nn==0){
		alert_message += '<br /><b>Minimal 1 Upload File</b>';
	}

	if(conf > 0) {
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
		custom_confirm(comfirm_message,function(){
			if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {
				alert('File maks 5MB!');
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

							var iframe = $('<iframe name="'+grid+'_frame"/>');
							iframe.attr({'id':grid+'_frame'});
							$('#form_update_'+grid).parent().append(iframe);
							
							var formAction = $('#form_update_'+grid).attr('action');
							formAction+='&isUpload=1';
							formAction+='&lastId='+o.last_id;
							formAction+='&uploadLimit='+uploadLimit;
							formAction+='&company_id='+o.company_id;
							formAction+='&isdraft='+isdraft;
							
							$('#form_update_'+grid).attr('action',formAction);
							$('#form_update_'+grid).attr('target',grid+'_frame');

							uploadfile_<?php echo $grid ?>('form_update_'+grid, grid, formAction, base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
													
						}else{
							var  full = $("#infomodule").text().split(':');
							var part1 = full[1].split('/');
							reload_grid_new(part1[1],grid);
							_custom_alert('Data Berhasil Disimpan!',header,info, grid, 1, 20000);
							$.get(base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
			})
		}
	})		
}
}


function update_submit_<?php echo $grid ?>(grid, url, dis) {
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

	/*Cek Untuk Upload Minimal 1*/
	var nn=0;
	$.each($(".num_rows_tb_details_export_uji_mikro_fg"), function(i,v){
		nn++;
	});

	if(nn==0){
		alert_message += '<br /><b>Minimal 1 Upload File</b>';
	}

	if(conf > 0) {
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}
	else {
	//return false;
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
							
							uploadfile_<?php echo $grid ?>('form_update_'+grid, grid, formAction, base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);

						 }else{
							_custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
							info = 'info';
							header = 'Info';
							
							var  full = $("#infomodule").text().split(':');
							var part1 = full[1].split('/');
							reload_grid_new(part1[1],grid);

							$.get(base_url+'<?php echo $urlpath ?>?action=update&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
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
				})
	  		 }	
			
	})		
}
}
/*Modify Upload File*/
function uploadfile_<?php echo $grid ?>(formgrid, grid, formAction, url){
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
    if(x>=20){
    	alert("Jumlah upload file melebihi 20, file yang akan di simpan 20 file teratas!");
    }
    var params = $(obj).serializeArray();
    $.each(params, function (i, val) {
        formData.append(val.name, val.value);
    });
   
    //return false;
    waitDialog_<?php echo $grid ?>("Waiting... Upload File...");
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
   				var o = $.parseJSON(data);	
   				$(".Dialog_<?php echo $grid ?>").dialog('close');															
				_custom_alert(o.message,'info','info', grid, 1, 20000);
				$.get(url, function(data) {
					$('div#form_'+grid).html(data);
					var  full = $("#infomodule").text().split(':');
					var part1 = full[1].split('/');
					reload_grid_new(part1[1],grid);
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
        $('#progress2').text(e.loaded);
    }
}
function waitDialog_<?php echo $grid ?>(h3=''){
	console.log('RaidenArmy');
	$(".Dialog_<?php echo $grid ?>").dialog({
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


function load_popup_<?php echo $grid ?>(page,div,act='',title){
	if(div === undefined || div == '') {
		div = '#alert_dialog_form';
	}
	if(title === undefined || title == '') {
		title = '';
	}
    $.ajax({
        url: page,
        beforeSend: function(){
            //$(div).html(image_load);
            //$('#loading_lock').css({'display':'block'});
        },
        success: function(response) {
        	if($(div).length == 0) {
        		$('#buat_content').html('<div title=\"'+title+'\" id=\"alert_dialog_form\" style=\"width: 880px;\">' + response + '</div>');
        		$('#alert_dialog_form').dialog({
        			resizable:false,
        			title:title,
		        	modal: true,
		        	minWidth: 900,
		        	minHeight: 0,
		        	create: function() {
		                $(this).css('maxHeight', 500);        
		            },
		        	buttons: {
		        		Close: function(){
		        			 $(this).dialog('close');
		        		},
		        		Approve: function(){
							approve_act_<?php echo $grid ?>($(this));
		        		}
		        	},				    				       	
		        });
        	}
        	else {
        		$(div).html(response);
        		$(div).dialog({
		        	modal: true,
		        	minWidth: 900,
		        	title:title,
		        	minHeight: 0,
		        	create: function() {
		                $(this).css('maxHeight', 500);        
		            },
		        	buttons: {
		        		Close: function(){
		        			 $(this).dialog('close');	        			         			 
		        		},
		        		Approve: function(){
							approve_act_<?php echo $grid ?>($(this));
		        		}
		        	},				    
		        });		       
        	}      
        	 $('#alert_dialog_form').bind('dialogclose', function(event) {
				 $(this).dialog('close');
		    });      
        },
        statusCode: {
		    404: function() {
		      $(div).html('ERROR 404<br />Page Not Found! :p<br /><br /><img src='+image_404+' >');
			}
		},
        dataType:'html'  		
    });
    return false;
}
function approve_act_<?php echo $grid ?>(ini){
	var grid = 'form_popup_export_best_formula';
	var vRemark = $('#vRemark').val();
	/*if (vRemark==''){
		alert_message='Remark tidak boleh kosong ';
		_custom_alert(alert_message,'Error!','info','export_best_formula', 1, 5000);
	}else{*/
		custom_confirm(comfirm_message,function(){	
			var dataForm = $('#'+grid).serializeArray();
			$.ajax({
				url: $('#'+grid).attr('action'),
				type: 'post',
				data: { form: dataForm },
				data: dataForm,
				success: function(data) {
					var o = $.parseJSON(data);
					var info = 'Error';
					var header = 'Error';
					if(o.status == true) {
						$('#grid_export_best_formula').trigger('reloadGrid');
						$.get(base_url+'<?php echo $urlpath ?>?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
                            $('div#form_<?php echo $grid ?>').html(data);
                            $('html, body').animate({scrollTop:$('#<?php echo $grid ?>').offset().top - 20}, 'slow');
	                    });
						_custom_alert(' '+o.message,'Info','info','export_best_formula', 1, 5000);
						ini.dialog("close");
					}
				}
			});
		})
	//}
}

function cek_id_<?php echo $grid ?>(page,div,act,title){
	var id =$("#export_best_formula_iexport_refor_formula").val();
	$("#export_best_formula_iexport_refor_formula_dis").removeClass('error_text');		
	if(id==""){
		_custom_alert("<bold>Pilih Nomor Request terlebih dahulu!</bold>");
		$("#export_best_formula_iexport_refor_formula_dis").addClass('error_text');	
		$("#export_best_formula_iexport_refor_formula_dis").focus();
		return false;
	}else{
		load_popup_<?php echo $grid ?>(page+"&iexport_refor_formula="+id,div,act,title);
	}
}

</script>
<?php $imgurl = base_url().'assets/images/e-load.gif';?> 
<div class="Dialog_<?php echo $grid ?>" style="display: none">
	<div  style="margin: 0px 0px">
		<img alt="" src="<?php echo $imgurl; ?>"  /><br/>
		<span id="span"> </span>
		<span id="span_progress"> </span>
		<h3 id = "h3">J u s t  a  m i n u t e ...</h3>
		<progress id = "progress" ></progress>
		<p id = "progress2" ></p>
	</div>
</div>
<iframe name="iframe_<?php echo $grid ?>" id="iframe_<?php echo $grid ?>" height="0" width="0"></iframe>

