<table width="100%" border='1'  style ="border-radius:5px;border-collapse:collapse">
		<tr>
			<th width="5%" rowspan="2">No</th>
			<th width="15%" rowspan="2">Kategori</th>
			<th width="55%" rowspan="2">Kelengkapan Data</th>
			<th width="15%" colspan="2">Solid</th>
			<th width="15%" colspan="2">Status Dokumen</th>
			<th width="20%" rowspan="2" >Verifikasi <br>Andev Man</th>
			<th width="20%" rowspan="2" >Konfirmasi</th>
		</tr>
		<tr>
			<th>ICH-CTD</th>
			<th>EU-CTD</th>
			<th>Tersedia</th>
			<th>Belum Tersedia</th>
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
					<input type="checkbox" name="eSolid_ich[]" value="Y" checked="checked" disabled="disabled">
				</td>
				<td align="center">
					<input type="checkbox" name="eSolid_eu[]" value="Y" checked="checked" disabled="disabled">
				</td>
				<td align="center">
					<input type="radio"  disabled="disabled" name="istatus_keberadaan_<?php echo $list['idossier_dok_list_id']   ?>[]" value="1" <?php echo ($list['istatus_keberadaan']=='1')?'checked':'' ?>  >
				</td>
				<td align="center">
					<input type="radio" disabled="disabled" name="istatus_keberadaan_<?php echo $list['idossier_dok_list_id']   ?>[]" value="0" <?php echo ($list['istatus_keberadaan']=='0')?'checked':'' ?>   >
				</td>

				<td align="center">
					<input type="checkbox"  disabled="disabled" name="istatus_verifikasi_<?php echo $list['idossier_dok_list_id']   ?>[]" value="1" <?php echo ($list['istatus_verifikasi']==1 ? 'checked' : '');?>>
				</td>
				<td align="center">
					<input type="checkbox"  name="istatus_confirm_<?php echo $list['idossier_dok_list_id']   ?>[]" value="1" <?php echo ($list['iStatus_confirm']==1 ? 'checked' : '');?>>
				</td>

			</tr>
		<?php
			$no++;
			}
		?>
</table>