 <style>
		body {
		    background-color: #FFFFFF;
		    color: #333333;
		    font-family: "Calibri";
		    font-size: 10px;
		    margin: 0;
		    -moz-transform:rotate(90deg);
		}
		.box_pdf {
			padding: 0px; margin: 0 auto; width: 100%;
		}
		.head_teks {
			padding: 0px 0px 0px 0px; font-size: 12px; font-weight: bold; border-bottom: 4px double #000000;  margin-bottom: 2px;
		}
		.nama_kat {
			color: #f82c04;
		}
		table {
		    background-color: transparent;
		    border-collapse: collapse;
		    border-spacing: 0;
		}
				.table {
		    margin-bottom: 18px;
		    width: 100%;
		}
					.table-bordered {
		    border: 1px solid #000000;
		}
		.table-bordered th {
		    background-color: #89b9e0;
		    text-transform: uppercase; font-weight: bold; font-size: 10px; color: #FFFFFF;
		}
		.table-bordered th, .table-bordered tr {
		    border-left: 2px solid #000000; 
		}
		.table-bordered th, .table-bordered td {
		    border-left: 1px solid #000000; 
		}
		.table th, .table td {
		    border-top: 1px solid #000000;
		    line-height: 15px;
		    padding: 8px;
		    vertical-align: middle;
		}
		table .p_product {
    background-color: #0E870B;
}
		</style>
 <div class="clear"></div>
    <div id="grid_wraper_monitoring_cost">
        <div id="grid_search_monitoring_cost">
            <div class="full_colums">
               <div class="clear"></div>
                <span style="margin-left:38%; font-size:16px;">LAPORAN KPI DAN COST BUDGET</span><br />
                <span style="margin-left:40%;font-size:14px;">Periode : <?php echo $tglAwal ?> s/d <?php echo $tglAkhir ?></span>
                <br />
                <br />

                <div style="margin-top:20px">
                        <table style="padding-left:28%;" >
                            <tr>
                                <td>Category</td>
                                <td>: <?php echo $header['kategori'] ?></td>
                            </tr>
                            <tr>
                                <td>Parameter</td>
                                <td>: <?php echo $header['kategori_parameter'] ?></td>
                            </tr>
                            <tr>
                                <td>Nilai</td>
                                <td>: <?php echo $uom?></td>
                            </tr>
                            <tr>
                                <td>UOM</td>
                                <td>: <?php echo $header['vNmSatuan']?></td>
                            </tr>
                            <tr>
                                <td>Syarat & Ketentuan</td>
                                <td>: <?php echo nl2br($header['description']) ?></td>
                            </tr>
                        </table>
                </div>
                <pre></pre>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>UPB</th>
							<th>Nama Usulan</th>
							<th>Posisi UPB</th>
							<th>Status UPB</th>
							<th>Tgl Approve<br> Direksi</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						foreach($datanya as $data) {
						?>
							<tr class="ui-widget-content jqgrow ui-row-ltr" role="row" id="param_id">
                                   <td class="ui-state-default jqgrid-rownum" style="text-align:right; width:5%;" role="gridcell"><?php echo $i ?></td>
                                   <td style="text-align:left; width:10%;" ><?php echo $data['vupb_nomor'] ?></td>
                                   <td style="text-align:left; width:40%;" ><?php echo $data['nama_usulan'] ?></td>
                                   <td style="text-align:left; width:20%;" ><?php echo $data['posisi_upb'] ?></td>
                                   <td style="text-align:left; width:20%;" ><?php echo $data['status_upb'] ?></td>
                                   <td style="text-align:left; width:20%;" ><?php echo $data['approve_direksi'] ?></td>
                                   
                               </tr>	
						<?php 
							$i++;
							}		
						?>
					</tbody>
				</table>
				<span style='margin-left:95%;'><?php echo $per.' of '.$total ?> </span>
            </div>
        </div>
    </div>
