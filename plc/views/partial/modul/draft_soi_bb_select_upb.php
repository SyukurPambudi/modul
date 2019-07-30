<?php 
	$modul_fields = $rowData['iM_modul_fileds'];
	$grid = str_replace("_".$field, "", $id);
	$urlpath = str_replace('_', '/', $grid);
	$field = $grid.'_'.$field;
	$base_url = base_url().'processor/plc/'.$urlpath.'?action=getTujuanReq';
 ?>	 

<script>
	var upb = $("#<?php echo $id ?>").val();
	$("#<?php echo $id ?>").change(function(){
		 $.ajax({
			url: "<?php echo $base_url; ?>",
			type: "post",
			data : {
				upb 	: upb,
				field 	: '<?php echo $modul_fields; ?>'
			},
			success: function(data) {
				$("#<?php echo $grid; ?>_iTujuan_req").val(data);
			}
		});
		
	})

	$("#<?php echo $id ?>").change(function(){
		 $.ajax({
			url: "<?php echo $base_url; ?>",
			type: "post",
			data : {
				upb 	: $(this).val(),
				field 	: '<?php echo $modul_fields; ?>'
			},
			success: function(data) {
				$("#<?php echo $grid; ?>_iTujuan_req").val(data);
			}
		});
		
	})
</script>