<script type="text/javascript">
function add_row1(table_id,id,req){
	var row_content = '';
	row_content +='<tr><td>';
	row_content	+= '<input type="file" class="fileupload multi multifile '+req+'" name="fileupload_'+id+'[]" style="width: 90%" /><br>';
	row_content	+= '<input type="hidden" name="idossier_dok_list_id['+id+'][]" style="width: 90%" value="'+id+'" />';
	row_content	+= '<input type="hidden" name="idossier_dok_list_file_id['+id+'][]" style="width: 90%" value="" />';
	row_content += '</td><td><span class="delete_btn"><a href="javascript:;" class="tbfileupload_'+id+'" onclick="del_row12(this, \'tbfileupload_'+id+'\', '+id+')">[Hapus]</a></span></td></tr>';
	//$('table#fileupload_'+table_id+' tbody').after(row_content);
	jQuery("#"+table_id).append(row_content);
	var tb = $("#"+table_id).parent().next().next();
	var row_sudah = '<input type="checkbox" class="" name="sudah['+id+'] ?>][]" style="width: 90%" value="1">Status Upload<input type="hidden" name="istatus_keberadaan_update['+id+'] ?>]" value="1" />';
	tb.text('');
	tb.append(row_sudah);
	
}
function del_row12(dis, conname, id) {
	custom_confirm('Delete Selected Record?', function(){
		//$(dis).parent().parent().parent().find('.lDeleted').val('1');
		//$(dis).parent().parent().parent().fadeOut();
		var ini =$(dis).parent().parent().parent();
		var tb = $("table#"+conname).parent().next().next();
		ini.remove();
		var row=$("table#"+conname+" tr").length;
		var row_sudah = '<input type="checkbox" class="" name="sudah['+id+'] ?>][]" style="width: 90%" value="1">Status Upload<input type="hidden" name="istatus_keberadaan_update['+id+'] ?>]" value="1" />';
		tb.text('');
		if(row==0){
			$.ajax({
				url: base_url+'processor/plc/dossier/upload/dokumen?action=cekstatusup',
				type: 'post',
				data: 'id_doklis='+id,
				success: function(data) {
					var o = $.parseJSON(data);
					if(o.status==true){
						$("table#"+conname).before("<p>"+o.message+"</p>");
						tb.append(row_sudah);
					}
				}		
			});
		}else{
			tb.append(row_sudah);
		}
	})
	
}

function del_row13(dis, conname) {
		custom_confirm('Hide Selected Record?', function(){
			//$(dis).parent().parent().parent().remove();
			$(dis).parent().parent().parent().remove();
			
		});
}

function sudah(ini, id_doklis, nameDok){
	grid='dossier_upload_dokumen';
	url=base_url+'processor/plc/dossier/upload/dokumen?action=verkon';
	custom_confirm('Anda Yakin Akan Melanjutkan Dokumen : '+nameDok, function(){
		$.ajax({
			url: url,
			type: 'post',
			data: 'id='+id_doklis,
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.status==true){
					var info = 'success';
					var header = 'success';
					_custom_alert(o.message,header,info, grid, 1, 20000);
					$(ini).checked=true;
					$(ini).parent().parent().find(".tambah_btn").remove();
					$(ini).parent().parent().find(".delete_btn").remove();
					keterangan=$(ini).parent().parent().find("#filekt1");
					vket=keterangan.val();
					td=keterangan.parent();
					td.html(vket);
					$(ini).attr('disabled','disabled');
				}else{
					var info = 'error';
					var header = 'error';
					_custom_alert(o.message,header,info, grid, 1, 20000);
				}
			}		
		});
	});
	$(ini).checked=false;
}
</script>
<style type="text/css">
	table.table_on_mouse_over tr:hover td {
	  background: #f2f2f2;
	  background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	  background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
	}
</style>
<div class="tab">
		<div id="neg_upload_dok" class="margin_0" style="overflow:auto;">
			<div>
				<table class="hover_table table_on_mouse_over" id="brosur_bb_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<thead>
					<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
						<th colspan="11" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Tambahan</span></th>
					</tr>
					<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
						<th style="border: 1px solid #dddddd; width: 3%;" >No</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Modul</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Sub Modul</th>
						<th style="border: 1px solid #dddddd; width: 20%;">Nama <br> Dokumen</th>
						<th style="border: 1px solid #dddddd; width: 10%;">PIC</th>
						<th style="border: 1px solid #dddddd; width: 10%;">Keterangan Review</th>
						<th style="border: 1px solid #dddddd; width: 35%;">Pilih File</th>
						<th style="border: 1px solid #dddddd; width: 5%;">Keterangan</th>
						<th style="border: 1px solid #dddddd; width: 5%;">Status</th>	
					</tr>
					</thead>
					<tbody>

				<?php 
				$i=1;

				foreach ($datadok as $kv => $vv) {
					
					foreach ($vv as $ki => $row) {
								$required=$row['iPerlu']==1?'required':'';
								//tambahan untuk download file
								$id  = $row['idossier_review_id'];
								// variable dokumen
								$tersedia = $row['istatus_keberadaan_update'];
								$submit_upload = $row['iSubmit_upload'];
								$iver=$row['istatus_verifikasi'];
								$iconfrm=$row['iStatus_confirm'];
								$istatus=0;
								if(($iconfrm==1)&&($iver==1)){
									$istatus=1;
								}
						//selesai tambahan download
							?>
							<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
								<td style="border: 1px solid #dddddd; width: 3%;text-align: center;">
									<span class="brosur_bb_upload_num"><?php echo $i ?></span>
								</td>	
								<td style="border: 1px solid #dddddd; width: 10%;text-align: left;">
									<?php echo $row['vNama_Kategori'] ?>
								</td>
								<td style="border: 1px solid #dddddd; width: 10%;text-align: left;">
									<?php echo $row['vsubmodul_kategori'] ?>
								</td>
								<td style="border: 1px solid #dddddd; width: 10%;text-align: left;">
									<?php echo $row['vNama_Dokumen'] ?>
								</td>	
								<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">

									<?php 

										if ($tersedia == 1) {
											$value=$row['vpic'] ;
											$sql = 'select * from hrd.employee a where a.cNip = "'.$value.'"	';
											$rows = $this->db_plc0->query($sql)->row_array();
											if($rows){
											echo $rows['vName'];
											}
										
									?>
										
									<?php
										}else{

											$value=$row['cPic'] ;
											$sql = 'select b.cNip,b.vName 
													from plc2.plc2_upb_team_item a 
													join hrd.employee b on a.vnip=b.cNip
													where a.iteam_id = "'.$iTeam_andev.'"
													and a.ldeleted=0
													and b.lDeleted = 0';
											$teams = $this->db_plc0->query($sql)->result_array();
											$o  = "<select id='dossier_upload_dokumen_cPic' class='combobox required' name='cPic[".$row['id_doklis']."][]'>";            
											$o .= '<option value="">--Select--</option>';
								            foreach($teams as $item) {
								                if ($item['cNip'] == $value) $selected = " selected";
								                else $selected = "";
								                $o .= "<option {$selected} value='".$item['cNip']."'>".$item['vName']."</option>";
								            }            
								            $o .= "</select>";

								            $value=$row['vpic'] ;
											$sql = 'select * from hrd.employee a where a.cNip = "'.$value.'"	';
											$rows = $this->db_plc0->query($sql)->row_array();
											if($rows){
											echo $rows['vName'];
											}
								        }

									 ?>

									
								</td>	
								<td style="border: 1px solid #dddddd; width: 20%;text-align: left;">
									<?php echo $row['vKeterangan_review'] ?>	
								</td>
								<td style="border: 1px solid #dddddd; width: 20%;text-align: left;">
									<input type="hidden" name="iHapus[<?php echo $row['id_doklis'] ?>][]" class='lDeleted'style="width: 70%"  />
									<input type="hidden" name="idossier_review_id" style="width: 70%" value="<?php echo $row['idossier_review_id'] ?>" />
									<input type="hidden" name="doklis_file_id[<?php echo $row['id_doklis'] ?>][]" style="width: 70%" value="<?php echo $row['idossier_dok_list_file_id'] ?>" />
									<input type="hidden" name="doklis_id[<?php echo $row['id_doklis'] ?>][]" style="width: 70%" value="<?php echo $row['id_doklis'] ?>" />
									<?php //echo $tersedia;
											$value=$row['id_doklis'] ;
											//echo $value;
											$sql = 'select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_id = "'.$value.'" and a.lDeleted=0';
											$rows = $this->db_plc0->query($sql);
										if ($tersedia == 1) {
											?>
											<table id="tbfileupload_<?php echo $row['id_doklis'] ?>" width="100%">
										 	<tbody>
										 		<?php 
										 			
										 			if($rows->num_rows()>=1){
														foreach ($rows->result_array() as $kr => $vr) {
															$file='';
															if ($vr['vFilename'] != "") {
																$id  = $row['idossier_review_id'];
																$value = $vr['vFilename'];	
																if (file_exists('./files/plc/dossier_dok/'.$id.'/'.$value)) {
																	$link = base_url().'processor/plc/dossier/upload/dokumen?action=download&id='.$id.'&file='.$value;
																	$file = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$vr['vFilename'].'</a>';
																}else{
																	$file=$vr['vFilename'];
																}
															}else{
																$file="File Tersedia";
															}
															?>
															<tr>
																<td>	
																	<?php echo $file; ?>
																	<input type="hidden" name="idossier_dok_list_id[<?php echo $vr['idossier_dok_list_id'] ?>][]" style="width: 90%" value="<?php echo $vr['idossier_dok_list_id'] ?>" />
															        <input type="hidden" name="idossier_dok_list_file_id[<?php echo $vr['idossier_dok_list_id'] ?>][]" style="width: 90%" value="<?php echo $vr['idossier_dok_list_file_id'] ?>" />
													   			</td>
													   			<td>
													   				<?php if($istatus==0){ ?>
													   				<span class="delete_btn"><a href="javascript:;" class="tbfileupload_<?php echo $vr['idossier_dok_list_id'] ?>" onclick="del_row12(this, 'tbfileupload_<?php echo $vr['idossier_dok_list_id'] ?>', <?php echo $vr['idossier_dok_list_id'] ?>)">[Hapus]</a></span></td>
													   				<?php } ?>
													   		</tr>
															<?php
														}
													}else{
															$file="File Tersedia";
															?>
															<tr>
																<td>	
																	<?php echo $file; ?>
																<!--	<input type="hidden" name="idossier_dok_list_id[<?php //echo $row['idossier_dok_list_id'] ?>][]" style="width: 90%" value="<?php //echo $row['idossier_dok_list_id'] ?>" />
															        <input type="hidden" name="idossier_dok_list_file_id[<?php //echo $row['idossier_dok_list_id'] ?>][]" style="width: 90%" value="<?php //echo $row['idossier_dok_list_file_id'] ?>" />
													   			--></td>
													   			<td><!--<span class="delete_btn"><a href="javascript:;" class="tbfileupload_<?php//echo $row['idossier_dok_list_id'] ?>" onclick="del_row(this, 'tbfileupload_<?php //echo $row['idossier_dok_list_id'] ?>')">[Hapus]</a></span>--></td>
													   		</tr>
															<?php
													}
										 		?>
												
									   		</tbody>
									   		</table>
									   		<?php if($istatus==0){ ?>
									   		<span class="tambah_btn">
												<a href="javascript:;" onclick="javascript:add_row1('tbfileupload_<?php echo $row['id_doklis'] ?>',<?php echo $row['id_doklis'] ?>,'<?php echo $required; ?>')">Tambah</a>
											</span>
											<?php } ?>
						
									<?php

										}else{


									 ?>
									 	<table id="tbfileupload_<?php echo $row['id_doklis'] ?>" width="100%">
									 	<tbody>
									 		<?php
									 		if($rows->num_rows()>=1){
												foreach ($rows->result_array() as $kr => $vr) {
														$file='';
														if ($vr['vFilename'] != "") {
															$id  = $row['idossier_review_id'];
															$value = $vr['vFilename'];	
															if (file_exists('./files/plc/dossier_dok/'.$id.'/'.$value)) {
																$link = base_url().'processor/plc/dossier/upload/dokumen?action=download&id='.$id.'&file='.$value;
																$file = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$vr['vFilename'].'</a>';
															}else{
																$file=$vr['vFilename'];
															}
														}else{
															$file="File Tersedia";
														}
														?>
														<tr>
															<td>	
																<?php echo $file; ?>
																<input type="hidden" name="idossier_dok_list_id[<?php echo $vr['idossier_dok_list_id'] ?>][]" style="width: 90%" value="<?php echo $vr['idossier_dok_list_id'] ?>" />
														        <input type="hidden" name="idossier_dok_list_file_id[<?php echo $vr['idossier_dok_list_id'] ?>][]" style="width: 90%" value="<?php echo $vr['idossier_dok_list_file_id'] ?>" />
												   			</td>
												   			<td>
												   				<?php if($istatus==0){ ?>
												   				<span class="delete_btn"><a href="javascript:;" class="tbfileupload_<?php echo $vr['idossier_dok_list_id'] ?>" onclick="del_row12(this, 'tbfileupload_<?php echo $vr['idossier_dok_list_id'] ?>', <?php echo $vr['idossier_dok_list_id'] ?>)">[Hapus]</a></span></td>
												   				<?php } ?>
												   		</tr>
														<?php
													}
												}else{
														?>
														<!--<tr>
															<td>	
																<input type="file" class="fileupload multi multifile <?php //echo $required; ?>" name="fileupload_<?php //echo $row['id_doklis'] ?>[]" style="width: 90%" /> <?php //if($row['iPerlu']==1){echo "*";}?>
																<input type="hidden" name="idossier_dok_list_id[<?php //echo $row['id_doklis'] ?>][]" style="width: 90%" value="<?php //echo $row['id_doklis'] ?>" />
														        <input type="hidden" name="idossier_dok_list_file_id[<?php //echo $row['id_doklis'] ?>][]" style="width: 90%" value="<?php //echo $row['idossier_dok_list_file_id'] ?>" />
												   			</td>
												   			<td><span class="delete_btn"><a href="javascript:;" class="fileupload_<?php //echo $row['id_doklis'] ?>" onclick="del_row(this, 'fileupload_<?php// echo $row['id_doklis'] ?>')">[Hapus]</a></span></td>
												   		</tr>-->
														<?php
												}
											?>
								   		</tbody>
								   		</table>
								   		<?php if($istatus==0){ ?>
								   		<span class="tambah_btn">
											<a href="javascript:;" onclick="javascript:add_row1('tbfileupload_<?php echo $row['id_doklis'] ?>',<?php echo $row['id_doklis'] ?>,'<?php echo $required ?>')">Tambah</a>
										</span>
									<?php 
										}
										}
									 ?>
								</td>
								<td style="border: 1px solid #dddddd; width: 10%">
									<?php 
										if ($tersedia == 1) {
											$value=$row['idossier_dok_list_file_id'] ;
											$sql = 'select * from dossier.dossier_dok_list_file a where a.idossier_dok_list_file_id = "'.$value.'"	';
											$rows = $this->db_plc0->query($sql)->row_array();
											if (!empty($rows)) {
												if($istatus==0){
												echo '<textarea class="" id="filekt1"name="fileketerangan['.$row['id_doklis'].'][]" style="width: 200px;"size="200">'.$row['vKeterangan'].'</textarea>';
												}else{
													echo $row['vKeterangan'];
												}
											}else{
												if($istatus==0){
													echo '<textarea class="" id="filekt1"name="fileketerangan['.$row['id_doklis'].'][]" style="width: 200px;"size="200">'.$row['vKeterangan'].'</textarea>';
												}else{
													echo $row['vKeterangan'];
												}
											}	

										?>
											
									<?php

										}else{
											if($istatus==0){
									 ?>
										<textarea class="" id="filekt1"name="fileketerangan[<?php echo $row['id_doklis'] ?>][]" style="width: 200px;"size="200"><?php  echo $row['vKeterangan'] ?></textarea>
									<?php 
											}
										}
									 ?>

									
								</td>
								<td style="border: 1px solid #dddddd; width: 10%">
									<?php 
									$read=$istatus==1?'disabled="disabled"':'';
									$checked=$istatus==1?'checked':'';
									if($row['iPerlu']==0){
										echo '<input type="checkbox" class="" name="sudah['.$row['id_doklis'].'] ?>][]" style="width: 90%" value="1" '.$read.' '.$checked.'>Status Upload';
										echo '<input type="hidden" name="istatus_keberadaan_update['.$row['id_doklis'].'] ?>]" value="1" />';
									}else{
										if($tersedia==1){
											echo '<input type="checkbox" class="" name="sudah['.$row['id_doklis'].'] ?>][]" style="width: 90%" value="1" '.$read.' '.$checked.'>Status Upload';
											echo '<input type="hidden" name="istatus_keberadaan_update['.$row['id_doklis'].'] ?>]" value="1" />';
										}
									}
									?>						
								</td>
							</tr>
						<?php
						$i++;
					}
				}
				?>
					</tbody>
					<tfoot>
						<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; background:#b3d2ea">
							<td colspan="10" style="border: 1px solid #dddddd; width: 3%; text-align: left;">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
</div>



