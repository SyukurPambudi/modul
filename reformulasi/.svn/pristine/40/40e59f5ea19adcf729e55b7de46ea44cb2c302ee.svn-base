<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table1_'.$id;
?>
<script>
$("#<?php echo $tableId;?> .fileupload1_lokal_skala_lab_file_disolusi").MultiFile();
$("#<?php echo $tableId;?> .file_remove1").click(function(){
	var li = $(this).closest('li');
	var fileid_lokal_skala_lab_file_disolusi1 = li.attr('fileid_lokal_skala_lab_file_disolusi1');
	var tmpDel = $("#study_pd_del1");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid_lokal_skala_lab_file_disolusi1;
	tmpDel.val( v );
	alert( $("#study_pd_del1").val() );
});

function add_row_lokal_skala_lab_file_disolusiss1(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_numasd:first").text('1');
		var n = $("span."+table_id+"_numasd:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_numasd">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" id="fileupload1_lokal_skala_lab_file_disolusi'+table_id+c+'" class="fileupload1_lokal_skala_lab_file_disolusi multi multifile " name="fileid_lokal_skala_lab_file_disolusi_upload_lokal_skala_lab_file_disolusi[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namefile_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="" /></td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea id= "filekt1'+c+'" class="" name="fileketerangan_lokal_skala_lab_file_disolusi[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len1'+c+'">250</span> karakter<br/></td>';
			
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="study_pd_del1" onclick="del_row(this, \'study_pd_del1\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_numasd">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content	 += '<input type="file" id="fileupload1_lokal_skala_lab_file_disolusi'+table_id+c+'" class="fileupload1_lokal_skala_lab_file_disolusi multi multifile " name="fileid_lokal_skala_lab_file_disolusi_upload_lokal_skala_lab_file_disolusi[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namefile_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="" /></td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea id= "filekt1'+c+'" class="" name="fileketerangan_lokal_skala_lab_file_disolusi[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len1'+c+'">250</span> karakter<br/></td>';
			

			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="study_pd_del1" onclick="del_row(this, \'study_pd_del1\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_numasd:last").text(c);		
		}
				$("#filekt1"+c).keyup(function() {
					var len = this.value.length;
					if (len >= 250) {
					this.value = this.value.substring(0, 250);
					}
					$("#len1"+c).text(250 - len);
				});
				$("#fileupload1_lokal_skala_lab_file_disolusi"+table_id+c).change(function () {
			        var fileExtension = ["pdf","docx","xlsx","jpeg", "jpg", "png"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

}
</script>

<table class="hover_table" id="lokal_skala_lab_file_disolusi" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 
			1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">File Analisa Disolusi  </span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd;  border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Pilih File</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Keterangan</th>

		<th style="border: 1px solid #dddddd; width: 10%;">Action</th>		
	</tr>
	</thead>
	<tbody>
		<?php
		
			$i = 1;
			$linknya = "";
			if(!empty($rows)) {

				foreach($rows as $row) {
					//tambahan untuk download file
					$id  = $row['ilokal_refor_skala_lab'];
					$value = $row['vFilename'];	
					if($value != '') {
						if (file_exists('./files/reformulasi/local/skala_lab/disolusi/'.$id.'/'.$value)) {
							$link = base_url().'processor/reformulasi/lokal/skala/lab?action=download&filepath=disolusi&id='.$id.'&file='.$value;
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
						<span class="lokal_skala_lab_file_disolusi_numasd"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vFilename'] ?> 
						<input type="hidden" name="namefile_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="<?php echo $row['vFilename'] ?>" />
						<input type="hidden" name="fileid_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="<?php echo $row['ilocal_refor_skala_lab_file'] ?>" />
					</td>

					<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['tKeterangan'] ?>
					</td>

					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { ?>
							<span class="delete_btn"><a href="javascript:;" class="study_pd_del1" onclick="del_row1(this, 'study_pd_del1')">[Hapus]</a></span>	
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
						<td colspan="4"style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span>Tidak ada file diupload</span>
						</td>		
					</tr>

					

				<?php 
				}else{
			//$i++;
		?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="lokal_skala_lab_file_disolusi_numasd">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileupload1_lokal_skala_lab_file_disolusi_study_pd_1" class="fileupload1_lokal_skala_lab_file_disolusi multi multifile " name="fileid_lokal_skala_lab_file_disolusi_upload_lokal_skala_lab_file_disolusi[]" style="width: 70%" /> *
						<input type="hidden" name="namefile_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid_lokal_skala_lab_file_disolusi[]" style="width: 70%" value="" />
						</td>	

						<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" id="filekt1" name="fileketerangan_lokal_skala_lab_file_disolusi[]" style="width: 240px; height: 50px;"size="250">
							
						</textarea>
						<br/>
						tersisa <span id="len1">250</span> karakter<br/>

					</td>

					<td style="border: 1px solid #dddddd; width: 5%">
						<span class="delete_btn"><a href="javascript:;" class="study_pd_del1" onclick="del_row(this, 'study_pd_del1')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" style="text-align: left">*) Max File 5 MB : Format = pdf, docx, xlsx, jpeg, jpg, png</td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<a href="javascript:;" onclick="javascript:add_row_lokal_skala_lab_file_disolusiss1('lokal_skala_lab_file_disolusi')">Tambah</a>	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>


<script>
	$('#filekt1').keyup(function() {
	var len = this.value.length;
	if (len >= 250) {
	this.value = this.value.substring(0, 250);
	}
	$('#len1').text(250 - len);
	});
	$("#fileupload1_lokal_skala_lab_file_disolusi_study_pd_1").change(function () {
       var fileExtension = ["pdf","docx","xlsx","jpeg", "jpg", "png"];
        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "study_pd", 1, 20000);
        	$(this).val('');
        }
	});
</script>