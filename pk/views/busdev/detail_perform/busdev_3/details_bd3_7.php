
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
			<th colspan="6" style="text-align: left">KATEGORI OBAT</td>
		</tr>	
		<tr>
			<th>No</th>
			<th>No UPB</th>
			<th>Nama UPB</th> 
			<th>Kategori UPB</th>
			<th>Tanggal Applet</th>
			<th>Kategori Produk</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb_obat = 0; 
			if($rcount_obat>=1){
				foreach ($dataall_obat as $kall => $vall) {

					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$vall['vupb_nomor']."</td>";
					echo "<td>".$vall['vupb_nama']."</td>"; 
					echo "<td>".$vall['vkategori']."</td>";  
					echo "<td>".date('Y-m-d',strtotime($vall['dinput_applet']))."</td>"; 
					echo "<td>".$vall['vNama_Group']."</td>";
					echo "<tr>"; 
					$i++;
					$tot_upb_obat++;
				}
			} 
			?>
	</tbody>
	<thead>
		<tr>
			<th colspan="6" style="text-align: left">KATEGORI NON OBAT</td>
		</tr>	
		<tr>
			<th>No</th>
			<th>No UPB</th>
			<th>Nama UPB</th> 
			<th>Kategori UPB</th>
			<th>Tanggal NIE</th>
			<th>Kategori Produk</th>
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb_non = 0; 
			if($rcount_non>=1){
				foreach ($dataall_non as $kall => $vall) {

					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$vall['vupb_nomor']."</td>";
					echo "<td>".$vall['vupb_nama']."</td>"; 
					echo "<td>".$vall['vkategori']."</td>";  
					echo "<td>".date('Y-m-d',strtotime($vall['ttarget_noreg']))."</td>"; 
					echo "<td>".$vall['vNama_Group']."</td>";
					echo "<tr>"; 
					$i++;
					$tot_upb_non++;
				}
			} 
			?>
	</tbody>
</table>
<?php 
$jumupb=$tot_upb_non+$tot_upb_obat;
$disc_count=0;
if($jumupb>0){
	$disc_count=$dataall_disc['jum'];
}
$rata=0;
if($jumupb!=0 && $disc_count!=0){
	$rata=$jumupb/$disc_count;
}
?>
<br>
<label class="lbl_detail">Details Result</label>
<table class='tb_det'>
<thead>
		<tr>
			<th>Jumlah UPB Memenuhi Syarat (A)</th>
			<th>Jumlah Kategori Produk (B)</th>
			<th>A/B</th>
		<tr>
	</thead>
	<tbody>
<tr>
	<td><?php echo $jumupb ?></td>
	<td><?php echo $disc_count ?></td>
	<td><?php echo $rata ?></td>
<tr>
	</tbody>
</table>

<br>
<label class="lbl_detail">Realisasi NIE / APPLET produk baru Food suplement, OTC & kosmetik * (tidak termasuk ALKES)  : <?php echo $rata ?></label>