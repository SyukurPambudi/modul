<?php 
/*Array ( 
[iexport_ro] => 2 
[vRo_no] => RO00000002 
[ipo_id] => 1 
[iClose_po] => 0 
[cTerima_pr] => N01147 
[dTgl_terima] => 2018-02-20 
[isupplier_id] => 1 [iSubmit] => 0 
[iApprove_pr] => 0 
[cApprove_pr] => 
[dApprove_pr] => 
[vRemark] => 
[dCreate] => 
[cCreated] => 
[dupdate] => 2018-02-20 09:14:29 
[cUpdate] => [lDeleted] => 0 ) */
	$sqDetailPo = /*'select *,b.vnama,e.iJumlah  
				from reformulasi.export_po_detail a 
				join plc2.plc2_raw_material b on b.raw_id=a.raw_id
				join reformulasi.export_po c on c.ipo_id=a.ipo_id
				join reformulasi.export_request_sample d on d.iexport_request_sample=a.iexport_request_sample
				join reformulasi.export_request_sample_detail e on e.raw_id=a.raw_id and e.iexport_request_sample=d.iexport_request_sample
				join reformulasi.export_ro f on f.ipo_id=c.ipo_id
				join reformulasi.export_ro_detail g on g.iexport_ro=f.iexport_ro and g.iexport_request_sample_detail=e.iexport_request_sample_detail
				where a.ldeleted=0 
				and a.ipo_id= "'.$rowData['ipo_id'].'" ';*/
				'select * 
				from reformulasi.export_ro_detail a 
				join reformulasi.export_ro b on b.iexport_ro=a.iexport_ro
				join reformulasi.export_request_sample_detail c on c.iexport_request_sample_detail=a.iexport_request_sample_detail
				join reformulasi.export_request_sample d on d.iexport_request_sample=c.iexport_request_sample
				join plc2.plc2_raw_material e on e.raw_id=c.raw_id
				join reformulasi.export_po f on f.ipo_id=b.ipo_id
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and d.lDeleted=0
				and e.ldeleted=0
				and f.ldeleted=0
				and f.ipo_id= "'.$rowData['ipo_id'].'"  ';
				/*echo '<pre>'.$sqDetailPo;*/
	$dDetailPo = $this->db->query($sqDetailPo)->result_array();

	//print_r($dDetailPo);

 ?>

 	<?php 
 		foreach ($dDetailPo as $detailpo) {
		
		$nmBB = $detailpo ['vnama'];
		$noRequest = $detailpo ['vRequest_no'];
		$iJumlah = $detailpo ['iJumlah'];
		$vSatuan = $detailpo ['vSatuan'];

		$iJumlah_batch = $detailpo['iJumlah_batch'];
		$iexport_ro_detail = $detailpo['iexport_ro_detail'];

 			
 		

 	?>
 	<style type="text/css">
 			.heder{
 				padding: 3px;
                width: 500px;
                border: 1px solid rgba(51, 23, 93, 0.2);
                background-color: #FFF;
                margin-left: 5px;
 			}
 			.sepasi{
 				margin-bottom: 3%;
 			}


 	</style>
 		<!-- Header -->
 		<div class="heder">
	 		<table style="width: 100%;" border="0">
				<tbody>         
					<tr>
				        <td width="20%">Nama Bahan Baku</td>
				        <td>:</td>
				        <td width="75%"><?php echo $nmBB ?></td>
				    </tr>

				    <tr>
				        <td width="20%">No Permintaan</td>
				        <td>:</td>
				        <td width="75%"> 
				            <span ><?php echo $noRequest ?></span>
				        </td>
				    </tr>

				    <tr>
				        <td width="20%">Jumlah</td>
				        <td>:</td>
				        <td width="75%"> 
				            <span ><?php echo $iJumlah ?></span>
				        </td>
				    </tr>
				    <tr>
				        <td width="20%">Satuan</td>
				        <td>:</td>
				        <td width="75%"> 
				            <span ><?php echo $vSatuan ?></span>
				        </td>
				    </tr>

				    <tr>
				        <td width="20%">Jumlah Batch</td>
				        <td>:</td>
				        <td width="75%"> 
				        	<input type="hidden" name="iexport_ro_detail[]" value="<?php echo $iexport_ro_detail ?>">
				        	
				        	<?php 
				        		if (empty($iJumlah_batch)) {
				        	?>
				        			<span><input type="text" name="iJumlah_batch[]" value="" size="5"></span>		
				        	<?php 
				        		}else{
				        	?>
				        			<span >
				        					<input type="hidden" name="iJumlah_batch[]" value="<?php echo $iJumlah_batch ?>" size="5">
				        					<?php echo $iJumlah_batch ?>
				        			</span>	
				        	<?php 
				        		} 
				        	?>
				        	
				            
				            
				        </td>
				    </tr>

				</tbody>    
			</table>
		</div>
 		<?php 
 			if (empty($iJumlah_batch)) {
 				echo "<span style='margin-left: 5px;font-weight:bold;' >isi Jumlah Batch !!! </span>";
 			}else{

 				

 		?>	
				 		<table class="hover_table" id="export_detail_terima_supplier_<?php echo $iexport_ro_detail ?>" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
							  <thead>
								  <tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
								    <th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">DETAIL PENERIMAAN</span></th>
								  </tr>
								  <tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
								    <th style="border: 1px solid #dddddd;">No Batch</th>
								    <th style="border: 1px solid #dddddd;">Jumlah Terima</th>
								    <th style="border: 1px solid #dddddd;">Satuan</th>
								    <th style="border: 1px solid #dddddd;">Tanggal Terima</th>
								    <th style="border: 1px solid #dddddd;">Batch Ke</th>
								    <th style="border: 1px solid #dddddd;">No KSK</th>
								    <th style="border: 1px solid #dddddd;">Status On Going</th>
								    <th style="border: 1px solid #dddddd;">Status Analisa BB</th>
								    <!-- <th style="border: 1px solid #dddddd;">Action</th>     -->
								  </tr>
							  </thead>
							  
							  <tbody>
							  	<?php 
							  		$sqBatch = 'select * 
					 							from reformulasi.export_ro_detail_batch a 
					 							where a.lDeleted=0 
					 							and a.iexport_ro_detail="'.$iexport_ro_detail.'" ';
					 				$dBatch = $this->db->query($sqBatch)->result_array();

					 				if (!empty($dBatch)) {
					 					foreach ($dBatch as $dataBacth ) {
							  	 ?>
											  	<tr>
											  		<td>
											  			<?php if ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) {	?>
												  				<input type="hidden" name="iexport_ro_detail_batch[]" class="angka" value="<?php echo $dataBacth['iexport_ro_detail_batch'] ?>" size="8">
												  				<?php echo $dataBacth['vNo_batch'] ?>
												  				<input type="hidden" name="vNo_batch[]" class="angka" value="<?php echo $dataBacth['vNo_batch'] ?>" size="8">
											  			<?php }else{ ?>
											  					<input type="hidden" name="iexport_ro_detail_batch[]" class="angka" value="<?php echo $dataBacth['iexport_ro_detail_batch'] ?>" size="8">
											  					<input type="text" name="vNo_batch[]" value="<?php echo $dataBacth['vNo_batch'] ?>" size="8">
											  			<?php } ?>
											  		</td>
											  		<td>
											  			<?php if ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) {	?>
											  					<?php echo $dataBacth['iJumlah_terima'] ?>
											  					<input type="hidden" name="iJumlah_terima[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima'] ?>" size="8">
											  			<?php }else{ ?>
											  					<input type="text" name="iJumlah_terima[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima'] ?>" size="8">
											  			<?php } ?>
											  		</td>
											  		<td>
											  				<?php if ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) {	?>
											  					<?php echo $dataBacth['vSatuan_batch'] ?>
											  					<input type="hidden" name="vSatuan_batch[]" class="angka" value="<?php echo $dataBacth['vSatuan_batch'] ?>" size="8">
											  				<?php }else{ 
											  						$sqlSatuan = "select *,a.nama_satuan as vNmSatuan from kanban.kbn_master_satuan a where a.iDeleted=0";
											  						$dtaSatauan = $this->db->query($sqlSatuan)->result_array();
											  						echo '<select name="vSatuan_batch[]">';
											  						foreach ($dtaSatauan as $d) {
											  							$swel = '';
											  							if($d['vNmSatuan']==$dataBacth['vSatuan_batch'] ){
											  								$swel = ' selected '; 
											  							}
											  							?> 
											  								<option <?php echo $swel ?> value='<?php echo $d['vNmSatuan']?>' >
											  									<?php echo $d['vNmSatuan']?></option>
											  							<?php
											  						}
											  						echo "</select>";

											  					?>
 
											  				
											  				<?php } ?>	
											  		</td>
											  		<td>
											  				<?php if ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) {	?>

											  					<?php echo $dataBacth['dTgl_terima_batch'] ?>
											  					<input type="hidden" name="dTgl_terima_batch[]" class="angka" value="<?php echo $dataBacth['dTgl_terima_batch'] ?>" size="8">
											  				<?php }else{ ?>
											  					<input type="text" name="dTgl_terima_batch[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_batch'] ?>" size="8">
											  				<?php } ?>	

											  		</td>
											  		<td>
												  			<?php echo $dataBacth['iBatch_ke'] ?>
												  			<input type="hidden" name="iBatch_ke[]" class="angka" value="<?php echo $dataBacth['iBatch_ke'] ?>" size="8">
											  		</td>
											  		<td>
											  				<?php if ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) {	?>

											  					<?php echo $dataBacth['vNo_KSK'] ?>
											  					<input type="hidden" name="vNo_KSK[]" class="angka" value="<?php echo $dataBacth['vNo_KSK'] ?>" size="8">
											  				<?php }else{ ?>
											  					<input type="text" name="vNo_KSK[]" value="<?php echo $dataBacth['vNo_KSK'] ?>" size="8">
											  				<?php } ?>	

											  		</td>

											  		<td>
											  				<?php if ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) {	?>
											  					<?php 
											  							$lmarketing = array(0=>'Tidak', 1=>'Ya');
											  							echo $lmarketing[$dataBacth['iOngoing'] ]; 
											  					?>
											  							<input type="hidden" name="iOngoing[]" class="angka" value="<?php echo $dataBacth['iOngoing'] ?>" size="8">
											  				<?php }else{
											  						$lmarketing = array(0=>'Tidak', 1=>'Ya');
												  					$o  = "<select name='iOngoing[]' >";  
														            foreach($lmarketing as $k=>$v) {
														                if ($k == $dataBacth['iOngoing']) $selected = " selected";
														                else $selected = "";
														                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
														            }            
														            $o .= "</select>";
														            echo $o;


											  				 ?>
													  				
											  					<!-- <input type="text" name="iOngoing[]" class="" value="<?php echo $dataBacth['iOngoing'] ?>" size="8"> -->
											  				<?php } ?>	

											  		</td>
											  		<!-- read status analisa BB jika sudah ada -->
												  		<td>
												  			<?php 
												  				$sql ='select a.iHasil_analisa_bb 
																		from reformulasi.export_ro_detail_batch a
																		where a.lDeleted=0
																		and a.iexport_ro_detail_batch="'.$dataBacth['iexport_ro_detail_batch'].'"
																		and a.iHasil_analisa_bb is not null';

																$dHasil = $this->db->query($sql)->row_array();

																if (!empty($dHasil)) {
																	if($dHasil['iHasil_analisa_bb'] == 2){
																		echo "Berhasil";
																	}else{
																		echo "<span style='color:red;'><b>Gagal</b></span>";
																	}
																}else{
																	echo "-";
																}

												  			 ?>
												  			

												  		</td>
											  		<!-- <td>-</td> -->
											  	</tr>
								


								<?php  		
										}
									}
								 ?>				  	
							  </tbody>
							  	<!-- <tfoot>
									<tr>
										<td colspan="8"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('export_detail_terima_supplier_<?php echo $iexport_ro_detail  ?>')">Tambah</a></td>
									</tr>
								</tfoot> -->

						</table>
		<?php 
			} 

		?>

		<div class="sepasi"></div>


		

 	<?php 
 		}
 	?>

<script type="text/javascript">
	// datepicker
	 $(".tanggal").datepicker({changeMonth:true,
								changeYear:true,
								dateFormat:"yy-mm-dd" });

	// input number
	   $(".angka").numeric();
</script>
