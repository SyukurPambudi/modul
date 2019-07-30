<?php 

// $sqC = "SELECT p.`vtipe` FROM plc2.`plc2_upb_team` p JOIN plc2.`plc2_upb_team_item` pt ON pt.`iteam_id` = p.`iteam_id`
// 	WHERE p.`ldeleted`=0 AND pt.`ldeleted` = 0 AND pt.`vnip` = '".$this->user->gNIP."'";
// $dtN = $this->db_plc0->query($sqC)->row_array();
// if(empty($dtN['vtipe'])){
// 	$dtN['vtipe'] = '-';
// }
// /*
$sqC = "SELECT DISTINCT (p.`vtipe`) FROM plc2.`plc2_upb_team` p JOIN plc2.`plc2_upb_team_item` pt 
ON pt.`iteam_id` = p.`iteam_id` WHERE p.`ldeleted`=0 AND pt.`ldeleted` = 0 AND (pt.`vnip` = '".$this->user->gNIP."' OR p.`vnip` = '".$this->user->gNIP."')";

$dtN = $this->db_plc0->query($sqC)->result_array();
$tipe = array();
foreach ($dtN as $v) {
	array_push($tipe,$v['vtipe']);
}  



?>
<div class="reload1">
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
	var tmpDel = $("#lpo_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#lpo_del").val() );
});
function add_row_aplpo_upload3(table_id,idFile){		
		//alert(table_id+'_'+idFile);
		$('.doneHilangAll_'+idFile).html('');
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num2:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	 += '<tr>';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '		<input  type="file" id="fileupload_applet3" class="fileupload3 multi multifile required" name="fileupload3_'+idFile+'[]" style="width: 70%" /> *';
			row_content	 += '		<input  type="hidden" name="namafile3_'+idFile+'[]" style="width: 70%" value="" />';
			row_content	 += '		<input  type="hidden" name="fileid3_'+idFile+'[]" style="width: 70%" value="" />';
			row_content	 += '	</td>	';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '		-';
			row_content	 += '	</td>';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '		-';
			row_content	 += '	</td> ';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '		<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,\''+table_id+'\',3,0)">[Hapus]</a>'; 
			row_content	 += '	</td> ';
			row_content	 += '</tr> ';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';

			row_content	 += '<tr>';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '		<input  type="file" id="fileupload_applet3" class="fileupload3 multi multifile required" name="fileupload3[]" style="width: 70%" /> *';
			row_content	 += '		<input  type="hidden" name="namafile3[]" style="width: 70%" value="" />';
			row_content	 += '		<input  type="hidden" name="fileid3[]" style="width: 70%" value="" />';
			row_content	 += '	</td>	';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '		-';
			row_content	 += '	</td>';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '		-';
			row_content	 += '	</td> ';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '		<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,\''+table_id+'\',3,0)">[Hapus]</a>'; 
			row_content	 += '	</td> ';
			row_content	 += '</tr> ';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num2:last").text(c);		
		} 
		$("#datepicker"+table_id+c).datepicker({dateFormat:"yy-mm-dd"}); 

}

function add_row_aplpo_upload(table_id,idFile){		 
		var row = $('table#'+table_id+' tbody.lpo_upload_body tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	 += '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '	<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '		<span class="lpo_upload_num">1</span>';
			row_content	 += '	</td>		';
			row_content	 += '		<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '		<input type="file" id="fileupload_applet" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" /> *';
			row_content	 += '		<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content	 += '		<input type="hidden" name="fileid[]" style="width: 70%" value="" />';
			row_content	 += '	</td>	';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%;" >';
			row_content	 += '		<i>Save File First !!</i> ';
			row_content	 += '	</td> ';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 5%;" >';
			row_content	 += '		<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,\''+table_id+'\',1,0)">[Hapus]</a>'; 
			row_content	 += '	</td> ';
			row_content	 += '</tr> '; 
			
			jQuery("#"+table_id+" tbody.lpo_upload_body").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';

			row_content	 += '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '	<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '		<span class="lpo_upload_num">1</span>';
			row_content	 += '	</td>		';
			row_content	 += '		<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '		<input type="file" id="fileupload_applet" class="fileupload multi multifile required" name="fileupload[]" style="width: 70%" /> *';
			row_content	 += '		<input type="hidden" name="namafile[]" style="width: 70%" value="" />';
			row_content	 += '		<input type="hidden" name="fileid[]" style="width: 70%" value="" />';
			row_content	 += '	</td>	';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%;" >';
			row_content	 += '		<i>Save File First !!</i> ';
			row_content	 += '	</td> ';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 5%;" >';
			row_content	 += '		<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,\''+table_id+'\',1,0)">[Hapus]</a>'; 
			row_content	 += '	</td> ';
			row_content	 += '</tr> '; 
			
			jQuery("#"+table_id+" tbody.lpo_upload_body").append(row_content);
			$("span."+table_id+"_num:last").text(c);		
		} 
		$("#datepicker"+table_id+c).datepicker({dateFormat:"yy-mm-dd"}); 

}

function add_row_aplpo_upload2(table_id,idFile){		
		//alert(table_id+'_'+idFile);
		$('.hilangapkedua_'+idFile).html('');
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num2:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	 += '			<tr>';
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 2%">';
			row_content	 += '				<span class="'+table_id+'_num2">1</span></td>';	
			row_content	 += '			</td>	';

			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%">'; 	
			row_content	 += '				<input type="text" name="namaDokumen_'+idFile+'[]" style="width: 70%" value="" />';
			row_content	 += '			</td>	';
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '				<input type="text" id="datepicker'+table_id+c+'" class="datepicker'+table_id+c+'" name="Deadline_'+idFile+'[]" style="width: 70%" value="" />';
			row_content	 += '			</td>';
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '<select name="vpic_td_dis_'+idFile+'[]" id="vpic_td_dis1" class="required">';
			row_content	 += '<option value="">Pilih Manager</option>';
							<?php 
							foreach ($rpic as $p) {
							?>
								row_content	 += '<option value="<?php echo $p['vtipe']; ?>"><?php echo $p['vtipe']; ?> Manager</option>';
							<?php
								}
							?>
			row_content	 += '</select> ';


			row_content	 += '			</td>'; 
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '				<span class="hilangap1_'+idFile+'">';
			row_content	 += '					<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,\''+table_id+'\',2,0)">[Hapus]</a>'; 
			row_content	 += '				</span>';
			row_content	 += '			</td>';	
			row_content	 += '		</tr>'; 
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';

			row_content	 += '			<tr>';
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 2%">';
			row_content	 += '				<span class="'+table_id+'_num2">1</span></td>';	
			row_content	 += '			</td>	';
			
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '				<input type="text" name="namaDokumen_'+idFile+'[]" style="width: 70%" value="" />';
			row_content	 += '			</td>	';
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '				<input type="text" id="datepicker'+table_id+c+'" class="datepicker'+table_id+c+'" name="Deadline_'+idFile+'[]" style="width: 70%" value="" />';
			row_content	 += '			</td>';
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> ';
			row_content	 += '<select name="vpic_td_dis_'+idFile+'[]" id="vpic_td_dis1" class="required">';
			row_content	 += '<option value="">Pilih Manager</option>';
							<?php 
							foreach ($rpic as $p) {
							?>
								row_content	 += '<option value="<?php echo $p['vtipe']; ?>"><?php echo $p['vtipe']; ?> Manager</option>';
							<?php
								}
							?>
			row_content	 += '</select> ';


			row_content	 += '			</td>';
			 
			row_content	 += '			<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '				<span class="hilangap1_'+idFile+'">';
			row_content	 += '					<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,\''+table_id+'\',2,0)">[Hapus]</a>'; 
			row_content	 += '				</span>';
			row_content	 += '			</td>';
			row_content	 += '		</tr>'; 
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num2:last").text(c);		
		} 
		$("#datepicker"+table_id+c).datepicker({dateFormat:"yy-mm-dd"}); 

}
</script>

<table class="hover_table" id="lpo_upload" cellspacing="0" cellpadding="1" style="width: 150%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 150%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Tambahan</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 15%;">Pilih File</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 80%;">Detail</th> 
		<th colspan="1" style="border: 1px solid #dddddd;width: 80%;">Action</th> 	
	</tr>
	</thead>
	<tbody class="lpo_upload_body">
	  	<?php 
	  		if(empty($applet1)){ 
	  	?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
				<span class="lpo_upload_num">1</span>
			</td>		
			<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
				<input type="file" id="fileupload_applet" class="fileupload multi multifile" name="fileupload[]" style="width: 70%" /> *
				<input type="hidden" name="namafile[]" style="width: 70%" value="" />
				<input type="hidden" name="fileid[]" style="width: 70%" value="" />
			</td>	
			<td colspan="1" style="border: 1px solid #dddddd; width: 15%;" >
				<i>Save File First !!</i> 
			</td> 
			<td colspan="1" style="border: 1px solid #dddddd; width: 5%;" >
				-
			</td> 
		</tr> 
		<?php }else{
			$no = 1;
			foreach ($applet1 as $applet) { ?>

				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
					<span class="lpo_upload_num"><?php echo $no?></span>
				</td>		
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 

					<?php 
					//dOWNLOAD fILE iN hERE 
					$value = $applet['vfilename'] ;
					if($value != '') {
						if (file_exists('./files/plc/appletnew/'.$iupb_id.'/'.$value)) {
							$link = base_url().'processor/plc/applet?action=download1&id='.$iupb_id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$applet['vfilename'].'</a>';
							echo $linknya;
						}
						else {
							echo $applet['vfilename'];
						}
					}
					else { 
						echo $applet['vfilename'];
					}	
					?>
					<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $applet['iappletfile1']?>" />
				</td>	
				<td colspan="3" style="border: 1px solid #dddddd; width: 15%"> 


					
					 <table class="hover_table" id="lpo_upload2_<?php echo $applet['iappletfile1'] ?>" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
						<thead> 
						<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
							<th style="border: 1px solid #dddddd; width: 1%;" >No</th>
							<th style="border: 1px solid #dddddd; width: 25%;" >Nama Dokumen</th>
							<th colspan="1" style="border: 1px solid #dddddd; width: 15%;">Tanggal Deadline</th>
							<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">PIC TD</th>  
							<?php 
								if($applet['idoneAdd'] == 1){
									?>
										<th colspan="1" style="border: 1px solid #dddddd;width: 80%;">Detail Dokumen</th> 

										<th colspan="1" style="border: 1px solid #dddddd;width: 80%;">Tanggal Kesepakatan AD</th>  
									<?php
								}
							?>
							<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">Action</th> 
						</tr>
						</thead> 
						<tbody class="lpo_upload2_body">

						<?php  
							$sqlRw = "SELECT * FROM plc2.`appletfile2` h WHERE h.`ldelete` = 0 AND h.`iappletfile1` =".$applet['iappletfile1'];
							//echo $sqlRw;
							$sqNrw = $this->dbset->query($sqlRw)->num_rows();
							if($sqNrw>0){
								$row2 = $this->dbset->query($sqlRw)->result_array();
								$i = 1 ; 
								foreach ($row2 as $r2) { 
									 $red = '';
									 if($applet['idoneAdd'] == 1){
									 	$red = ' readonly ';
									 }
								?>
									<tr>
										<td colspan="1" style="border: 1px solid #dddddd; width: 2%"> 
											<span class="lpo_upload2_<?php echo $applet['iappletfile1'] ?>_num2"><?php echo $i++ ?></span></td>
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
											<input <?php echo $red ?> type="text" name="namaDokumen_<?php echo $applet['iappletfile1']?>[]" style="width: 70%" value="<?php echo $r2['vnamaDokumen']?>" />
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<?php if($applet['idoneAdd'] == 1){?> 
												<input  type="hidden" id="datepicker_<?php echo $r2['iappletfile2']?>" class="datepicker_<?php echo $r2['iappletfile2']?>" name="Deadline_<?php echo $applet['iappletfile1']?>[]" style="width: 70%" value="<?php echo $r2['dDeadline']?>" />
												<input  disabled type="text" id="datepicker_<?php echo $r2['iappletfile2']?>" class="datepicker_<?php echo $r2['iappletfile2']?>" name="Deadline_<?php echo $applet['iappletfile1']?>[]" style="width: 70%" value="<?php echo $r2['dDeadline']?>" />
											<?php }else{ ?>
												<input  type="text" id="datepicker_<?php echo $r2['iappletfile2']?>" class="datepicker_<?php echo $r2['iappletfile2']?>" name="Deadline_<?php echo $applet['iappletfile1']?>[]" style="width: 70%" value="<?php echo $r2['dDeadline']?>" />
											<?php } ?>

											<script type="text/javascript">
												$(".datepicker_<?php echo $r2['iappletfile2']?>").datepicker({dateFormat:"yy-mm-dd"}); 
											</script>
										</td>
										<td colspan="1" style="border: 1px solid #dddddd; width: 10%"> 
											<?php if($applet['idoneAdd'] == 1){?> 
												<input  type="hidden" name="vpic_td_dis_<?php echo $applet['iappletfile1']?>[]" id="vpic_td_dis1" value="<?php echo $r2['vTeamPD']?>" /> 
												<?php  echo $r2['vTeamPD']; ?> Manager
											<?php }else{ ?>
											<select name="vpic_td_dis_<?php echo $applet['iappletfile1']?>[]" id="vpic_td_dis1" class="required">
											<option value="">Pilih Manager</option>
											<?php 
											foreach ($rpic as $p) {
												if($p['vtipe'] == $r2['vTeamPD']){
													$sel = 'selected';
												}else{
													$sel = '';
												}
												
											?>
												<option <?php echo $sel; ?> value="<?php echo $p['vtipe']; ?>"><?php echo $p['vtipe']; ?> Manager</option>
											<?php
												}
											?>
											</select> 
											<?php } ?>
										</td> 

										<?php 
											if($applet['idoneAdd'] == 1){
												?><td colspan="1" style="border: 1px solid #dddddd; width: 30%"> 
													<?php 
 
													if(in_array($r2['vTeamPD'], $tipe) or in_array('BD', $tipe)){
													?> 	 
														<table class="hover_table" id="lpo_upload3_<?php echo $r2['iappletfile2']?>" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
															<thead> 
															<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
																<th style="border: 1px solid #dddddd; width: 25%;" >Upload File</th>
																<th colspan="1" style="border: 1px solid #dddddd; width: 15%;">Tanggal Upload</th>
																<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">Revisi/Tdk</th>  
																<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">Action</th>  
															</tr>
															</thead> 
															<tbody class="lpo_upload3_body">
																<?php 
																	$sqlData2 = "SELECT * FROM plc2.`appletfile3` h WHERE h.`ldelete` = 0 AND h.`iappletfile2` = ".$r2['iappletfile2'];
																	$inData2 = $this->dbset->query($sqlData2)->result_array();
																	if(empty($inData2)){
																?>
																	<tr>
																		<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
																			<?php if(in_array($r2['vTeamPD'], $tipe)){?>
																			<input  type="file" id="fileupload_applet3" class="fileupload3 multi multifile required" name="fileupload3_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" /> *
																			<input  type="hidden" name="namafile3_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" value="" />
																			<input  type="hidden" name="fileid3_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" value="" />
																			<?php } else{ echo '-';} ?>
																		</td>	
																		<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																			-
																		</td>
																		<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																			-
																		</td> 
																		<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																			<?php if(in_array($r2['vTeamPD'], $tipe)){?>
																				<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,'lpo_upload3_<?php echo $r2['iappletfile2']?>',3,0)">[Hapus]</a>
																			<?php } else{ echo '-';} ?>
																		</td> 
																	</tr>
																<?php } else { 
																		foreach ($inData2 as $idt) { 
																	?>
																			<tr>
																				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">

																					<?php 
																					$value = $idt['vfilename'];
																					if($value != '') {
																						if (file_exists('./files/plc/appletnew/'.$iupb_id.'/detail/'.$r2['iappletfile2'].'/'.$value)) {
																							$link = base_url().'processor/plc/applet?action=download2&id='.$iupb_id.'&id2='.$r2['iappletfile2'].'&file='.$value;
																							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$idt['vfilename'].'</a>';
																							echo $linknya;
																						}
																						else {
																							echo $idt['vfilename'];
																						}
																					}
																					else { 
																						echo $idt['vfilename'];
																					}	

																					echo '<br>';


																						if($idt['irevisi']==1){
																							if(in_array($r2['vTeamPD'], $tipe)){
																							?>
																								<input  type="file" id="fileupload_applet3" class="fileupload3 multi multifile required" name="fileupload3_<?php echo $r2['iappletfile2'].'_'.$idt['iappletfile3'] ?>[]" style="width: 70%" /> *
																							<?php
																							}else{
																								echo 'File Belum di Revisi';
																							}
																						}
																					?>
																					<input  type="hidden" name="namafile3_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" value="<?php echo $idt['vfilename']?>" />
																					<input  type="hidden" name="fileid3_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" value="<?php echo $idt['iappletfile3']?>" />
																				</td>	
																				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																					<?php 
																					$sqEm = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$idt['cupload']."'";
																					$dtName = $this->dbset->query($sqEm)->row_array();
																					echo $idt['cupload'].' - '.$dtName['vName'].' - '.$idt['dupload']?>
																				</td>
																				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																					<span class="hasil_rev_<?php echo $idt['iappletfile3'] ?>">
																					<?php 
																					if($idt['iDone']==1){
																						if(in_array('BD', $tipe)){
																							$dtar = array(1=>'Revisi',2=>'Tidak');
																								if($idt['irevisi']==2){
																									echo ' Tidak ';
																								}elseif($idt['irevisi']==1){
																									echo ' Revisi ';
																								} else{
																							?>
																								<select class="revis_<?php echo $idt['iappletfile3'] ?>" name="revis_file[]">
																									<option value="">-- Pilih --</option>
																									<?php 
																										foreach ($dtar as $dt=>$v) {
																											echo '<option value="'.$dt.'">'.$v.'</option>';
																										}
																									?>
																								</select>
																							<?php
																								}

																						}else{
																							//if($idt['iDone']==1){
																								if($idt['irevisi']==2){
																									echo ' Tidak ';
																								}elseif($idt['irevisi']==1){
																									echo ' Revisi ';
																								} else{
																									echo ' Waiting ';
																								}
																							//}
																						}
																					}else{
																						if($idt['irevisi']==2){
																							echo ' Tidak ';
																						}elseif($idt['irevisi']==1){
																							echo ' Revisi ';
																						} else{
																							echo '';
																						}
																					}
																					?>
																				</span>
																				</td> 
																				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																					<span class="tambahdoneHilangAll_<?php echo $r2['iappletfile2']?>">
																					<?php 
																						if($idt['iDone']==1){
																							if(in_array('BD', $tipe)){
																								if($idt['irevisi']==2){
																									echo '-';
																								}else{
																									if($iLvlemp>4){
																								?>
																									<span class="hilangap3_<?php echo $idt['iappletfile3'] ?>">
																										<a href="javascript:;" onclick="javascript:donefileap1(<?php echo $idt['iappletfile3']?>)">[Done]</a>  
																									</span>
																								<?php
																									} 
																								}
																							}else{
																								echo ' - ';
																							}
																						}else{
																							if(in_array($r2['vTeamPD'], $tipe)){
																							?>
																								<span class="hilangap2_<?php echo $idt['iappletfile3'] ?>">
																									<?php if($idt['irevisi']!=1){
																										if($iLvlemp>4){	?>
																											<a href="javascript:;" onclick="javascript:donefileap(<?php echo $idt['iappletfile3']?>,<?php echo $idt['iappletfile2']?>)">[Done]</a>  
																										<?php } ?>
																									 
																											<a href="javascript:;" onclick="javascript:deleteRowtable(this,1,'lpo_upload3_<?php echo $r2['iappletfile2']?>',3,<?php echo $idt['iappletfile3']?>)">[Hapus]</a>
																									<?php } ?>
																								</span>
																							<?php 
																							}else{
																								echo ' - ';
																							}
																						}
																					?>
																					</span>
																				</td> 
																			</tr>
																<?php }} ?>
															</tbody>
															<tfoot>
																<tr>
																	<td colspan="4" style="text-align: right">  

																		<?php  if(in_array($r2['vTeamPD'], $tipe)){  
																				if($r2['iDoneAll']==0){
																				?> 
																				<span class="tambahdoneHilangAll_<?php echo $r2['iappletfile2']?>">
																					<a href="javascript:;" onclick="javascript:add_row_aplpo_upload3('lpo_upload3_<?php echo $r2['iappletfile2']?>',<?php echo $r2['iappletfile2']?>)">[Tambah]</a> 
																					<?php 
																						$sq = "SELECT * FROM plc2.`appletfile3` h WHERE h.`ldelete` = 0 AND h.`iappletfile2` = ".$r2['iappletfile2'];
																						$ck = $this->dbset->query($sq)->num_rows();
																						if($ck>0){
																							if($iLvlemp>4){	
																					?>
																					<span class="doneHilangAll_<?php echo $r2['iappletfile2']?>">
																						<a href="javascript:;" onclick="javascript:donefileap3(<?php echo $r2['iappletfile2']?>)">[Done]</a> 
																					</a> 
																					</span>
																		<?php }}}} ?>
																	</td>
																</tr>
															</tfoot> 
														</table>   

													<script type="text/javascript">
														 
													</script>

													<?php } ?>


												</td>

												<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
													<?php  
													if(empty($r2['dcAndev']) OR $r2['dcAndev'] == "0000-00-00"){
														if($r2['vTeamPD']=="AD" && in_array('AD', $tipe)){ 
														?>
															<input  type="text" id="datepickerAD_<?php echo $r2['iappletfile2']?>" class="datepickerAD_<?php echo $r2['iappletfile2']?>" name="DeadlineAD_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" value="<?php echo $r2['dcAndev']?>" />
														<?php
														}else{
															echo '-';
															 
														}
													}else{
														if(in_array('AD', $tipe)){ 
															?>
																<input  type="text" id="datepickerAD_<?php echo $r2['iappletfile2']?>" class="datepickerAD_<?php echo $r2['iappletfile2']?>" name="DeadlineAD_<?php echo $r2['iappletfile2']?>[]" style="width: 70%" value="<?php echo $r2['dcAndev']?>" />
															<?php
														}else{
															echo $r2['dcAndev'];
														} 
													} ?> 
													<script type="text/javascript">
														$(".datepickerAD_<?php echo $r2['iappletfile2']?>").datepicker({dateFormat:"yy-mm-dd"}); 
													</script>
												</td>
												<?php
											}
										?>


										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<span class="hilangap1_<?php echo $applet['iappletfile1']?>">
												<?php
													if($applet['idoneAdd']!=1){
														?>
															<a href="javascript:;" onclick="javascript:deleteRowtable(this,1,'lpo_upload2_<?php echo $applet['iappletfile1'] ?>',2,<?php echo $r2['iappletfile2']?>)">[Hapus]</a>
														<?php
													}else{
														$idone = $applet['idoneAdd'];
														echo '-';
													} 
												?>
												
											</span>
										</td>
									</tr>

								<?php
								}
							}else{
								?>
									<tr>
										<td colspan="1" style="border: 1px solid #dddddd; width: 2%"> 
											<span class="lpo_upload2_<?php echo $applet['iappletfile1'] ?>_num2">1</span></td>
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
											<input  type="text" name="namaDokumen_<?php echo $applet['iappletfile1']?>[]" style="width: 70%" value="" />
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<input  type="text" id="datepicker_<?php echo $applet['iappletfile1']?>_<?php echo $applet['iappletfile1']?>" class="datepicker_<?php echo $applet['iappletfile1']?>_<?php echo $applet['iappletfile1']?>" name="Deadline_<?php echo $applet['iappletfile1']?>[]" style="width: 70%" value="" />
											<script type="text/javascript">
												$("#datepicker_<?php echo $applet['iappletfile1']?>_<?php echo $applet['iappletfile1']?>").datepicker({dateFormat:"yy-mm-dd"}); 
											</script>
										</td>
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<select name="vpic_td_dis_<?php echo $applet['iappletfile1']?>[]" id="vpic_td_dis1" class="required">
											<option value="">Pilih Manager</option>
											<?php 
											foreach ($rpic as $p) {
											?>
												<option value="<?php echo $p['vtipe']; ?>"><?php echo $p['vtipe']; ?> Manager</option>
											<?php
												}
											?>
											</select> 
										</td> 
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<span class="hilangap1_<?php echo $applet['iappletfile1']?>">  
												<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,'lpo_upload2_<?php echo $applet['iappletfile1'] ?>',2,0)">[Hapus]</a>
											</span>
										</td>
									</tr>
								<?php
							}
						?>
							

						</tbody>
						<tfoot>
							<tr>
								<td colspan="4" style="text-align: left"> </td><td style="text-align: center"> 
									<div class="hilangap1_<?php echo $applet['iappletfile1']?>">
										<?php if($applet['idoneAdd'] != 1){
											$sq = "SELECT * FROM plc2.`appletfile2` h WHERE h.`ldelete` = 0 AND h.`iappletfile1` = ".$applet['iappletfile1'];
											$ck = $this->dbset->query($sq)->num_rows();
										?>
										<a href="javascript:;" onclick="javascript:add_row_aplpo_upload2('lpo_upload2_<?php echo $applet['iappletfile1'] ?>',<?php echo $applet['iappletfile1']?>)">[Tambah]</a>
										<?php 
											if($ck>0){
												?>
													<span class="hilangapkedua_<?php echo $applet['iappletfile1']?>">
														<a href="javascript:;" onclick="javascript:hilangap1(<?php echo $applet['iappletfile1']?>)">[Done]</a>	 
													</span>
												<?php
											}
										?>
										
										<?php }else{echo '-';}?>
									</div>
								</td>
							</tr>
						</tfoot>


						 
					</table>   
				</td>
				 
			</tr> 

		<?php $no++; }}?>

	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" style="text-align: right">  
				<?php 
					 
					 
					if(in_array('BD', $tipe)){ 
						$sql = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
							JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
							JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0
							AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL) 
							AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$iupb_id."'";
						$c1 = $this->dbset->query($sql)->num_rows();
						$sql2 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
							JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1`
							JOIN plc2.`appletfile3` h3 ON h3.`iappletfile2` = h2.`iappletfile2`
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
							AND h.`iupb_id` = '".$iupb_id."'";
						$c2 = $this->dbset->query($sql2)->num_rows();
					//Cek Don File untuk Manager Khusus Dia

						$sql3 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
						JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  
						AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$iupb_id."'";
						$c11 = $this->dbset->query($sql3)->num_rows();
						$sql4 = "SELECT h2.`iappletfile2`FROM plc2.`appletfile1` h 
							JOIN plc2.`appletfile2` h2 ON h.`iappletfile1` = h2.`iappletfile1` 
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` = '".$iupb_id."'";
						$c22 = $this->dbset->query($sql4)->num_rows();
						

						$sqL5 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
							WHERE h.idoneAdd=1 AND h.`ldelete` = 0 AND  h.`iupb_id` = '".$iupb_id."'";
						$c111 = $this->dbset->query($sqL5)->num_rows();
						$sqL6 = "SELECT  h.`iappletfile1` FROM plc2.`appletfile1` h   
							WHERE h.`ldelete` = 0 AND  h.`iupb_id` = '".$iupb_id."'";
						$c222 = $this->dbset->query($sqL6)->num_rows();


						if($c1==$c2 && $c11==$c22 && $c111==$c222 && $iappbd_applet==0 && $c222>0){  
						?>
							<div>
								<a href="javascript:;" onclick="javascript:add_row_aplpo_upload('lpo_upload')">[Tambah]</a>
							</div>
						<?php 
						}
					} 
				?>
				
			</td>
		</tr>
	</tfoot>
	
</table>


<script>
	var last_id = <?php echo $iupb_id?>;
	var url2 =  "<?php echo base_url().'processor/plc/applet'; ?>";

	$(".datepicker").datepicker({dateFormat:"yy-mm-dd"});
	$("#fileupload_applet").change(function () {
        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info", "info", "lpo", 1, 20000);
        	$(this).val('');
        }
	});

	function deleteRowtable(r,idhapus,idtable,itipe,idindex) {
		jumlah=document.getElementById(idtable).rows.length; 
		//Total 3 Header/ Body/ Footer
		if(jumlah>3){
			if(idhapus>0){
				$.ajax({
	            url: "<?php echo base_url().'processor/plc/applet?action=hapustableap' ?>",
	            type: 'POST',
	            data: {
	                id_file: idindex, 
	                tipe: itipe,
	            },
	            async: false, 
	            success: function(data) {  
	            	var i = $(r).closest('tr').index();  
					document.getElementById(idtable).deleteRow(i+1);
	            	 _custom_alert('Done, data berhasil di hapus');
	            	$.get(url2+"?action=update&id="+last_id, function(data) {
                            $("div#form_applet").html(data); 
                    });
	            }
	        });
			}else{   
				var i = $(r).closest('tr').index();    
				if(itipe==1){
					i++;
				}
				document.getElementById(idtable).deleteRow(i+1);   
			} 
		}else{
			_custom_alert('Data Minimal 1');
		}
		

	}

	function hilangap1(id){
		$.ajax({
            url: "<?php echo base_url().'processor/plc/applet?action=hilangap1' ?>",
            type: 'POST',
            data: {
                id_file: id, 
                iupb_id: <?php echo $iupb_id?>,
            },
            async: false, 
            success: function(data) { 
            	 $('.hilangap1_'+id).html('-');
            	 $('.reload1'+id).html(data);
            	 _custom_alert('Done, Anda tidak bisa menambahkan dokumen Kembali');
            	 $.get(url2+"?action=update&id="+last_id, function(data) {
                    $("div#form_applet").html(data); 
                 });
            }
        });
	}
	
	function donefileap(id,id2){
		$.ajax({
            url: "<?php echo base_url().'processor/plc/applet?action=donefileap' ?>",
            type: 'POST',
            data: {
                id_file: id,  
                id_file2: id2,   
            },
            async: false, 
            success: function(data) { 
            	 $('.hilangap2_'+id).html('-'); 
            	 _custom_alert('Done, file akan diCek oleh BD');
            	 $.get(url2+"?action=update&id="+last_id, function(data) {
                    $("div#form_applet").html(data); 
                 });
            }
        }); 
	}
	function donefileap3(id){
		$.ajax({
            url: "<?php echo base_url().'processor/plc/applet?action=donefileapall' ?>",
            type: 'POST',
            data: {
                id_file: id,   
            },
            async: false, 
            success: function(data) { 
            	 $('.tambahdoneHilangAll_'+id).html('-'); 
            	 _custom_alert('Done, Semua file akan diCek oleh BD');
            	 $.get(url2+"?action=update&id="+last_id, function(data) {
                    $("div#form_applet").html(data); 
                 });
            }
        }); 
	}
	function donefileap1(id){
		var hasilrev = $('.revis_'+id).val(); 
		if(hasilrev!=''){
			$.ajax({
	            url: "<?php echo base_url().'processor/plc/applet?action=donefileaprevisi' ?>",
	            type: 'POST',
	            data: {
	                id_file: id,  
	                revisi:hasilrev, 
	            },
	            async: false, 
	            success: function(data) { 
	            	 $('.hilangap3_'+id).html('-');  
	            	 if(hasilrev==1){
	            	 	$('.hasil_rev_'+id).html('Revisi');  
	            	 }else{
	            	 	 $('.hasil_rev_'+id).html('Tidak');
	            	 } 
	            	 
	            	 _custom_alert('Done');

	            	$.get(url2+"?action=update&id="+last_id, function(data) {
                            $("div#form_applet").html(data); 
                    });
	            }
	        });
		}else{
			_custom_alert('Pilih Hasil Revisi !!');
		}
		 
	}
</script>
</div>