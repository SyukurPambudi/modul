<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
$( "#button_show" ).click(function() {
	$( "#ihold_dok" ).show( "slow" );
	$( "#button_hide" ).show( "slow" );
	$("#cancel_btn").val("2");
});
$( "#button_hide" ).click(function() {
	$( "#ihold_dok" ).hide( "slow" );
	$( "#button_hide" ).hide( "slow" );
	$("#cancel_btn").val("0");
});

$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#ihold_dok_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#ihold_dok_del").val() );
});

function del_upload_ihold(dis, conname, table_id) {
	if($('.'+conname).length > 1) {
		custom_confirm('Delete Selected Record?', function(){
			$(dis).parent().parent().parent().remove();
		})
		
	}
	else {
		$(dis).parent().parent().parent().remove();
		
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 27%">';
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileuploadx[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafilex[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileidx[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="ihold_dok_del" onclick="del_upload_ihold(this, \'ihold_dok_del\', \'skala_trial_kimiawi\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);	
	}
}

function add_row_upload_hold(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileuploadx[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafilex[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileidx[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="ihold_dok_del" onclick="del_upload_ihold(this, \'ihold_dok_del\', \'skala_trial_kimiawi\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 30%">';
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileuploadx[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafilex[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileidx[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="ihold_dok_del" onclick="del_upload_ihold(this, \'ihold_dok_del\', \'skala_trial_kimiawi\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
}
</script>
<?php 
	if(!empty($rows)){echo '<span style="font-weight: bold; text-transform: uppercase;"> UPB Cancel </span>';}else{
	if(($teamnya==$teamupb)){
?>
	<span class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="button_show">Update</span>
	<span style="display: none;" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="button_hide">Cancel</span>
	<br>
<?php } else{}
} ?>
<table class="hover_table" id="ihold_dok" cellspacing="0" cellpadding="1" <?php if(!empty($rows)){ echo 'style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse"';}else{echo 'style="display: none; width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse"';}?>>
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="4" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Hold UPB (*Abaikan jika UPB tidak di cancel!)</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Pilih File</th>
		<th style="border: 1px solid #dddddd;">Action</th>		
	</tr>
	</thead>
	<tbody>
	<input type="hidden" name="cancel_btn" id="cancel_btn">
		<?php
				$i = 1;
				$linknya = "";
		if (isset($mydept)) {				
		if(in_array('BD', $mydept)) {
			if(!empty($rows)) {
				foreach($rows as $row) {
			//tambahan untuk download file
			$idsp  = $row['iupb_id'];
			$value = $row['filename'];
			$path = "kimiawi";	
			if($value != '') {
				if (file_exists('./files/plc/dok_hold_upb/'.$idsp.'/'.$value)) {
					$link = base_url().'processor/plc/upb/daftar?action=download&id='.$idsp.'&path='.$path.'&file='.$value;
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
						<span class="ihold_dok_num"><?php echo $i ?></span>
					</td>		
					<td colspan="2" style="border: 1px solid #dddddd; width: 30%">
						<?php echo $row['filename'] ?> 
						<input type="hidden" class="multifile" id="namafilex" name="namafilex[]" style="width: 70%" value="<?php echo $row['filename'] ?>" />
						<input type="hidden" name="fileidx[]" style="width: 70%" value="<?php echo $row['id'] ?>" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<!--<span class="delete_btn"><a href="javascript:;" class="ihold_dok_del" onclick="del_upload_ihold(this, 'ihold_dok_del', 'skala_trial_kimiawi')">[Hapus]</a></span>-->
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
						<span class="ihold_dok_num">1</span>
					</td>		
					<td colspan="2" style="border: 1px solid #dddddd; width: 30%">
						<input type="file" class="fileupload multi multifile" name="fileuploadx[]" style="width: 70%" /> *max 5 mb
						<input type="hidden" class="multifile" id="namafilex" name="namafilex[]" style="width: 70%" value="" />
						<input type="hidden" name="fileidx[]" style="width: 70%" value="" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="ihold_dok_del" onclick="del_upload_ihold(this, 'ihold_dok_del','skala_trial_kimiawi')">[Hapus]</a></span>
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
						<span class="ihold_dok_num"><?php echo $i ?></span>
					</td>							
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $linknya ?>
						<?php echo $row['filename'] ?> 
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
			} ?>
	</tbody>
	<tfoot>
		<?php if(!empty($rows)){} else{?>
		<tr>
			<td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_upload_hold('ihold_dok')">Tambah</a></td>
		</tr>
		<?php } ?>
	</tfoot>
</table>