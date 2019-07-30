<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_detail_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->_field = $this->input->get('field');
		$this->_upb_id = $this->input->get('iupb_id');
    }
    function index($action = '') {
    	
    	$dataUPB = $this->getDetailUPB($_GET['iupb_id']);
    	$data['dataUPB'] = $dataUPB;
    	$view = $this->load->view('partial/detail_upb',$data);
    	echo $view;

    }


    function output(){
    	$this->index($this->input->get('action'));
    }


    function getDetailUPB($iupb_id){
			$sql = 'select a.vupb_nomor,a.ttanggal,a.vupb_nama,a.vgenerik , b.vteam as timBD , c.vteam as timMKT,d.vteam as timPD
			,e.vteam as timQA
				from plc2.plc2_upb a 
				left join plc2.plc2_upb_team b on b.iteam_id = a.iteambusdev_id
				left join plc2.plc2_upb_team c on c.iteam_id = a.iteammarketing_id 
				left join plc2.plc2_upb_team d on d.iteam_id = a.iteampd_id
				left join plc2.plc2_upb_team e on e.iteam_id = a.iteamqa_id
				where a.iupb_id= ?
		';
		$dUPB =  $this->db->query($sql, array($iupb_id))->row_array();

		return $dUPB;
    }

	
}
