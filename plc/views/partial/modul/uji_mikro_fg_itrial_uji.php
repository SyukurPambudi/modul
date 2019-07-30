<?php 
	$grid=str_replace("_".$field, "", $id);
	$ifor_id=isset($dataHead["ifor_id"])?$dataHead["ifor_id"]:"0";
	if($ifor_id!="0"){
?>
<script>
	 $.ajax({
		url: base_url+"processor/plc/v3/partial/controllers/plc?action=getnum",
		type: "post",
		data : {ifor_id:<?php echo $ifor_id ?>},
		success: function(data) {
			var o = $.parseJSON(data);
			$("#<?php echo $grid ?>_itrial_uji").val(o.iVersi);
		}
	});
</script>
<?php } ?>