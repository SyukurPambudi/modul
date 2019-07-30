<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#study_ad_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#study_ad_del").val() );
});


$("#tgl1").datepicker({dateFormat:"yy-mm-dd"});
$("#tgl2").datepicker({dateFormat:"yy-mm-dd"});




function add_row_study_ad_upload(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		tgl = '<?php echo date("Y-m-d"); ?>';
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileupload_studyad[]" style="width: 70%" />';
			row_content  += '<input type="hidden" name="namafile_studyad[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_studyad[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea row="2" id= "filekt_studyad'+c+'" class="required" name="fileketerangan_studyad[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len_studyad'+c+'">250</span> karakter<br/></td>';
			row_content  += '<td colspan="1" style="border: 1px solid #dddddd; width: 5%"><input type="hidden" name="tglRequest[]"  id="tgll_'+c+'" value="'+tgl+'"/>'+tgl+'</td>';
		
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="study_ad_del" onclick="del_row(this, \'study_ad_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileupload_studyad[]" style="width: 70%" />';
			row_content  += '<input type="hidden" name="namafile_studyad[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_studyad[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea row="2" id= "filekt_studyad'+c+'"class="required" name="fileketerangan_studyad[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len_studyad'+c+'">250</span> karakter<br/>';
			row_content  += '</td>';
			row_content  += '<td colspan="1" style="border: 1px solid #dddddd; width: 5%"><input type="hidden" name="tglRequest[]"  id="tgll_'+c+'"  value="'+tgl+'"/>'+tgl+'</td>';
		

			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="study_ad_del" onclick="del_row(this, \'study_ad_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
				$("#filekt_studyad"+c).keyup(function() {
					var len = this.value.length;
					if (len >= 250) {
					this.value = this.value.substring(0, 250);
					}
					$("#len_studyad"+c).text(250 - len);
				});
				$("#fileupload"+table_id+c).change(function () {
			        var fileExtension = ["pdf","docx","xlsx","jpeg", "jpg", "png"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

			    $("#fileuploadDox"+table_id+c).change(function () {
			        var fileExtension = ["pdf","docx","xlsx"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

			    $("#tgllad_"+c).datepicker({	changeMonth:true,
					changeYear:true,
					dateFormat:"yy-mm-dd" 
					});
				$("#tgll_"+c).datepicker({	changeMonth:true,
					changeYear:true,
					dateFormat:"yy-mm-dd" 
					});


}
</script>

<table class="hover_table" id="study_ad_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="5" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 10%;">Upload Memo</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">Keterangan</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 5%;">Tgl Request</th>
		<th style="border: 1px solid #dddddd; width: 20%;">Action</th>		
	</tr>
	</thead>
	<tbody>
		<?php
		
			$i = 1;
			$linknya = "";
			if(!empty($rows)) {

				foreach($rows as $row) {
					//tambahan untuk download file
					$id  = $row['iupi_dok_td_id'];
							$value = $row['vMemo'];	
							if($value != '') {
								if (file_exists('./files/plc/import/td_file/'.$id.'/'.$value)) {
									$link = base_url().'processor/plc/import/tambahan/data?action=downloadMemo&id='.$id.'&filememo='.$value;
									$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">[Download]</a>';
								}
								else {
									$linknya = 'File sudah tidak ada!';
								}
							}
							else {

								$linknya = 'No File';
							}	
						?>
					<!-- $id  = $row['iupi_dok_td_id'];
					$value = $row['vMemo'];	
					if($value != '') {
						if (file_exists('./files/plc/import/td_file/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/tambahan/data/ad?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
						}
						else {
							$linknya = 'File sudah tidak ada!';
						}
					}
					else {

						$file = 'No File';
					}	 -->
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="study_ad_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
						<?php echo $row['vMemo'] ?> 
						<input type="hidden" name="namafile_studyad[]" style="width: 70%" value="<?php echo $row['vMemo'] ?>" />
						<input type="hidden" name="fileid_studyad[]" style="width: 70%" value="<?php echo $row['iMemo_id'] ?>" />
					</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 8%" row="2">
						<?php echo $row['vKeterangan'] ?>
					</td>

					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<?php echo $row['dTglrequest'] ?>
					</td>

					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { ?>
							<span class="delete_btn"><a href="javascript:;" class="study_ad_del" onclick="del_row1(this, 'study_ad_del')">[Hapus]</a></span>	
						<?php	} ?>
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
			//$i++;
		?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="study_ad_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
						<input type="file" id="fileupload_study_ad_1" class="fileupload multi multifile required" name="fileupload_studyad[]" style="width: 70%" />
						<input type="hidden" name="namafile_studyad[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid_studyad[]" style="width: 70%" value="" />
					</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="input_rows1 required" id="filekt_studyad1" name="fileketerangan_studyad[]" style="width: 240px;"size="250" row="2"></textarea>
						<br/>
						tersisa <span id="len_studyad1">250</span> karakter<br/>
					</td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<?php echo date('Y-m-d') ?>
						<input type="hidden" name="tglRequest[]"  id="tgll_1" readonly="readonly" class="input_rows1 required" size="12" value="<?php echo date('Y-m-d') ?>"/>
					</td>
					
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="study_ad_del" onclick="del_row1(this, 'study_ad_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align: left">*) Max File 5 MB : Format = pdf, docx, xlsx, jpeg, jpg, png</td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<a href="javascript:;" onclick="javascript:add_row_study_ad_upload('study_ad_upload')">Tambah</a>	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>


	<script>
		$('#filekt_studyad1').keyup(function() {
		var len = this.value.length;
		if (len >= 250) {
		this.value = this.value.substring(0, 250);
		}
		$('#len_studyad1').text(250 - len);
		});
		$("#fileupload_study_ad_1").change(function () {
	        var fileExtension = ["pdf","docx","xlsx","jpeg", "jpg", "png"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "study_ad", 1, 20000);
	        	$(this).val('');
	        }
    	});

    	 $("#fileuploadDox_study_ad_1").change(function () {
			        var fileExtension = ["pdf","docx","xlsx","jpeg", "jpg", "png"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

    	$("#tgllad_1").datepicker({	changeMonth:true,
				changeYear:true,
				dateFormat:"yy-mm-dd" 
			});
		$("#tgll_1").datepicker({	changeMonth:true,
				changeYear:true,
				dateFormat:"yy-mm-dd" 
			});


	</script>