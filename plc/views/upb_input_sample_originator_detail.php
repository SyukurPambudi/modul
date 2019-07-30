<script type="text/javascript">
	$(document).ready(function(){
		 $( "button.btn_input_sample_person" ).button({
			icons: {
				primary: "ui-icon-person"
			},
			text: false
		})
		$( "button.btn_input_sample_detail" ).button({
			icons: {
				primary: "ui-icon-newwin"
			},
			text: false
		})
	})	
</script>
<?php
	$depts = $this->auth_localnon->my_depts(TRUE) ? $this->auth_localnon->my_depts(TRUE) : array();
	$teams = $this->auth_localnon->my_teams(TRUE) ? $this->auth_localnon->my_teams(TRUE) : array();
?>
<input type="hidden" name="iupb_id" id="iupb_id" value="<?php echo $iupb_id ?>" />
<input type="hidden" name="company_id" id="company_id" value="<?php echo $this->input->get('company_id') ?>" />
<input type="hidden" name="modul_id" id="modul_id" value="<?php echo $this->input->get('modul_id') ?>" />
<input type="hidden" name="group_id" id="group_id" value="<?php echo $this->input->get('group_id') ?>" />
<table id="table_input_sample_detail" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="10" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Input Pengiriman/Permintaan Sample Originator</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th rowspan="2" style="border: 1px solid #dddddd;">No</th>
		<th colspan="3" style="border: 1px solid #dddddd;">Businnes Development</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Product Development</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Analisys Development</th>
		<th colspan="2" style="border: 1px solid #dddddd;">Quality Assurance</th>
		<?php if ($this->input->get('action') != 'view') {?>
		<!--<th rowspan="2" style="border: 1px solid #dddddd;">Action</th>-->
		<?php }?>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No Request</th>
		<th style="border: 1px solid #dddddd;">Tanggal Kirim</th>
		<!--<th style="border: 1px solid #dddddd;">Pengirim</th>-->
		<th style="border: 1px solid #dddddd;">Detail</th>
		
		<th style="border: 1px solid #dddddd;">Tanggal Terima</th>
		<!--<th style="border: 1px solid #dddddd;">Penerima</th>-->
		<th style="border: 1px solid #dddddd;">Detail</th>
		
		<th style="border: 1px solid #dddddd;">Tanggal Terima</th>
		<!--<th style="border: 1px solid #dddddd;">Penerima</th>-->
		<th style="border: 1px solid #dddddd;">Detail</th>
		
		<th style="border: 1px solid #dddddd;">Tanggal Terima</th>
		<!--<th style="border: 1px solid #dddddd;">Penerima</th>-->
		<th style="border: 1px solid #dddddd;">Detail</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$jbd=0;
		$jpd=0;
		$jad=0;
		$jqa=0;
		//print_r($depts);
		//print_r($rows);
		foreach($rows as $r) {
			$i++;	
	?>	
	<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
		<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
			<span class="table_input_sample_detail_num"><?php echo $i; ?></span>
			<input type="hidden" name="iKirimID[<?php echo $r['iKirimID'] ?>]" value="<?php echo $r['iKirimID'] ?>" />
		</td>
		<td> <?php echo $r['vreq_ori_no']   ?></td>
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalKirimBD'])) {
					echo date('d-m-Y', strtotime($r['dTanggalKirimBD']));
				}
				else {
					if(in_array('BD', $depts)) {
						echo '<input type="text" required class="input_tgl datepicker input_rows1" name="dTanggalKirimBD['.$r['iKirimID'].']"/>';
					}
					else {
						echo '&nbsp;';
					}					
				}
			?>			
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPengirimBD[]" class="cPengirimBD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalKirimBD'])) {					
			?>
					<div style="text-align: left;">
						<span style="vertical-align: top;">Pengirim: </span><span style="margin-left: 7px;"><?php echo $r['cPengirimBD'] ?></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><?php echo $r['txtNoteBD'] ?></span>
					</div>
				<?php
				}
				else {
					
			?>
					<div class="divsamplebd input_sample_toggle" style="text-align: left; display: none;">
						<span style="vertical-align: top;">Pengirim: </span><span style="margin-left: 7px;"><input type="hidden" name="cPengirimBD[<?php echo $r['iKirimID'] ?>]" id="cPengirimBD" style="width: 50px;" /><input readonly="readonly" required style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_bd" name="upb_input_sampel_nama_nip_bd" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=bd','List Karyawan')">[...]</button></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea name="txtNoteBD[<?php echo $r['iKirimID'] ?>]" style="width: 100px; height: 50px;"></textarea></span>
					</div>
					<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsamplepd', this)">&nbsp;</button>
		
			<?php
					$jbd++;
				}
			?>				
			</td>
		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalTerimaPD']) && $r['dTanggalTerimaPD'] != '0000-00-00') {
					echo date('d-m-Y', strtotime($r['dTanggalTerimaPD']));
				}
				else {
					if(in_array('PD', $depts)) {
						echo '<input type="text" required class="input_tgl datepicker input_rows1" name="dTanggalTerimaPD['.$r['iKirimID'].']"/>';
					}
					else {
						echo '&nbsp;';
					}					
				}
			?>					
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPenerimaPD[]" class="cPenerimaPD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalTerimaPD']) && $r['dTanggalTerimaPD'] != '0000-00-00') {					
			?>
					<div style="text-align: left;">
						<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><?php echo $r['cPenerimaPD'] ?></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><?php echo $r['txtNotePD'] ?></span>
					</div>
			<?php
				}
				else {
			?>
					<div class="divsamplepd input_sample_toggle" style="text-align: left; display: none;">
						<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" class="cPenerimaPD" name="cPenerimaPD[<?php echo $r['iKirimID'] ?>]" id="cPenerimaPD" style="width: 50px;" /><input required readonly="readonly" style="width: 110px;" type="text" class="upb_input_sampel_nama_nip_pd" id="upb_input_sampel_nama_nip_pd" name="upb_input_sampel_nama_nip_pd" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=pd&ix=<?php echo $jpd; ?>','List Karyawan')">[...]</button></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea class="txtNotePD" name="txtNotePD[<?php echo $r['iKirimID'] ?>]" style="width: 100px; height: 50px;"></textarea></span>
					</div>
					<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsamplepd', this)">&nbsp;</button>
		
			<?php
					$jpd++;
					}
					
			?>
			</td>
		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalTerimaAD']) && $r['dTanggalTerimaAD'] != '0000-00-00') {
					echo date('d-m-Y', strtotime($r['dTanggalTerimaAD']));
				}
				else {
					if(in_array('AD', $depts)) {
						if(isset($r['dTanggalTerimaPD']) && $r['dTanggalTerimaPD'] != '0000-00-00') {
							echo '<input type="text" required class="input_tgl datepicker input_rows1" name="dTanggalTerimaAD['.$r['iKirimID'].']"/>';
						}
					}
					else {
						echo '&nbsp;';
					}
				}
			?>					
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPenerimaAD[]" class="cPenerimaAD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalTerimaAD']) && $r['dTanggalTerimaAD'] != '0000-00-00') {					
			?>
					<div style="text-align: left; ">
						<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><?php echo $r['cPenerimaAD'] ?></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><?php echo $r['txtNoteAD'] ?></span>
					</div>
			<?php
				}
				else {
		?>					
					<div class="divsamplead input_sample_toggle" style="text-align: left; display: none;">
						<!--<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" class="cPenerimaAD" name="cPenerimaAD[<?php echo $r['iKirimID'] ?>]" id="cPenerimaAD" style="width: 50px;" /><input readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_ad" class="upb_input_sampel_nama_nip_ad" name="upb_input_sampel_nama_nip_ad" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=ad&ix=<?php echo $jad; ?>','List Karyawan')">[...]</button></span><br />-->
						<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" class="cPenerimaAD" name="cPenerimaAD[<?php echo $r['iKirimID'] ?>]" id="cPenerimaAD" style="width: 50px;" /><input required readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_ad" class="upb_input_sampel_nama_nip_ad" name="upb_input_sampel_nama_nip_ad" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=andev&ix=<?php echo $jad; ?>','List Karyawan')">[...]</button></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea class="txtNoteAD" name="txtNoteAD[<?php echo $r['iKirimID'] ?>]" style="width: 100px; height: 50px;"></textarea></span>
					</div>
					<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsamplead', this)">&nbsp;</button>
	
			<?php
					$jad++;
					}
		
			?>
			</td>
		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalTerimaQA']) && $r['dTanggalTerimaQA'] != '0000-00-00') {
					echo date('d-m-Y', strtotime($r['dTanggalTerimaQA']));
				}
				else {
					if(in_array('QA', $depts)) {
						echo '<input type="text" required class="input_tgl datepicker input_rows1" name="dTanggalTerimaQA['.$r['iKirimID'].']"/>';
					}
					else {
						echo '&nbsp;';
					}
				}
			?>			
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPenerimaQA[]" class="cPenerimaQA input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->
		<td style="border: 1px solid #dddddd;">
			<?php
				if(isset($r['dTanggalTerimaQA']) && $r['dTanggalTerimaQA'] != '0000-00-00') {					
			?>
					<div style="text-align: left;">
						<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><?php echo $r['cPenerimaQA'] ?></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><?php echo $r['txtNoteQA'] ?></span>
					</div>
			<?php
				}
				else {
			?>
					<div class="divsampleqa input_sample_toggle" style="text-align: left; display: none;">
						<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" class="cPenerimaQA" name="cPenerimaQA[<?php echo $r['iKirimID'] ?>]" id="cPenerimaQA" style="width: 50px;" /><input required readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_qa" class="upb_input_sampel_nama_nip_qa" name="upb_input_sampel_nama_nip_qa" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=qa&ix=<?php echo $jqa; ?>','List Karyawan')">[...]</button></span><br />
						<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea class="txtNoteQA" name="txtNoteQA[<?php echo $r['iKirimID'] ?>]" style="width: 100px; height: 50px;"></textarea></span>
					</div>
					<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsampleqa', this)">&nbsp;</button>
		
			<?php
					$jqa++;
					}
			?>
					
			</td>
		
		<!--<td style="border: 1px solid #dddddd; width: 3%;">
			<span class="delete_btn"><a href="javascript:;" class="table_input_sample_detail_del" onclick="del_row(this, 'table_input_sample_detail_del')">[Delete]</a></span>
		</td>-->
	</tr>
	<?php
		}
		$i++;
		//print_r($depts);
	//selesai tampil yg ada, tinggal tampilin yg kosong utk add new
	?>
	<?php if (empty($reqs)) {
	?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
		<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
			<span class="table_input_sample_detail_num"><?php echo $i ?></span>
			<input type="hidden" name="iKirimIDa"/>
		</td>
		<td> 
			<?php echo $_GET['req_id']  ?>
		</td>
		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('BD', $depts)) {
					echo '<input type="text" class="input_tgl datepicker input_rows1" required name="dTanggalKirimBDa"/>';
				}
				else {
					echo '&nbsp;';
				}
			?>			
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPengirimBD[]" class="cPengirimBD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('BD', $depts)) {
			?>
				<div class="divsamplebd input_sample_toggle" style="text-align: left; display: none;">
					<span style="vertical-align: top;">Pengirim: </span><span style="margin-left: 7px;"><input type="hidden" name="cPengirimBDa" id="cPengirimBD" class="cPengirimBD" style="width: 50px;" /><input readonly="readonly" required style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_bd" name="upb_input_sampel_nama_nip_bd" class="upb_input_sampel_nama_nip_bd" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=bd','List Karyawan')">[...]</button></span><br />
					<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea name="txtNoteBDa" style="width: 100px; height: 50px;"></textarea></span>
				</div>
				<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsamplebd', this)">&nbsp;</button>						
			<?php
				}
			?>
			</td>
		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('PD', $depts)) {
					echo '<input type="text" class="input_tgl datepicker input_rows1" name="dTanggalTerimaPDa"/>';
				}
				else {
					echo '&nbsp;';
				}
			?>		
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPenerimaPD[]" class="cPenerimaPD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('PD', $depts)) {
			?>
			<div class="divsamplepd input_sample_toggle" style="text-align: left; display: none;">
				<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" name="cPenerimaPDa" id="cPenerimaPDa" class="cPenerimaPD" style="width: 50px;" /><input readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_pda" name="upb_input_sampel_nama_nip_pda" class="upb_input_sampel_nama_nip_pd" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=pd','List Karyawan')">[...]</button></span><br />
				<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea name="txtNotePDa" style="width: 100px; height: 50px;"></textarea></span>
			</div>
			<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsamplepd', this)">&nbsp;</button>
			<?php } ?>
		</td>
		
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('AD', $depts)) {
					echo '<input type="text" class="input_tgl datepicker input_rows1" name="dTanggalTerimaADa"/>';
				}
				else {
					echo '&nbsp;';
				}
			?>			
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPenerimaAD[]" class="cPenerimaAD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->
		<td style="border: 1px solid #dddddd;">
			<?php 
				if(in_array('AD', $depts)) {
			?>
			<div class="divsamplead input_sample_toggle" style="text-align: left; display: none;">
				<!--<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" class="cPenerimaAD" name="cPenerimaAD" id="cPenerimaAD" style="width: 50px;" /><input readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_ad" class="upb_input_sampel_nama_nip_ad" name="upb_input_sampel_nama_nip_ad" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=ad&ix=','List Karyawan')">[...]</button></span><br />-->
				<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" class="cPenerimaAD" name="cPenerimaADa" id="cPenerimaADa" style="width: 50px;" /><input required readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_ada" class="upb_input_sampel_nama_nip_ad" name="upb_input_sampel_nama_nip_ada" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=andev','List Karyawan')">[...]</button></span><br />
				<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea class="txtNoteAD" name="txtNoteADa" style="width: 100px; height: 50px;"></textarea></span>
			</div>
			<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsamplead', this)">&nbsp;</button>
			<?php } ?>
		</td>
		<!-- QA-->
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('QA', $depts)) {
					echo '<input type="text" class="input_tgl datepicker input_rows1" name="dTanggalTerimaQAa"/>';
				}
				else {
					echo '&nbsp;';
				}
			?>		
		</td>	
		<!--<td style="border: 1px solid #dddddd; text-align: left;">
			<input type="text" name="cPenerimaPD[]" class="cPenerimaPD input_small" />
			<button type="button" class="btn_input_sample_person">&nbsp;</button>
		</td>-->
		<td style="border: 1px solid #dddddd;">
			<?php
				if(in_array('QA', $depts)) {
			?>
			<div class="divsampleqa input_sample_toggle" style="text-align: left; display: none;">
				<span style="vertical-align: top;">Penerima: </span><span style="margin-left: 3px;"><input type="hidden" name="cPenerimaQAa" id="cPenerimaQAa" class="cPenerimaQA" style="width: 50px;" /><input readonly="readonly" style="width: 110px;" type="text" id="upb_input_sampel_nama_nip_qaa" name="upb_input_sampel_nama_nip_qaa" class="upb_input_sampel_nama_nip_qa" /><button type="button" onclick="browse('<?php echo base_url()  ?>processor/plc/plc/master/employee/popup?type=qa','List Karyawan')">[...]</button></span><br />
				<span style="vertical-align: top;">Note: </span><span style="margin-left: 25px;"><textarea name="txtNoteQAa" style="width: 100px; height: 50px;"></textarea></span>
			</div>
			<button type="button" class="btn_input_sample_detail" onclick="javascript:open_detail_sample('divsampleqa', this)">&nbsp;</button>
			<?php } ?>
		</td>
		
		
		
		<!--<td style="border: 1px solid #dddddd; width: 3%;">
			<span class="delete_btn"><a href="javascript:;" class="table_input_sample_detail_del" onclick="del_row(this, 'table_input_sample_detail_del')">[Delete]</a></span>
		</td>-->
	</tr>

	<?php	
		} 
	?>
	</tbody>
	<?php if ($this->input->get('action') != 'view') {?>
	<!--<tfoot>
		<tr>
			<td style="text-align:right;" colspan="8"></td>
			<td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('table_input_sample_detail')">Tambah</a></td>
		</tr>
	</tfoot>-->
	<?php }?>
</table>