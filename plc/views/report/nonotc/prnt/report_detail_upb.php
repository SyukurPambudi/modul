<body style="font-family: serif; font-size: 14px;">
<style>

.table1 {
    color: #444;
    border-collapse: collapse;
}
 
.table1 tr th{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}
 
.table1, th, td {
    text-align: left;
}

.table1 tr:nth-child(even) {
    background-color: #f2f5f7;
}
.table2 {
    color: #444;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #f2f5f7;
    background-color: #ffffff;
}
 
.table2 tr th tbody{
    background: #35A9DB;
    color: #fff;
    font-weight: normal;
}
 
.table2, th, td,tbody {
    padding: 10px 5px;
    text-align: left;
}
.table2 tbody tr:nth-child(even) {
    background-color: #f2f5f7;
}
</style>
<div style='width:100%;'>
<div width='100%' align="center" style="font-size: 16px;"><b>Report Detail Usulan Produk Baru</b></br></div>
<table class="table1" width="100%" >
		<?php foreach ($rl as $kr => $vr) {
			echo "<tr>";
			echo "<td>".$vr."</td>";
			echo "<td width='2px'>:</td>";
			echo "<td>".$row[$kr]."</td>";
			echo "</tr>";
		}
			echo "<tr>";
			echo "<td>Pengusul</td>";
			echo "<td width='2px'>:</td>";
			echo "<td>".$row['cnip']." | ".$row['vName']." | ".$row['vteamm']."</td>";
			echo "</tr>";
		foreach ($r2 as $kr => $vr) {
			echo "<tr>";
			echo "<td>".$vr."</td>";
			echo "<td width='2px'>:</td>";
			echo "<td>".$row[$kr]."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td valign='top'>Dok Bahan Baku</td>";
		echo "<td width='2px' valign='top'>:</td>";
		echo "<td>";
		echo "<table class='table2' width='100%'>";?>
		<thead><tr><td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color: #ffffff'>DOKUMEN</td></tr></thead>
		<?php
		echo "<tbody>";
		foreach ($txtDocBB as $kbb => $vbb) {
			echo "<tr>";
			echo "<td>".$vbb['vdokumen']."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top'>Dok Standar Mutu</td>";
		echo "<td width='2px' valign='top'>:</td>";
		echo "<td>";
		echo "<table class='table2' width='100%'>";?>
		<thead><tr><td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color: #ffffff'>DOKUMEN</td></tr></thead>
		<?php
		echo "<tbody>";
		foreach ($txtDocSM as $kbb => $vbb) {
			echo "<tr>";
			echo "<td>".$vbb['vdokumen']."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top'>Komposisi</td>";
		echo "<td width='2px' valign='top'>:</td>";
		echo "<td>";
		echo "<table class='table2' style='border : 1px solid black;border-collapse: none;' width='100%'>";?>
		<thead>
			<tr>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Bahan</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Kekuatan</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Satuan</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Keterangan</td>
			</tr>
		</thead>
		<?php
		echo "<tbody>";
		foreach ($datakom as $kbb => $vbb) {
			echo "<tr>";
			echo "<td>".$vbb['vnama']."</td>";
			echo "<td>".$vbb['ijumlah']."</td>";
			echo "<td>".$vbb['vsatuan']."</td>";
			echo "<td>".$vbb['vketerangan']."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top'>Marketing Forecast</td>";
		echo "<td width='2px' valign='top'>:</td>";
		echo "<td>";
		echo "<table class='table2' style='border : 1px solid black;border-collapse: none;' width='100%'>";?>
		<thead>
			<tr>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>No</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Tahun</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Jumlah</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>Marketing Forecast</td>
				<td style='background-color:#2e6e9e;text-align: center;font-weight: bold;color:#ffffff;'>%</td>
			</tr>
		</thead>
		<?php
		echo "<tbody>";
		?>
		<tr>
			<td>1</td>
			<td><?php echo !empty($forecast['r1']['vyear']) ? $forecast['r1']['vyear'] : '' ?></td>
			<td><?php echo !empty($forecast['r1']['vunit']) ? $forecast['r1']['vunit'] : '' ?></td>
			<td><?php echo !empty($forecast['r1']['vforecast']) ? $forecast['r1']['vforecast'] : '' ?></td>
			<td><?php echo !empty($forecast['r1']['vincrement']) ? $forecast['r1']['vincrement'] : '' ?></td>
		</tr>
		<tr>
			<td>2</td>
			<td><?php echo !empty($forecast['r2']['vyear']) ? $forecast['r2']['vyear'] : '' ?></td>
			<td><?php echo !empty($forecast['r2']['vunit']) ? $forecast['r2']['vunit'] : '' ?></td>
			<td><?php echo !empty($forecast['r2']['vforecast']) ? $forecast['r2']['vforecast'] : '' ?></td>
			<td><?php echo !empty($forecast['r2']['vincrement']) ? $forecast['r2']['vincrement'] : '' ?></td>
		</tr>
		<tr>
			<td>3</td>
			<td><?php echo !empty($forecast['r3']['vyear']) ? $forecast['r3']['vyear'] : '' ?></td>
			<td><?php echo !empty($forecast['r3']['vunit']) ? $forecast['r3']['vunit'] : '' ?></td>
			<td><?php echo !empty($forecast['r3']['vforecast']) ? $forecast['r3']['vforecast'] : '' ?></td>
			<td><?php echo !empty($forecast['r3']['vincrement']) ? $forecast['r3']['vincrement'] : '' ?></td>
		</tr>
		<?php
		echo "</tbody>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Pengusul</td>";
		echo "<td width='2px'>:</td>";
		echo "<td>".$row['cnip']." | ".$row['vName']." | ".$row['vteamm']."</td>";
		echo "</tr>";
		?>
</table>
</div>
</body>