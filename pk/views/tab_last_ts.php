<?php
	$qdkat="select * from pk.pk_kategori kat where kat.ldeleted=0";
	$dkat=$this->dbset->query($qdkat)->result_array();
	$o ='';
	$sql="select em.cNip,em.vName,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk from hrd.employee em
		inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID
		inner join hrd.msdivision di on em.iDivisionID=di.iDivID
		inner join hrd.position po on po.iPostId=em.iPostID
		Where em.cNip='".$nipnya."'";
	$data['rows'] = $this->db->query($sql)->result_array();
	$data['id']="view_browse";
	//$o.=$this->load->view('browse_details_employee',$data);
	$o .= '<style>';
	$o .= '.box{
		background-color:#edf5fb;
		border:4px double #a1ccee;
		margin:10px 0px 10px 0px;
		padding: 10px;
		}';
	$o .= '.rows_group::before, .form-horizontal .rows_group::after {
		    content: "";
		    display: table;
		    line-height: 0;
		}
		.form_horizontal_plc .rows_group::after {
		    clear: both;
		}
		.form_horizontal_plc .rows_group {
		    clear: both;
		    margin-bottom: 5px;
		    padding-top: 0;
		}';
	$o .= '.rows_label {
			background-color: #b8d7f0;
			border-bottom: 1px solid #cccccc;
			float: left;
			margin-bottom: 2px;
			padding: 4px;
			text-align: left;
			width: 175px;
			margin-right : 10px;
		}';
	$o .= '.table_browse_pk{
			font-size: 12px;	
			}
			.table_browse_pk, table_browse_pk th, table_browse_pk tr, .table_browse_pk td, .table_browse_pk thead, .table_browse_pk tbody{
				border:1px solid #c5dbec;
			}
			.table_browse_pk tbody tr th{
				text-align:left;
			}
			.table_browse_pk tbody{
				font-weight: bold;
			}';
	$o .='</style>';
	$o .= '<table width="100%" height="100%" class="table_browse_pk">';
	$o .= '<thead style="background-color:#0000FF;color:#effff0;">';
	$o .= '<tr>';
	$o .= '<th>ASPEK PENILAIAN</th>';
	$o .= '<th>BOBOT</th>';
	$o .= '<th>NILAI AKHIR TIAP ASPEK</th>';
	$o .= '<th>NILAI X BOBOT</th>';
	$o .= '</thead>';
	$o .= '<tbody>';
	$n=array();
	foreach ($dkat as $k) {
		$bobot=$k["bobot"]*100;
		$idkat=$k["ikategori_id"];
		$bo=$k["bobot"];
		$sql="select ni.poin_sepakat_atasan as atas,pa.bobot as bobo from pk.pk_nilai ni
				inner join pk.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
				where ni.idmaster_id=".$id." and pa.ikategori_id=".$idkat." and ni.ldeleted=0 and pa.ldeleted=0";
		$sq=$this->dbset->query($sql);
		$ra=$sq->result_array();
		$s=array();
		foreach ($ra as $qj => $vj) {
			$s[]=number_format(($vj['atas']*$vj['bobo']),2);
		}
		$j=number_format(array_sum($s),2);
		$n[]=floatval($bo*floatval($j));
		$o.='<tr>';
		$o.='<td>'.$k["kategori"].'</td>';
		$o.='<td align="center">'.$bobot.'%</td>';
		$o.='<td align="center">'.floatval($j).'</td>';
		$o.='<td align="center">'.number_format((floatval($bo)*floatval($j)),2).'</td>';
		$o.='</tr>';
	}
	$n_final=array_sum($n);

	$sql="select * from pk.pk_kategori_nilai ni where ni.ldeleted=0 order by ni.iNilai1 ASC";
	$q=$this->db->query($sql);
	$dt=$q->result_array();
	$rows=$q->num_rows();
	$iNilai=array();
	$vKeterangan=array();
	$n_final_kat='';
	$n='';
	foreach ($dt as $ke) {
		$iNilai[]=$ke["iNilai1"]; // Nilai Bataas Bawah
		$vKeterangan[]=$ke["vKeterangan"]; // Keterangan Nilai
	}
	for ($i=0; $i < $rows ; $i++) { 
		if($n_final>=$iNilai[$i]){
			$n=$iNilai[$i];
			$n_final_kat=$vKeterangan[$i];
		}
	}

	$o .="<tr>";
	$o .="<td colspan='3' align='right' style='padding-right:10px;'>JUMLAH</td>";
	$o .="<td align='center'>".number_format($n_final,2)."</td>";
	$o .="</tr>";
	$o .="<tr>";
	$o .="<td colspan='3' align='right' style='padding-right:10px;'>KATEGORI PENILAIAN</td>";
	$o .="<td align='center'>".$n_final_kat."</td>";
	$o .="</tr>";
	$o .= '</tbody></table>';
	$o .='<div id=det_kategori>';
	$sql="select * from pk.pk_kategori_nilai ni where ni.ldeleted=0 order by ni.iNilai1 DESC";
	$q=$this->dbset->query($sql);
	$o .= '<p style="font-size:10px;margin-top:10px">KETERANGAN PENILAIAN :</p>';
		$o .= '<table style="font-size:10px">';
	foreach ($q->result_array() as $key) {
		$o.='<tr>';
		$o.='<td>'.$key['vKeterangan']."</td><td>:</td><td>".$key['iNilai1']." - ".$key['iNilai2'].'</td>';
		$o.='</tr>';
	}
	$qcat="select * from pk.pk_master ma where ma.idmaster_id=".$id;
	$dcat=$this->dbset->query($qcat)->row_array();
	$o .= '</table>';
	$o .= '</div>';
	$o .= '<div id="catatan_atasan" class="box">';
	$o .= '<input type="hidden" value="'.$id.'" name="ipk" />';
	$o .= '<input type="hidden" value="'.$n_final.'" name="ifinal" />';	
	
	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">CATATAN UNTUK KARYAWAN:</label></div>';
	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_umum_pengaju">Komentar/Evaluasi Umum</label><div class="rows_input"><textarea name="tcatatan_umum_pengaju" id="tcatatan_umum_pengaju" class="" style="width:500px" disabled="TRUE">'.$dcat["tcatatan_umum_pengaju"].'</textarea></div></div>';
	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_rencana_pengaju">Rencana untuk periode yang akan datang</label><div class="rows_input"><textarea name="tcatatan_rencana_pengaju" id="tcatatan_rencana_pengaju" class="" style="width:500px" disabled="TRUE">'.$dcat["tcatatan_rencana_pengaju"].'</textarea></div></div>';

	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">CATATAN UNTUK PIMPINAN:</label></div>';
	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_umum_atasan">Evaluasi umum</label><div class="rows_input"><textarea name="tcatatan_umum_atasan" id="tcatatan_umum_atasan" class="" style="width:500px" disabled="TRUE">'.$dcat["tcatatan_umum_atasan"].'</textarea></div></div>';
	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_saran_atasan">Saran/Perbaikan</label><div class="rows_input"><textarea name="tcatatan_saran_atasan" id="tcatatan_saran_atasan" class="" style="width:500px" disabled="TRUE">'.$dcat["tcatatan_saran_atasan"].'</textarea></div></div>';
	$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_pelatihan_atasan">Pelatihan yang diusulkan</label><div class="rows_input"><textarea name="tcatatan_pelatihan_atasan" id="tcatatan_pelatihan_atasan" class="" style="width:500px" disabled="TRUE">'.$dcat["tcatatan_pelatihan_atasan"].'</textarea></div></div>';

	$o .= '<table width=100%>';
	$o .= '<tr>';
	$o .= '<td rowspan=2 style="vertical-align:top;border:1px solid #c5dbec; width:20%">';
	$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">Rencana Karir</label></div>';
	$n=array("1"=>"Demosi","2"=>"Rotasi","3"=>"Mutasi", "4"=>"Promosi", "5"=>"Belum dapat ditentukan sekarang");
	foreach ($n as $k => $v) {
		$select=$dcat['ikarir']==$k?'checked':'';
		$o .= '<input type="radio" name="karir" value="'.$k.'" '.$select.' disabled="TRUE"> '.$v.' <br>';
	}
	
	$o .= '</td>';
	$o .= '<td style="vertical-align:top;border:1px solid #c5dbec;">';
	$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">Ke</label></div>';
	$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="iDeptID">Departement</label><div class="rows_input">';
	if($dcat['iDeptId']!=0){
	$que1 = "select * from hrd.msdepartement dep where dep.lDeleted=0 and dep.iDeptID=".$dcat['iDeptId'];
	$dt1 = $this->dbset->query($que1)->row_array();
	$o .= $dt1['vDescription'];
	}
	//$o .= $que1;
	$o .= '</div></div>';
	$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="iPostId">Posisi</label><div class="rows_input">';
	if($dcat['iPostId']!=0){
		$que = "select * from hrd.position pos where pos.lDeleted=0 and pos.iPostId=".$dcat['iPostId'];
		
		$dt2=$this->dbset->query($que)->row_array();
		$o.=$dt2['vDescription'];
	}
	$o .= '</div></div>';		
	$o .= '</td>';
	$o .= '</tr>';
	$o .= '<tr>';
	$o .= '<td style="vertical-align:top;border:1px solid #c5dbec;">';
	$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">Pertimbangan</label></div>';
	$o .= '<textarea name="tpertimbangan" id="tpertimbangan" class="" style="width:500px" disabled="TRUE">'.$dcat['tPertimbangan'].'</textarea>';
	$o .= '</td>';
	$o .= '</tr>';
	$o .= '</table>';

	$o .= '</div>';
	echo $o;
?>