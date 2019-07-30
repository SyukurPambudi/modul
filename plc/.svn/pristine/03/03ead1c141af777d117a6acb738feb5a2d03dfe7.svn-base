<?php 
	$this->load->library('lib_plc');
	$upbTeam = $this->lib_plc->getNamaTeamUPB($rowDataH['iupb_id']);

	$satuansq='select * from plc2.plc2_master_satuan a where a.plc2_master_satuan_id = ?';
	$dSatuan = $this->db->query($satuansq,array($rowDataH['plc2_master_satuan_id']))->row_array();

	$sqCb = 'select a.cNip as valval , concat(a.cNip," - ",a.vName) as showshow
			from hrd.employee a 
			where a.cNip in (

						select b1.vnip 
						from plc2.plc2_upb_team a1
						join plc2.plc2_upb_team_item b1 on b1.iteam_id=a1.iteam_id
						where a1.ldeleted=0
						and b1.ldeleted=0
						and a1.iteam_id in ('.$hasTeamID.')
			)';

	$pilihan = $this->db->query($sqCb)->result_array();

	//echo $hasTeamID;

	$sdataKirim = 'select *
						,b.dTanggalKirimBD,b.cPengirimBD,b.txtNoteBD
						,b.dTanggalTerimaPD,b.cPenerimaPD,b.txtNotePD
						,b.dTanggalTerimaAD,b.cPenerimaAD,b.txtNoteAD
						,b.dTanggalTerimaQA,b.cPenerimaQA,b.txtNoteQA
						from plc2.plc2_upb_request_originator a 
						left join plc2.plc2_upb_date_sample b on b.iReq_ori_id=a.ireq_ori_id
						where a.ldeleted=0
						and a.ldeleted=0
						and a.ireq_ori_id= ?
						';
	$dataKirim = $this->db->query($sdataKirim,array($rowDataH['ireq_ori_id']))->row_array();
 ?>

 <?php 
    $arrTeam = explode(',',$hasTeam);
    if( in_array('BD', $arrTeam) || $isAdmin  ){
                        	

 ?>
	<div style="background-color: #F7F7F9;
			border: 1px solid #E1E1E8;
			padding: 7px;
			width: 500px;">
		<h3>Busdev</h3>
		<table style="width: 100%;" border="0">
			<tbody>
				
				<tr>
					<td width="20%">Pengirim</td>
					<td>:</td>
					<td width="80%">
						<?php 
							$return = '<select class="input_rows1 choose required" name="cPengirimBD"  id="cPengirimBD" >';            
				            foreach($pilihan as $me) {
				            	if ($me['valval'] == $dataKirim['cPengirimBD']) $selected = ' selected';
			                    else $selected = '';
			                    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
				            }            
				            $return .= '</select>';

				            echo $return;

						 ?>
					</td>
				</tr>
				
				<tr>
					<td width="20%">Tanggal Kirim</td>
					<td>:</td>
					<td width="80%">
						
						<?php 
							$return = '<input type="text"  name="dTanggalKirimBD"  value="'.$dataKirim['dTanggalKirimBD'].'" id="dTanggalKirimBD" class="input_rows1 tanggal required" size="10" >';
							echo $return;
						 ?>
					</td>
				</tr>

				<tr>
					<td width="20%">Keterangan</td>
					<td>:</td>
					<td width="80%">
						<?php 
							$return = '<textarea  name="txtNoteBD" class="input_rows1 " colspan="2" id="txtNoteBD" >'.nl2br($dataKirim['txtNoteBD']).'</textarea>';
							echo $return; 
						?>
						
					</td>
				</tr>

			</tbody>
		</table>
	</div>
	<br>
<?php 
	}
 ?>

 <?php 
 	$arrTeam = explode(',',$hasTeam);
    if( in_array('PD', $arrTeam) || $isAdmin  ){
 ?>

		<div style="background-color: #F7F7F9;
				border: 1px solid #E1E1E8;
				padding: 7px;
				width: 500px;">
			<h3>PD</h3>
			<table style="width: 100%;" border="0">
				<tbody>
					
					<tr>
						<td width="20%">Penerima</td>
						<td>:</td>
						<td width="80%">
							<?php 
								$return = '<select class="input_rows1 choose required" name="cPenerimaPD"  id="cPenerimaPD" >';            
					            foreach($pilihan as $me) {
					                if ($me['valval'] == $dataKirim['cPenerimaPD']) $selected = ' selected';
				                    else $selected = '';
				                    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
					            }            
					            $return .= '</select>';

					            echo $return;

							 ?>
						</td>
					</tr>
					
					<tr>
						<td width="20%">Tanggal Terima</td>
						<td>:</td>
						<td width="80%">
							
							<?php 
								$return = '<input type="text"  name="dTanggalTerimaPD" id="dTanggalTerimaPD" value="'.$dataKirim['dTanggalTerimaPD'].'" class="input_rows1 tanggal required" size="10" >';
								echo $return;
							 ?>
						</td>
					</tr>

					<tr>
						<td width="20%">Keterangan</td>
						<td>:</td>
						<td width="80%">
							<?php 
								$return = '<textarea  name="txtNotePD" class="input_rows1 " colspan="2" id="txtNotePD" >'.nl2br($dataKirim['txtNotePD']).'</textarea>';
								echo $return; 
							?>
							
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<br>
<?php 
	}
 ?>

 <?php 
 	$arrTeam = explode(',',$hasTeam);
    if( in_array('PD', $arrTeam) || in_array('AD', $arrTeam) || $isAdmin  ){
 ?>

		<div style="background-color: #F7F7F9;
				border: 1px solid #E1E1E8;
				padding: 7px;
				width: 500px;">
			<h3>AD</h3>
			<table style="width: 100%;" border="0">
				<tbody>
					
					<tr>
						<td width="20%">Penerima</td>
						<td>:</td>
						<td width="80%">
							<?php 
								$return = '<select class="input_rows1 choose required" name="cPenerimaAD"  id="cPenerimaAD" >';            
					            foreach($pilihan as $me) {
					                if ($me['valval'] == $dataKirim['cPenerimaAD']) $selected = ' selected';
				                    else $selected = '';
				                    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
					            }            
					            $return .= '</select>';

					            echo $return;

							 ?>
						</td>
					</tr>
					
					<tr>
						<td width="20%">Tanggal Terima</td>
						<td>:</td>
						<td width="80%">
							
							<?php 
								$return = '<input type="text"  name="dTanggalTerimaAD" id="dTanggalTerimaAD" value="'.$dataKirim['dTanggalTerimaAD'].'" class="input_rows1 tanggal required" size="10" >';
								echo $return;
							 ?>
						</td>
					</tr>

					<tr>
						<td width="20%">Keterangan</td>
						<td>:</td>
						<td width="80%">
							<?php 
								$return = '<textarea  name="txtNoteAD" class="input_rows1 " colspan="2" id="txtNoteAD" >'.nl2br($dataKirim['txtNoteAD']).'</textarea>';
								echo $return; 
							?>
							
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<br>
<?php 
	}
 ?>
 
 <?php 
 	$arrTeam = explode(',',$hasTeam);
    if( in_array('QA', $arrTeam) ){
 ?>

	<div style="background-color: #F7F7F9;
			border: 1px solid #E1E1E8;
			padding: 7px;
			width: 500px;">
		<h3>QA</h3>
		<table style="width: 100%;" border="0">
			<tbody>
				
				<tr>
					<td width="20%">Penerima</td>
					<td>:</td>
					<td width="80%">
						<?php 
							$return = '<select class="input_rows1 choose required" name="cPenerimaQA"  id="cPenerimaQA" >';            
				            foreach($pilihan as $me) {
				                if ($me['valval'] == $dataKirim['cPenerimaQA']) $selected = ' selected';
			                    else $selected = '';
			                    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
				            }            
				            $return .= '</select>';

				            echo $return;

						 ?>
					</td>
				</tr>
				
				<tr>
					<td width="20%">Tanggal Terima</td>
					<td>:</td>
					<td width="80%">
						
						<?php 
							$return = '<input type="text"  name="dTanggalTerimaQA" id="dTanggalTerimaQA" value="'.$dataKirim['dTanggalTerimaQA'].'" class="input_rows1 tanggal required" size="10" >';
							echo $return;
						 ?>
					</td>
				</tr>

				<tr>
					<td width="20%">Keterangan</td>
					<td>:</td>
					<td width="80%">
						<?php 
							$return = '<textarea  name="txtNoteQA" class="input_rows1 " colspan="2" id="txtNoteQA" >'.nl2br($dataKirim['txtNoteQA']).'</textarea>';
							echo $return; 
						?>
						
					</td>
				</tr>

			</tbody>
		</table>
	</div>

<?php 
	}
 ?>