<script type="text/javascript">
	// jQuery(function($) {
		// $('.detjumlah').autoNumeric('init');
	     
	  // });
	  jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
	
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="sample_robatch_sample" cellspacing="0" cellpadding="1" style="width: 75%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Batch</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">No Batch</th>
		<th style="border: 1px solid #dddddd;">Jumlah</th>
		<th style="border: 1px solid #dddddd;">Satuan</th>
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
						<span class="sample_robatch_sample_num"><?php echo $i ?></span>
						<input type="hidden" name="ibatch_id[]" value="<?php echo $row['ibatch_id'] ?>" />
					</td>
					<td style="border: 1px solid #dddddd; width: 25%">
						<input type="text" name="det_nobatch[]" value="<?php echo $row['vbatch_nomor'] ?>" class="vbatch_nomor required" style="width: 80%; text-align: right" />
					</td>
					<td style="border: 1px solid #dddddd; width: 20%">
						<input type="text" name="detjumlah[]" value="<?php echo $row['iJumlah'] ?>" class="detjumlah required" style="width: 80%; text-align: right" />
					</td>
					<td style="border: 1px solid #dddddd; width: 25%">
						<input type="text" name="detsatuan[]" class="detsatuan" value="<?php echo $row['vSatuan'] ?>" style="width: 80%; text-align: right" />
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="sample_robatch_sample_del" onclick="del_row(this, 'sample_robatch_sample_del')">[Hapus]</a></span>
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
						<span class="sample_robatch_sample_num">1</span>
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
						<input type="text" name="det_nobatch[]" class="vbatch_nomor" style="width: 80%; text-align: right" />
				</td>
				<td style="border: 1px solid #dddddd; width: 20%">
						<input type="text" name="detjumlah[]" class="detjumlah" style="width: 80%; text-align: right" />
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
						<input type="text" name="detsatuan[]" class="detsatuan" style="width: 80%; text-align: right" />
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="sample_robatch_sample_del" onclick="del_row(this, 'sample_robatch_sample_del')">[Hapus]</a></span>
				</td>		
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('sample_robatch_sample')">Tambah</a></td>
		</tr>
	</tfoot>
</table>