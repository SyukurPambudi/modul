<?php
    $urlGetProsesKopi = base_url()."processor/plc/migrasi_data?action=getProsesKopi"; 

    if(isset($upload)){
        $upload=$upload;
    }else{
        $upload="uploadfile";
    } 

    
?>

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

function migrasi_data_btn_multiupload(grid, url, dis, isdraft) {
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

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
    var vNiplogin = $('#nip_login').val();

    var vToken = stringUnik(vNiplogin);

    
    if(conf > 0) {
        _custom_alert(alert_message,'Error!','info',grid, 1, 5000);
    }
    else {

        custom_confirm(comfirm_message,function(){
                $("#list_modules").html("");
                $.ajax({
                    url: '<?php echo $urlGetProsesKopi;?>',
                    //dataType: 'json',
                    type: 'post',
                    data: $('#form_create_'+grid).serialize()+'&'+$.param({ 'vToken': vToken }),
                    // data: {    
                    //             iupb_id : $("#migrasi_data_iupb_id").val()
                    //         },
                    beforeSend: function() {
                        $("#button_save_draft_migrasi_data").hide();
                    },
                    success: function(data) {   
                        var o = $.parseJSON(data);                                              
                        var info = 'Info';
                        var header = 'Info';
                        var iupb_id_ref = o.iupb_id_ref;
                        var company_id = o.company_id;
                        var group_id = o.group_id;
                        var modul_id = o.modul_id;      
                        var message = o.message;      
                        var proseses = o.proseses;   
                        var totalproses = o.totalproses;   
                        if(o.status == true) {
                            _custom_alert(o.message,header,info, grid, 1, 20000);
                            $('#grid_'+grid).trigger('reloadGrid');
                          //  $("#button_save_draft_migrasi_data").hide();
                                                    
                        }
                        else{
                            _custom_alert(o.message,header,info, grid, 1, 20000);
                            info = 'info';
                            header = 'Info';
                        }
                    }
                })

               
        })
    }   
}


function stringUnik(nip) {
  var text = nip;
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 10; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}


function migrasi_data_btn_multiuploadcc(grid, url, dis, isdraft) {
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

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');


    
    if(conf > 0) {
        _custom_alert(alert_message,'Error!','info',grid, 1, 5000);
    }
    else {

        custom_confirm(comfirm_message,function(){
                $("#list_modules").html("");
                $.ajax({
                    url: '<?php echo $urlGetProsesKopi;?>',
                    //dataType: 'json',
                    type: 'post',

                    data: {    
                                iupb_id : $("#migrasi_data_iupb_id").val()
                            },
                    
                    success: function(data) {   
                        var o = $.parseJSON(data);                                              
                        var info = 'Info';
                        var header = 'Info';
                        var iupb_id_ref = o.iupb_id_ref;
                        var company_id = o.company_id;
                        var group_id = o.group_id;
                        var modul_id = o.modul_id;      
                        var message = o.message;      
                        var proseses = o.proseses;   
                        var totalproses = o.totalproses;   
                        if(o.status == true) {
                            //_custom_alert(o.message,header,info, grid, 1, 20000);

                            //$('#grid_'+grid).trigger('reloadGrid');
                            /*
                                status    true
                                group_id    null
                                proseses    […]
                                0    {…}
                                iM_flow_proses    1
                                iM_flow    1
                                iM_modul    1
                                iUrut    10
                                vKode_modul    PL00001
                                vNama_modul    Daftar UPB
                                idprivi_modules    4213
                                iType_modul    1
                                vCodeModule    3.1.PLC_DAFTAR_UPB
                                vDesciption    Modul daftar UPB
                                vDept_author    BD
                                vNip_author    N1200,N16921
                                vDept_participant    DR
                                vNip_participant    N15748
                                dCreate    2018-12-07 15:29:52
                                cCreated    N14615
                                dupdate    2018-12-07 15:29:52
                                cUpdate    N15748
                                lDeleted    0
                                modul_id    null
                                message    null


                            */
                            var iupb_id_new = 0;
                            $.each(proseses, function(i,v){
                                poresesSendiri(v.iM_modul,iupb_id_ref,iupb_id_new,v.vNama_modul,i,totalproses,grid,bar,percent,status);
                            })

                            

                            $("#button_save_draft_migrasi_data").hide();
                                                    
                        }
                        else{
                            _custom_alert(o.message,header,info, grid, 1, 20000);
                            info = 'info';
                            header = 'Info';
                        }
                    }
                })

               
        })
    }   
}

function poresesSendiri(iModul_id,iupb_id_ref,iupb_id_new,vNama_modul,i,totalproses,grid,bar,percent,status){
    
    

        $("#list_modules").append('<li id="modul_'+iModul_id+'"><a href="#">'+vNama_modul+'</a></li>');
        var current_persen = ((i+1)/totalproses)*100;
        
        alert(iupb_id_new);
        $.ajax({
            url: $('#form_create_'+grid).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $('#form_create_'+grid).serialize()+'&'+$.param({ 'iupb_id_ref': iupb_id_ref })+'&'+$.param({ 'iupb_id_new': iupb_id_new })+'&'+$.param({ 'iModul_id': iModul_id }),
            beforeSend: function() {
                // setting a timeout
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
                

            },
            complete: function(xhr) {
                var percentVal = current_persen + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                status.html(xhr.responseText);
                /*$("#modul_"+iModul_id).css('background-color','#B4F5B4');*/
            },


            success: function(datax) {   
                $("#modul_"+iModul_id).css('background-color','#B4F5B4');
                var o = $.parseJSON(datax);                                              
                iupb_id_new = o.iupb_id_new;
                if(o.status == true) {
                    return true
                }else{
                    return false;    
                }

                
            }   

        })
    

}


	
</script>