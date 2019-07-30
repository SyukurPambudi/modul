<script type="text/javascript">
// jQuery(function($) {
		// $('.detjum_pr').autoNumeric('init');
	      
	  // });
 jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
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
				
				$this->db_plc0->where('raw_id', $row['raw_id']);
				$b = $this->db_plc0->get('plc2.plc2_raw_material')->row_array();
				
				$this->db_plc0->where('ipo_id', $row['ipo_id']);
				$c = $this->db_plc0->get('plc2.plc2_upb_po')->row_array();

				$this->db_plc0->where('ireq_id', $row['ireq_id']);
				$r = $this->db_plc0->get('plc2.plc2_upb_request_sample')->row_array();                
				
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="sample_po_sample_num"><?php echo $i ?></span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 15%">
						<input type="hidden" name="ipo_id[]" value="<?php echo $row['ipo_id'] ?>"/>
						<input type="hidden" name="irodet_id[]" value="<?php echo $row['irodet_id'] ?>"/>
						<input disabled="true" type="text" name="detrawname[]" value="<?php echo $r['vreq_nomor'] ?>" class="detreq_id_dis" style="width: 80%" />
						
					</td>
					<td style="border: 1px solid #dddddd; width: 15%">
						<input type="hidden" name="raw_id[]" value="<?php echo $row['raw_id'] ?>" class="detreq_id" />
						<textarea disabled="true" name="rawname[]" class="detraw_id_dis" style="width: 80%"><?php echo $b['vnama'] ?></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<?php echo $row['ijumlah'] ?>
						<input type="hidden" name="detjumlah[]" value="<?php echo $row['ijumlah'] ?>" class="detjumlah" style="width: 80%; text-align: right" />
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="detjum_pr[]" value="<?php echo $row['vrec_jum_pr'] ?>" class="detjum_pr required" style="width: 80%; text-align: right" />
					</td>
					
					<td style="border: 1px solid #dddddd; width: 5%">
						<?php echo $row['vsatuan'] ?>
						<input type="hidden" name="detsatuan[]" value="<?php echo $row['vsatuan'] ?>" class="detsatuan" style="width: 80%" />
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