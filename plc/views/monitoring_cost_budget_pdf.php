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

<body>
	<div class="box_pdf">
		<div class="head_teks">
			<span style="margin-left:38%;font-size:16px;">LAPORAN MONITORING KPI</span><br />
			<span style="margin-left:40%;">Periode : <?php echo $tglAwal ?> s/d <?php echo $tglAkhir ?></span> <br />
			
		</div>
		<pre></pre>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Category</th>
					<th>Parameter</th>
					<th>Nilai</th>
					<th>UOM</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 1;
				foreach($datanya as $data) {
					$hari_kerja = $data['hari']-$data['hari_libur'];
					if ($hari_kerja > 0) {
								$banding= $hari_kerja / $data['per'];
							}else{
								$banding ='0';
							}
							
					if ($data['iparameter_id']== 7 || $data['iparameter_id']== 9 || $data['iparameter_id']== 10|| $data['iparameter_id']== 11 || $data['iparameter_id']== 12) {
						$uom = round($banding, 2);	
					}else{
						$uom = $data['per'];
					}

				?>
					<tr class="ui-widget-content jqgrow ui-row-ltr" role="row" tglAwal='' tglAkhir=''  id='<?php echo $data['iparameter_id'] ?>' uom='<?php echo $data['jumlah'] ?>'>
						<td style="text-align:right; width:5%;" ><?php echo $i ?></td>
						<td style="text-align:left; width:20%;" ><?php echo $data['vkategori_parameter'] ?></td>
						<td style="text-align:left; width:70%;" ><?php echo $data['vparameter'] ?></td>
						<td style="text-align:left; width:5%;" ><?php echo $uom ?></td>
						<td style="text-align:left; width:5%;" ><?php echo $data['vNmSatuan'] ?></td>

					</tr>	
				<?php 
					$i++;
					}		
				?>
			</tbody>
		</table>			
	</div>
</body>
