<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 120%; border: 1px solid #dddddd; text-align: center; margin-left: -180px;  margin-top: 30px; border-collapse: collapse">
	<?php
		$i = 1;
		if (isset($mydept)) {
		if(in_array('BD', $mydept)){
			// $sql_iupb="select u.iupb_id from plc2.plc2_upb u 
						// where u.iconfirm_dok<>1 and u.ldeleted=0
						 // and u.iupb_id IN (select fo.iupb_id from plc2.plc2_upb_formula fo where fo.ibest=2 and fo.iapppd_basic=2 and fo.ldeleted=0 )
						 // and u.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.ldeleted=0)
						 // and u.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_spesifikasi_fg bk where bk.iappqa=2 and bk.ldeleted=0)";
			$sql_iupb="select u.iupb_id, u.vupb_nomor,u.vupb_nama from plc2.plc2_upb u
						 where (u.iconfirm_dok=0 or u.iconfirm_dok is null) and u.ldeleted=0
							and u.iteambusdev_id IN ($team)
							and u.iupb_id IN (select fo.iupb_id from plc2.plc2_upb_formula fo where fo.ibest=2 and fo.iapppd_basic=2 and fo.ldeleted=0)
							and u.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.ldeleted=0)
							and u.iupb_id IN (select distinct(bk.iupb_id) from plc2.plc2_upb_spesifikasi_fg bk where bk.iappqa=2 and bk.ldeleted=0)";
			$jum_iupb=$this->db_plc0->query($sql_iupb)->num_rows();
			$q_iupb=$this->db_plc0->query($sql_iupb)->result_array();
			$x=0;$x2=0;
			$jenisDok="";$fileDok="";$depDok="";$dateDok="";$null="";
			foreach($q_iupb as $r){
				$vupb_nomor=$r['vupb_nomor'];
				$vupb_nama=$r['vupb_nama'];
				$iupb_id=$r['iupb_id'];
				//dokumen yang belum di cek
				$tabel=array('plc2_upb_file_bk_dmf','plc2_upb_file_bk_coars','plc2_upb_file_bk_ws','plc2_upb_file_bk_coabb','plc2_upb_file_bk_lsa'
							,'plc2_upb_file_spesifikasi_fg','plc2_upb_file_skala_trial_filename'
							,'plc2_upb_file_proses_produksi','plc2_upb_file_lpp','plc2_upb_file_form_valpro','plc2_upb_file_lapprot_valpro'
							,'plc2_upb_file_coa_ex','plc2_upb_file_lsa_ex','plc2_upb_file_soi_ex','plc2_upb_file_coa_fg','plc2_upb_file_soi_fg'
							,'plc2_upb_file_valmoa','plc2_upb_file_lap_ori','plc2_upb_file_lapprot_udt','plc2_upb_file_bahan_kemas'
							,'plc2_upb_file_protaccel','plc2_upb_file_protreal','plc2_upb_file_stabpilot','plc2_upb_file_kube');
				$depnya=array('Purchasing PD','Purchasing PD','Purchasing PD','Purchasing PD','QC','PD','PD','PD','PD','PD','PD'
							,'Purchasing PD','QC','QC','QA','QC','PD','PD','PD','PD','PD','QC','PD','PD');
				$pknya=array('iupb_id','iupb_id','iupb_id','iupb_id','iupb_id','ispekfg_id','ifor_id','ifor_id','ifor_id','ifor_id','ifor_id'
							,'ifor_id','ifor_id','ifor_id','ifor_id','isoi_id','ifor_id','ifor_id','ifor_id','ibk_id','ifor_id','ifor_id'
							,'ifor_id','iupb_id');
				$tampil=array('Dokumen DMF','Dokumen CoA RS','Dokumen CoA WS','Dokumen CoA Bahan Baku','Dokumen LSA Zat Aktif'
							,'Dokumen Spesifikasi FG','Dokumen Formula','Dokumen Proses Produksi','Dokumen Form Validasi Proses'
							,'Dokumen Laporan Pengembangan Produk','Dokumen Laporan & Protokol Validasi Proses','Dokumen CoA Excipient'
							,'Dokumen LSA Excipient','Dokumen SOI Excipient','Dokumen CoA FG','Dokumen SOI FG'
							,'Dokumen Validasi MOA','Dokumen Laporan Originator','Dokumen Laporan & Protokol UDT','Dokumen Bahan Kemas'
							,'Dokumen Protokol Accelerated','Dokumen Protokol RealTime','Dokumen Stabilita Pilot','Dokumen Kajian Uji BE');
				 //cari ifor_id
					 $sql_for="select * from plc2.plc2_upb_formula fo where fo.iupb_id='$iupb_id' and fo.ibest=2 and fo.iapppd_basic=2 
							 order by fo.ifor_id desc limit 1";
					 $q_for=$this->db_plc0->query($sql_for)->row_array();
					 $ifor_id=$q_for['ifor_id'];
					 //print_r($q_for);
					
				//cari ibk_id
					$sql_bk="select bk.* from plc2.plc2_upb_bahan_kemas bk where bk.iappqa=2 and bk.iupb_id='$iupb_id'
								order by bk.ibk_id desc limit 1";
					 $q_bk=$this->db_plc0->query($sql_bk)->row_array();
					 $ibk_id=$q_bk['ibk_id'];
					
				 //cari ispekfg_id
					 $sql_spek="select fg.* from plc2.plc2_upb_spesifikasi_fg fg 
								 where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
								 order by fg.ispekfg_id desc limit 1";
					 $q_spek=$this->db_plc0->query($sql_spek)->row_array();
					 $ispek_id=$q_spek['ispekfg_id'];
					 //print_r($q_bk);
					
				 //cari isoi_id
					 $sql_soi="select fg.* from plc2.plc2_upb_soi_fg fg 
								 where fg.iappqa=2 and fg.iupb_id='$iupb_id' and fg.ldeleted=0
									 order by fg.isoi_id desc limit 1";
					 $q_soi=$this->db_plc0->query($sql_soi)->row_array();
					 $isoi_id=$q_soi['isoi_id'];
				
				$idnya=array($iupb_id, $iupb_id, $iupb_id, $iupb_id, $iupb_id, $ispek_id, $ifor_id, $ifor_id, $ifor_id, $ifor_id, $ifor_id
							,$ifor_id, $ifor_id, $ifor_id, $ifor_id, $isoi_id, $ifor_id, $ifor_id, $ifor_id, $ibk_id, $ifor_id, $ifor_id
							,$ifor_id, $iupb_id);
					
					foreach($tabel as $k=>$v){
						$query = $this->db_plc0->query("select * from plc2.".$v." where ".$pknya[$k]." =".$idnya[$k]);
						$jumlah = $query->num_rows();
						$x = $jumlah+$x;
						if($jumlah==0){
							$null.=$tampil[$k].',';
						}
						else{
							//cek jumlah yg blm done
							$query2 = $this->db_plc0->query("select f.*,(ifnull(dUpdateDate,dInsertDate)) as updateDate from plc2.".$v." as f where f.iconfirm_busdev=0 and f.".$pknya[$k]." =".$idnya[$k]);
							$jumlah2 = $query2->num_rows();
							if($jumlah2 > 0){
								$detDoka = $query2->result_array();
								//print_r($detDoka); echo '</br>';
								foreach($detDoka as $detDok){
									$fileDok .=$detDok['filename'].',';
									$dateDok .=$detDok['updateDate'].',';
									$jenisDok .=$tampil[$k].',';
									$depDok .=$depnya[$k].',';
								}
							}
						}
					}
			}
			//echo $vupb_nomor.'<br>'.$jenisDok.'<br>'.$fileDok.'</br>'.$depDok.'</br>'.$dateDok;	
			
			
			$ArjenisDok=explode(',',trim($jenisDok,','));
			$ArfileDok=explode(',',trim($fileDok,','));
			$ArdateDok=explode(',',trim($dateDok,','));
			$ArdepDok=explode(',',trim($depDok,','));
			if(!empty($ArjenisDok) && ($jum_iupb>0)) {
				
		?>
			<thead>
				<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
					<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">List Alert Cek Dokumen</span></th>
				</tr>
			</thead>
			<tbody>
				<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
					<th style="border: 1px solid #dddddd;">No</th>
					<th style="border: 1px solid #dddddd;">No UPB</th>
					<th style="border: 1px solid #dddddd;">Nama UPB</th>
					<th style="border: 1px solid #dddddd;">Jenis Dokumen</th>
					<th style="border: 1px solid #dddddd;">Nama File</th>
					<th style="border: 1px solid #dddddd;">Update</th>		
				</tr>
				
				<?php foreach($ArjenisDok as $ix=>$jeDok) {?> 
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; <?php if($i%2==0){echo "background: #e8ebea;";} else {echo "background: #ffffff;";}?>">
					<td style="border: 1px solid #dddddd; width: 2%; text-align: center;">
						<span class="alert_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%; text-align: center;">
						<?php echo $vupb_nomor; ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 20%; text-align: left;">
						<?php echo $vupb_nama;  ?> 
					</td>	
					<td style="border: 1px solid #dddddd; width: 20%; text-align: left;">
						<?php echo $jeDok; ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 28%; text-align: left;">
						<?php echo $ArfileDok[$ix]; ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 25%; text-align: center;">
						<?php echo 'Team: '.$ArdepDok[$ix].'</br>Pada: '.$ArdateDok[$ix]; ?>
					</td>
				</tr>
		<?php
			$i++;	
			}

			}
			else { 
			//$i++;
		?>
		<tr>
			 <td colspan="7" style="text-align: left"><b><p style="color:green;font-size:120%;">Semua Dokumen Telah Dicek.</p></b></td>
		</tr>
		<?php } } }?>
	</tbody>
	<tfoot>
	</tfoot>
</table>