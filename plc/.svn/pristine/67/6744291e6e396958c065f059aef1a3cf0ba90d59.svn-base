<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_prareg=isset($dataHead["iappbusdev_prareg"])?$dataHead["iappbusdev_prareg"]:"";
    $get=$this->input->get();
?>
<script>
    <?php
       if($iupb_id!="0" && $iappbusdev_prareg==2){?>
            $("#<?php echo $id ?>").parent().parent().show();
    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().hide();
    <?php } ?>

    $("#<?php echo $id ?>").change(function(){
        var v = $(this).val();
        if(v=="1"){
            $(this).parent().parent().next().show();
            $("#v3_prareg_hpr_imutu_prareg").addClass("required");
            $("#v3_prareg_hpr_ibutuh_dok_prareg").addClass("required");
        }else{
            $(this).parent().parent().next().next().hide();
            $(this).parent().parent().next().hide();
            $("#v3_prareg_hpr_imutu_prareg").removeClass("required");
            $("#v3_prareg_hpr_ibutuh_dok_prareg").removeClass("required");

        }
        $("label[for='v3_prareg_hpr_form_detail_iPic_Prareg_req_doc']").parent().hide();
        $("label[for='v3_prareg_hpr_form_detail_tPrareg_req_doc']").parent().hide();
        $("#v3_prareg_hpr_imutu_prareg").val("");
        $("#v3_prareg_hpr_ibutuh_dok_prareg").val("");
    });
</script>