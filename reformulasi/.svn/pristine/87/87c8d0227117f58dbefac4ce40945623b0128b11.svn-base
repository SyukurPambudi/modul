<?php 

?>

<script type="text/javascript">

</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<div class="v3_table_permintaan_sample_detail">
	<table class="hover_table" id="bentuk_sediaan_parameter" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Parameter Pengujian</span></th>
		</tr>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No</th>
			<th style="border: 1px solid #dddddd;">Paramter</th>
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
							<span class="bentuk_sediaan_parameter_num"><?php echo $i ?></span>
						</td>	
						<td style="border: 1px solid #dddddd; width: 90%">
							<input type="hidden" name="id_parameter_sediaan[]" value="<?php echo $row['id_parameter_sediaan']; ?>" class="" style="width: 100%" />
							<textarea class="required" name="tParameter[]" rows="2" style="width: 90%;"><?php echo $row['tParameter']; ?></textarea>
						</td>
						<td style="border: 1px solid #dddddd; width: 10%">
							<span class="permintaan_sample_detail_delete_btn"><a href="javascript:;" class="bentuk_sediaan_parameter_del" onclick="del_row(this, 'bentuk_sediaan_parameter_del')">[Hapus]</a></span>
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
					<span class="bentuk_sediaan_parameter_num">1</span>
				</td>	
				<td style="border: 1px solid #dddddd; width: 90%">
					<input type="hidden" name="id_parameter_sediaan[]" value="" class="" style="width: 100%" />
					<textarea class="required" name="tParameter[]" rows="2" style="width: 90%;"></textarea>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
					<span class="permintaan_sample_detail_delete_btn"><a href="javascript:;" class="bentuk_sediaan_parameter_del" onclick="del_row(this, 'bentuk_sediaan_parameter_del')">[Delete]</a></span>
				</td>		
			</tr>
			<?php } ?>
		</tbody>
		<tfoot class="permintaan_sample_detail_add_row">
			<tr>
				<td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('bentuk_sediaan_parameter')">Tambah</a></td>
			</tr>
		</tfoot>
	</table>
</div>