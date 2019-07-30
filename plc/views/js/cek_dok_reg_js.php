<script type="text/javascript">
function update_btn_back_cek_dok_reg(grid, url, dis) {
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
                            formAction+='&modul_id='+modul_id;
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
                                    formAction+='&modul_id='+modul_id;
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
                            $('#grid_'+grid).trigger('reloadGrid');
                            //reload_grid_new(part1[1],grid);
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
function update_btn_back_v3_cekdok_reg_QA(grid, url, dis) {
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
        $.ajax({
                url:base_url+"processor/plc/v3/cek/dokumen/reg?action=cekReviseQA",
                type: 'post',
                data: $('#form_update_'+grid).serialize()+'&'+$.param({ 'iM_modul_activity': iM_modul_activity })+'&'+$.param({ 'modul_id': iModul_id }),
                success: function(data1) {
                    var oo = $.parseJSON(data1);
                    var comfirm_message1 = comfirm_message;
                    if(oo.status==false){
                        comfirm_message1="<p><strong>Apakah yakin Akan Revised Dokumen?</strong></p>"+oo.message;
                    }
                    custom_confirm(comfirm_message1,function(){
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
                                        formAction+='&modul_id='+modul_id;
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
                                                formAction+='&modul_id='+modul_id;
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
                                        $('#grid_'+grid).trigger('reloadGrid');
                                        //reload_grid_new(part1[1],grid);
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
        });
        return false;
             
}
}   
function update_btn_back_v3_cekdok_reg_BD(grid, url, dis) {
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
        $.ajax({
                url:base_url+"processor/plc/v3/cek/dokumen/reg?action=cekReviseBD",
                type: 'post',
                data: $('#form_update_'+grid).serialize()+'&'+$.param({ 'iM_modul_activity': iM_modul_activity })+'&'+$.param({ 'modul_id': iModul_id }),
                success: function(data1) {
                    var oo = $.parseJSON(data1);
                    var comfirm_message1 = comfirm_message;
                    if(oo.status==false){
                        comfirm_message1="<p><strong>Apakah yakin Akan Revised Dokumen?</strong></p>"+oo.message;
                    }
                    custom_confirm(comfirm_message1,function(){
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
                                        formAction+='&modul_id='+modul_id;
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
                                                formAction+='&modul_id='+modul_id;
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
                                        $('#grid_'+grid).trigger('reloadGrid');
                                        //reload_grid_new(part1[1],grid);
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
        });
        return false;
             
}
}   
</script>