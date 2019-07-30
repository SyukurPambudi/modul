<style type="text/css">
 			.heder{
 				padding: 3px;
                /*width: 500px;*/
                width: 75%;
                border: 1px solid rgba(51, 23, 93, 0.2);
                background-color: #FFF;
                margin-left: 5px;
 			}
 			.sepasi{
 				margin-bottom: 3%;
 			}
 			.detail_{
 				width: 100%;
 				/*overflow: auto*/
 			}
</style>



<?php 
	
	$sql_mod = 'select * 
				from reformulasi.export_dok_reformulasi a 
				join reformulasi.export_dok_reformulasi_sub b on b.iexport_dok_reformulasi=a.iexport_dok_reformulasi
				where a.lDeleted=0
				and b.lDeleted=0
				order by a.iUrutan,b.iUrutan_sub';
	$dMods = $this->db->query($sql_mod)->result_array();
	//print_r($dMods);
	
	foreach ($dMods as $data ) {
		

?>
		 	<div class="detail_" >
			 		<!-- Header -->
			 		<div class="heder">
				 		<table style="width: 75%;" border="0">
							<tbody>         
								<tr>
							        <td width="30%">Modul & Sub Dokumen</td>
							        <td>: <b><?php echo $data['vNamaProses'].'</b> - '.$data['vSub_dokumen'] ?></td>
							    </tr>
							</tbody>    
						</table>
					</div>
			 			
			 		<table class="hover_table" id="<?php echo $data['iexport_dok_reformulasi'] ?>_<?php echo $data['iexport_dok_reformulasi_sub'] ?>" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
						<thead>
						<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
							<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;"><?php echo $data['vSub_dokumen'] ?></span></th>
						</tr>
						<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
							<th style="border: 1px solid #dddddd; width: 5%;">No</th>
							<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Nama File</th>
							<th colspan="3" style="border: 1px solid #dddddd;width: 50%;">Keterangan</th>
							<th style="border: 1px solid #dddddd; width: 20%;">Action</th>		
						</tr>
						</thead>
						<tbody>
							<?php 
								$sqldok = $data['sSql'];
								$sqldok .= $data['sWhere'];

								/*$sqldok = 'select *	from reformulasi.export_draft_soi_bb a
											join reformulasi.export_draft_soi_bb_file b on b.iexport_draft_soi_bb=a.iexport_draft_soi_bb
											join reformulasi.export_ro_detail c on c.iexport_ro_detail=a.iexport_ro_detail
											join reformulasi.export_request_sample_detail d on d.iexport_request_sample_detail=c.iexport_request_sample_detail
											join reformulasi.export_request_sample e on e.iexport_request_sample=d.iexport_request_sample
											join reformulasi.export_req_refor f on f.iexport_req_refor=e.iexport_req_refor
											where a.lDeleted=0
											and b.lDeleted=0
											and c.lDeleted=0
											and d.lDeleted=0
											and e.lDeleted=0
											and f.lDeleted=0
											and f.iexport_req_refor=9';*/
								$sqldok = trim($sqldok).$rowData['iexport_req_refor'];
								//echo $sqldok;
								//exit;
								$dDoks = $this->db->query($sqldok)->result_array();											

								$vFilename = trim($data['vNmfield_dok']);
								$vKeterangan = trim($data['vKeterangan_dok']);
								$vFolder_file = trim($data['vFolder_file']);
								$vPath = trim($data['vPath']);
								//$vController = trim($data['vController']);
								
								//print_r($dDoks);
								if (!empty($dDoks)) {
									
									$no = 1;
									foreach ($dDoks as $dDok ) {
										$id  = $dDok['aidi'];
										$value = $dDok[$vFilename];	
										$path = $vPath;	
										$folder_file = $vFolder_file; 

										
										if($value != '') {
											if (file_exists('./files/reformulasi/export/'.$folder_file.'/'.$id.'/'.$value)) {
												$link = base_url().'processor/reformulasi/export/cek/dokumen?action=download&id='.$id.'&file='.$value.'&path='.$path;
												$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
											}
											else {
												$linknya = 'File sudah tidak ada!';
											}
										}
										else {

											$file = 'No File';
										}	

									
							 ?>
										<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
											<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
												<span class="num"><?php echo $no ?></span>
											</td>		
											<td colspan="1" style="border: 1px solid #dddddd; width: 27%"><?php echo $dDok[$vFilename] ?></td>
											
											<td colspan="3" style="border: 1px solid #dddddd; width: 8%"><?php echo  $dDok[$vKeterangan]  ?></td>
											<td style="border: 1px solid #dddddd; width: 10%"><?php echo $linknya ?>
																		
												<!-- <span class="delete_btn"><a style="color: #0000ff" href="javascript:;" onclick="window.location='http://localhost/erp_core0/processor/reformulasi/export/draft/soi/bb?action=download&amp;id=1&amp;file=ek120i.pdf&amp;path=export_draft_soi_bb'">Download</a></span>						 -->
											</td>		
										</tr>
							<?php 
									$no++;
									}
								}else{
									echo "<tr><td colspan='4'><b>File Upload tidak ditemukan !!</b></td></tr>";
								}
							 ?>
						</tbody>
					</table>

					<div class="sepasi"></div>
			</div>


<?php 
	}//end foreach
	

?>

