<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_jenis_dokumen extends MX_Controller {
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
		$grid->setTitle('Master Jenis Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_jenis_dok');		
		$grid->setUrl('master_jenis_dokumen');
		$grid->addList('vjenis_dok','lDeleted');

		$grid->setSortBy('vjenis_dok');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vjenis_dok','lDeleted');

		//setting widht grid
		$grid ->setWidth('vjenis_dok', '250'); 
		$grid ->setWidth('lDeleted', '150'); 
		
		
		//modif label
		$grid->setLabel('vjenis_dok','Jenis Dokumen'); 
		$grid->setLabel('lDeleted','Status'); 
		$grid->setFormUpload(TRUE);

		$grid->setSearch('vjenis_dok','lDeleted');
		
	 	//ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		

		//Field mandatori
		$grid->setRequired('vjenis_dok');	
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
					$key2 = $this->input->post('master_jenis_dokumen_vjenis_dok');
                    $cek_data = 'select * from dossier_jenis_dok a where a.vjenis_dok="'.$key2.'"';
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
				$id=$this->input->post('master_jenis_dokumen_ijenis_dok_id');
				$key2 = $this->input->post('master_jenis_dokumen_vjenis_dok');
                $cek_data = 'select * from dossier_jenis_dok a where a.vjenis_dok="'.$key2.'" and ijenis_dok_id != "'.$id.'"';
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
function manipulate_update_button($b, $r){
	if($r['ijenis_dok_id']==1){
		unset($b['update']);
	}
	return $b;
}

/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
