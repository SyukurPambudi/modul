<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_prareg=isset($dataHead["iappbusdev_prareg"])?$dataHead["iappbusdev_prareg"]:"0";
    $iappbd_hpr=isset($dataHead["iappbd_hpr"])?$dataHead["iappbd_hpr"]:"0";
    $iprareg_ulang_prareg=isset($dataHead["iprareg_ulang_prareg"])?$dataHead["iprareg_ulang_prareg"]:"";
    $imutu_prareg=isset($dataHead["imutu_prareg"])?$dataHead["imutu_prareg"]:"";
    $ibutuh_dok_prareg=isset($dataHead["ibutuh_dok_prareg"])?$dataHead["ibutuh_dok_prareg"]:"";
    $value=isset($dataHead[$field])?$dataHead[$field]:"-";
    $get=$this->input->get();?>
    <script>
        <?php
    if($iupb_id!="0" && $iappbusdev_prareg==2 && $iprareg_ulang_prareg==1 && $imutu_prareg==0 && $ibutuh_dok_prareg==1){?>
        $("#<?php echo $id ?>").parent().parent().show();
    <?php }else{ ?>
    $("#<?php echo $id ?>").parent().parent().hide();
    <?php } 
    if ($iappbd_hpr ==2 ){ ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
           <?php } ?>
    </script>