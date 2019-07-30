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
	var tmpDel = $("#upb_daftar_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#upb_daftar_del").val() );
});

function add_row_upb_daftar(table_id){		
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
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';	
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="upb_daftar_del" onclick="del_row1(this, \'upb_daftar_del\')">[Hapus]</a></span></td>';		
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
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="upb_daftar_del" onclick="del_row1(this, \'upb_daftar_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
}
</script>

<table class="hover_table" id="upb_daftar" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
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
		if(in_array('BD', $mydept)||in_array('DR', $mydept) || in_array('PD', $mydept)) {
			//if(!empty($rows)) {
			if(!empty($rows)) {
				foreach($rows as $row) {
			//tambahan untuk download file
			$idsp  = $row['iupb_id'];
			$value = $row['filename'];
			$type = "upb_daftar";
			if($value != '') {
				if (file_exists('./files/plc/dok_tambah/'.$idsp.'/'.$value)) {
					$link = base_url().'processor/plc/upb/daftar?action=download&id='.$idsp.'&path='.$type.'&file='.$value;
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
						<span class="upb_daftar_num"><?php echo $i ?></span>
					</td>							
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['filename'] ?> 
						<input type="hidden" name="namafile[]" style="width: 70%" value="<?php echo $row['filename'] ?>" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $row['id'] ?>" />
					</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 40%">
						<?php echo $row['vketerangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 15%">
						<span class="delete_btn"><a href="javascript:;" class="upb_daftar_del" onclick="del_row1(this, 'upb_daftar_del')">[Hapus]</a></span>
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
						<span class="upb_daftar_num">1</span>
					</td>		
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" class="fileupload multi multifile" name="fileupload[]" style="width: 70%" />
						<input type="hidden" name="namafile[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="" />
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="upb_daftar_del" onclick="del_row1(this, 'upb_daftar_del')">[Hapus]</a></span>
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
						<span class="upb_daftar_num"><?php echo $i ?></span>
					</td>							
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $linknya ?>
						<?php echo $row['filename'] ?> 
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 23%">
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
			<td></td><td style="text-align: left"><font color="RED">*.jpg , *.doc, *.pdf</a></td>
			<td colspan="3"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_upb_daftar('upb_daftar')">Tambah</a></td>
		</tr><?php //}?>
	</tfoot>
</table>