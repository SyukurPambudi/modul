<table border="1px" width="70%" style="border:1px;border-collapse: collapse;">
	<thead>
		<tr>
			<th>No</th>
			<th>No Request</th>
			<th>Jml <br> Request PD</th>
			<th>No PO</th>
			<th>Jumlah PO</th>
			<th>No Terima</th>
			<th>Jml <br>Terima Purch</th>
		</tr>
	</thead>	
	<tbody>
		<?php
			$no = 1;
			if(count($datas) > 0) {
				foreach($datas as $row) {
		?>

			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $row['vreq_nomor'] ?></td>
				<td align="right"><?php echo $row['jumlah_req'] ?></td>
				<td><?php echo $row['vpo_nomor'] ?></td>
				<td align="right"><?php echo $row['jumlah_po'] ?></td>
				<td><?php echo $row['vro_nomor'] ?></td>
				<td align="right"><?php echo $row['jml_terima_purc'] ?></td>
				
			</tr>
		<?php
			$no++;
			}
		}
		else {
			// jika tidak ada rows di detil
		?>
			<tr>
				<td colspan="7" align="center">Tidak ada History</td>
			</tr>
		<?php
			}
		?>
	</tbody>
	
</table>
<?php 

	//print_r($datas)
 ?>