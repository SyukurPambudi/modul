<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $iappbd_applet=isset($dataHead["iappbd_applet"])?$dataHead["iappbd_applet"]:"0";
    $ireg_ulang=isset($dataHead["ireg_ulang"])?$dataHead["ireg_ulang"]:"";
    $iHasil_registrasi=isset($dataHead["iHasil_registrasi"])?$dataHead["iHasil_registrasi"]:"------";
   
    $get=$this->input->get();
    /* echo $ireg_ulang.'.............'.$iappbusdev_registrasi.'.................';
    exit; */
    ?>


    
    <script>
    
    
<?php
    
    
       if($iupb_id!="0" && $iappbusdev_registrasi==2  && $ireg_ulang == 0 && $ireg_ulang <> "" ){?>
            $("#<?php echo $id ?>").parent().parent().show();
                 

    <?php }else{ ?>
        //$("#<?php echo $id ?>").parent().parent().hide();
        $("#v3_reg_applet_tbayar_reg").parent().parent().next().next().next().next().next().hide();
        //$("#v3_reg_applet_vnie").hide();

    <?php }
if ($iappbd_applet ==2 && $ireg_ulang == 0 && $ireg_ulang <> ""){ 
        $arra=array(0=>"NIE",1=>"APPLET");
        $value=isset($arra[$dataHead[$field]])?$arra[$dataHead[$field]]:"-";
        ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');

     <?php 
        } 
    ?>
      $("#<?php echo $id ?>").change(function(){
            var nilai="NIE";
            if($(this).val()==1){
                nilai="APPLET";
            }
            // $("label[for='v3_reg_applet_form_detail_ttarget_noreg']").html("Tanggal "+nilai+"<span class='required_bintang'>*</span>");
            // $("label[for='v3_reg_applet_form_detail_vnie']").html("Nomor "+nilai+"<span class='required_bintang'>*</span>");
            // $("label[for='v3_reg_applet_form_detail_dRegistrasi_expired']").html("Tanggal "+nilai+" Expired <span class='required_bintang'>*</span>");
            // $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").html("File "+nilai+"<span class='required_bintang'>*</span>");
            if(nilai=="NIE"){
                $("#v3_reg_applet_form_detail_dinput_applet").remove();
                $.ajax({
                    url: base_url+'processor/plc/v3/reg/applet?action=getTglApplet',
                    type: 'post',
                    data: 'iupb=<?php echo $iupb_id ?>',
                    success: function(data) {
                        var o = $.parseJSON(data);
                        if(o.c_row>0){
                            $("#v3_reg_applet_ttarget_noreg").val(o.d_row.d_from);
                            $("#v3_reg_applet_dRegistrasi_expired").val(o.d_row.d_valid);
                            $("#v3_reg_applet_vnie").val(o.d_row.c_noreg);
                        }else{
                            $("#v3_reg_applet_ttarget_noreg").val("");
                            $("#v3_reg_applet_dRegistrasi_expired").val("");
                            $("#v3_reg_applet_vnie").val("");
                        }
                    }
                });
                show($("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent());
                hide($("label[for='v3_reg_applet_form_detail_vfileregistrasiApplet']").parent());
            }else{
                <?php
                 $dinput_applet=isset($dataHead["dinput_applet"]) && $dataHead["dinput_applet"] != NULL && $dataHead["dinput_applet"] != "0000-00-00" ? date("Y-m-d",strtotime($dataHead["dinput_applet"])):"";
                 $dExpired_applet=isset($dataHead["dExpired_applet"]) && $dataHead["dExpired_applet"] != NULL && $dataHead["dExpired_applet"] != "0000-00-00" ? date("Y-m-d",strtotime($dataHead["dExpired_applet"])):"";
                 ?>
                 var ini = '<div class="rows_group" style="overflow:fixed;" id="v3_reg_applet_form_detail_dinput_applet">';
                     ini+= '<label for="v3_reg_applet_form_detail_dinput_applet" class="rows_label">Tanggal Applet<span class="required_bintang">*</span></label>';
                     ini+= '<div class="rows_input"><input type="text" value="<?php echo $dinput_applet ?>" name="dinput_applet" id="v3_reg_applet_dinput_applet" class="input_rows1 tanggal required hasDatepicker" readonly="readonly" size="10">';
                     
                     ini += '<div class="rows_group" style="overflow:fixed;" id="v3_reg_applet_form_detail_dExpired_applet">';
                     ini+= '<label for="v3_reg_applet_form_detail_dExpired_applet" class="rows_label">Tanggal Expired Applet<span class="required_bintang">*</span></label>';
                     ini+= '<div class="rows_input"><input type="text" value="<?php echo $dExpired_applet ?>" name="dExpired_applet" id="v3_reg_applet_dExpired_applet" class="input_rows1 tanggal required hasDatepicker" readonly="readonly" size="10">';
                 $("#<?php echo $id ?>").parent().parent().after(ini);
                 $("#v3_reg_applet_dinput_applet").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker({changeMonth:true,
                                             changeYear:true,
                                             dateFormat:"yy-mm-dd",
                                             onSelect: function(date) {
                                                var d = new Date(date);
                                                var year = d.getFullYear();
                                                var month = d.getMonth();
                                                var day = d.getDate();
                                                var c = new Date(year + 2, month+1, day)
                                                var year1 = c.getFullYear();
                                                var month1 = c.getMonth();
                                                var day1 = c.getDate();
                                                var newdate=year1+'-'+pad(month1)+'-'+pad(day1);
                                                $("#v3_reg_applet_dExpired_applet").val(newdate);
                                            }
                                        });
                hide($("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent());
                show($("label[for='v3_reg_applet_form_detail_vfileregistrasiApplet']").parent());
            }
        });
        var nilai1="NIE";
        var nnn='<?php echo $iHasil_registrasi; ?>';
        if(nnn==1){
            nilai1="APPLET";
        }
        if(nilai1=="APPLET"){
            <?php
                 $dinput_applet=isset($dataHead["dinput_applet"]) && $dataHead["dinput_applet"] != NULL && $dataHead["dinput_applet"] != "0000-00-00" ? date("Y-m-d",strtotime($dataHead["dinput_applet"])):"";
                 $dExpired_applet=isset($dataHead["dExpired_applet"]) && $dataHead["dExpired_applet"] != NULL && $dataHead["dExpired_applet"] != "0000-00-00" ? date("Y-m-d",strtotime($dataHead["dExpired_applet"])):"";
                ?>
                var ini = '<div class="rows_group" style="overflow:fixed;" id="v3_reg_applet_form_detail_dinput_applet">';
                    ini+= '<label for="v3_reg_applet_form_detail_dinput_applet" class="rows_label">Tanggal Applet<span class="required_bintang">*</span></label>';
                    ini+= '<div class="rows_input"><input type="text" value="<?php echo $dinput_applet ?>" name="dinput_applet" id="v3_reg_applet_dinput_applet" class="input_rows1 tanggal required hasDatepicker" readonly="readonly" size="10"></div></div>';
                    
                    ini += '<div class="rows_group" style="overflow:fixed;" id="v3_reg_applet_form_detail_dExpired_applet">';
                    ini+= '<label for="v3_reg_applet_form_detail_dExpired_applet" class="rows_label">Tanggal Expired Applet<span class="required_bintang">*</span></label>';
                    ini+= '<div class="rows_input"><input type="text" value="<?php echo $dExpired_applet ?>" name="dExpired_applet" id="v3_reg_applet_dExpired_applet" class="input_rows1" readonly="readonly" size="10"></div></div>';
                $("#<?php echo $id ?>").parent().parent().after(ini);
                $("#v3_reg_applet_dinput_applet").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker({changeMonth:true,
											changeYear:true,
                                            dateFormat:"yy-mm-dd",
                                            onSelect: function(date) {
                                                var d = new Date(date);
                                                var year = d.getFullYear();
                                                var month = d.getMonth();
                                                var day = d.getDate();
                                                var c = new Date(year + 2, month+1, day)
                                                var year1 = c.getFullYear();
                                                var month1 = c.getMonth();
                                                var day1 = c.getDate();
                                                var newdate=year1+'-'+pad(month1)+'-'+pad(day1);
                                                $("#v3_reg_applet_dExpired_applet").val(newdate);
                                            }
                                        });
                                            
                show($("label[for='v3_reg_applet_form_detail_vfileregistrasiApplet']").parent());
                hide($("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent());
        }else{
            hide($("label[for='v3_reg_applet_form_detail_vfileregistrasiApplet']").parent());
            show($("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent());
        }
        $.ajax({
            url: base_url+'processor/plc/v3/reg/applet?action=getTglApplet',
            type: 'post',
            data: 'iupb=<?php echo $iupb_id ?>',
            success: function(data) {
                var o = $.parseJSON(data);
                if(o.c_row>0){
                    $("#v3_reg_applet_ttarget_noreg").val(o.d_row.d_from);
                    $("#v3_reg_applet_dRegistrasi_expired").val(o.d_row.d_valid);
                    $("#v3_reg_applet_vnie").val(o.d_row.c_noreg);
                }else{
                    $("#v3_reg_applet_ttarget_noreg").val("");
                    $("#v3_reg_applet_dRegistrasi_expired").val("");
                    $("#v3_reg_applet_vnie").val("");
                }
            }
        });
        function show (elements, specifiedDisplay) {
            elements = elements.length ? elements : [elements];
            for (var index = 0; index < elements.length; index++) {
                elements[index].style.display = specifiedDisplay || 'block';
            }
        }
        function hide (elements) {
            elements = elements.length ? elements : [elements];
            for (var index = 0; index < elements.length; index++) {
                elements[index].style.display = 'none';
            }
        }
        function pad(d) {
            return (d < 10) ? '0' + d.toString() : d.toString();
        }
        function test() {
            alert("dsadas");
        }
      </script>