<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class partial_view_tambahan_data extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->user = $this->auth->user();
    }

    function index($action = '') {
    	$action = $this->input->get('action');

    	switch ($action) {
			case 'gethistorytd':
				echo $this->gethistorytd();
				break;
			case 'gethistoy_detailtd':
				echo $this->gethistoy_detailtd();
				break;
			default:
				echo $this->getreviewdokumen();
				break;
		}

    }
	


	function gethistorytd(){
		$iupi_id=$_POST['iupi_id'];
		$sql1="SELECT * FROM plc2.`upi_dok_td` a JOIN plc2.daftar_upi b ON a.iupi_id = b.iupi_id
			WHERE a.`iupi_id` =".$iupi_id." AND a.lDeleted=0 AND b.iStatusKill = 0 AND a.iApprove_bdirm=2 ORDER BY a.iupi_dok_td_id DESC";
		//$sql1="SELECT * FROM plc2.`upi_dok_td` a WHERE a.`iupi_id` = ".$iupi_id." AND a.lDeleted=0 ORDER BY a.iupi_dok_td_id DESC";
		$data['rows'] = $this->db_plc0->query($sql1)->result_array();
		$view = $this->load->view('import/import_tambahan_data_history',$data,TRUE);

		return $view;
		
	}

	

	function gethistoy_detailtd(){
		$post=$this->input->post();


		$sqlfile2 ="SELECT * FROM plc2.`upi_dok_td_detail` a WHERE a.`iupi_dok_td_id` = ".$post['iupi_dok_td_id'];
		$data['tgl']=$this->dbset->query($sqlfile2)->result_array();


		$return = $this->load->view('import/import_tambahan_data_history_detail',$data,TRUE);
		return $return;
	}

	
	public function output(){
		$this->index($this->input->get('action'));
	}

}

