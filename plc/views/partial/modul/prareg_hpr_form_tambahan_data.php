
<?php 
	$grid=str_replace("_".$field, "", $id);
    $iupb_id=isset($dataHead["iupb_id"])?$dataHead["iupb_id"]:"0";
    $iappbd_hpr=isset($dataHead["iappbd_hpr"])?$dataHead["iappbd_hpr"]:"0";
	$iappbusdev_prareg=isset($dataHead["iappbusdev_prareg"])?$dataHead["iappbusdev_prareg"]:"0";
	$get=$this->input->get();

// $sqC = "SELECT p.`vtipe` FROM plc2.`plc2_upb_team` p JOIN plc2.`plc2_upb_team_item` pt ON pt.`iteam_id` = p.`iteam_id`
// 	WHERE p.`ldeleted`=0 AND pt.`ldeleted` = 0 AND pt.`vnip` = '".$this->user->gNIP."'";
// $dtN = $this->db_plc0->query($sqC)->row_array();
// if(empty($dtN['vtipe'])){
// 	$dtN['vtipe'] = '-';
// }
// /*

$sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
from hrd.employee a 
join hrd.msdepartement b on b.iDeptID=a.iDepartementID
join hrd.position c on c.iPostId=a.iPostID
where a.cNip ="'.$this->user->gNIP.'"
';
$iAm = $this->db_plc0->query($sql)->row_array();
$iLvlemp = $iAm['iLvlemp'];


$sqC = "SELECT DISTINCT (p.`vtipe`) FROM plc2.`plc2_upb_team` p JOIN plc2.`plc2_upb_team_item` pt 
ON pt.`iteam_id` = p.`iteam_id` WHERE p.`ldeleted`=0 AND pt.`ldeleted` = 0 AND (pt.`vnip` = '".$this->user->gNIP."' OR p.`vnip` = '".$this->user->gNIP."')";

$dtN = $this->db->query($sqC)->result_array();
$tipe = array();
foreach ($dtN as $v) {
	array_push($tipe,$v['vtipe']);
}  
$qp="select distinct(vtipe) from plc2.plc2_upb_team where ldeleted=0 and vtipe!='' ";
$rpic= $this->db_plc0->query($qp)->result_array();

$qp="SELECT * FROM plc2.`hprfile1` h WHERE h.`ldelete` = 0 AND h.`iupb_id` = '".$iupb_id."' ";
$hpr1 = $this->db_plc0->query($qp)->result_array();


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
function add_row_lpo_upload3(table_id,idFile){
		$('.doneHilangAll_'+idFile).html('');
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num2:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content	 += '<tr>';
			row_content	 += '	<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content	 += '		<input  type="file" id="fileupload_hpr3" class="fileupload3 multi multifile required" name="fileupload3_'+idFile+'[]" style="width: 70%" /> *';
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
			row_content	 += '		<input  type="file" id="fileupload_hpr3" class="fileupload3 multi multifile required" name="fileupload3[]" style="width: 70%" /> *';
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

function add_row_lpo_upload(table_id,idFile){		 
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
			row_content	 += '		<input type="file" id="fileupload_hpr" class="fileupload multi multifile required" name="fileupload_hpr[]" style="width: 70%" /> *';
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
			row_content	 += '		<input type="file" id="fileupload_hpr" class="fileupload multi multifile required" name="fileupload_hpr[]" style="width: 70%" /> *';
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

function add_row_lpo_upload2(table_id,idFile){		
		$('.hilangkedua_'+idFile).html('');
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
			row_content	 += '				<span class="hilang1_'+idFile+'">';
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
			row_content	 += '				<span class="hilang1_'+idFile+'">';
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

<table class="hover_table" id="lpo_upload" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 99%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Upload Dokumen Tambahan</span></th>
	</tr>
	<tr style="width: 99%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 20%;">Pilih File</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 80%;">Detail</th> 
		<th colspan="1" style="border: 1px solid #dddddd;width: 5%;">Action</th> 	
	</tr>
	</thead>
	<tbody class="lpo_upload_body">
	  	<?php 
	  		if(empty($hpr1)){ 
	  	?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
				<span class="lpo_upload_num">1</span>
			</td>		
			<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
				<input type="file" id="fileupload_hpr" class="fileupload multi multifile" name="fileupload_hpr[]" style="width: 70%" /> *
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
			foreach ($hpr1 as $hpr) { ?>

				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
					<span class="lpo_upload_num"><?php echo $no?></span>
				</td>		
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 

					<?php 
					//dOWNLOAD fILE iN hERE 
					$value = $hpr['vfilename'] ;
					if($value != '') {
						if (file_exists('./files/plc/hprnew/'.$iupb_id.'/'.$value)) {
							$link = base_url().'processor/plc/v3/prareg/hpr?action=download1&id='.$iupb_id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$hpr['vfilename'].'</a>';
							echo $linknya;
						}
						else {
							echo $hpr['vfilename'];
						}
					}
					else { 
						echo $hpr['vfilename'];
					}	
					?>
					<input type="hidden" name="fileid[]" style="width: 70%" value="<?php echo $hpr['ihprfile1']?>" />
				</td>	
				<td colspan="3" style="border: 1px solid #dddddd; width: 15%"> 


					
					 <table class="hover_table" id="lpo_upload2_<?php echo $hpr['ihprfile1'] ?>" cellspacing="0" cellpadding="1" style="width: 99%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
						<thead> 
						<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
							<th style="border: 1px solid #dddddd; width: 1%;" >No</th>
							<th style="border: 1px solid #dddddd; width: 25%;" >Nama Dokumen</th>
							<th colspan="1" style="border: 1px solid #dddddd; width: 15%;">Tanggal Deadline</th>
							<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">PIC TD</th>  
							<?php 
								if($hpr['idoneAdd'] == 1){
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
							$sqlRw = "SELECT * FROM plc2.`hprfile2` h WHERE h.`ldelete` = 0 AND h.`ihprfile1` =".$hpr['ihprfile1'];
							//echo $sqlRw;
							$sqNrw = $this->db->query($sqlRw)->num_rows();
							if($sqNrw>0){
								$row2 = $this->db->query($sqlRw)->result_array();
								$i = 1 ; 
								foreach ($row2 as $r2) { 
									 $red = '';
									 if($hpr['idoneAdd'] == 1){
									 	$red = ' readonly ';
									 }
								?>
									<tr>
										<td colspan="1" style="border: 1px solid #dddddd; width: 2%"> 
											<span class="lpo_upload2_<?php echo $hpr['ihprfile1'] ?>_num2"><?php echo $i++ ?></span></td>
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
											<input <?php echo $red ?> type="text" name="namaDokumen_<?php echo $hpr['ihprfile1']?>[]" style="width: 70%" value="<?php echo $r2['vnamaDokumen']?>" />
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<?php if($hpr['idoneAdd'] == 1){?> 
												<input  type="hidden" id="datepicker_<?php echo $r2['ihprfile2']?>" class="datepicker_<?php echo $r2['ihprfile2']?>" name="Deadline_<?php echo $hpr['ihprfile1']?>[]" style="width: 70%" value="<?php echo $r2['dDeadline']?>" />
												<input  disabled type="text" id="datepicker_<?php echo $r2['ihprfile2']?>" class="datepicker_<?php echo $r2['ihprfile2']?>" name="Deadline_<?php echo $hpr['ihprfile1']?>[]" style="width: 70%" value="<?php echo $r2['dDeadline']?>" />
											<?php }else{ ?>
												<input  type="text" id="datepicker_<?php echo $r2['ihprfile2']?>" class="datepicker_<?php echo $r2['ihprfile2']?>" name="Deadline_<?php echo $hpr['ihprfile1']?>[]" style="width: 70%" value="<?php echo $r2['dDeadline']?>" />
											<?php } ?>

											<script type="text/javascript">
												$(".datepicker_<?php echo $r2['ihprfile2']?>").datepicker({dateFormat:"yy-mm-dd"}); 
											</script>
										</td>
										<td colspan="1" style="border: 1px solid #dddddd; width: 10%"> 
											<?php if($hpr['idoneAdd'] == 1){?> 
												<input  type="hidden" name="vpic_td_dis_<?php echo $hpr['ihprfile1']?>[]" id="vpic_td_dis1" value="<?php echo $r2['vTeamPD']?>" /> 
												<?php  echo $r2['vTeamPD']; ?> Manager
											<?php }else{ ?>
											<select name="vpic_td_dis_<?php echo $hpr['ihprfile1']?>[]" id="vpic_td_dis1" class="required">
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
											if($hpr['idoneAdd'] == 1){
												?><td colspan="1" style="border: 1px solid #dddddd; width: 30%"> 
													<?php 
 
													if(in_array($r2['vTeamPD'], $tipe) or in_array('BD', $tipe)  or in_array('AD', $tipe) ){
													?> 	 
														<table class="hover_table" id="lpo_upload3_<?php echo $r2['ihprfile2']?>" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
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
																	$sqlData2 = "SELECT * FROM plc2.`hprfile3` h WHERE h.`ldelete` = 0 AND h.`ihprfile2` = ".$r2['ihprfile2'];
																	$inData2 = $this->db->query($sqlData2)->result_array();
																	if(empty($inData2)){
																?>
																	<tr>
																		<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
																			<?php if(in_array($r2['vTeamPD'], $tipe)){?>
																			<input  type="file" id="fileupload_hpr3" class="fileupload3 multi multifile required" name="fileupload3_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" /> *
																			<input  type="hidden" name="namafile3_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" value="" />
																			<input  type="hidden" name="fileid3_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" value="" />
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
																				<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,'lpo_upload3_<?php echo $r2['ihprfile2']?>',3,0)">[Hapus]</a>
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
																						if (file_exists('./files/plc/hprnew/'.$iupb_id.'/detail/'.$r2['ihprfile2'].'/'.$value)) {
																							$link = base_url().'processor/plc/v3/prareg/hpr?action=download2&id='.$iupb_id.'&id2='.$r2['ihprfile2'].'&file='.$value;
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
																								<input  type="file" id="fileupload_hpr3" class="fileupload3 multi multifile required" name="fileupload3_<?php echo $r2['ihprfile2'].'_'.$idt['ihprfile3'] ?>[]" style="width: 70%" /> *
																							<?php
																							}else{
																								echo 'File Belum di Revisi';
																							}
																						}
																					?>
																					<input  type="hidden" name="namafile3_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" value="<?php echo $idt['vfilename']?>" />
																					<input  type="hidden" name="fileid3_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" value="<?php echo $idt['ihprfile3']?>" />
																				</td>	
																				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																					<?php 
																					$sqEm = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$idt['cupload']."'";
																					$dtName = $this->db->query($sqEm)->row_array();
																					echo $idt['cupload'].' - '.$dtName['vName'].' - '.$idt['dupload']?>
																				</td>
																				<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
																					<span class="hasil_rev_<?php echo $idt['ihprfile3'] ?>">
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
																								<select class="revis_<?php echo $idt['ihprfile3'] ?>" name="revis_file[]">
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
																					<span class="tambahdoneHilangAll_<?php echo $r2['ihprfile2']?>">
																					<?php 
																						if($idt['iDone']==1){
																							if(in_array('BD', $tipe)){
																								if($idt['irevisi']==2){
																									echo '-';
																								}else{
																									if($iLvlemp>4){
																								?>
																									<span class="hilang3_<?php echo $idt['ihprfile3'] ?>">
																										<a href="javascript:;" onclick="javascript:donefile1(<?php echo $idt['ihprfile3']?>)">[Done]</a>  
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
																								<span class="hilang2_<?php echo $idt['ihprfile3'] ?>">
																									<?php if($idt['irevisi']!=1){
																										if($iLvlemp>4){?>
																											<a href="javascript:;" onclick="javascript:donefile(<?php echo $idt['ihprfile3']?>,<?php echo $idt['ihprfile2']?>)">[Done]</a>  
																								 		<?php } ?>
																									<a href="javascript:;" onclick="javascript:deleteRowtable(this,1,'lpo_upload3_<?php echo $r2['ihprfile2']?>',3,<?php echo $idt['ihprfile3']?>)">[Hapus]</a>
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
																				<span class="tambahdoneHilangAll_<?php echo $r2['ihprfile2']?>">
																					<a href="javascript:;" onclick="javascript:add_row_lpo_upload3('lpo_upload3_<?php echo $r2['ihprfile2']?>',<?php echo $r2['ihprfile2']?>)">[Tambah]</a> 
																					<?php 
																						$sq = "SELECT * FROM plc2.`hprfile3` h WHERE h.`ldelete` = 0 AND h.`ihprfile2` = ".$r2['ihprfile2'];
																						$ck = $this->db->query($sq)->num_rows();
																						if($ck>0){
																							if($iLvlemp>4){	
																					?>
																					<span class="doneHilangAll_<?php echo $r2['ihprfile2']?>">
																						<a href="javascript:;" onclick="javascript:donefile3(<?php echo $r2['ihprfile2']?>)">[Done]</a> 
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
														if($r2['iDoneAll']=="1" && in_array('AD', $tipe)){ 
															?>
																<input  type="text" id="datepickerAD_<?php echo $r2['ihprfile2']?>" class="datepickerAD_<?php echo $r2['ihprfile2']?>" name="DeadlineAD_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" value="<?php echo $r2['dcAndev']?>" />
															<?php
														}else{
															echo '-';	
														}
													}else{
														if($r2['iDoneAll']=="1" && in_array('AD', $tipe)){ 
															?>
																<input  type="text" id="datepickerAD_<?php echo $r2['ihprfile2']?>" class="datepickerAD_<?php echo $r2['ihprfile2']?>" name="DeadlineAD_<?php echo $r2['ihprfile2']?>[]" style="width: 70%" value="<?php echo $r2['dcAndev']?>" />
															<?php
														}else{
															if(in_array($r2['vTeamPD'], $tipe) OR in_array("BD", $tipe)){
																echo $r2['dcAndev'];
															}else{
																echo '-';
															}
														} 
													}?> 
													<script type="text/javascript">
														$(".datepickerAD_<?php echo $r2['ihprfile2']?>").datepicker({dateFormat:"yy-mm-dd"}); 
													</script>
													
												</td>
												<?php
											}
										?>


										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<span class="hilang1_<?php echo $hpr['ihprfile1']?>">
												<?php
													if($hpr['idoneAdd']!=1){
														?>
															<a href="javascript:;" onclick="javascript:deleteRowtable(this,1,'lpo_upload2_<?php echo $hpr['ihprfile1'] ?>',2,<?php echo $r2['ihprfile2']?>)">[Hapus]</a>
														<?php
													}else{
														$idone = $hpr['idoneAdd'];
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
											<span class="lpo_upload2_<?php echo $hpr['ihprfile1'] ?>_num2">1</span></td>
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
											<input  type="text" name="namaDokumen_<?php echo $hpr['ihprfile1']?>[]" style="width: 70%" value="" />
										</td>	
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<input  type="text" id="datepicker_<?php echo $hpr['ihprfile1']?>_<?php echo $hpr['ihprfile1']?>" class="datepicker_<?php echo $hpr['ihprfile1']?>_<?php echo $hpr['ihprfile1']?>" name="Deadline_<?php echo $hpr['ihprfile1']?>[]" style="width: 70%" value="" />
											<script type="text/javascript">
												$("#datepicker_<?php echo $hpr['ihprfile1']?>_<?php echo $hpr['ihprfile1']?>").datepicker({dateFormat:"yy-mm-dd"}); 
											</script>
										</td>
										<td colspan="1" style="border: 1px solid #dddddd; width: 15%"> 
											<select name="vpic_td_dis_<?php echo $hpr['ihprfile1']?>[]" id="vpic_td_dis1" class="required">
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
											<span class="hilang1_<?php echo $hpr['ihprfile1']?>">  
												<a href="javascript:;" onclick="javascript:deleteRowtable(this,0,'lpo_upload2_<?php echo $hpr['ihprfile1'] ?>',2,0)">[Hapus]</a>
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
									<div class="hilang1_<?php echo $hpr['ihprfile1']?>">
										<?php if($hpr['idoneAdd'] != 1){
											$sq = "SELECT * FROM plc2.`hprfile2` h WHERE h.`ldelete` = 0 AND h.`ihprfile1` = ".$hpr['ihprfile1'];
											$ck = $this->db->query($sq)->num_rows();
										?>
										<a href="javascript:;" onclick="javascript:add_row_lpo_upload2('lpo_upload2_<?php echo $hpr['ihprfile1'] ?>',<?php echo $hpr['ihprfile1']?>)">[Tambah]</a>
										<?php 
											if($ck>0){
												?>
													<span class="hilangkedua_<?php echo $hpr['ihprfile1']?>">
														<a href="javascript:;" onclick="javascript:hilang1(<?php echo $hpr['ihprfile1']?>)">[Done]</a>	 
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
						$sql = "SELECT h2.`ihprfile2`FROM plc2.`hprfile1` h 
							JOIN plc2.`hprfile2` h2 ON h.`ihprfile1` = h2.`ihprfile1`
							JOIN plc2.`hprfile3` h3 ON h3.`ihprfile2` = h2.`ihprfile2`
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0
							#AND (h2.dcAndev<>'0000-00-00' AND h2.dcAndev IS NOT NULL) 
							AND h3.`irevisi` = 2 AND h3.`iDone` = 1 AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$iupb_id."'";
						$c1 = $this->db->query($sql)->num_rows();
						$sql2 = "SELECT h2.`ihprfile2`FROM plc2.`hprfile1` h 
							JOIN plc2.`hprfile2` h2 ON h.`ihprfile1` = h2.`ihprfile1`
							JOIN plc2.`hprfile3` h3 ON h3.`ihprfile2` = h2.`ihprfile2`
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h3.`ldelete` = 0  
							AND h.`iupb_id` = '".$iupb_id."'";
						$c2 = $this->db->query($sql2)->num_rows();
					//Cek Don File untuk Manager Khusus Dia

						$sql3 = "SELECT h2.`ihprfile2`FROM plc2.`hprfile1` h 
						JOIN plc2.`hprfile2` h2 ON h.`ihprfile1` = h2.`ihprfile1` 
						WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0  
						AND h2.`iDoneAll` =  1 AND  h.`iupb_id` = '".$iupb_id."'";
						$c11 = $this->db->query($sql3)->num_rows();
						$sql4 = "SELECT h2.`ihprfile2`FROM plc2.`hprfile1` h 
							JOIN plc2.`hprfile2` h2 ON h.`ihprfile1` = h2.`ihprfile1` 
							WHERE h.idoneAdd=1 AND h2.`ldelete`=0 AND h.`ldelete` = 0 AND h.`iupb_id` = '".$iupb_id."'";
						$c22 = $this->db->query($sql4)->num_rows();
						

						$sqL5 = "SELECT  h.`ihprfile1` FROM plc2.`hprfile1` h   
							WHERE h.idoneAdd=1 AND h.`ldelete` = 0 AND  h.`iupb_id` = '".$iupb_id."'";
						$c111 = $this->db->query($sqL5)->num_rows();
						$sqL6 = "SELECT  h.`ihprfile1` FROM plc2.`hprfile1` h   
							WHERE h.`ldelete` = 0 AND  h.`iupb_id` = '".$iupb_id."'";
						$c222 = $this->db->query($sqL6)->num_rows();
						//echo $c111."-".$c222;
						if($c1==$c2 && $c11==$c22 && $c111==$c222 && $iappbusdev_prareg==0 && $c222>0){  
						?>
							<div>
								<a href="javascript:;" onclick="javascript:add_row_lpo_upload('lpo_upload')">[Tambah]</a>
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
	var url2 =  "<?php echo base_url().'processor/plc/v3/prareg/hpr'; ?>";

	$(".datepicker").datepicker({dateFormat:"yy-mm-dd"});
	$("#fileupload_hpr").change(function () {
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
	            url: "<?php echo base_url().'processor/plc/v3/prareg/hpr?action=hapustable' ?>",
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

 					$.get(url2+"?action=update&id="+last_id+"&foreign_key=0&company_id=<?php echo $get['company_id']; ?>&group_id=<?php echo $get['group_id']; ?>&modul_id=<?php echo $get['modul_id']; ?>", function(data) {
                            $("div#form_v3_prareg_hpr").html(data); 
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

	function hilang1(id){ 
		$.ajax({
            url: "<?php echo base_url().'processor/plc/v3/prareg/hpr?action=hilang1' ?>",
            type: 'POST',
            
            data: {
                id_file: id, 
                iupb_id: <?php echo $iupb_id?>,
            },
            async: false, 
            success: function(data) { 
            	 $('.hilang1_'+id).html('-');
            	 $('.reload1'+id).html(data);
            	 	_custom_alert('Done, Anda tidak bisa menambahkan dokumen Kembali');
            	 	$.get(url2+"?action=update&id="+last_id+"&foreign_key=0&company_id=<?php echo $get['company_id']; ?>&group_id=<?php echo $get['group_id']; ?>&modul_id=<?php echo $get['modul_id']; ?>", function(data) {
                            $("div#form_v3_prareg_hpr").html(data); 
                    });
            }
        });
	}
	
	function donefile(id,id2){
		$.ajax({
            url: "<?php echo base_url().'processor/plc/v3/prareg/hpr?action=donefile' ?>",
            type: 'POST',
            data: {
                id_file: id,  
                id_file2: id2,   
            },
            async: false, 
            success: function(data) { 
            	 $('.hilang2_'+id).html('-'); 
            	 _custom_alert('Done, file akan diCek oleh BD');
            	 $.get(url2+"?action=update&id="+last_id+"&foreign_key=0&company_id=<?php echo $get['company_id']; ?>&group_id=<?php echo $get['group_id']; ?>&modul_id=<?php echo $get['modul_id']; ?>", function(data) {
                            $("div#form_v3_prareg_hpr").html(data); 
                 });
            }
        }); 
	}
	function donefile3(id){
		$.ajax({
            url: "<?php echo base_url().'processor/plc/v3/prareg/hpr?action=donefileall' ?>",
            type: 'POST',
            data: {
                id_file: id,   
            },
            async: false, 
            success: function(data) { 
            	 $('.tambahdoneHilangAll_'+id).html('-'); 
            	 _custom_alert('Done, Semua file akan diCek oleh BD');
            	 $.get(url2+"?action=update&id="+last_id+"&foreign_key=0&company_id=<?php echo $get['company_id']; ?>&group_id=<?php echo $get['group_id']; ?>&modul_id=<?php echo $get['modul_id']; ?>", function(data) {
                            $("div#form_v3_prareg_hpr").html(data); 
                 });
            }
        }); 
	}
	function donefile1(id){
		var hasilrev = $('.revis_'+id).val(); 
		if(hasilrev!=''){
			$.ajax({
	            url: "<?php echo base_url().'processor/plc/v3/prareg/hpr?action=donefilerevisi' ?>",
	            type: 'POST',
	            data: {
	                id_file: id,  
	                revisi:hasilrev, 
	            },
	            async: false, 
	            success: function(data) { 
	            	 $('.hilang3_'+id).html('-');  
	            	 if(hasilrev==1){
	            	 	$('.hasil_rev_'+id).html('Revisi');  
	            	 }else{
	            	 	 $('.hasil_rev_'+id).html('Tidak');
	            	 } 
	            	 
	            	 _custom_alert('Done');
					 $.get(url2+"?action=update&id="+last_id+"&foreign_key=0&company_id=<?php echo $get['company_id']; ?>&group_id=<?php echo $get['group_id']; ?>&modul_id=<?php echo $get['modul_id']; ?>", function(data) {
                            $("div#form_v3_prareg_hpr").html(data); 
                 	});
	            }
	        });
		}else{
			_custom_alert('Pilih Hasil Revisi !!');
		}
		 
	}
</script>
</div>
<script>
    ini =$("label[for='v3_prareg_hpr_form_detail_form_tambahan_data']");
    row_input = ini.parent().find('.rows_input');
    row_input.css({
        "margin-left": "10px"
    });
    <?php
    if($iupb_id=="0"){
        ?>
        ini.parent().hide();
    <?php } ?>
    ini.remove();
</script>

<?php 
	/* mansur 2019-04-27 
			cek tambahan data sudah done semua baru munculkan isian tanggal HPR 
	*/
	$this->load->library('auth');

		$type='';
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
			}elseif(in_array('PD', $manager)){
				$type='PD';
			}elseif(in_array('QA', $manager)){
				$type='QA';
			}elseif(in_array('PAC', $manager)){
				$type='PAC';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
				}elseif(in_array('PD', $team)){
					$type='PD';
				}elseif(in_array('QA', $team)){
					$type='QA';
				}elseif(in_array('PAC', $team)){
					$type='PAC';
				}
				else{$type='';}
			}
		}
			// cek apakah UPB butuh tambahan data
			$sqlcekbutuh = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$iupb_id.'"';
			$upebeh = $this->db_plc0->query($sqlcekbutuh)->row_array();
			$itambahan_hpr =isset($upebeh['itambahan_hpr'])?$upebeh['itambahan_hpr']:"-";

			if($itambahan_hpr==1){
				/* jika butuh tambahan data , maka pastikan semua tambahan data dan Done  */
				$sqlcekdokTambahDone = '
					select count(*) as jumlah 
					from plc2.hprfile3 a 
					join plc2.hprfile2 b on b.ihprfile2=a.ihprfile2
					join plc2.hprfile1 c on c.ihprfile1=b.ihprfile1
					where 
					a.ldelete=0
					and b.ldelete=0
					and c.ldelete=0
					and c.iupb_id = "'.$iupb_id.'"
				';
				
				$dJumfile = $this->db_plc0->query($sqlcekdokTambahDone)->row_array();

				$sqlcekdokTambahDone .= ' and a.iDone=0';
				$dudahdone = $this->db_plc0->query($sqlcekdokTambahDone)->row_array();

					//echo $dJumfile['jumlah'].' -- '.$dudahdone['jumlah'];

					if($dJumfile['jumlah'] < 1 or $type <> 'BD'){
						//echo	"okeh ajah";
				?>	
						<script>
							//alert("okeh");
							$("#v3_prareg_hpr_ttarget_hpr").removeClass('required');
							$("#v3_prareg_hpr_ttarget_hpr").parent().hide();
							
 							$("#v3_prareg_hpr_iprareg_ulang_prareg").removeClass('required');
							$("#v3_prareg_hpr_iprareg_ulang_prareg").parent().hide();

							$("#button_update_submit_v3_prareg_hpr").hide();

						</script>

				
				<?php
					}

					if($dudahdone['jumlah'] > 0 or $type <> 'BD'){
						//echo	"okeh ajah";
				?>	
						<script>
							//alert("jumlah done");
							$("#v3_prareg_hpr_ttarget_hpr").removeClass('required');
							$("#v3_prareg_hpr_ttarget_hpr").parent().hide();
							
 							$("#v3_prareg_hpr_iprareg_ulang_prareg").removeClass('required');
							$("#v3_prareg_hpr_iprareg_ulang_prareg").parent().hide();

							$("#button_update_submit_v3_prareg_hpr").hide();

						</script>

				
				<?php
					}

					

			}

?>
