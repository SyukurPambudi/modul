<?php 
	$grid 		= str_replace("_".$field, "", $id);
	$upb_id 	= 0;
    $revisi     = 0;
    $iM_modul 	= $rowData['iM_modul'];
    $getFile 	= $this->db->get_where('plc3.m_modul_fileds', array('iM_modul' => $iM_modul, 'vNama_field' => 'file_tentative', 'lDeleted' => 0))->row_array();
    $fileDetail = $getFile['vFile_detail'];

    if (isset($dataHead)){
        $upb_id     = $dataHead['iupb_id'];
        $revisi     = $dataHead['irevisi'];
    }
?>
<script>
	var upb_id = "<?php echo $upb_id; ?>";
	var revisi = "<?php echo $revisi; ?>";
	load_soi_fg_tentative(upb_id, revisi, false);

	$("#<?php echo $id ?>").change(function(){
		var upb_id = $(this).val();
		var revisi = 0;
		load_soi_fg_tentative(upb_id, revisi, true);
	})

	function load_soi_fg_tentative (upb, revisi, load_data){
		$.ajax({
			url: base_url+"processor/plc/v3/partial/controllers/plc?action=getDetailSoiFgTentative",
			type: "post",
			data : {
				iupb_id 	: upb,
				irevisi 	: revisi,
				file 		: "<?php echo $fileDetail; ?>",
			},
			success: function(data) {
				var o = $.parseJSON(data);
				if (load_data){
					$("#<?php echo $grid ?>_vkode_surat").val(o.vkode_surat);
					$("#<?php echo $grid ?>_dmulai_draft").val(o.dmulai_draft);
					$("#<?php echo $grid ?>_dselesai_draft").val(o.dselesai_draft);
					$("#<?php echo $grid ?>_vnip_formulator").val(o.nip);
				}
				$(".v3_table_soi_fg_file_tentative").html(o.file);
			}
		});
	}
</script>