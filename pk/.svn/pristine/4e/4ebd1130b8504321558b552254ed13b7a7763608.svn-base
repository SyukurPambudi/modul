
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
<label class="lbl_detail">Details Semua Kartu Call! </label>
<table class='tb_det'>
	<thead>
 
		<tr>
			<th>No</th>
			<th>Messages</th>
			<th>Pejabat</th> 
			<th>Hasil</th> 
			<th>Target Kunjungan</th>
			<th>Tgl Kunjungan</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb = 0; 
			foreach ($dataall as $kall => $vall) {
				echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$vall['vMessages']."</td>";
				echo "<td>".$vall['vpejabat']."</td>"; 
				echo "<td>".$vall['thasil']."</td>";   
				echo "<td>".$vall['vtarget_kunjungan']."</td>";  
				echo "<td>".$vall['dCreate']."</td>";
				echo "<tr>";  
				$tot_upb++; 
				$i++;
				
			} 
			?>
		
	</tbody>
</table>

<br>
<label class="lbl_detail">Details Result</label>
<table class='tb_det'>
<thead>
		<tr>
			<th>Jumlah Call</th> 
			<th>Periode</th> 
			<th>Total Periode</th> 
		<tr>

	</thead>
	<tbody>
	<tr>
		<td><?php echo $tot_upb;
				if($selisih!=0){
					$ret = $tot_upb/$selisih;
				}else{
					$ret = 0;
				}

		?></td> 

		<td><?php echo $t1.' - '.$t2; ?></td> 
		<td><?php echo $selisih; ?></td> 

	<tr> 	
	</tbody>
</table>
<br>
<label class="lbl_detail">Rata-rata Kunjungan : <?php echo number_format( $ret, 2, '.', '' ); ?></label>