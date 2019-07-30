<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_sediaan_produk extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Sediaan Produk');		
		$grid->setTable('hrd.mnf_sediaan');		
		$grid->setUrl('master_sediaan_produk');
		$grid->addList('vsediaan','itest_udt');
		$grid->setSortBy('vsediaan');
		$grid->setSortOrder('asc');
		$grid->addFields('vsediaan','itest_udt','spesifikasi');
		$grid->setLabel('vsediaan', 'Sediaan');
		$grid->setLabel('itest_udt','Test UDT');
		$grid->setSearch('vsediaan','itest_udt');
		$grid->setRequired('vsediaan','Test UDT');
		$grid->changeFieldType('itest_udt', 'combobox', '', array(1=>'Tidak', 2=>'Ya'));
		$grid->setQuery('ldeleted', 0);
		$grid->setDeletedKey('ldeleted');
		
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function insertBox_master_sediaan_produk_spesifikasi($field, $id) {
		$data=array();
		return $this->load->view('master_sediaan_produk_spesifikasi', $data, TRUE);
	}
	
	function updateBox_master_sediaan_produk_spesifikasi($field, $id, $value, $row) {
		$this->db_plc0->where(array('isediaan_id'=>$row['isediaan_id'],'ldeleted'=>0));
		$this->db_plc0->order_by('iurut', 'asc');
		$data['rows'] = $this->db_plc0->get('plc2.plc2_upb_master_sediaan_spesifikasi_fg')->result_array();
		return $this->load->view('master_sediaan_produk_spesifikasi', $data, TRUE);
	}

	function searchBox_master_sediaan_produk_itest_udt($field, $id) {
		$echo = '<select id="'.$id.'"><option value="">--Select--</option>';
		$echo .= '<option value="1">Tidak</option>';
		$echo .= '<option value="2">Ya</option>';
		$echo .= '</select>';
		return $echo;
	}
	
	function before_insert_processor($row, $postData) {
		unset($postData['vspesifikasi']);
		unset($postData['istabilita']);
		return $postData;
	}
	function after_insert_processor($row, $insertId, $postData) {
		$spek = $postData['vspesifikasi'];
		$parm = $postData['istabilita'];
		$i=1;
		$skrg = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		foreach($spek as $k => $v) {
			$dt['isediaan_id'] = $insertId;
			$dt['iurut'] = $i;
			$dt['vspesifikasi'] = $v;
			$dt['istabilita'] = $parm[$k];
			$dt['tupdate'] = $skrg;
			$dt['cnip'] = $user->gNIP;
			$i++;
			$this->db_plc0->insert('plc2.plc2_upb_master_sediaan_spesifikasi_fg', $dt);
		}
	}

	function before_update_processor($row, $postData) {
		unset($postData['vspesifikasi']);
		unset($postData['istabilita']);
		unset($postData['isediaanspek_id']);
		return $postData;
	}
	function after_update_processor($row, $updateId, $postData) {
		$this->load->helper('search_array');
		$spekDetID = $postData['isediaanspek_id'];
		$spek = $postData['vspesifikasi'];
		$parm = $postData['istabilita'];
		$i=1;
		$skrg = date('Y-m-d H:i:s');
		$user = $this->auth->user();
		$skrg = date('Y-m-d H:i:s');
		$existData = $this->db_plc0->get_where('plc2.plc2_upb_master_sediaan_spesifikasi_fg', array('isediaan_id'=>$updateId, 'ldeleted'=>0))->result_array();
		foreach($existData as $k => $v) {
			if(in_array($v['isediaanspek_id'], $spekDetID)) {
				$this->db_plc0->where('isediaanspek_id', $v['isediaanspek_id']);
				$key = array_search($v['isediaanspek_id'], $spekDetID);
				$this->db_plc0->update('plc2.plc2_upb_master_sediaan_spesifikasi_fg', array('vspesifikasi'=>$spek[$key], 'istabilita'=>$parm[$key], 'cnip'=>$user->gNIP, 'tupdate'=>$skrg));
			}
			else {
				$this->db_plc0->where('isediaanspek_id', $v['isediaanspek_id']);
				$this->db_plc0->update('plc2.plc2_upb_master_sediaan_spesifikasi_fg', array('ldeleted'=>1, 'cnip'=>$user->gNIP, 'tupdate'=>$skrg));
			}
		}
		$this->db_plc0->where(array('isediaan_id'=>$updateId,'ldeleted'=>0));
		$this->db_plc0->order_by('iurut', 'asc');
		$drows = $this->db_plc0->get('plc2.plc2_upb_master_sediaan_spesifikasi_fg')->result_array();
		$ur = 1;
		foreach($drows as $drow) {
			$this->db_plc0->where('isediaanspek_id', $drow['isediaanspek_id']);
			$this->db_plc0->update('plc2.plc2_upb_master_sediaan_spesifikasi_fg', array('iurut'=>$ur));
			$ur++;
		}
		foreach($spek as $k => $v) {
			if(empty($spekDetID[$k])) {
				$dt['isediaan_id'] = $updateId;
				$dt['iurut'] = $ur;
				$dt['vspesifikasi'] = $v;
				$dt['istabilita'] = $parm[$k];
				$dt['tupdate'] = $skrg;
				$dt['cnip'] = $user->gNIP;
				$ur++;
				$this->db_plc0->insert('plc2.plc2_upb_master_sediaan_spesifikasi_fg', $dt);
			}
		}
	}
	
    function output(){
    	$this->index($this->input->get('action'));
    }
}