<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
$("#<?php echo $tableId;?> .fileupload2").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid2 = li.attr('fileid2');
	var tmpDel = $("#stabilita_bb_del1");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid2;
	tmpDel.val( v );
	alert( $("#stabilita_bb_del1").val() );
});

function ngilang(ini, table_id){
	del_row1(ini, table_id);
	document.getElementById('tambah1').style.visibility='visible';
}

function add_row_stabilita_upload(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			document.getElementById('tambah1').style.visibility = 'hidden';
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" class="fileupload multi multifile required" name="fileupload2[]" style="width: 70%" />*max 5 mb';
			row_content  += '<input type="hidden" name="namafile2[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid2[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea id= "filekt2" class="required" name="fileketerangan2[]" style="width: 240px; height: 50px;" required></textarea><br/>tersisa <span id="len">250</span> karakter<br/></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="stabilita_bb_del1" onclick="ngilang(this, \'stabilita_bb_del1\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			_custom_alert("Maksimal 1 File Upload","Info","Info", "Alert", 1, 20000);	
		}
				$("#filekt2").keyup(function() {
					var lena = this.value.length;
					if (lena >= 250) {
					this.value = this.value.substring(0, 250);
					}
					$("#lena").text(250 - lena);
				});

}
</script>

<table class="hover_table" id="stabilita_bb_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Dokumen Accelerate</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Pilih File</th>
		<th colspan="3" style="border: 1px solid #dddddd;width: 50%;">Keterangan</th>
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
					$idfolder  = $row['idossier_review_id'];
					$value = $row['vFilename'];	
					if($value != '') {
						if (file_exists('./files/plc/dossier_dok/'.$idfolder.'/'.$value)) {
							$link = base_url().'processor/plc/stabilita/terbalik?action=download&id='.$idfolder.'&file='.$value;
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
						<span class="stabilita_bb_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vFilename'] ?> 
						<input type="hidden" name="namafile2[]" style="width: 70%" value="<?php echo $row['vFilename'] ?>" />
						<input type="hidden" name="fileid2[]" style="width: 70%" value="<?php echo $row['idossier_dok_list_file_id'] ?>" />
					</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['vKeterangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { ?>
							<span class="delete_btn"><a href="javascript:;" class="stabilita_bb_del1" onclick="ngilang(this, 'stabilita_bb_del1')">[Hapus]</a></span>	
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
						<span class="stabilita_bb_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" class="fileupload multi multifile required" name="fileupload2[]" style="width: 70%" /> *max 5 mb
						<input type="hidden" name="namafile2[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid2[]" style="width: 70%" value="" />
						</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="required" id="filekt2"name="fileketerangan2[]" style="width: 240px; height: 50px;"size="250" required>
							
						</textarea>
						<br/>
						tersisa <span id="lena">250</span> karakter<br/>
						
				

					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
					<!--	<span class="delete_btn"><a href="javascript:;" class="stabilita_bb_del1" onclick="del_row1(this, 'stabilita_bb_del1')">[Hapus]</a></span>-->
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5"></td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
				<div id="tambah1" style="visibility :hidden"><a href="javascript:;" onclick="javascript:add_row_stabilita_upload('stabilita_bb_upload')">Tambah</a></div>
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>


	<script>
		$('#filekt2').keyup(function() {
		var lena = this.value.length;
		if (lena >= 250) {
		this.value = this.value.substring(0, 250);
		}
		$('#lena').text(250 - lena);
		});
	</script>