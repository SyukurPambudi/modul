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
	var tmpDel = $("#valmoa_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#valmoa_del").val() );
});
function del_valmoa(dis, conname, table_id) {
	//if($('.'+conname).length > 1) {
		custom_confirm('Delete Selected Record?', function(){
			$(dis).parent().parent().parent().remove();
			if($('.'+conname).length==0) {
				var row = $('table#'+table_id+' tbody tr:last').clone();
				$("span."+table_id+"_num:first").text('1');
				var n = $("span."+table_id+"_num:last").text();
					var row_content = '';
					row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
					row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
					row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
					row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 50%">';
					row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload7[]" style="width: 70%" />*max 5 mb';
					row_content  += '<input type="hidden" name="namafile7[]" style="width: 70%" value="" />';
					row_content  += '<input type="hidden" name="fileid7[]" style="width: 70%" value="" /></td>';	
					row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
					row_content	 += '<textarea class="" name="fileketerangan7[]" style="width: 240px; height: 50px;"></textarea></td>';
					row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
					row_content	 += '<span class="delete_btn"><a href="javascript:;" class="valmoa_del" onclick="del_valmoa(this, \'valmoa_del\', \'valmoa\')">[Hapus]</a></span></td>';		
					row_content  += '</tr>';
					
					jQuery("#"+table_id+" tbody").append(row_content);	
			}
		})
}
function add_row_valmoa(table_id){		
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
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload7[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile7[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid7[]" style="width: 70%" value="" /></td>';	
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan7[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="valmoa_del" onclick="del_valmoa(this, \'valmoa_del\', \'valmoa\')">[Hapus]</a></span></td>';		
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
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload7[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile7[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid7[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan7[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="valmoa_del" onclick="del_valmoa(this, \'valmoa_del\', \'valmoa\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
}
</script>

<table class="hover_table" id="valmoa" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload File</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Pilih File</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Keterangan</th>
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
		if(in_array('PD', $mydept)) {
			//if(!empty($rows)) {
			if(!empty($rows)) {
				foreach($rows as $row) {
			//tambahan untuk download file
			$idsp  = $row['ifor_id'];
			$value = $row['filename'];
			$type = "lapprot_valmoa";
			if($value != '') {
				if (file_exists('./files/plc/'.$type.'/'.$idsp.'/'.$value)) {
					$link = base_url().'processor/plc/product/trial/basic/formula?action=download2&id='.$idsp.'&path='.$type.'&file='.$value;
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
						<span class="valmoa_num"><?php echo $i ?></span>
					</td>							
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['filename'] ?> 
						<input type="hidden" name="namafile7[]" style="width: 70%" value="<?php echo $row['filename'] ?>" />
						<input type="hidden" name="fileid7[]" style="width: 70%" value="<?php echo $row['id'] ?>" />
					</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['keterangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="valmoa_del" onclick="del_valmoa(this, 'valmoa_del', 'valmoa')">[Hapus]</a></span>
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
						<span class="valmoa_num">1</span>
					</td>		
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" class="fileupload multi multifile" name="fileupload7[]" style="width: 70%" /> *max 5 mb
						<input type="hidden" name="namafile7[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid7[]" style="width: 70%" value="" />
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" name="fileketerangan7[]" style="width: 240px; height: 50px;"></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="valmoa_del" onclick="del_valmoa(this, 'valmoa_del', 'valmoa')">[Hapus]</a></span>
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
						<span class="valmoa_num"><?php echo $i ?></span>
					</td>							
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $linknya ?>
						<?php echo $row['filename'] ?> 
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['keterangan'] ?>
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
		<tr>
			<td colspan="5"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_valmoa('valmoa')">Tambah</a></td>
		</tr>
	</tfoot>
</table>