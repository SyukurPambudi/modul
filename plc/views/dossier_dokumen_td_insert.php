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

function add_file_memo_dossier_dok_td(table_id, id_negara, namefile){
	var row_memo = '';
		row_memo += '<tr><td>';
		row_memo += '<input type="file" class="fileupload multi multifile required" name="'+namefile+'[]" style="width: 90%" />';
		row_memo += '</td><td>';
		row_memo += '<span class="delete_btn_file_memo"><a href="javascript:;" id="table_memo_<?php echo $path ?>'+id_negara+'" onclick="del_row12(this, \'table_memo_<?php echo $path ?>'+id_negara+'\', '+id_negara+')">[Hapus]</a></span>';
		row_memo += '</td></tr>';
	jQuery("#"+table_id).append(row_memo);
}

function add_dokumen_memo_dossier_dok_td(table_id, id_negara, namefile){
	var n = $("span."+table_id+"_num:last").text();
	var r = n + 1; 
	var row_dokumen = '';
		row_dokumen += '<tr><td>';
		row_dokumen += '<input type="text" name="'+namefile+'[]" id="'+namefile+'_'+r+'" class="required" />';
		row_dokumen += '</td><td>';
		row_dokumen += '<span class="delete_btn_dokumen_memo"><a href="javascript:;" id="delete_dokumen_memo<?php echo $path; ?>'+id_negara+'" onclick="del_row12(this, \'table_dokumen_memo_<?php echo $path; ?>'+id_negara+'\', '+id_negara+')">[Hapus]</a></span>';
		row_dokumen += '</td></tr>';
	jQuery("#"+table_id).append(row_dokumen);
}
function add_asal_memo_dossier_dok_td(table_id, id_negara, namefile){
	var n = $("span."+table_id+"_num:last").text();
	var r = n + 1; 
	var row_dokumen = '';
		row_dokumen += '<tr><td>';
		row_dokumen += '<input type="text" name="'+namefile+'[]" id="'+namefile+'_'+r+'" class="required" />';
		row_dokumen += '</td><td>';
		row_dokumen += '<span class="delete_btn_dokumen_memo"><a href="javascript:;" id="delete_dokumen_memo<?php echo $path; ?>'+id_negara+'" onclick="del_row12(this, \'table_dokumen_memo_<?php echo $path; ?>'+id_negara+'\', '+id_negara+')">[Hapus]</a></span>';
		row_dokumen += '</td></tr>';
	jQuery("#"+table_id).append(row_dokumen);
}


function del_row12(ini, table_memo, id_negara){
	custom_confirm('Delete Selected Record?', function(){
		var tr =$(ini).parent().parent().parent();
		var td = tr.parent().parent();
		var r = td.find('tbody').children().length;
		if(r>=2){
			tr.remove();
		}else{
			_custom_alert("Tidak Bisa di Hapus!<br> Minimal 1 Upload!","Info","Info");
		}
	});
}

function add_dokumen_td_insert(table_id,id_negara){
	var row = $('table#table_create_'+table_id+' tbody tr.dossier_upload:last').clone();
	$("span."+table_id+"_num:first").text('1');
	var n = $("span."+table_id+"_num:last").text();
	tgl = '<?php echo date("Y-m-d"); ?>';
	if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	  	+= '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;" class="dossier_upload">';
			row_content 	+= '<td style="border: 1px solid #dddddd; width: 5%; text-align: center;">';
			row_content		+= '<span class="<?php echo $path?>'+id_negara+'_num">'+c+'</span>';
			row_content		+= '</td>';
			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 40%">';
			row_content	 	+= '<table id="table_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" width="100%"><tbody><tr><td>';
			row_content		+= '<input type="file" class="fileupload multi multifile required" name="fileupload_memo_<?php echo $path; ?>'+id_negara+'_'+c+'[]" style="width: 90%" />';
			row_content		+= '</td><td><span class="delete_btn_file_memo"><a href="javascript:;" id="table_<?php echo $path; ?>'+id_negara+'" onclick="del_row12(this, \'table_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\', '+id_negara+')">[Hapus]</a></span>';
			row_content		+= '</td></tr></tbody><tfoot><tr><td></td><td><span class="add_file_memo">';
			row_content		+= '<a href="javascript:;" onclick="javascript:add_file_memo_dossier_dok_td(\'table_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\','+id_negara+', \'fileupload_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\')">Tambah</a>';
			row_content		+= '</span></td></tr></tfoot></table>';
			row_content		+= '</td>';
			
			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content		+= '<table id="table_asal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" width="100%">';
			row_content		+= '<tbody><tr><td>';
			row_content 	+= '<input type="text" name="vasal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'[]" id="vasal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" class="required" />';
			row_content 	+= '</td><td>';
			row_content 	+= '<span class="delete_btn_asal_memo"><a href="javascript:;" id="delete_asal_memo<?php echo $path; ?>'+id_negara+'_'+c+'" onclick="del_row12(this, \'table_asal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\', '+id_negara+')">[Hapus]</a></span>';
			row_content		+= '</td></tr></tbody><tfoot><tr><td></td><td><span class="add_asal_memo">';
			row_content 	+= '<a href="javascript:;" onclick="javascript:add_asal_memo_<?php echo $path; ?>(\'table_asal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\','+id_negara+', \'vasal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\')">Tambah</a>';
			row_content 	+= '</span></td></tr></tfoot></table>';
			row_content		+= '</td>';

			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content		+= '<table id="table_dokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" width="100%">';
			row_content		+= '<tbody><tr><td>';
			row_content 	+= '<input type="text" name="vdokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'[]" id="vdokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" class="required" />';
			row_content 	+= '</td><td>';
			row_content 	+= '<span class="delete_btn_dokumen_memo"><a href="javascript:;" id="delete_dokumen_memo<?php echo $path; ?>'+id_negara+'_'+c+'" onclick="del_row12(this, \'table_dokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\', '+id_negara+')">[Hapus]</a></span>';
			row_content		+= '</td></tr></tbody><tfoot><tr><td></td><td><span class="add_dokumen_memo">';
			row_content 	+= '<a href="javascript:;" onclick="javascript:add_dokumen_memo_<?php echo $path; ?>(\'table_dokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\','+id_negara+', \'vdokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\')">Tambah</a>';
			row_content 	+= '</span></td></tr></tfoot></table>';
			row_content		+= '</td><td>';
			row_content		+= '<select id="<?php echo $path ?>'+id_negara+'_cpic_'+c+'" name="cpic_<?php echo $path; ?>['+id_negara+'][]" class="required">';
			row_content		+= '<option value="">Pilih PIC</option>';
							<?php
								foreach ($pic as $kpic => $vpic) {?>
			row_content 	+= '<option value="<?php echo $vpic["cNip"] ?>"><?php echo $vpic["vName"] ?></option>';
								<?php }
							?>
			row_content		+= '</select>';
			row_content		+= '</td>';
			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 10%">';
			row_content		+= '<input type="hidden" id="<?php echo $path ?>'+id_negara+'_dreq_'+c+'" name="dreq_<?php echo $path ?>['+id_negara+'][]" size="25" value="'+tgl+'" /><?php echo date("Y-m-d") ?>';
			row_content		+= '</td><td style="border: 1px solid #dddddd; width: 5%">';
			row_content		+= '<span class="delete_btn"><a href="javascript:;" class="<?php echo $path ?>'+id_negara+'_del_'+c+'" onclick="del_row1(this, \'<?php echo $path ?>'+id_negara+'_del_'+c+'\')">[Hapus]</a></span></td></tr>';

			jQuery("#table_create_"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  	+= '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;" class="dossier_upload">';
			row_content 	+= '<td style="border: 1px solid #dddddd; width: 5%; text-align: center;">';
			row_content		+= '<span class="<?php echo $path?>'+id_negara+'_num">'+c+'</span>';
			row_content		+= '</td>';
			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 40%">';
			row_content	 	+= '<table id="table_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" width="100%"><tbody><tr><td>';
			row_content		+= '<input type="file" class="fileupload multi multifile required" name="fileupload_memo_<?php echo $path; ?>'+id_negara+'_'+c+'[]" style="width: 90%" />';
			row_content		+= '</td><td><span class="delete_btn_file_memo"><a href="javascript:;" id="table_<?php echo $path; ?>'+id_negara+'" onclick="del_row12(this, \'table_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\', '+id_negara+')">[Hapus]</a></span>';
			row_content		+= '</td></tr></tbody><tfoot><tr><td></td><td><span class="add_file_memo">';
			row_content		+= '<a href="javascript:;" onclick="javascript:add_file_memo_dossier_dok_td(\'table_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\','+id_negara+', \'fileupload_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\')">Tambah</a>';
			row_content		+= '</span></td></tr></tfoot></table>';
			row_content		+= '</td>';


			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content		+= '<table id="table_asal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" width="100%">';
			row_content		+= '<tbody><tr><td>';
			row_content 	+= '<input type="text" name="vasal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'[]" id="vasal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" class="required" />';
			row_content 	+= '</td><td>';
			row_content 	+= '<span class="delete_btn_asal_memo"><a href="javascript:;" id="delete_asal_memo<?php echo $path; ?>'+id_negara+'_'+c+'" onclick="del_row12(this, \'table_asal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\', '+id_negara+')">[Hapus]</a></span>';
			row_content		+= '</td></tr></tbody><tfoot><tr><td></td><td><span class="add_asal_memo">';
			row_content 	+= '<a href="javascript:;" onclick="javascript:add_asal_memo_<?php echo $path; ?>(\'table_asal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\','+id_negara+', \'vasal_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\')">Tambah</a>';
			row_content 	+= '</span></td></tr></tfoot></table>';
			row_content		+= '</td>';

			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content		+= '<table id="table_dokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" width="100%">';
			row_content		+= '<tbody><tr><td>';
			row_content 	+= '<input type="text" name="vdokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'[]" id="vdokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'" class="required" />';
			row_content 	+= '</td><td>';
			row_content 	+= '<span class="delete_btn_dokumen_memo"><a href="javascript:;" id="delete_dokumen_memo<?php echo $path; ?>'+id_negara+'_'+c+'" onclick="del_row12(this, \'table_dokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\', '+id_negara+')">[Hapus]</a></span>';
			row_content		+= '</td></tr></tbody><tfoot><tr><td></td><td><span class="add_dokumen_memo">';
			row_content 	+= '<a href="javascript:;" onclick="javascript:add_dokumen_memo_<?php echo $path; ?>(\'table_dokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\','+id_negara+', \'vdokumen_memo_<?php echo $path; ?>'+id_negara+'_'+c+'\')">Tambah</a>';
			row_content 	+= '</span></td></tr></tfoot></table>';
			row_content		+= '</td><td>';
			row_content		+= '<select id="<?php echo $path ?>'+id_negara+'_cpic_'+c+'" name="cpic_<?php echo $path; ?>['+id_negara+'][]" class="required">';
			row_content		+= '<option value="">Pilih PIC</option>';
							<?php
								foreach ($pic as $kpic => $vpic) {?>
			row_content 	+= '<option value="<?php echo $vpic["cNip"] ?>"><?php echo $vpic["vName"] ?></option>';
								<?php }
							?>
			row_content		+= '</select>';
			row_content		+= '</td>';
			row_content		+= '<td colspan="1" style="border: 1px solid #dddddd; width: 10%">';
			row_content		+= '<input type="hidden" id="<?php echo $path ?>'+id_negara+'_dreq_'+c+'" name="dreq_<?php echo $path ?>['+id_negara+'][]" size="25" value="'+tgl+'" /><?php echo date("Y-m-d") ?>';
			row_content		+= '</td><td style="border: 1px solid #dddddd; width: 5%">';
			row_content		+= '<span class="delete_btn"><a href="javascript:;" class="<?php echo $path ?>'+id_negara+'_del_'+c+'" onclick="del_row1(this, \'<?php echo $path ?>'+id_negara+'_del_'+c+'\')">[Hapus]</a></span></td></tr>';

			$('table#table_create_'+table_id+' tbody tr.dossier_upload:last').after(row_content);
			$("span."+table_id+"_num:last").text(c);
		}
}

</script>
<div class="tab">
	<?php
		$vn['idossier_negara_id']=0;
		foreach($mnnegara as $t => $vn) {
			if($vn['idossier_negara_id']==""){
				$vn['idossier_negara_id']=0;
			}
		}
	?>	
	<div id="create_<?php echo $path.$vn['idossier_negara_id'] ?>" class="margin_0">
		<div style="overflow:auto;">
			<table class="hover_table" id="table_create_<?php echo $path.$vn['idossier_negara_id'] ?>" cellspacing="0" cellpadding="1" style="border: 1px solid #548cb6; text-align: center; margin-left: 5px; border-collapse: collapse">
				<thead>
				<tr style="width: 100%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse; color:white;">
					<th style="border: 1px solid #dddddd; width: 5%;">No</th>
					<th style="border: 1px solid #dddddd; width: 40%;">Dokumen yg dibutuhkan</th>
					<th style="border: 1px solid #dddddd; width: 40%;">Asal TD dari buyer/MOH</th>
					<th style="border: 1px solid #dddddd; width: 20%;">Keterangan</th>
					<th style="border: 1px solid #dddddd; width: 20%;">PIC Requestor</th>
					<th style="border: 1px solid #dddddd; width: 10%;">Tgl Request</th>
					<th style="border: 1px solid #dddddd; width: 5%;">Action</th>
				</thead>
				<tbody>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;" class="dossier_upload">
						<td style="border: 1px solid #dddddd; width: 5%; text-align: center;">
							<span class="<?php echo $path.$vn['idossier_negara_id'] ?>_num">1</span>
						</td>
						<td colspan="1" style="border: 1px solid #dddddd; width: 40%">
							<table id="table_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1" width="100%">
								<tbody>
									<tr>
										<td>
											<input type="file" class="fileupload multi multifile required" name="fileupload_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1[]" style="width: 90%" />
										</td>
										<td>
							   				<span class="delete_btn_file_memo"><a href="javascript:;" id="table_<?php echo $path.$vn['idossier_negara_id'] ?>" onclick="del_row12(this, 'table_memo_<?php echo $path.$vn['idossier_negara_id'] ?>', <?php echo $vn['idossier_negara_id'] ?>)">[Hapus]</a></span>
							   			</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td>
											<span class="add_file_memo">
												<a href="javascript:;" onclick="javascript:add_file_memo_<?php echo $path; ?>('table_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1',<?php echo $vn['idossier_negara_id'] ?>, 'fileupload_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1')">Tambah</a>
											</span>
										</td>
									</tr>
								</tfoot>
							</table>
							
						</td>
						<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
							<table id="table_asal_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1" width="100%">
								<tbody>
									<tr>
										<td>
											<input type="text" name="vasal_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1[]" id="vasal_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1" class="required" />
										</td>
										<td>
							   				<span class="delete_btn_asal_memo"><a href="javascript:;" id="delete_asal_memo<?php echo $path.$vn['idossier_negara_id'] ?>" onclick="del_row12(this, 'table_asal_memo_<?php echo $path.$vn['idossier_negara_id'] ?>', <?php echo $vn['idossier_negara_id'] ?>)">[Hapus]</a></span>
							   			</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td>
											<span class="add_asal_memo">
												<a href="javascript:;" onclick="javascript:add_asal_memo_<?php echo $path; ?>('table_asal_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1',<?php echo $vn['idossier_negara_id'] ?>, 'vasal_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1')">Tambah</a>
											</span>
										</td>
									</tr>
								</tfoot>
							</table>
						</td>

						<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
							<table id="table_dokumen_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1" width="100%">
								<tbody>
									<tr>
										<td>
											<input type="text" name="vdokumen_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1[]" id="vdokumen_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1" class="required" />
										</td>
										<td>
							   				<span class="delete_btn_dokumen_memo"><a href="javascript:;" id="delete_dokumen_memo<?php echo $path.$vn['idossier_negara_id'] ?>" onclick="del_row12(this, 'table_dokumen_memo_<?php echo $path.$vn['idossier_negara_id'] ?>', <?php echo $vn['idossier_negara_id'] ?>)">[Hapus]</a></span>
							   			</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td>
											<span class="add_dokumen_memo">
												<a href="javascript:;" onclick="javascript:add_dokumen_memo_<?php echo $path; ?>('table_dokumen_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1',<?php echo $vn['idossier_negara_id'] ?>, 'vdokumen_memo_<?php echo $path.$vn['idossier_negara_id'] ?>_1')">Tambah</a>
											</span>
										</td>
									</tr>
								</tfoot>
							</table>
						</td>
						<td>
							<select id="<?php echo $path.$vn['idossier_negara_id'] ?>_cpic_1" name="cpic_<?php echo $path; ?>[<?php echo $vn['idossier_negara_id']; ?>][]" class="required">
								<option value="">Pilih PIC</option>
							<?php
								foreach ($pic as $kpic => $vpic) {
									echo "<option value='".$vpic['cNip']."'>".$vpic['vName']."</option>";
								}
							?>
							</select>
						</td>
						<td colspan="1" style="border: 1px solid #dddddd; width: 10%">
							<input type="hidden" id="<?php echo $path.$vn['idossier_negara_id'] ?>_dreq_1" name="dreq_<?php echo $path ?>[<?php echo $vn['idossier_negara_id']; ?>][]" size="25" value="<?php echo date('Y-m-d') ?>" />
							<?php echo date('Y-m-d') ?>
						</td>
						<td style="border: 1px solid #dddddd; width: 5%">
							<span class="delete_btn"><a href="javascript:;" class="<?php echo $path.$vn['idossier_negara_id'] ?>_del_1" onclick="del_row1(this, '<?php echo $path.$vn['idossier_negara_id'] ?>_del_1')">[Hapus]</a></span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5"></td><td style="text-align: center">
							<?php if ($this->input->get('action') != 'view') { ?>
								<a href="javascript:;" onclick="javascript:add_dokumen_td_insert('<?php echo $path.$vn['idossier_negara_id'] ?>',<?php echo $vn['idossier_negara_id'] ?>)">Tambah</a>	
								<?php
								 } ?>
							
						</td>
					</tr>
				</tfoot>	
			</table>			
		</div>
	</div>
	<?php
	
	?>
</div>