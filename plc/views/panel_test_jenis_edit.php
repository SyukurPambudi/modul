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
					$check = in_array($d['iplc2_upb_jenis_panel_id'], $val) ? 'checked' : '';
			?>
				<td width="3%"><input <?php echo $check ?> type="checkbox" name="bb[]" id="bb<?php echo $i ?>" value="<?php echo $d['iplc2_upb_jenis_panel_id'] ?>" class="dn_radio dokbb"></td>
				<td width="27%"><label for="bb<?php echo $i ?>"><?php echo $d['vNmJenis'] ?></label></td>				
			<?php
					$i++;
				}
			?>
			</tr>
				<input type="hidden" name="ibb" id="ibb" value=<?php echo $i;?>>
		</tbody>
	</table>
</div>