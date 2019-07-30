<?php 

?>

<script type="text/javascript">

</script>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<div class="v3_table_soi_fg_file_tentative">
	<table class="hover_table" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">File Upload SOI Fg Tentative</span></th>
		</tr>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No.</th>
			<th style="border: 1px solid #dddddd;">Nama File</th>
			<th style="border: 1px solid #dddddd;">Keterangan</th>		
			<th style="border: 1px solid #dddddd;">Action</th>		
		</tr>
		</thead>
		<tbody>
			<?php
				$i = 0;
				if(!empty($rows)) {
					foreach($rows as $row) {
					$i++;				
			?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
						<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span class="bk_primer_kemasan_num"><?php echo $i ?></span>
						</td>	
						<td style="border: 1px solid #dddddd;">
							<?php echo $row['vFilename']; ?>
						</td>
						<td style="border: 1px solid #dddddd;">
							<?php echo $row['tKeterangan']; ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 100px;">
							<?php 
								$filename 	= $row['vFilename_generate'];
								$fileid  	= $row['filename'];
								$pk_id 		= $row['idHeader_File'];
								$filepath 	= $row['filepath'];

								if (file_exists('./'.$filepath.'/'.$pk_id.'/'.$filename)){
									$link = base_url().'processor/plc/v3/spesifikasi/soi/fg?action=download&id='.$pk_id.'&path='.$fileid.'&file='.$filename;
									$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">[ Download ]</a>';
									echo $linknya;
								} else {
									echo "File Not Found";
								}
							?>
						</td>		
					</tr>
			<?php
					}
				} else {
					?>
						<tr>
							<td colspan="4">Tidak Ada Data</td>
						</tr>
					<?php
				}
			?>
		</tbody>
	</table>
	<br>
</div>