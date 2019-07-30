
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
</style> 
<label class="lbl_detail">Details Semua Data UPB! </label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal Kunjungan</th>
			<th>Target Kunjungan</th> 
			<th>Nama Pejabat</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb = 0;
			if($rcount>=1){
				foreach ($dataall as $kall => $vall) {
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$vall['tReceived']."</td>";
					echo "<td>".$vall['vtarget_kunjungan']."</td>"; 
					echo "<td>".$vall['vpejabat']."</td>";
					echo "<tr>"; 
					$i++;
					$tot_upb++;
				}
			} 
			?>
	</tbody>
</table>

<br>
<label class="lbl_detail">Details Result</label>
<table class='tb_det'>
<thead>
		<tr>
			<th>Jumlah Kunjungan (A)</th>
			<th>Tanggal Mulai Perhitungan</th>
			<th>Tanggal Akhir Perhitungan</th>
			<th>Jumlah Bulan Yang Dihitung (B)</th>
			<th>A/B</th>
		<tr>
	</thead>
	<tbody>
<tr>
<?php 
	$date1=date_create($datamaster['tgl1']);
	$date2=date_create($datamaster['tgl2']);

	$diff =  $date1->diff($date2);

    $months = $diff->y * 12 + $diff->m + $diff->d / 30;

    $selisih = (int) floor($months)+1;

    $rata=0;
    if($tot_upb>0){
    	$rata=$tot_upb/$selisih;
    }
    $rata = number_format( $rata, 2, '.', '' );
?>
	<td><?php echo $tot_upb ?></td>
	<td><?php echo $datamaster['tgl1']; ?></td>
	<td><?php echo $datamaster['tgl2']; ?></td>
	<td><?php echo $selisih; ?></td>
	<td><?php echo $rata; ?></td>
<tr>
	
		
	</tbody>
</table>

<br>
<label class="lbl_detail">Rata-rata kunjungan per bulan bertemu dengan KASIE dan KASUBDIT BPOM (bukan evaluator) : <?php echo $rata ?></label>