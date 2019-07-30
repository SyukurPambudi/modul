<?php 
		$judul = 'LAPORAN KPI DAN COST BUDGET';
		$thead = '	<tr>
						<th>No</th>
						<th>UPB</th>
						<th>Nama Usulan</th>
						<th>Posisi UPB</th>
						<th>Status UPB</th>
						<th>Tgl Approve<br> Direksi</th>
					</tr>';

		// mulai draw
		$html = '<div class="gen_report2" style="margin-top:3%;">
					<span><b>'.$judul.'</b></span>
					<br>
					<span>Periode : '.$tglAwal.' s/d '.$tglAkhir.'</span>
					<br>
					<span>Category : '.$header['kategori'].'</span>
					<br>
					<span>Parameter : '.$header['kategori_parameter'].'</span>
					<br>
					<span>Nilai : '.$uom.'</span>
					<br>
					<span>UOM : '.$header['vNmSatuan'].'</span>  
					<br>
					<span>Syarat & Ketentuan : '.$header['description'].'</span>

					<table style="font-family:Tahoma;font-size:10" width="100%" border="1" style="border:1px solid #000000;border-collapse:collapse;">';

		$html .= $thead;
		//isi body table start
						$i = 1;
						foreach($datanya as $data) {
							$html .= '<tr>';
							$html .= '<td style="width:5%;">'.$i.'</td>';
							$html .= '<td style="width:10%;">'.$data['vupb_nomor'].'</td>';
							$html .= '<td style="width:30%;">'.$data['nama_usulan'].'</td>';
							$html .= '<td style="width:10%;">'.$data['posisi_upb'].'</td>';
							$html .= '<td style="width:10%;">'.$data['status_upb'].'</td>';
							$html .= '<td style="width:10%;">'.$data['approve_direksi'].'</td>';
							$html .= '</tr>';
						$i++;
					}	
		$html .='</table>';						
		$html .=''.$per.' of '.$total.'';
						
		//isi body table end
		$excel=$html;
		$skrg = date('Y-m-d H:i:s');
		$filename ="Monitoring_cost_budget_Detail.xls";		
		 header('Content-type: application/ms-excel');
		 header('Content-Disposition: attachment; filename='.$filename);
		echo $excel;
		exit;

?>