<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

	$rows;
	if (isset($act)){
		if ($act=='update' || $act == 'view') {
			$rows = $this->db->get_where('reformulasi.export_bk_primer_detail', array('iexport_bk_id' => $rowDataH['iexport_bk_id'], 'ldeleted' => 0))->result_array();
		}
	}
	$title = $form_field['vDesciption']

?>

<script type="text/javascript">

</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<div class="v3_table_permintaan_sample_detail">
	<table class="hover_table" id="export_bk_primer_kemasan" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;"><?php echo $title; ?></span></th>
		</tr>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No</th>
			<th style="border: 1px solid #dddddd;">Jenis Bahan Kemas</th>
			<th style="border: 1px solid #dddddd;">Keterangan</th>
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
							<span class="export_bk_primer_kemasan_num"><?php echo $i ?></span>
						</td>	
						<td style="border: 1px solid #dddddd; width: 45%">
							<input type="hidden" name="iexport_bk_primer_detail[]" value="<?php echo $row['iexport_bk_primer_detail']; ?>" class="" style="width: 100%" />
							<input type="text" name="vjenis_bk[]" value="<?php echo $row['vjenis_bk']; ?>" class="" style="width: 80%" />
						</td>
						<td style="border: 1px solid #dddddd; width: 45%">
							<textarea rows="3" name="tketerangan_bk[]" ><?php echo $row['tketerangan_bk']; ?></textarea>
						</td>
						<td style="border: 1px solid #dddddd; width: 10%">
							<span class="permintaan_sample_detail_delete_btn"><a href="javascript:;" class="export_bk_primer_kemasan_del" onclick="del_row(this, 'export_bk_primer_kemasan_del')">[Hapus]</a></span>
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
					<span class="export_bk_primer_kemasan_num">1</span>
				</td>	
				<td style="border: 1px solid #dddddd; width: 45%">
					<input type="hidden" name="iexport_bk_primer_detail[]" value="" class="" style="width: 100%" />
					<input type="text" name="vjenis_bk[]" value="" class="" style="width: 80%" />
				</td>
				<td style="border: 1px solid #dddddd; width: 45%">
					<textarea rows="3" name="tketerangan_bk[]" ></textarea>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
					<span class="permintaan_sample_detail_delete_btn"><a href="javascript:;" class="export_bk_primer_kemasan_del" onclick="del_row(this, 'export_bk_primer_kemasan_del')">[Hapus]</a></span>
				</td>	
			</tr>
			<?php } ?>
		</tbody>
		<tfoot class="permintaan_sample_detail_add_row">
			<tr>
				<td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('export_bk_primer_kemasan')">Tambah</a></td>
			</tr>
		</tfoot>
	</table>
</div>