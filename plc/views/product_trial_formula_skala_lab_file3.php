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
	var tmpDel = $("#skala_lab_hum_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#skala_lab_hum_del").val() );
});

function add_row_skala_lab_hum_upload(table_id){		
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
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileupload_hum[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile_hum[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_hum[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea id= "filekt_hum'+c+'" class="" name="fileketerangan_hum[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len_hum'+c+'">250</span> karakter<br/></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="skala_lab_hum_del" onclick="del_row(this, \'skala_lab_hum_del\')">[Hapus]</a></span></td>';		
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
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileupload_hum[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile_hum[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_hum[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea id= "filekt_hum'+c+'"class="" name="fileketerangan_hum[]" style="width: 240px; height: 50px;"></textarea><br/>tersisa <span id="len_hum'+c+'">250</span> karakter<br/>';
			row_content  += '</td>';
			
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="skala_lab_hum_del" onclick="del_row(this, \'skala_lab_hum_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
				$("#filekt_hum"+c).keyup(function() {
					var len = this.value.length;
					if (len >= 250) {
					this.value = this.value.substring(0, 250);
					}
					$("#len_hum"+c).text(250 - len);
				});
				$("#fileupload"+table_id+c).change(function () {
			        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
			        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
			        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
			        	$(this).val('');
			        }
			    });

}
</script>

<table class="hover_table" id="skala_lab_hum_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Tambahan</span></th>
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
					$idsp  = $row['ifor_id'];
					$value = $row['filename'];
					$path = "mikrobiologi";	
					if($value != '') {
						if (file_exists('./files/plc/product_trial/skala_lab/mikrobiologi/'.$idsp.'/'.$value)) {
							$link = base_url().'processor/plc/product/trial/formula/skala/lab?action=download&id='.$idsp.'&path='.$path.'&file='.$value;
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
						<span class="skala_lab_hum_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['filename'] ?> 
						<input type="hidden" name="namafile_hum[]" style="width: 70%" value="<?php echo $row['filename'] ?>" />
						<input type="hidden" name="fileid_hum[]" style="width: 70%" value="<?php echo $row['id'] ?>" />
					</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['keterangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { ?>
							<span class="delete_btn"><a href="javascript:;" class="skala_lab_hum_del" onclick="del_row1(this, 'skala_lab_hum_del')">[Hapus]</a></span>	
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
						<span class="skala_lab_hum_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileupload_skala_lab_hum_1" class="fileupload multi multifile required" name="fileupload_hum[]" style="width: 70%" /> *
						<input type="hidden" name="namafile_hum[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid_hum[]" style="width: 70%" value="" />
						</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" id="filekt_hum1"name="fileketerangan_hum[]" style="width: 240px; height: 50px;"size="250"></textarea>
						<br/>
						tersisa <span id="len_hum1">250</span> karakter<br/>
						
				

					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="skala_lab_hum_del" onclick="del_row1(this, 'skala_lab_hum_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" style="text-align: left">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<a href="javascript:;" onclick="javascript:add_row_skala_lab_hum_upload('skala_lab_hum_upload')">Tambah</a>	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>


	<script>
		$('#filekt_hum1').keyup(function() {
		var len = this.value.length;
		if (len >= 250) {
		this.value = this.value.substring(0, 250);
		}
		$('#len_hum1').text(250 - len);
		});
		$("#fileupload_skala_lab_hum_1").change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "skala_lab_hum_upload", 1, 20000);
	        	$(this).val('');
	        }
    	});
	</script>