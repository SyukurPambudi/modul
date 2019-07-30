<script type="text/javascript">

//jQuery(function($) {
//		$('.kom_kekuatan').autoNumeric('init');
	      
//	  });

//create autocomplete raw material
var config = {
	source: base_url+'processor/plc/pembagian/produk/export?action=carinegara',					
	select: function(event, ui){
		var i = $('.vNamaNegara').index(this);
		$('.vNamaNegara_id').eq(i).val(ui.item.id);						
	},
	minLength: 2,
	autoFocus: true,
};
$(".vNamaNegara").livequery(function(){
	$(this).autocomplete(config);
	var i = $('.vNamaNegara').index(this);
	$(this).keypress(function(e){
		if(e.which != 13) {
			$('.vNamaNegara_id').eq(i).val('');
		}			
	});
	$(this).blur(function(){
		if($('.vNamaNegara_id').eq(i).val() == '') {
			$(this).val('');
		}			
	});
})
</script>
<table id="table_komposisi_upb" cellspacing="0" cellpadding="3" style="width: 50%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Negara</th>
		<th style="border: 1px solid #dddddd;">Action</th>
	</tr>
	</thead>
	<tbody>
	<?php 
		if(isset($isi)) {
			if(is_array($isi) && count($isi) > 0) {
				$n=1;
				foreach($isi as $v) {
					$row = $this->db_plc0->get_where('dossier.dossier_negara', array('lDeleted'=>0,'idossier_negara_id'=>$v['idossier_negara_id']))->row_array();
	?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_upb_num"><?php echo $n;?></span></td>
						<td style="border: 1px solid #dddddd; width: 40%">
							<input class="vNamaNegara_id" name="negara_id[]" type="hidden" required ='required' class='required' value="<?php echo $v['idossier_negara_id']?>" >
							<input class="input_rows-table vNamaNegara required"  required ='required' style="width: 98%" name="nama_negara[]" type="text" value="<?php echo $row['vKode_Negara'].' - '.$row['vNama_Negara']?>">
						</td>
						<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_upb_del" onclick="del_row(this, 'table_komposisi_upb_del')">[Delete]</a></span></td>
					</tr>
	<?php 		
				$n=$n+1;
				}
			}
			else{
	?>
	<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
		<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_upb_num">1</span></td>
		<td style="border: 1px solid #dddddd; width: 40%">
			<input class="vNamaNegara_id required" name="negara_id[]"type="hidden" required ='required'>
			<input class="input_rows-table vNamaNegara required" style="width: 98%" required ='required' name="nama_negara[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_upb_del" onclick="del_row(this, 'table_komposisi_upb_del')">[Delete]</a></span></td>
	</tr>
	<?php } 
	}
	else{
	?>
	<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
		<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_upb_num">1</span></td>
		<td style="border: 1px solid #dddddd; width: 40%">
			<input class="vNamaNegara_id required" name="negara_id[]"  required ='required' type="hidden" >
			<input class="input_rows-table vNamaNegara required" required ='required' style="width: 98%" name="nama_negara[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_upb_del" onclick="del_row(this, 'table_komposisi_upb_del')">[Delete]</a></span></td>
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_komposisi_upb')">Tambah</a></td>
		</tr>
	</tfoot>
</table>