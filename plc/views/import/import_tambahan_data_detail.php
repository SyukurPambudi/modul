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
			<th style="border: 1px solid #dddddd; width: 30%;">Upload File</th>	
		</tr>
		</thead>
		<tbody>
		<?php 
			$i = 1;
			foreach ($rows as $row) {
				?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff;">
					<td><?php echo $i; ?></td>
					<td><?php echo $row['vMemo']?></td>
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
						<input type="text" name="LengkapiDokumen[]"  class="input_rows1 required" size="16" />
						<input type="hidden" name="idMemo[]" value="<?php echo $row['iMemo_id'] ?>"/>
					</td>
					<td>
						<input type="text" name="tglMelengkapi[]"  id="tgl2_<?php echo $i?>" readonly="readonly" class="input_rows1 required" size="8" />
					</td>
					<?php

						}

					?>



					<td>
						<table id="table_upload_<?php echo $path.$row['iMemo_id'] ?>">
							
							<?php 
								$sql ="SELECT * FROM plc2.`upi_dok_td_detail_file` a WHERE a.`iMemo_id` =".$row['iMemo_id'];
								$sqli = $this->db_plc0->query($sql);
								if($sqli->num_rows>0){
									foreach ($sqli->result_array() as $dt) {
										?>
											<tr>
												<td>
													<?php echo $dt['vFileupidetail'] ?>
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
										<input type="file" class="fileupload multi multifile required" name="filedetail_<?php echo $row['iMemo_id']?>[]" style="width: 90%" /> 
										<input type="hidden" name="filetd_<?php echo $row['iMemo_id']?>[]" style="width: 90%" value="" />
								        <input type="hidden" name="filetdid_<?php echo $row['iMemo_id']?>[]" style="width: 90%" value="" />
									</td>
									<td>
						   				<span class="delete_btn"><a href="javascript:;" class="<?php echo $path; ?>_del_<?php echo $row['iMemo_id'] ?>" onclick="">[Hapus]</a></span>
						   			</td>
						   		</tr>

								
						   	<?php
						   	}
						   	?>
						   	</table>
						   	<?php 
						   		if($sqli->num_rows>0){?>
							   		
								<?php
								}else{?>
									<span class="tambah_btn_<?php echo $path.$row['iMemo_id'] ?>">
											<a href="javascript:;" onclick="javascript:add_row_<?php echo $path ?>('table_upload_<?php echo $path.$row['iMemo_id'] ?>',<?php echo $row['iMemo_id'] ?>)">Tambah</a>
									</span>
								<?php
								}?>

					</td>
				
				</tr>
				<script type="text/javascript">
					$("#tgl2_"+<?php echo $i ?>).datepicker({	
						changeMonth:true,
						changeYear:true,
						dateFormat:"yy-mm-dd" 
					});
				</script>

				<?php
				$i++;
			}

		?>
					
		</tbody>
		<tfoot>
		</tfoot>	
	</table>			
</div>