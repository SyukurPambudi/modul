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

function change_row_color(i){
	var va=$("#"+i).val();
	var ini="#ffffff";
	var n = $( "#"+i+":checked" ).length;
	if(n==1){
		if(va==1){
			ini="#d6fcfb";
		}else{
			ini="#fff7d8";
		}
	}
	$("#"+i).parent().parent().css("background-color", ini);
}
</script>
<div class="tab">

	<div id="cek_review" class="margin_0">
		<div style="overflow:auto;">
			<table class="hover_table" id="table_cek_review" cellspacing="0" cellpadding="1" style="border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse">
				<thead>
					<tr style="width: 100%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
						<th style="border: 1px solid #dddddd; width: 10%;">Modul</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Sub Modul</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Dokumen</th>
						<th style="border: 1px solid #dddddd; width: 5%;">Nilai Bobot <br> Dokumen</th>
						<th style="border: 1px solid #dddddd; width: 5%;">Tersedia</th>		
						<th style="border: 1px solid #dddddd; width: 5%;">Belum <br>Tersedia</th>		
						<th style="border: 1px solid #dddddd; width: 10%;">Ket</th>		
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($dokumen as $kdokumen => $vdokumen) { 
					?>
					<tr>
						<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vNama_Kategori'] ?></td>
						<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vsubmodul_kategori'] ?></td>
						<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['vNama_Dokumen'] ?></td>
						<td style="border: 1px solid #dddddd;"><?php echo $vdokumen['ibobot'] ?></td>
						<?php 
						$tersedia=$vdokumen['istatus_keberadaan']==1?'checked':'';
						$ttersedia=$vdokumen['istatus_keberadaan']==0?'checked':'';
						?>
						<td style="border: 1px solid #dddddd;"><input type="checkbox" class="required" <?php echo $tersedia; ?> name="review_dokumen[<?php echo $vdokumen['idossier_dok_list_id']; ?>]" id="review_1_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>" value="1" onclick='javascript:change_row_color("review_1_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>")' /></td>
						<td style="border: 1px solid #dddddd;"><input type="checkbox" class="required" <?php echo $ttersedia; ?> name="review_dokumen[<?php echo $vdokumen['idossier_dok_list_id']; ?>]" id="review_0_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>" value="0" onclick='javascript:change_row_color("review_0_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>")' /></td>
						<script>
							var n = $( "#review_1_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>:checked" ).length;
							var n2 = $( "#review_0_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>:checked" ).length;
							if(n==1){
								$("#review_1_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>").parent().parent().css("background-color", "#d6fcfb");
							}else if(n2==1){
								$("#review_0_dokumen_<?php echo $vdokumen['idossier_dok_list_id']?>").parent().parent().css("background-color", "#fff7d8");
							}
						</script>
						<td style="border: 1px solid #dddddd;">
							<textarea name="review_keterangan[<?php echo $vdokumen['idossier_dok_list_id'] ?>]" id="review_keterangan<?php echo $vdokumen['idossier_dok_list_id'] ?>"><?php echo $vdokumen['vKeterangan_review'] ?></textarea>
						</td>
					</tr>
					<?php
						} 
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>