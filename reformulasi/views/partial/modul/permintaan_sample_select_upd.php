<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

	$field_id = $form_field['iM_modul_fields'];
	$iupb_id = 0;
	$vupb_id = '';
	$isCreate = 1;
	if ($act=='update' || $act=='view') {
		$iupb_id = $row_value;
		$isCreate = 0;
	}

?>

 <script type="text/javascript">
 	$("#v3_export_request_sample_vupb_nama").attr("readonly","true");
 	$("#v3_export_request_sample_iteampd_id").attr("readonly","true");
 	var idtujuan = "#v3_export_request_sample_iTujuan_request";
 	var tujuan = $(idtujuan).val();
	changeLoadUPB(tujuan, "<?php echo $iupb_id; ?>", 1);

	$(idtujuan).die();
	$(idtujuan).live("change",function(){
		$("#v3_export_request_sample_upb_id").val('');
		$("#v3_export_request_sample_iupb_id_dis").val('');
		if ($( this ).val()=="") {
			alert("Tujuan harus diisi");
		}
		var existing = ($(this).val()==tujuan)?1:0;
		changeLoadUPB($(this).val(), "<?php echo $iupb_id; ?>", existing);

	})

	function changeLoadUPB (tujuanReq, upb, existing) {
		$.ajax({
            url: base_url+"processor/reformulasi/v3/export/request/sample?action=load_upd",
            type: "post",
            data : {
                tujuan 		: tujuanReq,
                upb 		: upb,
                modul_id 	: "<?php echo $modul_id; ?>",
                existing 	: existing,
                field_id 	: "<?php echo $field_id; ?>",
                is_create 	: "<?php echo $isCreate; ?>",
            },
            success: function(data) {
            	$(".span_permintaan_sample_upd").html(data);
            }
        });
	}

	$( "button.icon_pop" ).button({
		icons: {
			primary: "ui-icon-newwin"
		},
		text: false
	})
</script>

<span class="span_permintaan_sample_upd">

</span> 
