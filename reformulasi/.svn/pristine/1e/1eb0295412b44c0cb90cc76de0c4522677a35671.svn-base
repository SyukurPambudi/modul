<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partial_view_ujibe extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->dbset = $this->load->database('reformulasi', true);
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
		$iupi_id=$_POST['refor_id'];
		$sql1="SELECT a.`iujilab_id`, a.`iupi_id`, DATE_FORMAT(a.`dTanggal_hasil_pemeriksaan`,'%m-%d-%Y') AS a, 
				DATE_FORMAT(a.`dTanggal_kirim_sample`,'%m-%d-%Y') AS b, DATE_FORMAT(a.`dTanggal_permohonan_pemeriksaaan`,'%m-%d-%Y') AS c,
				b.*,c.* FROM plc2.`uji_lab_upi` a 
				JOIN plc2.`lab_penguji` b ON a.`ilab_penguji_id` = b.`ilab_penguji_id`
				JOIN plc2.`daftar_upi` c ON a.`iupi_id` = c.`iupi_id`
				WHERE a.`lDeleted`=0 AND c.iStatusKill AND a.`iupi_id` = ".$iupi_id;

		$data['rows'] = $this->db->query($sql1)->result_array();
		
		$view = $this->load->view('uji_lab_histori',$data,TRUE);

		return $view;
		
	}

	

	function gethistoy_detailtd(){
		$post=$this->input->post();

		/*$sqluji ="SELECT a.`iujilab_id`, a.`iupi_id`, DATE_FORMAT(a.`dTanggal_hasil_pemeriksaan`,'%m-%d-%Y') AS a, 
				DATE_FORMAT(a.`dTanggal_kirim_sample`,'%m-%d-%Y') AS b, DATE_FORMAT(a.`dTanggal_permohonan_pemeriksaaan`,'%m-%d-%Y') AS c,
				b.*,c.* FROM plc2.`uji_lab_upi` a 
				JOIN plc2.`lab_penguji` b ON a.`ilab_penguji_id` = b.`ilab_penguji_id`
				JOIN plc2.`daftar_upi` c ON a.`iupi_id` = c.`iupi_id`
				WHERE a.`lDeleted`=0 AND c.iStatusKill=0 AND a.`iujilab_id` =".$post['iujilab_id'];*/
		$sqluji ="SELECT a.`vNo_req_refor`, a.`cIteno`, 
				b.'C_ITNAM' FROM reformulasi.`lokal_req_refor` a 
				JOIN plc2.`itemas` b ON a.`cIteno` = b.`C_ITENO`		
				WHERE a.`lDeleted`=0 AND a.`vNo_req_refor` =".$post['vNo_req_refor'];*/

		$data['rows'] = $this->dbset->query($sqluji)->result_array();

		$sqlfile1 = "SELECT * FROM reformulasi.`file_lokal_hasil_ujibe` a WHERE a.`vNo_req_refor` =".$post['vNo_req_refor'];
		$data['penawaran']=$this->dbset->query($sqlfile1)->result_array();


		/*$return = $this->load->view('uji_lab_histori_detail',$data,TRUE);*/
		return $return;
	}

	
	public function output(){
		$this->index($this->input->get('action'));
	}

}

