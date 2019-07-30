<script>
/* DOM */
window
  .document
  .body

/* CLICK */

.addEventListener( "click", function( event ) {
  var oTarget = event.target;

 /* FOR input[type="checkbox"] */

if( oTarget.tagName == "INPUT" && oTarget.type == "checkbox" ) {
  var chkbox = document.getElementsByTagName("INPUT"),
  i = 0;
  for( ;i < chkbox.length; i++ ) {
     if( oTarget.name == chkbox[i].name ) {
       if( chkbox[i] == oTarget ) continue;
       chkbox[i].checked = false;
     }
   }
 }

 /* --- */

}, false );
function ceckcentang(id,idall,idrevall){
	j=0;
	$.each($("."+id), function(i,v){
		if($(this).attr('checked')){
		}else{
			j++;
		}
	});
	if(j>=1){
		$("#"+idall).attr('checked',false);
	}else if(j==0){
		$("#"+idall).attr('checked',true);
	}
	$("#"+idrevall).attr('checked',false);
}

</script>
<div class="tab">
	<ul>
	<?php
		foreach($mnnegara as $t => $vn) {
			echo '<li>
					  <a href="#neg_pembuatan_dosier_'.$vn['idossier_negara_id'].'">'.$vn['vNama_Negara'].'</a>
				  </li>';
		}
	?>	
	</ul>
	<?php
	foreach($mnnegara as $t => $vn) {				
	?>
		
		<div id="neg_pembuatan_dosier_<?php echo $vn['idossier_negara_id'] ?>" class="margin_0">
			<div style="overflow:auto;">
				<table class="hover_table" id="table_pembuatan_dosier_<?php echo $vn['idossier_negara_id'] ?>" cellspacing="0" cellpadding="1" style="border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse">
					<thead>
					<tr style="width: 100%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
						<th style="border: 1px solid #dddddd; width: 20%;">Modul</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Sub</th>
						<th style="border: 1px solid #dddddd; width: 35%;">Dokumen</th>
						<th style="border: 1px solid #dddddd; width: 5%;">Jml <br> Dokumen</th>
						<th style="border: 1px solid #dddddd; width: 5%;">Nilai Bobot <br> Dokumen</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Divisi</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Tersedia</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Tdk <br>Tersedia</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Ket</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Status</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Nama PIC</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Approved</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa <br> Dokumen</th>	
						<th style="border: 1px solid #dddddd; width: 10%;">Revisi <br> Oleh <br> Dossier</th>	
						<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokume</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Approved</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Revisi <br> Oleh <br> IR Staff</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Approved</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Revisi <br> Oleh <br> BDIRM</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen </th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Approved</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa</th>	
					</tr>
					</thead>
					<tbody>
						<?php 
							foreach ($dokumen as $kdokumen => $vdokumen) {
								if($vn['idossier_negara_id']==$vdokumen['idossier_negara_id']){
									
									$disabled=$vdokumen['iStatus_kelengkapan4']==1?'disabled':'';
									$checked=$vdokumen['iStatus_kelengkapan4']==1?'checked':'';
						?>
						<tr>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vmodul_kategori'] ?></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vNama_Kategori'] ?></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vNama_Dokumen'] ?></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['ijml_dok'] ?></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['ibobot'] ?></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vDescription'] ?></td>
							<?php 
							$tersedia=$vdokumen['istatus_keberadaan']==1?'checked':'';
							$ttersedia=$vdokumen['istatus_keberadaan']==0?'checked':'';
							?>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $tersedia; ?> disabled="disabled"> </td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $ttersedia; ?> disabled="disabled"></td>
							
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vKeterangan_review'] ?></td>
							<?php
							$s=($vdokumen['istatus_verifikasi']==1)&&($vdokumen['iStatus_confirm']==1)?'Approved':'Need Upload'
							?>
							<td style="border: 1px solid #dddddd;"> <?php echo $s; ?></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vName'] ?></td>
							<?php 
							$cek1=$vdokumen['iStatus_kelengkapan1']==1?'checked':'';
							$tcek1=$vdokumen['iStatus_kelengkapan1']==0?'checked':'';
							?>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $tcek1; ?> disabled="disabled" /></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $cek1; ?> disabled="disabled" /></td>
							<td style="border: 1px solid #dddddd;">
								<?php echo $vdokumen['vKeterangan_kelengkapan1']; ?></td>
							<?php
							$status=0;
							$sta='';
							if($vdokumen['iStatus_kelengkapan1']==1){
								$status=1;
								$ista='Approved';
							}else{
								$status=0;
								$ista='Revised';
							}
							$cek2=$vdokumen['iStatus_kelengkapan2']==1?'checked':'';
							$tcek2=$vdokumen['iStatus_kelengkapan2']==0?'checked':'';
							?>
							<td style="border: 1px solid #dddddd;"><?php echo $ista ?></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $tcek2; ?> disabled="disabled" /></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $cek2; ?> disabled="disabled" /></td>
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vKeterangan_kelengkapan2']; ?></td>
							<?php
							$status2=0;
							$sta2='';
							if($vdokumen['iStatus_kelengkapan2']==1){
								$status2=1;
								$ista2='Approved';
							}else{
								$status2=0;
								$ista2='Revised';
							}
							$cek3=$vdokumen['iStatus_kelengkapan3']==1?'checked':'';
							$tcek3=$vdokumen['iStatus_kelengkapan3']==0?'checked':'';
							?>
							<td style="border: 1px solid #dddddd;"><?php echo $ista2 ?></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $tcek3; ?> disabled="disabled" /></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $cek3; ?> disabled="disabled" /></td>
							
							<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vKeterangan_kelengkapan3']; ?></td>
							<?php
							$status3=0;
							$sta3='';
							if($vdokumen['iStatus_kelengkapan3']==1){
								$status3=1;
								$ista3='Approved';
							}else{
								$status3=0;
								$ista3='Revised';
							}
							$cek4=$vdokumen['iStatus_kelengkapan4']==1?'checked':'';
							$tcek4=$vdokumen['iStatus_kelengkapan4']==0?'checked':'';
							?>
							<td style="border: 1px solid #dddddd;"><?php echo $ista3 ?></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $tcek4; ?> disabled="disabled" /></td>
							<td style="border: 1px solid #dddddd;"><input type="checkbox" <?php echo $cek4; ?> disabled="disabled" /></td>
							
							<td style="border: 1px solid #dddddd;">
								<?php echo $vdokumen['vKeterangan_kelengkapan4']; ?></td>
						<tr>
						<?php			
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
		}
	?>
</div>
