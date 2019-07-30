<?php 
	$label 		= str_replace($field, 'form_detail_'.$field, $id);
	$controller = str_replace("_".$field, "", $id);
	$url 		= base_url().'processor/reformulasi/'.str_replace('/', '_', $controller).'?action=download';

	$rows 		= array();
	if (strtolower($act) != 'create'){
		$sqlRows 	= $form_field['vSource_input'];
		$sqlFile 	= $form_field['vSource_input_edit'];
		$dataRows 	= $this->db->query($sqlRows, array($rowDataH['iexport_skala_lab']))->result_array();

		foreach ($dataRows as $row) {
			$dataFiles 		= $this->db->query($sqlFile, array($row['iexport_skala_lab_formula']))->result_array();
			$files 			= array();
			foreach ($dataFiles as $fl) {
				$id_head 	= $fl['idHeader_File'];
				$value 		= $fl['vFilename_generate'];
				$path 		= $fl['filepath'];
				$filename 	= $fl['filename'];

				$link 		= $url.'&id='.$id_head.'&path='.$filename.'&file='.$value;
				$download 	= "No File";
				if (file_exists('./'.$path.'/'.$id_head.'/'.$value)){
					$download = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
				} else {
					$download = 'File Not Found';
				}
				$fl['download'] = $download;
				array_push($files, $fl);
			}
			$row['files'] 	= $files;
			array_push($rows, $row);
		}
	}

	// print_r(json_encode($rows));exit();

?>

<style type="text/css">
	#<?php echo $id; ?>{
		min-width 		: 99%; 
		overflow-x 		: scroll; 
		overflow-y 		: hidden; 
		white-space 	: nowrap;
	}

	#table_trial_uji_fisik{ 
		border 			: 2px #A1CCEE solid;
		padding 		: 5px;
		background 		: #fff;
		border-radius 	: 5px;
		min-width 		: 99%;
	}

	#table_trial_uji_fisik thead tr th{    
		border 			: 1px solid #89b9e0;
	    text-align 		: center;
	    color 			: #FFFFFF;
	    background 		: -webkit-gradient(linear, left top, left bottom, from(#1e5f8f), to(#3496df)) repeat-x;
	    background 		: -moz-linear-gradient(top, #1e5f8f, #3496df) repeat-x;
	    text-transform 	: uppercase; 
	    padding 		: 5px;
	}

	#table_trial_uji_fisik tbody tr td{
		border 			: 1px #dddddd solid;
		padding 		: 3px;
		text-align 		: center;
	}

	#table_trial_uji_fisik tbody tr{
		border 			: 1px solid #ddd;
		border-collapse : collapse;
		background 		: #fff
	}

	#table_trial_uji_fisik tfoot tr td{
		border 			: 1px #dddddd solid;
		padding 		: 3px;
		text-align 		: center;
	}

	#table_trial_uji_fisik tfoot tr{
		border 			: 1px solid #ddd;
		border-collapse : collapse;
		background 		: #fff
	}
</style>

<div id="<?php echo $id; ?>">
	<br>
	<table id="table_trial_uji_fisik" cellspacing="0" cellpadding="1">
		<thead>
			<tr>
				<th colspan="10"><?php echo $form_field['vDesciption']; ?></th>
			</tr>
			<tr>
				<th rowspan="2">No.</th>
				<th rowspan="2">Nomor Formulasi</th>
				<th rowspan="2">Tanggal Mulai Orientasi<br>Skala Lab</th>
				<th rowspan="2">Tanggal Selesai Orientasi<br>Skala Lab</th>
				<th rowspan="2">PIC Skala Lab</th>
				<th colspan="4">Upload File</th>
				<th rowspan="2">Tanggal Submit</th>
			</tr>
			<tr>
				<th>No.</th>
				<th>File</th>
				<th>Keterangan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($rows as $num => $row) {
					$dataFiles 	= $row['files'];
					$countFiles = count($dataFiles);
					$span 		= ( $countFiles > 0 ) ? $countFiles : 1;
					$rowHead 	= '';
					$rowHead	.= '<td rowspan="'.$span.'">'.($num + 1).'</td>';
					$rowHead	.= '<td rowspan="'.$span.'">'.$row['vno_formula'].'</td>';
					$rowHead	.= '<td rowspan="'.$span.'">'.$row['dmulai_skala_lab'].'</td>';
					$rowHead	.= '<td rowspan="'.$span.'">'.$row['dselesai_skala_lab'].'</td>';
					$rowHead	.= '<td rowspan="'.$span.'">'.$row['nip_pic'].' - '.$row['name_pic'].'</td>';

					$rowSubmit	= '<td rowspan="'.$span.'">'.$row['dsubmit_fisik'].'</td>';

					if ( $countFiles > 0 ){
						foreach ($row['files'] as $numfiles => $file) {
							$printf  = '';
							$printf .= '<tr>';
							$printf .= ( $numfiles == 0 ) ? $rowHead : '';
							$printf .= '	<td>'.($numfiles + 1).'</td>';
							$printf .= '	<td>'.$file['vFilename'].'</td>';
							$printf .= '	<td>'.$file['tKeterangan'].'</td>';
							$printf .= '	<td>'.$file['download'].'</td>';
							$printf .= ( $numfiles == 0 ) ? $rowSubmit : '';
							$printf .= '</tr>';
							echo $printf;
						}
					} else {
						$print  = '';
						$print .= '<tr>';
						$print .= $rowHead;
						$print .= '<td colspan="4">Tidak Ada File</td>';
						$print .= $rowSubmit;
						$print .= '</tr>';
						echo $print;
					}
				}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$("label[for='<?php echo $label; ?>']").hide();
	$("#<?php echo $id; ?>").parent().removeClass('rows_input');
</script>














































