<?php
$noupd="-";
$NamaProduk="-";
$NamaUsulan="-";
$StandarDok="-";
$rselesai="0";
$calldok="0";
$cfinishdok="0";
$cunfinishdok="0";
$persenf="0%";
if($qdatall->num_rows()>=1){
	$noupd=$dataupd['vUpd_no'];
	$NamaProduk=$dataupd['C_ITNAM'];
	$NamaUsulan=$dataupd['vNama_usulan'];
	$StandarDok=$dataupd['jenis'];
	$calldok=$qdatall->num_rows();
	$cfinishdok=$qdataapp->num_rows();
	if($cfinishdok>=1){
		$s=$cfinishdok/$calldok*100;
		$persenf=number_format($s,2)."%";
	}
	$cunfinishdok=$calldok-$cfinishdok;
}
?>
<style type="text/css" media="screen">
.head_table{
	background: rgba(0, 0, 0, 0) -moz-linear-gradient(center top , #1e5f8f, #3496df) repeat-x scroll 0 0;
    border: 1px solid #89b9e0;
    color: #ffffff;
    float: center;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 1px;
    padding: 2px 8px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
    text-transform: uppercase;
}
.print_rpt{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#ffffff;
	margin:20px;
	border:#000 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
.print_rpt tr {
	text-align: left;
	padding-left:10px;
}
.print_rpt td:first-child {
	text-align: left;
	padding-left:10px;
	border-left: 0;
}
.print_rpt td {
	padding:5px;
	border-top: 1px solid #000000;
	border-bottom:1px solid #000000;
	border-left: 1px solid #000000;
	text-align: center;
}	
</style>
<div class="boxContent" style="overflow:auto;">
	<div class="box_dropdown">
		<div class="content">
			<div class="box_content_form">
                <div class="form_horizontal_plc">
                     <div class="rows_group">
                        <label class="rows_label" for="lbl_vupd_nomor">No UPD</label>
                        <div class="rows_input select_rows">
                           <p name="lbl_vupd_nomor"><?php echo $noupd ?></p>
                        </div>
                    </div> 
                    <div class="rows_group">
                        <label class="rows_label" for="lbl_NamaProduk">Nama Produk</label>
                        <div class="rows_input select_rows">
                           <p name="lbl_NamaProduk"><?php echo $NamaProduk ?></p>
                        </div>
                    </div> 
                    <div class="rows_group">
                        <label class="rows_label" for="lbl_NamaUsulan">Nama Usulan</label>
                        <div class="rows_input select_rows">
                           <p name="lbl_NamaProduk"><?php echo $NamaUsulan ?></p>
                        </div>
                    </div>
                    <div class="rows_group">
                        <label class="rows_label" for="lbl_NamaUsulan">Standar Dokumen</label>
                        <div class="rows_input select_rows">
                           <p name="lbl_NamaProduk"><?php echo $StandarDok ?></p>
                        </div>
                    </div>
                    <div class="rows_group">
                        <label class="rows_label" for="lbl_NamaUsulan">Report % Penyelesaian</label>
                        <div class="rows_input select_rows">
                           <p name="lbl_NamaProduk"><?php echo $persenf ?></p>
                        </div>
                    </div>
                </div>
                <div id="preview_print">
                </div>
				
				

				<div class="clear"></div>
				<table class='print_rpt'>
				<thead>
					<tr>
						<td colspan="3" class="head_table">Report Progress Qty Dokumen</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class='rows_label'>All Qty Dokumen</td>
						<td><?php echo $calldok ?></td>
						<td>Item</td>
					</tr>
					<tr>
						<td class='rows_label'>Qty Dokumen Lengkap CK 3 (Approved)</td>
						<td><?php echo $cfinishdok ?></td>
						<td>Item</td>
					</tr>
					<tr>
						<td class='rows_label'>Qty Dokumen BELUM Lengkap CK 3 (Approved)</td>
						<td><?php echo $cunfinishdok ?></td>
						<td>Item</td>
					</tr>
				</tbody>
				</table>
				<div class="control-group-btn">
					<div class="left1-control-group-btn">
					</div>
					<div class="left-control-group-btn">
                        <button onclick="javascript:print_<?php echo $grid; ?>(2)" class="ui-button-text icon-save" id="btn_print_excel">Print Excel</button>
                        <button onclick="javascript:print_<?php echo $grid; ?>(1)" class="ui-button-text icon-save" id="btn_print_pdf">Print PDF</button>									
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>
<iframe height="0" width="0" id="iframe_preview_<?php echo $grid; ?>"></iframe>
<script type="text/javascript">
	function print_<?php echo $grid; ?>(iprint=1){
        if(iprint==2){
            var url=base_url+"processor/plc/report_export_progress_dokumen?action=print_xls";
        }else{
            var url=base_url+"processor/plc/report_export_progress_dokumen?action=print_pdf";
        }
        var id=$("#search_grid_report_export_progress_dokumen_idossier_upd_id").val();

        url=url+"&id="+id;
        document.getElementById("iframe_preview_<?php echo $grid; ?>").src = url;
       
    }
</script>