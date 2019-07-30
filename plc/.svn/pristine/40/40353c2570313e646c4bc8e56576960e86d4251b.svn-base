<?php $path="dossier_dok_td"; ?>
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

function ceckcentang4(id,idall,idrevall){
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
$("#<?php echo $path; ?>_rev_all_cek_4_").change(function(){
	va=false;
	da=false;
	if($(this).attr('checked')){
		va=true;
		da=false;
	}
	tr=$(this).parent().parent().parent().next();
	$(tr).find('input:checkbox.appr_').attr('checked',da);
	$(tr).find('input:checkbox.rev_').attr('checked',va);
});
$("#<?php echo $path; ?>_app_all_cek_4_").click(function(){
	va=false;
	da=false;
	if($(this).attr('checked')){
		va=true;
		da=false;
	}
	tr=$(this).parent().parent().parent().next();
	$(tr).find('input:checkbox.rev_').attr('checked',da);
	$(tr).find('input:checkbox.appr_').attr('checked',va);
});
$(".appr_").change(function(){
	ceckcentang4("appr_","<?php echo $path; ?>_app_all_cek_4_","<?php echo $path; ?>_rev_all_cek_4_");
});
$(".rev_").change(function(){
	ceckcentang4("rev_","<?php echo $path; ?>_rev_all_cek_4_","<?php echo $path; ?>_app_all_cek_4_");
});

</script>
<div class="tab">
	<div id="create_<?php echo $path?>" class="margin_0">
		<div style="overflow:auto; max-width:1280px">
			<table class="hover_table" id="table_create_" cellspacing="0" cellpadding="1" style="border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse">
				<thead>
				<tr style="width: 100%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
					<th style="border: 1px solid #dddddd; width: 6%;">No</th>
					<th style="border: 1px solid #dddddd; width: 8%;">Nama Dokumen</th>
					<th style="border: 1px solid #dddddd; width: 8%;">PIC Requestor</th>
					<th style="border: 1px solid #dddddd; width: 8%;">Tgl Request</th>
					<th style="border: 1px solid #dddddd; width: 15%;">Pilih File</th>
					<th style="border: 1px solid #dddddd; width: 15%;">Keterangan</th>
					<th style="border: 1px solid #dddddd; width: 10%;">Status</th>
					<?php
					if($docs->num_rows()>=1){
						$s=0;
						foreach ($docs->result_array() as $kdocs => $vdocs) { 
							if($vdocs['istatus_upload']==1  && $s==0){
					?>
								<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen</th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Approved<br></th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa <br> Dokumen</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Revisi <br> Oleh <br> Dossier</th>	
								<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen</th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Approved</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Revisi <br> Oleh <br> IR Staff</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen </th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Approved</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Revisi <br> Oleh <br> BDIRM</th>
								<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen <br> <input type="checkbox" name="all_cek_4_" id="<?php echo $path ?>_rev_all_cek_4_" class='all_rev' /></th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Approved<br> <input type="checkbox" name="all_cek_4_" id="<?php echo $path ?>_app_all_cek_4_" class="all_rev" /></th>
								<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revisi Analisa</th>		
					</tr>
					<?php
							$s++;
							}
						}
					}
					?>
					
				</thead>
				<tbody>
					<?php

					if($docs->num_rows()>=1){
						$sq=0;
						$i=1;
						foreach ($docs->result_array() as $kdocs => $vdocs) { 
							//if($vn['idossier_negara_id']==$vdocs['idossier_negara_id']){
								$ista=$vdocs['istatus_upload'];
								$dis=$vdocs['istatus_upload']==1?'disabled="disabled"':'';
								?>
								<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;">
									<td style="border: 1px solid #dddddd; width: 6%; text-align: center;">
										<span class="<?php echo $path ?>_num"><?php echo $i ?></span>
									</td>
									<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
										<?php echo $vdocs['vdok_td_memo'] ?>
									</td>
									<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
											<?php 
											$nama='';
											foreach ($pic as $kpic => $vpic) {
												if($vdocs['cpic']==$vpic['cNip']){
													$nama=$vpic['vName'];
												}
											}
											echo $nama;
										?>
									</td>
									<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
										<?php echo $vdocs['drequest']; ?>
									</td>
									<td style="border: 1px solid #dddddd; width: 15%">
										<table id="table_upload_<?php echo $path ?>" with="100%">
										<?php 
										$isdone=0;
										$keterangan='';
											$sqli="select * from dossier.dossier_dok_td_file fi where fi.lDeleted=0 and fi.idossier_dok_td_memo_id=".$vdocs['idossier_dok_td_memo_id'];
											$qsel=$this->db_plc0->query($sqli);
											if($qsel->num_rows()>=1){
												$isdone=1;
												foreach ($qsel->result_array() as $ksel => $vsel) {
													$keterangan=$vsel['vKeterangan'];
													?>
														<tr>
															<td width="80%" style="text-align:left">
																<?php echo $vsel['vFilename']; ?>
												   			</td>
												   			<td width="20%">
												   			</td>
												   		</tr>
												<?php
												}
											}else{
												?>	<tr>
														<td>
															<?php echo "No File"; ?>
														</td>
														<td></td>
												   	</tr>
												<?php
											}
										?></table>
									</td>
									<td style="border:1px solid #dddddd; width:15%">
										<?php echo $vdocs['vketerangan']; //Keterangan Upload ?>
									</td>
									<td style="border:1px solid #dddddd; width:10%">
										<?php  
											$checked=$vdocs['istatus_upload']==1?'Uploaded':'Need Upload';
											echo $checked;
											?>
									</td>
									<?php if($vdocs['istatus_upload']==1){
										$sq++; 
										$checkapp=$vdocs['istatus_td_kelengkapan1']==2?'checked':'';
										$checkrev=$vdocs['istatus_td_kelengkapan1']==1?'checked':'';
										$disabled1=$vdocs['istatus_td_kelengkapan1']!=0?' disabled="disabled"':'';
										$dis=$vdocs['istatus_td_kelengkapan1']!=0?'dis':'';
										?>
										<td style="border: 1px solid #dddddd;"><input type="checkbox" name="<?php echo $path; ?>_cek_1[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_1_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="1" <?php echo $checkrev.$disabled1 ?> /></td>
										<td style="border: 1px solid #dddddd;"><input type="checkbox" name="<?php echo $path; ?>_cek_1[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_1_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="2" <?php echo $checkapp.$disabled1 ?> /></td>
										<td style="border: 1px solid #dddddd;">
											<?php
													echo $vdocs['vKeterangan_td_kelengkapan1'];
											?>
										</td>
										<?php
											$status2=0;
											$ista='';
											if($vdocs['istatus_td_kelengkapan1']==2){
												$status2=2;
												$ista='Approved';
											}elseif($vdocs['istatus_td_kelengkapan1']==1){
												$ista='Revised';
											}
											$checkapp2=$vdocs['iStatus_td_kelengkapan2']==2?'checked':'';
											$checkrev2=$vdocs['iStatus_td_kelengkapan2']==1?'checked':'';
											$disabled2=$vdocs['iStatus_td_kelengkapan2']!=0?' disabled="disabled"':'';
											$dis2=$vdocs['iStatus_td_kelengkapan2']!=0?'dis':'';
											?>
											<td style="border: 1px solid #dddddd;"><?php echo $ista ?></td>
											<td style="border: 1px solid #dddddd;"><?php if($status2==2){ ?><input type="checkbox" name="cek_2[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_2_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="1" <?php echo $checkrev2.$disabled2 ?> /><?php } ?></td>
											<td style="border: 1px solid #dddddd;"><?php if($status2==2){ ?><input type="checkbox" name="cek_2[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_2_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="2" <?php echo $checkapp2.$disabled2 ?> /><?php } ?></td>
									
											<td style="border: 1px solid #dddddd;">
													<?php 
													echo $vdocs['vKeterangan_td_kelengkapan2'];
													?></td>
										<?php
											$status3=0;
											$ista='';
											if($vdocs['iStatus_td_kelengkapan2']==2){
												$status3=2;
												$ista='Approved';
											}elseif($vdocs['iStatus_td_kelengkapan2']==1){
												$ista='Revised';
											}
											$checkapp3=$vdocs['iStatus_td_kelengkapan3']==2?'checked':'';
											$checkrev3=$vdocs['iStatus_td_kelengkapan3']==1?'checked':'';
											$disabled3=$vdocs['iStatus_td_kelengkapan3']!=0?' disabled="disabled"':'';
											$dis2=$vdocs['iStatus_td_kelengkapan3']!=0?'dis':'';
											?>
											<td style="border: 1px solid #dddddd;"><?php echo $ista ?></td>
											<td style="border: 1px solid #dddddd;"><?php if($status3==2){ ?><input type="checkbox" name="cek_3[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_3_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="1" <?php echo $checkrev3.$disabled3 ?> /><?php } ?></td>
											<td style="border: 1px solid #dddddd;"><?php if($status3==2){ ?><input type="checkbox" name="cek_3[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_3_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="2" <?php echo $checkapp3.$disabled3 ?> /><?php } ?></td>
									
											<td style="border: 1px solid #dddddd;">
													<?php 
													echo $vdocs['vKeterangan_td_kelengkapan3'];
													?></td>
										<?php
											$status4=0;
											$ista4='';
											if($vdocs['iStatus_td_kelengkapan3']==2){
												$status4=2;
												$ista4='Approved';
											}elseif($vdocs['iStatus_td_kelengkapan3']==1){
												$ista4='Revised';
											}
											$checkapp4=$vdocs['iStatus_td_kelengkapan4']==2?'checked':'';
											$checkrev4=$vdocs['iStatus_td_kelengkapan4']==1?'checked':'';
											//$disabled4=$vdocs['iStatus_td_kelengkapan4']!=0?' disabled="disabled"':'';
											$disabled4='';
											$dis4=$vdocs['iStatus_td_kelengkapan4']!=0?'dis':'';
											?>
											<td style="border: 1px solid #dddddd;"><?php echo $ista4 ?></td>
											<td style="border: 1px solid #dddddd;"><?php if($status4==2){ ?><input type="checkbox" name="cek_4[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_4_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="1" class='rev_'<?php echo $checkrev4.$disabled4 ?> /><?php } ?></td>
											<td style="border: 1px solid #dddddd;"><?php if($status4==2){ ?><input type="checkbox" name="cek_4[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_4_<?php echo $vdocs['idossier_dok_td_memo_id']; ?>" value="2" class='appr_'<?php echo $checkapp4.$disabled4 ?> /><?php } ?></td>
									
											<td style="border: 1px solid #dddddd;">
												<?php if($status4==2){ 
														//if($vdocs['iStatus_td_kelengkapan4']!=2){
													?>
															<textarea name="cek_4_keterangan[<?php echo $vdocs['idossier_dok_td_memo_id'] ?>]" id="cek_4_keterangan_<?php echo $vdocs['idossier_dok_td_memo_id'] ?>"><?php echo $vdocs['vKeterangan_td_kelengkapan4']; ?></textarea> <?php 
														//}else{
														//	echo $vdocs['vKeterangan_td_kelengkapan4'];
														//}
													}else{
														echo $vdocs['vKeterangan_td_kelengkapan4'];
													} ?></td>							
									
									<?php } ?>
								</tr>
								<?php
								$i++;
							}
						}
					?>					
				</tbody>
				<tfoot>
				</tfoot>	
			</table>			
		</div>
	</div>
	<?php
	
	?>
</div>