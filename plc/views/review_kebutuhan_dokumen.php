<div class="tab">
	<ul>
	<?php
		foreach($mnnegara as $t => $vn) {
			echo '<li>
					  <a href="#neg-'.$vn['idossier_negara_id'].'">'.$vn['vNama_Negara'].'</a>
				  </li>';
		}
	?>	
	</ul>
	<?php
		foreach($mnnegara as $t => $vn) {				
	?>
		<div id="neg-<?php echo $vn['idossier_negara_id'] ?>" class="margin_0">
			<div>
				<table width="75%" border='1'  style ="border-radius:5px;border-collapse:collapse">
					<tr>
						<th width="5%">No</th>
						<th width="15%">Kategori</th>
						<th width="80%">Kelengkapan Data</th>
						<th width="15%" colspan="2"><?php echo $upd['vjenis_dok']; ?></th>
					</tr>
					<input type="hidden" name="jenissediaan" value="<?php echo $iSediaan?>" >
					<?php $no = 1;
					foreach($docs as $list) 
					{ 
						
					?>
						<tr>
							<td align="right"><?php echo $no ?></td>
							<td>
								<?php echo $list['vNama_Kategori'] ?>
							</td>
							<td>
								<?php echo $list['vNama_Dokumen'] ?>
								<input type="hidden" name="idossier_dokumen_id[<?php echo $vn['idossier_negara_id'];?>][]" value="<?php echo $list['idossier_dokumen_id']   ?>" >

							</td>
							<td align="center">
								<input type="checkbox" name="isediaan[]" value="Y" checked="checked" disabled="disabled">
							</td>
						</tr>
					<?php
						$no++;
						}
					?>
				</table>
			</div>			
		</div>
	<?php
		}
	?>
		
</div>