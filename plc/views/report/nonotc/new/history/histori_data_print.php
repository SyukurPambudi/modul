 
<body style="font-family: serif; font-size: 14px;">
<style>

.table1 {
    color: #000;
    border-collapse: collapse;
}
 
.dddd tr th{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}
 
.table1, .table1 th, .table1 td {
    text-align: left;
    border: 1px solid #BBB;
}

.table1 tbody tr:nth-child(even) {
    background-color: #f2f5f7;
}
.table1 thead tr td{
	background: #35A9DB;
     color: #fff;
    font-weight: normal;
    text-align: center;
}

.tablechild {
	color: #000;
    border-collapse: collapse;
}
.tablechild tr td{
    font-weight: normal;
    text-align: left;
}
</style>


<div style='width:100%;'>
<div width='100%' align="center" style="font-size: 16px;"><b>History Pengadaan Sample, Mikrobiologi dan BB Andev</b></br><?php echo $row['vupb_nomor'].' || '.$row['vupb_nama'] ?><br></div> 
<table border="1" id="table1" class="table1 display dddd" cellspacing="0" >
		<thead>
		 <tr>
		 	<th colspan="9">PD - SOURCHING</th>
		 	<th colspan="3">MIKRO</th>
		 	<th colspan="3">ANDEV - PD - QA</th>
		 </tr>
		 <tr>
			 
			<th colspan="6">Detail Permintaan</th>			
			<th rowspan="2">PO Sample</th> 
			<th rowspan="2">Penerimaan Sample dari Supplier</th> 
			<th rowspan="2">Terima Sample Bahan Baku</th> 
			<th rowspan="2">Uji Mikro BB</th> 
			<th rowspan="2">Draft SOI Mikro BB</th> 
			<th rowspan="2">SOI Mikro BB Final</th> 
			<th rowspan="2">Analisa dan Release Sample Bahan Baku</th> 
			<th rowspan="2">Draft SOI BB</th> 
			<th rowspan="2">SOI Bahan Baku</th> 
							 
		</tr> 
		 
		<tr>
			 <th>No Permintaan</th>
			 <th>Tanggal Permintaan</th>
			 <th>Team PD</th> 
			 <th>Tujuan Request</th> 
			 <th>Detail Bahan Baku</th> 
			 <th>Tgl Approved</th>  
		</tr>
	</thead> 
	<tbody>
		<?php  
 
			$tujuanReq = array(''=>'-','0'=>'-','1'=>'Untuk Sample','2'=>'Untuk Skala Lab','3'=>'Untuk Pilot','4'=>'Untuk Re-Sample','5'=>'Skala Lab');
			$typ = array(''=>'-','0'=>'-','1'=>'Free','2'=>'Not Free');
			$jns = array(''=>'-','0'=>'Tidak','1'=>'Iya','2'=>'-');
			$jns2 = array(''=>'-','0'=>'','1'=>'Tidak','2'=>'Iya');

			//Sample
			$samp ="SELECT ps.`ireq_id`, ps.`vreq_nomor`,ps.`trequest`,ps.iTujuan_req, ps.`iupb_id`, ps.`iapppd`, ps.`tapppd`, ps.`vnip_apppd` FROM plc2.`plc2_upb_request_sample` ps WHERE 
				ps.`ldeleted` = 0 AND ps.`iupb_id` = '".$row['iupb_id']."'";
			$count = $this->db_plc0->query($samp)->num_rows();
			$samp_p = $this->db_plc0->query($samp)->result_array();

			$gTeam = 'SELECT pt.`vteam` FROM plc2.`plc2_upb_team` pt WHERE pt.`ldeleted` = 0 AND pt.`iteam_id` = "'.$row['iteampd_id'].'"';
			$team = $this->db_plc0->query($gTeam)->row_array();
			if(empty($team['vteam'])){
				$team['vteam'] = '-';
			}

			$lo = 0 ;
			foreach ($samp_p as $ke) {

			echo '<tr>';
		 	echo '<td>'.$ke['vreq_nomor'].'</td>';
		 	echo '<td>'.$ke['trequest'].'</td>';  
		 	echo '<td>'.$team['vteam'].'</td>'; 
		 	echo '<td>'.$tujuanReq[$ke['iTujuan_req']].'</td>'; 
			echo '<td>';
				 		$bb = "SELECT pr.`vnama`, pus.`ijumlah`, pus.`vsatuan` FROM plc2.plc2_raw_material pr JOIN 
							plc2.`plc2_upb_request_sample_detail` pus ON pr.`raw_id` = pus.`raw_id` 
							WHERE pus.`ldeleted` = 0 AND pus.`ireq_id` = '".$ke['ireq_id']."'";
							$bb_p = $this->db_plc0->query($bb)->result_array();
							$num = 1;
							if(!empty($bb_p)){
								echo '<table width ="100%" border="1"><tr><th>No</th><th>Bahan Baku</th><th>Jumlah</th><th>Satuan</th><tr>';
								foreach ($bb_p as $va) {
									echo '<tr>';
									echo '<td>'.$num++.'</td>';
					 				echo '<td>'.$va['vnama'].'</td>'; 
					 				echo '<td>'.$va['ijumlah'].'</td>'; 
					 				echo '<td>'.$va['vsatuan'].'</td>'; 
					 				echo '</tr>';
								}
								echo '</table>';
							}
				 		echo '</td>'; 
				 	echo '<td>';
				 	if($ke['iapppd']==2){
				 		echo ' Approved oleh '.$ke['vnip_apppd'].', Pada '.$ke['tapppd']; 
				 	}else if($ke['iapppd']==0){
				 		echo ' Waiting for Approval';
				 	}else if($ke['iapppd']==1){
				 		echo ' Rejected oleh '.$ke['vnip_apppd'].', Pada '.$ke['tapppd'];
				 	}
			echo '</td>';

			echo '<td>';
				 			
			 			$bbb = "SELECT pr.`raw_id`, pr.`vnama`, pus.`ijumlah`, pus.`vsatuan` FROM plc2.plc2_raw_material pr JOIN 
						plc2.`plc2_upb_request_sample_detail` pus ON pr.`raw_id` = pus.`raw_id` 
						WHERE pus.`ldeleted` = 0 AND pus.`ireq_id` = '".$ke['ireq_id']."' and pus.`ireq_id` IN (SELECT pod.`ireq_id` FROM plc2.`plc2_upb_po_detail` pod WHERE pod.`ldeleted` = 0)";
						$bb_p_p = $this->db_plc0->query($bbb)->result_array();
						if(!empty($bb_p_p)){
							echo '<table width ="100%" border="1"><tr>';
				 				echo '<th>No</th>';
				 				echo '<th>Bahan Baku</th>';
				 				echo '<th>Detail PO Sample</th>'; 
				 			echo '<tr>';
			 			
							$num = 1;
							foreach ($bb_p_p as $va) {
								echo '<tr>';
								echo '<td>'.$num++.'</td>';
				 				echo '<td>'.$va['vnama'].'</td>'; 
				 				echo '<td>';
				 				
								$pur = "SELECT p.itype, p.`vpo_nomor`, m.`vnmsupp`, p.trequest, p.tdeadline, p.vor_nomor,p.iapppr,p.vnip_pur,p.tapp_pur FROM plc2.`plc2_upb_po_detail` po 
									JOIN plc2.`plc2_upb_po` p ON p.`ipo_id` = po.`ipo_id`
									JOIN hrd.`mnf_supplier` m ON m.`isupplier_id` = p.isupplier_id
									WHERE po.`ldeleted` = 0 AND p.`ldeleted` =0
									AND po.`ireq_id` = '".$ke['ireq_id']."' AND po.`raw_id` = '".$va['raw_id']."'";
								$pur_p = $this->db_plc0->query($pur)->result_array(); 
								//echo $pur;
								if(!empty($pur_p)){
									echo '<table width ="100%" border="1"><tr>';
						 				 echo '<th>Jenis</th>';
						 				 echo '<th>Nomor PO</th>';
										 echo '<th>Nama Supplier</th>'; 
										 echo '<th>Tgl PO Request</th>';
										 echo '<th>Tgl ETA</th>';
										 echo '<th>No OR</th>';
										 echo '<th>Tgl Confirm PO oleh Sourcing</th>';
									echo '</tr>';


									foreach ($pur_p as $pu) {
										echo '<tr>';  
											echo '<td>'.$typ[$pu['itype']].'</td>';
							 				echo '<td>'.$pu['vpo_nomor'].'</td>';
							 				echo '<td>'.$pu['vnmsupp'].'</td>';
							 				echo '<td>'.$pu['trequest'].'</td>';
							 				echo '<td>'.$pu['tdeadline'].'</td>';
							 				echo '<td>'.$pu['vor_nomor'].'</td>'; 
							 				echo '<td>';
										 	if($pu['iapppr']==2){
										 		echo ' Approved oleh '.$pu['vnip_pur'].', Pada '.$pu['tapp_pur']; 
										 	}else if($pu['iapppr']==0){
										 		echo ' Waiting for Approval';
										 	}else if($pu['iapppr']==1){
										 		echo ' Rejected oleh '.$pu['vnip_pur'].', Pada '.$pu['tapp_pur'];
										 	}
										 	echo '</td>';

						 				echo '</tr>';
									}
									echo '</table>';
								}

								
								echo '</td>';
				 				echo '</tr>'; 
							}
							echo '</table>'; 
						}
				 			
				echo '</td>'; 


				echo '<td>';
				 		$pemr = "SELECT ro.vro_nomor, ro.`iro_id`, p.ipo_id, p.`vpo_nomor`, ro.trequest FROM plc2.`plc2_upb_po_detail` po 
							 JOIN plc2.`plc2_upb_po` p ON p.`ipo_id` = po.`ipo_id`
							 JOIN hrd.`mnf_supplier` m ON m.`isupplier_id` = p.isupplier_id
							 JOIN plc2.`plc2_upb_ro` ro on ro.ipo_id = po.`ipo_id`
							 WHERE po.`ldeleted` = 0 AND p.`ldeleted` =0 AND ro.ldeleted = 0
							 AND
							 po.`ireq_id` = '".$ke['ireq_id']."'";
						//echo $pemr;
						$pemr_p = $this->db_plc0->query($pemr)->result_array();
						if(!empty($pemr_p)){
							echo '<table width ="100%" border="1"><tr>';
				 				 echo '<th>Nomor PO</th>'; 
				 				 echo '<th>Nomor RO</th>'; 
				 				 echo '<th>Tanggal Terima</th>'; 
				 				 echo '<th>Detail Penerimaan Supplier</th>'; 
							echo '</tr>';
							foreach ($pemr_p as $pr) {
								echo '<tr>';   
					 				echo '<td>'.$pr['vpo_nomor'].'</td>';
					 				echo '<td>'.$pr['vro_nomor'].'</td>'; 
					 				echo '<td>'.$pr['trequest'].'</td>';
					 				echo '<td>';
					 				$batch ="SELECT b.`vbatch_nomor`, b.`iJumlah`, b.`vSatuan` FROM  plc2.`plc2_upb_ro_batch` b 
										WHERE b.`ldeleted` = 0 AND b.`iro_id` = '".$pr['iro_id']."'";
									$batch_p = $this->db_plc0->query($batch)->result_array();
									if(!empty($batch_p)){
										echo '<table width ="100%" border="1"><tr>';
							 				echo '<th>Nomor Batch</th>'; 
							 				echo '<th>Jumlah</th>'; 
							 				echo '<th>Satuan</th></tr>';
							 				foreach ($batch_p as $bp) {
												echo '<tr>';   
									 				echo '<td>'.$bp['vbatch_nomor'].'</td>';
									 				echo '<td>'.$bp['iJumlah'].'</td>';
									 				echo '<td>'.$bp['vSatuan'].'</td>'; 
									 			echo '</tr>'; 
								 			}
						 				echo '</table>'; 
									} 
					 				echo '</td>'; 
					 				
					 			echo '</tr>'; 
							}
							echo '</table>'; 
						}
				echo '</td>';

				echo '<td>';

					$ter = "SELECT ro.vro_nomor, ro.`iro_id`, 
							rod.vrec_jum_pd,rod.vrec_nip_pd,rod.trec_date_pd, 
							rod.vrec_jum_qc,rod.vrec_nip_qc,rod.trec_date_qc, 
							rod.vrec_jum_qa,rod.vrec_nip_qa,rod.trec_date_qa
							FROM 
							plc2.`plc2_upb_po_detail` po JOIN plc2.`plc2_upb_po` p ON p.`ipo_id` = po.`ipo_id` 
							JOIN hrd.`mnf_supplier` m ON m.`isupplier_id` = p.isupplier_id 
							JOIN plc2.`plc2_upb_ro` ro ON ro.ipo_id = po.`ipo_id` 
							JOIN plc2.`plc2_upb_ro_detail` rod ON rod.`iro_id` = ro.`iro_id` 
							WHERE po.`ldeleted` = 0 AND p.`ldeleted` =0 AND rod.`ldeleted` = 0 
							AND ro.ldeleted = 0 
							AND po.`ireq_id` = '".$ke['ireq_id']."'"; 
						//echo $ter;
						$ter_p = $this->db_plc0->query($ter)->result_array();
						if(!empty($ter_p)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th rowspan="2">Nomor RO</th>'; 
			 				 echo '<th colspan="3">PD</th>'; 
			 				 echo '<th colspan="3">AD</th>'; 
			 				 echo '<th colspan="3">QA</th>'; 
				 			echo '</tr><tr>';   
			 				 echo '<th>Jumlah Total Terima</th>'; 
			 				 echo '<th>PIC Penerima</th>'; 
			 				 echo '<th>TGL Terima</th>'; 
			 				 echo '<th>Jumlah Total Terima</th>'; 
			 				 echo '<th>PIC Penerima</th>'; 
			 				 echo '<th>TGL Terima</th>'; 
			 				 echo '<th>Jumlah Total Terima</th>'; 
			 				 echo '<th>PIC Penerima</th>'; 
			 				 echo '<th>TGL Terima</th>'; 
				 			echo '</tr>'; 
				 			foreach ($ter_p as $tp) {
								echo '<tr>';   
					 				echo '<td>'.$tp['vro_nomor'].'</td>';
					 				echo '<td>'.$tp['vrec_jum_pd'].'</td>';
					 				echo '<td>'.$tp['vrec_nip_pd'].'</td>'; 
					 				echo '<td>'.$tp['trec_date_pd'].'</td>'; 

					 				echo '<td>'.$tp['vrec_jum_qc'].'</td>';
					 				echo '<td>'.$tp['vrec_nip_qc'].'</td>'; 
					 				echo '<td>'.$tp['trec_date_qc'].'</td>'; 

					 				echo '<td>'.$tp['vrec_jum_qa'].'</td>';
					 				echo '<td>'.$tp['vrec_nip_qa'].'</td>'; 
					 				echo '<td>'.$tp['trec_date_qa'].'</td>'; 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>'; 
						}

				echo '</td>'; 

				echo '<td>';

					$mikrobb = "SELECT ps.`vreq_nomor`, pm.`vnama`, bb.`iuji_mikro_bb`, bb.iJumlah_terima,
						bb.dMulai_literatur, bb.dSelesai_literatur, 
						bb.dMulai_uji,bb.dSelesai_uji, bb.cApproval_uji, bb.cPic_uji, bb.iUji_spesifik, bb.dApproval_uji, bb.`iApprove_uji`, bb.`dApproval_uji` FROM plc2.`uji_mikro_bb` bb 
						JOIN plc2.plc2_upb_request_sample_detail psd ON bb.`ireqdet_id` = psd.`ireqdet_id`
						JOIN plc2.plc2_upb_request_sample ps ON ps.`ireq_id` = psd.`ireq_id`
						JOIN plc2.plc2_raw_material pm ON pm.`raw_id` = psd.`raw_id`
						WHERE ps.`ldeleted` = 0 AND psd.`ldeleted` = 0 AND bb.`lDeleted` = 0 AND pm.`ldeleted` = 0
						AND ps.`ireq_id` =  '".$ke['ireq_id']."'"; 
						//echo $ter;
						$mikrobb_b = $this->db_plc0->query($mikrobb)->result_array();
						if(!empty($mikrobb_b)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th >Nomor Permintaan</th>'; 
			 				 echo '<th >Tgl Mulai Study Literatur</th>'; 
			 				 echo '<th >Tgl Selesai Study Literatur</th>'; 
			 				 echo '<th >Tgl Mulai Pengujian</th>'; 
			 				 echo '<th >Tgl Selesai Pengujian</th>'; 
			 				 echo '<th >PIC</th>';
			 				 echo '<th >Perlu Uji Spesifik</th>'; 
			 				 echo '<th >Approval Chief Mikro</th>'; 
			 				echo '</tr>';
			 				foreach ($mikrobb_b as $mb) {
								echo '<tr>';   
					 				echo '<td>'.$mb['vreq_nomor'].' || '.$mb['vnama'].'</td>';
					 				echo '<td>'.$mb['dMulai_literatur'].'</td>';
					 				echo '<td>'.$mb['dSelesai_literatur'].'</td>'; 
					 				echo '<td>'.$mb['dMulai_uji'].'</td>';
					 				echo '<td>'.$mb['dSelesai_uji'].'</td>';

					 				echo '<td>'.$mb['cPic_uji'].'</td>'; 
					 				echo '<td>'.$jns[$mb['iUji_spesifik']].'</td>'; 
					 				echo '<td>';
						 				if($mb['iApprove_uji']==2){ //Approve
											echo "Approved Oleh ".$mb['cApproval_uji']."<br>Pada ".$mb['dApproval_uji']."";
										}else if($mb['iApprove_uji']==1){ // Reject
											echo "Rejected Oleh ".$mb['cApproval_uji']."<br>Pada ".$mb['dApproval_uji']."";
										}else if($mb['iApprove_uji']==0){
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 
 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>'; 
						}

				echo '</td>'; 

				echo '<td>';

					$draftmikrobb = "SELECT ps.`vreq_nomor`, pm.`vnama`, bb.`iuji_mikro_bb`,
						bb.dMulai_draft_soi, bb.dSelesai_draft_soi, bb.iApprove_draft,bb.dApproval_draft,bb.cApproval_draft FROM plc2.`uji_mikro_bb` bb 
						JOIN plc2.plc2_upb_request_sample_detail psd ON bb.`ireqdet_id` = psd.`ireqdet_id`
						JOIN plc2.plc2_upb_request_sample ps ON ps.`ireq_id` = psd.`ireq_id`
						JOIN plc2.plc2_raw_material pm ON pm.`raw_id` = psd.`raw_id`
						WHERE ps.`ldeleted` = 0 AND psd.`ldeleted` = 0 AND bb.`lDeleted` = 0 AND pm.`ldeleted` = 0
						AND ps.`ireq_id` =  '".$ke['ireq_id']."'"; 
						//echo $draftmikrobb;
						$draftmikrobb_b = $this->db_plc0->query($draftmikrobb)->result_array();
						if(!empty($draftmikrobb_b)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th >Nomor Permintaan</th>'; 
			 				 echo '<th >Tgl Mulai Pembuatan Draft</th>'; 
			 				 echo '<th >Tgl Selesai Pembuatan Draft</th>'; 
			 				 echo '<th >Approval Draft (Chief QA)</th>'; 
			 				echo '</tr>';
			 				foreach ($draftmikrobb_b as $db) {
								echo '<tr>';   
					 				echo '<td>'.$db['vreq_nomor'].' || '.$db['vnama'].'</td>';
					 				echo '<td>'.$db['dMulai_draft_soi'].'</td>';
					 				echo '<td>'.$db['dSelesai_draft_soi'].'</td>';  
					 				echo '<td>';
						 				if($db['iApprove_draft']==2){ //Approve
											echo "Approved Oleh ".$db['cApproval_draft']."<br>Pada ".$db['dApproval_draft']."";
										}else if($db['iApprove_draft']==1){ // Reject
											echo "Rejected Oleh ".$db['cApproval_draft']."<br>Pada ".$db['dApproval_draft']."";
										}else if($db['iApprove_draft']==0){
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 
 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>'; 
						}

				echo '</td>'; 

				echo '<td>';

					$finalmikro = "SELECT bb.`ireqdet_id`, ps.`vreq_nomor`, pm.`vnama`, bb.`iuji_mikro_bb`,
						bb.dMulai_draft_soi, bb.dSelesai_draft_soi, bb.iApprove_mikro_final,bb.dApproval_mikro_final,bb.cApproval_mikro_final FROM plc2.`uji_mikro_bb` bb 
						JOIN plc2.plc2_upb_request_sample_detail psd ON bb.`ireqdet_id` = psd.`ireqdet_id`
						JOIN plc2.plc2_upb_request_sample ps ON ps.`ireq_id` = psd.`ireq_id`
						JOIN plc2.plc2_raw_material pm ON pm.`raw_id` = psd.`raw_id`
						WHERE ps.`ldeleted` = 0 AND psd.`ldeleted` = 0 AND bb.`lDeleted` = 0 AND pm.`ldeleted` = 0
						AND ps.`ireq_id` =  '".$ke['ireq_id']."'"; 
						//echo $finalmikro;
						$finalmikro_b = $this->db_plc0->query($finalmikro)->result_array();
						if(!empty($finalmikro_b)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th >Nomor Permintaan</th>'; 
			 				 echo '<th >Tgl Mulai Pembuatan Draft</th>'; 
			 				 echo '<th >Tgl Selesai Pembuatan Draft</th>'; 
			 				 echo '<th >Approval Draft (Chief QA)</th>'; 
			 				echo '</tr>';
			 				foreach ($finalmikro_b as $fb) {
								echo '<tr>';   
					 				echo '<td>'.$fb['vreq_nomor'].' || '.$db['vnama'].'</td>';
					 				echo '<td>'.$fb['dMulai_draft_soi'].'</td>';
					 				echo '<td>'.$fb['dSelesai_draft_soi'].'</td>';  
					 				echo '<td>';
						 				if($fb['iApprove_mikro_final']==2){ //Approve
											echo "Approved Oleh ".$fb['cApproval_mikro_final']."<br>Pada ".$fb['dApproval_mikro_final']."";
										}else if($fb['iApprove_mikro_final']==1){ // Reject
											echo "Rejected Oleh ".$fb['cApproval_mikro_final']."<br>Pada ".$fb['dApproval_mikro_final']."";
										}else if($fb['iApprove_mikro_final']==0){
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 
 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>'; 
						}

				echo '</td>'; 


				echo '<td>';

					$relise = "SELECT p.`vpo_nomor`, po.`raw_id`, ro.vro_nomor, rod.irelease, ro.`iro_id` , rod.vrec_jum_pd, rod.`dStart_analisa`, 
						rod.`dFinish_analisa`,rod.vnip_apppd_analisa,rod.`iapppd_analisa`,rod.`tapppd_analisa`
						FROM plc2.`plc2_upb_po_detail` po JOIN plc2.`plc2_upb_po` p ON p.`ipo_id` = po.`ipo_id`  
						JOIN plc2.`plc2_upb_ro` ro ON ro.ipo_id = po.`ipo_id` 
						JOIN plc2.`plc2_upb_ro_detail` rod ON rod.`iro_id` = ro.`iro_id` 
						WHERE po.`ldeleted` = 0 
						AND p.`ldeleted` =0 AND rod.`ldeleted` = 0 
						AND ro.ldeleted = 0 AND po.`ireq_id` = '".$ke['ireq_id']."'"; 
						//echo $ter;
						$relise_p = $this->db_plc0->query($relise)->result_array();
						if(!empty($relise_p)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th >Nomor Permintaan</th>'; 
			 				 echo '<th >Nomor RO</th>'; 
			 				 echo '<th >Jumlah Terima</th>'; 
			 				 echo '<th >Tgl Mulai Analisa</th>'; 
			 				 echo '<th >Tgl Selesai Analisa</th>'; 
			 				 echo '<th >Status Release</th>'; 
			 				 echo '<th >Approved PD</th>'; 
			 				echo '</tr>'; 
			 				foreach ($relise_p as $rb) {
								echo '<tr>';   
					 				echo '<td>'.$rb['vpo_nomor'].'</td>';
					 				echo '<td>'.$rb['vro_nomor'].'</td>';
					 				echo '<td>'.$rb['vrec_jum_pd'].'</td>';
					 				echo '<td>'.$rb['dStart_analisa'].'</td>';
					 				echo '<td>'.$rb['dFinish_analisa'].'</td>';
					 				echo '<td>'.$jns2[$rb['irelease']].'</td>';  
					 				echo '<td>';
						 				if($rb['iapppd_analisa']==2){ //Approve
											echo "Approved Oleh ".$rb['vnip_apppd_analisa']."<br>Pada ".$rb['dFinish_analisa']."";
										}else if($rb['iapppd_analisa']==1){ // Reject
											echo "Rejected Oleh ".$rb['vnip_apppd_analisa']."<br>Pada ".$rb['dFinish_analisa']."";
										}else if($rb['iapppd_analisa']==0){
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 
 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>';   
						}

				echo '</td>'; 
 				echo '<td>';

					$draftsi = "SELECT ps.`vreq_nomor`, pm.`vnama`,  bb.dMulai_draft,bb.dSelesai_draft ,bb.vNoDraft, bb.cPenyusun,bb.dApproval,bb.`cApproval`, bb.`iApprove`  FROM plc2.`draft_soi_bb` bb 
						JOIN plc2.plc2_upb_request_sample_detail psd ON bb.`ireqdet_id` = psd.`ireqdet_id`
						JOIN plc2.plc2_upb_request_sample ps ON ps.`ireq_id` = psd.`ireq_id`
						JOIN plc2.plc2_raw_material pm ON pm.`raw_id` = psd.`raw_id`
						WHERE ps.`ldeleted` = 0 AND psd.`ldeleted` = 0 AND bb.`lDeleted` = 0 AND pm.`ldeleted` = 0 AND ps.`ireq_id` = '".$ke['ireq_id']."'"; 
						//echo $draftsi;
						$draftsi_b = $this->db_plc0->query($draftsi)->result_array();
						if(!empty($draftsi_b)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th >Nomor Permintaan</th>'; 
			 				 echo '<th >Tgl Mulai Pembuatan Draft</th>'; 
			 				 echo '<th >Tgl Selesai Pembuatan Draft</th>'; 
			 				 echo '<th >No Draft</th>'; 
			 				 echo '<th >Team PD</th>'; 
			 				 echo '<th >PIC Penyusun</th>'; 
			 				 echo '<th >Approval Draft (Chief QA)</th>'; 
			 				echo '</tr>'; 
			 				foreach ($draftsi_b as $dsb) {
								echo '<tr>';   
					 				echo '<td>'.$dsb['vreq_nomor'].' || '.$dsb['vnama'].'</td>';
					 				echo '<td>'.$dsb['dMulai_draft'].'</td>';
					 				echo '<td>'.$dsb['dSelesai_draft'].'</td>';
					 				echo '<td>'.$dsb['vNoDraft'].'</td>';
					 				echo '<td>'.$team['vteam'].'</td>'; 
					 				echo '<td>'.$dsb['cPenyusun'].'</td>'; 
					 				echo '<td>';
						 				if($dsb['iApprove']==2){ //Approve
											echo "Approved Oleh ".$dsb['cApproval']."<br>Pada ".$dsb['dApproval']."";
										}else if($dsb['iApprove']==1){ // Reject
											echo "Rejected Oleh ".$dsb['cApproval']."<br>Pada ".$dsb['dApproval']."";
										}else if($dsb['iApprove']==0){
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 
 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>';   
						}

				echo '</td>'; 

				if($lo==0){
				echo '<td rowspan="'.$count.'">';

					$soibb = "SELECT psb.vkode_surat,psb.tberlaku,psb.`vnip_qc`, psb.`iappqc`, psb.`tapp_qc`, psb.`vnip_qa`, psb.`tapp_qa`,psb.`iappqa` FROM plc2.plc2_upb_soi_bahanbaku psb 
						WHERE psb.`ldeleted` = 0 AND psb.`iupb_id` =  '".$row['iupb_id']."'"; 
						//echo $draftsi;
						$soibb_b = $this->db_plc0->query($soibb)->result_array();
						if(!empty($soibb_b)){
							echo '<table width ="100%" border="1"><tr>';
			 				 echo '<th >Nomor SOI</th>'; 
			 				 echo '<th >Tgl Berlaku</th>'; 
			 				 echo '<th >Approved PD</th>'; 
			 				 echo '<th >Approved QA</th>';  
			 				echo '</tr>';  
			 				foreach ($soibb_b as $ssb) {
								echo '<tr>';    
					 				echo '<td>'.$ssb['vkode_surat'].'</td>';
					 				echo '<td>'.$ssb['tberlaku'].'</td>'; 
					 				echo '<td>';
						 				if($ssb['iappqc']==2){ //Approve
											echo "Approved Oleh ".$ssb['vnip_qc']."<br>Pada ".$ssb['tapp_qc']."";
										}else if($ssb['iappqc']==1){ // Reject
											echo "Rejected Oleh ".$ssb['vnip_qc']."<br>Pada ".$ssb['tapp_qc']."";
										}else if($ssb['iappqc']==0){
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 

					 				echo '<td>';
						 				if($ssb['iappqa']==2){ //Approve
											echo "Approved Oleh ".$ssb['vnip_qa']."<br>Pada ".$ssb['tapp_qa']."";
										}else if($ssb['iappqa']==1){ // Reject
											echo "Rejected Oleh ".$ssb['vnip_qa']."<br>Pada ".$ssb['tapp_qa']."";
										}else if($ssb['iappqc']==0){											
											echo "Waiting for Approval";
										} 
					 				echo '</td>'; 
 
					 			echo '</tr>'; 
				 			}
				 			echo '</table>';   
						}

				echo '</td>'; 
			}$lo++;
 
			    echo '</tr>';
			} 
		?>
	</tbody>
</table>
</div>
</body>