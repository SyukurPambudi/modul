<?php
	$url = base_url().'processor/plc/v3_penerimaan_sample?action=load_detail';
	$rows = array();
	if (isset($act)){
		if ($act != 'create'){
			$irodet_id = $rowDataH['irodet_id'];
			$rows = $this->db->get_where('plc2.plc2_upb_ro_detail_jenis', array('irodet_id'=>$irodet_id,'ldeleted'=>0))->result_array();
		}
	}

	$sqlJenis = 'SELECT ijenis_mikro, vjenis_mikro FROM plc2.plc2_master_jenis_uji_mikro WHERE ldeleted = 0 ORDER BY ijenis_mikro ASC';
	$arrJenis = $this->db->query($sqlJenis)->result_array();
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
<table class="hover_table" id="terima_sample_bb_jenis" cellspacing="0" cellpadding="1" style="width: 100%; border: 1px solid #dddddd; text-align: center; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Jenis Uji Mikro Bahan Baku</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Jenis Uji</th>
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
						<span class="terima_sample_bb_jenis_num"><?php echo $i ?></span>
						<input type="hidden" name="irodet_jenis_id[]" value="<?php echo $row['irodet_jenis_id'] ?>" />
					</td>
					<td style="border: 1px solid #dddddd; width: 25%">
						<select name="ijenis_mikro[]" class="required">
							<?php
								foreach ($arrJenis as $v) {
									$selected = ($v['ijenis_mikro'] == $row['ijenis_mikro'])?'selected':'';
									?>
										<option <?php echo $selected; ?> value="<?php echo $v['ijenis_mikro']; ?>"><?php echo $v['vjenis_mikro']; ?></option>
									<?php
								}
							?>
						</select>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="terima_sample_bb_jenis_del" onclick="del_row(this, 'terima_sample_bb_jenis_del')">[Hapus]</a></span>
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
						<span class="terima_sample_bb_jenis_num">1</span>
						<input type="hidden" name="irodet_jenis_id[]" value="" />
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
					<select name="ijenis_mikro[]" class="required">
						<?php
							foreach ($arrJenis as $v) {
								?>
									<option value="<?php echo $v['ijenis_mikro']; ?>"><?php echo $v['vjenis_mikro']; ?></option>
								<?php
							}
						?>
					</select>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="terima_sample_bb_jenis_del" onclick="del_row(this, 'terima_sample_bb_jenis_del')">[Hapus]</a></span>
				</td>		
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('terima_sample_bb_jenis')">Tambah</a></td>
		</tr>
	</tfoot>
</table>