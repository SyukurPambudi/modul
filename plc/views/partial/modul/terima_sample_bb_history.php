<?php
	$act;
	if (isset($act)){
		if ($act != 'create'){
			$ireq_id = $rowDataH['ireq_id'];
			$raw_id = $rowDataH['raw_id'];
			$sql = 'SELECT b.raw_id,a.vreq_nomor,b.ijumlah AS jumlah_req,cc.vpo_nomor,c.ijumlah AS jumlah_po,dd.vro_nomor,d.ijumlah AS jml_terima_purc
						FROM plc2.plc2_upb_request_sample a 
						JOIN plc2.plc2_upb_request_sample_detail b ON b.ireq_id=a.ireq_id
						JOIN plc2.plc2_upb_po_detail c ON c.ireq_id = a.ireq_id 
						JOIN plc2.plc2_upb_po cc ON cc.ipo_id = c.ipo_id
						JOIN plc2.plc2_upb_ro_detail d ON d.raw_id=c.raw_id AND d.ipo_id=cc.ipo_id
						JOIN plc2.plc2_upb_ro dd ON dd.iro_id = d.iro_id
						WHERE a.ireq_id = ?
							AND b.raw_id = ?
							AND a.ldeleted = 0
							AND b.ldeleted = 0
							AND c.ldeleted = 0
							AND cc.ldeleted = 0
							AND d.ldeleted = 0
							AND dd.ldeleted = 0';
			$rows = $this->db->query($sql, array($ireq_id, $raw_id))->result_array();
		}
	}
?>
<script type="text/javascript">
 	jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});

 	if ('<?php echo $act; ?>' == 'update'){
 		var team = '<?php echo $rowDataH["team"]; ?>';
 		var isort = '<?php echo $rowDataH["iSort"]; ?>';
 		var arrTeam = team.split(',');
 		var isPD = jQuery.inArray('PD', arrTeam);
 		var isAD = jQuery.inArray('AD', arrTeam);
 		var isQA = jQuery.inArray('QA', arrTeam);
 		
 		if (isPD !== -1 && isort == 1){
 			//menghilangkan required class ad
	        $("#v3_terima_sample_bb_vrec_jum_qc").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_nip_qc").removeClass("required error_text");
	        $("#v3_terima_sample_bb_trec_date_qc").removeClass("required error_text");
			
			//menghilangkan required class qa
	        $("#v3_terima_sample_bb_vrec_jum_qa").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_nip_qa").removeClass("required error_text");
	        $("#v3_terima_sample_bb_trec_date_qa").removeClass("required error_text");

	        //menambahkan class required
        	$("#v3_terima_sample_bb_iUjiMikro_bb").addClass("required");
        	$("#v3_terima_sample_bb_vwadah").addClass("required");
        	$("#v3_terima_sample_bb_vrec_jum_pd").addClass("required");
        	$("#v3_terima_sample_bb_vrec_nip_pd").addClass("required");
        	$("#v3_terima_sample_bb_trec_date_pd").addClass("required");

 		} else if (isAD !== -1 && isort == 2){
 			//menghilangkan required class pd
	        $("#v3_terima_sample_bb_iUjiMikro_bb").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vwadah").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_jum_pd").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_nip_pd").removeClass("required error_text");
	        $("#v3_terima_sample_bb_trec_date_pd").removeClass("required error_text");

			//menghilangkan required class qa
	        $("#v3_terima_sample_bb_vrec_jum_qa").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_nip_qa").removeClass("required error_text");
	        $("#v3_terima_sample_bb_trec_date_qa").removeClass("required error_text");

	        //menambahkan class required
        	$("#v3_terima_sample_bb_vrec_jum_qc").addClass("required");
        	$("#v3_terima_sample_bb_vrec_nip_qc").addClass("required");
        	$("#v3_terima_sample_bb_trec_date_qc").addClass("required");

 		} else if (isQA !== -1 && isort == 3){
 			//menghilangkan required class pd
	        $("#v3_terima_sample_bb_iUjiMikro_bb").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vwadah").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_jum_pd").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_nip_pd").removeClass("required error_text");
	        $("#v3_terima_sample_bb_trec_date_pd").removeClass("required error_text");

 			//menghilangkan required class ad
	        $("#v3_terima_sample_bb_vrec_jum_qc").removeClass("required error_text");
	        $("#v3_terima_sample_bb_vrec_nip_qc").removeClass("required error_text");
	        $("#v3_terima_sample_bb_trec_date_qc").removeClass("required error_text");
	        
	        //menambahkan class required
        	$("#v3_terima_sample_bb_vrec_jum_qa").addClass("required");
        	$("#v3_terima_sample_bb_vrec_nip_qa").addClass("required");
        	$("#v3_terima_sample_bb_trec_date_qa").addClass("required");

 		}
 	}

</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<div class="penerimaan_sample_detail_frame">
	<table class="hover_table" id="sample_po_sample" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">History Terima Sample</span></th>
		</tr>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No</th>
			<th style="border: 1px solid #dddddd;">No. Request</th>
			<th style="border: 1px solid #dddddd;">Jumlah Request PD</th>
			<th style="border: 1px solid #dddddd;">No. PO</th>
			<th style="border: 1px solid #dddddd;">Jumlah PO</th>
			<th style="border: 1px solid #dddddd;">No. Terima</th>
			<th style="border: 1px solid #dddddd;">Jml Terima Purch</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$i = 0;
				if(!empty($rows)) {
					foreach($rows as $row) {
					$i++;
			?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
						<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span class="sample_po_sample_num"><?php echo $i ?></span>
						</td>		
						<td style="border: 1px solid #dddddd; width: 15%">
							<?php echo $row['vreq_nomor'] ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<?php echo $row['jumlah_req'] ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<?php echo $row['vpo_nomor'] ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<?php echo $row['jumlah_po'] ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<?php echo $row['vro_nomor'] ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<?php echo $row['jml_terima_purc'] ?>
						</td>
								
					</tr>
			<?php
					}
				}
			
			?>
			
		</tbody>
		<tfoot>
			
		</tfoot>
	</table>
</div>