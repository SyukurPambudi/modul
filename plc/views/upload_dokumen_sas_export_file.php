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
	var tmpDel = $("#upload_doksas_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#upload_doksas_del").val() );
});

function add_row_upload_doksas_upload(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileupload_updoksas[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile_updoksas[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_updoksas[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%"><?php echo date("d-m-Y"); ?></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<select id= "cpic_updoksas'+c+'" name="cpic_updoksas[]" tyle="width: 70%" class="required"><option value="">---Pilih PIC---</option>';
			//row_content	 += '<?php $sql=mysql_query("select a.vName as vName, a.cNip as cNip from hrd.employee as a, plc2.plc2_upb_team as b, plc2.plc2_upb_team_item as c where  b.iteam_id=c.iteam_id and c.vnip=a.cNip and b.iteam_id=74 order by a.vName ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="<?php echo $dt[1]; ?>"><?php echo $dt[1]."-".$dt[0]; ?></option><?php } ?>';
			<?php 
				foreach ($cpic as $kpic => $vpic) {?>
					row_content	 +='<option value="<?php echo $vpic["cNip"]; ?>"><?php echo $vpic["cNip"]."-".$vpic["vName"]; ?></option>';
			<?php }
			?>
			row_content	 += '</select></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="upload_doksas_del" onclick="del_row(this, \'upload_doksas_del\')">[Hapus]</a></span></td>';		
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
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileupload_updoksas[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile_updoksas[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_updoksas[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%"><?php echo date("d-m-Y"); ?></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<select id= "cpic_updoksas'+c+'" name="cpic_updoksas[]" tyle="width: 70%" class="required"><option value="">---Pilih PIC---</option>';
			//row_content	 += '<?php $sql=mysql_query("select a.vName as vName, a.cNip as cNip from hrd.employee as a, plc2.plc2_upb_team as b, plc2.plc2_upb_team_item as c where  b.iteam_id=c.iteam_id and c.vnip=a.cNip and b.iteam_id=74 order by a.vName ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="<?php echo $dt[1]; ?>"><?php echo $dt[1]."-".$dt[0]; ?></option><?php } ?>';
			<?php 
				foreach ($cpic as $kpic => $vpic) {?>
					row_content	 +='<option value="<?php echo $vpic["cNip"]; ?>"><?php echo $vpic["cNip"]."-".$vpic["vName"]; ?></option>';
			<?php }
			?>
			row_content	 += '</select></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="upload_doksas_del" onclick="del_row(this, \'upload_doksas_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
				
				$("#fileupload"+table_id+c).change(function () {
			        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

}
</script>

<table class="hover_table" id="upload_doksas_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Pilih File</th>
		<th colspan="2" style="border: 1px solid #dddddd;width: 25%;">Tanggal Upload</th>
		<th colspan="2" style="border: 1px solid #dddddd;width: 25%;">PIC</th>
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
					$id  = $row['idossier_dok_sas_id'];
					$value = $row['vDok_sas_name'];	
					if($value != '') {
						if (file_exists('./files/plc/dok_sas/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/upload/dokumen/sas/export?action=download&id='.$id.'&file='.$value;
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
						<span class="upload_doksas_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vDok_sas_name'] ?> 
						<input type="hidden" name="namafile_updoksas[]" style="width: 70%" value="<?php echo $row['vDok_sas_name'] ?>" />
						<input type="hidden" name="fileid_updoksas[]" style="width: 70%" value="<?php echo $row['idossier_file_dok_sas_id'] ?>" />
					</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['dDate_sas_dok'] ?>
					</td>
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php 
						$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$row['cPic_sas']))->row_array();
						echo $rows['cNip']."-".$rows['vName']; ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { ?>
							<span class="delete_btn"><a href="javascript:;" class="upload_doksas_del" onclick="del_row1(this, 'upload_doksas_del')">[Hapus]</a></span>	
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
						<span class="upload_doksas_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileupload_upload_doksas_1" class="fileupload multi multifile required" name="fileupload_updoksas[]" style="width: 70%" /> *
						<input type="hidden" name="namafile_updoksas[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid_updoksas[]" style="width: 70%" value="" />
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php echo date("d-m-Y"); ?>
					</td>
					<td colspan="2" style="border: 1px solid #dddddd; width: 15%">
						<select id= "cpic_updoksas_1" name="cpic_updoksas[]" tyle="width: 70%" class="required">
							<option value="">---Pilih PIC---</option>
						<?php 
							foreach ($cpic as $kpic => $vpic) {
								echo "<option value='".$vpic['cNip']."'>".$vpic['cNip']."-".$vpic['vName']."</option>";
							}
						?>
						</select></td>	
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="upload_doksas_del" onclick="del_row(this, 'upload_doksas_del')">[Hapus]</a></span>
					</td>
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6" style="text-align: left">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<a href="javascript:;" onclick="javascript:add_row_upload_doksas_upload('upload_doksas_upload')">Tambah</a>	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>


	<script>
		$("#fileupload_upload_doksas_1").change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "upload_doksas", 1, 20000);
	        	$(this).val('');
	        }
    	});
	</script>