<?php
if(isset($upload)){
    $upload=$upload;
}else{
    $upload="uploadfile";
} ?>
<script type="text/javascript">
    // datepicker
     $(".tanggal").datepicker({changeMonth:true,
                                changeYear:true,
                                dateFormat:"yy-mm-dd" });

    // input number
       $(".angka").numeric();

    /*erp Message*/
    var full = $("#infomodule").text().split(':');
    var part1 = full[1].split('/');

function save_draft_btn_multiupload(grid, url, dis, isdraft) {
    var urlc = new URL(url);


    if (urlc.searchParams.has("iM_modul_activity")){
       var iM_modul_activity = urlc.searchParams.get("iM_modul_activity");
    }else{
       var iM_modul_activity = '';
    }

    if (urlc.searchParams.has("modul_id")){
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
        uploadLimit = 5242880;//$('#'+grid+'_fileupload').attr('limit');
    }

    if(isdraft != undefined) {
        $('#form_create_'+grid+' #isdraft').val(isdraft);
    }
    
    /*untuk draft tidak ada pengecekan required field*/
    /*$.each(req, function(i,v){
        $(this).removeClass('error_text');
        if($(this).val() == '') {
            var id = $(this).attr('id');
            var label = $("label[for='"+id+"']").text();
            label = label.replace('*','');
            alert_message += '<br /><b>'+label+'</b> '+required_message;            
            $(this).addClass('error_text');         
            conf++;
        }       
    })*/

    
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
                    data: $('#form_create_'+grid).serialize()+'&'+$.param({ 'iM_modul_activity': iM_modul_activity })+'&'+$.param({ 'modul_id': iModul_id }),
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
                                var iframe = $('<iframe name='+grid+'"_frame"/>');
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
                                
                                <?php 
                                if($upload!="upload_custom_grid"){ 
                                    echo $upload ?>('form_create_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);  
                                <?php
                                    }else{ ?>
                                        var formAction = url+"&action=uploadFile";
                                        formAction+='&isUpload=1';
                                        formAction+='&lastId='+o.last_id;
                                        formAction+='&uploadLimit='+uploadLimit;
                                        formAction+='&company_id='+o.company_id;
                                        formAction+='&isdraft='+isdraft;
                                        upload_custom_grid('form_create_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);
                                    <?php }
                                ?>

                            }else{
                                _custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
                                $('#grid_'+grid).trigger('reloadGrid');
                                //reload_grid_new(part1[1],grid);
                                
                                $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                    $('div#form_'+grid).html(data);
                                    $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                                });

                            }
                            $('#grid_'+grid).trigger('reloadGrid');
                            //reload_grid_new(part1[1],grid);
                            
                                                    
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

function save_btn_multiupload(grid, url, dis) {
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
    if($("#ppic_memo_busdev_cPIC").val()==''){
            $("#ppic_memo_busdev_cPIC_text").addClass('error_text');    
            conf++;
        }
        if($("#ppic_memo_busdev_iupb_id").val()==''){
            $("#ppic_memo_busdev_iupb_id_dis").addClass('error_text');  
            conf++;
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
                data: $('#form_create_'+grid).serialize()+'&'+$.param({ 'iM_modul_activity': iM_modul_activity })+'&'+$.param({ 'modul_id': iModul_id }),
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
                                
                                var formAction = $('#form_create_'+grid).attr('action');
                                formAction+='&isUpload=1';
                                formAction+='&lastId='+o.last_id;
                                formAction+='&uploadLimit='+uploadLimit;
                                formAction+='&company_id='+o.company_id;
                                
                                $('#form_create_'+grid).attr('action',formAction);
                                $('#form_create_'+grid).attr('target',grid+'_frame');
                                 <?php 
                                if($upload!="upload_custom_grid"){ 
                                    echo $upload ?>('form_create_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);  
                                <?php
                                    }else{ ?>
                                        var formAction = url+"&action=uploadFile";
                                        formAction+='&isUpload=1';
                                        formAction+='&lastId='+o.last_id;
                                        formAction+='&uploadLimit='+uploadLimit;
                                        formAction+='&company_id='+o.company_id;
                                        formAction+='&isdraft='+isdraft;
                                        upload_custom_grid('form_create_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);
                                    <?php }
                                ?>

                            }else{
                                _custom_alert(o.message,header,info, grid, 1, 20000);
                                $('#grid_'+grid).trigger('reloadGrid');
                                //reload_grid_new(part1[1],grid);
                                info = 'info';
                                header = 'Info';
                                
                                $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                        $('div#form_'+grid).html(data);
                                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                                }); 
                            }
                            $('#grid_'+grid).trigger('reloadGrid');
                            //reload_grid_new(part1[1],grid);
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

function update_draft_btn(grid, url, dis, isdraft) {
    
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

    

    var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
    var conf=0;
    var alert_message = '';
    var uploadField = $('#form_update_'+grid+' input.multifile');
    var uploadLimit = 0;
    var isUpload = uploadField.length;
    
    if(isdraft ==true) {
        $('#form_update_'+grid+' #isdraft').val(isdraft);
    }
    if(isUpload) {
        uploadLimit = 5242880;
    }
    
    /*untuk draft tidak ada pengecekan required*/
    /*$.each(req, function(i,v){
        $(this).removeClass('error_text');
        if($(this).val() == '') {
            var id = $(this).attr('id');
            var label = $("label[for='"+id+"']").text();
            label = label.replace('*','');
            alert_message += '<br /><b>'+label+'</b> '+required_message;            
            $(this).addClass('error_text');         
            conf++;
        }       
    })*/

    if(conf > 0) {
        _custom_alert(alert_message,'Error!','info',grid, 1, 5000);
    }
    else {
        custom_confirm(comfirm_message,function(){
            if(isUpload && !isValidAFileSize('#form_update_'+grid+' input.multifile', uploadLimit)) {

            } else {                
                $.ajax({
                url: $('#form_update_'+grid).attr('action'),
                type: 'post',
                //data: $('#form_update_'+grid).serialize()+'&'+$.param({ 'wordlist': wordlist }),
                data: $('#form_update_'+grid).serialize()+'&'+$.param({ 'iM_modul_activity': iM_modul_activity })+'&'+$.param({ 'modul_id': iModul_id }),
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
                            $('#form_update_'+grid).parent().append(iframe);
                            
                            var formAction = $('#form_update_'+grid).attr('action');
                            formAction+='&isUpload=1';
                            formAction+='&lastId='+o.last_id;
                            formAction+='&uploadLimit='+uploadLimit;
                            formAction+='&company_id='+o.company_id;
                            formAction+='&isdraft='+isdraft;
                            
                            $('#form_update_'+grid).attr('action',formAction);
                            $('#form_update_'+grid).attr('target',grid+'_frame');

                            <?php 
                            if($upload!="upload_custom_grid"){ 
                                echo $upload ?>('form_update_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);  
                            <?php
                                }else{ ?>
                                    var formAction = url+"&action=uploadFile";
                                    formAction+='&isUpload=1';
                                    formAction+='&lastId='+o.last_id;
                                    formAction+='&uploadLimit='+uploadLimit;
                                    formAction+='&company_id='+o.company_id;
                                    formAction+='&isdraft='+isdraft;
                                    upload_custom_grid('form_update_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);
                                <?php }
                            ?>
                                                    
                            }else{
                            _custom_alert('Data Berhasil Disimpan!',header,info, grid, 1, 20000);
                            $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                    $('div#form_'+grid).html(data);
                                    $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                            });
                        }
                        $('#grid_'+grid).trigger('reloadGrid');
                        //reload_grid_new(part1[1],grid);

                        $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                    $('div#form_'+grid).html(data);
                                    $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                            });

                        
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
                    var last_id = o.last_id;
                    var company_id = o.company_id;
                    var group_id = o.group_id;
                    var modul_id = o.modul_id;
                    if(o.status == true) {
                        //$('#form_update_'+grid)[0].reset();
                        info = 'info';
                        header = 'Info';
                    }
                    _custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
                    $('#grid_'+grid).trigger('reloadGrid');
                    //reload_grid_new(part1[1],grid);
                }
            })
        })
    }       
}

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

    var req = $('#form_update_'+grid+' input.required, #form_update_'+grid+' select.required, #form_update_'+grid+' textarea.required');
    var conf=0;
    var alert_message = '';
    //alert("test");
    var uploadField = $('#form_update_'+grid+' input.multifile');
    var uploadLimit = 0;
    var isUpload = uploadField.length;
    
    /*iM_modul_activity=36*/

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
                alert('File maks 5MB!');
            } 
            else{
                $.ajax({
                url: $('#form_update_'+grid).attr('action'),
                type: 'post',
                data: $('#form_update_'+grid).serialize()+'&'+$.param({ 'iM_modul_activity': iM_modul_activity })+'&'+$.param({ 'modul_id': iModul_id }),
                success: function(data) {
                    
                    //alert(isUpload);
                    var o = $.parseJSON(data);
                    var info = 'Info';
                    var header = 'Info';
                    var last_id = o.last_id;
                    var company_id = o.company_id;
                    var group_id = o.group_id;
                    var modul_id = o.modul_id;
                    if(o.status == true){
                        if(isUpload > 0) {              
                            //alert('tes');                             
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
                            
                            <?php 
                            if($upload!="upload_custom_grid"){ 
                                echo $upload ?>('form_update_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);  
                            <?php
                                }else{ ?>
                                    var formAction = url+"&action=uploadFile";
                                    formAction+='&isUpload=1';
                                    formAction+='&lastId='+o.last_id;
                                    formAction+='&uploadLimit='+uploadLimit;
                                    formAction+='&company_id='+o.company_id;
                                    formAction+='&isdraft='+isdraft;
                                    upload_custom_grid('form_update_'+grid, grid, formAction, url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id);
                                <?php }
                            ?>

                         }else{
                            _custom_alert('Data Berhasil Disimpan !',header,info, grid, 1, 20000);
                            info = 'info';
                            header = 'Info';
                            
                            $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                    $('div#form_'+grid).html(data);
                                    $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                            });
                        }
                        $('#grid_'+grid).trigger('reloadGrid');
                        //reload_grid_new(part1[1],grid);
                        $.get(url+'&action=update&foreign_key=0&company_id='+company_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
                                    $('div#form_'+grid).html(data);
                                    $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
                            });
                        
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
    //waitDialog("Waiting... Upload File...");
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
                //$(".Dialog_<?php echo $upload; ?>").dialog('close');                                                           
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
function waitDialog(h3=''){
    console.log('RaidenArmy');
    $(".Dialog_<?php echo $upload; ?>").dialog({
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
<?php $imgurl = base_url().'assets/images/e-load.gif';?> 
<div class="Dialog_<?php echo $upload; ?>" style="display: none">
    <div  style="margin: 0px 0px">
        <img alt="" src="<?php echo $imgurl; ?>"  /><br/>
        <span id="span"> </span>
        <h3 id = "h3">J u s t  a m i n u t e ...</h3>
        <progress id = "progress" ></progress>
    </div>
</div>

