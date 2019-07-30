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
	var tmpDel = $("#cpa_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#cpa_del").val() );
});

function add_row_cpa(table_id){		
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
			row_content  +=	'<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">';
			<?php if (isset($mydept)) {
				if(in_array('BD', $mydept)){?>
			row_content  +=	'<select name="confirmcpa[]"><option value="0">Haven\'t been checked</option><option value="1">Yes</option><option value="3">No</option><option value="2">Unnecessary</option></select>';
			<?php } 
				else{?>
			row_content  +=	'<select name="confirmcpa[]"><option value="0">Haven\'t been checked</option></select>';
			<?php		}
				}?>
			row_content  +=	'</td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileuploadcpa[]" style="width: 50%" />*';
			row_content  += '<input type="hidden" name="namafiledcpa[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileidcpa[]" style="width: 70%" value="" /></td>';	
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangancpa[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="cpa_del" onclick="del_row1(this, \'cpa_del\')">[Hapus]</a></span></td>';		
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
			<?php if (isset($mydept)) {
				if(in_array('BD', $mydept)){?>
			row_content  +=	'<select name="confirmcpa[]"><option value="0">Haven\'t been checked</option><option value="1">Yes</option><option value="3">No</option><option value="2">Unnecessary</option></select>';
			<?php } 
				else{?>
			row_content  +=	'<select name="confirmcpa[]"><option value="0">Haven\'t been checked</option></select>';
			<?php		}
				}?>
			row_content  +=	'</td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 30%">';
			row_content	 += '<input type="file" id="fileupload'+table_id+c+'" class="fileupload multi multifile required" name="fileuploadcpa[]" style="width: 50%" />*';
			row_content  += '<input type="hidden" name="namafilecpa[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileidcpa[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangancpa[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="cpa_del" onclick="del_row1(this, \'cpa_del\')">[Hapus]</a></span></td>';		
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

<table class="hover_table" id="cpa" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Laporan File COA Pilot Batch 1</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Confirm</th>
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
		if((in_array('BD', $mydept))||(in_array('QA', $mydept))) {
			//if(!empty($robb)) {
			if(!empty($rows)) {
				foreach($rows as $row) {
			//tambahan untuk download file
			$idsp  = $row['icoa_id'];
			$sql="select * from plc2.coa_pilot_lab cp where cp.iappqa=2 and cp.lDeleted=0 and cp.icoa_id=".$idsp;
			$dt=$this->db_plc0->query($sql)->row_array();
			$iupb_id=$dt['iupb_id'];
			$value = $row['vFilename'];
			$type = "cpa";
			if($value != '') {
				if (file_exists('./files/plc/coa_pilot_lab/'.$idsp.'/coa_pilot1/'.$value)) {
					$link = base_url().'processor/plc/cek/dokumen/registrasi?action=download2&id='.$idsp.'&path='.$type.'&file='.$value;
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
						<span class="cpa_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<?php if((in_array('BD', $mydept))&&($iDone<>1)) { ?>
						<select name="confirmcpa[]">
							<option value="0" <?php if($row['iconfirm_busdev']==0){echo "selected";}?> >Haven't been checked</option>
							<option value="1" <?php if($row['iconfirm_busdev']==1){echo "selected";}?> >Yes</option>
							<option value="3" <?php if($row['iconfirm_busdev']==3){echo "selected";}?> >No</option>
							<option value="2" <?php if($row['iconfirm_busdev']==2){echo "selected";}?> >Unnecessary</option>
						</select>
						<?php }
							else{
						?>
						<input type="hidden" name="confirmcpa[]" value="<?php echo $row['iconfirm_busdev'];?>">
						<span>
							<?php if($row['iconfirm_busdev']==0){echo "Haven't been checked";}?>
							<?php if($row['iconfirm_busdev']==1){echo "Yes";}?>
							<?php if($row['iconfirm_busdev']==3){echo "No";}?>
							<?php if($row['iconfirm_busdev']==2){echo "Unnecessary";}?>
						</span>
						<?php }?>
					</td>
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['vFilename'] ?> 
						<input type="hidden" name="namafilecpa[]" style="width: 70%" value="<?php echo $row['vFilename'] ?>" />
						<input type="hidden" name="fileidcpa[]" style="width: 70%" value="<?php echo $row['icoa_pilot_batch1_id'] ?>" />
					</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['vKeterangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<?php if (($this->input->get('action') != 'view') && (in_array('QA', $mydept)) && (($row['iconfirm_busdev']==0)||($row['iconfirm_busdev']==3))) { ?>
							<span class="delete_btn"><a href="javascript:;" class="cpa_del" onclick="del_row1(this, 'cpa_del')">[Hapus]</a></span>	
						<?php	} ?>
						<span class="delete_btn"><?php echo $linknya ?></span>
					</td>		
				</tr>
		<?php
			$i++;	
				}

			}
			else {
			//$i++;
		/*?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="cpa_num">1</span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="confirmcpa[]">
							<option value="0">Haven't been checked</option>
							<?php if(in_array('BD', $mydept)) { ?>
							<option value="1">Yes</option>
							<option value="3">No</option>
							<option value="2">Unnecessary</option> <?php } ?>
						</select>
					</td>
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileuploadcpa1" class="fileupload multi multifile required" name="fileuploadcpa[]" style="width: 50%" /> *
						<input type="hidden" name="namafilecpa[]" style="width: 70%" value="" />
						<input type="hidden" name="fileidcpa[]" style="width: 70%" value="" />
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" name="fileketerangancpa[]" style="width: 240px; height: 50px;"></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="cpa_del" onclick="del_row1(this, 'cpa_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php*/ }
		} 	
		else
			{
			if(!empty($rows)) {	
			foreach($rows as $row) {
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="bahan_kemas_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<span>
							<?php if($row['iconfirm_busdev']==0){echo "Haven't been checked";}?>
							<?php if($row['iconfirm_busdev']==1){echo "Yes";}?>
							<?php if($row['iconfirm_busdev']==3){echo "No";}?>
							<?php if($row['iconfirm_busdev']==2){echo "Unnecessary";}?>
						</span>
					</td>					
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $linknya ?>
						<?php echo $row['vFilename'] ?> 
						</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['vKeterangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">-</td>
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
			<td colspan="3" style="text-align: left">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
			<?php if(($iDone<>1) && ((in_array('BD', $mydept))||(in_array('QA', $mydept)))) {?>
			<td colspan="2" style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_cpa('cpa')">Tambah</a></td>
			<?php }?>
			<?php if((in_array('BD', $mydept))&&($iDone==0)&&($cekconf==0)) {?>
			<td style="text-align: center">
				<?php echo '&nbsp;&nbsp;&nbsp; <span onclick="javascript:load_popup(\''.base_url().'processor/plc/cek/dokumen/registrasi?action=dokDone&dok=cpa&id='.$idsp.'&upb_id='.$iupb_id.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="button_donecpa">Done</span>';?>
			</td>
			<?php }?>
		</tr>
		<?php if(($iDone==1)) {?>
			<tr>
			 <td colspan="3" style="text-align: left"><b><p style="color:green;font-size:120%;">Status Dokumen File COA Pilot Batch 1 : DONE </p></b></td>
			</tr>
		<?php }?>
		
	</tfoot>
</table>
<script>
	$("#fileuploadcpa1").change(function () {
	    var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	    if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	    	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "cek_dokumen_registrasi", 1, 20000);
	    	$(this).val('');
	    }
	});
</script>