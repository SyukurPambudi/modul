<script type="text/javascript">
	function browse_multi1_setting_prioritas_prareg(url, title, dis, param) {
		var i = $('.btn_browse_bb').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
	function get_upb_exists() {
		var i = 0;
		var l_upb_id = '';
		$('.upb_id').each(function() {
			if  ($('.upb_id').eq(i).val() != '') {
				l_upb_id += $('.upb_id').eq(i).val()+'_';
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
		foreach($team_pd as $t) {				
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
						<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
							<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>_num">1</span></td>
							<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" name="iupb_id[<?php echo $t['iteam_id']?>][]" class="upb_set_prio_upb_id_<?php echo $t['iteam_id']?> upb_id" />
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php echo $t['iteam_id']?>" type="text" name="iupb_nomor" />
								<button class="btn_browse_upb" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg('<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>','List UPB',this,'iupb_id='+$('.list_upbid_exists').val());return false;">...</button>
								<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
								<!-- <button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button> -->
							</td>
							<!--
								<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
								<input type="hidden" name="iupb_id[<?php //echo $t['iteam_id']?>][]" class="upb_set_prio_upb_id_<?php //echo $t['iteam_id']?>" />
								<input readonly="readonly" style="width: 65%" class="input_tgl upb_set_prio_upbno_<?php //echo $t['iteam_id']?>" type="text" name="iupb_nomor" />
								<button class="btn_browse_upb_<?php //echo $t['iteam_id']?>" type="button" onclick="javascript:browse_multiple('<?php //echo $browse_url ?>&pdId=<?php //echo $t['iteam_id'] ?>','List UPB',this,'btn_browse_upb_<?php //echo $t['iteam_id']?>')">...</button>
							</td>
							  -->
							
							<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upb_set_prio_generik_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 15%;"><div class="upb_set_prio_status_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 20%; text-align: left"><div class="upb_set_prio_kategori_<?php echo $t['iteam_id']?>"></div></td>
							<td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td>
							<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>_del" onclick="del_row(this, 'table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>_del')">[Delete]</a></span></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_upb_setting_prio_reg_rincian_<?php echo $t['iteam_id']?>')">Tambah</a></td>
						</tr>
					</tfoot>
				</table>
			</div>			
		</div>
	<?php
		}
	?>
		
</div>