<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_prareg=isset($dataHead["iappbusdev_prareg"])?$dataHead["iappbusdev_prareg"]:"0";
    $iprareg_ulang_prareg=isset($dataHead["iprareg_ulang_prareg"])?$dataHead["iprareg_ulang_prareg"]:"";
    $imutu_prareg=isset($dataHead["imutu_prareg"])?$dataHead["imutu_prareg"]:"";
    $get=$this->input->get();
?>
<script>
    <?php
       if($iupb_id!="0" && $iappbusdev_prareg==2 && $iprareg_ulang_prareg==1 && $imutu_prareg==0){?>
            $("#<?php echo $id ?>").parent().parent().show();
    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().hide();
    <?php } ?>
    $("#<?php echo $id ?>").change(function(){
            if($(this).val()==1){
                $("label[for='v3_prareg_hpr_form_detail_iPic_Prareg_req_doc']").parent().show();
                $("label[for='v3_prareg_hpr_form_detail_tPrareg_req_doc']").parent().show();
            }else{
                $("label[for='v3_prareg_hpr_form_detail_iPic_Prareg_req_doc']").parent().hide();
                $("label[for='v3_prareg_hpr_form_detail_tPrareg_req_doc']").parent().hide();
            }
        });

    </script>