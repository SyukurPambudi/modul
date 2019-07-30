<style type="text/css">
	th{
		background-color: #87CEFA;
	}
</style>
<div style='width:100%;text-align:center;'>
	<h1>Report Setting Praregistrasi UPB</h1>
	
		<table  border="1" align="center">
			<thead >
				<tr>
					<th>No</th>
					<th>No UPB</th>
					<th>Generik</th>
					<th>Usulan Nama Produk</th>
					<th>Kategori</th>
					<th>Tgl Prioritas</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no=1;
					foreach($datanya as $row) {
						$no_upb = $row['vupb_nomor'];
						$generik = $row['vgenerik'];
						$usulan = $row['vupb_nama'];
						$kategori = $row['kategupb'];
						$tglprioritas=date('Y-m-d',strtotime($row['tglprioritas']));
						if(($row['tglprioritas']==null) or ($row['tglprioritas']=='0000-00-00') or ($row['tglprioritas']=='1970-01-01')){
							$tglprioritas='-';
						}
						$status = $row['statusprareg'];
					 ?>
				<tr>
					<td width="15px"><?php echo $no ?></td>
					<td width="50px"><?php echo $no_upb ?></td>
					<td width="300px"><?php echo $generik ?></td>
					<td width="200px"><?php echo $usulan ?></td>
					<td width="30px"><?php echo $kategori?></td>
					<td width="100px"><?php echo $tglprioritas ?></td>
					<td width="30px"><?php echo $status ?></td>
				</tr>
				
			<?php 
				$no++;
				}		
			?>
			</tbody>
		</table>
	
</div>

