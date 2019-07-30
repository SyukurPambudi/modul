<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $iappbd_applet=isset($dataHead["iappbd_applet"])?$dataHead["iappbd_applet"]:"0";
    $ireg_ulang=isset($dataHead["ireg_ulang"])?$dataHead["ireg_ulang"]:"-";
    $iprareg_ulang_reg=isset($dataHead["iprareg_ulang_reg"])?$dataHead["iprareg_ulang_reg"]:"-";
   
    $get=$this->input->get();
    ?>
    <script>
<?php
       if($iupb_id!="0" && $iappbusdev_registrasi==2 && $iprareg_ulang_reg==0 && $ireg_ulang==1){?>
            $("#<?php echo $id ?>").parent().parent().show();

    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().hide();
    <?php }
if ($iappbd_applet ==2 ){ 
        $arra=array(0=>"Tidak",1=>"Ya");
        $value=isset($arra[$dataHead[$field]])?$arra[$dataHead[$field]]:"-";
        ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
      <?php } ?>
      $("#<?php echo $id ?>").change(function(){
            var v = $(this).val();
            if(v=="1"){
                $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_iPic_Registrasi_req_doc']").parent().hide();
                $("label[for='v3_reg_applet_form_detail_tRegistrasi_req_doc']").parent().hide();
            }else{
                $("label[for='v3_reg_applet_form_detail_ibutuh_dok_reg']").parent().show();
                if($("#v3_reg_applet_ibutuh_dok_reg").val()==1){
                    $("label[for='v3_reg_applet_form_detail_iPic_Registrasi_req_doc']").parent().show();
                    $("label[for='v3_reg_applet_form_detail_tRegistrasi_req_doc']").parent().show();
                }
            }
        });
      </script>


<?php
      if($iupb_id==0){
                ?>
                <script>            
					$("#<?php echo $id ?>").parent().parent().remove();
                </script>
                <?php 
            }
        ?>