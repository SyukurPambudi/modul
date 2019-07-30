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
	var tmpDel = $("#doktd_sas_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#doktd_sas_del").val() );
});

function add_row_doktd_sas_upload(table_id){		
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
			row_content	 += '<input type="file" id="fileupload_'+table_id+'_'+c+'" class="fileupload multi multifile required" name="fileupload_doktd_sas[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile_doktd_sas[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_doktd_sas[]" style="width: 70%" value="" /></td>';
			row_content  += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%"><?php echo date("Y-m-d H:i:s"); ?></td>';
			row_content  += '<td colspan="1" style="border: 1px solid #dddddd; width: 15%"><select id= "cPic_doktd_sas_'+c+'" name="cPic_doktd_sas[]" tyle="width: 70%" class="required"><option value="">---Pilih PIC---</option>';
						<?php
				foreach ($cpic as $kpic => $vpic) {
				$nip=$vpic["cNip"];
				$nama=$vpic["vName"];
				$option='<option value="'.$nip.'">'.$vpic["cNip"].'-'.$vpic['vName'].'</option>';
			?>
			row_content  += '<?php echo $option; ?>';
						<?php 	}
						?>
			row_content  +=	'</select></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="doktd_sas_del" onclick="del_row(this, \'doktd_sas_del\')">[Hapus]</a></span></td>';		
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
			row_content	 += '<input type="file" id="fileupload_'+table_id+'_'+c+'" class="fileupload multi multifile required" name="fileupload_doktd_sas[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile_doktd_sas[]" style="width: 70%" value="" />';	
			row_content  += '<input type="hidden" name="fileid_doktd_sas[]" style="width: 70%" value="" /></td>';
			row_content  += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%"><?php echo date("Y-m-d H:i:s"); ?></td>';
			row_content  += '<td colspan="1" style="border: 1px solid #dddddd; width: 15%"><select id= "cPic_doktd_sas_'+c+'" name="cPic_doktd_sas[]" tyle="width: 70%" class="required"><option value="">---Pilih PIC---</option>';
						<?php
				foreach ($cpic as $kpic => $vpic) {
				$nip=$vpic["cNip"];
				$nama=$vpic["vName"];
				$option='<option value="'.$nip.'">'.$vpic["cNip"].'-'.$vpic['vName'].'</option>';
			?>
			row_content  += '<?php echo $option; ?>';
						<?php 	}
						?>
			row_content  +=	'</select></td>';
			
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="doktd_sas_del" onclick="del_row(this, \'doktd_sas_del\')">[Hapus]</a></span></td>';		
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

<table class="hover_table" id="doktd_sas_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="5" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;"><?php if($status==0){ echo "Upload";}else{echo "Download";} ?> Dokumen</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Pilih File</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">Tanggal <?php if($status==0){ echo "Upload";}else{echo "Download";}?></th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 30%;">PIC</th>
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
					$id  = $row['idossier_dok_td_sas_id'];
					$value = $row['vDok_sas_name'];	
					$ipk=$row['idossier_file_dok_dt_sas_id'];
					if($value != '') {
						if (file_exists('./files/plc/dok_dt_sas/'.$id.'/'.$value)) {
							$link = base_url().'processor/plc/dokumen/dt/sas?action=download&id='.$id.'&file='.$value.'&ipk='.$ipk;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="download_'.$ipk.'()">Download</a>';
							$linknya .='<script>
										function download_'.$ipk.'(){
										var last_id ='.$this->input->get("id").';
										var foreign_id ='.$this->input->get("foreign_key").';
										var company_id ='.$this->input->get("company_id").';
										var group_id ='.$this->input->get("group_id").';
										var modul_id ='.$this->input->get("modul_id").';
										window.location=\''.$link.'\';
										grid="dokumen_dt_sas";
										$.get(base_url+"processor/plc/dokumen/dt/sas?action=update&id="+last_id+"&foreign_key="+foreign_id+"&company_id="+company_id+"&group_id="+group_id+"&modul_id="+modul_id, function(data) {
					                            $("div#form_"+grid).html(data);
					                    });
									}
										</script>';
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
						<span class="doktd_sas_upload_num"><?php echo $i ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vDok_sas_name'] ?>
						<input type="hidden" name="namafile_doktd_sas[]" style="width: 70%" value="<?php echo $row['vDok_sas_name'] ?>" />
						<input type="hidden" name="fileid_doktd_sas[]" style="width: 70%" value="<?php echo $row['idossier_file_dok_dt_sas_id'] ?>" />
						</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
						<?php if($status==0){echo date('Y-m-d',$row['dDate_sas_dok']);
							}else{
								echo $row['ddown_dtsas_dok'];
							}?>
					</td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<?php
						//	foreach ($cpic as $kpic => $vpic) {
								//$sel=$row['cPic_sas']==$vpic['cNip']?'selected':'';
								echo $vpic['cNip']."-".$vpic['vName'];
							//}
						?>
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if ($this->input->get('action') != 'view') { 
							if($status==0){?>
							<span class="delete_btn"><a href="javascript:;" class="doktd_sas_del" onclick="del_row(this, 'doktd_sas_del')">[Hapus]</a></span>	
						<?php	} } ?>
						
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
						<span class="doktd_sas_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileupload_doktd_sas_1" class="fileupload multi multifile required" name="fileupload_doktd_sas[]" style="width: 70%" /> *
						<input type="hidden" name="namafile_doktd_sas[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid_doktd_sas[]" style="width: 70%" value="" />
						</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
						<?php echo date('Y-m-d H:i:s'); ?>
					</td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<select id= "cPic_doktd_sas_1" name="cPic_doktd_sas[]" tyle="width: 70%" class="required">
							<option value="">---Pilih PIC---</option>
						<?php
							foreach ($cpic as $kpic => $vpic) {
								echo "<option value='".$vpic['cNip']."'>".$vpic['cNip']."-".$vpic['vName']."</option>";
							}
						?>
						</select></td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="doktd_sas_del" onclick="del_row(this, 'doktd_sas_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align: left">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { 
					if($status==0){?>
					<a href="javascript:;" onclick="javascript:add_row_doktd_sas_upload('doktd_sas_upload')">Tambah</a>	
				<?php } } ?>
				
			</td>
		</tr>
	</tfoot>
</table>


	<script>
		$("#fileupload_doktd_sas_1").change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "doktd_sas", 1, 20000);
	        	$(this).val('');
	        }
    	});
	</script>