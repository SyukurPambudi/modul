<?php
	
	$rows 		= array();
	$read 		= 'readonly';
	$readPD 	= '';
	$readAD 	= '';
	$readQA 	= '';

	if (strtolower($act) != 'create'){
		$idHead = $rowDataH['iexport_terima_sample'];

		$recPD 	= $rowDataH['iterima_pd'];
		$recAD 	= $rowDataH['iterima_ad'];
		$recQA 	= $rowDataH['iterima_qa'];
		$ujiMik = $rowDataH['iuji_mikro'];

		// $readPD = ( $recPD == 0 ) ? '' : $read;
		// $readAD = ( $recAD == 0 && $recPD > 0 ) ? '' : $read;
		// $readQA = ( $recQA == 0 && $recAD > 0 && $recPD > 0 ) ? '' : $read;

		$acts 	= $this->lib_sub_core->get_current_module_activities($modul_id, $idHead); 
		$sort 	= ( count($acts) > 0 ) ? $acts[0]['iSort'] : 0;

		$readPD = ( $sort == 1 ) ? '' : $read;
		$readAD = ( $sort == 2 ) ? '' : $read;
		$readQA = ( $sort == 3 ) ? '' : $read;

		$sql 	= 'SELECT m.ID AS id_material, CONCAT(r.vraw, " - ", r.vnama) AS nama_material,
						IF(CHAR_LENGTH(ird.mSpecification) = 0, m.mSpec, ird.mSpecification) AS spesification,
						d.eStatusPO, d.cUnitSize, d.yQtyKirim AS qty_po, d.yOutsdPO,
						(SELECT GROUP_CONCAT(DISTINCT b.cBatchNo SEPARATOR "<br>") AS batch FROM pd_source.lpb_batch b WHERE b.lDeleted = 0 AND b.cLPB_Number = d.cLPB_Number) AS batch,
						d.yQtyRecieve, d.dTerimaPD, CONCAT(epd.cNip, " - ", epd.vName) AS detail_pd, 
						d.dFormulator, CONCAT(efor.cNip, " - ", efor.vName) AS detail_formulator, 
						d.dTerimaReq, CONCAT(erc.cNip, " - ", erc.vName) AS detail_request,
						sd.iexport_terima_sample_detail, sd.tdetail_pd, IF( sd.dtgl_kirim_pd = "0000-00-00", NULL, sd.dtgl_kirim_pd ) AS dtgl_kirim_pd,
						sd.tdetail_ad, IF( sd.dtgl_terima_ad = "0000-00-00", NULL, sd.dtgl_terima_ad ) AS dtgl_terima_ad,
						sd.tdetail_qa, IF( sd.dtgl_terima_qa = "0000-00-00", NULL, sd.dtgl_terima_qa ) AS dtgl_terima_qa
					FROM reformulasi.export_terima_sample_detail sd
					JOIN pd_source.lpb_detail d ON sd.ilpb_detail_id = d.id
					/*join untuk mendapatkan raw material*/
					JOIN pd_source.item_material m ON d.iItemID = m.ID
					JOIN plc2.plc2_raw_material r ON m.iRawID = r.raw_id
					/*join untuk mendapatkan initial request detail*/
					JOIN pd_source.inreq_detail ird ON d.cRequestNo = ird.cRequestNo AND m.ID = d.iItemID
					/*join untuk emndapatkan nama karyawan*/
					LEFT JOIN hrd.employee epd ON d.cTerimaPD = epd.cNip
					LEFT JOIN hrd.employee efor ON d.cFormulator = efor.cNip
					LEFT JOIN hrd.employee erc ON d.cTerimaReq = erc.cNip
					WHERE sd.iexport_terima_sample = ? AND sd.ldeleted = 0
					GROUP BY d.id ';
		$rows 	= $this->db->query($sql, array($idHead))->result_array();
	}

?>

<style type="text/css">
	.exp_terima_sample_raw_table{ 
		border 			: 2px #A1CCEE solid;
		padding 		: 5px;
		background 		: #fff;
		border-radius 	: 5px;
		width:  		: 200%;
	}

	.exp_terima_sample_raw_table thead tr th{    
		border 			: 1px solid #89b9e0;
	    text-align 		: center;
	    color 			: #FFFFFF;
	    background 		: -webkit-gradient(linear, left top, left bottom, from(#1e5f8f), to(#3496df)) repeat-x;
	    background 		: -moz-linear-gradient(top, #1e5f8f, #3496df) repeat-x;
	    text-transform 	: uppercase; 
	    padding 		: 5px;
	}

	.exp_terima_sample_raw_table tbody tr td{
		border 			: 1px #dddddd solid;
		padding 		: 3px;
		text-align 		: center;
	}

	.exp_terima_sample_raw_table tbody tr{
		border 			: 1px solid #ddd;
		border-collapse : collapse;
		background 		: #fff
	}

	.exp_terima_sample_raw_div{
		min-width 		: 99%; 
		overflow-x 		: scroll; 
		overflow-y 		: hidden; 
		white-space 	: nowrap;
	}
</style>

<?php
	if (strtolower($act) == 'create'){
		echo "Save First...!!!";
	} else {
?>

<script type="text/javascript">
	function setDatePicker(num){
		if ("<?php echo $read; ?>" != "<?php echo $readPD; ?>"){
			$("#tanggal_pd_"+num).datepicker({
			 	changeMonth 	: true,
				changeYear 		: true,
				dateFormat 		: "yy-mm-dd", 
				showOn 			: "button",
				buttonImage 	: base_url+"assets/images/calendar.gif",
				buttonImageOnly : true,
				buttonText 		: "Select date"
			}).attr('readonly','readonly');
			$("#tanggal_pd_"+num).addClass('required');
			$("#detail_pd_"+num).addClass('required');
		}

		if ("<?php echo $read; ?>" != "<?php echo $readAD; ?>"){
			$("#tanggal_ad_"+num).datepicker({
			 	changeMonth 	: true,
				changeYear 		: true,
				dateFormat 		: "yy-mm-dd", 
				showOn 			: "button",
				buttonImage 	: base_url+"assets/images/calendar.gif",
				buttonImageOnly : true,
				buttonText 		: "Select date"
			}).attr('readonly','readonly');
			$("#tanggal_ad_"+num).addClass('required');
			$("#detail_ad_"+num).addClass('required');
		}

		if ("<?php echo $read; ?>" != "<?php echo $readQA; ?>"){
			$("#tanggal_qa_"+num).datepicker({
			 	changeMonth 	: true,
				changeYear 		: true,
				dateFormat 		: "yy-mm-dd", 
				showOn 			: "button",
				buttonImage 	: base_url+"assets/images/calendar.gif",
				buttonImageOnly : true,
				buttonText 		: "Select date"
			}).attr('readonly','readonly');
			$("#tanggal_qa_"+num).addClass('required');
			$("#detail_qa_"+num).addClass('required');
		}

 	}
</script>

<div class="exp_terima_sample_raw_div">
	<table class="exp_terima_sample_raw_table" id="exp_terima_sample_raw_table" cellspacing="0" cellpadding="1">
		<thead>
			<tr>
				<th colspan="22"><?php echo $form_field['vDesciption'] ?></th>
			</tr>
			<tr>
				<th rowspan="3">No.</th>
				<th rowspan="2" colspan="9">Detail Penerimaan Dari Supplier</th>
				<th colspan="6">Detail Pengiriman Dan Penerimaan Sourcing</th>
				<th colspan="6">Kirin Bhan Baku Ke AD Dan QA</th>
			</tr>
			<tr>
				<th colspan="2">PD Sourcing</th>
				<th colspan="2">PD Formulator</th>
				<th colspan="2">Requestor</th>
				<th colspan="2">PD</th>
				<th colspan="2">AD</th>
				<th colspan="2">QA</th>
			</tr>
			<tr>
				<th>ID Material</th>
				<th>Nama Material</th>
				<th>Spesification</th>
				<th>Status PO</th>
				<th>Unit Size</th>
				<th>Qty PO</th>
				<th>Outstanding PO</th>
				<th>No. Batch</th>
				<th>Qty Terima</th>
				<th>Tanggal Kirim</th>
				<th>Detail</th>
				<th>Tanggal Terima</th>
				<th>Detail</th>
				<th>Tanggal Terima</th>
				<th>Detail</th>
				<th>Tanggal Kirim</th>
				<th>Detail</th>
				<th>Tanggal Terima</th>
				<th>Detail</th>
				<th>Tanggal Terima</th>
				<th>Detail</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($rows as $num => $row){
					?>
						<tr>
							<td><?php echo $num+1; ?></td>
							<td><?php echo $row['id_material']; ?></td>
							<td><?php echo $row['nama_material']; ?></td>
							<td><?php echo $row['spesification']; ?></td>
							<td><?php echo $row['eStatusPO']; ?></td>
							<td><?php echo $row['cUnitSize']; ?></td>
							<td><?php echo $row['qty_po']; ?></td>
							<td><?php echo $row['yOutsdPO']; ?></td>
							<td><?php echo $row['batch']; ?></td>
							<td><?php echo $row['yQtyRecieve']; ?></td>
							<td><?php echo $row['dTerimaPD']; ?></td>
							<td><?php echo $row['detail_pd']; ?></td>
							<td><?php echo $row['dFormulator']; ?></td>
							<td><?php echo $row['detail_formulator']; ?></td>
							<td><?php echo $row['dTerimaReq']; ?></td>
							<td><?php echo $row['detail_request']; ?></td>

							<!-- inputan untuk pd -->
							<td>
								<input type="hidden" name="id_details[]" value="<?php echo $row['iexport_terima_sample_detail']; ?>" />
								<input readonly type="text" id="tanggal_pd_<?php echo $num; ?>" name="tanggal_pd[]" value="<?php echo $row['dtgl_kirim_pd']; ?>" style="width: 70%" />
							</td>
							<td>
								<textarea name="detail_pd[]" id="detail_pd_<?php echo $num; ?>" <?php echo $readPD; ?> rows="2" style="width: 100px"><?php echo $row['tdetail_pd']; ?></textarea>
							</td>
							<!-- inputan untuk pd -->

							<!-- inputan untuk ad -->
							<td>
								<input readonly type="text" id="tanggal_ad_<?php echo $num; ?>" name="tanggal_ad[]" value="<?php echo $row['dtgl_terima_ad']; ?>" style="width: 70%" />
							</td>
							<td>
								<textarea name="detail_ad[]" id="detail_ad_<?php echo $num; ?>" <?php echo $readAD; ?> rows="2" style="width: 100px"><?php echo $row['tdetail_ad']; ?></textarea>
							</td>
							<!-- inputan untuk ad -->

							<!-- inputan untuk qa -->
							<td>
								<input readonly type="text" id="tanggal_qa_<?php echo $num; ?>" name="tanggal_qa[]" value="<?php echo $row['dtgl_terima_qa']; ?>" style="width: 70%" />
							</td>
							<td>
								<textarea name="detail_qa[]" id="detail_qa_<?php echo $num; ?>" <?php echo $readQA; ?> rows="2" style="width: 100px"><?php echo $row['tdetail_qa']; ?></textarea>
							</td>
							<!-- inputan untuk ad -->
						</tr>
						<script type="text/javascript">
							setDatePicker(<?php echo $num; ?>);
						</script>
					<?php
				}
			?>
		</tbody>
	</table>
</div>
<?php
	}
?>

