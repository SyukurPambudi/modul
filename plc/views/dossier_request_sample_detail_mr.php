<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>

<table class="hover_table" id="dossier_request_sample_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">DETAIL REQUEST</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 3%;" >No</th>
		<th style="border: 1px solid #dddddd; width: 8%;">No Item</th>
		<th style="border: 1px solid #dddddd; width: 25%;">Item Name</th>
		<th  style="border: 1px solid #dddddd; width: 8%;">No Batch</th>
		<th style="border: 1px solid #dddddd; width: 5%;">Qty</th>
	</tr>
	</thead>
	<tbody>
	
		<?php 
			$i = 1;
			foreach($rows as $row) {

		?>
			<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: right;">
						<span class="dossier_request_sample_upload_num"><?php echo $i ?></span>
					</td>	
					<td style="border: 1px solid #dddddd;  text-align: center;">
						<?php echo $row['c_itemnumb'] ?>
					</td>
					<td style="border: 1px solid #dddddd; text-align: center;">
						<?php echo $row['c_itemname'] ?>
					</td>
					<td style="border: 1px solid #dddddd;  text-align: center;">
						<?php echo $row['c_batchno'] ?>
					</td>
					<td style="border: 1px solid #dddddd;  text-align: right;">
						<?php echo number_format($row['n_qty'])  ?>
					</td>
			</tr>
		<?php		
			$i++;	
			}

		 ?>
				
		
	</tbody>
</table>
<?php 
	//print_r($rows);
 ?>


