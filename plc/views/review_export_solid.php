<table width="75%" border='1'  style ="border-radius:5px;border-collapse:collapse">
		<tr>
			<th width="5%" rowspan="2">No</th>
			<th width="15%" rowspan="2">Kategori</th>
			<th width="80%" rowspan="2">Kelengkapan Data</th>
			<th width="15%" colspan="2">Solid</th>
		</tr>
		<tr>
			<th>ICH-CTD</th>
			<th>EU-CTD</th>
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
					<input type="hidden" name="idossier_dokumen_id[]" value="<?php echo $list['idossier_dokumen_id']   ?>" >

				</td>
				<td align="center">
					<input type="checkbox" name="eSolid_ich[]" value="Y" checked="checked" disabled="disabled">
				</td>
				<td align="center">
					<input type="checkbox" name="eSolid_eu[]" value="Y" checked="checked" disabled="disabled">
				</td>
			</tr>
		<?php
			$no++;
			}
		?>
</table>