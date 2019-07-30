<?php 
	$be = array('1'=>'BE','2'=>'Non BE'); 
?>
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
<label class="lbl_detail">Details Semua Data UPB Obat </label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>No UPB</th>
			<th>Nama UPB</th> 
			<!-- <th>Kode Obat</th>  -->
			<th>Kategory</th>
			
			<th>Tanggal Applet</th> 
			<th>Tanggal Registrasi</th> 
			<th>Selisih (Bulan)</th> 
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb = 0; 
			$selisih = 0;
			foreach ($dataall as $kall => $vall) {
				echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$vall['vupb_nomor']."</td>";
				echo "<td>".$vall['vupb_nama']."</td>"; 
				//echo "<td>".$vall['vKode_obat']."</td>"; 

				echo "<td>".$vall['vkategori']."</td>";   


				echo "<td>".$vall['dinput_applet']."</td>"; 
				echo "<td>".$vall['tregistrasi']."</td>";  

				$timeEnd = strtotime($vall['dinput_applet']);
				$timeStart = strtotime($vall['tregistrasi']);
				$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
				$time +=  (date("m",$timeEnd)-date("m",$timeStart));   
				if($time <=0){
					$durasi = -1*($time); 
				}else{
					$durasi = $time;
				}
				$selisih += $durasi;

				echo "<td>".$durasi."</td>";   
				echo "<tr>"; 


				

				$tot_upb++;
				$i++;
				
			} 
			?>
		
	</tbody>
</table>


<label class="lbl_detail">Details Semua Data UPB NON Obat </label>
<table class='tb_det'>
	<thead>
		<tr>
			<th>No</th>
			<th>No UPB</th>
			<th>Nama UPB</th> 
			<!-- <th>Kode Obat</th> -->
 			<th>Kategory</th>
			<th>Tanggal NIE</th> 
			<th>Tanggal Registrasi</th> 
			<th>Selisih (Bulan)</th> 
		<tr>
	</thead>
	<tbody>
		
			<?php
			$i=1;
			$tot_upb2 = 0; 
			$selisih2 = 0;
			foreach ($dataall2 as $kall => $vall) {
				echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$vall['vupb_nomor']."</td>";
				echo "<td>".$vall['vupb_nama']."</td>"; 
				//echo "<td>".$vall['vKode_obat']."</td>"; 

				echo "<td>".$vall['vkategori']."</td>";  
 
				 
				echo "<td>".$vall['ttarget_noreg']."</td>"; 
				echo "<td>".$vall['tregistrasi']."</td>";  

				$timeEnd = strtotime($vall['ttarget_noreg']);
				$timeStart = strtotime($vall['tregistrasi']);
				$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
				$time +=  (date("m",$timeEnd)-date("m",$timeStart));      
				if($time <=0){
					$durasi = -1*($time); 
				}else{
					$durasi = $time;
				}
				$selisih2 += $durasi;

				echo "<td>".$durasi."</td>";   
				echo "<tr>"; 
 
				$tot_upb2++;
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
			<th>Total Selisih Kategori Obat</th> 
			<th>Total Selisih NON Kategori Obat</th>
			<th>Jumlah UPB Kategori Obat</th>
			<th>Jumlah UPB Kategori NON  Obat</th>
			
		<tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo $selisih ?></td> 
		<td><?php echo $selisih2 ?></td>
		<td><?php echo $tot_upb ?></td>
		<td><?php echo $tot_upb2 ?></td>
		

		<?php 
			$upb = $tot_upb + $tot_upb2;
			$t_sel = $selisih + $selisih2;

			if($upb!=0){
				$rat = $t_sel/$upb;
			}else{
				$rat = 0;
			} 
		?>
	<tr> 	
	</tbody>
</table>
<br>
<label class="lbl_detail">Rata - rata (Total Selisih (Obat & Non Obat) / Jumlah UBP (Obat & Non Obat)) : <?php echo number_format( $rat, 2, '.', '' ); ?> Bulan</label>
