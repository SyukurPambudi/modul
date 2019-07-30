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

function add_row_<?php echo $path ?>(idtable,iddok){
	var row ='';
	row +='<tr>';
	row +='<td>';
	row +='<input type="file" class="fileupload multi multifile required" name="fileupload_<?php echo $path ?>'+iddok+'[]" style="width: 90%" />'; 
	row +='<input type="hidden" name="<?php echo $path; ?>_idossier_dok_td_id['+iddok+'][]" style="width: 90%" value="'+iddok+'" />';
	row +='<input type="hidden" name="<?php echo $path; ?>_idossier_dok_td_file_id['+iddok+'][]" style="width: 90%" value="" />';
	row +='</td>';
	row +='<td>';
	row +='<span class="delete_btn"><a href="javascript:;" class="<?php echo $path; ?>_del_'+iddok+'" onclick="del_row1(this, \'<?php echo $path; ?>_del_'+iddok+'\')">[Hapus]</a></span>';
	row +='</td>';
	row +='</tr>';
	jQuery("#"+idtable).append(row);
}

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

$("#<?php echo $path; ?>_rev_all_cek_1_").change(function(){
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
$("#<?php echo $path; ?>_app_all_cek_1_").click(function(){
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
	ceckcentang("appr_","<?php echo $path; ?>_app_all_cek_1_","<?php echo $path; ?>_rev_all_cek_1_")
});
$(".rev_").change(function(){
	ceckcentang("rev_","<?php echo $path; ?>_rev_all_cek_1_","<?php echo $path; ?>_app_all_cek_1_")
});

</script>
<div class="tab">
	<div id="create_" class="margin_0">
		<div style="overflow:auto; max-width:1280px">
			<table class="hover_table" id="table_create_<?php echo $path ?>" cellspacing="0" cellpadding="1" style="border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse" width='1280px'>
				<thead>
				<tr style="width: 100%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
					<th style="border: 1px solid #dddddd; width: 6%;">No</th>
					<th style="border: 1px solid #dddddd; width: 10%;">Dokumen yg dibutuhkan</th>
					<th style="border: 1px solid #dddddd; width: 8%;">Keterangan</th>
					<th style="border: 1px solid #dddddd; width: 8%;">PIC Requestor</th>
					<th style="border: 1px solid #dddddd; width: 8%;">Tgl Request</th>
					<th style="border: 1px solid #dddddd; width: 15%;">Pilih File</th>
					<th style="border: 1px solid #dddddd; width: 15%;">Keterangan Upload</th>
					<th style="border: 1px solid #dddddd; width: 10%;">Status</th>
					<?php
					if($docs->num_rows()>=1){
						$s=0;
						foreach ($docs->result_array() as $kdocs => $vdocs) { 
							if($vdocs['istatus_upload']==1 && $s==0){
					?>
								<th style="border: 1px solid #dddddd; width: 10%;">Rev <br> Dokumen <br> <input type="checkbox" name="<?php echo $path; ?>_all_cek_1_" id="<?php echo $path; ?>_rev_all_cek_1_" class='all_rev' /></th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Approved<br> <input type="checkbox" name="<?php echo $path; ?>_all_cek_1_" id="<?php echo $path; ?>_app_all_cek_1_" class="all_rev" /></th>		
								<th style="border: 1px solid #dddddd; width: 10%;">Keterangan <br> Revision Analisa <br> Dokumen</th>
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
							//f($vn['idossier_negara_id']==$vdocs['idossier_negara_id']){
								$ista=$vdocs['istatus_upload'];
								$dis=$vdocs['istatus_upload']==1?'disabled="disabled"':'';
								?>
								<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;">
									<td style="border: 1px solid #dddddd; width: 6%; text-align: center;">
										<span class="<?php echo $path ?>_num"><?php echo $i ?></span>
									</td>
									<td colspan="1" style="border: 1px solid #dddddd; width: 10%">
										<input type="hidden" id="<?php echo $path ?>_iddet_<?php echo $i ?>" name="iddet_<?php echo $path ?>[]" required="required" class="required input_rows1" size="25" value="<?php echo $vdocs['idossier_dok_td_detail_id'] ?>" />
										<table id="table_memo_<?php echo $path ?>_<?php echo $i; ?>" width="100%">
											<tbody>
											<?php
												$sq="select * from dossier.dossier_dok_td_memo_file fi
													where fi.lDeleted=0 and fi.idossier_dok_td_detail_id=".$vdocs['idossier_dok_td_detail_id'];
												$qmem=$this->db_plc0->query($sq);
												if($qmem->num_rows>=1){
													$dmem=$qmem->result_array();
													foreach ($dmem as $kmem => $vmem) {
														echo $vmem['vFilename'].'<br>';
													}
												}
											?>
											</tbody>
										</table>
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
										<?php echo date('d-m-Y',strtotime($vdocs['drequest'])); ?>
									</td>
									<td style="border: 1px solid #dddddd; width: 15%">
										<table id="table_upload_<?php echo $path.$vdocs['idossier_dok_td_memo_id'] ?>" with="100%">
										<?php 
										$isdone=0;
										$keterangan='';
											$sqli="select * from dossier.dossier_dok_td_file fi where fi.lDeleted=0 and fi.idossier_dok_td_memo_id=".$vdocs['idossier_dok_td_memo_id'];
											$qsel=$this->db_plc0->query($sqli);
											if($qsel->num_rows()>=1){
												$isdone=1;
												foreach ($qsel->result_array() as $ksel => $vsel) {
													?>
														<tr>
															<td width="80%" style="text-align:left">
																<?php
																$o='';
																$id=$vsel['idossier_dok_td_memo_id'];
																$value=$vsel['vFilename'];
																if($value != '') {
																	if (file_exists('./files/plc/dossier_dok/dossier_dok_td/'.$id.'/'.$value)) {
																		$link = base_url().'processor/plc/dossier/dokumen/td?action=downloaddok&id='.$id.'&file='.$value;
																		$o.= '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$vsel['vFilename'].'</a>';
																	}
																	else {
																		$o.= 'File sudah tidak ada!';
																	}
																}
																echo $o; ?>
																<input type="hidden" name="<?php echo $path; ?>_idossier_dok_td_id[<?php echo $vsel['idossier_dok_td_memo_id'] ?>][]" style="width: 90%" value="<?php echo $vsel['idossier_dok_td_memo_id'] ?>" />
														        <input type="hidden" name="<?php echo $path; ?>_idossier_dok_td_file_id[<?php echo $vsel['idossier_dok_td_memo_id'] ?>][]" style="width: 90%" value="<?php echo $vsel['idossier_dok_td_file_id'] ?>" />
												   			</td>
												   			<td width="20%">
												   				<?php if($ista!=1){ ?>
												   				<span class="delete_btn"><a href="javascript:;" class="<?php echo $path; ?>_del_<?php echo $vdocs['idossier_dok_td_memo_id'] ?>" onclick="del_row1(this, '<?php echo $path; ?>_del_<?php echo $vdocs['idossier_dok_td_memo_id'] ?>')">[Hapus]</a></span>
												   				<?php } ?>
												   			</td>
												   		</tr>
												<?php
												}
											}else{
												
											}
										?></table>
										<?php if($ista!=1){ ?>
										<span class="tambah_btn_<?php echo $path.$vdocs['idossier_dok_td_memo_id'] ?>">
											<a href="javascript:;" onclick="javascript:add_row_<?php echo $path ?>('table_upload_<?php echo $path.$vdocs['idossier_dok_td_memo_id'] ?>',<?php echo $vdocs['idossier_dok_td_memo_id'] ?>)">Tambah</a>
										</span>
										<?php } ?>
									</td>
									<td style="border:1px solid #dddddd; width:15%">
										<textarea class="" id="<?php echo $path; ?>_fileketerangan_<?php echo $vdocs['idossier_dok_td_memo_id'] ?>" name="<?php echo $path; ?>_fileketerangan[<?php echo $vdocs['idossier_dok_td_memo_id'] ?>]" style="width: 200px;"size="200" <?php echo $dis ?> ><?php echo $vdocs['vketerangan']; ?></textarea>
									</td>
									<td style="border:1px solid #dddddd; width:10%">
										<?php if($isdone!=0){ 
											$status=0;
											$checked=$vdocs['istatus_upload']==1?'checked':'';
											$disabled=$vdocs['istatus_upload']==1?'disabled="disabled"':'';
											$dis=$vdocs['istatus_upload']==1?'dis':'';
											?>
											<input type="checkbox" class="" name="<?php echo $path.$dis; ?>_sudah[<?php echo $vdocs['idossier_dok_td_memo_id'] ?>][]" style="width: 90%" value="1" <?php echo $disabled." ".$checked; ?> >Status Upload
										<?php } ?>
									</td>
									<?php if($vdocs['istatus_upload']==1){
										
											
											$ista='';
											if($vdocs['istatus_td_kelengkapan1']==2){
												$ista='Approved';
											}elseif($vdocs['istatus_td_kelengkapan1']==1){
												$ista='Revised';
											}
											$checkapp=$vdocs['istatus_td_kelengkapan1']==2?'checked':'';
											$checkrev=$vdocs['istatus_td_kelengkapan1']==1?'checked':'';
											$disabled=$vdocs['istatus_td_kelengkapan1']==2?'disabled="disabled"':'';
											?>
											<td style="border: 1px solid #dddddd;"><input type="checkbox" name="cek_1<?php echo $disabled ?>[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_1<?php echo $disabled.$vdocs['idossier_dok_td_memo_id']; ?>" value="1" class='rev_<?php echo $disabled; ?>' <?php echo $disabled." ".$checkrev ?> /></td>
											<td style="border: 1px solid #dddddd;"><input type="checkbox" name="cek_1<?php echo $disabled ?>[<?php echo $vdocs['idossier_dok_td_memo_id']; ?>]" id="cek_1<?php echo $disabled.$vdocs['idossier_dok_td_memo_id']; ?>" value="2" class='appr_<?php echo $disabled; ?>' <?php echo $disabled." ".$checkapp ?> /></td>
											
											<td style="border: 1px solid #dddddd;">
												<?php 
													if ($vdocs['istatus_td_kelengkapan1']!=2){?>
														<textarea name="cek_1_keterangan[<?php echo $vdocs['idossier_dok_td_memo_id'] ?>]" id="cek_1_keterangan_<?php echo $vdocs['idossier_dok_td_memo_id'].$disabled ?>"><?php echo $vdocs['vKeterangan_td_kelengkapan1']; ?></textarea> <?php }
													else{
														echo $vdocs['vKeterangan_td_kelengkapan1'];
													}
													?></td>			
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