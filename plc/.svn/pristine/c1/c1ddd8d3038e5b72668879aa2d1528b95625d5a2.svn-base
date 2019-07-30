<?php

	$rows = array();
	if (isset($act)){
		if ($act != 'create'){
			$ivalidasi_id = $rowDataH['ivalidasi_id'];
			$rows = $this->db->get_where('plc2.validasi_proses_batch', array('ivalidasi_id'=>$ivalidasi_id,'ldeleted'=>0))->result_array();
		}
	}

?>

<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="validasi_proses_batch" cellspacing="0" cellpadding="1" style="width: 100%; border: 1px solid #dddddd; text-align: center; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Nomor Batch</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Nomor Batch</th>
		<th style="border: 1px solid #dddddd;">Action</th>		
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
						<span class="validasi_proses_batch_num"><?php echo $i ?></span>
						<input type="hidden" name="ivalpro_batch_id[]" value="<?php echo $row['ivalpro_batch_id'] ?>" />
					</td>
					<td style="border: 1px solid #dddddd; width: 85%">
						<input style="width: 90%;" type="text" class="required" name="vno_batch[]" value="<?php echo $row['vno_batch']; ?>" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="validasi_proses_batch_del" onclick="del_row(this, 'validasi_proses_batch_del')">[Hapus]</a></span>
					</td>		
				</tr>
		<?php
				}
			}
			else {
			//$i++;
		?>
			<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="validasi_proses_batch_num">1</span>
						<input type="hidden" name="ivalpro_batch_id[]" value="" />
				</td>
				<td style="border: 1px solid #dddddd; width: 85%">
					<input style="width: 90%;" type="text" class="required" name="vno_batch[]" />
				</td>		
				<td style="border: 1px solid #dddddd; width: 10%">
					<span class="delete_btn"><a href="javascript:;" class="validasi_proses_batch_del" onclick="del_row(this, 'validasi_proses_batch_del')">[Hapus]</a></span>
				</td>		
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('validasi_proses_batch')">Tambah</a></td>
		</tr>
	</tfoot>
</table>