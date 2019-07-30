<?php 
		$judul = 'LAPORAN KPI DAN COST BUDGET';
		$thead = '	<tr>
						<th>No</th>
							<th>UPB</th>
							<th>Nama Usulan</th>
							<th>Tgl Approve<br> Setting Prioritas</th>
							<th>Tgl Submit<br>Dokumen</th>
							<th>Tgl Tambahan<br>Data</th>
							<th>Jumlah <br> Hari</th>
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
							$jml_hari = $data['jumlah_hari']-$data['hari_libur'];
							$html .= '<tr>';
							$html .= '<td style="width:5%;">'.$i.'</td>';
							$html .= '<td style="width:10%;">'.$data['vupb_nomor'].'</td>';
							$html .= '<td style="width:30%;">'.$data['nama_usulan'].'</td>';
							$html .= '<td style="width:10%;">'.$data['date_prioritas'].'</td>';
							$html .= '<td style="width:10%;">'.$data['tanggal_sub_dokumen'].'</td>';
							$html .= '<td style="width:10%;">'.$data['tgl_tamb_data'].'</td>';
							$html .= '<td style="width:10%;">'.$jml_hari.'</td>';
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