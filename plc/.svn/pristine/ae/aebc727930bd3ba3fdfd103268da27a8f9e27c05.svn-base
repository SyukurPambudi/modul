<script type="text/javascript">
	jQuery('.detjumlah').live('keyup', function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
	// jQuery(function($) {
		// $('.detjumlah').autoNumeric('init');
	      
	  // });
	function browse_multi1_sample_po_sample(url, title, dis, param) {
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
<script type="text/javascript">
	$('.detjumlah').die();
	$('.detjumlah').live("keyup",function(){
		var disval=$(this).val();
		var dismaxval=$(this).parent().prev().find('input').val();
		//if (disval>dismaxval) {
		//	alert('Tidak boleh melebihi jumlah maximal');
		//	$(this).val(dismaxval)
		//}
	})
</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="sample_po_sample" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Detail Bahan Baku</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Permintaan Sample</th>
		<th style="border: 1px solid #dddddd;">Bahan Baku</th>
		<!--<th style="border: 1px solid #dddddd;">Nama Produk</th>
		<th style="border: 1px solid #dddddd;">Max Jumlah</th>-->
		<th style="border: 1px solid #dddddd;">Jumlah</th>
		<th style="border: 1px solid #dddddd;">Satuan</th>
		<th style="border: 1px solid #dddddd;">Manufacturer</th>
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
				$r = $this->db_plc0->get('plc2.plc2_upb_request_sample')->row_array();
				
				$rqi=$row['ireq_id'];$rwi=$row['raw_id'];
				
				$sel="select * from plc2.plc2_upb_request_sample_detail where ireq_id=$rqi and raw_id=$rwi";
				$rd=$this->db_plc0->query($sel)->row_array();
				
				$this->db_plc0->where('raw_id', $row['raw_id']);
				$b = $this->db_plc0->get('plc2.plc2_raw_material')->row_array();
				
				$this->db_plc0->where('imanufacture_id', $row['imanufacture_id']);
				$m = $this->db_plc0->get('hrd.mnf_manufacturer')->row_array();
				$nmmf = count($m) > 0 ? $m['vnmmanufacture'] : '';


				$ireqdet_id=$rd['ireqdet_id'];
				$data = array();

				$sql2 = "SELECT * FROM plc2.plc2_upb_request_sample_detail c  where c.ireqdet_id='".$ireqdet_id."'";
				$data2 = $this->db_plc0->query($sql2)->row_array();

				$sql22 = "select sum(a.ijumlah) as sumjumlah from plc2.plc2_upb_po_detail a where a.raw_id='".$data2['raw_id']."' and a.ireq_id='".$data2['ireq_id']."'";
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
						<span class="sample_po_sample_num"><?php echo $i ?></span>
						<?php "req=".$data2['ijumlah']."sudah=".$data22['sumjumlah']; ?>
					</td>		
					<td style="border: 1px solid #dddddd; width: 15%">
						<input type="hidden" name="ipodet_id[]" value="<?php echo $row['ipodet_id'] ?>" class="ipodet_id" />
						<input type="hidden" name="ireq_id[]" value="<?php echo $row['ireq_id'] ?>" class="detreq_id" />
						<input disabled="true" type="text" name="detrawname[]" value="<?php echo $r['vreq_nomor'] ?>" class="detreq_id_dis" style="width: 80%" />
						<!-- <button class="btn_browse_ro" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>browse/ro?field=sample_po_sample&col=detreq_id','List RO',this,'btn_browse_ro')">...</button> -->
						<input type="hidden" name="list_raw_mate_exists" class="list_raw_mate_exists"/>
						<button class="btn_browse_ro" type="button" onClick="javascript:get_rawmate_exists();javascript:browse_multi1_sample_po_sample('<?php echo $browse_url ?>browse/ro?field=sample_po_sample&col=detreq_id','List Ro',this,'ireqdet_id='+$('.list_raw_mate_exists').val());return false;">...</button>
						<!-- <button name="btn_peng_item[]" class="peng_item_btn" onClick="javascript:get_sparepart_penggantian_exists();javascript:browse_multi1_ga_transaksi_request_penggantian_sparepart('<?php //echo $url;?>?company_id=3&modul_id=34&group_id=2368','Master Sparepart',this, 'iKendaraanId='+$('#ga_transaksi_request_penggantian_sparepart_iKendaraanId').val()+'&sparepart_penggantian_id='+$('.list_penggantian_sparepart_exists').val());return false;">[...]</button> -->
						
					<!-- belum jelas karena masalah field di tabel -->	<input type="hidden" name="ireqdet_id[]" class="ireqdet_id" value="<?php echo $rd['ireqdet_id'] ?>"/>
					</td>
					<td style="border: 1px solid #dddddd; width: 15%">
						<input type="hidden" name="detrawid[]" value="<?php echo $row['raw_id'] ?>" class="detraw_id" />
						<textarea disabled="true" name="rawname[]" class="detraw_id_dis" style="width: 80%"><?php echo $b['vnama'] ?></textarea>
						<!--<input disabled="true" type="text" name="rawname[]" value="<?php echo $b['vnama'] ?>" class="detraw_id_dis" style="width: 100%" />-->
						<!--<button class="btn_browse_bb" type="button" onclick="javascript:browse_multiple('<?php echo $browse_url ?>browse/bb?field=sample_po_sample&col=detraw_id','List Bahan Baku',this,'btn_browse_bb')">...</button>-->
					</td>
					<!--<td style="border: 1px solid #dddddd; width: 10%">
						<textarea name="detnamaproduk[]" class="detnamaproduk" style="width: 80%;" ><?php //echo $row['vnama_produk'] ?></textarea>
						<!--<input type="text" name="detnamaproduk[]" value="<?php //echo $row['vnama_produk'] ?>" class="detnamaproduk" style="width: 80%;" />-->
					<!--</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="detmaxjumlah[]" readonly="readonly" class="detmaxjumlah" value="<?php echo $iMax ?>" style="width: 80%; text-align: right" />
					</td>-->
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="detjumlah[]" value="<?php echo $row['ijumlah'] ?>" class="detjumlah" style="width: 80%; text-align: right" />
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<input type="text" name="detsatuan[]" value="<?php echo $row['vsatuan'] ?>" class="detsatuan" style="width: 80%" />
					</td>
					<td style="border: 1px solid #dddddd; width: 20%">
						<input type="hidden" name="detmanufacture_id[]" value="<?php echo $row['imanufacture_id'] ?>" class="detmanufacture_id" />
						<input disabled="true" type="text" name="detmanufacture_id_dis[]" value="<?php echo $nmmf ?>" class="detmanufacture_id_dis" style="width: 90%" />
						<button class="btn_browse_mnf" type="button" onclick="javascript:browse_multiple('<?php echo $browse_url ?>browse/mnf?field=sample_po_sample&col=detmanufacture_id','List Manufacturer',this,'btn_browse_mnf')">...</button>
					</td>
					<td style="border: 1px solid #dddddd; width: 5%">
						<span class="delete_btn"><a href="javascript:;" class="sample_po_sample_del" onclick="del_row(this, 'sample_po_sample_del')">[Hapus]</a></span>
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
				<span class="sample_po_sample_num">1</span>
			</td>
			<td style="border: 1px solid #dddddd; width: 15%">
				<input type="hidden" name="ipodet_id[]" value="" class="ipodet_id" />
				<input type="hidden" name="ireq_id[]" value="" class="detreq_id" />
				<input disabled="true" type="text" name="detrawname[]" value="" class="detreq_id_dis" style="width: 80%" />
				<!-- <button class="btn_browse_ro" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>browse/ro?field=sample_po_sample&col=detreq_id','List RO',this,'btn_browse_ro')">...</button> -->
				<input type="hidden" name="list_raw_mate_exists" class="list_raw_mate_exists"/>
				<input type="hidden" name="ireqdet_id"[] class="ireqdet_id" value=""/>
				<button class="btn_browse_ro" type="button" onClick="javascript:get_rawmate_exists();javascript:browse_multi1_sample_po_sample('<?php echo $browse_url ?>browse/ro?field=sample_po_sample&col=detreq_id','List Ro',this,'ireqdet_id='+$('.list_raw_mate_exists').val());return false;">...</button>
			</td>
			<td style="border: 1px solid #dddddd; width: 15%">
				<input type="hidden" name="detrawid[]" value="" class="detraw_id" />
				<!--<input disabled="true" type="text" name="rawname[]" value="" class="detraw_id_dis" style="width: 80%" />-->
				<textarea disabled="true" name="rawname[]" class="detraw_id_dis" style="width: 80%"></textarea>
				<!--<button class="btn_browse_bb" type="button" onclick="javascript:browse_multiple('<?php echo $browse_url ?>browse/bb?field=sample_po_sample&col=detraw_id','List Bahan Baku',this,'btn_browse_bb')">...</button>-->
			</td>
			<!--<td style="border: 1px solid #dddddd; width: 10%">
				<textarea name="detnamaproduk[]" class="detnamaproduk" style="width: 80%;"></textarea>
			</td>
			<td style="border: 1px solid #dddddd; width: 5%">
				<input type="text" name="detmaxjumlah[]" readonly="readonly" class="detmaxjumlah" value="0" style="width: 80%; text-align: right" />
			</td>-->
			<td style="border: 1px solid #dddddd; width: 5%">
				<input type="text" name="detjumlah[]" value="" class="detjumlah" style="width: 80%; text-align: right" />
			</td>
			<td style="border: 1px solid #dddddd; width: 5%">
				<input type="text" name="detsatuan[]" value="" class="detsatuan" style="width: 80%" />
			</td>
			<td style="border: 1px solid #dddddd; width: 20%">
				<input type="hidden" name="detmanufacture_id[]" value="" class="detmanufacture_id" />
				<input disabled="true" type="text" name="detmanufacture_id_dis[]" value="" class="detmanufacture_id_dis" style="width: 80%" />
				<button class="btn_browse_mnf" type="button" onclick="javascript:browse_multiple('<?php echo $browse_url ?>browse/mnf?field=sample_po_sample&col=detmanufacture_id','List Manufacturer',this,'btn_browse_mnf')">...</button>
			</td>
			<td style="border: 1px solid #dddddd; width: 5%">
				<span class="delete_btn"><a href="javascript:;" class="sample_po_sample_del" onclick="del_row(this, 'sample_po_sample_del')">[Hapus]</a></span>
			</td>		
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('sample_po_sample')">Tambah</a></td>
		</tr>
	</tfoot>
</table>