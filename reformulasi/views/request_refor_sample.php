		<?php
			if (empty($rows)) {
			 		
			 	echo "Data permintaan sample tidak ditemukan. Silahkan membuat permintaan sample.";	
			}else{
			
		?>
				<table border="1" style="border-collapse: collapse" >
				<thead>
					<tr>
						<th>No</th>
						<th>No Permintaan</th>
						<th>Tanggal Permintaan</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>


		<?php 
				$no=1;
				foreach ($rows as $row ) {
			
		 ?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $row['vreq_nomor'] ?></td>
						<td><?php echo $row['trequest']?></td>
						<td><?php echo $row['setatus']; ?></td>
					</tr>
		<?php 
				$no++;
				}
		?>
				</tbody>
				</table>
		<?php 
			}
		 ?>
