<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_dokumen extends MX_Controller {
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
		$grid->setUrl('master_dokumen');
		$grid->addList('dossier_kat_dok.vNama_Kategori','vNama_Dokumen');
		$grid->setSortBy('vNama_Dokumen');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('idossier_kat_dok_id','vNama_Dokumen');

		//setting widht grid
		$grid ->setWidth('vNama_Kategori', '150'); 
		$grid ->setWidth('vNama_Dokumen', '200'); 
		
		
		//modif label
		$grid->setLabel('dossier_kat_dok.vNama_Kategori','Kategori'); 
		$grid->setLabel('vNama_Kategori','Kategori'); 
		$grid->setLabel('idossier_kat_dok_id','Kategori'); 
		$grid->setLabel('vNama_Dokumen','Nama Dokumen'); 

		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNama_Dokumen');
		$grid->setJoinTable('dossier.dossier_kat_dok', 'dossier_kat_dok.idossier_kat_dok_id = dossier_dokumen.idossier_kat_dok_id', 'inner');
		
	 	//ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		

	//Field mandatori
		$grid->setRequired('idossier_kat_dok_id');	
		$grid->setRequired('vNama_Dokumen');	

	//	$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
		//Set View Gridnya (Default = grid)
		$grid->setQuery('dossier_dokumen.lDeleted', 0);
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
					$key = $this->input->post('idossier_kat_dok_id');
					$key2 = $this->input->post('vNama_Dokumen');
                        $cek_data = 'select * from dossier_dokumen a where a.idossier_kat_dok_id="'.$key.'"  and a.vNama_Dokumen="'.$key2.'"  and a.lDeleted=0';
                        $data_cek = $this->dbset->query($cek_data)->row_array();
                        if (empty($data_cek) ) {
                             echo $grid->saved_form();
                        }else{
                            $r['status'] = FALSE;
                            $r['message'] = "Nama Dokumen Sudah ada";
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
				$key = $this->input->post('idossier_kat_dok_id');
					$key2 = $this->input->post('vNama_Dokumen');
                        $cek_data = 'select * from dossier_dokumen a where a.idossier_kat_dok_id="'.$key.'"  and a.vNama_Dokumen="'.$key2.'"  and a.lDeleted=0';
                        $data_cek = $this->dbset->query($cek_data)->row_array();
                        if (empty($data_cek) ) {
                             echo $grid->updated_form();
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
function insertBox_master_dokumen_idossier_kat_dok_id($field, $id) {
	        $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.idossier_kat_dok_id,a.vNama_Kategori from dossier_kat_dok a";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($id == $row['idossier_kat_dok_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected}  value='".$row['idossier_kat_dok_id']."'>".$row['vNama_Kategori']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
}
function updateBox_master_dokumen_idossier_kat_dok_id($field, $id, $value, $rowData) {
	 if ($this->input->get('action') == 'view') {
            $sql = 'select a.vNama_Dokumen,b.vNama_Kategori,a.idossier_dokumen_id,a.idossier_kat_dok_id
					from dossier_dokumen a  
					join dossier_kat_dok b on b.idossier_kat_dok_id=a.idossier_kat_dok_id 
					where a.idossier_dokumen_id = "'.$rowData['idossier_dokumen_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vNama_Kategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.idossier_kat_dok_id,a.vNama_Kategori from dossier_kat_dok a";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($value == $row['idossier_kat_dok_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['idossier_kat_dok_id']."'>".$row['vNama_Kategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    
}	

function insertBox_master_dokumen_vNama_Dokumen($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="25" />';
	return $return;
}
function updateBox_master_dokumen_vNama_Dokumen($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />';
		
	}
	
	return $return;
}	


function insertBox_master_dokumen_dupdate($field, $id) {
		$skg=date('Y-m-d');
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		$return .= $skg;
		return $return;
}

function updateBox_master_dokumen_dupdate($field, $id, $value, $rowData) {
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

function insertBox_master_dokumen_cUpdate($field, $id) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$vName = $this->user->gName;
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		$return .= $vName;
		return $return;
}

function updateBox_master_dokumen_cUpdate($field, $id, $value, $rowData) {
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

/*function pendukung end*/    	

	
	




	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
