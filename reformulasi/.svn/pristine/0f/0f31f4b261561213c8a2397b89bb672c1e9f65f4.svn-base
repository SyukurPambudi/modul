<?php 
	$grid 		= str_replace("_".$field, "", $id);
	$field_id 	= $rowData['iM_modul_fields'];
?>

<script type="text/javascript">
	var idexp = "#<?php echo $id; ?>";
	var iexp = $(idexp).val();
	showHideSample();

	$(idexp).die();
	$(idexp).live("change",function(){
		var idval = $(this).val();
		showHideSample();
	});

	function showHideSample(){
		var idSample = "#<?php echo $grid; ?>_ineed_sample";
		var valueTrial = $(idexp).val();
		$(idSample).val('0').trigger("liszt:updated");
		if (valueTrial == 1){
			$("label[for='<?php echo $grid; ?>_form_detail_ineed_sample_trial']").parent().show();
		} else {
			$("label[for='<?php echo $grid; ?>_form_detail_ineed_sample_trial']").parent().hide();
		}
	}
</script>