<script type="text/javascript">
	function browse_multi1_re_detail_permintaan_sample(url, title, dis, param) {
		var i = $('.btn_browse_bb').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
	function get_rawmaterial_exists() {
		var i = 0;
		var l_irawmat_id = '';
		$('.detraw_id').each(function() {
			if  ($('.detraw_id').eq(i).val() != '') {
				l_irawmat_id += $('.detraw_id').eq(i).val()+'_';
			}
			
			i++;
		});
	
		l_irawmat_id = l_irawmat_id.substring(0, l_irawmat_id.length - 1);
		if (l_irawmat_id === undefined) l_ireq_id = 0;
		$('.list_raw_material_exists').val(l_irawmat_id);
		var x= $('.list_raw_material_exists').val(l_irawmat_id);
		//alert (l_irawmat_id);
	}
	jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
	// jQuery(function($) {
		// $('.detjumlah').autoNumeric('init');
	      
	  // });
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="re_detail_permintaan_sample" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Bahan Baku</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Bahan</th>
		<th style="border: 1px solid #dddddd;">Jumlah</th>
		<th style="border: 1px solid #dddddd;">Satuan</th>
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
				$this->db->where('raw_id', $row['raw_id']);
				$m = $this->db->get('plc2.plc2_raw_material')->row_array();
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="re_detail_permintaan_sample_num"><?php echo $i ?></span>
					</td>		
					<td style="border: 1px solid #dddddd; width: 47%">
						<input type="hidden" name="iexport_request_sample_detail[]" value="<?php echo $row['iexport_request_sample_detail'] ?>" class="iexport_request_sample_detail" />
						<input type="hidden" name="detrawid[]" value="<?php echo $row['raw_id'] ?>" class="detraw_id" />
						<input disabled="true" type="text" name="rawname[]" value="<?php echo $m['vnama'] ?>" class="detraw_id_dis required" style="width: 80%" />
						<button class="btn_browse_bb" type="button" onClick="javascript:get_rawmaterial_exists();javascript:browse_multi1_re_detail_permintaan_sample('<?php echo $browse_url ?>?field=re_detail_permintaan_sample&col=detraw_id','List Bahan Baku',this,'irawmat_id='+$('.list_raw_material_exists').val());return false;">...</button>
						<input type="hidden" name="list_raw_material_exists" class="list_raw_material_exists"/>
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<input type="text" name="detjumlah[]" value="<?php echo $row['iJumlah'] ?>" class="detjumlah required" style="width: 100%; text-align: right;" />
					</td>
					<td style="border: 1px solid #dddddd; width: 15%">
						<input type="text" name="detsatuan[]" value="<?php echo $row['vSatuan'] ?>"  class="detsatuan" style="width: 100%" />
					</td>
					<td style="border: 1px solid #dddddd; width: 50%">
						<input type="text" name="detspesifikasi[]" value="<?php echo $row['vSpesifikasi'] ?>" class="detspesifikasi" style="width: 100%" />
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="re_detail_permintaan_sample_del" onclick="del_row(this, 're_detail_permintaan_sample_del')">[Hapus]</a></span>
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
				<span class="re_detail_permintaan_sample_num">1</span>
			</td>		
			<td style="border: 1px solid #dddddd; width: 47%">
				<input type="hidden" name="iexport_request_sample_detail[]" value="" class="iexport_request_sample_detail" />
				<input type="hidden" name="detrawid[]" value="" class="detraw_id" />
				<input disabled="true" type="text" name="rawname[]" value="" class="detraw_id_dis required" style="width: 80%" />
				<!-- <button class="btn_browse_bb" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>?field=re_detail_permintaan_sample&col=detraw_id','List Bahan Baku',this,'btn_browse_bb')">...</button> -->
				<button class="btn_browse_bb" type="button" onClick="javascript:get_rawmaterial_exists();javascript:browse_multi1_re_detail_permintaan_sample('<?php echo $browse_url ?>?upbid='+$('#re_detail_permintaan_sample_iupb_id').val()+'&field=re_detail_permintaan_sample&col=detraw_id','List Bahan Baku',this,'irawmat_id='+$('.list_raw_material_exists').val());return false;">...</button>
				<input type="hidden" name="list_raw_material_exists" class="list_raw_material_exists"/>
			</td>	
			<td style="border: 1px solid #dddddd; width: 10%">
				<input type="text" name="detjumlah[]" value="" class="detjumlah required" style="width: 100%; text-align: right;"/>
			</td>
			<td style="border: 1px solid #dddddd; width: 15%">
				<input type="text" name="detsatuan[]" value="" class="detsatuan " style="width: 100%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 50%">
				<input type="text" name="detspesifikasi[]" value="" class="detspesifikasi" style="width: 100%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 10%">
				<span class="delete_btn"><a href="javascript:;" class="re_detail_permintaan_sample_del" onclick="del_row(this, 're_detail_permintaan_sample_del')">[Delete]</a></span>
			</td>		
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('re_detail_permintaan_sample')">Tambah</a></td>
		</tr>
	</tfoot>
</table>