<?php 
	//echo "Hari".$data['hari']-$data['hari_libur'];
	//echo "Per".$data['per'];
	$i = 1;
	foreach($datanya as $data) {
		$hari_kerja = $data['hari']-$data['hari_libur'];
		if ($hari_kerja > 0) {
			$banding= $hari_kerja / $data['per'];
		}else{
			$banding ='0';
		}

		
		if ($data['iparameter_id']== 7 || $data['iparameter_id']== 9 || $data['iparameter_id']== 10|| $data['iparameter_id']== 11 || $data['iparameter_id']== 12|| $data['iparameter_id']== 14) {
			$uom = round($banding, 2);	
		}else{
			$uom = $data['per'];
		}
		


	?>
		<tr class="ui-widget-content jqgrow ui-row-ltr"  >
			<td class="ui-state-default jqgrid-rownum" style="text-align:center; width:5%; padding-left:1%;" role="gridcell"><span class='ui-icon ui-icon-lightbulb detail_monitoring_cost_budget_bt' id="detail_monitoring_cost_budget_bt" tglAwal='<?php echo $tglAwal ?>' tglAkhir='<?php echo $tglAkhir?>' role="row"  no ='<?php echo $i ?>' idparameter='<?php echo $data['iparameter_id'] ?>' total='<?php echo $data['total'] ?>' per='<?php echo $data['per'] ?>' uom='<?php echo $uom?>' hari='<?php echo $data['hari'] ?>' harilibur='<?php echo $data['hari_libur'] ?>'></span></td>
			<td style="text-align:left; width:5%;" ><?php echo $i ?></td>
			<td style="text-align:left; width:30%;" ><?php echo $data['vkategori_parameter']?></td>
			<td style="text-align:left; width:30%;" ><?php echo $data['vparameter'] ?></td>
			<td style="text-align:left; width:30%;" ><?php echo $uom ?></td>
			<td style="text-align:left; width:30%;" ><?php echo $data['vNmSatuan'] ?></td>
			
		</tr>	
	
		
<?php 
	$i++;
	}		
?>



<?php $url = base_url()."processor/plc/monitoring/cost/budget/?action=getdetail"; ?>

<script type="text/javascript">
	$('.detail_monitoring_cost_budget_bt').click( function  () {
		if ($(this).attr('tglAwal') == '' || $(this).attr('tglAkhir')=='') {

			alert('Periode tidak boleh kosong');
		}else{
			return $.ajax({
			url: '<?php echo $url;?>',
				type: 'post',
				//dataType : "json",
				data: {
						parameter: $(this).attr('idparameter'),
						no: $(this).attr('no'),
						uom: $(this).attr('uom'),
						tglAwal: $(this).attr('tglAwal'),
						tglAkhir: $(this).attr('tglAkhir'),
						total: $(this).attr('total'),
						per: $(this).attr('per'),
						hari: $(this).attr('hari'),
						hari_libur: $(this).attr('harilibur'),
						},
				//data: $(this).attr('id'),
				beforeSend: function(){
				},
				success: function(data){
					$('#partial_budget').html(data);
				},
			}).responseText;	
		};

		
	});
</script>
	
