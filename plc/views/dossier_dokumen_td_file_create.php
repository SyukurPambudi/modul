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
	var tmpDel = $("#brosur_bb_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#brosur_bb_del").val() );
});

function add_row_brosur_upload(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 50%">';
			row_content  += '<input type="text" name="namadokumen[]" class="required" required="required" style="width: 70%" value="" /></td>';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';	
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 50%">';
			row_content  += '<input type="text" name="namadokumen[]" class="required" required="required" style="width: 70%" value="" /></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
				$("#filekt"+c).keyup(function() {
					var len = this.value.length;
					if (len >= 250) {
					this.value = this.value.substring(0, 250);
					}
					$("#len"+c).text(250 - len);
				});

}
</script>
<input type="hidden" name="dossier_dokumen_td_dUpload" class="required" readonly="TRUE" id="dossier_dokumen_td_dUpload"  value="<?php echo date('Y-m-d') ?>" class="input_rows1" size="10" />
<table class="hover_table" id="dok_td_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="3" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Tambahan</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th style="border: 1px solid #dddddd; width: 5%;" >Nama Dokumen</th>
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
					$id  = $row['idossier_dok_td_id'];
					$value = $row['vFilename'];	
					if($value != '') {
						if (file_exists('./files/plc/dossier_dok_td/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/dossier/dokumen/td?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
						}
						else {
							$linknya = 'File sudah tidak ada!';
							//$linknya = $id.$value;
						}
					}
					else {

						$file = 'No File';
					}	
			//selesai tambahan download
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="dok_td_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['cNama_dokumen'] ?> 
						<input type="hidden" name="namadokumen[]" class="required" style="width: 70%" required="required" value="<?php echo $row['cNama_dokumen'] ?>" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $row['idossier_dok_td_detail_id'] ?>" />
					</td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { ?>
							<?php 
								if (isset($mydept)) {
									if((in_array('IM', $mydept))) {
								
							 ?>
								<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row1(this, 'brosur_bb_del')">[Hapus]</a></span>	
							<?php 
									}
								}
							 ?>
					 
							
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
						<span class="dok_td_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="text" name="namadokumen[]" required="required" class='required'style="width: 70%" value="" />
					</td>	
					
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row1(this, 'brosur_bb_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"></td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<?php 
						if (isset($mydept)) {
							if((in_array('IM', $mydept))) {
					 ?>
								<a href="javascript:;" onclick="javascript:add_row_brosur_upload('dok_td_upload')">Tambah</a>	
					<?php 
							}

						}
					 ?>
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>
