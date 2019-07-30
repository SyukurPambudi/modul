<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

	$sqlJenis = "SELECT ijenis_bk_id, CONCAT('Sekunder > ', vjenis_bk) AS vjenis_bk FROM plc2.plc2_master_jenis_bk WHERE itipe_bk = 2 AND ldeleted = 0 ORDER BY vjenis_bk ASC";
	$arrJenis = $this->db->query($sqlJenis)->result_array();

	$rows;
	if (isset($act)){
		if ($act=='update' || $act == 'view') {
			$ibk_id = $rowDataH['ibk_id'];
			$sql = "SELECT * FROM plc2.plc2_upb_bk_sekunder_detail WHERE ibk_id = ? AND ldeleted = 0";
			$rows = $this->db->query($sql, array($ibk_id))->result_array();
		}
	}

?>

<script type="text/javascript">

</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<div class="v3_table_permintaan_sample_detail">
	<table class="hover_table" id="bk_kemasan_sekunder" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Kemasan Bahan Kemas Sekunder</span></th>
		</tr>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No</th>
			<th style="border: 1px solid #dddddd;">Jenis Bahan Kemas</th>
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
							<span class="bk_kemasan_sekunder_num"><?php echo $i ?></span>
						</td>	
						<td style="border: 1px solid #dddddd; width: 90%">
							<input type="hidden" name="ibk_sekunder_id[]" value="<?php echo $row['ibk_sekunder_id']; ?>" class="" style="width: 100%" />
							<select class="input_rows1" name="jenisbk_sekunder[]" value="<?php echo $row['ijenis_bk_id']; ?>" id="jenis_bk_id_<?php echo $row['ibk_sekunder_id']; ?>" style="width: 100%;" >
								<?php 
									foreach ($arrJenis as $jns) {
										$selected = ($jns['ijenis_bk_id']==$row['ijenis_bk_id'])?'selected':'';
										?>
											<option <?php echo $selected; ?> value="<?php echo $jns['ijenis_bk_id'] ?>"><?php echo $jns['vjenis_bk']; ?></option>
										<?php
									}
								?>
							</select>
						</td>
						<td style="border: 1px solid #dddddd; width: 10%">
							<span class="permintaan_sample_detail_delete_btn"><a href="javascript:;" class="bk_kemasan_sekunder_del" onclick="del_row(this, 'bk_kemasan_sekunder_del')">[Hapus]</a></span>
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
					<span class="bk_kemasan_sekunder_num">1</span>
				</td>	
				<td style="border: 1px solid #dddddd; width: 90%">
					<input type="hidden" name="ibk_sekunder_id[]" value="" class="" style="width: 100%" />
					<select class="input_rows1" name="jenisbk_sekunder[]" value="" style="width: 100%;" >
						<?php 
							foreach ($arrJenis as $jns) {
								?>
									<option value="<?php echo $jns['ijenis_bk_id'] ?>"><?php echo $jns['vjenis_bk']; ?></option>
								<?php
							}
						?>
					</select>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
					<span class="permintaan_sample_detail_delete_btn"><a href="javascript:;" class="bk_kemasan_sekunder_del" onclick="del_row(this, 'bk_kemasan_sekunder_del')">[Delete]</a></span>
				</td>		
			</tr>
			<?php } ?>
		</tbody>
		<tfoot class="permintaan_sample_detail_add_row">
			<tr>
				<td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('bk_kemasan_sekunder')">Tambah</a></td>
			</tr>
		</tfoot>
	</table>
</div>