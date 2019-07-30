<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="best_formula_detail" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Data Stabilita</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">Parameter</th>
		<th style="border: 1px solid #dddddd;">Persyaratan</th>
		<th style="border: 1px solid #dddddd;">Real Time Test</th>		
		<th style="border: 1px solid #dddddd;">Accelerate Test</th>		
		<th style="border: 1px solid #dddddd;">Action</th>
	</tr>
	</thead>
	<tbody>
		<?php
		 $n = 1;
		 if(!empty($rows)){
			foreach($rows as $r) {
		?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd; width: 14%; text-align: center">
				<input type="hidden" value="<?php echo $r['istai_id']; ?>" name="detistai_id[]" />
				<input type="hidden" value="<?php echo $r['vparam']; ?>" name="detvparam[]" style="width: 100%" />
				<?php echo $r['vparam']; ?>
			</td>	
			<td style="border: 1px solid #dddddd; width: 27%; text-align: center">
				<input type="hidden" value="<?php echo $r['vsyarat']; ?>" name="detvsyarat[]" style="width: 100%" />
				<?php echo $r['vsyarat']; ?>
			</td>
			<td style="border: 1px solid #dddddd; width: 14%; text-align: center">
				<?php
					if($this->input->get('action') == 'view') {
						echo $r['vrealtime'];
					?>
						<input type="hidden" name="detvrealtime[]" value="<?php echo $r['vrealtime'];?>" style="width: 100%" />
					<?php }
					else {
					?>
						<input type="text" value="<?php echo $r['vrealtime']; ?>" name="detvrealtime[]" />
				<?php
					}
				?>
			</td>
			<td style="border: 1px solid #dddddd; width: 14%; text-align: center">
				<?php
					if($this->input->get('action') == 'view') {
						echo $r['vaccelerate'];
					?>
						<input type="hidden" value="<?php echo $r['vaccelerate']; ?>" name="detvaccelerate[]" />
					<?php }
					else {
				?>
						<input type="text" value="<?php echo $r['vaccelerate']; ?>" name="detvaccelerate[]" />
				<?php
					}
				?>
			</td>
			<td style="border: 1px solid #dddddd; width: 5%; text-align: center">
				<?php
					if($this->input->get('action') == 'view') {
						echo '&nbsp;';
					}
					else {
				?>
						<span class="delete_btn"><a href="javascript:;" class="best_formula_detail_del" onclick="del_row(this, 'best_formula_detail_del')">[Hapus]</a></span>
				<?php
					}
				?>
			</td>
		</tr>
		<?php
				$n++;
			}?>
		
		<?php }
		else{
		?>
		
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd; width: 75%">
				<input type="hidden" name="detistai_id[]" />
				<input type="text" name="detvparam[]" class="vparam" style="width: 100%" />
			</td>	
			<td style="border: 1px solid #dddddd; width: 45%">
				<input type="text" name="detvsyarat[]" class="vsyarat" style="width: 100%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 45%">
				<input type="text" name="detvrealtime[]" class="vrealtime" style="width: 100%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 45%">
				<input type="text" name="detvaccelerate[]" class="vaccelerate" style="width: 100%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 5%; text-align: center">
				<?php
					if($this->input->get('action') == 'view') {
						echo '&nbsp;';
					}
					else {
				?>
						<span class="delete_btn"><a href="javascript:;" class="best_formula_detail_del" onclick="del_row(this, 'best_formula_detail_del')">[Hapus]</a></span>
				<?php
					}
				?>
			</td>
		</tr>
		
		<?php }?>
		
		
	</tbody>
	<?php
	if(empty($rows)){
	?>
	<tfoot>
		<tr>
			<td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('best_formula_detail')">Tambah</a></td>
		</tr>
	</tfoot>
	<?php } ?>
</table>