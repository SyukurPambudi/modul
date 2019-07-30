<?php 
	$grid 		= str_replace("_".$field, "", $id);
	$field_id 	= $rowData['iM_modul_fields'];

?>

<script type="text/javascript">
	var idexp = "#<?php echo $grid; ?>_iexport_req_refor";
	var iexp = $(idexp).val();
	load_detail(iexp);

	$(idexp).die();
	$(idexp).live("change",function(){
		var idval = $(this).val();
		load_detail(idval);
	});

	function load_detail (id) { 
		$.ajax({
            url: base_url+"processor/reformulasi/<?php echo str_replace('_', '/', $grid); ?>?action=load_detail",
            type: "post",
            data : {
                field_id 	: "<?php echo $field_id; ?>",
                id_refor 	: id,
                id 			: "<?php echo $id; ?>"
            },
            success: function(data) {
            	$("#<?php echo $id; ?>").html(data);
            }
        });
	}
</script>