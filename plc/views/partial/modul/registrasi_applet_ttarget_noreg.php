<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_registrasi=isset($dataHead["iappbusdev_registrasi"])?$dataHead["iappbusdev_registrasi"]:"0";
    $iappbd_applet=isset($dataHead["iappbd_applet"])?$dataHead["iappbd_applet"]:"0";
    $ireg_ulang=isset($dataHead["ireg_ulang"])?$dataHead["ireg_ulang"]:"";
   
    $get=$this->input->get();
    ?>

    <script>
<?php
       if($iupb_id!="0" && $iappbusdev_registrasi==2 && $ireg_ulang==0 && $ireg_ulang <> ""){?>
            $("#<?php echo $id ?>").parent().parent().show();
        $("#<?php echo $id ?>").addClass("required");

    <?php }else{ ?>
        $("#<?php echo $id ?>").parent().parent().hide();
        $("#<?php echo $id ?>").removeClass("required");
    <?php }
/* if ($iappbd_applet ==2 ){ 
        $arra=array(0=>"NIE",1=>"APPLET");
        $value=isset($dataHead[$field])?$dataHead[$field]:"-";
        ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
      <?php } */ ?>
      </script>