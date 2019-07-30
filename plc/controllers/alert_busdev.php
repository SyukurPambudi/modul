<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Alert_busdev extends MX_Controller {
	private $sess_auth;
	private $dbset;

			
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->library('biz_process');
		$this->load->helper('tanggal');
		$this->load->model('user_model');
        $this->url = 'alert_busdev'; 
		$this->dbset = $this->load->database('plc', true);
		
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$grid = new Grid;		
		$grid->setTitle('Alert Cek Dokumen PraRegistrasi');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('alert_busdev');		
		$grid->addFields('listcek');
		$grid->setLabel('listcek', 'List');
		 // $grid->setLabel('iteambusdev_id', 'Tim Busdev');
		 // $grid->setLabel('iteampd_id', 'Tim PD');
	
		switch ($action) {		
			case 'view':
				$grid->render_form();
				break;
			case 'rawmat_list':
				$this->rawmat_list();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index('view');
	}
	public function insertBox_alert_busdev_listcek($field, $id) {
		$data['mydept'] = $this->auth->my_depts(TRUE);	
		$data['team'] = $this->auth->my_teams();
		return $this->load->view('view_alert_busdev',$data,TRUE);
	}
	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
	}
	
}
?>
