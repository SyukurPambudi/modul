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


<label class="lbl_detail">Details Absensi</label>

<table>
	<tr>
		<td>
			<table class='tb_det'>
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Jam Masuk</th>
					<tr>
				</thead>
				<tbody>
						<?php
						$i=1;
							foreach ($data1 as $data) {
								echo "<tr>";
								echo "<td>".$i."</td>";
								echo "<td>".$data['dAbsensi']."</td>";
								echo "<td>".$data['cin']."</td>";
								$i++;
							}
						?>
					
				</tbody>
				<tfooter>
					<tr>
					<td colspan="2">Jumlah </td>
						<td><?php echo $data3 ?> </td>
					</tr>
				</tfooter>
			</table>

		</td>
		<td align="Left" valign="top">
			<br><br>
			<label class="lbl_detail">Keterangan : </label><br>
			<label class="lbl_detail">Total Jumlah Hadir Telat dalam 1 Periode : <?php echo $data3; ?></label><br>
		</td>
	</tr>
</table>



		



