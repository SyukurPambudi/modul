<?php $path="import_tambahan_data_detail"; ?>
<script>
/* DOM */
window
  .document
  .body

/* CLICK */

.addEventListener( "click", function( event ) {
  var oTarget = event.target;

 /* FOR input[type="checkbox"] */

if( oTarget.tagName == "INPUT" && oTarget.type == "checkbox" ) {
  var chkbox = document.getElementsByTagName("INPUT"),
  i = 0;
  for( ;i < chkbox.length; i++ ) {
     if( oTarget.name == chkbox[i].name ) {
       if( chkbox[i] == oTarget ) continue;
       chkbox[i].checked = false;
     }
   }
 }



 /* --- */

}, false );

function add_row_<?php echo $path ?>(idtable,iddok){

	var row ='';
	row +='<tr>';
	row +='<td>';
	row +='<input type="file" class="fileupload multi multifile required" name="filedetail_'+iddok+'[]" style="width: 90%" />'; 
	row +='<input type="hidden" name="filetd_'+iddok+'[]" style="width: 90%" value="'+iddok+'" />';
	row +='<input type="hidden" name="filetdid_'+iddok+'[]" style="width: 90%" value="" />';
	row +='</td>';
	row +='<td>';
	row +='<span class="delete_btn"><a href="javascript:;" class="<?php echo $path; ?>_del_'+iddok+'" onclick="del_row(this, \'<?php echo $path; ?>_del_'+iddok+'\')">[Hapus]</a></span>';
	row +='</td>';
	row +='</tr>';
	jQuery("#"+idtable).append(row);s
}

	$("#tgl2").datepicker({	changeMonth:true,
		changeYear:true,
		dateFormat:"yy-mm-dd" 
	});


</script>

	<table class="hover_table" id="" cellspacing="0" cellpadding="1" style="border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 150%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Tambahan Data Detail</span></th>
		</tr>
		<tr style="width: 150%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
			<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
			<th  style="border: 1px solid #dddddd; width: 15%;">Memo</th>
			<th style="border: 1px solid #dddddd; width: 10%;">Keterangan</th>	
			<th style="border: 1px solid #dddddd; width: 5%;">Tgl Request</th>
			<th style="border: 1px solid #dddddd; width: 20%;" >Lengkapi Dokumen</th>
			<th style="border: 1px solid #dddddd; width: 3%;">Tgl Melengkapi</th>
			<th style="border: 1px solid #dddddd; width: 30%;">File</th>	
		</tr>
		</thead>
		<tbody>
			<?php 

			$i = 1;
			foreach ($rows as $row) {
						$id  = $row['iupi_dok_td_id'];
							$value = $row['vMemo'];	
							if($value != '') {
								if (file_exists('./files/plc/import/td_file/'.$id.'/'.$value)) {
									$link = base_url().'processor/plc/import/tambahan/data?action=downloadMemo&id='.$id.'&filememo='.$value;
									$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'. $row['vMemo'].'</a>';
								}
								else {
									$linknya = 'File sudah tidak ada!';
								}
							}
							else {

								$linknya = 'No File';
							}	
						?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;">
						<td><?php echo $i; ?></td>
						<td><?php echo $linknya ?></td>
						<td><?php echo $row['vKeterangan']?></td>
						<td><?php  echo $row['dTglrequest']?></td>
					<?php 
						$sqllihat = "SELECT * FROM plc2.`upi_dok_td_detail` WHERE `iMemo_id`=".$row['iMemo_id'];
						$sqltampil = $this->db_plc0->query($sqllihat);
						if($sqltampil->num_rows>0){
							foreach ($sqltampil->result_array() as $r) {
								?>
									<td>
										<?php echo $r['vNama_dokumen'] ?>
									</td>
									<td>
										<?php echo $r['dTgl_td'] ?>
									</td>

								<?php
							}

						}else{
						?>
							<td>
								-
							</td>
							<td>
								-
							</td>
						<?php
							}
						?>
						<td>
							<table id="table_upload_<?php echo $path.$row['iMemo_id'] ?>" width="98%" class="hover_table" " style="border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
							
							<?php 
								$sql ="SELECT * FROM plc2.`upi_dok_td_detail_file` a WHERE a.`iMemo_id` =".$row['iMemo_id'];
								$sqli = $this->db_plc0->query($sql);
								if($sqli->num_rows>0){
									foreach ($sqli->result_array() as $dt) {
										$id1  = $dt['iMemo_id'];
											$value1 = $dt['vFileupidetail'];	
											if($value1 != '') {
												if (file_exists('./files/plc/import/td_detail_file/'.$id1.'/'.$value1)) {
													$link1 = base_url().'processor/plc/import/tambahan/data?action=downloaddDokumen&id='.$id1.'&filedokumen='.$value1;
													$linknya1 = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link1.'\'">'. $dt['vFileupidetail'].'</a>';
												}
												else {
													$linknya1 = 'File sudah tidak ada!';
												}
											}
											else {
												$linknya1 = 'No File';
											}	
										?>
											<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;">
												<td>
													<?php echo $linknya1?>
													<input value="<?php echo $dt['vFileupidetail'] ?>" type="hidden" name="filetd_<?php echo $row['iMemo_id']?>[]" style="width: 90%" value="" />
											        <input value="<?php echo $dt['iDoktdfile_id'] ?>" type="hidden" name="filetdid_<?php echo $row['iMemo_id']?>[]" style="width: 90%" value="" />
												</td>
												
									   		</tr>

										<?php
									}
								}else{
							?>
							
								<tr>
									<td>
										No file
									</td>
						   		</tr>

								
						   	<?php
						   	}
						   	?>
						   	</table>

						</td>
					</tr>
				<?php 
					$i++;
					}
				?>
			
		</tbody>

	</table>			
</div>