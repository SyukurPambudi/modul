<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_sediaan_dokumen_export extends MX_Controller {
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
		$grid->setTitle('Master Sediaan Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_sediaan_dok');		
		$grid->setUrl('master_sediaan_dokumen_export');
		$grid->addList('vsediaan_dok','lDeleted');

		$grid->setSortBy('vsediaan_dok');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vsediaan_dok','lDeleted');

		//setting widht grid
		$grid ->setWidth('vsediaan_dok', '250'); 
		$grid ->setWidth('lDeleted', '150'); 
		
		
		//modif label
		$grid->setLabel('vsediaan_dok','Jenis Dokumen'); 
		$grid->setLabel('lDeleted','Status'); 
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vsediaan_dok','lDeleted');
		
	 	//ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		

		//Field mandatori
		$grid->setRequired('vsediaan_dok');	
		$grid->setRequired('lDeleted');	

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
					$key2 = $this->input->post('master_sediaan_dokumen_export_vsediaan_dok');
                    $cek_data = 'select * from dossier_sediaan_dok a where a.vsediaan_dok="'.$key2.'"';
                    $data_cek = $this->dbset->query($cek_data)->num_rows();
                    if ($data_cek==0) {
                         echo $grid->saved_form();
                    }else{
                        $r['status'] = FALSE;
                        $r['message'] = "Nama Dokumen Sudah ada!";
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
				$id=$this->input->post('master_sediaan_dokumen_export_isediaan_dok_id');
				$key2 = $this->input->post('master_sediaan_dokumen_export_vsediaan_dok');
                $cek_data = 'select * from dossier_sediaan_dok a where a.vsediaan_dok="'.$key2.'" and isediaan_dok_id != "'.$id.'"';
                $data_cek = $this->dbset->query($cek_data)->num_rows();
                if ($data_cek==0) {
                     echo $grid->updated_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Nama Dokumen Sudah ada!";
                    echo json_encode($r);
                }
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

   

/*manipulasi view object form start*/



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
