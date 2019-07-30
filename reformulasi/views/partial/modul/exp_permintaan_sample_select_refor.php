<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/
		// print_r($rowData);
		// print_r($field);
		// print_r($id);
		// exit();

	$controller = str_replace('_'.$field, '', $id);
	$controller = str_replace('_', '/', $controller);

	$field_id 	= $rowData['iM_modul_fields'];
	$modul_id 	= $rowData['iM_modul'];

?>

<script type="text/javascript">
	var id_refor = "#<?php echo $id; ?>";
	$(id_refor).die();
	$(id_refor).live("change",function(){
		var val_refor = $(this).val();
		load_raw(val_refor);

	})

	function load_raw(refor){
		$.ajax({
            url: base_url+"processor/reformulasi/<?php echo $controller; ?>?action=load_raw",
            type: "post",
            data : {
                id_refor 		: refor,
                modul_id 		: "<?php echo $modul_id; ?>",
                field_id 		: "<?php echo $field_id; ?>",
            },
            success: function(data) {
            	$(".exp_permintaan_sample_raw_div").html(data);
            }
        });
	}
</script>

<span class="span_permintaan_sample_upd">

</span> 
