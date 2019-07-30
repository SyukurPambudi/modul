<script type="text/javascript">
	function browse_multi1_sample_permintaan_sample(url, title, dis, param) {
		var i = $('.btn_browse_bb').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
	
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="bahan_baku_analisa_sample" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Pemeriksaan Bahan Baku</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No. Urut</th>
		<th style="border: 1px solid #dddddd;">Uraian</th>
		<th style="border: 1px solid #dddddd;">Spesifikasi</th>
		<th style="border: 1px solid #dddddd;">Hasil</th>
		<th style="border: 1px solid #dddddd;">Cat. Hasil</th>
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
						<input type="hidden" name="irawdet_id[]" value="<?php echo $row['irawdet_id'] ?>" class="irawdet_id" />
						<input class="required" type="text" name="ino_urut[]" value="<?php echo $row['ino_urut'] ?>" style="width: 40%">
					</td>		
					<td style="border: 1px solid #dddddd; width: 30%">
						<textarea class="required" name="vuraian[]" style="width: 90%"><?php echo $row['vuraian'] ?></textarea>
					</td>	
					<td style="border: 1px solid #dddddd; width: 30%">
						<textarea name="vspesifikasi[]" style="width: 90%"><?php echo $row['vspesifikasi'] ?></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 15%">
						
						<select name="ihasil[]">
							<option value="">[Pilih]</option>
							<?php 
							if($row['ihasil']==1){
								echo '<option value="1" selected>MS</option>
								<option value="0">TMS</option>';
								}
							elseif($row['ihasil']==0){
								echo '<option value="1">MS</option>
								<option value="0" selected>TMS</option>';
								}
							?>
							
						</select>
					</td>
					<td style="border: 1px solid #dddddd; width: 30%">
						<input type="text" name="vhasil[]" value="<?php echo $row['vhasil'] ?>" style="width: 100%" />
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bahan_baku_analisa_sample_del" onclick="del_row(this, 'bahan_baku_analisa_sample_del')">[Hapus]</a></span>
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
				<input type="hidden" name="irawdet_id[]" value="" class="irawdet_id" />
				<input type="text" class="required" name="ino_urut[]" value="" style="width: 50%"/>
			</td>		
			<td style="border: 1px solid #dddddd; width: 30%">
				<textarea name="vuraian[]" class="required" style="width: 90%"></textarea>
				
			</td>	
			<td style="border: 1px solid #dddddd; width: 30%">
				<textarea name="vspesifikasi[]" style="width: 90%"></textarea>
			</td>
			<td style="border: 1px solid #dddddd; width: 15%">
				<select name="ihasil[]">
					<option value="">[Pilih]</option>
					<option value="1">MS</option>
					<option value="0">TMS</option>
				</select>
			</td>
			<td style="border: 1px solid #dddddd; width: 30%">
				<input type="text" name="vhasil[]" value="" style="width: 90%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 10%">
				<span class="delete_btn"><a href="javascript:;" class="bahan_baku_analisa_sample_del" onclick="del_row(this, 'bahan_baku_analisa_sample_del')">[Hapus]</a></span>
			</td>		
				</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('bahan_baku_analisa_sample')">Tambah</a></td>
		</tr>
	</tfoot>
</table>