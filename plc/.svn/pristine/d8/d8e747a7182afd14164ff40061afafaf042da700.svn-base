<script type="text/javascript">
	function browse_multi1_setting_prioritas_prareg(url, title, dis, param) {
		var i = $('.btn_browse_bb').index(dis);	
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
		foreach($team_pd as $t) {
			echo '<li>
					  <a href="#teampd-'.$t['iteam_id'].'">PD '.$t['vteam'].'</a>
				  </li>';
		}
	?>	
	</ul>
	<?php
		//echo $t['iteam_id'];		
		foreach($team_pd as $t) {
			$sql = "SELECT * FROM plc2.plc2_upb_prioritas_reg_detail d
					INNER JOIN plc2.plc2_upb u ON d.iupb_id=u.iupb_id
					INNER JOIN plc2.plc2_upb_master_kategori_upb k ON u.ikategoriupb_id=k.ikategori_id
					WHERE d.iprioritas_id = '".$iprioritas_id."'
					AND d.iteampd_id = '".$t['iteam_id']."'
					AND d.ldeleted = 0";
			
			$rows = $this->db_plc0->query($sql)->result_array();			
	?>
		<div id="teampd-<?php echo $t['iteam_id'] ?>" class="margin_0">
			<div>
				<table id="table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<thead>
						<tr class="nodrop nodrag" style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
							<th style="border: 1px solid #dddddd;">No</th>
							<th style="border: 1px solid #dddddd;">NO. UPB</th>
							<th style="border: 1px solid #dddddd;">NAMA GENERIK</th>
							<th style="border: 1px solid #dddddd;">STATUS</th>
							<th style="border: 1px solid #dddddd;">KATEGORI UPB</th>
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
							<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>_num"><?php echo $no; ?></span></td>
							<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" value="<?php echo $r['iupb_id'] ?>" name="iupb_id[<?php echo $t['iteam_id']?>][]" class="upb_set_prio_upb_id_<?php echo $t['iteam_id']?>" />
								<input type="hidden" name="upb_idi[<?php echo $t['iteam_id']?>][]" class="upb_idi" value="<?php echo $r['iupb_id'] ?>">
								<!-- 
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php //echo $t['iteam_id']?>" type="text" name="iupb_nomor" />
								<button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button>
								 -->
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php echo $t['iteam_id']?> upb_id" type="text" name="iupb_nomor" value="<?php echo $r['vupb_nomor'] ?>" />
								<button class="btn_browse_upb" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg('<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>','List UPB',this,'iupb_id='+$('.list_upbid_exists').val());return false;">...</button>
								<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
								
							</td>
							<!-- 
							<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" name="iupb_id[<?php //echo $t['iteam_id']?>][]" value="<?php //echo $r['iupb_id'] ?>" class="upb_set_prio_upb_id_<?php //echo $t['iteam_id']?>" />
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php //echo $t['iteam_id']?>" type="text" name="iupb_nomor" value="<?php //echo $r['vupb_nomor'] ?>" />
								<button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button>
							</td>
							 -->
							<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upb_set_prio_generik_<?php echo $t['iteam_id']?>"><?php echo $r['vgenerik'] ?></div></td>
							<td style="border: 1px solid #dddddd; width: 15%;"><div class="upb_set_prio_status_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 20%; text-align: left"><div class="upb_set_prio_kategori_<?php echo $t['iteam_id']?>"><?php echo $r['vkategori'] ?></div></td>
							<td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td>
							<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_setting_prio_rincian_<?php echo $t['iteam_id']?>_del" onclick="del_row(this, 'table_upb_setting_prio_rincian_<?php echo $t['iteam_id']?>_del')">[Delete]</a></span></td>
						</tr>
						<?php
							$no++;
							}
						}
						else {
						?>
						<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
							<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_setting_prio_rincian_<?php echo $t['iteam_id']?>_num"><?php echo $no; ?></span></td>
							<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" name="iupb_id[<?php echo $t['iteam_id']?>][]" class="upb_set_prio_upb_id_<?php echo $t['iteam_id']?>" />
								<input type="hidden" name="upb_idi[<?php echo $t['iteam_id']?>][]" class="upb_idi" value="">
								<!-- 
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php //echo $t['iteam_id']?>" type="text" name="iupb_nomor" />
								<button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button>
								 -->
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php echo $t['iteam_id']?> upb_id" type="text" name="iupb_nomor" value="" />
								<button class="btn_browse_upb" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg('<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>','List UPB',this,'iupb_id='+$('.list_upbid_exists').val());return false;">...</button>
								<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
								
							</td>
							<!-- 
							<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" name="iupb_id[<?php //echo $t['iteam_id']?>][]" class="upb_set_prio_upb_id_<?php //echo $t['iteam_id']?>" />
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php //echo $t['iteam_id']?>" type="text" name="iupb_nomor" />
								<button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //cho $t['iteam_id']?>')">...</button>
							</td>
							 -->
							<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upb_set_prio_generik_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 15%;"><div class="upb_set_prio_status_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 20%; text-align: left"><div class="upb_set_prio_kategori_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td>
							<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>_del" onclick="del_row(this, 'table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>_del')">[Delete]</a></span></td>
						</tr>
						<?php
							}
						?>
						
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>')">Tambah</a></td>
						</tr>
						<tr>
							<td colspan="6" style="text-align: center">Paging : </td>
						</tr>
					</tfoot>
				</table>
			</div>			
		</div>
	<?php
		}
	?>
		
</div>