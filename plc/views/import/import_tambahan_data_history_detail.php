<?php $path='import_tambahan_data'; ?>
<script>
/* DOM */
window
  .document
  .body

/* CLICK */

.addEventListener( "click", function( event ) {
  var oTarget = event.target;

 /* FOR input[type="checkbox"] */


</script>
<div class="details" style="width:100%; overflow:auto;"; ?>

<div id="create" class="margin_0">
	<div style="overflow:auto; max-width:1580px">
		<table class="hover_table" id="table_create" cellspacing="0" cellpadding="1" style="width: 100%; border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse">
			<thead>
			<tr style="width: 160%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
				<th style="border: 1px solid #dddddd; width: 5%;">No</th>
				<th style="border: 1px solid #dddddd; width: 25%;">Nama File</th>
				<th style="border: 1px solid #dddddd; width: 25%;">Tgl Kelengkapan Dokumen</th>
				<th style="border: 1px solid #dddddd; width: 25%;">Nama Dokumen</th>
			</thead>
			<tbody>
			<?php 
				$ii = 1;
				foreach ($tgl as $ke) {
					if($ke['iupi_dok_td_id'] != ""){
					?>
						<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
							<td style="border: 1px solid #dddddd; text-align: center;">
							<span class="dossier_request_sample_upload_num"><?php echo $ii ?></span>
							</td>	
							<td style="border: 1px solid #dddddd; text-align: center;">

								<?php
								
									$sql = "SELECT * FROM plc2.`upi_dok_td_detail_file` b WHERE b.`iMemo_id` =".$ke['iMemo_id']." AND b.`iupi_dok_td_id` = ".$ke['iupi_dok_td_id'];
									//echo $sql;
									$unse = $this->db_plc0->query($sql)->result_array();
									foreach ($unse as $un) {

										$id1  = $un['iMemo_id'];
											$value1 = $un['vFileupidetail'];	
											if($value1 != '') {
												if (file_exists('./files/plc/import/td_detail_file/'.$id1.'/'.$value1)) {
													$link1 = base_url().'processor/plc/import/tambahan/data?action=downloaddDokumen&id='.$id1.'&filedokumen='.$value1;
													$linknya1 = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link1.'\'">'. $un['vFileupidetail'].'</a>';
												}
												else {
													$linknya1 = 'File sudah tidak ada!';
												}
											}
											else {
												$linknya1 = 'No File';
											}	
										?>
										
										<span class="dossier_request_sample_upload_num"><?php echo $linknya1; ?><br></span>
										<hr style="border: 0.5px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
										<?php
									}

								?>
							</td>	
							<td style="border: 1px solid #dddddd; text-align: center;">
							<span class="dossier_request_sample_upload_num"><?php echo $ke['dTgl_td'] ?></span>
							</td>	
							<td style="border: 1px solid #dddddd; text-align: center;">
							<span class="dossier_request_sample_upload_num"><?php echo $ke['vNama_dokumen'] ?></span>
							</td>
						</tr>
					<?php
					}else{
						?>
							<span class="dossier_request_sample_upload_num">No Data</span>
						<?php
					}
					$ii++;
				}
			?>

			</tbody>
			<tfoot>
			</tfoot>	
		</table>			
	</div>
</div>
</div>