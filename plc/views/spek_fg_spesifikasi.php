<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="spek_fg_sediaan_spesifikasi" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Spesifikasi</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Parameter</th>
		<th style="border: 1px solid #dddddd;">Spesifikasi</th>
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
						<span class="master_sediaan_produk_spek_num"><?php echo $i ?></span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 45%">
						<input type="hidden" name="ispekfgsediaan_id[]" value="<?php echo $row['ispekfgsediaan_id'] ?>" />
						<input type="text" name="vspesifikasi[]" value="<?php echo $row['vspesifikasi'] ?>" class="vspesifikasi" style="width: 100%" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 45%">
						<input type="text" name="vvalue[]" value="<?php echo $row['vvalue'] ?>" class="vvalue" style="width: 100%" />
					</td>
					
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="master_sediaan_produk_spek_del" onclick="del_row(this, 'master_sediaan_produk_spek_del')">[Hapus]</a></span>
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
				<span class="master_sediaan_produk_spek_num">1</span>
			</td>		
			<td style="border: 1px solid #dddddd; width: 75%">
				<input type="text" name="vspesifikasi[]" class="vspesifikasi" style="width: 100%" />
			</td>	
			<td style="border: 1px solid #dddddd; width: 45%">
				<input type="text" name="vvalue[]" class="vspesifikasi" style="width: 100%" />
			</td>
			
			<td style="border: 1px solid #dddddd; width: 10%">
				<span class="delete_btn"><a href="javascript:;" class="spek_fg_sediaan_spesifikasi_del" onclick="del_row(this, 'spek_fg_sediaan_spesifikasi_del')">[Delete]</a></span>
			</td>		
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('spek_fg_sediaan_spesifikasi')">Tambah</a></td>
		</tr>
	</tfoot>
</table>