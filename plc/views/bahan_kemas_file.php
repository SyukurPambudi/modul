<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
//print_r($jenis_bk);
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#bahan_kemas_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#bahan_kemas_del").val() );
});
function del_bahan_kemas(dis, conname, table_id) {
	//if($('.'+conname).length > 1) {
		var j_p=0;
		var j_k=0;
		$(".pertama").each(function(){
 			j_p +=1;
		});
		$(".kedua").each(function(){
 			j_k +=1;
		});
		if((j_p<=1)&&(j_k<=1)){
			_custom_alert("File Upload Primer dan Sekunder Minimal 1","INFO","INFO", "bahan_kemas", 1, 20000);
			return false;
		}else{
			custom_confirm('Delete Selected Record?', function(){
				$(dis).parent().parent().parent().remove();
				/*
				if($('.'+conname).length==0) {
					var row = $('table#'+table_id+' tbody tr:last').clone();
					$("span."+table_id+"_num:first").text('1');
					var n = $("span."+table_id+"_num:last").text();
						var row_content = '';
						row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
						row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
						row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
						row_content  +=	'<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">';
						row_content  +=	'<select name="ijenis_bk_id[]">';
						<?php foreach($jenis_bk as $jbk){?>
							row_content  += '<option value="<?php echo $jbk['ijenis_bk_id']?>"> <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>';
						<?php } ?>
						row_content  += '</select>';
						row_content  +=	'</td>';
						row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 50%">';
						row_content	 += '<input type="file" id="fileuploadbk1" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" />*';
						row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
						row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';	
						row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
						row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
						row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
						row_content	 += '<span class="delete_btn"><a href="javascript:;" class="bahan_kemas_del" onclick="del_bahan_kemas(this, \'bahan_kemas_del\', \'bahan_kemas\')">[Hapus]</a></span></td>';		
						row_content  += '</tr>';
						
						jQuery("#"+table_id+" tbody").append(row_content);	
						$("#fileuploadbk1").change(function () {
					        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
					        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
					        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
					        	$(this).val('');
					        }
					    });

				}*/
			})
		}
}
function add_row_bahan_kemas(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var c=1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content  +=	'<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">';
			row_content  +=	'<select name="ijenis_bk_id[]" id="ijenis_bk_id'+c+'">';

			<?php $i=0; foreach($jenis_bk as $jbk){
				$css='';
				if ($i==0){
					$css='pertama';
					$i++;
				}
				?>
				row_content  += '<option value="<?php echo $jbk['ijenis_bk_id']?>" class="<?php echo $css ?>"> <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>';
			<?php } ?>
			row_content  += '</select>';
			row_content  +=	'</td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 50%">';
			row_content	 += '<input type="file" id="fileuploadbk'+c+'" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';	
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="bahan_kemas_del" onclick="del_bahan_kemas(this, \'bahan_kemas_del\', \'bahan_kemas\')">[Hapus]</a></span></td>';		
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
			row_content  +=	'<select name="ijenis_bk_id[]" id="ijenis_bk_id'+c+'">';
			<?php $i=0; foreach($jenis_bk as $jbk){
				$css='';
				if ($i==0){
					$css='pertama';
					$i++;
				}
				?>
				row_content  += '<option value="<?php echo $jbk['ijenis_bk_id']?>" class="<?php echo $css ?>"> <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>';
			<?php } ?>
			row_content  += '</select>';
			row_content  +=	'</td>';
			row_content	 += '<td colspan="2" style="border: 1px solid #dddddd; width: 30%">';
			row_content	 += '<input type="file" id="fileuploadbk'+c+'" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" />*';
			row_content  += '<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content  += '<input type="hidden" name="fileid[]" style="width: 70%" value="" /></td>';
			row_content	 += '<td colspan="3" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea></td>';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="bahan_kemas_del" onclick="del_bahan_kemas(this, \'bahan_kemas_del\', \'bahan_kemas\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
		$("#fileuploadbk"+c).change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", table_id, 1, 20000);
	        	$(this).val('');
	        }
	    });
	    $("#ijenis_bk_id"+c).change(function(){
			$(this).find('option').attr('class','');
			url=base_url+'processor/plc/bahan/kemas?action=cekjnsbk';
			$.ajax({
				url: url,
				type: 'post',
				data: 'id='+$(this).val(),
				success: function(data) {
					var o = $.parseJSON(data);
					if(o.id==1){
						$("#ijenis_bk_id"+c+" option[value="+o.value+"]").addClass("pertama");
					}else if(o.id==2){
						$("#ijenis_bk_id"+c+" option[value="+o.value+"]").addClass("kedua");
					}
					
				}		
			});
		});
}
</script>

<table class="hover_table" id="bahan_kemas" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload File</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Jenis Bahan Kemas</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Pilih File</th>
		<th colspan="3" style="border: 1px solid #dddddd;">Keterangan</th>
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
		if((in_array('BD', $mydept))||(in_array('QA', $mydept))||(in_array('BIC', $mydept)) ||(in_array('PD', $mydept)) ||(in_array('PPC', $mydept))) {
			if(!empty($rows)) {
			//print_r($rows);
				foreach($rows as $row) {
			//tambahan untuk download file
			$idsp  = $row['ibk_id'];
			$value = $row['filename'];
			$type = "bahan_kemas";
			if($value != '') {
				if (file_exists('./files/plc/bahan_kemas/'.$idsp.'/'.$value)) {
					$link = base_url().'processor/plc/bahan/kemas?action=download&id='.$idsp.'&path='.$type.'&file='.$value;
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
						<span class="bahan_kemas_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="ijenis_bk_id[]" id="ijenis_bk_id<?php echo $i ?>">
						<?php
						foreach($jenis_bk as $jbk){
							$css='';
							if($row['ijenis_bk_id']==$jbk['ijenis_bk_id']){
								$sel='selected';
								if($jbk['idtipe_bk']==1){
									$css="pertama";
								}elseif($jbk['idtipe_bk']==2){
									$css="kedua";
								}
							} else{$sel='';}
						?>
								<option value="<?php echo $jbk['ijenis_bk_id']?>" <?php echo $sel;?> class="<?php echo $css;?>" > <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>		
						<?php } ?>
						</select>
						<script type="text/javascript">
							$("#ijenis_bk_id<?php echo $i ?>").change(function(){
								$(this).find('option').attr('class','');
								url=base_url+'processor/plc/bahan/kemas?action=cekjnsbk';
								$.ajax({
									url: url,
									type: 'post',
									data: 'id='+$(this).val(),
									success: function(data) {
										var o = $.parseJSON(data);
										if(o.id==1){
											$("#ijenis_bk_id<?php echo $i ?> option[value="+o.value+"]").addClass("pertama");
										}else if(o.id==2){
											$("#ijenis_bk_id<?php echo $i ?> option[value="+o.value+"]").addClass("kedua");
										}
										
									}		
								});
							});
						</script>
					</td>					
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $row['filename'] ?> 
						<input type="hidden" name="namafile[]" style="width: 70%" value="<?php echo $row['filename'] ?>" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $row['id'] ?>" />
					</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
						<?php echo $row['vketerangan'] ?>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bahan_kemas_del" onclick="del_bahan_kemas(this, 'bahan_kemas_del', 'bahan_kemas')">[Hapus]</a></span>
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
						<span class="bahan_kemas_num">1</span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="ijenis_bk_id[]" id="ijenis_bk_id1">
						<?php 
						$i=0;
						foreach($jenis_bk as $jbk){
							$selected='';
							$css='';
							if(($i==0)&&($jbk['idtipe_bk']==1)){
								$selected="selected";
								$css='pertama';
								$i++;
							}
							?>
							<option value="<?php echo $jbk['ijenis_bk_id']?>" <?php echo $selected ?> class="<?php echo $css ?>" > <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>		
						<?php } ?>
						</select>
					</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileuploadbk1" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" /> *
						<input type="hidden" name="namafile[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="" />
						</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bahan_kemas_del" onclick="del_bahan_kemas(this, 'bahan_kemas_del', 'bahan_kemas')">[Hapus]</a></span>
					</td>	
				</tr>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="bahan_kemas_num">2</span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<select name="ijenis_bk_id[]" id="ijenis_bk_id2">
						<?php 
						$i=0;
						foreach($jenis_bk as $jbk){
							$selected='';
							$css='';
							if(($i==0)&&($jbk['idtipe_bk']==2)){
								$selected="selected";
								$css='kedua';
								$i++;
							}
							?>
							<option value="<?php echo $jbk['ijenis_bk_id']?>" <?php echo $selected ?> class="<?php echo $css ?>" > <?php echo $jbk['itipe_bk'].' > '.$jbk['vjenis_bk']?> </option>		
						<?php } ?>
						</select>
					</td>	
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<input type="file" id="fileuploadbk2" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" /> *
						<input type="hidden" name="namafile[]" style="width: 70%" value="" />
						<input type="hidden" name="fileid[]" style="width: 70%" value="" />
						</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 15%">
						<textarea class="" name="fileketerangan[]" style="width: 240px; height: 50px;"></textarea>
					</td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="bahan_kemas_del" onclick="del_bahan_kemas(this, 'bahan_kemas_del', 'bahan_kemas')">[Hapus]</a></span>
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
						<span class="bahan_kemas_num"><?php echo $i ?></span>
					</td>
					<td style="border: 1px solid #dddddd; width: 4%; text-align: center;">
						<?php 
							$ijbk=$row['ijenis_bk_id'];
							$sql = "select mbk.ijenis_bk_id,mbk.vjenis_bk as vjenis_bk,
									(case
										when mbk.itipe_bk=1 then 'Primer'
										when mbk.itipe_bk=2 then 'Sekunder'
										else 'Tersier'
									end) as itipe_bk from plc2.plc2_master_jenis_bk mbk where mbk.ldeleted=0 and mbk.ijenis_bk_id='$ijbk'
									";
							$data = $this->db_plc0->query($sql)->row_array();
						echo $data['itipe_bk'].' > '.$data['vjenis_bk'];
						?>
					</td>						
					<td colspan="2" style="border: 1px solid #dddddd; width: 27%">
						<?php echo $linknya ?>
						<?php echo $row['filename'] ?> 
						</td>	
					<td colspan="3" style="border: 1px solid #dddddd; width: 8%">
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
			<td colspan="6" style="text-align: left;">*) Max File 5 MB : Format = pdf,jpeg,jpg,png,gif,bmp</td><td style="text-align: center">
			<td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_bahan_kemas('bahan_kemas')">Tambah</a></td>
		</tr><?php //}?>
	</tfoot>
</table>

<script>
	 $("#fileuploadbk1").change(function () {
	        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
	        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
	        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "bahan_kemas", 1, 20000);
	        	$(this).val('');
	        }
    	});

  	$("#fileuploadbk2").change(function () {
        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "bahan_kemas", 1, 20000);
        	$(this).val('');
        }
	});

	$("#ijenis_bk_id1").change(function(){
		$(this).find('option').attr('class','');
		url=base_url+'processor/plc/bahan/kemas?action=cekjnsbk';
		$.ajax({
			url: url,
			type: 'post',
			data: 'id='+$(this).val(),
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.id==1){
					$("#ijenis_bk_id1 option[value="+o.value+"]").addClass("pertama");
				}else if(o.id==2){
					$("#ijenis_bk_id1 option[value="+o.value+"]").addClass("kedua");
				}
				
			}		
		});
	})
	$("#ijenis_bk_id2").change(function(){
		$(this).find('option').attr('class','');
		url=base_url+'processor/plc/bahan/kemas?action=cekjnsbk';
		$.ajax({
			url: url,
			type: 'post',
			data: 'id='+$(this).val(),
			success: function(data) {
				var o = $.parseJSON(data);
				if(o.id==1){
					$("#ijenis_bk_id2 option[value="+o.value+"]").addClass("pertama");
				}else if(o.id==2){
					$("#ijenis_bk_id2 option[value="+o.value+"]").addClass("kedua");
				}
				
			}		
		});
	})
	</script>