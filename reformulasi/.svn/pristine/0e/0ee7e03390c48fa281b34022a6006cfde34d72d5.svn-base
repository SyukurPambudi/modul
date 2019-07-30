<?php
	$mydept = $this->auth->my_depts(TRUE);
	$vPath_upload 		= 'files/reformulasi/export/skala_trial';
	$title 				= 'Upload File';
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
	var tmpDel = $("#<?php echo $id; ?>_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#<?php echo $id; ?>_del").val() );
});
function del_<?php echo $id; ?>(dis, conname, table_id) {
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
			_custom_alert("File Upload Primer Minimal 1","INFO","INFO", "<?php echo $id; ?>", 1, 20000);
			return false;
		}else{
			custom_confirm('Delete Selected Record?', function(){
				$(dis).parent().parent().parent().remove();
			})
		}
}
function add_row_<?php echo $id; ?>(table_id){		
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
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $id; ?>_del" onclick="del_<?php echo $id; ?>(this, \'<?php echo $id; ?>_del\', \'<?php echo $id; ?>\')">[Hapus]</a></span></td>';		
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
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $id; ?>_del" onclick="del_<?php echo $id; ?>(this, \'<?php echo $id; ?>_del\', \'<?php echo $id; ?>\')">[Hapus]</a></span></td>';		
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

<table class="hover_table" id="<?php echo $id; ?>" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">File <?php echo $title; ?></span></th>
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
		//if (isset($mydept)) {}
		//print_r($mydept);
		$linknya = "";
		if (isset($mydept)) {
		if((in_array('BD', $mydept))||(in_array('QA', $mydept))||(in_array('BIC', $mydept)) ||(in_array('PD', $mydept)) ||(in_array('PPC', $mydept))) {
			if(!empty($rows)) {
			//print_r($rows);
				foreach($rows as $row) {
			//tambahan untuk download file
			$idsp  = $row['idHeader_File'];
			$value = $row['vFilename_generate'];
			if($value != '') {
				if (file_exists('./'.$vPath_upload.'/'.$idsp.'/'.$value)) {
					$link = base_url().'processor/reformulasi/v3/export/uji/fisik?action=download&id='.$idsp.'&path='.$vPath_upload.'&file='.$value;
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
						<span class="<?php echo $id; ?>_num"><?php echo $i ?></span>
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
						<span class="delete_btn"><a href="javascript:;" class="<?php echo $id; ?>_del" onclick="del_<?php echo $id; ?>(this, '<?php echo $id; ?>_del', '<?php echo $id; ?>')">[Hapus]</a></span>
						<span class="delete_btn"><?php echo $linknya ?></span>
					</td>		
				</tr>
		<?php
			$i++;	
				}

			}
			else {
			//$i++;
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="<?php echo $id; ?>_num">1</span>
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
						<span class="delete_btn"><a href="javascript:;" class="<?php echo $id; ?>_del" onclick="del_<?php echo $id; ?>(this, '<?php echo $id; ?>_del', '<?php echo $id; ?>')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php }
		} 	
		else
			{
			if(!empty($rows)) {	
			foreach($rows as $row) {
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="<?php echo $id; ?>_num"><?php echo $i ?></span>
					</td>						
					<td style="border: 1px solid #dddddd; width: 27%">
						<?php echo $linknya ?>
						<?php echo $row['filename'] ?> 
						</td>	
					<td style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['vketerangan'] ?>
					</td>
					</tr>
		<?php
			$i++;	
				}

			}
			else {
			//$i++;
		?>
			<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
				
			</tr>
		<?php }
				
			} 
			}?>
	</tbody>
	<tfoot>
		<?php //if((in_array('BD', $mydept))||(in_array('QA', $mydept)) ||(in_array('PD', $mydept))) {?>
		<tr>
			<td colspan="2" style="text-align: left;">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
			<td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_<?php echo $id; ?>('<?php echo $id; ?>')">Tambah</a></td>
		</tr><?php //}?>
	</tfoot>
</table>

<script>
	 $("#fileuploadbk1").change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "<?php echo $id; ?>", 1, 20000);
	        	$(this).val('');
	        }
    	});

  	$("#fileuploadbk2").change(function () {
        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "<?php echo $id; ?>", 1, 20000);
        	$(this).val('');
        }
	});
	</script>