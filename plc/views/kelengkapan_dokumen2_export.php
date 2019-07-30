<table width="75%" border='1'  style ="border-radius:5px;border-collapse:collapse">
		<tr>
			<th width="5%" rowspan="2">No</th>
			<th width="10%" rowspan="2">Kategori</th>
			<th width="70%" rowspan="2">Kelengkapan Data</th>
			<th width="15%" colspan="2">Kelengkapan Dokumen I</th>
			<th width="15%" colspan="2">Kelengkapan Dokumen II</th>
		</tr>
		<tr>
			<th>Ya</th>
			<th>Tidak</th>
			<th>Ya</th>
			<th>Tidak</th>
		</tr>
		<input type="hidden" name="jenissediaan" value="<?php echo $iSediaan   ?>" >
		<?php $no = 1;
		foreach($docs as $list) 
		{ 
			
		?>
			<tr>
				<td align="right"><?php echo $no ?></td>
				<td>
					<?php echo $list['vNama_Kategori'] ?>

				</td>
				<td>
					<?php echo $list['vNama_Dokumen'] ?>
					<input type="hidden" name="idossier_dok_list_id[]" value="<?php echo $list['idossier_dok_list_id']   ?>" >

				</td>
				<td align="center">
					<input type="radio" disabled="TRUE" name="iStatus_kelengkapan1_<?php echo $list['idossier_dok_list_id']   ?>[]" value="1" <?php echo ($list['iStatus_kelengkapan1']=='1')?'checked':'' ?>  >
				</td>
				<td align="center">
					<input type="radio" disabled="TRUE" name="iStatus_kelengkapan1_<?php echo $list['idossier_dok_list_id']   ?>[]" value="0" <?php echo ($list['iStatus_kelengkapan1']=='0')?'checked':'' ?>   >
				</td>
				<td align="center">
					<input type="radio" name="iStatus_kelengkapan2_<?php echo $list['idossier_dok_list_id']   ?>[]" value="1" <?php echo ($list['iStatus_kelengkapan2']=='1')?'checked':'' ?>  >
				</td>
				<td align="center">
					<input type="radio" name="iStatus_kelengkapan2_<?php echo $list['idossier_dok_list_id']   ?>[]" value="0" <?php echo ($list['iStatus_kelengkapan2']=='0')?'checked':'' ?>   >
				</td>
			</tr>
		<?php
			$no++;
			}
		?>
</table>