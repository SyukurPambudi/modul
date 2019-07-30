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
							<th width="5%" rowspan="2">No</th>
							<th width="15%" rowspan="2">Kategori</th>
							<th width="80%" rowspan="2">Kelengkapan Data</th>
							<th width="15%" colspan="2">Non - Solid</th>
							<th width="15%" colspan="2">Status Dokumen</th>
						</tr>
						<tr>
							<th>ICH-CTD</th>
							<th>EU-CTD</th>
							<th>Tersedia</th>
							<th>Belum Tersedia</th>
						</tr>
						<input type="hidden" name="jenissediaan" value="<?php echo $iSediaan   ?>" >
						<?php 
						$sql_doc='	select * 
									from dossier.dossier_dokumen a 
									join dossier.dossier_dok_list b on b.idossier_dokumen_id=a.idossier_dokumen_id
									join dossier.dossier_kat_dok c on c.idossier_kat_dok_id=a.idossier_kat_dok_id 
									where a.lDeleted=0
									and b.lDeleted=0
									and b.idossier_negara_id="'.$vn['idossier_negara_id'].'"
									and b.idossier_review_id="'.$idossier_review_id.'"';
						$docs = $this->db_plc0->query($sql_doc)->result_array();


						$no = 1;
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
									<input type="hidden" name="idossier_dok_list_id[]" value="<?php echo $list['idossier_dok_list_id']   ?>" >

								</td>
								<td align="center">
									<input type="checkbox" name="eSolid_ich[]" value="Y" checked="checked" disabled="disabled">
								</td>
								<td align="center">
									<input type="checkbox" name="eSolid_eu[]" value="Y" checked="checked" disabled="disabled">
								</td>
								<td align="center">
									<input type="radio" name="istatus_keberadaan_<?php echo $list['idossier_dok_list_id']   ?>[]" value="1" <?php echo ($list['istatus_keberadaan']=='1')?'checked':'' ?>  >
								</td>
								<td align="center">
									<input type="radio" name="istatus_keberadaan_<?php echo $list['idossier_dok_list_id']   ?>[]" value="0" <?php echo ($list['istatus_keberadaan']=='0')?'checked':'' ?>   >
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