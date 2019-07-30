<?php echo $sql; ?>
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
<label class="lbl_detail">Daftar UPB sudah setting prioritas 4 semester lalu dan sudah di approve (<?php echo $jrow1['jml'] ?> UPB)</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>NOMOR UPB</th>
			<th>Nama UPB</th>
			<th>Info Hak Paten</th>
			<th>Tahun</th>
			<th>Semester</th>
			<th>Kategori</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			if($row1=="1"){
				foreach ($dt1 as $kall => $vall) {
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$vall['vupb_nomor']."</td>";
					echo "<td>".$vall['vupb_nama']."</td>";
					echo "<td>".$vall['tinfo_paten']."</td>";
					echo "<td>".$vall['iyear']."</td>";
					echo "<td>".$vall['imonth']."</td>";
					echo "<td>".$vall['kategori']."</td>";
					echo "<tr>";

					$i++;
				}
			}
			?>
		
	</tbody>
</table>
<br>
<label class="lbl_detail">Daftar UPB Kategori A sudah setting prioritas 4 semester lalu dan sudah di approve (<?php echo $jrow2['jml'] ?> UPB)</label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>NOMOR UPB</th>
			<th>Nama UPB</th>
			<th>Info Hak Paten</th>
			<th>Tahun</th>
			<th>Semester</th>
			<th>Kategori</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			if($row2=="1"){
				foreach ($dt2 as $kall2 => $vall2) {
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$vall2['vupb_nomor']."</td>";
					echo "<td>".$vall2['vupb_nama']."</td>";
					echo "<td>".$vall2['tinfo_paten']."</td>";
					echo "<td>".$vall2['iyear']."</td>";
					echo "<td>".$vall2['imonth']."</td>";
					echo "<td>".$vall2['kategori']."</td>";
					echo "<tr>";

					$i++;
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
			<th>UPB ALL</th>
			<th>UPB Kategori A</th>
			<th>Hasil Persentase</th>
		<tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $jrow1['jml'] ?></td>
			<td><?php echo $jrow2['jml'] ?></td>
			<td><?php echo $jrow2['jml']/$jrow1['jml']*100 ?> %</td>
		<tr>
	</tbody>
</table>
