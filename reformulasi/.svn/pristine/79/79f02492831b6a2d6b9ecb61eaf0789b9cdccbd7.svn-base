<script type="text/javascript">
	jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
	// jQuery(function($) {
		// $('.detjumlah').autoNumeric('init');
	      
	  // });
	function browse_multi1_req_reformulasi(url, title, dis, param) {
		var i = $('.btn_browse_ro').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
	function get_rawmate_exists() {
		var i = 0;
		var l_ireq_id = '';
		$('.ireqdet_id').each(function() {
			if  ($('.ireqdet_id').eq(i).val() != '') {
				l_ireq_id += $('.ireqdet_id').eq(i).val()+'_';
			}
			
			i++;
		});
	
		l_ireq_id = l_ireq_id.substring(0, l_ireq_id.length - 1);
		if (l_ireq_id === undefined) l_ireq_id = 0;
		$('.list_raw_mate_exists').val(l_ireq_id);
		var x= $('.list_raw_mate_exists').val();
		//alert (l_ireq_id);
	}
</script>
<?php

	$browse_url = base_url().'processor/reformulasi/';
	$rows;
	$auto = "Auto Generated...!!!";
	$empty = "";
	if (isset($act)){
		if ($act=='update' || $act == 'view') {
			$iexport_req_refor = $rowDataH['iexport_req_refor'];
			$sql = "SELECT d.*, b.*, s.vNmSatuan FROM reformulasi.export_req_refor_rawmaterial d 
					LEFT JOIN plc2.plc2_master_satuan s ON d.plc2_master_satuan_id = s.plc2_master_satuan_id
					LEFT JOIN plc2.plc2_raw_material b ON d.raw_id = b.raw_id	
					WHERE d.iexport_req_refor_rawmaterial = ? AND d.ldeleted = 0 AND ( s.ldeleted = 0 OR s.ldeleted IS NULL)";
			$rows = $this->db->query($sql, array($iexport_req_refor))->result_array(); 
			if (isset($rowDataH['vno_export_req_refor'])){
				$auto = $rowDataH['vno_export_req_refor'];
				$empty = $rowDataH['vno_export_req_refor'];
			}
		}
	}

	$mnf = "SELECT imanufacture_id, vmanufacture, vnmmanufacture FROM hrd.mnf_manufacturer WHERE ldeleted = 0 ORDER BY vnmmanufacture ASC";
	$arrmnf = $this->db->query($mnf)->result_array();
	$satuan = $this->db->get_where('plc2.plc2_master_satuan', array('ldeleted' => 0))->result_array();
	$getbahan = $this->db->get_where('plc2.plc2_raw_material', array('ldeleted' => 0))->result_array();

?>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<br>
<!-- <table class="hover_table" id="v3_export_request_refor" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse;">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Bahan Baku</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Bahan</th>
		<th style="border: 1px solid #dddddd;">Kekuatan</th>
		<th style="border: 1px solid #dddddd;">Satuan</th>
		<th style="border: 1px solid #dddddd;">Fungsi</th>
		<th style="border: 1px solid #dddddd;">Action</th>		
	</tr>
	</thead>
	<tbody>
		<?php 
			$i = 0;
			if(!empty($rows)) {
				foreach($rows as $row) { 
					$i++;				
				$this->db_plc0->where('ireq_id', $row['ireq_id']);
				$r = $this->db_plc0->get('reformulasi.export_req_refor')->row_array();

				$rqi=$row['iexport_req_refor'];$rwi=$row['raw_id'];
				
				$sel="select * from reformulasi.export_req_refor_rawmaterial where iexport_req_refor_rawmaterial=$rqi and raw_id=$rwi";
				$rd=$this->db_plc0->query($sel)->row_array();

				$this->db_plc0->where('raw_id', $row['raw_id']);
				$m = $this->db_plc0->get('plc2.plc2_raw_material')->row_array();

				$this->db_plc0->where('raw_id', $row['raw_id']);
				$b = $this->db_plc0->get('plc2.plc2_raw_material')->row_array();
				
				$this->db_plc0->where('imanufacture_id', $row['imanufacture_id']);
				$m = $this->db_plc0->get('hrd.mnf_manufacturer')->row_array();
				$nmmf = count($m) > 0 ? $m['vnmmanufacture'] : '';

				$ireqdet_id=$rd['iexport_request_sample_detail'];
				$data = array();

				$sql2 = "SELECT * FROM plc2.plc2_upb_request_sample_detail c  where c.ireqdet_id='".$ireqdet_id."'";
				$data2 = $this->db_plc0->query($sql2)->row_array();
				
				

				$sql22 = "select sum(a.ijumlah) as sumjumlah from reformulasi.export_request_sample_detail a where a.raw_id='".$data2['raw_id']."' and a.iexport_request_sample='".$data2['iexport_request_sample']."'";
				$data22 = $this->db_plc0->query($sql22)->row_array();

				$iMaxc = $data2['ijumlah']-$data22['sumjumlah'];
				if ($data22['sumjumlah'] =="") {
					$iMax=$data2['ijumlah'];
				}else{
					if ($iMaxc > 0) {
						$iMax=$iMaxc;
					}else{
						$iMax=0;
					}	
				}
			

		 ?>	
		 	<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="pembuatan_po_sample_num"><?php echo $i ?></span>
						<?php "req=".$data2['ijumlah']."sudah=".$data22['sumjumlah']; ?>
					</td>		
					<td style="border: 1px solid #dddddd; width: 30%">
						<input type="hidden" name="iexport_request_sample_detail" value="" class="iexport_request_sample_detail" />
						<input type="hidden" name="detrawid" value="" class="detraw_id" />
						<input disabled="true" type="text" name="rawname[]" value="" class="detraw_id_dis required" style="width: 60%" />
						<button class="btn_browse_ro" type="button" onClick="javascript:get_rawmate_exists();javascript:browse_multi1_req_reformulasi('<?php echo $browse_url ?>browse/ro?field=v3_export_request_refor&col=detreq_id','List Ro',this,'ireqdet_id='+$('.list_raw_mate_exists').val());return false;">...</button>
						
						<input type="hidden" name="list_raw_material_exists" class="list_raw_material_exists"/>
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="detjumlah[]" value="<?php echo $row['ijumlah'] ?>" class="detjumlah" style="width: 80%; text-align: right" />
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						
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
					<td style="border: 1px solid #dddddd; width: 20%">
						<select class="input_rows1" name="detmanufacture_id[]"  >
							<?php
								foreach ($arrmnf as $mnf) {
									$selected = ($mnf['imanufacture_id']==$row['imanufacture_id'])?'selected':'';
									?>
										<option <?php echo $selected; ?> value="<?php echo $mnf['imanufacture_id'] ?>">
											<?php echo (strlen($mnf['vmanufacture'])>0)?$mnf['vnmmanufacture'].' | '.$mnf['vmanufacture']:$mnf['vnmmanufacture']; ?>
										</option>
									<?php
								}
							?>
						</select>
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<span class="delete_btn"><a href="javascript:;" class="pembuatan_po_sample_del" onclick="del_row(this, 'pembuatan_po_sample_del')">[Hapus]</a></span>
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
						<span class="pembuatan_po_sample_num">1</span>
					</td>
					<td style="border: 1px solid #dddddd; width: 30%">
						<input type="hidden" name="iexport_request_sample_detail" value="" class="iexport_request_sample_detail" />
						<input type="hidden" name="detrawid" value="" class="detraw_id" />
						<input disabled="true" type="text" name="rawname[]" value="" class="detraw_id_dis required" style="width: 60%" />
						<button class="btn_browse_ro" type="button" onClick="javascript:get_rawmate_exists();javascript:browse_multi1_req_reformulasi('<?php echo $browse_url ?>browse/ro?field=v3_export_request_refor&col=detreq_id','List Ro',this,'ireqdet_id='+$('.list_raw_mate_exists').val());return false;">...</button>
						
						<input type="hidden" name="list_raw_material_exists" class="list_raw_material_exists"/>
					</td>

					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="vkekuatan" value="<?=isset($_POST['vkekuatan']) ? $_POST['vkekuatan'] : ''?>" class="" />
				
					</td>
					
					<td style="border: 1px solid #dddddd; width: 5%">
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
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="vfungsi" value="<?=isset($_POST['vfungsi']) ? $_POST['vfungsi'] : ''?>" class="" />
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<span class="delete_btn"><a href="javascript:;" class="pembuatan_po_sample_del" onclick="del_row(this, 'pembuatan_po_sample_del')">[Hapus]</a></span>
					</td>	
					
		 		</tr>
				
		 		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('pembuatan_po_sample')">Tambah</a></td>
		</tr>
	</tfoot>
</table> -->