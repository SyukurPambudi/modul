<?php
if(!empty($rows)) {
}	

?>


<table class="hover_table" id="histori_stabilita_terbalik" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="9" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">HISTORI STABILITA TERBALIK</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;" >No</th>
		<th style="border: 1px solid #dddddd;">Real Time</th>
		<th style="border: 1px solid #dddddd;">Accelerated</th>
		<th style="border: 1px solid #dddddd;">Status Stabilita</th>
		<th style="border: 1px solid #dddddd;">Status Approve</th>	
		<th style="border: 1px solid #dddddd;">Apporval</th>
		<th style="border: 1px solid #dddddd;">Bulan Ke</th>
		<th style="border: 1px solid #dddddd;">Remark</th>	
		<th style="border: 1px solid #dddddd;">Tgl Approve</th>	
	</tr>
	</thead>
	<tbody>
		<?php
			$i = 1;
			$datstatus=array(0=>'Tidak Memenuhi Sayarat',1=>'Memenuhi Syarat');
			$datIApp=array(1=>'Reject', 2=>'Approved');
			foreach($rows as $row) {	
	
		?>

			<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $i ?>
					</td>		
					<td style="border: 1px solid #dddddd;">
						<?php echo $row['vRealtime']; ?> 
					</td>	
					<td style="border: 1px solid #dddddd;">
						<?php echo $row['vAccelerated'];?> 
					</td>
					<td style="border: 1px solid #dddddd;">
						<?php echo $datstatus[$row['iSucced']];?>					
					</td>	
					<td style="border: 1px solid #dddddd;">
						<?php echo $datIApp[$row['iApprove']];?>					
					</td>
					<td style="border: 1px solid #dddddd;">
						<?php echo $row['nip']."-".$row['vName'];?>					
					</td>
					<td style="border: 1px solid #dddddd;">
						<?php echo $row['iNumber_ke'];?>					
					</td>	
					<td style="border: 1px solid #dddddd;">
						<?php echo $row['vRemark'];?>					
					</td>
					<td style="border: 1px solid #dddddd;">
						<?php echo $row['tgl_Approve'];?>					
					</td>
				</tr>
			<?php
			$i++;
			}
			?>
	</tbody>
</table>