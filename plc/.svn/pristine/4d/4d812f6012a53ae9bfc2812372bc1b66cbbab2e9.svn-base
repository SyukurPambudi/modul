<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_dokumen_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Master Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dokumen');		
		$grid->setUrl('master_dokumen_export');
		$grid->addList('idossier_kat_dok_details_id','vNama_Dokumen','ibobot','iPerlu');
		$grid->setSortBy('vNama_Dokumen');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('idossier_kat_dok_details_id','vNama_Dokumen','ibobot','ismodule_stabilita','ibatch','ibulanke','ijenis','inon','iPerlu');

		//setting widht grid
		$grid ->setWidth('vNama_Kategori', '150'); 
		$grid ->setWidth('vNama_Dokumen', '200'); 
		$grid ->setWidth('iPerlu', '70'); 
		
		
		//modif label
		$grid->setLabel('dossier_kat_dok.vNama_Kategori','Kategori'); 
		$grid->setLabel('vNama_Kategori','Kategori'); 
		$grid->setLabel('idossier_kat_dok_details_id','Kategori'); 
		$grid->setLabel('vNama_Dokumen','Nama Dokumen'); 
		$grid->setLabel('msdivision.vDescription','Divisi'); 
		$grid->setLabel('ibobot','Bobot'); 
		$grid->setLabel('ijml_dok','Jumlah Dokumen'); 
		$grid->setLabel('ibatch','Batch Ke'); 
		$grid->setLabel('ibulanke','Bulan Ke'); 
		$grid->setLabel('ijenis','Jenis Stabilita'); 
		$grid->setLabel('inon','Terbalik / Non Terbalik'); 
		$grid->setLabel('ismodule_stabilita','Masuk Dalam Modul Stabilita?'); 

		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		$grid->setLabel('iPerlu','Status'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNama_Dokumen','iPerlu');
		$grid->setJoinTable('dossier.dossier_kat_dok_details', 'dossier_kat_dok_details.idossier_kat_dok_details_id = dossier_dokumen.idossier_kat_dok_details_id', 'left');
		$grid->setJoinTable('dossier.dossier_kat_dok', 'dossier_kat_dok.idossier_kat_dok_id = dossier_kat_dok_details.idossier_kat_dok_id', 'left');
		$grid->setJoinTable('hrd.msdivision', 'msdivision.iDivID=dossier_dokumen.idivisionId','left');
	 	//ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iPerlu','combobox','',array(''=>'Pilih',0=>'Tidak Perlu',1=>'Perlu'));
		

	//Field mandatori
		$grid->setRequired('idossier_kat_dok_details_id');	
		$grid->setRequired('vNama_Dokumen','ijml_dok','ibobot','ibatch','ibulanke','ijenis','inon','iPerlu');

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$post=$this->input->post();
				$key = $this->input->post('idossier_kat_dok_details_id');
				$key2 = $this->input->post('vNama_Dokumen');
                $cek_data = 'select * from dossier_dokumen a where a.idossier_kat_dok_details_id="'.$key.'"  and a.vNama_Dokumen like "'.$key2.'"  and a.lDeleted=0';
                $data_cek = $this->dbset->query($cek_data)->row_array();
                if (empty($data_cek) ) {
                	$d=$this->cekstabi($key);
                	if($d['status']==true){
                		$n=$post['master_dokumen_export_ismodule_stabilita'];
						if($n==1){
							$ibatch=$post['master_dokumen_export_ibatch'];
							$ibulanke=$post['master_dokumen_export_ibulanke'];
							$ijenis=$post['master_dokumen_export_ijenis'];
							$inon=$post['master_dokumen_export_inon'];
	                    	$cd = 'select * from dossier.dossier_dokumen a where a.ibatch="'.$ibatch.'" and a.ibulanke="'.$ibulanke.'" and a.ijenis="'.$ijenis.'" and a.inon="'.$inon.'"  and a.lDeleted=0';
	                    	$d = $this->dbset->query($cd)->row_array();
	                    	if(empty($d)){
	                        	echo $grid->saved_form();
	                        }else{
	                        	$r['status'] = FALSE;
		                        $r['message'] = "Details Stabilita sudah terpakai";
		                        echo json_encode($r);
	                        }
	                    }else{
	                    	echo $grid->saved_form();
	                    }
                    }else{
                    	echo $grid->saved_form();
                    }
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Nama Dokumen Sudah ada";
                    echo json_encode($r);
                }
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'cekstabi':
				echo json_encode($this->cekstabi($this->input->post('id')));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$post=$this->input->post();
				$key = $this->input->post('idossier_kat_dok_details_id');
				$key2 = $this->input->post('vNama_Dokumen');
				$id = $this->input->post('master_dokumen_export_idossier_dokumen_id');
                    $cek_data = 'select * from dossier_dokumen a where a.idossier_kat_dok_details_id="'.$key.'" and a.vNama_Dokumen like "'.$key2.'" and a.lDeleted=0 and a.idossier_dokumen_id!='.$id;
                    $data_cek = $this->dbset->query($cek_data)->row_array();
                    if (empty($data_cek) ) {
	                	$d=$this->cekstabi($key);
	                	if($d['status']==true){
	                		$n=$post['master_dokumen_export_ismodule_stabilita'];
							if($n==1){
								$ibatch=$post['master_dokumen_export_ibatch'];
								$ibulanke=$post['master_dokumen_export_ibulanke'];
								$ijenis=$post['master_dokumen_export_ijenis'];
								$inon=$post['master_dokumen_export_inon'];
		                    	$cd = 'select * from dossier.dossier_dokumen a where a.ibatch="'.$ibatch.'" and a.ibulanke="'.$ibulanke.'" and a.ijenis="'.$ijenis.'" and a.inon="'.$inon.'" and a.lDeleted=0 and a.idossier_dokumen_id!='.$id;
		                    	$d = $this->dbset->query($cd)->row_array();
		                    	if(empty($d)){
		                        	echo $grid->updated_form();
		                        }else{
		                        	$r['status'] = FALSE;
			                        $r['message'] = "Details Stabilita sudah terpakai";
			                        echo json_encode($r);
		                        }
		                    }else{
	                    		echo $grid->updated_form();
	                    	}
	                    }else{
	                    	echo $grid->updated_form();
	                    }
	                }else{
                        $r['status'] = FALSE;
                        $r['message'] = "Nama Dokumen Sudah ada";
                        echo json_encode($r);
                    }
					
				break;
				
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

   

/*manipulasi view object form start*/
function listBox_master_dokumen_export_idossier_kat_dok_details_id($value, $pk, $name, $rowData) {
	$sql="select k.vNama_Kategori,d.vsubmodul_kategori from dossier.dossier_kat_dok k
		inner join dossier.dossier_kat_dok_details d on k.idossier_kat_dok_id=d.idossier_kat_dok_id
		where k.lDeleted=0 and d.lDeleted=0 and d.idossier_kat_dok_details_id=".$value;
	$r=$this->dbset->query($sql);
	if($r->num_rows()!=0){
		$d=$r->row_array();
		$nr=strlen($d['vsubmodul_kategori']);
		if($nr>=50){
			$nama=strlen($d['vsubmodul_kategori'],0,50);
		}else{
			$nama=$d['vsubmodul_kategori'];
		}
		return $d['vNama_Kategori'].'-'.$nama;
	}else{
		return "";
	}
}
/*Manipulate Insert Box */
function insertBox_master_dokumen_export_idossier_kat_dok_details_id($field, $id) {
    $o  = '<select name="'.$field.'" id="'.$id.'" class="required" onchange="javascript:change_istabilita_'.$id.'(\''.$id.'\')">';
    $o .= "<option value=''>Pilih</option>";
    $sql = "select * from dossier.dossier_kat_dok k
			inner join dossier.dossier_kat_dok_details d on k.idossier_kat_dok_id=d.idossier_kat_dok_id
			where k.lDeleted=0 and d.lDeleted=0
			order by k.vNama_Kategori ASC, d.vsubmodul_kategori ASC";
    $q = $this->dbset->query($sql);
    if ($q->num_rows() > 0) {
        $r = $q->result_array();
        foreach($r as $row => $vr) {
        	$selected = '';
           	$nr=strlen($vr['vsubmodul_kategori']);
			if($nr>=50){
				$nama= substr($vr['vsubmodul_kategori'], 0, 50);
			}else{
				$nama=$vr['vsubmodul_kategori'];
			}
           $o .= "<option value='".$vr['idossier_kat_dok_details_id']."'>".$vr['vNama_Kategori']." - ".$nama."</option>";
        }
    }
    $o .= "</select>";
    $o .='<script>';
    $o .='function change_istabilita_'.$id.'(id){
        	var vid=$("#"+id).val();
        	if(vid!=""){
            	$.ajax({
					url: base_url+"processor/plc/master/dokumen/export?action=cekstabi",
					type: "post",
					data: "id="+vid,
					success: function(data) {
						var o = $.parseJSON(data);
						if(o.status==true){
							$("#master_dokumen_export_ismodule_stabilita").parent().parent().show();
							hide_details_stabilita();
						}else{
							$("#master_dokumen_export_ismodule_stabilita").parent().parent().hide();
							hide_details_stabilita();
						}
					}
            	});
			}else{
				hide_details_stabilita();
			}
		}
		function show_details_stabilita(){
			$("#master_dokumen_export_ibatch").parent().parent().show();
			$("#master_dokumen_export_ibatch").parent().parent().show();
			$("#master_dokumen_export_ijenis").parent().parent().show();
			$("#master_dokumen_export_inon").parent().parent().show();
			$("#master_dokumen_export_ibulanke").parent().parent().show();

			$("#master_dokumen_export_ibatch").addClass("required");
			$("#master_dokumen_export_ijenis").addClass("required");
			$("#master_dokumen_export_inon").addClass("required");
			$("#master_dokumen_export_ibulanke").addClass("required");
		}
		function hide_details_stabilita(){
			$("#master_dokumen_export_ibatch").parent().parent().hide();
			$("#master_dokumen_export_ijenis").parent().parent().hide();
			$("#master_dokumen_export_inon").parent().parent().hide();
			$("#master_dokumen_export_ibulanke").parent().parent().hide();

			$("#master_dokumen_export_ibatch").val("");
			$("#master_dokumen_export_ijenis").val("");
			$("#master_dokumen_export_inon").val("");
			$("#master_dokumen_export_ibulanke").val("");

			$("#master_dokumen_export_ibatch").removeClass("required");
			$("#master_dokumen_export_ijenis").removeClass("required");
			$("#master_dokumen_export_inon").removeClass("required");
			$("#master_dokumen_export_ibulanke").removeClass("required");
		}
		$("#master_dokumen_export_ismodule_stabilita").parent().parent().hide();
		hide_details_stabilita();
		';
    $o .='</script>';
    
    return $o;
}
function updateBox_master_dokumen_export_idossier_kat_dok_details_id($field, $id, $value, $rowData) {
	$o  = '<select name="'.$field.'" id="'.$id.'" class="required" onchange="javascript:change_istabilita_'.$id.'(\''.$id.'\')">';
    $o .= "<option value=''>Pilih</option>";
    $sql = "select * from dossier.dossier_kat_dok k
			inner join dossier.dossier_kat_dok_details d on k.idossier_kat_dok_id=d.idossier_kat_dok_id
			where k.lDeleted=0 and d.lDeleted=0
			order by k.vNama_Kategori ASC, d.vsubmodul_kategori ASC";
    $q = $this->dbset->query($sql);
    if ($q->num_rows() > 0) {
        $r = $q->result_array();
        foreach($r as $row => $vr) {
        	$selected = $vr['idossier_kat_dok_details_id']==$value?'selected':'';
           	$nr=strlen($vr['vsubmodul_kategori']);
			if($nr>=50){
				$nama= substr($vr['vsubmodul_kategori'], 0, 50);
			}else{
				$nama=$vr['vsubmodul_kategori'];
			}
           $o .= "<option value='".$vr['idossier_kat_dok_details_id']."' ".$selected.">".$vr['vNama_Kategori']." - ".$nama."</option>";
        }
    }
    $o .= "</select>";
    $o .='<script>';
    $o .='function change_istabilita_'.$id.'(id){
        	var vid=$("#"+id).val();
        	if(vid!=""){
            	$.ajax({
					url: base_url+"processor/plc/master/dokumen/export?action=cekstabi",
					type: "post",
					data: "id="+vid,
					success: function(data) {
						var o = $.parseJSON(data);
						if(o.status==true){
							$("#master_dokumen_export_ismodule_stabilita").parent().parent().show();
							hide_details_stabilita();
						}else{
							$("#master_dokumen_export_ismodule_stabilita").parent().parent().hide();
							hide_details_stabilita();
						}
					}
            	});
			}else{
				hide_details_stabilita();
			}
		}
		function show_details_stabilita(){
			
			$("#master_dokumen_export_ibatch").parent().parent().show();
			$("#master_dokumen_export_ibatch").parent().parent().show();
			$("#master_dokumen_export_ijenis").parent().parent().show();
			$("#master_dokumen_export_inon").parent().parent().show();
			$("#master_dokumen_export_ibulanke").parent().parent().show();

			$("#master_dokumen_export_ibatch").addClass("required");
			$("#master_dokumen_export_ijenis").addClass("required");
			$("#master_dokumen_export_inon").addClass("required");
			$("#master_dokumen_export_ibulanke").addClass("required");
		}
		function hide_details_stabilita(){
			$("#master_dokumen_export_ibatch").parent().parent().hide();
			$("#master_dokumen_export_ijenis").parent().parent().hide();
			$("#master_dokumen_export_inon").parent().parent().hide();
			$("#master_dokumen_export_ibulanke").parent().parent().hide();

			$("#master_dokumen_export_ibatch").val("");
			$("#master_dokumen_export_ijenis").val("");
			$("#master_dokumen_export_inon").val("");
			$("#master_dokumen_export_ibulanke").val("");

			$("#master_dokumen_export_ibatch").removeClass("required");
			$("#master_dokumen_export_ijenis").removeClass("required");
			$("#master_dokumen_export_inon").removeClass("required");
			$("#master_dokumen_export_ibulanke").removeClass("required");
		}
		
	   var vid=$("#'.$id.'").val();
    	if(vid!=""){
        	$.ajax({
				url: base_url+"processor/plc/master/dokumen/export?action=cekstabi",
				type: "post",
				data: "id="+vid,
				success: function(data) {
					var o = $.parseJSON(data);
					if(o.status==true){
						$("#master_dokumen_export_ismodule_stabilita").parent().parent().show();
					}else{
						$("#master_dokumen_export_ismodule_stabilita").parent().parent().hide();
					}
				}
        	});
		}else{
			$("#master_dokumen_export_ismodule_stabilita").parent().parent().hide();
			hide_details_stabilita();
		}
		';
    $o .='</script>';
    
    return $o;    
}	
function insertBox_master_dokumen_export_ismodule_stabilita($field, $id) {
	$r=array(0=>'No',1=>'Yes');
	$o='<select id="'.$id.'" name="'.$id.'"  onchange="javascript:change_ismodule_tabilita_'.$id.'(\''.$id.'\')">';
	foreach ($r as $kr => $vr) {
		$o.='<option value="'.$kr.'">'.$vr.'</option>';
	}
	$o.='</option>';
	$o.='</select>';
	$o.='<script>';
	$o.='function change_ismodule_tabilita_'.$id.'(id){
			var r = $("#"+id).val();
			if(r==1){
				show_details_stabilita();
			}else{
				hide_details_stabilita();
			}
		}';
	$o.='</script>';
	return $o;
}
function updateBox_master_dokumen_export_ismodule_stabilita($field, $id, $value, $rowData) {
	$r=array(0=>'No',1=>'Yes');
	$o='<select id="'.$id.'" name="'.$id.'" onchange="javascript:change_ismodule_tabilita_'.$id.'(\''.$id.'\')">';
	foreach ($r as $kr => $vr) {
		$s=$value==$kr?'selected':'';
		$o.='<option value="'.$kr.'" '.$s.'>'.$vr.'</option>';
	}
	$o.='</option>';
	$o.='</select>';
	$o.='<script>';
	$o.='function change_ismodule_tabilita_'.$id.'(id){
			var r = $("#"+id).val();
			if(r==1){
				show_details_stabilita();
			}else{
				hide_details_stabilita();
			}
		}
		var r1 = $("#'.$id.'").val();
		if(r1==1){
			show_details_stabilita();
		}else{
			hide_details_stabilita();
		}
		';
	$o.='</script>';
	return $o;
}
function insertBox_master_dokumen_export_vNama_Dokumen($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="50" />';
	return $return;
}
function updateBox_master_dokumen_export_vNama_Dokumen($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="50" />';
		
	}
	
	return $return;
}

function insertBox_master_dokumen_export_ijml_dok($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="25" onchange="ceknumber_'.$id.'()" />';
	$return .='<script>';
	$return	.='function ceknumber_'.$id.'(){
				    nilai=$("#'.$id.'").val();
					var number=/^[0-9]+$/;
					if(!nilai.match(number)){
						$("#'.$id.'").val("");
					}
				}';
	$return .='</script>';
	return $return;
}
function updateBox_master_dokumen_export_ijml_dok($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" onchange="ceknumber_'.$id.'()" />';
		
	}
	$return .='<script>';
	$return	.='function ceknumber_'.$id.'(){
				    nilai=$("#'.$id.'").val();
					var number=/^[0-9]+$/;
					if(!nilai.match(number)){
						$("#'.$id.'").val("");
					}
				}';
	$return .='</script>';

	return $return;
}
function insertBox_master_dokumen_export_ibobot($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="25" onchange="ceknumber_'.$id.'()" />';
	$return .='<script>';
	$return	.='function ceknumber_'.$id.'(){
				    nilai=$("#'.$id.'").val();
					var number=/^[0-9]+$/;
					if(!nilai.match(number)){
						$("#'.$id.'").val("");
					}
				}';
	$return .='</script>';
	return $return;
}
function updateBox_master_dokumen_export_ibobot($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" onchange="ceknumber_'.$id.'()" />';
		
	}
	$return .='<script>';
	$return	.='function ceknumber_'.$id.'(){
				    nilai=$("#'.$id.'").val();
					var number=/^[0-9]+$/;
					if(!nilai.match(number)){
						$("#'.$id.'").val("");
					}
				}';
	$return .='</script>';

	return $return;
}

function insertBox_master_dokumen_export_division($field, $id) {
	$sql="select * from hrd.msdivision di where di.lDeleted=0";
	$dt=$this->dbset2->query($sql)->result_array();
	$return = '<select name="'.$id.'"" id="'.$id.'" class="input_rows1 required">';
	$return .= '<option value="">---Pilih---</option>';
	foreach ($dt as $k => $v) {
		$return .= '<option value="'.$v['iDivID'].'">'.$v['vDescription'].'</option>';
	}
	$return .= '</select>';
	return $return;
}
function updateBox_master_dokumen_export_division($field, $id, $value, $rowData) {
	$sql="select * from hrd.msdivision di where di.lDeleted=0";
	$dt=$this->dbset2->query($sql)->result_array();
	$return = '<select name="'.$id.'" id="'.$id.'" class="input_rows1 required">';
	$return .= '<option value="">---Pilih---</option>';
	foreach ($dt as $k => $v) {
		$select=$rowData['idivisionId']==$v['iDivID']?'selected':'';		
		$return .= '<option value="'.$v['iDivID'].'" '.$select.'>'.$v['vDescription'].'</option>';
	}
	$return .= '</select>';
	return $return;
}	


function insertBox_master_dokumen_export_dupdate($field, $id) {
		$skg=date('Y-m-d');
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		$return .= $skg;
		return $return;
}

function updateBox_master_dokumen_export_dupdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
}

function insertBox_master_dokumen_export_cUpdate($field, $id) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$vName = $this->user->gName;
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		$return .= $vName;
		return $return;
}

function updateBox_master_dokumen_export_cUpdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();
		$vName = $this->user->gName;
		if ($this->input->get('action') == 'view') {
			$return= $emp['vName'];

		}
		else{
			$return = $emp['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
}
	
function insertBox_master_dokumen_export_ibatch($field, $id) {
	$d=array(''=>'---Pilih---','1'=>'Batch 1','2'=>'Batch 2','3'=>'Batch 3');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$e.='<option value="'.$k.'">'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function updateBox_master_dokumen_export_ibatch($field, $id, $value, $rowData) {
	$d=array(''=>'---Pilih---','1'=>'Batch 1','2'=>'Batch 2','3'=>'Batch 3');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$sel=$value==$k?'selected':'';
		$e.='<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function insertBox_master_dokumen_export_ibulanke($field, $id) {
	$d=array(''=>'---Pilih---','0'=>'0','1'=>'1','3'=>'3','6'=>'6','9'=>'9','12'=>'12','18'=>'18','24'=>'24','36'=>'36','48'=>'48','60'=>'60');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$e.='<option value="'.$k.'">'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function updateBox_master_dokumen_export_ibulanke($field, $id, $value, $rowData) {
	$d=array(''=>'---Pilih---','0'=>'0','1'=>'1','3'=>'3','6'=>'6','9'=>'9','12'=>'12','18'=>'18','24'=>'24','36'=>'36','48'=>'48','60'=>'60');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$sel=$value==$k?'selected':'';
		$e.='<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function insertBox_master_dokumen_export_ijenis($field, $id) {
	$d=array(''=>'---Pilih---','1'=>'Accelerated','2'=>'Realtime');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$e.='<option value="'.$k.'">'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function updateBox_master_dokumen_export_ijenis($field, $id, $value, $rowData) {
	$d=array(''=>'---Pilih---','1'=>'Accelerated','2'=>'Realtime');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$sel=$value==$k?'selected':'';
		$e.='<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function insertBox_master_dokumen_export_inon($field, $id) {
	$d=array(''=>'---Pilih---','1'=>'Terbalik','2'=>'Non Terbalik');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$e.='<option value="'.$k.'">'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}
function updateBox_master_dokumen_export_inon($field, $id, $value, $rowData) {
	$d=array(''=>'---Pilih---','1'=>'Terbalik','2'=>'Non Terbalik');
	$e='<select name="'.$id.'" id="'.$id.'">';
	foreach ($d as $k => $v) {
		$sel=$value==$k?'selected':'';
		$e.='<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
	}
	$e.='</select>';
	return $e;
}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/
function manipulate_insert_button($b){
		$save = '<button onclick="javascript:save_btn_multiupload(\'master_dokumen_export\', \''.base_url().'processor/plc/master/dokumen/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_master_dokumen_export">Save</button>';
		$js=$this->load->view('export/master_dokumen_export_js');
		$b['save'] = $save.$js;	
		return $b;
	}

function manipulate_update_button($b){
	if($this->input->get('action')=='view'){
		unset ($b['update']);
	}else{
		$save = '<button onclick="javascript:update_btn_back(\'master_dokumen_export\', \''.base_url().'processor/plc/master/dokumen/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update_master_dokumen_export">Update</button>';
		$js=$this->load->view('export/master_dokumen_export_js');
		$b['update'] = $save.$js;	
		return $b;
	}

	return $b;
}
    
   
	/*manipulasi proses object form end*/    

	/*function pendukung start*/  
	function before_update_processor($row, $postData) {
		$postData['dupdate'] = date('Y-m-d H:i:s');
		$postData['cUpdate'] =$this->user->gNIP;
		return $postData;

	}
	function before_insert_processor($row, $postData) {
		$postData['dCreate'] = date('Y-m-d H:i:s');
		$postData['cCreated'] =$this->user->gNIP;
		return $postData;

	}
	
	function cekstabi($id){
		$sql="select * from dossier.dossier_kat_dok_details k
		where k.lDeleted=0 and k.idossier_kat_dok_details_id=".$id;
		$q=$this->dbset->query($sql);
		$a['status']=false;
		if($q->num_rows!=0){
			$d=$q->row_array();
			if($d['istabilita']==2){
				$a['status']=true;
			}
		}
		return $a;
	}

/*function pendukung end*/    	
	public function output(){
		$this->index($this->input->get('action'));
	}

}
