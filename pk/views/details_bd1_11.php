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
<label class="lbl_detail">Details UPB yang memenuhi syarat</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>Nomor UPB</th>
			<th>Nama UPB</th>
			<th>Tanggal NIE</th>
			<th>Tambahan Applet</th>
			<th>Tanggal Applet</th>
			<th>Tanggal HPR</th>
			<th>Selisih</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			if($row!="0"){
				foreach ($datarow as $kall => $vall) {
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$vall['vupb_nomor']."</td>";
					echo "<td>".$vall['vupb_nama']."</td>";
					echo "<td>".$vall['ttarget_noreg']."</td>";
					if($vall['itambahan_applet']==1){
						$ta="Yes";
						$tt=$vall['ttambahan'];
					}else{
						$ta="No";
						$tt="-";
					}
					echo "<td>".$ta."</td>";
					echo "<td>".$tt."</td>";
					echo "<td>".$vall['ttarget_hpr']."</td>";
					echo "<td>".$rselisih[$kall]."</td>";
					echo "<tr>";

					$i++;
				}
			}
			?>
	<tr>
		<td colspan="7" style="text-align:center">JUMLAH</td>
		<td><?php echo array_sum($rselisih); ?></td>
	</tr>
	</tbody>
</table>
<br>
<label class="lbl_detail">Details Result</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>Jumlah UPB (a)</th>
			<th>Jumlah Selisih Waktu (b)</th>
			<th>Hasil (b/a)</th>
		<tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $row; ?></td>
			<td><?php echo array_sum($rselisih); ?></td>
			<td><?php if (array_sum($rselisih)!=0){echo array_sum($rselisih)/$row;}else{echo "0";}; ?></td>
		<tr>
	</tbody>
</table>