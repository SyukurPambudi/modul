<style>
.lbl_detail{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#ffffff;
	margin:10px;
	font-weight: bold;
}
.tb_det {
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
.tb_det th {
	padding:10px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
.tb_det th:first-child {
	padding-left:10px;
	border-left: 0;
}
.tb_det tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
.tb_det tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
.tb_det tr {
	text-align: left;
	padding-left:10px;
}
.tb_det td:first-child {
	text-align: center;
	padding-left:10px;
	border-left: 0;
}
.tb_det td {
	padding:5px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;
	text-align: center;
}
<?php 
$bulan = array(0=>'January',1=>'February',2=>'Maret',3=>'April',4=>'May',5=>'Juni',6=>'Juli',7=>'Agustus',8=>'September',9=>'Oktober',10=>'November',11=>'Desember');
?>
</style>


<label class="lbl_detail">Details Absensi</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>Bulan</th>
			<th>Jumlah</th>
			<th>Nilai</th>
		<tr>
	</thead>
	<tbody>
			<?php
			$i=1;
			$tot = 0;
			$k = 0;
				foreach ($data2 as $data) {
					if($data['piket']>=10){
						$tot += 100;
						$n = 100;
					}else if($data['piket']>=9){
						$tot += 80;
						$n = 80;
					}else if($data['piket']>=8){
						$tot += 60;
						$n = 60;
					}else if($data['piket']>=7){
						$tot += 40;
						$n = 40;
					}else{
						$tot += 20;
						$n = 20;
					}

					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$bulan[$data['bln']-1]."</td>";
					echo "<td>".$data['piket']."</td>";
					echo "<td>".$n."</td>";
					echo "</tr>";

					
					?>
					<tr>
						<td>Detail <td>
						<td colspan="3">

							<table>
								<tr bgcolor="#D3D3D3">
									<th>No</th>
									<th>Tanggal</th>
									<th>Jam Keluar</th>
								</tr>
								<?php

								$this->dbset = $this->load->database('hrd', true);

								if($area==5){
									$cout ="18:00:00";
								}else{
									$cout ="17:00:00";
								}

								$sql = "SELECT * FROM hrd.msabsen a WHERE a.cNip='".$nippemohon."' 
										AND a.cout>'".$cout."' AND a.`cout` != ':  :' AND a.`cout` != '' AND a.dAbsensi BETWEEN '".$tgl1."' AND '".$tgl2."' AND MONTH(a.dAbsensi) = ".$data['bln'];
								$dt = $this->dbset->query($sql)->result_array();
								$xyz = 1;
								foreach ($dt as $key) {
									?>
										<tr>
											<td><?php echo $xyz ?></td>
											<td><?php echo $key['dAbsensi'] ?></td>
											<td><?php echo $key['cout'] ?></td>
										<tr>
									<?php
									$xyz++;
								}
								?>

							</table>
						</td>						
					</tr>
					<?php
					$k += $data['piket'];
					$i++;
				}
			?>
		
	</tbody>
	<tfooter>
		<tr>
		<td colspan="3">Total Nilai</td>
			<td><?php echo $tot ?> </td>
		</tr>
	</tfooter>
</table>
<label class="lbl_detail">Total Nilai : <?php echo $tot ?></label><br>
<label class="lbl_detail">Rata - Rata Nilai / Semester : <?php echo number_format( $tot/6, 2, '.', '' ); ?></label>
		



