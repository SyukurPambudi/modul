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