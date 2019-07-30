<div id="table preview" style="overflow:auto;">
	<style>
		table.preview a:link {
			color: #666;
			font-weight: bold;
			text-decoration:none;
		}
		table.preview a:visited {
			color: #999999;
			font-weight:bold;
			text-decoration:none;
		}
		table.preview a:active,
		table.preview a:hover {
			color: #bd5a35;
			text-decoration:underline;
		}
		table.preview {
			font-family:Arial, Helvetica, sans-serif;
			color:#666;
			font-size:12px;
			text-shadow: 1px 1px 0px #fff;
			background:#eaebec;
			margin:20px;
			border:#ccc 1px solid;

			-moz-border-radius:3px;
			-webkit-border-radius:3px;
			border-radius:3px;

			-moz-box-shadow: 0 1px 2px #d1d1d1;
			-webkit-box-shadow: 0 1px 2px #d1d1d1;
			box-shadow: 0 1px 2px #d1d1d1;
		}
		table.preview th {
			padding:21px 5px 5px 25px;
			border-top:1px solid #fafafa;
			border-bottom:1px solid #e0e0e0;

			background: #ededed;
			background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
			background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
		}
		table.preview th:first-child {
			text-align: left;
			padding-left:20px;
		}
		table.preview tr:first-child th:first-child {
			-moz-border-radius-topleft:3px;
			-webkit-border-top-left-radius:3px;
			border-top-left-radius:3px;
		}
		table.preview tr:first-child th:last-child {
			-moz-border-radius-topright:3px;
			-webkit-border-top-right-radius:3px;
			border-top-right-radius:3px;
		}
		table.preview tr {
			text-align: center;
			padding-left:20px;
		}
		tabl.preview td:first-child {
			text-align: left;
			padding-left:20px;
			border-left: 0;
		}
		table.preview td {
			padding:5px;
			border-top: 1px solid #ffffff;
			border-bottom:1px solid #e0e0e0;
			border-left: 1px solid #e0e0e0;

			background: #fafafa;
			background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
			background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
		}
		table.preview tr.even td {
			background: #f6f6f6;
			background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
			background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
		}
		table.preview tr:last-child td {
			border-bottom:0;
		}
		table.preview tr:last-child td:first-child {
			-moz-border-radius-bottomleft:3px;
			-webkit-border-bottom-left-radius:3px;
			border-bottom-left-radius:3px;
		}
		table.preview tr:last-child td:last-child {
			-moz-border-radius-bottomright:3px;
			-webkit-border-bottom-right-radius:3px;
			border-bottom-right-radius:3px;
		}
		table.preview tr:hover td {
			background: #f2f2f2;
			background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
			background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
		}
	</style>
	<table cellspacing="0" class="preview">

			<!-- Table Header -->
			<thead>
				<tr>
					<th rowspan="2">No UPD</th>
					<th rowspan="2">Nama Usulan</th>
					<th rowspan="2">Pengusul</th>
					<th rowspan="2">Setting Product</th>
					<th rowspan="2">Pembagian Product</th>
					<th rowspan="2">Pembagian Product Staff</th>
					<th rowspan="2">Review Dokumen</th>
					<th rowspan="2">Upload Dokumen</th>
					<th colspan="4">Cek Kelengkapan</th>
					<th>Pembuatan Dossier</th>
					<th>Serah Terima Dossier</th>
					<th>Registrasi</th>
				</tr>
					<th>I</th>
					<th>II</th>
					<th>III</th>
					<th>IV</th>
				<tr>
				</tr>
			</thead>
			<!-- Table Header -->
				<?php
				foreach ($datupd as $kupd => $dupd) {
				?>
				<tr>
					<td><?php echo $dupd['vUpd_no']?></td>
					<td><?php echo $dupd['vNama_usulan']?></td>
					<td><?php 
					$sql="select * from hrd.employee em where em.cNip='".$dupd['cNip_pengusul']."'";
					$dts=$this->db_plc0->query($sql)->row_array();
					echo $dts['cNip'].'-'.$dts['vName'];
					?></td>
					<td>
						<?php
						$sqlsetting="SELECT IF(prio.iApprove_prio!=0,concat(if(prio.iApprove_prio=2,'Approved by ','Reject By '),(select em.vName from hrd.employee em where em.cNip=prio.cApprove)), '') as approval FROM dossier.dossier_prioritas prio 
							inner join dossier.dossier_prioritas_detail det on prio.idossier_prioritas_id=det.idossier_prioritas_id
							WHERE prio.lDeleted = 0 and det.idossier_upd_id=".$dupd['idossier_upd_id'];
						$dtsetting=$this->db_plc0->query($sqlsetting)->row_array();
						echo $dtsetting['approval'];
						?>
					</td>
					<td>
						<?php
						$sqlsetting="SELECT if(dossier_upd.iappad_pembagian!=0,concat (if(dossier_upd.iappad_pembagian=2,'Approved By ','Reject By '), (select em.vName from hrd.employee em where em.cNip=dossier_upd.cappad_pembagian)),if(dossier_upd.iSubmit_bagi_upd=0,'Draft-Need Submited','Waiting Approval')) as statuspembagian
							FROM dossier.dossier_upd
							INNER JOIN dossier.dossier_prioritas_detail ON dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id
							INNER JOIN dossier.dossier_prioritas ON dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id
							LEFT JOIN dossier.dossier_jenis_dok ON dossier_jenis_dok.ijenis_dok_id=dossier_upd.iSediaan
							WHERE dossier_upd.lDeleted =  0
							AND dossier_upd.ihold =  0
							AND dossier_upd.idossier_upd_id in (
							 select a.idossier_upd_id 
							 from dossier.dossier_upd a 
							 join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
							 join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
							 where c.iApprove_prio= 2
							 and a.lDeleted = 0
							 and b.lDeleted = 0
							 and c.lDeleted = 0
							 group by a.idossier_upd_id
							 ) 
							and dossier_upd.idossier_upd_id=".$dupd['idossier_upd_id'];
						$dtsetting=$this->db_plc0->query($sqlsetting)->row_array();
						echo $dtsetting['statuspembagian'];
						?>
					</td>
				<tr>
				<?php 
				}
				?>
			<!-- Table Body -->
			<tbody>
		</tbody>
			<!-- Table Body -->

	</table>
</div>