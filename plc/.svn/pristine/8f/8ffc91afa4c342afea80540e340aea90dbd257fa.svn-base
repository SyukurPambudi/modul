<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

		//print_r($rowDataH);
?>

<?php 
	if($act == 'create'){
		// add new record

		$this->db->where('ldeleted', 0);
		$this->db->order_by('vdokumen', 'ASC');
		$docs= $this->db->get('plc2.plc2_upb_master_dokumen_bb')->result_array();


?>
	<style type="text/css">
		margin: 0 7px 0 0;
	    padding: 0px;
	</style>
	<div class="box_cbox">
		<table width="100%" border="0">
			<tbody>
				<tr>
				<?php
					$i=0;			
					foreach($docs as $d) {
						if($i % 3 == 0) {
							echo '</tr><tr>';
						}
				?>
					<td width="3%"><input type="checkbox" name="bb[]" id="bb<?php echo $i ?>" value="<?php echo $d['idoc_id'] ?>" class="dn_radio dokbb"></td>
					<td width="27%"><label for="bb<?php echo $i ?>"><?php echo $d['vdokumen'] ?></label></td>				
				<?php
						$i++;
					}
				?>
				</tr>
				<input type="hidden" name="ibb" id="ibb" value=<?php echo $i;?>>
			</tbody>
		</table>
	</div>


<?php 
	}else{
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$docs = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		$isi = $rowDataH['txtDocBB'];

		// form update
?>		
	<style type="text/css">
		margin: 0 7px 0 0;
	    padding: 0px;
	</style>
	<div class="box_cbox">
		<?php
			$val = explode(',', $isi);
		?>
		<table width="100%" border="0">
			<tbody>
				<tr>
				<?php
					$i=0;			
					foreach($docs as $d) {
						if($i % 3 == 0) {
							echo '</tr><tr>';
						}
						$check = in_array($d['idoc_id'], $val) ? 'checked' : '';
				?>
					<td width="3%"><input <?php echo $check ?> type="checkbox" name="bb[]" id="bb<?php echo $i ?>" value="<?php echo $d['idoc_id'] ?>" class="dn_radio dokbb"></td>
					<td width="27%"><label for="bb<?php echo $i ?>"><?php echo $d['vdokumen'] ?></label></td>				
				<?php
						$i++;
					}
				?>
				</tr>
					<input type="hidden" name="ibb" id="ibb" value=<?php echo $i;?>>
			</tbody>
		</table>
	</div>


<?php 
	}
 ?>		





