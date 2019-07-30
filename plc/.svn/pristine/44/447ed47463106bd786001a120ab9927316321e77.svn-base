<?php
	$url = base_url().'processor/plc/v3_penerimaan_sample?action=load_detail';

	if (isset($act)){
		if ($act != 'create'){
			$this->db->where('iro_id', $rowDataH['iro_id']);
			$this->db->where('ldeleted', 0);
			$this->db->order_by('iro_id', 'asc');
			$rows = $this->db->get('plc2.plc2_upb_ro_batch')->result_array();
		}
	}
	$satuan = $this->db->get_where('plc2.plc2_master_satuan', array('ldeleted' => 0))->result_array();
?>
<script type="text/javascript">
	// jQuery(function($) {
		// $('.detjumlah').autoNumeric('init');
	     
	  // });
		jQuery('.detjumlah').live('keyup', function() {
			this.value = this.value.replace(/[^0-9\.]/g, '');
		});

		if ('<?php echo $act; ?>' == 'create'){
			$.ajax({
				url: "<?php echo $url; ?>",
				type: "POST",
				async: false,
				data: { 
					ipo_id: $('#v3_penerimaan_sample_ipo_id').val(),
            		iModul_id: '<?php echo $iModul_id; ?>'
				}, 
				success: function(data){
					$(".penerimaan_sample_detail_frame").html(data);  
				}
			});
		}

		$("#v3_penerimaan_sample_ipo_id").die();
		$("#v3_penerimaan_sample_ipo_id").live("change",function(){
			$.ajax({
				url: "<?php echo $url; ?>",
				type: "POST",
				async: false,
				data: { 
					ipo_id: $('#v3_penerimaan_sample_ipo_id').val(),
            		iModul_id: '<?php echo $iModul_id; ?>'
				}, 
				success: function(data){
					$(".penerimaan_sample_detail_frame").html(data);  
				}
			});
		});
	
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="sample_robatch_sample" cellspacing="0" cellpadding="1" style="width: 100%; border: 1px solid #dddddd; text-align: center; border-collapse: collapse">
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
						<!-- <input type="text" name="detsatuan[]" class="detsatuan" value="<?php echo $row['vSatuan'] ?>" style="width: 80%; text-align: right" /> -->
						<select name="detsatuan[]" value="<?php echo $row['plc2_master_satuan_id'] ?>" class="detsatuan required">
							<option value="">-- Pilih Satuan --</option>
							<?php
								foreach ($satuan as $s) {
									$selected = ($s['plc2_master_satuan_id'] == $row['plc2_master_satuan_id'])?'selected':'';
									?>
										<option <?php echo $selected; ?> value="<?php echo $s['plc2_master_satuan_id']; ?>"><?php echo $s['vNmSatuan']; ?></option>
									<?php
								}
							?>
						</select>
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
						<input type="hidden" name="ibatch_id[]" value="" />
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
						<input type="text" name="det_nobatch[]" class="vbatch_nomor" style="width: 80%; text-align: right" />
				</td>
				<td style="border: 1px solid #dddddd; width: 20%">
						<input type="text" name="detjumlah[]" class="detjumlah" style="width: 80%; text-align: right" />
				</td>
				<td style="border: 1px solid #dddddd; width: 25%">
					<!-- <input type="text" name="detsatuan[]" class="detsatuan" style="width: 80%; text-align: right" /> -->
					<select name="detsatuan[]" value="" class="detsatuan required">
						<option value="">-- Pilih Satuan --</option>
						<?php
							foreach ($satuan as $s) {
								?>
									<option value="<?php echo $s['plc2_master_satuan_id']; ?>"><?php echo $s['vNmSatuan']; ?></option>
								<?php
							}
						?>
					</select>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="sample_robatch_sample_del" onclick="del_row(this, 'sample_robatch_sample_del')">[Hapus]</a></span>
				</td>		
			</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('sample_robatch_sample')">Tambah</a></td>
		</tr>
	</tfoot>
</table>