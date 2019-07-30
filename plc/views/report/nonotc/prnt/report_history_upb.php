<body style="font-family: serif; font-size: 14px;">
<style>

.table1 {
    color: #000;
    border-collapse: collapse;
}
 
.table1 tr th{
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
<div width='100%' align="center" style="font-size: 16px;"><b>Report History UPB</b></br></div>
<table class="table1" width="100%" >
	<thead>
		<tr>
			<td rowspan="2">No</td>
			<td rowspan="2">Nama Usulan</td>
			<td colspan="2">Daftar UPB</td>
			<td rowspan="2">Review UPB</td>
			<td rowspan="2">Set Prioritas Prareg</td>			
			<td colspan="3">Sample Originator</td>
			<td rowspan="2">Study Literatur PD</td>
			<td rowspan="2">Study Literatur AD</td>
			<td colspan="4">Bahan Kemas Primer</td>
			<td colspan="4">Bahan Kemas Sekunder</td>
			<td>Permintaan Sample BB</td>
			<td>PO Sample</td>
			<td>Penerimaan Sample Dari Supplier</td>
			<td colspan="3">Terima Sample Oleh PD dan AD</td>
			<td>Analisa + Release BB</td>
			<td>Draft SOI BB</td>
			<td colspan="2">Spesifikasi SOI BB</td>
			<td>Formula Skala Trial</td>
		</tr>
		<tr>
			<td>Approval Busdev</td>
			<td>Approval Direksi</td>
			<td>No Request</td>
			<td>Request Sample Oridinaotr</td>
			<td>Terima sample Originator</td>
			<td>Approval PPIC</td>
			<td>Approval PD</td>
			<td>Approval Busdev</td>
			<td>Approval QA</td>
			<td>Approval PPIC</td>
			<td>Approval PD</td>
			<td>Approval Busdev</td>
			<td>Approval QA</td>
			<td>Approval PD</td>
			<td>Approval PR</td>
			<td>Approval PR</td>
			<td>Approval PD</td>
			<td>Approval QC</td>
			<td>Approval QA</td>
			<td>Approval PD</td>
			<td>Approval PD</td>
			<td>Approval PD</td>
			<td>Approval QA</td>
			<td>Approval PD</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($row as $kr => $vr) {
			echo "<tr>";
			echo "<td>".$vr['upb_no']."</td>";
			//Daftar UPB
			echo "<td>".$vr['nama']."</td>";
			echo "<td>".$vr['appbus']."</td>";
			echo "<td>".$vr['appdir']."</td>";
			//Review UPB
			echo "<td>".$vr['review_upb']."</td>";
			//Set Prioritas
			echo "<td>".$vr['set_prareg']."</td>";
			//Sample Originator (request dan terima)
			$sql="select ori.vreq_ori_no,
				if(ori.iSubmit>=1,
					if(ori.iapppd>=1,
					concat(
						(case when ori.iapppd=2 then 'Approved '
						when ori.iapppd=1 then 'Rejected '
						end),'Oleh: ',ori.vnip_apppd, ' Pada : ',ori.tapppd)
					,'Submit Need Approval ')
				,'Need To Submit ') as st,if(deor.isent_status=1,(concat('Sent Oleh : ',ori.vnip_apppd,' Pada : ',ori.tapppd)),'Have not been sent') as sent_ori
				from plc2.plc2_upb_request_originator ori 
				join plc2.otc_request_ori_detail deor on deor.ireq_ori_id=ori.ireq_ori_id
				where ori.ldeleted=0 and ori.iupb_id=".$vr['ID']."
				order by ori.vreq_ori_no ASC";
			$ddet=$this->db_plc0->query($sql);
			echo"<td>";
			$sa="";
			if($ddet->num_rows()>=1){
				$sa="<table class='tablechild'>";
				foreach ($ddet->result_array() as $kd => $vd) {
					$sa.="<tr><td>".$vd['vreq_ori_no']."</td></tr>";
				}
				$sa.="</table>";
			}
			echo $sa;
			echo"</td>";
			echo"<td>";
			if($ddet->num_rows()>=1){
				$sa="<table class='tablechild'>";
				foreach ($ddet->result_array() as $kd => $vd) {
					$sa.="<tr><td>".$vd['st']."</td></tr>";
				}
				$sa.="</table>";
			}
			echo"</td>";
			echo"<td>";
			$sa1="";
			if($ddet->num_rows()>=1){
				$sa1="<table class='tablechild'>";
				foreach ($ddet->result_array() as $kd => $vd) {
					$sa1.="<tr><td>".$vd['sent_ori']."</td></tr>";
				}
				$sa1.="</table>";
			}
			echo $sa1;
			echo"</td>";
			//Study Literatur
			echo "<td>".$vr['study_pd']."</td>";
			echo "<td>".$vr['study_ad']."</td>";
			//Bahan Kemas Primer
			$sqlbkp="select 
				if(bhnkms.iapppc>=1,concat(if(bhnkms.iapppc=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_apppc,' Pada : ',bhnkms.tapppc),'') as app_ppc,
				if(bhnkms.iapppd>=1,concat(if(bhnkms.iapppd=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_apppd,' Pada : ',bhnkms.tapppd),'') as app_ppd,
				if(bhnkms.iappbd>=1,concat(if(bhnkms.iappbd=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_appbd,' Pada : ',bhnkms.tappbd),'') as app_pbc,
				if(bhnkms.iappqa>=1,concat(if(bhnkms.iappqa=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_appqa,' Pada : ',bhnkms.tappqa),'') as app_pqa    
			from plc2.plc2_upb_bahan_kemas bhnkms where bhnkms.ldeleted=0 and bhnkms.iJenis_bk=1 and bhnkms.iupb_id=".$vr['ID'];
			$qrbkp=$this->db_plc0->query($sqlbkp);
			$app_ppc='';
			$app_ppd='';
			$app_pbc='';
			$app_pqa='';
			if($qrbkp->num_rows>=1){
				$drbkp=$qrbkp->row_array();
				$app_ppc=$drbkp['app_pqa'];
				$app_ppd=$drbkp['app_pqa'];
				$app_pbc=$drbkp['app_pqa'];
				$app_pqa=$drbkp['app_pqa'];
			}
			echo "<td>".$app_ppc."</td>";
			echo "<td>".$app_ppd."</td>";
			echo "<td>".$app_pbc."</td>";
			echo "<td>".$app_pqa."</td>";
			//Bahan Kemas Sekunder
			$sqlbkp2="select 
				if(bhnkms.iapppc>=1,concat(if(bhnkms.iapppc=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_apppc,' Pada : ',bhnkms.tapppc),'') as app_ppc,
				if(bhnkms.iapppd>=1,concat(if(bhnkms.iapppd=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_apppd,' Pada : ',bhnkms.tapppd),'') as app_ppd,
				if(bhnkms.iappbd>=1,concat(if(bhnkms.iappbd=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_appbd,' Pada : ',bhnkms.tappbd),'') as app_pbc,
				if(bhnkms.iappqa>=1,concat(if(bhnkms.iappqa=2,'Approved ','Rejected '),'Oleh ',bhnkms.vnip_appqa,' Pada : ',bhnkms.tappqa),'') as app_pqa    
			from plc2.plc2_upb_bahan_kemas bhnkms where bhnkms.ldeleted=0 and bhnkms.iJenis_bk=2 and bhnkms.iupb_id=".$vr['ID'];
			$qrbkp2=$this->db_plc0->query($sqlbkp2);
			$app_ppc2='';
			$app_ppd2='';
			$app_pbc2='';
			$app_pqa2='';
			if($qrbkp2->num_rows>=1){
				$drbkp2=$qrbkp2->row_array();
				$app_ppc2=$drbkp2['app_pqa'];
				$app_ppd2=$drbkp2['app_pqa'];
				$app_pbc2=$drbkp2['app_pqa'];
				$app_pqa2=$drbkp2['app_pqa'];
			}
			echo "<td>".$app_ppc2."</td>";
			echo "<td>".$app_ppd2."</td>";
			echo "<td>".$app_pbc2."</td>";
			echo "<td>".$app_pqa2."</td>";
			echo "<td>".$vr['appreqsample']."</td>";
			
			//Pembuatan PO
			echo"<td>";
			if(isset($vr['iReqid']) and $vr['iReqid']!="" and $vr['iReqid']!=0){
				$sqlpo="select po.vpo_nomor, if(po.iapppr>=1,
							concat(case when po.iapppr=1 then 'Reject' when po.iapppr=2 then 'Approved' END, ' Oleh :' ,po.vnip_pur,' Pada ' ,po.tapp_pur),' ') as app
					from plc2.plc2_upb_po_detail po1 
					join plc2.plc2_upb_po po on po.ipo_id=po1.ipo_id
					where po1.ldeleted = 0 and po.ldeleted=0 and po1.ireq_id =".$vr['iReqid']." order by po1.ipo_id desc";
				$ddetpo=$this->db_plc0->query($sqlpo);
				$sa2="";
				if($ddetpo->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($ddetpo->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vpo_nomor']."</td><td>".$vd['app']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
			}
			echo"</td>";

			//Penerimaan sample purcha
			echo"<td>";
			if(isset($vr['iReqid']) and $vr['iReqid']!="" and $vr['iReqid']!=0){
				$sqlps="select po.vpo_nomor, if(ro.iapppr>=1,
					concat(case when ro.iapppr=1 then 'Reject' when ro.iapppr=2 then 'Approved' END, ' Oleh :' ,ro.vnip_pur,' Pada ' ,ro.tapp_pur),' ') as app 
					from plc2.plc2_upb_ro ro
					join plc2.plc2_upb_po po on po.ipo_id=ro.ipo_id
					join plc2.plc2_upb_po_detail po2 on po.ipo_id=po2.ipo_id
				where po2.ldeleted = 0 and po2.ireq_id =".$vr['iReqid']." and po.ldeleted=0  order by po2.ipo_id desc";
				$ddetps=$this->db_plc0->query($sqlps);
				$sa2="";
				if($ddetps->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($ddetps->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vpo_nomor']."</td><td>".$vd['app']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
			}
			echo"</td>";

			//Terima Sample Oleh PD - AD
			if(isset($vr['ID']) and $vr['ID']!="" and $vr['ID']!=0){
				$sqltsa="SELECT plc2_upb_ro.vro_nomor,
				if(plc2_upb_ro_detail.vrec_jum_pd is not null and plc2_upb_ro_detail.vrec_jum_pd!=0,concat('Diterima Oleh ',plc2_upb_ro_detail.vrec_nip_pd,' Pada ',plc2_upb_ro_detail.trec_date_pd),'-') as terimaPD,
				if(plc2_upb_ro_detail.vrec_jum_qa is not null and plc2_upb_ro_detail.vrec_jum_qa!=0,concat('Diterima Oleh ',plc2_upb_ro_detail.vrec_nip_qa,' Pada ',plc2_upb_ro_detail.trec_date_qa),'-') as terimaQA,
				if(plc2_upb_ro_detail.vrec_jum_qc is not null and plc2_upb_ro_detail.vrec_jum_qc!=0,concat('Diterima Oleh ',plc2_upb_ro_detail.vrec_nip_qc,' Pada ',plc2_upb_ro_detail.trec_date_qc),'-') as terimaQC
					FROM plc2.plc2_upb_ro_detail
					INNER JOIN plc2.plc2_upb_request_sample ON plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id
					INNER JOIN plc2.plc2_upb_ro ON plc2.plc2_upb_ro.iro_id = plc2.plc2_upb_ro_detail.iro_id
					INNER JOIN plc2.plc2_upb ON plc2.plc2_upb.iupb_id = plc2.plc2_upb_request_sample.iupb_id
					INNER JOIN plc2.plc2_raw_material ON plc2.plc2_raw_material.raw_id = plc2.plc2_upb_ro_detail.raw_id
					WHERE plc2_upb.iupb_id = ".$vr['ID']."
					AND plc2_upb_ro_detail.ldeleted =  0
					AND plc2_upb_ro.iclose_po =  1
					AND plc2_upb.ihold =  0
					AND plc2_upb.itipe_id =  6
					AND plc2.plc2_upb.ldeleted =  0
					GROUP BY irodet_id
					ORDER BY plc2_upb_ro.vro_nomor desc LIMIT 1";
				$qtsa=$this->db_plc0->query($sqltsa);
				$sa2="";
				echo "<td>";
				if($qtsa->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($qtsa->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vro_nomor']."</td><td>".$vd['terimaPD']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
				echo "</td>";
				$sa2="";
				echo "<td>";
				if($qtsa->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($qtsa->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vro_nomor']."</td><td>".$vd['terimaQC']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
				echo "</td>";
				$sa2="";
				echo "<td>";
				if($qtsa->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($qtsa->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vro_nomor']."</td><td>".$vd['terimaQA']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
				echo "</td>";
			}

			//Analisa dan Release Sample BB
			echo"<td>";
			if(isset($vr['ID']) and $vr['ID']!="" and $vr['ID']!=0){
				$sqlpo="select a.vNo_analisa, if(a.iApprove>=1,
					concat(case when a.iApprove=1 then 'Reject' when a.iApprove=2 then 'Approved' END, ' Oleh :' ,a.cApproval,' Pada ' ,a.dApproval),' ') as app
					from plc2.analisa_bb a 
					where a.iupb_id=".$vr['ID']." and a.lDeleted=0";
				$ddetpo=$this->db_plc0->query($sqlpo);
				$sa2="";
				if($ddetpo->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($ddetpo->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vNo_analisa']."</td><td>".$vd['app']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
			}
			echo"</td>";

			//Draft SOI BB
			echo"<td>";
			if(isset($vr['ID']) and $vr['ID']!="" and $vr['ID']!=0){
				$sqlpo="select a.vNo_analisa, if(b.iApprove>=1,
						concat(case when b.iApprove=1 then 'Reject' when b.iApprove=2 then 'Approved' END, ' Oleh :' ,b.cApproval,' Pada ' ,b.dApproval),' ') as app
						from plc2.draft_soi_bb b
						inner join plc2.analisa_bb a on a.ianalisa_bb=b.ianalisa_bb
						where b.lDeleted=0 and a.lDeleted=0 and a.iupb_id=".$vr['ID'];
				$ddetpo=$this->db_plc0->query($sqlpo);
				$sa2="";
				if($ddetpo->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($ddetpo->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vNo_analisa']."</td><td>".$vd['app']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
			}
			echo"</td>";

			//Spesifikasi SOI Bahan Baku
			if(isset($vr['ID']) and $vr['ID']!="" and $vr['ID']!=0){
				$sqltsa="select bk.vkode_surat,
						if(bk.iappqc>=1,concat(case when bk.iappqc=1 then 'Reject' when bk.iappqc=2 then 'Approved' END, ' Oleh :' ,bk.vnip_qc,' Pada ' ,bk.tapp_qc),'-') as statusPD,
						if(bk.iappqa>=1,concat(case when bk.iappqa=1 then 'Reject' when bk.iappqa=2 then 'Approved' END, ' Oleh :' ,bk.vnip_qa,' Pada ' ,bk.tapp_qa),'-') as statusQA 
						from plc2.plc2_upb_soi_bahanbaku bk 
						where bk.ldeleted=0 and bk.iupb_id=".$vr['ID'];
				$qtsa=$this->db_plc0->query($sqltsa);
				$sa2="";
				echo "<td>";
				if($qtsa->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($qtsa->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vkode_surat']."</td><td>".$vd['statusPD']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
				echo "</td>";
				$sa2="";
				echo "<td>";
				if($qtsa->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($qtsa->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vkode_surat']."</td><td>".$vd['statusQA']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
				echo "</td>";
			}

			//Formula Skala Trial
			echo"<td>";
			if(isset($vr['ID']) and $vr['ID']!="" and $vr['ID']!=0){
				$sqlpo="select a.vkode_surat, if(a.iformula_apppd>=1,
					concat(case when a.iformula_apppd=1 then 'Reject' when a.iformula_apppd=2 then 'Approved' END, ' Oleh :' ,a.vformula_nip_apppd,' Pada ' ,a.tformula_apppd),' ') as app
					from plc2.plc2_upb_formula a 
					where a.iupb_id=".$vr['ID']." and a.lDeleted=0 order by a.ifor_id DESC";
				$ddetpo=$this->db_plc0->query($sqlpo);
				$sa2="";
				if($ddetpo->num_rows()>=1){
					$sa2="<table class='tablechild'>";
					foreach ($ddetpo->result_array() as $kd => $vd) {
						$sa2.="<tr><td>".$vd['vkode_surat']."</td><td>".$vd['app']."</td></tr>";
					}
					$sa2.="</table>";
				}
				echo $sa2;
			}
			echo"</td>";

			echo "</tr>";
		}
		?>
	</tbody>
</table>
</div>
</body>