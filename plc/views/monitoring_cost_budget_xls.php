<?php 
		$judul = 'LAPORAN MONITORING KPI';
		$thead = '	<tr>
						<th >NO</th>
						<th >Category</th>
						<th >Parameter</th>
						<th >Nilai</th>
						<th >UOM</th>
					</tr>';

		// mulai draw
		$html = '<div class="gen_report2" style="margin-top:3%;">
					<span><b>'.$judul.'</b></span>
					<br>
					<span>Periode : '.$tglAwal.' s/d '.$tglAkhir.'</span>
					<table style="font-family:Tahoma;font-size:10" width="100%" border="1" style="border:1px solid #000000;border-collapse:collapse;">';

		$html .= $thead;
		//isi body table start
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

							$html .= '<tr>';
							$html .= '<td style="width:5%;">'.$i.'</td>';
							$html .= '<td style="width:20%;">'.$data['vkategori_parameter'].'</td>';
							$html .= '<td style="width:70%;">'.$data['vparameter'].'</td>';
							$html .= '<td style="width:5%;">'.$uom.'</td>';
							$html .= '<td style="width:5%;">'.$data['vNmSatuan'].'</td>';
							
							$html .= '</tr>';
						$i++;
						}		
		//isi body table end
		$excel=$html;
		$skrg = date('Y-m-d H:i:s');
		$filename ="Monitoring_KPI.xls";		
		 header('Content-type: application/ms-excel');
		 header('Content-Disposition: attachment; filename='.$filename);
		echo $excel;
		exit;

?>