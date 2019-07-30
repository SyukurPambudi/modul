<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $iappbd_applet=isset($dataHead["iappbd_applet"])?$dataHead["iappbd_applet"]:"0";
    $iprareg_ulang_prareg=isset($dataHead["iprareg_ulang_prareg"])?$dataHead["iprareg_ulang_prareg"]:"-";
    $get=$this->input->get();
    ?>

    <script>
<?php
       if($iupb_id!="0" && $iappbusdev_registrasi==2 && $iprareg_ulang_prareg==1){?>
            $("#<?php echo $id ?>").parent().parent().show();
    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().hide();
    <?php }
if ($iappbd_applet ==2 ){
    $arra=array(0=>"Tidak",1=>"Ya");
    $value=isset($dataHead[$field])?$dataHead[$field]:"-"; ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');

      <?php } ?>
      $("#<?php echo $id ?>").change(function(){
                var v = $(this).val();
                if(v=="1"){
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_prareg']").parent().hide();
                    $("#v3_reg_applet_form_detail_ibutuh_dok_prareg").val("");
                }else{
                    $("label[for='v3_reg_applet_form_detail_ibutuh_dok_prareg']").parent().show();
                    $("#v3_reg_applet_form_detail_ibutuh_dok_prareg").val("");
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