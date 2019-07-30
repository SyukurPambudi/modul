<?php 

	$rows = $this->db->query($form_field['vSource_input'], array($rowDataH['iexport_req_refor']))->row_array();
	$upload = $this->db->query($form_field['vSource_input_edit'], array($rowDataH['iexport_req_refor']))->result_array(); 

?>

<script type="text/javascript">

</script>

<style type="text/css">
	.table_detail_request{ 
		border: 2px #A1CCEE solid;
		padding: 5px;
		background: #fff;
		border-radius: 5px;
		/*width: calc(99% - 190px);
		margin-left: 190px;
		margin-bottom: 10px; */
		width: 99%;
	}

	.table_detail_request tr td{
		vertical-align: top;
	}

	.table_skala_trial_fisik_upload tr td{
		border: 1px #dddddd solid;
		padding: 5px;
	}
</style>
<div class="table_skala_trial_fisik_detail">
	<?php
		if (isset($rows)){
			if (!empty($rows)){
				echo "<table class='table_detail_request'>";
				foreach ($rows as $key => $value) {
					?>
						<tr>
							<td style="width: 15%;"><?php echo $key; ?></td>
							<td style="width: 2%;"> : </td>
							<td><b><?php echo $value; ?></b></td>
						</tr>
					<?php
				}
				?>
					<tr>
						<td colspan="3">
							<table class="table_skala_trial_fisik_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
								<thead>
									<tr style="width: 100%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
										<th colspan="6" style="border: 1px solid #dddddd;">
											<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
												Upload File Request Reformulasi
											</span>
										</th>
									</tr>
									<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
										<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
										<th style="border: 1px solid #dddddd;">Nama File</th>
										<th style="border: 1px solid #dddddd;">Keterangan</th>
										<th style="border: 1px solid #dddddd; width: 10%;">Action</th>		
									</tr>
								</thead>
								<tbody>
									<?php
										if (count($upload) > 0){
											$numb = 1;
											foreach ($upload as $up) {
												?>
													<tr>
														<td><?php echo $numb; ?></td>
														<td><?php echo $up['vFilename']; ?></td>
														<td><?php echo $up['tKeterangan']; ?></td>
														<td>
															<?php
																if (file_exists('./'.$up['vPath_upload'].'/'.$up['idHeader_File'].'/'.$up['vFilename_generate'])) {
																	$link = base_url().'processor/reformulasi/v3/export/skala/trial/fisik?action=download&id='.$up['idHeader_File'].'&path='.$up['vPath_upload'].'&file='.$up['vFilename_generate'];
																	$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
																}
																else {
																	$linknya = 'File sudah tidak ada!';
																}
																echo $linknya;
															?>
														</td>
													</tr>
												<?php
												$numb ++;
											}
										} else {
											echo "<tr><td colspan='3'>Tidak Ada Data</td></tr>";
										}
									?>
								</tbody>
							</table>
						</td>
					</tr>
				<?php
				echo "</table>";
			} else {
				echo "Nomor Request Tidak Ditemukan";
			}
		} else {
			echo "Nomor Request Belum Dipilih";
		}
	?>
	
</div>