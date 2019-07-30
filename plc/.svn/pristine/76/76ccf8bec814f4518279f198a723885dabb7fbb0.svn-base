<?php 
	$grid=str_replace("_".$field, "", $id);
    $ibuatmbr_id=isset($dataHead["ibuatmbr_id"])?$dataHead["ibuatmbr_id"]:"0";
    if($ibuatmbr_id!=0){
?>
<script>
        $.ajax({
            url: base_url+"processor/plc/v3/partial/controllers/plc?action=getMBRDetails",
            type: "post",
            data : {c_iteno:$("#v3_pembuatan_mbr_c_iteno").val()},
            success: function(data) {
                var o = $.parseJSON(data);
                $("#<?php echo $grid ?>_c_version").val(o.c_version);
                $("#<?php echo $grid ?>_dbuat_mbr").val(o.d_datent);
                $("#<?php echo $grid ?>_dtgl_appr_1").val(o.d_userid1);
                $("#<?php echo $grid ?>_dtgl_appr_2").val(o.d_userid2);
                $("#<?php echo $grid ?>_dtgl_appr_3").val(o.d_userid3);
                $("#<?php echo $grid ?>_dtgl_appr_4").val(o.d_userid4);
                $("#<?php echo $grid ?>_no_mbr").val(o.c_nodoinp);
            }
        });
</script>
    <?php } ?>