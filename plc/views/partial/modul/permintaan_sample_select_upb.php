<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

	$iupb_id = 0;
	$vupb_id = '';
	if ($act=='update' || $act=='view') {
		$iupb_id = $row_value;
		$sql = "SELECT vupb_nomor FROM plc2.plc2_upb WHERE iupb_id = ?";
		$upb = $this->db->query($sql, array($iupb_id))->row_array();
		if (!empty($upb)){
			$vupb_id = $upb['vupb_nomor'];
		}
	}

		// print_r($rowDataH);exit();

?>

 <script type="text/javascript">
 	$("#v3_permintaan_sample_vupb_nama").attr("readonly","true");
 	$("#v3_permintaan_sample_iteampd_id").attr("readonly","true");
 	var idtujuan = "#v3_permintaan_sample_iTujuan_req";
 	var tujuan = $(idtujuan).val();
	changeLoadUPB(tujuan, "<?php echo $iupb_id; ?>", 1);

	$(idtujuan).die();
	$(idtujuan).live("change",function(){
		$("#v3_permintaan_sample_upb_id").val('');
		$("#v3_permintaan_sample_iupb_id_dis").val('');
		if ($( this ).val()=="") {
			alert("Tujuan harus diisi");
		}
		var existing = ($(this).val()==tujuan)?1:0;
		changeLoadUPB($(this).val(), "<?php echo $iupb_id; ?>", existing);

	})

	function changeLoadUPB (tujuanReq, upb, existing) {
		$.ajax({
            url: base_url+"processor/plc/v3/permintaan/sample?action=load_upb",
            type: "post",
            data : {
                tujuan: tujuanReq,
                upb: upb,
                modul_id: "<?php echo $modul_id; ?>",
                existing: existing
            },
            success: function(data) {
            	$(".span_permintaan_sample_upb").html(data);
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
<span class="span_permintaan_sample_upb">

</span> 
