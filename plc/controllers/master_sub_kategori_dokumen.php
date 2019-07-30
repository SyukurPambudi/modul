<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_sub_kategori_dokumen extends MX_Controller {
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
		$grid->setTitle('Master Sub Kategori Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_kat_dok_details');		
		$grid->setUrl('master_sub_kategori_dokumen');
		$grid->addList('dossier_kat_dok.vNama_Kategori','vsubmodul_kategori');
		$grid->setSortBy('dossier_kat_dok.vNama_Kategori');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('idossier_kat_dok_id','vsubmodul_kategori','istabilita');

		//setting widht grid
		$grid ->setWidth('dossier_kat_dok.vNama_Kategori', '250'); 
		
		
		//modif label
		$grid->setLabel('dossier_kat_dok.vNama_Kategori','Kategori'); 
		$grid->setLabel('idossier_kat_dok_id','Kategori'); 
		$grid->setLabel('vsubmodul_kategori','Sub Kategori'); 
		$grid->setLabel('istabilita','Is Stabilita?'); 
		$grid->setLabel('lDeleted','Status'); 

		$grid->setSearch('dossier_kat_dok.vNama_Kategori');
		//Field required
		$grid->setRequired('idossier_kat_dok_id','vsubmodul_kategori');	

		//Set Join Table
		$grid->setJoinTable('dossier.dossier_kat_dok','dossier_kat_dok.idossier_kat_dok_id=dossier_kat_dok_details.idossier_kat_dok_id','INNER');

		//set Mandatori
		$grid->setQuery('dossier_kat_dok_details.lDeleted',0);
		$grid->setQuery('dossier_kat_dok.lDeleted',0);

		//change type field
		$grid->changeFieldType('istabilita','combobox','',array(0=>'No', 2=>'Yes'));

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$key = $this->input->post('master_sub_kategori_dokumen_idossier_kat_dok_id');
				$key2 = $this->input->post('master_sub_kategori_dokumen_vsubmodul_kategori');
                $cek_data = 'select * from dossier_kat_dok_details a where a.idossier_kat_dok_id like "'.$key.'" and a.vsubmodul_kategori like "'.$key2.'" and a.lDeleted=0';
                $data_cek = $this->dbset->query($cek_data)->row_array();
                if (empty($data_cek) ) {
                     echo $grid->saved_form();
                }else{
                   	$r['status'] = FALSE;
                    $r['message'] = "Nama Kategori dan Sub Kategori Sudah ada";
                    echo json_encode($r);
                }
				break;
			case 'download':
				$this->download($this->input->get('file'));
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
				$id=$this->input->post('master_sub_kategori_dokumen_idossier_kat_dok_details_id');
				$key = $this->input->post('master_sub_kategori_dokumen_idossier_kat_dok_id');
				$key2 = $this->input->post('master_sub_kategori_dokumen_vsubmodul_kategori');
                $cek_data = 'select * from dossier_kat_dok_details a where a.idossier_kat_dok_id like "'.$key.'" and a.vsubmodul_kategori like "'.$key2.'" and a.idossier_kat_dok_details_id!='.$id.' and a.lDeleted=0';
                $data_cek = $this->dbset->query($cek_data)->num_rows();
                if ($data_cek==0) {
                     echo $grid->updated_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Nama Kategori dan Sub Kategori Sudah ada";
                    echo json_encode($r);
                }
				break;
				
			case 'employee_list':
				$this->employee_list();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

   

/*manipulasi view object form start*/
function insertBox_master_sub_kategori_dokumen_idossier_kat_dok_id($field, $id) {
	$sq='select * from dossier.dossier_kat_dok where lDeleted=0';
	$r=$this->dbset->query($sq)->result_array();
	$return='<select id="'.$id.'" name="'.$id.'" class="required" >';
	$return.='<option value="">---Pilih---</option>';
	foreach ($r as $kt => $vr) {
		$return.='<option value="'.$vr['idossier_kat_dok_id'].'" >'.$vr['vNama_Kategori'].'</option>';
	}
	$return.='</select>';
	return $return;
}
function updateBox_master_sub_kategori_dokumen_idossier_kat_dok_id($field, $id, $value, $rowData) {
	$sq='select * from dossier.dossier_kat_dok where lDeleted=0';
	$r1=$this->dbset->query($sq)->result_array();
	$r='<select id="'.$id.'" name="'.$id.'" class="required" >';
	$r.='<option value="">---Pilih---</option>';
	$v='';
	foreach ($r1 as $kt => $vr) {
		$select=$vr['idossier_kat_dok_id']==$value?'selected':'';
		if($vr['idossier_kat_dok_id']==$value){
			$v=$vr['vNama_Kategori'];
		}
		$r.='<option value="'.$vr['idossier_kat_dok_id'].'" '.$select.' >'.$vr['vNama_Kategori'].'</option>';
	}
	$r.='</select>';
	if ($this->input->get('action') == 'view') {
		$return= $v;

	}
	else{
		$return = $r;
		
	}
	
	return $return;
}	
function insertBox_master_sub_kategori_dokumen_vmodul_kategori($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="15" />';
	return $return;
}
function updateBox_master_sub_kategori_dokumen_vmodul_kategori($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
		
	}
	
	return $return;
}

function insertBox_master_negara_dupdate($field, $id) {
		$skg=date('Y-m-d');
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		$return .= $skg;
		return $return;
}

function updateBox_master_negara_dupdate($field, $id, $value, $rowData) {
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

function insertBox_master_negara_cUpdate($field, $id) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$vName = $this->user->gName;
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		$return .= $vName;
		return $return;
}

function updateBox_master_negara_cUpdate($field, $id, $value, $rowData) {
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

/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_insert_button($b){
		$save = '<button onclick="javascript:save_btn_multiupload(\'master_sub_kategori_dokumen\', \''.base_url().'processor/plc/master/sub/kategori/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_master_sub_kategori_dokumen">Save</button>';
		$js=$this->load->view('export/master_sub_kategori_dokumen');
		$b['save'] = $save.$js;	
		return $b;
	}

	function manipulate_update_button($b){
		if($this->input->get('action')=='view'){
			unset ($b['update']);
		}else{
			$save = '<button onclick="javascript:update_btn_back(\'master_sub_kategori_dokumen\', \''.base_url().'processor/plc/master/sub/kategori/dokumen?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_study_literatur_pd">Update</button>';
			$js=$this->load->view('export/master_sub_kategori_dokumen');
			$b['update'] = $save.$js;	
			return $b;
		}
		return $b;
	}

/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	return $postData;

}
function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;
	return $postData;

}


/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
