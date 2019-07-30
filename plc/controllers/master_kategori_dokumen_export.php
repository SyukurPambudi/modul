<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_kategori_dokumen_export extends MX_Controller {
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
		$grid->setTitle('Master Kategori Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_kat_dok');		
		$grid->setUrl('master_kategori_dokumen_export');
		$grid->addList('vNama_Kategori');
		$grid->setSortBy('vNama_Kategori');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNama_Kategori');

		//setting widht grid
		$grid ->setWidth('vNama_Kategori', '250'); 
		
		
		//modif label
		$grid->setLabel('vNama_Kategori','Kategori'); 
		$grid->setLabel('vmodul_kategori','Sub Kategori'); 
		$grid->setLabel('lDeleted','Status'); 
		$grid->setQuery('dossier_kat_dok.lDeleted',0);
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNama_Kategori');
		//Field mandatori
		$grid->setRequired('vNama_Kategori');	

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
						$key = $this->input->post('vNama_Kategori');
						//$key2 = $this->input->post('vmodul_kategori');
                        $cek_data = 'select * from dossier_kat_dok a where a.vNama_Kategori like "%'.$key.'%"';
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
				$id=$this->input->post('master_kategori_dokumen_export_idossier_kat_dok_id');
				$key = $this->input->post('vNama_Kategori');
				//$key2 = $this->input->post('vmodul_kategori');
                $cek_data = 'select * from dossier_kat_dok a where a.vNama_Kategori like "%'.$key.'%" and a.idossier_kat_dok_id != "'.$id.'"';
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
			default:
				$grid->render_grid();
				break;
		}
    }

   

/*manipulasi view object form start*/
function insertBox_master_kategori_dokumen_export_vNama_Kategori($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="15" />';
	return $return;
}
function updateBox_master_kategori_dokumen_export_vNama_Kategori($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';
		
	}
	
	return $return;
}	
function insertBox_master_kategori_dokumen_export_vmodul_kategori($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="15" />';
	return $return;
}
function updateBox_master_kategori_dokumen_export_vmodul_kategori($field, $id, $value, $rowData) {
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

	function manipulate_update_button($b){
		if($this->input->get('action')=='view'){
			unset ($b['update']);
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
