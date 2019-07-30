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
       if($iupb_id!="0" && $iappbusdev_registrasi==2 && $ireg_ulang==0&& $ireg_ulang<>""){?>
           // $("label[for='v3_reg_applet_form_detail_vfileregistrasi']").parent().show();

    <?php }else{ ?>
       // $("label[for='v3_reg_applet_form_detail_vfileregistrasi").parent().hide();
    <?php } ?>
      </script>