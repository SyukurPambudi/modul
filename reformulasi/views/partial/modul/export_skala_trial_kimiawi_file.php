<?php
	$mydept = $this->auth->my_depts(TRUE);
	$iM_modul_fileds 	= $form_field['iM_modul_fields'];
	$vPath_upload		= $form_field['vPath_upload'];
	$title 				= $form_field['vDesciption'];
?>

<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
//print_r($jenis_bk);
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#export_skala_trial_kimiawi_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#export_skala_trial_kimiawi_del").val() );
});
function del_export_skala_trial_kimiawi(dis, conname, table_id) {
	//if($('.'+conname).length > 1) {
		var j_p=0;
		var j_k=0;
		$(".pertama").each(function(){
 			j_p +=1;
		});
		$(".kedua").each(function(){
 			j_k +=1;
		});
		if((j_p<=1)){
			_custom_alert("File Upload Primer Minimal 1","INFO","INFO", "export_skala_trial_kimiawi", 1, 20000);
			return false;
		}else{
			custom_confirm('Delete Selected Record?', function(){
				$(dis).parent().parent().parent().remove();
			})
		}
}
function add_row_export_skala_trial_kimiawi(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var c=1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';		
			row_content	 += '<td style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" id="fileuploadbk'+c+'" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';	
			row_content	 += '<td style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="export_skala_trial_kimiawi_del" onclick="del_export_skala_trial_kimiawi(this, \'export_skala_trial_kimiawi_del\', \'export_skala_trial_kimiawi\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';	
			row_content	 += '<td style="border: 1px solid #dddddd; width: 30%">';
			row_content	 += '<input type="file" id="fileuploadbk'+c+'" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="export_skala_trial_kimiawi_del" onclick="del_export_skala_trial_kimiawi(this, \'export_skala_trial_kimiawi_del\', \'export_skala_trial_kimiawi\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
		$("#fileuploadbk"+c).change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
	        	$(this).val('');
	        }
	    });

}
</script>

<table class="hover_table" id="export_skala_trial_kimiawi" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">File <?php echo $title; ?></span></th>
		<input type="hidden" name="modul_fields" value="<?php echo $iM_modul_fileds; ?>">
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Pilih File</th>
		<th style="border: 1px solid #dddddd;">Keterangan</th>
		<th style="border: 1px solid #dddddd;">Action</th>		
	</tr>
	</thead>
	<tbody>
		<?php
			$i = 1;
			$linknya = "";
			if(!empty($rows)) {
				foreach($rows as $row) {
					$idsp  = $row['idHeader_File'];
					$value = $row['vFilename_generate'];
					if($value != '') {
						if (file_exists('./'.$vPath_upload.'/'.$idsp.'/'.$value)) {
							$link = base_url().'processor/reformulasi/v3/export/uji/kimiawi?action=download&id='.$idsp.'&path='.$vPath_upload.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
						} else {
							$linknya = 'File sudah tidak ada!';
						}
					} else {
						$file = 'No File';
					}	
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="export_skala_trial_kimiawi_num"><?php echo $i ?></span>
					</td>				
					<td style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vFilename'] ?> 
						<input type="hidden" name="namafile[]" style="width: 70%" value="<?php echo $row['vFilename'] ?>" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $row['iFile'] ?>" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['tKeterangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="export_skala_trial_kimiawi_del" onclick="del_export_skala_trial_kimiawi(this, 'export_skala_trial_kimiawi_del', 'export_skala_trial_kimiawi')">[Hapus]</a></span>
						<span class="delete_btn"><?php echo $linknya ?></span>
					</td>		
				</tr>
		<?php
					$i++;	
				}
			} else {
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="export_skala_trial_kimiawi_num">1</span>
					</td>
					<td style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileuploadbk1" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" /> *
						<input type="hidden" name="namafile[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="" />
						</td>	
					<td style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="export_skala_trial_kimiawi_del" onclick="del_export_skala_trial_kimiawi(this, 'export_skala_trial_kimiawi_del', 'export_skala_trial_kimiawi')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } ?>
	</tbody>

	<tfoot>
		<tr>
			<td colspan="2" style="text-align: left;">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
			<td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_export_skala_trial_kimiawi('export_skala_trial_kimiawi')">Tambah</a></td>
	</tfoot>
</table>

<script>
	 $("#fileuploadbk1").change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "export_skala_trial_kimiawi", 1, 20000);
	        	$(this).val('');
	        }
    	});

  	$("#fileuploadbk2").change(function () {
        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "export_skala_trial_kimiawi", 1, 20000);
        	$(this).val('');
        }
	});
	</script>