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
				<td width="3%"><input <?php echo $check ?> type="checkbox" name="sm[]" id="sm<?php echo $i ?>" value="<?php echo $d['idoc_id'] ?>" class="dn_radio doksm"></td>
				<td width="27%"><label for="sm<?php echo $i ?>"><?php echo $d['vdokumen'] ?></label></td>
				
				<!--<td width="3%"><input type="checkbox" name="bb[]" value="<?php echo $d['idoc_id'] ?>" class="dn_radio"></td>
				<td width="27%">MSDS</td>
				
				<td width="3%"><input type="checkbox" name="bb[]" value="<?php echo $d['idoc_id'] ?>" class="dn_radio"></td>
				<td width="27%">Sertifikat Non-GMO untuk kedelai dan turunannya</td>-->
			<?php
					$i++;
				}
			?>
			</tr>
				<input type="hidden" name="ism" id="ism" value=<?php echo $i;?>>
		</tbody>
	</table>
</div>