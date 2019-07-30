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

				$user = $this->auth_export->user();
                $x=$this->auth_export->dept();
                if($this->auth_export->is_manager()){
                    $x=$this->auth_export->dept();
                    $manager=$x['manager'];
                    if(in_array('PR', $manager)){$type='PR';}
                    else{$type='';}
                }
                else{
                    $x=$this->auth_export->dept();
                    $team=$x['team'];
                    if(in_array('PR', $team)){$type='PR';}
                    else{$type='';}
                }

                //print_r($team);
                //echo $type;


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
				'select *, a.iSubmit as submitUjiUpload
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
				and f.ipo_id= "'.$rowData['ipo_id'].'"  
				and a.iUji_mikro=2
				';
				/*echo '<pre>'.$sqDetailPo;*/
	$dDetailPo = $this->db->query($sqDetailPo)->result_array();

	//print_r($dDetailPo);

 ?>

 	<?php 
 		foreach ($dDetailPo as $detailpo) {
			$ipodet_id = $detailpo['ipodet_id'];
			$nmBB = $detailpo ['vnama'];
			$noRequest = $detailpo ['vRequest_no'];
			$iJumlah = $detailpo ['iJumlah'];
			$vSatuan = $detailpo ['vSatuan'];

			$iJumlah_batch = $detailpo['iJumlah_batch'];
			$iexport_ro_detail = $detailpo['iexport_ro_detail'];
			$iUji_mikro=$detailpo['iUji_mikro'];
			$iSubmit=$detailpo['submitUjiUpload'];

		

 			
 		

 	?>
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
 			.detail_<?php echo $iexport_ro_detail ?>{
 				width: 1800px;
 				/*overflow: auto*/
 			}
 			.cb1{
 				width: 100px;
 			}

 			.cb2{
 				width: 200px;
 			}

 			

 	</style>
 	<div class="detail_<?php echo $iexport_ro_detail ?>" >
	 		<!-- Header -->
	 		<div class="heder">
		 		<table style="width: 100%;" border="0">
					<tbody>         
						<tr>
					        <td width="15%">Nama Bahan Baku </td>
					        <td>:</td>
					        <td width="85%"><?php echo $nmBB ?></td>
					    </tr>

					    <tr>
					        <td width="15%">No Permintaan</td>
					        <td>:</td>
					        <td width="85%"> 
					            <span ><?php echo $noRequest ?></span>
					        </td>
					    </tr>

					    <tr>
					        <td width="15%">Jumlah</td>
					        <td>:</td>
					        <td width="85%"> 
					            <span ><?php echo $iJumlah ?></span>
					        </td>
					    </tr>
					    <tr>
					        <td width="15%">Satuan</td>
					        <td>:</td>
					        <td width="85%"> 
					            <span ><?php echo $vSatuan ?></span>
					        </td>
					    </tr>

					    <tr>
					        <td width="15%">Jumlah Batch</td>
					        <td>:</td>
					        <td width="85%"> 
					        	<input type="hidden" name="iexport_ro_detail[]" value="<?php echo $iexport_ro_detail ?>">
					        	
					        	<?php 


					        		if (empty($iJumlah_batch) and ( in_array('PD', $manager) or in_array('PD', $team))   ) {
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

					    <tr>
					        <td width="15%">Perlu Uji Mikro</td>
					        <td>:</td>
					        <td width="85%"> 
					        	<?php 
					        		if (empty($iUji_mikro) and ( in_array('PD', $manager) or in_array('PD', $team))) {
					        	?>
					        			<span>
					        				<?php 
					        					$lmarketing = array(''=>'Pilih',1=>'Tidak', 2=>'Ya');
							  					$o  = "<select name='iUji_mikro[]' >";  
									            foreach($lmarketing as $k=>$v) {
									                if ($k == $iUji_mikro) $selected = " selected";
									                else $selected = "";
									                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
									            }            
									            $o .= "</select>";
									            echo $o;

					        				 ?>
					        			</span>		
					        	<?php 
					        		}else{
					        	?>
					        			<span >

					        					<input type="hidden" name="iUji_mikro[]" value="<?php echo $iUji_mikro ?>" size="5">
					        					<?php 
					        						$luji = array(''=>'Pilih',1=>'Tidak', 2=>'Ya');
												  	echo $luji[$iUji_mikro ];  
												 ?>
					        			</span>	
					        	<?php 
					        		} 
					        	?>
					        	
					            
					            
					        </td>

					        <tr>
	                            <td width='15%'>File Upload</td>
	                            <td>:</td>
	                            <td width='85%'> 
	                                <span class='iupload_f' id='iupload_f'>
	                                	<?php 
	                                		$sq_all='SELECT * FROM reformulasi.`export_ro_detail_matrik` lf WHERE lf.lDeleted = 0 AND 
					                                lf.iexport_ro_detail = "'.$iexport_ro_detail.'"'; 
					                        $data['rows'] = $this->db->query($sq_all)->result_array();  
					                        $data['iexport_ro_detail']=$iexport_ro_detail;
					                        $filenya =  $this->load->view('export/sample/terima_bb_pd_ad_matrik',$data,TRUE);

					                        echo $filenya;
	                                	?>
	                                </span>
	                            </td>
	                        </tr>


					    </tr>

					</tbody>    
				</table>
			</div>
	 		<?php 
	 			if (empty($iUji_mikro)) {
	 				echo "<span style='margin-left: 5px;font-weight:bold;' >Pilih Uji Mikro  & Upload File Matriks First !!! </span>";
	 			}else{

	 				

	 		?>	
					 		<table class="hover_table" id="export_detail_terima_qa_<?php echo $iexport_ro_detail ?>" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
								  <thead>
									  <tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
									    <th colspan="8" rowspan="2" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">DETAIL PENERIMAAN DARI SUPPLIER</span></th>

									    <th colspan="13" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">DETAIL PENERIMAAN PD / AD / QA</span></th>
									  </tr>
									  <tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
									  	<th colspan="5" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">PD</span></th>
									  	<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Andev</span></th>
									  	<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">QA Mikro</span></th>
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

									    <!-- BAGIAN TERIMA SAMPLE PD -->
									    <th style="border: 1px solid #dddddd;">Jumlah Wadah (Batch)</th>
									    <th colspan="2" style="border: 1px solid #dddddd;">Jumlah Terima</th>
									    <th style="border: 1px solid #dddddd;">Tgl Terima</th>
									    <th style="border: 1px solid #dddddd;">Penerima</th>

									    <!-- BAGIAN TERIMA SAMPLE ANDEV -->
									    <th colspan="2" style="border: 1px solid #dddddd;">Jumlah Terima</th>
									    <th style="border: 1px solid #dddddd;">Tgl Terima</th>
									    <th style="border: 1px solid #dddddd;">Penerima</th>

									    <!-- BAGIAN TERIMA SAMPLE QA -->
									    <th colspan="2" style="border: 1px solid #dddddd;">Jumlah Terima</th>
									    <th style="border: 1px solid #dddddd;">Tgl Terima</th>
									    <th style="border: 1px solid #dddddd;">Penerima</th>


									  </tr>
								  </thead>
								  
								  <tbody>
								  	<?php 
								  		$sqBatch = 'select * 
						 							from reformulasi.export_ro_detail_batch a 
						 							join reformulasi.export_ro_detail b on b.iexport_ro_detail=a.iexport_ro_detail
						 							where a.lDeleted=0 
						 							and a.iexport_ro_detail="'.$iexport_ro_detail.'" 
						 							and a.iSubmit =1
						 							and a.iJumlah_terima is not null
						 							and a.vSatuan_batch is not null 
						 							and a.vNo_batch is not null
						 							and a.dTgl_terima_batch is not null
						 							
						 							';
						 				/*echo $sqBatch;
						 				exit;*/
						 				$dBatch = $this->db->query($sqBatch)->result_array();

						 				if (!empty($dBatch)) {
						 					foreach ($dBatch as $dataBacth ) {
								  	 ?>
												  	<tr>
												  		<td>
												  			<?php if ( ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) or (!in_array('PR', $team) )  ) {	?>
													  				<input type="hidden" name="iexport_ro_detail_batch[]" class="angka" value="<?php echo $dataBacth['iexport_ro_detail_batch'] ?>" size="8">
													  				<?php echo $dataBacth['vNo_batch'] ?>
													  				<input type="hidden" name="vNo_batch[]" class="angka" value="<?php echo $dataBacth['vNo_batch'] ?>" size="8">
												  			<?php }else{ ?>
												  					<input type="hidden" name="iexport_ro_detail_batch[]" class="angka" value="<?php echo $dataBacth['iexport_ro_detail_batch'] ?>" size="8">
												  					<input type="text" name="vNo_batch[]" value="<?php echo $dataBacth['vNo_batch'] ?>" size="8">
												  			<?php } ?>
												  		</td>
												  		<td>
												  			<?php if ( ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) or (!in_array('PR', $team) )  ) {	?>
												  					<?php echo $dataBacth['iJumlah_terima'] ?>
												  					<input type="hidden" name="iJumlah_terima[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima'] ?>" size="8">
												  			<?php }else{ ?>
												  					<input type="text" name="iJumlah_terima[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima'] ?>" size="8">
												  			<?php } ?>
												  		</td>
												  		<td>
												  			<?php if ( ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) or (!in_array('PR', $team) )  ) {	?>
												  					<?php echo $dataBacth['vSatuan_batch'] ?>
												  					<input type="hidden" name="vSatuan_batch[]" class="angka" value="<?php echo $dataBacth['vSatuan_batch'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="vSatuan_batch[]" value="<?php echo $dataBacth['vSatuan_batch'] ?>" size="8">
												  				<?php } ?>	
												  		</td>
												  		<td>
												  				<?php if ( ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) or (!in_array('PR', $team) )  ) {	?>

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
												  				<?php if ( ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) or (!in_array('PR', $team) )  ) {	?>

												  					<?php echo $dataBacth['vNo_KSK'] ?>
												  					<input type="hidden" name="vNo_KSK[]" class="angka" value="<?php echo $dataBacth['vNo_KSK'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="vNo_KSK[]" value="<?php echo $dataBacth['vNo_KSK'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td>
												  				<?php if ( ( $dataBacth['vNo_batch'] <> "" and $dataBacth['iJumlah_terima'] <> "" and $dataBacth['vSatuan_batch'] <> ""  and $dataBacth['dTgl_terima_batch'] <> ""  and $dataBacth['vNo_KSK'] <> "" ) or (!in_array('PR', $team) )  ) {	?>
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


												  		<!-- BAGIAN TERIMA SAMPLE OLEH PD START -->
												  		<td>
												  				<?php if ( ($dataBacth['iTerimaPd'] > 0)  or ( !( in_array('PD', $manager) and !in_array('PD', $team)) ) ) {	?>
												  					<?php echo $dataBacth['iJumlah_wadah'] ?>
												  					<input type="hidden" name="iJumlah_wadah[]" class="angka" value="<?php echo $dataBacth['iJumlah_wadah'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="iJumlah_wadah[]" class="angka" value="<?php echo $dataBacth['iJumlah_wadah'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td>
												  				<?php if ( ($dataBacth['iTerimaPd'] > 0)  or ( !( in_array('PD', $manager) and !in_array('PD', $team)) ) ) {	?>
												  					<?php echo $dataBacth['iJumlah_terima_pd'] ?>
												  					<input type="hidden" name="iJumlah_terima_pd[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima_pd'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="iJumlah_terima_pd[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima_pd'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td class="cb">	
												  				<?php if ( ($dataBacth['iTerimaPd'] > 0)  or ( !( in_array('PD', $manager) and !in_array('PD', $team)) ) ) {	
												  							$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 and a.plc2_master_satuan_id='".$dataBacth['iSatuan_pd']."'  ";
																	    	$teams = $this->db->query($sql)->row_array();

																	    	$ret = $teams['vNmSatuan'];
																	    	$ret .= '<input type="hidden" name="iSatuan_pd[]" class="angka" value="'.$dataBacth['iSatuan_pd'].'" size="8">';
										  									echo $ret; 
										  							 	}else{ 
												  				
														  					$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 ";
																	    	$teams = $this->db->query($sql)->result_array();
																	    	$echo = '<select class="chosen-select cb1" name="iSatuan_pd[]" >';
																	    	$echo .= '<option value="">--Pilih--</option>';
																	    	foreach($teams as $t) {
																	    		$selected = $dataBacth['iSatuan_pd'] == $t['plc2_master_satuan_id'] ? 'selected' : '';
																	    		$echo .= '<option '.$selected.' value="'.$t['plc2_master_satuan_id'].'">'.$t['vNmSatuan'].'</option>';
																	    	}
																	    	$echo .= '</select>';

																	    	echo $echo;
												  						} 
												  				?>	
												  			

												  		</td>

												  		<td>
												  				<?php if ( ($dataBacth['iTerimaPd'] > 0)  or ( !( in_array('PD', $manager) and !in_array('PD', $team)) ) ) {	?>
												  					<?php echo $dataBacth['dTgl_terima_pd'] ?>
												  					<input type="hidden" name="dTgl_terima_pd[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_pd'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="dTgl_terima_pd[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_pd'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td>
												  				<?php if ( ($dataBacth['iTerimaPd'] > 0)  or ( !( in_array('PD', $manager) and !in_array('PD', $team)) ) ) {	?>
												  					<?php 
												  					
												  						$iam = $controller->whoAmI($dataBacth['cPenerima_pd']);
											  							echo $iam['vName'];
												  					?>
												  					<input type="hidden" name="cPenerima_pd[]" value="<?php echo $dataBacth['cPenerima_pd'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="cPenerima_pd[]" value="<?php echo $dataBacth['cPenerima_pd'] ?>" size="8">
												  				<?php } ?>	

												  		</td>


												  		<!-- BAGIAN TERIMA SAMPLE OLEH PD END  -->

												  		<!-- BAGIAN TERIMA SAMPLE OLEH AD START -->
												  		<td>
												  				<?php if ( ($dataBacth['iTerimaAd'] > 0)  or ( !in_array('AD', $team) and !in_array('AD', $manager)  ) ) {	?>
												  					<?php echo $dataBacth['iJumlah_terima_ad'] ?>
												  					<input type="hidden" name="iJumlah_terima_ad[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima_ad'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="iJumlah_terima_ad[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima_ad'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td class="cb">	
												  				<?php if ( ($dataBacth['iTerimaAd'] > 0)  or ( !in_array('AD', $team) and !in_array('AD', $manager)  ) ) {	
												  							$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 and a.plc2_master_satuan_id='".$dataBacth['iSatuan_ad']."'  ";
																	    	$teams = $this->db->query($sql)->row_array();

																	    	$ret = $teams['vNmSatuan'];
																	    	$ret .= '<input type="hidden" name="iSatuan_ad[]" class="angka" value="'.$dataBacth['iSatuan_ad'].'" size="8">';
										  									echo $ret; 
										  							 	}else{ 
												  				
														  					$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 ";
																	    	$teams = $this->db->query($sql)->result_array();
																	    	$echo = '<select class="chosen-select cb1" name="iSatuan_ad[]" >';
																	    	$echo .= '<option value="">--Pilih--</option>';
																	    	foreach($teams as $t) {
																	    		$selected = $dataBacth['iSatuan_ad'] == $t['plc2_master_satuan_id'] ? 'selected' : '';
																	    		$echo .= '<option '.$selected.' value="'.$t['plc2_master_satuan_id'].'">'.$t['vNmSatuan'].'</option>';
																	    	}
																	    	$echo .= '</select>';

																	    	echo $echo;
												  						} 
												  				?>	
												  			

												  		</td>

												  		<td>
												  				<?php if ( ($dataBacth['iTerimaAd'] > 0)  or ( !in_array('AD', $team) and !in_array('AD', $manager)  ) ) {	?>
												  					<?php echo $dataBacth['dTgl_terima_ad'] ?>
												  					<input type="hidden" name="dTgl_terima_ad[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_ad'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="dTgl_terima_ad[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_ad'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td>
												  				<?php if ( ($dataBacth['iTerimaAd'] > 0)  or ( !in_array('AD', $team) and !in_array('AD', $manager)  ) ) {	?>
												  					<?php 
												  						$iam = $controller->whoAmI($dataBacth['cPenerima_ad']);
											  							echo $iam['vName'];
											  						?>
												  					<input type="hidden" name="cPenerima_ad[]" value="<?php echo $dataBacth['cPenerima_ad'] ?>" size="8">
												  				<?php }else{ 
												  						$sql = "
												  							select a.vnip,d.vName 
																			from reformulasi.reformulasi_team a 
																			join reformulasi.reformulasi_team_item b on b.ireformulasi_team=a.ireformulasi_team
																			join reformulasi.reformulasi_master_departement c on c.ireformulasi_master_departement=a.cDeptId
																			join hrd.employee d on d.cNip=a.vnip
																			where a.ldeleted=0
																			and b.ldeleted=0
																			and c.lDeleted=0
																			and c.vkode_departement='QA'
																			

																			union 

																			select b.vnip,d.vName 
																			from reformulasi.reformulasi_team a 
																			join reformulasi.reformulasi_team_item b on b.ireformulasi_team=a.ireformulasi_team
																			join reformulasi.reformulasi_master_departement c on c.ireformulasi_master_departement=a.cDeptId
																			join hrd.employee d on d.cNip=b.vnip
																			where a.ldeleted=0
																			and b.ldeleted=0
																			and c.lDeleted=0
																			and c.vkode_departement='QA'

												  						 ";
																	    	$teams = $this->db->query($sql)->result_array();
																	    	$echo = '<select  class="chosen-select cb2" name="cPenerima_qa[]" >';
																	    	$echo .= '<option value="">--Pilih--</option>';
																	    	foreach($teams as $t) {
																	    		$selected = $dataBacth['cPenerima_qa'] == $t['vnip'] ? 'selected' : '';
																	    		$echo .= '<option '.$selected.' value="'.$t['vnip'].'">'.$t['vName'].'</option>';
																	    	}
																	    	$echo .= '</select>';

																	    	echo $echo;
																	    	
												  					?>
												  					<input type="text" name="cPenerima_ad[]" value="<?php echo $dataBacth['cPenerima_ad'] ?>" size="8">
												  				<?php } ?>	

												  		</td>


												  		<!-- BAGIAN TERIMA SAMPLE OLEH AD END  -->

												  		<!-- BAGIAN TERIMA SAMPLE OLEH QA START -->
												  		<td>
												  				<?php if ( ($dataBacth['iTerimaQa'] > 0)  or ( !in_array('QA', $team) and !in_array('QA', $manager) ) or ($iUji_mikro <> 2) ) {		?>
												  					<?php echo $dataBacth['iJumlah_terima_qa'] ?>
												  					<input type="hidden" name="iJumlah_terima_qa[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima_qa'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="iJumlah_terima_qa[]" class="angka" value="<?php echo $dataBacth['iJumlah_terima_qa'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td class="cb">	
												  				<?php if ( ($dataBacth['iTerimaQa'] > 0)  or ( !in_array('QA', $team) and !in_array('QA', $manager) ) or ($iUji_mikro <> 2) ) {	
												  							$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 and a.plc2_master_satuan_id='".$dataBacth['iSatuan_qa']."'  ";
																	    	$teams = $this->db->query($sql)->row_array();

																	    	$ret = $teams['vNmSatuan'];
																	    	$ret .= '<input type="hidden" name="iSatuan_qa[]" class="angka" value="'.$dataBacth['iSatuan_qa'].'" size="8">';
										  									echo $ret; 
										  							 	}else{ 
												  				
														  					$sql = "select * from plc2.plc2_master_satuan a where a.ldeleted=0 ";
																	    	$teams = $this->db->query($sql)->result_array();
																	    	$echo = '<select  class="chosen-select cb1" name="iSatuan_qa[]" >';
																	    	$echo .= '<option value="">--Pilih--</option>';
																	    	foreach($teams as $t) {
																	    		$selected = $dataBacth['iSatuan_qa'] == $t['plc2_master_satuan_id'] ? 'selected' : '';
																	    		$echo .= '<option '.$selected.' value="'.$t['plc2_master_satuan_id'].'">'.$t['vNmSatuan'].'</option>';
																	    	}
																	    	$echo .= '</select>';

																	    	echo $echo;
												  						} 
												  				?>	
												  			

												  		</td>

												  		<td>
												  				<?php if ( ($dataBacth['iTerimaQa'] > 0)  or ( !in_array('QA', $team) and !in_array('QA', $manager) ) or ($iUji_mikro <> 2) ) {	?>
												  					<?php echo $dataBacth['dTgl_terima_qa'] ?>
												  					<input type="hidden" name="dTgl_terima_qa[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_qa'] ?>" size="8">
												  				<?php }else{ ?>
												  					<input type="text" name="dTgl_terima_qa[]" class="tanggal" value="<?php echo $dataBacth['dTgl_terima_qa'] ?>" size="8">
												  				<?php } ?>	

												  		</td>

												  		<td class="cb">
												  				<?php if ( ($dataBacth['iTerimaQa'] > 0)  or ( !in_array('QA', $team) and !in_array('QA', $manager) ) or ($iUji_mikro <> 2) ) {	?>
												  					<?php 
												  						$iam = $controller->whoAmI($dataBacth['cPenerima_qa']);
											  							echo $iam['vName'];
											  						?>
												  					<input type="hidden" name="cPenerima_qa[]" value="<?php echo $dataBacth['cPenerima_qa'] ?>" size="8">
												  				<?php }else{ 
												  						$sql = "
												  							select a.vnip,d.vName 
																			from reformulasi.reformulasi_team a 
																			join reformulasi.reformulasi_team_item b on b.ireformulasi_team=a.ireformulasi_team
																			join reformulasi.reformulasi_master_departement c on c.ireformulasi_master_departement=a.cDeptId
																			join hrd.employee d on d.cNip=a.vnip
																			where a.ldeleted=0
																			and b.ldeleted=0
																			and c.lDeleted=0
																			and c.vkode_departement='QA'

																			union 

																			select b.vnip,d.vName 
																			from reformulasi.reformulasi_team a 
																			join reformulasi.reformulasi_team_item b on b.ireformulasi_team=a.ireformulasi_team
																			join reformulasi.reformulasi_master_departement c on c.ireformulasi_master_departement=a.cDeptId
																			join hrd.employee d on d.cNip=b.vnip
																			where a.ldeleted=0
																			and b.ldeleted=0
																			and c.lDeleted=0
																			and c.vkode_departement='QA'

												  						 ";
																	    	$teams = $this->db->query($sql)->result_array();
																	    	$echo = '<select  class="chosen-select cb2" name="cPenerima_qa[]" >';
																	    	$echo .= '<option value="">--Pilih--</option>';
																	    	foreach($teams as $t) {
																	    		$selected = $dataBacth['cPenerima_qa'] == $t['vnip'] ? 'selected' : '';
																	    		$echo .= '<option '.$selected.' value="'.$t['vnip'].'">'.$t['vName'].'</option>';
																	    	}
																	    	$echo .= '</select>';

																	    	echo $echo;

												  				?>
												  					<!-- <input type="text" name="cPenerima_qa[]" value="<?php echo $dataBacth['cPenerima_qa'] ?>" size="8"> -->
												  				<?php } ?>	

												  		</td>
												  		
												  		<!-- BAGIAN TERIMA SAMPLE OLEH QA END  -->

												  		<!-- <td>-</td> -->
												  	</tr>
									


									<?php  		
											}
										}
									 ?>				  	
								  </tbody>
								  	<tfoot>
										<tr>
											<td colspan="22" align="left"><i> *Satuan diambil dari master satuan pada aplikasi PLC<i></td>
										</tr>
										<tr>
											<td colspan="22" align="left"><i> *PIC Penerima diambil dari master stackholder<i></td>
										</tr>
									</tfoot>

							</table>
			<?php 
				} 

			?>

			<div class="sepasi"></div>
	</div>

		

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


	$(".chosen-selectz").chosen();


</script>
