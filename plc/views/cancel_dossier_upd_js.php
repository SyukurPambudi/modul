<script>
function load_pop_cancel(page,title,lbl,id,urlget){
	div='';
	act='';
	if(div === undefined || div == '') {
		div = '#alert_dialog_form';
	}
	if(title === undefined || title == '') {
		title = '';
	}
	if(act === undefined || act == '') {
		act = function(){$('#alert_dialog_form').dialog('close')};
	}
    //var image_load = "<div class='ajax_loading'><img src='"+loader+"' /></div>";
    $.ajax({
        url: page,
        beforeSend: function(){
            //$(div).html(image_load);
            //$('#loading_lock').css({'display':'block'});
        },
        success: function(response) {
        	if($(div).length == 0) {
        		$('#buat_content').html('<div title="'+title+'" id="alert_dialog_form">' + response + '</div>');
        		$('#alert_dialog_form').dialog({
		        	modal: true,
		        	minWidth: 900,
		        	//zIndex: 999999,
		        	minHeight: "100%",
		        	buttons: 
		        	[{		text:lbl,
			        		"id":"btnOK",
			        		click:function(){
			        			getpost($(this),id,urlget);
			        		}
			        	},
			        	{
			        		text:"Cancel",
			        		"id":"btnCancel",
			        		click:function(){
			        			 $(this).dialog('close');
			        		}
			        }]					    				       	
		        });
        	}
        	else {
        		$(div).html(response);
        		$(div).dialog({
		        	modal: true,
		        	minWidth: 750,
		        	//zIndex: 999999,
		        	minHeight: "100%",
		        	buttons: 
		        	[{		text:lbl,
			        		"id":"btnOK",
			        		click:function(){
			        			getpost($(this),id,urlget);
			        		}
			        	},
			        	{
			        		text:"Cancel",
			        		"id":"btnCancel",
			        		click:function(){
			        			 $(this).dialog('close');
			        		}
			        	}]				    
		        });		       
        	}      
        	 $('#alert_dialog_form').bind('dialogclose', function(event) {
				act();
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
function getpost(dis,grid,urlget){
	var req = $('#form_popup_'+grid+' input.required, #form_popup_'+grid+' select.required, #form_popup_'+grid+' textarea.required');
	var conf=0;
	alert_message='';
	var uploadField = $('#form_popup_'+grid+' input.multifile');
	var isUpload = uploadField.length;
	var uploadLimit = 0;
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
	});
	if(conf!=0){
		_custom_alert(alert_message,'Error!','info',grid, 1, 5000);
	}else{
		$.ajax({
			url: $('#form_popup_'+grid).attr('action'),
			type: 'post',
			data:  $('#form_popup_'+grid).serialize(),
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.status==true){
					var info = 'success';
					var header = 'success';
						if(isUpload) {

							var iframe = $('<iframe name="'+grid+'_frame"/>');
							iframe.attr({'id':grid+'_frame'});
							$('#form_popup_'+grid).parent().append(iframe);
									
							var formAction = $('#form_popup_'+grid).attr('action');
								formAction+='&isUpload=1';
								formAction+='&lastId='+o.last_id;
								formAction+='&uploadLimit='+uploadLimit;
								formAction+='&company_id='+o.company_id;									
									
							$('#form_popup_'+grid).attr('action',formAction);
							$('#form_popup_'+grid).attr('target',grid+'_frame');
							uploadfile('form_popup_'+grid, grid, formAction, base_url+urlget+'&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id);
						}else{
							_custom_alert(o.message,header,info, grid, 1, 20000);
							$('#grid_'+grid).trigger('reloadGrid');
							$.get(base_url+urlget+'&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                    $('div#form_'+grid).html(data);
			                    $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			           		});
			           	}
			           	dis.dialog('close');

				}else{
					var info = 'error';
					var header = 'error';
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
				
			}		
		});
	}
}


function load_pop_bdi(page,titlebdi,lbl,id,urlget){
	div='';
	act='';
	if(div === undefined || div == '') {
		div = '#alert_dialog_form';
	}
	if(titlebdi === undefined || titlebdi == '') {
		titlebdi = '';
	}
	if(act === undefined || act == '') {
		act = function(){$('#alert_dialog_form').dialog('close')};
	}
    //var image_load = "<div class='ajax_loading'><img src='"+loader+"' /></div>";
    $.ajax({
        url: page,
        beforeSend: function(){
            //$(div).html(image_load);
            //$('#loading_lock').css({'display':'block'});
        },
        success: function(response) {
        	if($(div).length == 0) {
        		$('#buat_content').html('<div title="'+titlebdi+'" id="alert_dialog_form">' + response + '</div>');
        		$('#alert_dialog_form').dialog({
		        	modal: true,
		        	minWidth: '100%',
		        	//zIndex: 999999,
		        	minHeight: "100%",
		        	buttons: 
		        	[{		text:lbl,
			        		"id":"btnOK",
			        		click:function(){
			        			getpost($(this),id,urlget);
			        		}
			        	},
			        	{
			        		text:"Cancel",
			        		"id":"btnCancel",
			        		click:function(){
			        			 $(this).dialog('close');
			        		}
			        }]					    				       	
		        });
        	}
        	else {
        		$(div).html(response);
        		$(div).dialog({
		        	modal: true,
		        	minWidth: 750,
		        	//zIndex: 999999,
		        	minHeight: "100%",
		        	buttons: 
		        	[{		text:lbl,
			        		"id":"btnOK",
			        		click:function(){
			        			getpost($(this),id,urlget);
			        		}
			        	},
			        	{
			        		text:"Cancel",
			        		"id":"btnCancel",
			        		click:function(){
			        			 $(this).dialog('close');
			        		}
			        	}]				    
		        });		       
        	}      
        	 $('#alert_dialog_form').bind('dialogclose', function(event) {
				act();
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
</script>