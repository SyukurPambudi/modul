<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_applicant extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Applicant');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.applicant');		
		$grid->setUrl('master_applicant');
		$grid->addList('vNama_applicant','vAlamat');
		$grid->setSortBy('vNama_applicant');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNama_applicant','vAlamat');//,'dupdate','cUpdate');

		//setting widht grid
		$grid ->setWidth('vNama_applicant', '200'); 
		$grid ->setWidth('vAlamat', '350'); 
		$grid->setWidth('ideleted', '110'); 
		
		
		//modif label
		$grid->setLabel('vNama_applicant','Nama Applicant'); //Ganti Label
		$grid->setLabel('vAlamat','Alamat'); 
		$grid->setLabel('ideleted','Status'); 
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNama_applicant');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		//$grid->changeFieldType('istatus','combobox','',array(''=>'Pilih','C'=>'Kontrak','A'=>'Tetap'));
		$grid->changeFieldType('ideleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		

	//Field mandatori
		$grid->setRequired('vNama_applicant');	
		$grid->setRequired('vAlamat');	
		$grid->setQuery('lDeleted = "0" ', null);		

	//	$grid->setQuery('asset.asset_sparepart.ldeleted', 0);
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
					$key = $this->input->post('vNama_applicant');
                        $cek_data = 'select * from applicant a where a.vNama_applicant="'.$key.'" ';
                        $data_cek = $this->dbset->query($cek_data)->row_array();
                        if (empty($data_cek) ) {
                             echo $grid->saved_form();
                        }else{
                            $r['status'] = FALSE;
                            $r['message'] = "Nama Applicant Sudah ada";
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
				$id=$_POST['master_applicant_iapplicant_id']; 
                $key = $this->input->post('vNama_applicant');

                $cek_data = 'select * from plc2.applicant a where a.vNama_applicant="'.$key.'" and a.lDeleted=0 ';
                $result = $this->db_plc0->query($cek_data)->row_array();

                $sql2 = 'select * from plc2.applicant a where a.iapplicant_id = "'.$id.'"';
                $old = $this->db_plc0->query($sql2)->row_array();


                if (empty($result) or $old['vNama_applicant'] == $key  ) {
                        echo $grid->updated_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Nama Applicant Sudah ada";
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
function insertBox_master_applicant_vNama_applicant($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="30" />';
	return $return;
}
function updateBox_master_applicant_vNama_applicant($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="30" />';
		
	}
	
	return $return;
}	

function insertBox_master_applicant_vAlamat($field, $id) {
    $o  = "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";        
    $o .= " <script>
            $('#".$id."').keyup(function() {
            var len = this.value.length;
            if (len >= 250) {
            this.value = this.value.substring(0, 250);
            }
            $('#maxlengthnote').text(250 - len);
            });
        </script>";
    $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
                                            
    return $o;
}

function updateBox_master_applicant_vAlamat($field, $id, $value, $rowData) {
    if ($this->input->get('action') == 'view') { 
        $o = "<label title='Note'>".nl2br($value)."</label>";
    
    }else{
        $o  = "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";     
        $o .= " <script>
            $('#".$id."').keyup(function() {
            var len = this.value.length;
            if (len >= 250) {
            this.value = this.value.substring(0, 250);
            }
            $('#maxlengthnote').text(250 - len);
            });
        </script>";
        $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
    }

    return $o;
}




function insertBox_master_applicant_dupdate($field, $id) {
		$skg=date('Y-m-d H:i:s');
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
		$return .= $skg;
		return $return;
}

function updateBox_master_applicant_dupdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d H:i:s');
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = $skg;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
}

function insertBox_master_applicant_cUpdate($field, $id) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$vName = $this->user->gName;
		$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
		$return .= $vName;
		return $return;
}

function updateBox_master_applicant_cUpdate($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		$empu = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();
		$vName = $this->user->gName;
		if ($this->input->get('action') == 'view') {
			$return= $emp['vName'];

		}
		else{
			$return = $empu['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
}
	
	


/*manipulasi view object form end*/

/*manipulasi proses object form start*/
function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;
	return $postData;

}
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
	
	return $postData;

}

    
   
/*manipulasi proses object form end*/    

/*function pendukung start*/    
	
/*function pendukung end*/    	

	
	


function manipulate_update_button($buttons, $rowData) {
	 	if ($this->input->get('action') == 'view') {
	 		unset($buttons['update']);
	 	}
		else{

			
		}
		
		return $buttons;
	}

	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
