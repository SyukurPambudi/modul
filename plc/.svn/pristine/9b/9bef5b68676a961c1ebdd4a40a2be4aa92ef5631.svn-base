<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbusdev_prareg=isset($dataHead["iappbusdev_prareg"])?$dataHead["iappbusdev_prareg"]:"0";
    $iappbd_hpr=isset($dataHead["iappbd_hpr"])?$dataHead["iappbd_hpr"]:"0";
    $value=isset($dataHead[$field])?$dataHead[$field]:"-";
    $get=$this->input->get();?>
    <script>
        <?php
    if($iupb_id!="0" && $iappbusdev_prareg==2){?>
        $("#<?php echo $id ?>").parent().parent().show();
    <?php }else{ 
            $sqlcekbutuh = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$iupb_id.'"';
            $upebeh = $this->db_plc0->query($sqlcekbutuh)->row_array();
            $ibutuh_dok_prareg =isset($upebeh['ibutuh_dok_prareg'])?$upebeh['ibutuh_dok_prareg']:"-";
                if($ibutuh_dok_prareg == 1){
            ?>
                    $("#<?php echo $id ?>").parent().parent().hide();
    <?php 
                }
            } 
    if ($iappbd_hpr ==2 ){ ?>
        $("#<?php echo $id; ?>").parent().html('<input type="text" class="input_rows1" readonly="readonly" size="15" value="<?php echo $value; ?>">');
           <?php } ?>
    </script>