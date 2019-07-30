<script type="text/javascript">
	function browse_multi_prioritas_upd(url, title, dis, param) {
		var i = $('.btn_browse_upd').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
	function get_upb_exists() {
		var i = 0;
		var l_upb_id = '';
		$('.upd_id').each(function() {
			if  ($('.upd_id').eq(i).val() != '') {
				l_upb_id += $('.upd_id').eq(i).val()+'_';
			}
			
			i++;
		});
	
		l_upb_id = l_upb_id.substring(0, l_upb_id.length - 1);
		if (l_upb_id == undefined || l_upb_id == '') l_upb_id= 0;
		$('.list_updid_exists').val(l_upb_id);		
	}
</script>
<div class="tab">
	<ul>
	<?php
			echo '<li>
					  Rincinan UPD 
				  </li>';
	?>	
	</ul>
		<div id="teampd-" class="margin_0">
			<div>
				<table id="table_upb_prioritas_rincian" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<thead>
						<tr class="nodrop nodrag" style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
							<th style="border: 1px solid #dddddd;">No</th>
							<th style="border: 1px solid #dddddd;">NO. UPD</th>
							<th style="border: 1px solid #dddddd;">NAMA USULAN</th>
							<th style="border: 1px solid #dddddd;">TGL UPD</th>
							<th style="border: 1px solid #dddddd;">NO PRODUK</th>
							<th style="border: 1px solid #dddddd;">URUTAN</th>
							<th style="border: 1px solid #dddddd;">ACTION</th>
						</tr>
					</thead>					
					<tbody>
						<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
							<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_prioritas_rincian_num">1</span></td>
							<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" name="idossier_upd_id[]" class="upd_prio_upd_id upd_id required" />
								<input readonly="readonly" style="width: 65%" class="input_tgl upd_prio_upd_no" type="text" name="iupb_nomor" />
								<button class="btn_browse_upd" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi_prioritas_upd('<?php echo $browse_url ?>&pdId=fuck','List UPB',this,'iupd_id='+$('.list_updid_exists').val());return false;">...</button>
								<input type="text" name="list_updid_exists" class="list_updid_exists" value=""/>
							</td>
							<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upd_prio_nama_usulan"></div></td>
							<td style="border: 1px solid #dddddd; width: 15%;"><div class="upd_prio_tgl"></div></td>
							<td style="border: 1px solid #dddddd; width: 20%; text-align: left"><div class="upd_prio_iupb_id"></div></td>
							<td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td>
							<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_prioritas_rincian_del" onclick="del_row(this, 'table_upb_prioritas_rincian_del')">[Delete]</a></span></td>
							
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_upb_prioritas_rincian')">Tambah</a></td>
						</tr>
					</tfoot>
				</table>
			</div>			
		</div>
</div>