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
<label class="lbl_detail">UPB Memenuhi Syarat ( Kategori A) </label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>NOMOR UPB</th>
			<th>Nama UPB</th>
			<th>Info Hak Paten</th>
			<th>Tahun</th>
			<th>Semester</th>
			<th>Tgl Prareg</th>
		<tr>
	</thead>
	<tbody>

		
			<?php
			$i=1;
			$c=0;
			$sel=0;
				foreach ($datas as $data) {
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$data['vupb_nomor']."</td>";
					echo "<td>".$data['vupb_nama']."</td>";
					echo "<td>".$data['tinfo_paten']."</td>";
					echo "<td>".$data['iyear']."</td>";
					echo "<td>".$data['imonth']."</td>";
					echo "<td>".$data['ttarget_prareg']."</td>";
					echo "<tr>";

					$i++;
					$c++;
				}
			?>
		
	</tbody>
</table>
<?php 
	if ($c<>0) {
		$pembilang = 0;	
		$penyebut = $c;
		$rat=number_format(( ($pembilang/$penyebut) / 30),2);
	}else{
		$pembilang =0; 	
		$penyebut = 0;
		$rat=0;
	}
?>

<label class="lbl_detail">Jumlah UPB Memenuhi Syarat : <?php echo $penyebut ?> UPB</label><br>
