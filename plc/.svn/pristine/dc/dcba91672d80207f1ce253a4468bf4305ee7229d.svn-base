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
	var tmpDel = $("#bk_primer_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#bk_primer_del").val() );
});

function add_row_bk_primer(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content  +=	'<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">';
			row_content  +=	'<select name="ijbk_pr[]">';
			<?php foreach($jenis_bk as $jbk){?>
				row_content  += '<option value="<?php echo $jbk['ijenis_bk_id']?>"> <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>';
			<?php } ?>
			row_content  += '</select>';
			row_content  +=	'</td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="bk_primer_del" onclick="del_row1(this, \'bk_primer_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';	
			row_content  +=	'<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">';
			row_content  +=	'<select name="ijbk_pr[]">';
			<?php foreach($jenis_bk as $jbk){?>
				row_content  += '<option value="<?php echo $jbk['ijenis_bk_id']?>"> <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>';
			<?php } ?>
			row_content  += '</select>';
			row_content  +=	'</td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="bk_primer_del" onclick="del_row1(this, \'bk_primer_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
}
</script>

<table class="hover_table" id="bk_primer" cellspacing="0" cellpadding="1" style="width:42%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
		<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd;">No</th>
			<th style="border: 1px solid #dddddd;">Jenis Bahan Kemas</th>
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
		if(in_array('PPC', $mydept)) {
			//if(!empty($rows)) {
			if(!empty($rows)) {
				foreach($rows as $row) {
			$idsp  = $row['ibk_id'];
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="bk_primer_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="ijbk_pr[]" class="required">
						<?php foreach($jenis_bk as $jbk){
							if($row['ijenis_bk_id']==$jbk['ijenis_bk_id']){$sel='selected';} else{$sel='';}
						?>
								<option value="<?php echo $jbk['ijenis_bk_id']?>" <?php echo $sel;?> > <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>		
						<?php } ?>
						</select>
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bk_primer_del" onclick="del_row1(this, 'bk_primer_del')">[Hapus]</a></span>
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
						<span class="bk_primer_num">1</span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="ijbk_pr[]" class="required">
						<option value="">- Pilih -</option>
						<?php foreach($jenis_bk as $jbk){?>
							<option value="<?php echo $jbk['ijenis_bk_id']?>"> <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>		
						<?php } ?>
						</select>
					</td>					
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bk_primer_del" onclick="del_row1(this, 'bk_primer_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php }
		} 	
		else
			{
			if(!empty($rows)) {
				foreach($rows as $row) {
			$idsp  = $row['ibk_id'];
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="bk_primer_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="ijbk_pr[]" class="required">
						<?php foreach($jenis_bk as $jbk){
							if($row['ijenis_bk_id']==$jbk['ijenis_bk_id']){$sel='selected';} else{$sel='';}
						?>
								<option value="<?php echo $jbk['ijenis_bk_id']?>" <?php echo $sel;?> > <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>		
						<?php } ?>
						</select>
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bk_primer_del" onclick="del_row1(this, 'bk_primer_del')">[Hapus]</a></span>
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
			<td colspan="2"></td><td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_bk_primer('bk_primer')">Tambah</a></td>
		</tr><?php //}?>
	</tfoot>
</table>