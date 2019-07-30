<?php 
	$grid=str_replace("_".$field, "", $id);
?>
<script>
	$("#<?php echo $id ?>").change(function(){
		 $.ajax({
			url: base_url+"processor/plc/v3/partial/controllers/plc?action=getnum",
			type: "post",
			data : {ifor_id:$(this).val()},
			success: function(data) {
				var o = $.parseJSON(data);
				$("#<?php echo $grid ?>_itrial_uji").val(o.iVersi);
			}
		});
		
	})
</script>