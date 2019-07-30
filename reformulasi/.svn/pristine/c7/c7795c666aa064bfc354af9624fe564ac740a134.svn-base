<?php 

	$controller = str_replace('_'.$field, '', $id);

	$field_id 	= $rowData['iM_modul_fields'];
	$modul_id 	= $rowData['iM_modul'];

?>

<script type="text/javascript">
	var id_refor = "#<?php echo $controller.'_iexport_req_refor'; ?>";
	var value 	 = $(id_refor).val();
	/*load_raw(value);*/

	$(id_refor).die();
	$(id_refor).live("change",function(){
		var val_refor = $(this).val();
		load_raw(val_refor);

	})

	function load_raw(refor){
		$.ajax({
            url: base_url+"processor/reformulasi/<?php echo str_replace('_', '/', $controller); ?>?action=load_batch",
            type: "post",
            data : {
                id_refor 		: refor,
                modul_id 		: "<?php echo $modul_id; ?>",
                field_id 		: "<?php echo $field_id; ?>",
            },
            success: function(data) {
            	$("#<?php echo $id; ?>").html(data);
            }
        });
	}
</script>

