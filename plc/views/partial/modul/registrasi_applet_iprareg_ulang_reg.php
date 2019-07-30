<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $iappbd_applet=isset($dataHead["iappbd_applet"])?$dataHead["iappbd_applet"]:"0";
    $ineed_prareg=isset($dataHead["ineed_prareg"])?$dataHead["ineed_prareg"]:"-";
    $iprareg_ulang_reg=isset($dataHead["iprareg_ulang_reg"])?$dataHead["iprareg_ulang_reg"]:"-";
   
    $get=$this->input->get();
    ?>

    <script>
<?php 
        if($iupb_id!="0" && $iappbusdev_registrasi==2){?>
            $("#<?php echo $id ?>").parent().parent().show();

    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().hide();
    <?php }
if ($iappbd_applet ==2){ 
        $arra=array(0=>"Tidak",1=>"Ya");
        $value=isset($arra[$dataHead[$field]])?$arra[$dataHead[$field]]:"-";
        ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
      <?php } 
      if($ineed_prareg==0){?>
        $("#<?php echo $id; ?>").parent().html('<input type="hidden" class="input_rows1" name="iprareg_ulang_reg" readonly="readonly" size="15" value="0"> Tidak'); 
      <?php } ?>
      $("#<?php echo $id ?>").change(function(){
                var v = $(this).val();
                if(v=="1"){
                    $("label[for='v3_reg_applet_form_detail_ireg_ulang']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_imutu_reg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_tRegistrasi_req_doc']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_iPic_Registrasi_req_doc']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_imutu_prareg']").parent().show();
                    $("#v3_reg_applet_form_detail_imutu_prareg").val("");
                    $("#v3_reg_applet_form_detail_ibutuh_dok_prareg").val("");
                    $("label[for='v3_reg_applet_form_detail_ttarget_noreg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_vnie']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_dRegistrasi_expired']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_iHasil_registrasi']").parent().hide();
                }else{
                    $("label[for='v3_reg_applet_form_detail_imutu_prareg']").parent().hide();
                    //alert('rerre');
                    $("label[for='v3_reg_applet_form_detail_imutu_prareg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_prareg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_ireg_ulang']").parent().show();
                    $("#v3_reg_applet_form_detail_ireg_ulang").val("");
                    $("#v3_reg_applet_form_detail_imutu_reg").val("");
                    $("#v3_reg_applet_form_detail_ibutuh_dok_reg").val("");
                    $("label[for='v3_reg_applet_form_detail_imutu_reg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_tRegistrasi_req_doc']").parent().hide();
                    $("label[for='v3_reg_applet_form_detail_iPic_Registrasi_req_doc']").parent().hide();
                    $("#v3_reg_applet_form_detail_imutu_reg").val("");
                    if($("#v3_reg_applet_ireg_ulang").val()==0){
                        $("label[for='v3_reg_applet_form_detail_ttarget_noreg']").parent().show();
                        $("label[for='v3_reg_applet_form_detail_vnie']").parent().show();
                        $("label[for='v3_reg_applet_form_detail_dRegistrasi_expired']").parent().show();
                        $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent().show();
                    }else{
                        $("label[for='v3_reg_applet_form_detail_ttarget_noreg']").parent().hide();
                        $("label[for='v3_reg_applet_form_detail_vnie']").parent().hide();
                        $("label[for='v3_reg_applet_form_detail_dRegistrasi_expired']").parent().hide();
                        $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent().hide();
                    }
                }
            });
      </script>