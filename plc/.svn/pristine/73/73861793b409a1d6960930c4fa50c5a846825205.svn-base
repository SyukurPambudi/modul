<script type="text/javascript">
	function browse_multi1_setting_prioritas_prareg(url, title, dis, param) {
		var i = $('.btn_browse_upd').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
	function get_upb_exists() {
		var i = 0;
		var l_upb_id = '';
		$('.upb_idi').each(function() {
			if  ($('.upb_idi').eq(i).val() != '') {
				l_upb_id += $('.upb_idi').eq(i).val()+'_';
			}
			
			i++;
		});
	
		l_upb_id = l_upb_id.substring(0, l_upb_id.length - 1);
		if (l_upb_id == undefined || l_upb_id == '') l_upb_id= 0;
		$('.list_upbid_exists').val(l_upb_id);		
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
	<?php
			$sql = "select * 
					from dossier.dossier_prioritas a
					join dossier.dossier_prioritas_detail b on b.idossier_prioritas_id=a.idossier_prioritas_id
					join dossier.dossier_upd c on c.idossier_upd_id=b.idossier_upd_id
					join plc2.plc2_upb d on d.iupb_id=c.iupb_id
					where a.lDeleted = 0
					and b.lDeleted = 0
					and a.idossier_prioritas_id = '".$idossier_prioritas_id."'
					and c.lDeleted=0
				";
			
			$rows = $this->db_plc0->query($sql)->result_array();			
	?>
		<div id="teampd" class="margin_0">
			<div>
				<table id="table_upb_prioritas_rincian" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<thead>
						<tr class="nodrop nodrag" style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
							<th style="border: 1px solid #dddddd;">No</th>
							<th style="border: 1px solid #dddddd;">NO. UPD</th>
							<th style="border: 1px solid #dddddd;">NAMA USULAN</th>
							<th style="border: 1px solid #dddddd;">TGL UPD</th>
							<th style="border: 1px solid #dddddd;">NO UPB</th>
							<th style="border: 1px solid #dddddd;">URUTAN</th>
							<th style="border: 1px solid #dddddd;">ACTION</th>
						</tr>
					</thead>					
					<tbody>
						<?php
						$no = 1;
						if(count($rows) > 0) {
							foreach($rows as $r) {
						?>

							<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
								<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_prioritas_rincian_num"><?php echo $no; ?></span></td>
								<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
									<input value="<?php echo $r['idossier_upd_id'] ?>" type="hidden" name="idossier_upd_id[]" class="upd_prio_upd_id upd_id required" />
									<input type="hidden" name="upb_idi[]" class="upb_idi" value="<?php echo $r['idossier_upd_id'] ?>">

									<input readonly="readonly" style="width: 65%" class="input_tgl upd_prio_upd_no" type="text" name="iupd_nomor" value="<?php echo $r['vupb_nomor'] ?>"  />
									<button class="btn_browse_upd" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi_prioritas_upd('<?php echo $browse_url ?>&pdId=damn','List UPB',this,'iupb_id='+$('.list_upbid_exists').val());return false;">...</button>
									<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
									<!-- <button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button> -->
								</td>
								<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upd_prio_nama_usulan"><?php echo $r['vNama_usulan'] ?></div></td>
								<td style="border: 1px solid #dddddd; width: 15%;"><div class="upd_prio_tgl"><?php echo $r['dTanggal_upd'] ?></div></td>
								<td style="border: 1px solid #dddddd; width: 20%; text-align: left"><div class="upd_prio_iupb_id"><?php echo $r['vupb_nomor'] ?></div></td>
								<td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td>
								<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_prioritas_rincian_del" onclick="del_row(this, 'table_upb_prioritas_rincian_del')">[Delete]</a></span></td>
								
							</tr>

						<?php
							$no++;
							}
						}
						else {
							// jika tidak ada rows di detil
						?>
							<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
								<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_prioritas_rincian_num">1</span></td>
								<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
									<input type="hidden" name="idossier_upd_id[]" class="upd_prio_upd_id upd_id required" />
									<input readonly="readonly" style="width: 65%" class="input_tgl upd_prio_upd_no" type="text" name="iupb_nomor" />
									<button class="btn_browse_upd" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi_prioritas_upd('<?php echo $browse_url ?>&pdId=damn','List UPB',this,'iupb_id='+$('.list_upbid_exists').val());return false;">...</button>
									<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
									<!-- <button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button> -->
								</td>
								<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upd_prio_nama_usulan"></div></td>
								<td style="border: 1px solid #dddddd; width: 15%;"><div class="upd_prio_tgl"></div></td>
								<td style="border: 1px solid #dddddd; width: 20%; text-align: left"><div class="upd_prio_iupb_id"></div></td>
								<td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td>
								<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_prioritas_rincian_del" onclick="del_row(this, 'table_upb_prioritas_rincian_del')">[Delete]</a></span></td>
								
							</tr>


						<?php
							}
						?>
						
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_upb_prioritas_rincian')">Tambah</a></td>
						</tr>
						<tr>
							<td colspan="6" style="text-align: center">Paging : </td>
						</tr>
					</tfoot>
				</table>
			</div>			
		</div>
</div>