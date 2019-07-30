<?php
	$url = base_url().'processor/plc/v3_penerimaan_sample?action=load_detail';
	$rows = array();
	if (isset($act)){
		if ($act != 'create'){
			$ivalmoa_id = $rowDataH['ivalmoa_id'];
			$rows = $this->db->get_where('plc2.plc2_vamoa_metode', array('ivalmoa_id'=>$ivalmoa_id,'lDeleted'=>0))->result_array();
		}
	}

	$sqlMetode = 'SELECT iplc2_master_jenis_metode, vnama_metode FROM plc2.plc2_master_jenis_metode WHERE lDeleted = 0';
	$arrMetode = $this->db->query($sqlMetode)->result_array();
?>
<script type="text/javascript">
	if ($('#v3_terima_sample_bb_iUjiMikro_bb').val()==1){
		$("label[for='v3_terima_sample_bb_form_detail_jenis_mikro']").parent().show();
	}else{
		$("label[for='v3_terima_sample_bb_form_detail_jenis_mikro']").parent().hide();
	}
	
	$("#v3_terima_sample_bb_iUjiMikro_bb").die();
	$("#v3_terima_sample_bb_iUjiMikro_bb").live("change",function(){
		if ($( this ).val()==1) {
			$("label[for='v3_terima_sample_bb_form_detail_jenis_mikro']").parent().show();
		}else{
			$("label[for='v3_terima_sample_bb_form_detail_jenis_mikro']").parent().hide();
		}
	})
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="verifikasi_moa_bb_metode" cellspacing="0" cellpadding="1" style="width: 100%; border: 1px solid #dddddd; text-align: center; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Jenis Metode</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Jenis Metode</th>
		<th style="border: 1px solid #dddddd;">Jumlah Retest</th>
		<th style="border: 1px solid #dddddd;">Jumlah Validasi</th>
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
						<span class="verifikasi_moa_bb_metode_num"><?php echo $i ?></span>
						<input type="hidden" name="iplc2_vamoa_metode[]" value="<?php echo $row['iplc2_vamoa_metode'] ?>" />
					</td>
					<td style="border: 1px solid #dddddd; width: 25%">
						<select name="iplc2_master_jenis_metode[]" class="required">
							<?php
								foreach ($arrMetode as $v) {
									$selected = ($v['iplc2_master_jenis_metode'] == $row['iplc2_master_jenis_metode'])?'selected':'';
									?>
										<option <?php echo $selected; ?> value="<?php echo $v['iplc2_master_jenis_metode']; ?>"><?php echo $v['vnama_metode']; ?></option>
									<?php
								}
							?>
						</select>
					</td>
					<td style="border: 1px solid #dddddd; width: 25%">
						<input type="number" class="required" name="iretest[]" value="<?php echo $row['iretest']; ?>" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 25%">
						<input type="number" class="required" name="ijumlah_val[]" value="<?php echo $row['ijumlah_val']; ?>" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="verifikasi_moa_bb_metode_del" onclick="del_row(this, 'verifikasi_moa_bb_metode_del')">[Hapus]</a></span>
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
						<span class="verifikasi_moa_bb_metode_num">1</span>
						<input type="hidden" name="iplc2_vamoa_metode[]" value="" />
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
					<select name="iplc2_master_jenis_metode[]" class="required">
						<?php
							foreach ($arrMetode as $v) {
								?>
									<option value="<?php echo $v['iplc2_master_jenis_metode']; ?>"><?php echo $v['vnama_metode']; ?></option>
								<?php
							}
						?>
					</select>
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
					<input type="number" class="required" name="iretest[]" value="" />
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
					<input type="number" class="required" name="ijumlah_val[]" />
				</td>		
				<td style="border: 1px solid #dddddd; width: 10%">
					<span class="delete_btn"><a href="javascript:;" class="verifikasi_moa_bb_metode_del" onclick="del_row(this, 'verifikasi_moa_bb_metode_del')">[Hapus]</a></span>
				</td>		
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('verifikasi_moa_bb_metode')">Tambah</a></td>
		</tr>
	</tfoot>
</table>