
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
}
.tablelast {
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:10px;
	text-shadow: 1px 1px 0px #fff;
	background:#ffffff;
	margin:10px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
.tablelast th {
	padding:10px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
.tablelast th:first-child {
	padding-left:10px;
	border-left: 0;
}
.tablelast tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.tablelast tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.tablelast tr {
	text-align: left;
	padding-left:10px;
}
.tablelast td:first-child {
	text-align: center;
	padding-left:10px;
	border-left: 0;
}
.tablelast td {
	padding:5px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
#det_kategori{
	margin-top:10px;
	margin-left:10px;
	margin-right:10px;
}
#label, #label-mini{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	text-shadow: 2px 2px 1px #fff;
	background:#ffffff;
	margin:10px;
	
}
#label-mini{
	font-size:12px;
	font-weight: bold;
}
#label{
	font-size:14px;
	font-weight: bold;
}
.box {
	font-size: 12px;
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
	margin-top:10px;
	margin-left:20px;
	margin-right:20px;
	background: #e6e6e6;
}
.box-comment {
	font-size: 12px;
	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;
	border:1px solid #e0e0e0;
	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
	padding-top:10px;
	padding-left:10px;
	padding-right:10px;
	background: #ffffff;
}
#catatan_atasan{
	font-size: 12px;
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	text-shadow: 2px 2px 1px #fff;
	background:#ffffff;
	margin:10px;
}
input[type=checkbox]{
	transform:scale(0.8);
}
textarea{
	font-size: 12px;
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	text-shadow: 2px 2px 1px #fff;
	background:#ffffff;
}
</style>

<div style='page-break-after:always'>
<p id="label">HASIL AKHIR</p>
<table cellspacing='0' width="98%" class="tablelast"> <!-- cellspacing='0' is important, must stay -->

	<!-- Table Header -->
	<thead>
		<tr>
			<th>Aspek Penilaian</th>
			<th>Bobot</th>
			<th>Nilai Akhir Tiap Aspek</th>
			<th>NILAI X BOBOT</th>
		<tr>
	</thead>
	<!-- Table Header -->

	<!-- Table Body -->
	<tbody>
		<?php
		$this->database = $this->load->database('pk', true);
		$qdkat="select * from pk.pk_kategori kat where kat.ldeleted=0";
		$dkat=$this->database->query($qdkat)->result_array();
		$n=array();
		foreach ($dkat as $k => $valo) {
			$s=array();
			$bobot=$valo["bobot"];
			$idkat=$valo["ikategori_id"];
            if($idkat == 4){
			$sql="select ni.poin_sepakat_atasan as atas, pa.bobot as bo from pk.pk_nilai ni
					inner join pk.pk_parameter_po pa on ni.iparameter_id=pa.iparameter_id
					where ni.idmaster_id=".$id." and ni.ikategori_id=".$idkat." and ni.ldeleted=0 and pa.ldeleted=0";                
            }else {
			$sql="select ni.poin_sepakat_atasan as atas, pa.bobot as bo from pk.pk_nilai ni
					inner join pk.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
					where ni.idmaster_id=".$id." and ni.ikategori_id=".$idkat." and ni.ldeleted=0 and pa.ldeleted=0";                
            }

			$jml=$this->database->query($sql)->result_array();
			foreach ($jml as $qj => $vj) {
				$s[]=number_format(($vj['atas']*$vj['bo']),2);
			}
			$j=array_sum($s);
			$n[]=number_format(floatval($bobot)*floatval($j),2);
			echo '<tr>';
			echo '<td>'.$valo["kategori"].'</td>';
			$bobo=$bobot*100;
			echo '<td align="center">'.$bobo.'%</td>';
			echo '<td align="center">'.$j.'</td>';
			echo '<td align="center">'.number_format(floatval($bobot)*floatval($j),2).'</td>';
			echo '</tr>';
		}
		$n_final=array_sum($n);

		$sql="select * from pk.pk_kategori_nilai ni where ni.ldeleted=0 order by ni.iNilai1 ASC";
		$q=$this->database->query($sql);
		$dt=$q->result_array();
		$rows=$q->num_rows();
		$iNilai=array();
		$vKeterangan=array();
		$n_final_kat='';
		$n='';
		foreach ($dt as $ke) {
			$iNilai[]=$ke["iNilai1"]; // Nilai Bataas Bawah
			$vKeterangan[]=$ke["vKeterangan"]; // Keterangan Nilai
		}
		for ($i=0; $i < $rows ; $i++) { 
			if($n_final>=$iNilai[$i]){
				$n=$iNilai[$i];
				$n_final_kat=$vKeterangan[$i];
			}
		}
		?>
		<tr>
		<td colspan='3' align='right'>JUMLAH</td>
		<td align='center'><?php echo $n_final; ?></td>
		</tr>
		<tr>
		<td colspan='3' align='right'>KATEGORI PENILAIAN</td>
		<td align='center'><?php echo $n_final_kat; ?></td>
		</tr>
	</tbody>
	<!-- Table Body -->

</table>
	<div id="det_kategori">
	<?php
	$sql="select * from pk.pk_kategori_nilai ni where ni.ldeleted=0 order by ni.iNilai1 DESC";
	$q=$this->database->query($sql); ?>
	<p style="font-size:10px;margin-top:5px;font-weight:bold;margin-bottom:0px;">KETERANGAN PENILAIAN :</p>
		<table style="font-size:10px">
	<?php
	foreach ($q->result_array() as $key) {
		echo '<tr>';
		echo '<td>'.$key['vKeterangan']."</td><td>:</td><td>".$key['iNilai1']." - ".$key['iNilai2'].'</td>';
		echo '</tr>';
	}
	$qcat="select * from pk.pk_master ma where ma.idmaster_id=".$id;
	$dcat=$this->database->query($qcat)->row_array();?>
	</table>
	</div>
		<div id="catatan_atasan">
			<p style="font-weight:bold;margin-top:5px;">CATATAN UNTUK KARYAWAN:</p>
			<p>Komentar/Evaluasi Umum</p><p><?php echo $dcat["tcatatan_umum_pengaju"] ?></p>
			<p>Rencana untuk periode yang akan datang</p><p><?php echo $dcat["tcatatan_rencana_pengaju"] ?></p>
		

		<p style="font-weight:bold">CATATAN UNTUK PIMPINAN:</p>
		<p>Evaluasi umum</p><p><?php echo  $dcat["tcatatan_umum_atasan"] ?></p>
		<p>Saran/Perbaikan</p><p><?php echo $dcat["tcatatan_saran_atasan"] ?></p>
		<p>Pelatihan yang diusulkan</p><p><?php echo $dcat["tcatatan_pelatihan_atasan"] ?></p>
		</div>
		<div id="catatan_atasan">
		<table width=100% id="catatan_atasan" style="margin:0px">
			<tr>
				<td rowspan=2 style="vertical-align:top;border:1px solid #c5dbec; width:20%">
					<p style="font-weight:bold">Rencana Karir</p><br>
					<?php $n=array("1"=>"Demosi","2"=>"Rotasi","3"=>"Mutasi", "4"=>"Promosi", "5"=>"Belum dapat ditentukan sekarang");
					foreach ($n as $k => $v) {
						$select=$dcat['ikarir']==$k?'checked="checked"':'';
						echo '<input type="radio" name="karir" value="'.$k.'" '.$select.'> '.$v.' <br>';
					}
					?>
				</td>
				<td style="vertical-align:top;border:1px solid #c5dbec;">
					<p style="font-weight:bold">Ke</p>
					<p style="font-size:10px;margin-top:5px;margin-left:10px;font-weight: bold;">Posisi:
						<?php 
						if(isset($dcat['iPostId'])){
							if($dcat['iPostId']!='' or $dcat['iPostId']!=NULL){
								$que = "select * from hrd.position pos where pos.lDeleted=0 and pos.iPostId=".$dcat['iPostId'];
								$dt2=$this->dbset->query($que)->row_array();
								 echo $dt2['vDescription']; 
							}
						}?>
					</p>
					<p style="font-size:10px;margin-top:5px;margin-left:10px;font-weight: bold;">Departemen:
					<?php 
					if(isset($dcat['iPostId'])){
						if($dcat['iPostId']!='' or $dcat['iPostId']!=NULL){
							$que1 = "select * from hrd.msdepartement dep where dep.lDeleted=0 and dep.iDeptID=".$dcat['iDeptId'];
							$dt1 = $this->dbset->query($que1)->row_array();
								echo $dt1['vDescription']; 
						}
					}?>	
					</p><br>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;border:1px solid #c5dbec;">
					<p style="font-weight:bold">Pertimbangan</p>
					<textarea name="tpertimbangan" id="tpertimbangan" class="" style="width:500px"><?php echo $dcat['tPertimbangan']?></textarea>
				</td>
			</tr>
		</table>
		<p style="padding-left:10px;">Tandatangan</p>
		</div>
<table width="100%" style="padding-left:10px;text-align:left" id="catatan_atasan">
	<tr>
		<td width="30%">Karyawan,</td>
		<td width="30%">Atasan Langsung,</td>
		<td width="30%">Atasan tidak langsung,</td>
	</tr>
	<tr height="100px" style="vertical-align:bottom;">
		<td width="30%" style="text-align:center"><br><br><br><br></td>
		<td width="30%" style="text-align:center"><br><br><br><br></td>
		<td width="30%" style="text-align:center"><br><br><br><br></td>
	</tr>
	<tr>
		<td width="30%"><div style="border-top:1px solid black; width:150px;">(Nama Jelas & Tanggal)</div></td>
		<td width="30%"><div style="border-top:1px solid black; width:150px;">(Nama Jelas & Tanggal)</div></td>
		<td width="30%"><div style="border-top:1px solid black; width:150px;">(Nama Jelas & Tanggal)</div></td>
	</tr>
</table>