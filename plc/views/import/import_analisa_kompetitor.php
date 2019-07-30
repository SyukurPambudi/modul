<script type="text/javascript">

//jQuery(function($) {
//		$('.kom_kekuatan').autoNumeric('init');
	      
//	  });

//create autocomplete raw material
var config = {
	source: base_url+'processor/plc/import/analisa/principal?action=cariproduk',					
	select: function(event, ui){
		var i = $('.vNama_produk').index(this);
		$('.vNamaproduk_id').eq(i).val(ui.item.id);						
		$('.vNama_manuf').eq(i).val(ui.item.manuf);						
	},
	minLength: 2,
	autoFocus: true,
};
$(".vNama_produk").livequery(function(){
	$(this).autocomplete(config);
	var i = $('.vNama_produk').index(this);
	$(this).keypress(function(e){
		if(e.which != 13) {
			$('.vNamaproduk_id').eq(i).val('');
		}			
	});
	$(this).blur(function(){
		if($('.vNamaproduk_id').eq(i).val() == '') {
			$(this).val('');
		}			
	});
})

var config2 = {
	source: base_url+'processor/plc/import/analisa/principal?action=cariapplicant',					
	select: function(event, ui){
		var i = $('.vApplicant').index(this);
		$('.iapplicant_id').eq(i).val(ui.item.id);						
		$('.vApplicant').eq(i).val(ui.item.vNama_applicant);						
	},
	minLength: 2,
	autoFocus: true,
};
$(".vApplicant").livequery(function(){
	$(this).autocomplete(config2);
	var i = $('.vApplicant').index(this);
	$(this).keypress(function(e){
		if(e.which != 13) {
			$('.iapplicant_id').eq(i).val('');
		}			
	});
	$(this).blur(function(){
		if($('.iapplicant_id').eq(i).val() == '') {
			$(this).val('');
		}			
	});
})

$(".angka2").keyup(function(){
					this.value = this.value.replace(/[^0-9\.]/g,"");
	                        });
                        
$(".angka2").css('text-align','right');


</script>
<table id="table_komposisi_upb" cellspacing="0" cellpadding="3" style="width: 95%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;width: 5%;">No</th>
		<th style="border: 1px solid #dddddd; width: 25%;">Nama Produk</th>
		<th style="border: 1px solid #dddddd; width: 25%;">Manufactur</th>
		<th style="border: 1px solid #dddddd; width: 20%;">Applicant</th>
		<th style="border: 1px solid #dddddd; width: 15%;">Sales</th>
		<th style="border: 1px solid #dddddd; width: 10%;">Action</th>
	</tr>
	</thead>
	<tbody>
	<?php 
		if(isset($isi)) {
			if(is_array($isi) && count($isi) > 0) {
				$n=1;
				foreach($isi as $v) {
	?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
						<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_upb_num"><?php echo $n;?></span></td>
						<td style="border: 1px solid #dddddd; width: 25%">
							<input class="vNamaproduk_id" name="produk_id[]" type="hidden" required ='required' class='required' value="<?php echo $v['iplc2_produk_kompetitor_id']?>" >
							<input class="input_rows-table vNama_produk required"  required ='required' style="width: 98%" name="nama_produk[]" type="text" value="<?php echo $v['vNama_produk']?>">
						</td>
						<td style="border: 1px solid #dddddd; width: 25%">
							<input class="input_rows-table vNama_manuf required" readonly="readonly" required ='required' style="width: 98%" name="nama_manuf[]" type="text" value="<?php echo $v['vNama_manuf']?>">
						</td>
						<td style="border: 1px solid #dddddd; width: 20%">
							<input class="input_rows-table iapplicant_id  required"  required ='required' style="width: 98%" name="iapplicant_id[]" type="hidden" value="<?php echo $v['iapplicant_id']?>">
							<input class="input_rows-table vApplicant required"  required ='required' style="width: 98%" name="vApplicant[]" type="text" value="<?php echo $v['vNama_applicant']?>">
						</td>
						<td style="border: 1px solid #dddddd; width: 15%">
							<input class="input_rows-table iSales required angka2"  required ='required' style="width: 98%" name="iSales[]" type="text" value="<?php echo $v['iSales']?>" >
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
		<td style="border: 1px solid #dddddd; width: 25%">
			<input class="vNamaproduk_id required" name="produk_id[]"type="hidden" required ='required'>
			<input class="input_rows-table vNama_produk required" style="width: 98%" required ='required' name="nama_produk[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 25%">
			<input class="input_rows-table vNama_manuf required" readonly="readonly" style="width: 98%" required ='required' name="nama_manuf[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 20%">
			<input class="input_rows-table iapplicant_id  required"  required ='required' style="width: 98%" name="iapplicant_id[]" type="hidden" >
			<input class="input_rows-table vApplicant required"  required ='required' style="width: 98%" name="vApplicant[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 15%">
			<input class="input_rows-table iSales required angka2"  required ='required' style="width: 98%" name="iSales[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_komposisi_upb_del" onclick="del_row(this, 'table_komposisi_upb_del')">[Delete]</a></span></td>
	</tr>
	<?php } 
	}
	else{
	?>
	<tr style="border: 1px solid #dddddd; border-collapse: collapse;">
		<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_komposisi_upb_num">1</span></td>
		<td style="border: 1px solid #dddddd; width: 25%">
			<input class="vNamaproduk_id required" name="produk_id[]"  required ='required' type="hidden" >
			<input class="input_rows-table vNama_produk required" required ='required' style="width: 98%" name="nama_produk[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 25%">
			<input class="input_rows-table vNama_manuf required" readonly="readonly" required ='required' style="width: 98%" name="nama_manuf[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 20%">
			<input class="iapplicant_id required" name="iapplicant_id[]"  required ='required' type="hidden" >
			<input class="input_rows-table vApplicant required" required ='required' name="vApplicant[]" type="text" >
		</td>
		<td style="border: 1px solid #dddddd; width: 15%">
			<input class="input_rows-table iSales required angka2"  required ='required' style="width: 98%" name="iSales[]" type="text" >
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