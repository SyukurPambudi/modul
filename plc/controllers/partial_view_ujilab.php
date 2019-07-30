<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partial_view_ujilab extends MX_Controller {
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
		$sql1="SELECT a.`iujilab_id`, a.`iupi_id`, DATE_FORMAT(a.`dTanggal_hasil_pemeriksaan`,'%m-%d-%Y') AS a, 
				DATE_FORMAT(a.`dTanggal_kirim_sample`,'%m-%d-%Y') AS b, DATE_FORMAT(a.`dTanggal_permohonan_pemeriksaaan`,'%m-%d-%Y') AS c,
				b.*,c.* FROM plc2.`uji_lab_upi` a 
				JOIN plc2.`lab_penguji` b ON a.`ilab_penguji_id` = b.`ilab_penguji_id`
				JOIN plc2.`daftar_upi` c ON a.`iupi_id` = c.`iupi_id`
				WHERE a.`lDeleted`=0 AND c.iStatusKill AND a.`iupi_id` = ".$iupi_id;

		$data['rows'] = $this->db_plc0->query($sql1)->result_array();
		
		$view = $this->load->view('uji_lab_histori',$data,TRUE);

		return $view;
		
	}

	

	function gethistoy_detailtd(){
		$post=$this->input->post();

		$sqluji ="SELECT a.`iujilab_id`, a.`iupi_id`, DATE_FORMAT(a.`dTanggal_hasil_pemeriksaan`,'%m-%d-%Y') AS a, 
				DATE_FORMAT(a.`dTanggal_kirim_sample`,'%m-%d-%Y') AS b, DATE_FORMAT(a.`dTanggal_permohonan_pemeriksaaan`,'%m-%d-%Y') AS c,
				b.*,c.* FROM plc2.`uji_lab_upi` a 
				JOIN plc2.`lab_penguji` b ON a.`ilab_penguji_id` = b.`ilab_penguji_id`
				JOIN plc2.`daftar_upi` c ON a.`iupi_id` = c.`iupi_id`
				WHERE a.`lDeleted`=0 AND c.iStatusKill=0 AND a.`iujilab_id` =".$post['iujilab_id'];
		$data['rows'] = $this->dbset->query($sqluji)->result_array();

		$sqlfile1 = "SELECT * FROM plc2.`file_surat_penawaran` a WHERE a.`iujilab_id` =".$post['iujilab_id'];
		$data['penawaran']=$this->dbset->query($sqlfile1)->result_array();

		$sqlfile2 ="SELECT * FROM plc2.`file_parameter_periksa` a WHERE a.`iujilab_id` =".$post['iujilab_id'];
		$data['paramate']=$this->dbset->query($sqlfile2)->result_array();

		$sqlfile3 ="SELECT * FROM plc2.`file_bukti_bayar` a WHERE a.`iujilab_id` =".$post['iujilab_id'];
		$data['bukti']=$this->dbset->query($sqlfile3)->result_array();

		$sqlfile4 ="SELECT * FROM plc2.`file_hasil_periksa` a WHERE a.`iujilab_id` =".$post['iujilab_id'];
		$data['periksa']=$this->dbset->query($sqlfile4)->result_array();

		$return = $this->load->view('uji_lab_histori_detail',$data,TRUE);
		return $return;
	}

	
	public function output(){
		$this->index($this->input->get('action'));
	}

}

