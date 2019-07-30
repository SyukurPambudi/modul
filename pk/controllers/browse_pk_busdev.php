<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_pk_busdev extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    			
		switch ($action) {		
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				//print_r($post);exit();
				$postfinal=$post['ifinal'];
				$catatan_umum=$post['tcatatan_umum_atasan'];
				$catatan_atasan=$post['tcatatan_saran_atasan'];
				$t='';
				if(isset($post['karir'])){
					$karir=$post['karir'];
					$t.=", ikarir='".$post['karir']."'";
				}
				if(isset($post['iDeptID'])){
					$iDeptID=$post['iDeptID'];
					$t.=", iDeptId='".$post['iDeptID']."'";
				}
				if(isset($post['iPostId'])){
					$iPostId=$post['iPostId'];
					$t.=", iPostId='".$post['iPostId']."'";
				}
				$sql="UPDATE plc2.pk_master SET is_confirm=1, is_dinilai='".$postfinal."', tcatatan_umum_atasan='".$catatan_umum."', tcatatan_saran_atasan='".$catatan_atasan."',tcatatan_pelatihan_atasan='".$post['tcatatan_pelatihan_atasan']."'".$t.", tPertimbangan='".$post['tpertimbangan']."' WHERE  idmaster_id=".$post['ipk'];
				$this->db_erp_pk->query($sql);
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
			case 'getPosisi':
				$dt='';
				$dt.='<option value="">Pilih Posisi</option>';
				$que = "select po.* from hrd.position po
						inner join hrd.msdivision di on di.igrpdivid=po.igrpdivid
						inner join hrd.msdepartement de on de.iDivID=di.iDivID
						where po.ldeleted=0 and di.ldeleted=0 and de.ldeleted=0 and de.iDeptID=".$this->input->post('iDeptID');
				$dt1=$this->db_erp_pk->query($que)->result_array();
				foreach ($dt1 as $kd => $vd) {
					$dt.='<option value="'.$vd['iPostId'].'">'.$vd['vDescription'].'</option>';
				}
				$data['row']=$dt;
				echo json_encode($data);
				exit();
				break;
			default:
				echo $this->viewform($this->input->get('id'),$this->input->get('vnip'));
				break;
		}
    }
/*Maniupulasi Gird end*/
/*manipulasi view object form start*/
public function viewform($id=0,$nipnya=0){
		$qdkat="select * from plc2.pk_kategori kat where kat.ldeleted=0";
		$dkat=$this->db_erp_pk->query($qdkat)->result_array();
		$o ='';
		$sql="select em.cNip,em.vName,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk from hrd.employee em
			inner join hrd.msdepartement de on de.iDeptID=em.iDeptID
			inner join hrd.msdivision di on em.iDivisionID=di.iDivID
			inner join hrd.position po on po.iPostId=em.iPostID
			Where em.cNip='".$nipnya."'";
		$data['rows'] = $this->db->query($sql)->result_array();
		$data['id']="view_browse";
		$o.=$this->load->view('browse_details_employee',$data);
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
			$sql="select sum(ni.poin_sepakat) as jml from plc2.pk_nilai ni
					inner join plc2.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
					where ni.idmaster_id=".$id." and pa.ikategori_id=".$idkat." and ni.ldeleted=0 and pa.ldeleted=0";
			$jml=$this->db_erp_pk->query($sql)->row_array();
			$j=$jml["jml"];
			$n[]=floatval($k["bobot"])*floatval($j);
			$o.='<tr>';
			$o.='<td>'.$k["kategori"].'</td>';
			$o.='<td align="center">'.$bobot.'%</td>';
			$o.='<td align="center">'.$jml["jml"].'</td>';
			$o.='<td align="center">'.floatval($k["bobot"])*floatval($j).'</td>';
			$o.='</tr>';
		}
		$n_final=array_sum($n);
		$o .="<tr>";
		$o .="<td colspan='3' align='right' style='padding-right:10px;'>JUMLAH</td>";
		$o .="<td align='center'>".$n_final."</td>";
		$o .="</tr>";
		$o .="<tr>";
		$o .="<td colspan='3' align='right' style='padding-right:10px;'>KATEGORI PENILAIAN</td>";
		$o .="<td align='center'>".$this->getKategori($n_final)."</td>";
		$o .="</tr>";
		$o .= '</tbody></table>';
		$o .='<div id=det_kategori>';
		$sql="select * from plc2.pk_kategori_nilai ni where ni.ldeleted=0 order by ni.iNilai1 DESC";
		$q=$this->db_erp_pk->query($sql);
		$o .= '<p style="font-size:10px;margin-top:10px">KETERANGAN PENILAIAN :</p>';
 		$o .= '<table style="font-size:10px">';
		foreach ($q->result_array() as $key) {
			$o.='<tr>';
			$o.='<td>'.$key['vKeterangan']."</td><td>:</td><td>".$key['iNilai1']." - ".$key['iNilai2'].'</td>';
			$o.='</tr>';
		}
		$o .= '</table>';
		$o .= '</div>';

		$sq="select * from plc2.pk_master ma where ma.idmaster_id=".$id." and ldeleted=0";
		$row=$this->db_erp_pk->query($sq)->row_array();
		$o .= '<div id="catatan_atasan" class="box">';
		$o .= '<input type="hidden" value="'.$id.'" name="ipk" class="tab_note" />';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">CATATAN UNTUK KARYAWAN:</label></div>';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_umum_pengaju">Komentar/Evaluasi Umum</label><div class="rows_input"><textarea name="tcatatan_umum_pengaju" id="tcatatan_umum_pengaju" class="tab_note" style="width:500px" disabled="TRUE">'.$row['tcatatan_umum_pengaju'].'</textarea></div></div>';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_rencana_pengaju">Rencana untuk periode yang akan datang</label><div class="rows_input"><textarea name="tcatatan_rencana_pengaju" id="tcatatan_rencana_pengaju" class="tab_note" style="width:500px" disabled="TRUE">'.$row['tcatatan_rencana_pengaju'].'</textarea></div></div>';
		$o.='</div>';

		$o .= '<div id="catatan_atasan" class="box">';
		$o .= '<form id="formcatatan">';
		$o .= '<input type="hidden" value="'.$id.'" name="ipk" />';
		$o .= '<input type="hidden" value="'.$n_final.'" name="ifinal" />';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">CATATAN UNTUK PIMPINAN:</label></div>';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_umum_atasan"> Evaluasi umum</label><div class="rows_input"><textarea name="tcatatan_umum_atasan" id="tcatatan_umum_atasan" class="" style="width:500px"></textarea></div></div>';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_saran_atasan">Saran/Perbaikan</label><div class="rows_input"><textarea name="tcatatan_saran_atasan" id="tcatatan_saran_atasan" class="" style="width:500px"></textarea></div></div>';
		$o .= '<div style="overflow:auto;" class="rows_group"><label class="rows_label" for="tcatatan_pelatihan_atasan">Pelatihan yang diusulkan</label><div class="rows_input"><textarea name="tcatatan_pelatihan_atasan" id="tcatatan_pelatihan_atasan" class="" style="width:500px"></textarea></div></div>';
		$o .= '<table width=100%>';
		$o .= '<tr>';
		$o .= '<td rowspan=2 style="vertical-align:top;border:1px solid #c5dbec; width:20%">';
		$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">Rencana Karir</label></div>';
		$o .= '<input type="radio" name="karir" value="1"> Demosi <br>';
		$o .= '<input type="radio" name="karir" value="2"> Rotasi <br>';
		$o .= '<input type="radio" name="karir" value="3"> Mutasi <br>';
		$o .= '<input type="radio" name="karir" value="4"> Promosi <br>';
		$o .= '<input type="radio" name="karir" value="5"> Belum dapat ditentukan sekarang';
		$o .= '</td>';
		$o .= '<td style="vertical-align:top;border:1px solid #c5dbec;">';
		$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">Ke</label></div>';
		$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="iDeptID">Departement</label><div class="rows_input"><select name="iDeptID" id="iDeptID">';
		$o .= '<option value="">Pilih Departement</option>';
		$que = "select * from hrd.msdepartement dep where dep.lDeleted=0";
		$dt=$this->db_erp_pk->query($que)->result_array();
		foreach ($dt as $kd => $vd) {
			$o.='<option value="'.$vd['iDeptID'].'">'.$vd['vDescription'].'</option>';
		}
		$o .= '</select></div></div>';
		$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="iPostId">Posisi</label><div class="rows_input"><select name="iPostId" id="iPostId">';
		$o .= '</select></div></div>';		
		$o .= '</td>';
		$o .= '</tr>';
		$o .= '<tr>';
		$o .= '<td style="vertical-align:top;border:1px solid #c5dbec;">';
		$o .= '<div style="overflow:fix;" class="rows_group"><label class="rows_label" for="browse_label" style="border: 1px solid rgb(221, 221, 221); background: rgb(84, 140, 182) none repeat scroll 0% 0%; border-collapse: collapse; width: 98%; font-weight: bold; color: rgb(255, 255, 255); text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;margin-bottom:10px;">Pertimbangan</label></div>';
		$o .= '<textarea name="tpertimbangan" id="tpertimbangan" class="" style="width:500px"></textarea>';
		$o .= '</td>';
		$o .= '</tr>';
		$o .= '</table>';
		$o .= '</form>';
		$o .= '</div>';
		$o .= '<button onclick="javascript:setuju(\'pk_busdev\', \''.base_url().'processor/pk/browse/pk/busdev?action=confirm&last_id='.$id.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_save_pk_busdev">Confirm</button>';
		$o .="<script>
			$('#iDeptID').change(function(){
				var val=$(this).val();
				url=base_url+'processor/pk/browse/pk/busdev?action=getPosisi';
				$.ajax({
						url: url,
						type: 'post',
						data: 'iDeptID='+$('#iDeptID').val(),
						success: function(data) {
							var o = $.parseJSON(data);
							var row = o.row;
							$('#iPostId').html(row);							
						}		
					});
			});
			function setuju(grid, url){
				custom_confirm('Anda Yakin?',function(){
					$.ajax({
						url: url,
						type: 'post',
						data: $('#formcatatan').serialize(),
						success: function(data) {
							var o = $.parseJSON(data);
							if(o.status==true){
								var info = 'success';
								var header = 'success';
								_custom_alert(o.message,header,info, grid, 1, 20000);
								$('#grid_'+grid).trigger('reloadGrid');
							}else{
								var info = 'error';
								var header = 'error';
								_custom_alert(o.message,header,info, grid, 1, 20000);
							}
							$.get(base_url+'processor/pk/pk/busdev?action=view&id='+o.last_id+'&foreign_key='+o.foreign_id+'&company_id='+o.company_id+'&group_id='+o.group_id+'&modul_id='+o.modul_id, function(data) {
			                        $('div#form_'+grid).html(data);
			                        $('html, body').animate({scrollTop:$('#'+grid).offset().top - 20}, 'slow');
			                });
							$('#alert_dialog_form').dialog('close');
						}		
					});
				});
			}
			</script>";
	return $o;
}
function getKategori($nilai=0){
	$sql="select * from plc2.pk_kategori_nilai ni where ni.ldeleted=0 order by ni.iNilai1 ASC";
	$q=$this->db_erp_pk->query($sql);
	$dt=$q->result_array();
	$rows=$q->num_rows();
	$iNilai=array();
	$vKeterangan=array();
	$return='';
	$n='';
	foreach ($dt as $ke) {
		$iNilai[]=$ke["iNilai1"]; // Nilai Bataas Bawah
		$vKeterangan[]=$ke["vKeterangan"]; // Keterangan Nilai
	}
	for ($i=0; $i < $rows ; $i++) { 
		if($nilai>=$iNilai[$i]){
			$n=$iNilai[$i];
			$return=$vKeterangan[$i];
		}
	}
	return $return;
}


public function output(){
		$this->index($this->input->get('action'));
	}

}

