<?php 
	$this->load->library('lib_plc');
	$upbTeam = $this->lib_plc->getNamaTeamUPB($rowDataH['iupb_id']);

	$satuansq='select * from plc2.plc2_master_satuan a where a.plc2_master_satuan_id = ?';
	$dSatuan = $this->db->query($satuansq,array($rowDataH['plc2_master_satuan_id']))->row_array();
 ?>
<div class="" style="max-width:98%;">
	<div class="full_colums" style="background-color:white;max-width:98%;padding: 10px 10px 10px 10px;">
		<table style="width:100%;font-weight: bold;border-collapse: collapse;">
			<tbody>
				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">No Request</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $rowDataH['vreq_ori_no'] ?></td>
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Nama Originator</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $rowDataH['vnama_originator'] ?></td>
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Qty</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $rowDataH['ijum_ori'].' '.$dSatuan['vNmSatuan'] ?></td>
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Tgl Request</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $rowDataH['trequest_ori'] ?></td>
					
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Keterangan </td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $rowDataH['vKeterangan'] ?></td>
				</tr>


				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">No UPB</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;">
						<?php echo $upbTeam['vupb_nomor'] ?>
						<input type="hidden" name="iupb_id" value="<?php echo $rowDataH['iupb_id'] ?> ">	
					</td>
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Nama Usulan</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $upbTeam['vupb_nama'] ?></td>
				</tr>


				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Team PD</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $upbTeam['nmPD'] ?></td>
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Team AD</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $upbTeam['nmAD'] ?></td>
				</tr>

				<tr style="border-bottom: 1px solid #89b9e0;">
					<td style="width:100px;padding-top:10px;">Team QA</td>
					<td style="width:3px;align:center;padding-top:10px;">:</td>
					<td style="padding-left:5px;padding-top:10px;"><?php echo $upbTeam['nmQA'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>