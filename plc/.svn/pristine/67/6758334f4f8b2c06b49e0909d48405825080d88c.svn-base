<?php
	$bb = explode(',', $bb);
	$sm = explode(',', $sm);
?>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="registrasi_upb_dokumen" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Dokumen Bahan Baku</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Dokumen</th>
		<th style="border: 1px solid #dddddd;">Tersedia</th>				
		<th style="border: 1px solid #dddddd;">Catatan</th>
	</tr>
	</thead>
	<tbody>
		<?php
			$i = 0;
			$abb = $this->db_plc0->get_where('plc2.plc2_upb_registrasi_dokumen_bb_detail', array('iupb_id'=>$iupb_id))->result_array();
			//print_r($abb);
			foreach($bb as $row) {
					if(search_array($row, $abb)) {
					$checked = 'checked';
					$notes = $this->db_plc0->get_where('plc2.plc2_upb_registrasi_dokumen_bb_detail', array('iupb_id'=>$iupb_id, 'idoc_id'=>$row))->row_array();
					$note = $notes['tnote']; 
				}
				else {
					$checked = '';
					$note = '';
				}
				$n = $this->db_plc0->get_where('plc2.plc2_upb_master_dokumen_bb',array('idoc_id' => $row))->row_array();
				if(sizeof($n)==0){
					?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<input type="hidden" name="bbid[]" value="<?php echo $row ?>" />
						<span class="master_sediaan_produk_spek_num">-</span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%; text-align: left">
						-
					</td>	
					<td style="border: 1px solid #dddddd; width: 5%">
						-
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%">
					-</td>					
				</tr>
					<?php
				}
				else{
				$i++;				
				?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<input type="hidden" name="bbid[]" value="<?php echo $row ?>" />
						<span class="master_sediaan_produk_spek_num"><?php echo $i ?></span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%; text-align: left">
						<?php echo $n['vdokumen'] ?>
					</td>	
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="checkbox" <?php echo $checked ?> name="okbb[<?php echo $row ?>]" />
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%">
						<input type="text" name="notebb[<?php echo $row ?>]" value="<?php echo $note ?>" class="" style="width: 100%" />
					</td>					
				</tr>
					<?php
				}
				
			}			
		?>
	</tbody>	
</table>
<br /><br />
<table class="hover_table" id="registrasi_upb_dokumen" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Dokumen Standar Mutu</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Dokumen</th>
		<th style="border: 1px solid #dddddd;">Tersedia</th>				
		<th style="border: 1px solid #dddddd;">Catatan</th>
	</tr>
	</thead>
	<tbody>
		<?php
			$i = 0;
			$asm = $this->db_plc0->get_where('plc2.plc2_upb_registrasi_dokumen_sm_detail', array('iupb_id'=>$iupb_id))->result_array();
			foreach($bb as $row) {
				if(search_array($row, $asm)) {
					$checked = 'checked';
					$notes = $this->db_plc0->get_where('plc2.plc2_upb_registrasi_dokumen_sm_detail', array('iupb_id'=>$iupb_id, 'idoc_id'=>$row))->row_array();
					$note = $notes['tnote']; 
				}
				else {
					$checked = '';
					$note = '';
				}
				$n = $this->db_plc0->get_where('plc2.plc2_upb_master_dokumen_sm',array('idoc_id' => $row))->row_array();
				if(sizeof($n)==0){
				?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<input type="hidden" name="smid[]" value="" />
						<span class="master_sediaan_produk_spek_num">-</span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%; text-align: left">
						-
					</td>	
					<td style="border: 1px solid #dddddd; width: 5%">
						-</td>		
					<td style="border: 1px solid #dddddd; width: 45%">
						-</td>					
				</tr>
				<?php 
				}else{
				$i++;				
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<input type="hidden" name="smid[]" value="<?php echo $row ?>" />
						<span class="master_sediaan_produk_spek_num"><?php echo $i ?></span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%; text-align: left">
						<?php echo $n['vdokumen'] ?>
					</td>	
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="checkbox" <?php echo $checked ?> name="oksm[<?php echo $row ?>]" />
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%">
						<input type="text" name="notesm[<?php echo $row ?>]" value="<?php echo $note ?>" class="" style="width: 100%" />
					</td>					
				</tr>
		<?php
				}
			}			
		?>
	</tbody>	
</table>