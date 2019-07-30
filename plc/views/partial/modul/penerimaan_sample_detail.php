<?php
	if (isset($act)){
		if ($act != 'create'){
			$iro_id = $rowDataH['iro_id'];
			$sql = 'SELECT d.irodet_id, d.iro_id, d.ipo_id, d.ireq_id, r.vreq_nomor, d.raw_id, m.vnama, d.ijumlah, d.vrec_jum_pr, d.vsatuan, d.imanufacture_id, s.vNmSatuan, d.plc2_master_satuan_id
						FROM plc2.plc2_upb_ro_detail d 
						JOIN plc2.plc2_upb_request_sample r ON d.ireq_id = r.ireq_id
					    JOIN plc2.plc2_upb_po p ON d.ipo_id = p.ipo_id
					    JOIN plc2.plc2_raw_material m ON d.raw_id = m.raw_id
					    LEFT JOIN plc2.plc2_master_satuan s ON d.plc2_master_satuan_id = s.plc2_master_satuan_id
						WHERE d.iro_id = ? AND d.ldeleted = 0 AND (s.ldeleted = 0 OR s.ldeleted IS NULL)'; 
			$rows = $this->db->query($sql, array($iro_id))->result_array();
		}
	}
?>
<script type="text/javascript">
 	jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<div class="penerimaan_sample_detail_frame">
	<table class="hover_table" id="sample_po_sample" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Bahan Baku</span></th>
		</tr>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No</th>
			<th style="border: 1px solid #dddddd;">Permintaan Sample</th>
			<th style="border: 1px solid #dddddd;">Bahan Baku</th>
			<th style="border: 1px solid #dddddd;">Jumlah Permintaan</th>
			<th style="border: 1px solid #dddddd;">Jumlah Terima</th>
			<th style="border: 1px solid #dddddd;">Satuan</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$i = 0;
				if(!empty($rows)) { //update
				
					foreach($rows as $row) {
					$i++;               
					
			?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
						<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span class="sample_po_sample_num"><?php echo $i ?></span>
						</td>		
						<td style="border: 1px solid #dddddd; width: 15%">
							<input type="hidden" name="detpo_id[]" value="<?php echo $row['ipo_id'] ?>"/>
							<input type="hidden" name="irodet_id[]" value="<?php echo $row['irodet_id'] ?>"/>
							<input type="hidden" name="imanufacture_id[]" value="<?php echo $row['imanufacture_id'] ?>"/>
							<input type="hidden" name="ireq_id[]" value="<?php echo $row['ireq_id'] ?>"/>
							<input readonly="true" type="text" name="detrawname[]" value="<?php echo $row['vreq_nomor'] ?>" class="detreq_id_dis" style="width: 80%" />
							
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<input type="hidden" name="raw_id[]" value="<?php echo $row['raw_id'] ?>" class="detreq_id" />
							<textarea readonly="true" name="rawname[]" class="detraw_id_dis" style="width: 80%"><?php echo $row['vnama'] ?></textarea>
						</td>
						<td style="border: 1px solid #dddddd; width: 5%">
							<?php echo $row['ijumlah'] ?>
							<input type="hidden" name="ijumlah[]" value="<?php echo $row['ijumlah'] ?>" class="detjumlah" style="width: 80%; text-align: right" />
						</td>
						<td style="border: 1px solid #dddddd; width: 5%">
							<input type="text" name="detjum_pr[]" value="<?php echo $row['vrec_jum_pr'] ?>" class="detjum_pr required" style="width: 80%; text-align: right" />
						</td>
						
						<td style="border: 1px solid #dddddd; width: 5%">
							<?php echo $row['vNmSatuan'] ?>
							<input type="hidden" name="vsatuan[]" value="<?php echo $row['plc2_master_satuan_id'] ?>" class="detsatuan" style="width: 80%" />
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