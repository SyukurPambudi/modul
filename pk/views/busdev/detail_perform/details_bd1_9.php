
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
			<th>No UPB</th>
			<th>Nama UPB</th> 
			<!-- <th>Kode Obat</th>  -->
			<th>Kategory UPB</th>
			<th>Group Produk</th>
			<th>Tgl Applet</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb = 0; 
			foreach ($dataall as $kall => $vall) {
				echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$vall['vupb_nomor']."</td>";
				echo "<td>".$vall['vupb_nama']."</td>"; 
				//echo "<td>".$vall['vKode_obat']."</td>";   
				echo "<td>".$vall['vkategori']."</td>"; 
				echo "<td>".$vall['vNama_Group']."</td>";   
				echo "<td>".$vall['dinput_applet']."</td>";
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
			<th>Jumlah Group Produk (Kategory B)</th> 
		<tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo $t_pr ?></td> 
	<tr> 	
	</tbody>
</table>
<br>
<label class="lbl_detail">Jumlah Group Produk (Kategory B): <?php echo $t_pr; ?> Group Produk</label>