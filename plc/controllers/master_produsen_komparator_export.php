<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_produsen_komparator_export extends MX_Controller {
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
		$grid->setTitle('Master Produsen Komparator');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_produsen_komparator');		
		$grid->setUrl('master_produsen_komparator_export');
		$grid->addList('vKode_produsen','vNama_produsen');
		$grid->setSortBy('vKode_produsen');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vKode_produsen','vNama_produsen');

		//setting widht grid
		$grid ->setWidth('vKode_produsen', '100'); 
		$grid ->setWidth('vNama_produsen', '500'); 
		//$grid->setWidth('iDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vKode_produsen','Kode Produsen'); 
		$grid->setLabel('vNama_produsen','Nama Produsen Komparator'); 
		//$grid->setLabel('iDeleted','Status'); 
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNama_produsen');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		$grid->changeFieldType('iDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		

	//Field mandatori
		$grid->setRequired('vKode_produsen');	
		$grid->setRequired('vNama_produsen');	
		$grid->setRequired('iDeleted');	

	//	$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
		$grid->setQuery('lDeleted',0);
		//$grid->setMultiSelect(true);
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
					$key = $this->input->post('vNama_produsen');
                        $cek_data = 'select * from dossier_produsen_komparator a where a.vNama_produsen="'.$key.'"  and a.lDeleted=0 ';
                        $data_cek = $this->dbset->query($cek_data)->row_array();
                        if (empty($data_cek) ) {
                             echo $grid->saved_form();
                        }else{
                            $r['status'] = FALSE;
                            $r['message'] = "Nama Produsen Komparator Sudah ada";
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
				$key = $this->input->post('vNama_produsen');
                        $cek_data = 'select * from dossier_produsen_komparator a where a.vNama_produsen="'.$key.'" and a.lDeleted=0 ';
                        $data_cek = $this->dbset->query($cek_data)->row_array();
                        if (empty($data_cek) ) {
                             echo $grid->updated_form();
                        }else{
                            $r['status'] = FALSE;
                            $r['message'] = "Nama Komparator Sudah ada";
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
function insertBox_master_produsen_komparator_export_vKode_produsen($field, $id) {
	$return = 'Auto Number';
	return $return;
}
function updateBox_master_produsen_komparator_export_vKode_produsen($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	

function insertBox_master_produsen_komparator_export_vNama_produsen($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="100" />';
	return $return;
}
function updateBox_master_produsen_komparator_export_vNama_produsen($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="100" />';
		
	}
	
	return $return;
}	


function insertBox_master_produsen_komparator_export_dupdate($field, $id) {
		$skg=date('Y-m-d');
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		$return .= $skg;
		return $return;
}

function updateBox_master_produsen_komparator_export_dupdate($field, $id, $value, $rowData) {
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

function insertBox_master_produsen_komparator_export_cUpdate($field, $id) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$vName = $this->user->gName;
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		$return .= $vName;
		return $return;
}

function updateBox_master_produsen_komparator_export_cUpdate($field, $id, $value, $rowData) {
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

public function after_insert_processor($fields, $id, $post) {

		$cNip = $this->user->gNIP;
		//$tgl = date('Y-m-d', mktime());
		//$tUpdated = date('Y-m-d H:i:s', mktime());
		//$SQL = "UPDATE dossier.dossier_produsen_komparator set cCreatedBy='{$cNip}', dCreated='{$tUpdated}' where id = '{$id}'";
		//$this->dbset->query($SQL);
		
		//update service_request autonumber No Brosur
		$nomor = "P".str_pad($id, 4, "0", STR_PAD_LEFT);
		$sql = "UPDATE dossier.dossier_produsen_komparator SET vKode_produsen = '".$nomor."' WHERE idossier_produsen_komparator_id=$id LIMIT 1";
		$query = $this->db_plc0->query( $sql );
		
		

	}  
	
/*function pendukung end*/    	
	function manipulate_update_button($b){
		if($this->input->get('action')=='view'){
			unset ($b['update']);
		}
		return $b;
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
