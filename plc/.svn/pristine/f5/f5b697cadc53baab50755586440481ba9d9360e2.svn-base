<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
$dtnow=date('Y-m-d H:i:s');
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
		var dtnow='<?php echo $dtnow; ?>';
		if (n.length == 0) {
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">'+dtnow+'</td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<select id= "cPIC'+c+'" name="cPIC[]" tyle="width: 70%">';
			row_content	 += '<?php $sql=mysql_query("select a.vName as vName, a.cNip as cNip from hrd.employee as a, plc2.plc2_upb_team as b, plc2.plc2_upb_team_item as c where  b.iteam_id=c.iteam_id and c.vnip=a.cNip and b.iteam_id=74 order by a.vName ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="">---Pilih PIC---</option><option value="<?php echo $dt[1]; ?>"><?php echo $dt[1]."-".$dt[0]; ?></option><?php } ?>';
			row_content	 += '</select></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			//row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content	 += '<input type="file" class="fileupload multi multifile" name="fileupload[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">'+dtnow+'</td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			//row_content	 += '<textarea id= "filekt'+c+'"class="" name="cPIC[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len'+c+'">250</span> karakter<br/>';
			row_content	 += '<select id= "cPIC'+c+'" name="cPIC[]" tyle="width: 70%">';
			row_content	 += '<?php $sql=mysql_query("select a.vName as vName, a.cNip as cNip from hrd.employee as a, plc2.plc2_upb_team as b, plc2.plc2_upb_team_item as c where  b.iteam_id=c.iteam_id and c.vnip=a.cNip and b.iteam_id=74 order by a.vName ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="">---Pilih PIC---</option><option value="<?php echo $dt[1]; ?>"><?php echo $dt[1]."-".$dt[0]; ?></option><?php } ?>';
			row_content	 += '</select></td>';
			//row_content  += '</td>';
			
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			//row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}

}
</script>

<table class="hover_table" id="brosur_bb_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Dokumen SAS</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Pilih File</th>
		<th colspan="3" style="border: 1px solid #dddddd;width: 20%;">Tanggal Download</th>
		<th colspan="3" style="border: 1px solid #dddddd;width: 50%;">PIC</th>	
	</tr>
	</thead>
	<tbody>
		<?php
		
			$i = 1;
			$linknya = "";
			if(!empty($rows)) {

				foreach($rows as $row) {
					//tambahan untuk download file
					$id  = $row['idossier_dok_sas_id'];
					$value = $row['vDok_sas_name'];	
					if($value != '') {
						if (file_exists('./files/plc/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/download/dokumen/sas/export?action=download&id='.$id.'&file='.$value;
							//$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
						}
						else {
							//$linknya = 'File sudah tidak ada!';
						}
					}
					else {

						$file = 'No File';
					}	
			//selesai tambahan download
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="brosur_bb_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vDok_sas_name'] ?> 
						<input type="hidden" name="namafile[]" style="width: 70%" value="<?php echo $row['vDok_sas_name'] ?>" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $row['idossier_dok_sas_id'] ?>" />
					</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['ddown_sas_dok'] ?>
					</td>
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['cPic_sas']."-".$row['vName']; ?>
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
					
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						
						</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
					
					</td>
					<td colspan="3" style="border: 1px solid #dddddd; width: 15%">
						
					<td style="border: 1px solid #dddddd; width: 10%">
						<!--<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row1(this, 'brosur_bb_del')">[Hapus]</a></span> -->
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7"></td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<!-- <a href="javascript:;" onclick="javascript:add_row_brosur_upload('brosur_bb_upload')">Tambah</a> -->	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>