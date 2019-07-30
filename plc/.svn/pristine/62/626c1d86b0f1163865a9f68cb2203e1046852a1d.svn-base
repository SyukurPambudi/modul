<?php
$idpath="realtime_stabilita_non_terbalik";
?>
<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<script>

function add_row_realtime_stabilita_non_terbalik_upload(table_id,idossier_dok_list_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span.<?php echo $idpath; ?>"+idossier_dok_list_id+"_num:first").text('1');
		var n = $("span.<?php echo $idpath; ?>"+idossier_dok_list_id+"_num:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="<?php echo $idpath; ?>'+idossier_dok_list_id+'_num">'+c+'</span>';			
			row_content	 += '</td><td colspan="1" style="border: 1px solid #dddddd; width: 27%">';
			row_content	 += '<input type="file" id="<?php echo $idpath; ?>'+idossier_dok_list_id+'_fileupload_'+c+'" class="fileupload multi multifile required" name="<?php echo $idpath; ?>_'+idossier_dok_list_id+'_fileupload[]" style="width: 70%" /> *';
			row_content  += '<input type="hidden" name="<?php echo $idpath; ?>_namafile['+idossier_dok_list_id+'][]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="<?php echo $idpath; ?>_fileid['+idossier_dok_list_id+'][]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '<textarea class="" id="<?php echo $idpath; ?>'+idossier_dok_list_id+'_filekt_'+c+'"name="<?php echo $idpath; ?>_fileketerangan['+idossier_dok_list_id+'][]" style="width: 240px; height: 50px;"size="250"></textarea><br/>tersisa <span id="<?php echo $idpath; ?>'+idossier_dok_list_id+'_len_'+c+'">250</span> karakter<br/></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $idpath; ?>'+idossier_dok_list_id+'_del" onclick="del_row(this, \'<?php echo $idpath; ?>'+idossier_dok_list_id+'_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="<?php echo $idpath; ?>'+idossier_dok_list_id+'_num">'+c+'</span>';			
			row_content	 += '</td><td colspan="1" style="border: 1px solid #dddddd; width: 27%">';
			row_content	 += '<input type="file" id="<?php echo $idpath; ?>'+idossier_dok_list_id+'_fileupload_'+c+'" class="fileupload multi multifile required" name="<?php echo $idpath; ?>_'+idossier_dok_list_id+'_fileupload[]" style="width: 70%" /> *';
			row_content  += '<input type="hidden" name="<?php echo $idpath; ?>_namafile['+idossier_dok_list_id+'][]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="<?php echo $idpath; ?>_fileid['+idossier_dok_list_id+'][]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '<textarea class="" id="<?php echo $idpath; ?>'+idossier_dok_list_id+'_filekt_'+c+'" name="<?php echo $idpath; ?>_fileketerangan['+idossier_dok_list_id+'][]" style="width: 240px; height: 50px;"size="250"></textarea><br/>tersisa <span id="<?php echo $idpath; ?>'+idossier_dok_list_id+'_len_'+c+'">250</span> karakter<br/></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $idpath; ?>'+idossier_dok_list_id+'_del" onclick="del_row(this, \'<?php echo $idpath; ?>'+idossier_dok_list_id+'_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span.<?php echo $idpath; ?>"+idossier_dok_list_id+"_num:last").text(c);		
		}
				$("#<?php echo $idpath; ?>"+idossier_dok_list_id+"_filekt_"+c).keyup(function() {
					var len = this.value.length;
					if (len >= 250) {
					this.value = this.value.substring(0, 250);
					}
					$('#<?php echo $idpath; ?>'+idossier_dok_list_id+'_len_'+c).text(250 - len);
				});
				$("#<?php echo $idpath; ?>"+idossier_dok_list_id+"_fileupload_"+c).change(function () {
			        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

}
</script>
<div class="tab">
	<ul>
	<?php
		foreach($mnnegara as $t => $vn) {
			echo '<li>
					  <a href="#'.$idpath.$vn['idossier_negara_id'].'">'.$vn['vNama_Negara'].'</a>
				  </li>';
		}
	?>	
	</ul>
	<?php
	foreach($mnnegara as $t => $vn) {	
		$idossier_dok_list_id="";
		foreach ($dokumen as $kdok => $vdok) {
			$idossier_dok_list_id=$vdok['idossier_negara_id']==$vn['idossier_negara_id']?$vdok["idossier_dok_list_id"]:"";
			if($vdok['idossier_negara_id']==$vn['idossier_negara_id']){
				$sql="select * from dossier.dossier_dok_list_file fil 
						where fil.lDeleted=0 and fil.idossier_dok_list_id=".$idossier_dok_list_id;
				$data=$this->db_plc0->query($sql);

			?>
			<div id="<?php echo $idpath.$vn['idossier_negara_id'] ?>" class="margin_0">
				<div style="overflow:auto;">
					<table class="hover_table" id="table_<?php echo $idpath."_".$idossier_dok_list_id ?>" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
					<thead>
					<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
						<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Tambahan</span></th>
					</tr>
					<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
						<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
						<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Pilih File</th>
						<th colspan="3" style="border: 1px solid #dddddd;width: 50%;">Keterangan</th>
						<th style="border: 1px solid #dddddd; width: 20%;">Action</th>		
					</tr>
					</thead>
					
					<tbody>
					<?php
					
						$i = 1;
						$linknya = "";
						if($data->num_rows()>=1) {
							foreach($data->result_array() as $row) {
								//tambahan untuk download file
								$id  = $vn['idossier_review_id'];
								$value = $row['vFilename'];	
								if($value != '') {
									if (file_exists('./files/plc/dossier_dok/'.$id.'/'.$value)) {
										$link = base_url().'processor/plc/stabilita/terbalik?action=download&id='.$id.'&file='.$value;
										$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
									}
									else {
										$linknya = 'File sudah tidak ada!';
									}
								}
								else {

									$file = 'No File';
								}	
						//selesai tambahan download
					?>
							<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
								<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
									<span class="<?php echo $idpath.$row['idossier_dok_list_id']; ?>_num"><?php echo $i ?></span>
								</td>		
								<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
									<?php echo $row['vFilename'] ?> 
									<input type="hidden" name="<?php echo $idpath; ?>_namafile[<?php echo $row['idossier_dok_list_id']; ?>][]" style="width: 70%" value="<?php echo $row['vFilename'] ?>" />
									<input type="hidden" name="<?php echo $idpath; ?>_fileid[<?php echo $row['idossier_dok_list_id']; ?>][]" style="width: 70%" value="<?php echo $row['idossier_dok_list_file_id'] ?>" />
								</td>	
								<td colspan="3" style="border: 1px solid #dddddd; width: 8%"`>
									<?php echo $row['vKeterangan'] ?>
								</td>
								<td style="border: 1px solid #dddddd; width: 10%">
									<?php if ($this->input->get('action') != 'view') { 
										if($vdok["istatus_verifikasi"]==0 && $vdok["istatus_verifikasi"]==0) {
										?>
										<span class="delete_btn"><a href="javascript:;" class="<?php echo $idpath; ?>_del" onclick="del_row(this, '<?php echo $idpath; ?>_del')">[Hapus]</a></span>	
									<?php	
										}
										} ?>
									
									<span class="delete_btn"><?php echo $linknya ?></span>						
								</td>		
							</tr>
					<?php
						$i++;	
							}

						}
						else {

							if ($this->input->get('action') == 'view') {
								//untuk view yang tidak ada file upload sama sekali
							?>
								<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
									<td colspan="6"style="border: 1px solid #dddddd; width: 3%; text-align: center;">
										<span>Tidak ada file diupload</span>
									</td>		
								</tr>

								

							<?php 
							}else{
								if($vdok["istatus_verifikasi"]==0 && $vdok["istatus_verifikasi"]==0) {
					?>
							<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
								<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
									<span class="<?php echo $idpath.$idossier_dok_list_id; ?>_num">1</span>
								</td>		
								<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
									<input type="file" id="<?php echo $idpath.$idossier_dok_list_id; ?>_fileupload_1" class="fileupload multi multifile required" name="<?php echo $idpath.'_'.$idossier_dok_list_id; ?>_fileupload[]" style="width: 70%" /> *
									<input type="hidden" name="<?php echo $idpath; ?>_namafile[<?php echo $idossier_dok_list_id; ?>][]" style="width: 70%" value="" />
									<input type="hidden" name="<?php echo $idpath; ?>_fileid[<?php echo $idossier_dok_list_id; ?>][]" style="width: 70%" value="" />
									</td>	
								<td colspan="3" style="border: 1px solid #dddddd; width: 15%">
									<textarea class="" id="<?php echo $idpath.$idossier_dok_list_id;; ?>_filekt_1" name="<?php echo $idpath; ?>_fileketerangan[<?php echo $idossier_dok_list_id; ?>][]" style="width: 240px; height: 50px;"size="250"></textarea>
									<br/>
									tersisa <span id="<?php echo $idpath.$idossier_dok_list_id; ?>_len_1">250</span> karakter<br/>
								</td>
								<td style="border: 1px solid #dddddd; width: 10%">
									<span class="delete_btn"><a href="javascript:;" class="<?php echo $idpath.$idossier_dok_list_id; ?>_del" onclick="del_row(this, '<?php echo $idpath.$idossier_dok_list_id; ?>_del')">[Hapus]</a></span>
								</td>	
							</tr>
					<?php 
								}else{
									echo "<tr><td colspan='6'>File Sudah Di Verifikasi</td></tr>";
								}
					} 
				}?>
				</tbody>
				<tfoot>
					<tr>
						<?php if($vdok["istatus_verifikasi"]==0 && $vdok["istatus_verifikasi"]==0) { ?>
						<td colspan="5" style="text-align: left">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
							<?php if ($this->input->get('action') != 'view') { ?>
								<a href="javascript:;" onclick="javascript:add_row_<?php echo $idpath; ?>_upload('table_<?php echo $idpath."_".$idossier_dok_list_id; ?>',<?php echo $idossier_dok_list_id; ?>)">Tambah</a>	
							<?php } ?>
							
						</td>
						<?php } ?>
					</tr>
				</tfoot>

				</table>
				</div>
			</div>
			<script>
				$("#<?php echo $idpath.$idossier_dok_list_id; ?>_filekt_1").keyup(function() {
				var len = this.value.length;
				if (len >= 250) { 
				this.value = this.value.substring(0, 250);
				}
				$('#<?php echo $idpath.$idossier_dok_list_id; ?>_len_1').text(250 - len);
				});
				$("#<?php echo $idpath.$idossier_dok_list_id; ?>_fileupload_1").change(function () {
			        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "<?php echo $idpath; ?>_", 1, 20000);
			        	$(this).val('');
			        }
				});
			</script>
			<?php
			}
		}	
	}
	?>
</div>
