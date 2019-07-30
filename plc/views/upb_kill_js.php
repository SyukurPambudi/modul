<script>
function update_btn_back(grid, url, dis) {
    var urlc = new URL(url);
    let searchParams = new URLSearchParams(url);

    if(searchParams.has('iM_modul_activity')){
       var iM_modul_activity = urlc.searchParams.get("iM_modul_activity"); 
    }else{
       var iM_modul_activity = 0; 
    }

    if(searchParams.has('modul_id')){
       var iModul_id = urlc.searchParams.get("modul_id"); 
    }else{
       var iModul_id = 0; 
    }

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
                        if(o.status == true){
                            if(isUpload) {
                                var iframe = $('<iframe name='+grid+'"_frame"/>');
                                iframe.attr({'id':grid+'_frame'});
                                $('#form_create_'+grid).parent().append(iframe);
                                var formAction = url+"&action=uploadFile";
                                formAction+='&isUpload=1';
                                formAction+='&lastId='+o.last_id;
                                formAction+='&uploadLimit='+uploadLimit;
                                formAction+='&company_id='+o.company_id;
                                formAction+='&modul_id='+modul_id;
                                upload_custom_grid('form_create_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);
                            
                            }else{
                                _custom_alert(o.message,header,info, grid, 1, 20000);
                                $('#grid_'+grid).trigger('reloadGrid');
                                info = 'info';
                                header = 'Info';
                                
                                $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                        $('div#form_'+grid).html(data);
                                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                                }); 
                            }
                            $('#grid_'+grid).trigger('reloadGrid');
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
function upload_custom_grid(formgrid, grid, formAction, url){
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
    // waitDialog("Waiting... Upload File...");
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
                _custom_alert(o.message,'info','info', grid, 1, 20000);
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
</script>