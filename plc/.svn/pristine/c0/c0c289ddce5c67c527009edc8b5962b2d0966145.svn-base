<table style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="14" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Input Pengiriman/Permintaan Sample Originator</span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th rowspan="2" style="border: 1px solid #dddddd;">No</th>
		<th rowspan="2" style="border: 1px solid #dddddd;">No Request</th>
		<th colspan="3" style="border: 1px solid #dddddd;">Businnes Development</th>
		<th colspan="3" style="border: 1px solid #dddddd;">Product Development</th>
		<th colspan="3" style="border: 1px solid #dddddd;">Analisys Development</th>
		<th colspan="3" style="border: 1px solid #dddddd;">Quality Assurance</th>
			</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		
		<th style="border: 1px solid #dddddd;">Tanggal Kirim</th>
		<th style="border: 1px solid #dddddd;">Pengirim</th>
		<th style="border: 1px solid #dddddd;">Catatan</th>
		
		<th style="border: 1px solid #dddddd;">Tanggal Terima</th>
		<th style="border: 1px solid #dddddd;">Penerima</th>
		<th style="border: 1px solid #dddddd;">Catatan</th>
		
		<th style="border: 1px solid #dddddd;">Tanggal Terima</th>
		<th style="border: 1px solid #dddddd;">Penerima</th>
		<th style="border: 1px solid #dddddd;">Catatan</th>
		
		<th style="border: 1px solid #dddddd;">Tanggal Terima</th>
		<th style="border: 1px solid #dddddd;">Penerima</th>
		<th style="border: 1px solid #dddddd;">Catatan</th>
	</tr>
	</thead>
	<tbody>
		<?php 
			$this->load->library('lib_plc');

			$sqHist = "select a.vreq_ori_no
						,b.dTanggalKirimBD,b.cPengirimBD,b.txtNoteBD
						,b.dTanggalTerimaPD,b.cPenerimaPD,b.txtNotePD
						,b.dTanggalTerimaAD,b.cPenerimaAD,b.txtNoteAD
						,b.dTanggalTerimaQA,b.cPenerimaQA,b.txtNoteQA
						from plc2.plc2_upb_request_originator a 
						left join plc2.plc2_upb_date_sample b on b.iReq_ori_id=a.ireq_ori_id
						where a.ldeleted=0
						and a.ldeleted=0
						and a.iupb_id= ?
						order by a.ireq_ori_id
						";
				//print_r($rowDataH);
			$histories = $this->db->query($sqHist,array($rowDataH['iupb_id']))->result_array();

			$i= 1;
			foreach ($histories as $item ) {
					$namaBD = $this->lib_plc->whoAmI($item['cPengirimBD']);
					$namaPD = $this->lib_plc->whoAmI($item['cPenerimaPD']);
					$namaAD = $this->lib_plc->whoAmI($item['cPenerimaAD']);
					$namaQA = $this->lib_plc->whoAmI($item['cPenerimaQA']);
			
		?>

			<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
				<td style="border: 1px solid #dddddd; width: 3%; text-align: right;">
					<?php echo $i ?>	
				</td>
				
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['vreq_ori_no'] ?>	
				</td>


				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['dTanggalKirimBD'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $namaBD['vName'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['txtNoteBD'] ?>	
				</td>

				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['dTanggalTerimaPD'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $namaPD['vName'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['txtNotePD'] ?>	
				</td>

				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['dTanggalTerimaAD'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $namaAD['vName'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['txtNoteAD'] ?>	
				</td>

				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['dTanggalTerimaQA'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $namaQA['vName'] ?>	
				</td>
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<?php echo $item['txtNoteQA'] ?>	
				</td>
			</tr>
			
		<?php
			$i++;
			}
		?>
		</tbody>
	</table>