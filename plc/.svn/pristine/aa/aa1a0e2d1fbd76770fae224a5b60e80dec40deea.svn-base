<?php
    $grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $ibe=isset($dataHead["ibe"])?$dataHead["ibe"]:"0";
    ?>
<script>
    <?php
    if($iupb_id=="0"){?>
        $("#<?php echo $id ?>").parent().parent().hide();
        $("#<?php echo $id ?>").removeClass("required");
    <?php }else{ 
        if($ibe==1){
            ?>
                $("#<?php echo $id ?>").parent().parent().show();
                $("#<?php echo $id ?>").removeClass("required").addClass("required");
            <?php
        }else{
            ?>
                $("#<?php echo $id ?>").parent().parent().hide();
                $("#<?php echo $id ?>").removeClass("required");

            <?php
        }
    } 
    ?>
</script>