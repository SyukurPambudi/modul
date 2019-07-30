<script type="text/javascript">
//jQuery(function($) {
//		$('.kom_kekuatan').autoNumeric('init');
	      
//});
//create autocomplete raw material
var config2 = {
	source: base_url+'processor/plc/upb/daftar?action=rawmat_list',					
	select: function(event, ui){
		var i = $('.vRaw_mat_1_div').index(this);
		$('.vRaw_mat_1_div_id').eq(i).val(ui.item.id);						
	},
	minLength: 2,
	autoFocus: true,
};
$(".vRaw_mat_1_div").livequery(function(){
	$(this).autocomplete(config2);
	var i = $('.vRaw_mat_1_div').index(this);
	$(this).keypress(function(e){
		if(e.which != 13) {
			$('.vRaw_mat_1_div_id').eq(i).val('');
		}			
	});
	$(this).blur(function(){
		if($('.vRaw_mat_1_div_id').eq(i).val() == '') {
			$(this).val('');
		}			
	});
})
</script>

<table id="table_komposisi_ori" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<?php
		if((isset($kompor)) && ($iapp==0) && ($teamupb==$teamnya)) {
			if(is_array($kompor) && count($kompor) > 0) {
				
		?>
		<tr>
			<td colspan="6" style="text-align: left">
				<?php 
					$butt='<span onclick="javascript:load_popup(\''.base_url().'processor/plc/upb/daftar?action=copyOri&upb_id='.$iupb_id.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="button_copyUPB">Copy Komposisi Originator ke Komposisi UPB</span></br>';
					echo $butt;
				?>
			</td>
		</tr>
		<?php }
			}
		?>
	</tfoot>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
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

		if(isset($kompor)) {
			if(is_array($kompor) && count($kompor) > 0) {
				$n=1;
				foreach($kompor as $v) {
	?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_ori_num"><?php echo $n;?></span></td>
						<td style="border: 1px solid #dddddd; width: 40%">
						<!--<input style="width: 98%" type="text" name="kom_bahan[]"  />  -->
							<input class="vRaw_mat_1_div_id" name="kor_bahan_id[]" type="hidden" value="<?php echo $v['raw_id']?>" >
							<input class="input_rows-table vRaw_mat_1_div" style="width: 98%" name="name_kor_bahan[]" type="text" value="<?php echo $v['vnama'].' - '.$v['vraw']?>">
						</td>
						<td style="border: 1px solid #dddddd; width: 15%;"><input style="width: 96%" type="number" step="0.001" min="0"name="kor_kekuatan[]" class="kor_kekuatan" value="<?php echo $v['ijumlah']?>" /></td>
						<td style="border: 1px solid #dddddd; width: 15%;"><input style="width: 96%" type="text" name="kor_satuan[]" value="<?php echo $v['vsatuan']?>" /></td>
						<td style="border: 1px solid #dddddd; width: 20%;"><input style="width: 96%" type="text" name="kor_fungsi[]" value="<?php echo $v['vfungsi']?>" /></td>
						<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_ori_del" onclick="del_row(this, 'table_komposisi_ori_del')">[Delete]</a></span></td>
					</tr>
	<?php 		
				$n=$n+1;
				}
			}
			else{
	?>
	<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
		<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_ori_num">1</span></td>
		<td style="border: 1px solid #dddddd; width: 40%">
		<!--<input style="width: 98%" type="text" name="kom_bahan[]"  />  -->
			<input class="vRaw_mat_1_div_id" name="kor_bahan_id[]" type="hidden" >
			<input class="input_rows-table vRaw_mat_1_div" style="width: 98%" name="name_kor_bahan[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 15%;"><input style="width: 96%" type="number" step="0.001" min="0" name="kor_kekuatan[]" class="kor_kekuatan"/></td>
		<td style="border: 1px solid #dddddd; width: 15%;"><input style="width: 96%" type="text" name="kor_satuan[]"  /></td>
		<td style="border: 1px solid #dddddd; width: 20%;"><input style="width: 96%" type="text" name="kor_fungsi[]"  /></td>
		<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_ori_del" onclick="del_row(this, 'table_komposisi_ori_del')">[Delete]</a></span></td>
	</tr>
	<?php } 
	}
	else{
	?>
	<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
		<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_ori_num">1</span></td>
		<td style="border: 1px solid #dddddd; width: 40%">
		<!--<input style="width: 98%" type="text" name="kom_bahan[]"  />  -->
			<input class="vRaw_mat_1_div_id" name="kor_bahan_id[]" type="hidden" >
			<input class="input_rows-table vRaw_mat_1_div" style="width: 98%" name="name_kor_bahan[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 15%;"><input style="width: 96%" type="number" step="0.001" min="0"class="kor_kekuatan" name="kor_kekuatan[]" /></td>
		<td style="border: 1px solid #dddddd; width: 15%;"><input style="width: 96%" type="text" name="kor_satuan[]"  /></td>
		<td style="border: 1px solid #dddddd; width: 20%;"><input style="width: 96%" type="text" name="kor_fungsi[]"  /></td>
		<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_ori_del" onclick="del_row(this, 'table_komposisi_ori_del')">[Delete]</a></span></td>
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_komposisi_ori')">Tambah</a></td>
		</tr>
		
</table>